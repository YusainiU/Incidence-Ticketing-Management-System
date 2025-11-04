<?php

namespace App\Actions\Steps;

use App\Models\User;
use App\Models\UserToRoles;
use App\Models\Roles;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use App\Models\Customer;
use LivewireFilemanager\Filemanager\Models\Folder;
use Illuminate\Support\Str;

class StepsUserRoles
{

    public function AddNewRole(User $user, $roles)
    {
        $now = Carbon::now('utc')->toDateTimeString();
        $records = [];
        foreach ($roles as $role) {
            $records[] = [
                'user_id' => $user->id,
                'roles_id' => $role,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        UserToRoles::insert(
            $records
        );

    }

    public static function checkCustomerUserHasPortalAccess()
    {
        $userId = Auth()->id();
        $u = user::where('id', $userId)->where('user_identity', 'customer')->first();
        if($u){
            $access = $u->customer->portal_enabled;
            return $access ? true : false;
        }
        return false;        
    }

    public static function CreateUserIdentitySession()
    {
        $userId = Auth()->id();
        $u = user::where('id', $userId)->where('user_identity','=', 'customer')->first();
        session()->put('isCustomer', 'false');
        session()->put('isInternal', 'false');
        session()->put('customerSiteId', null);
        session()->put('roles', null);
        session()->put('customerName', Null);
        if ($u && $u->customer_id) {
            //Lock to Customer Session
            $customer = Customer::find($u->customer_id);
            session()->put('isCustomer', 'true');
            session()->put('customerSiteId', $u->customer_id);
            session()->put('customerName', $customer->name);
        } else {
            //Add Roles
            session()->put('isInternal', 'true');
            $s = new self();
            $r = $s->getUserRoles($userId);
            if (count($r)) {
                session()->put('roles', $r);
                $isSuperAdmin = false;
                $isAdmin = false;
                if(in_array('Super Administrator', $r)){
                    $isSuperAdmin = true;
                }
                if(in_array('Administrator',$r)){
                    $isAdmin = true;
                }
                session()->put('isSuperAdmin', $isSuperAdmin);
                session()->put('isAdmin', $isAdmin);
            }
        }
    }

    public static function removeIdentitySession()
    {
        session()->forget('customerSiteId');
        session()->forget('roles');
        session()->forget('isCustomer');
        session()->forget('isInternal');
        session()->forget('customerName');
        session()->forget('isSuperAdmin');
        session()->forget('isAdmin');
    }

    public function checkInternalUser()
    {
        if(session('isInternal') == 'false')
        {
            return redirect('/')->with('error', 'You are not authorized to access this page.');
        }
    }

    public function checkCustomer()
    {
        $id = session('customerSiteId');
        if(!$id) {
            return redirect('/')->with('error', 'You are not authorized to access this page.');
        }
        return $id;
    }

    public function  checkCustomerFolder(Customer $customer)
    {
        $folder = Folder::where('customer_id','=', $customer->id)->first();
        if($folder){
            return $folder;
        }
        return false;
    }

    public function createCustomerFolder(Customer $customer)
    {
        $folderName = trim($customer->name);
        $slug = Str::slug($folderName);
        $data = [
            'name' => $folderName,
            'slug' => $slug,
            'parent_id' => 1,            
        ];
        $folder = Folder::create($data);
        $folder->customer_id = $customer->id;
        $folder->save();
        return $folder;
    }

    public function checkClassName(object $classToChck)
    {
        $e = get_class($classToChck);
        $n = explode('\\',$e);
        $className = lcfirst(end($n));
        return $className;
    }

    public function isSuperAdmin()
    {
        $roles = session('roles');
        $super = Roles::where('name','=','Super Administrator')->first();
        if($roles && is_array($roles) && $super && in_array($super->name, $roles))
        {
            return true;
        }
        return false;
    }

    public function isAdmin()
    {
        $roles = session('roles');
        $admin = Roles::where('name','='.'Administrator')->first();
        if($roles && is_array($roles) && $admin && in_array($admin->name, $roles))
        {
            return true;
        }
        return false;        
    }

    public function checkAccess($checkClass=null)
    {
        $canView = false;
        $canEdit = false;
        $access = $this->identifyMe();
        $isSuperAdmin = $this->isSuperAdmin();
        $isAdmin = $this->isAdmin();
        $roles = session('roles');
        $access['roles'] = $roles;
        $routeName = Route::currentRouteName();
        $access["route"] = $routeName;
        if($checkClass)
        {
            $routeName = $this->checkClassName($checkClass);
            $access["route"] = $routeName;
        }

        $canAccess = $this->UserCanAccessRoute($routeName);

        if(!$canAccess)
        {
            redirect()->route('dashboard');

        }
        if($roles)
        {
            foreach($roles as $role)
            {
                if($this->canView($role))
                {
                    $canView = true;
                }
                if($this->canEdit($role, $routeName))
                {
                    $canEdit = true;
                }
            }
        }
        $access['canView'] = $canView;
        $access['canEdit'] = $canEdit;
        $access['isSuperAdmin'] = $isSuperAdmin;
        $access['isAdmin'] = $isAdmin;
        return $access;
    }

    public function identifyMe()
    {
        $me['identity'] = 'internal';
        if(session('isCustomer') == 'true'){
            $cid = session('customerSiteId');
            $me['customerName'] = session('customerName');
            $me['identity'] = 'customer';
            $me['customerId'] = $cid;
        }
        return $me;
    }    


    public function RemoveUserRoles(User $user, int $id)
    {
        UserToRoles::where('id', $id)->delete();
    }

    public function CurrentUserHasRole(string $roleName)
    {
        $currUserId = auth()->id();
        $role = Roles::where([
            'name' => $roleName,
            'active' => true,
        ])->get()->first();
        if ($role && $role->name) {
            $c = UserToRoles::where([
                'user_id' => $currUserId,
                'roles_id' => $role->id,
            ])->get()->first();
            if ($c) {
                return true;
            }
        }
        return false;
    }

    public function canView($roleName)
    {
        $hasRole = $this->CurrentUserHasRole($roleName);
        if ($hasRole) {
            return true;
        }
        return false;
    }

    public function canEdit($roleName, $routeName)
    {
        $r = Roles::select(['allow_edit'])->where('name','=',$roleName)->first();
        if($r->allow_edit)
        {
            $e = explode(',',$r->allow_edit);            
            if(in_array($routeName,$e))
            {
                return true;
            }            
        }
        return false;
    }

    public function canAccess()
    {
        $hasAccess = $this->UserCanAccessRoute(null);
        if ($hasAccess) {
            return true;
        } else {
            abort(403);
        }
    }

    public function getUserRoles(int $userId)
    {
        $r = [];
        $roles = UserToRoles::where('user_id', $userId)->get();
        $t= []; 
        if ($roles) {
            foreach ($roles as $role) {
                $ro = $role->getRoleName($role->roles_id);
                $t[] = $role->id;
                if($ro) {
                    $r[] = $ro->name;
                }
            }
        }
        return $r;
    }

    public function UserCanAccessRoute(?string $routeName)
    {
        if(!$routeName)
        {
            $routeName = Route::currentRouteName();
        }
        $currUserId = auth()->id();
        $roles = UserToRoles::where('user_id', $currUserId)->get();
        if ($roles) {
            $r = [];
            foreach ($roles as $role) {
                $ro = $role->getRoleName($role->roles_id);
                if ($ro) {
                    if ($ro->allowed_routes) {
                        $r[] = $ro->allowed_routes;
                    }
                }
            }
            if (sizeof($r)) {
                $access = array_unique(explode(",", implode(",", $r)));
                if (in_array($routeName, $access)) {
                    return true;
                }
            }
        }
        return false;
    }

    public function UserHasAccessToProfile(User $user)
    {
        $currUserId = auth()
        ->id();
        if ($user->id === $currUserId) {
            return true;
        } else {
            return false;
        }
    }



}
