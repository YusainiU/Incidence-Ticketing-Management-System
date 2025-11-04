<?php

namespace App\Livewire\Admin;

use App\Actions\Steps\StepsUserRoles;
use Livewire\Component;
use App\Models\Roles;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Route;

class RolesAdmin extends Component
{

    public $canEdit = false;
    public $isSuperAdmin = false;
    public $isAdmin = false;
    public $routes = [];
    public $displayNameColumn = '';
    public $displayDescriptionColumn = '';
    public $displayAccessColumn = '';
    public $showMore = '';
    
    public function mount(StepsUserRoles $stepsUserRoles)
    {
        $access = $stepsUserRoles->checkAccess($this);
        $this->canEdit = $access['canEdit'];
        $this->isSuperAdmin = $access['isSuperAdmin'];
        $this->isAdmin = $access['isAdmin'];
        if (!sizeof($this->routes)) {
            $this->prepareRoutes();
        }
    }

    public function prepareRoutes()
    {
        $allRoutes = Route::getRoutes();
        $routeNames = $allRoutes->getRoutesByName();
        $this->routes = array_keys($routeNames);
    }

    public function expandMore($key)
    {
        $this->showMore = $key == 'close' ? '':$key;
    }

    public function getRoles()
    {
        $roles = Roles::query();
        return $roles->get();
    }

    public function changeName(Roles $role, string $newName)
    {
        if(trim($newName)){
            $role->name = $newName;
            $role->update(
                $role->only(['name'])
            );
            return to_route('adminDashboard',['openContent' => 'rolesAdmin']);
        }
    }

    public function changeRoleStatus(Roles $role)
    {
        $role->active = !$role->active;
        $role->update(
            $role->only(['active'])
        );
        return to_route('adminDashboard',['openContent' => 'rolesAdmin']);
    }

    public function changeDescription(Roles $role, string $newDesription)
    {
        if(trim($newDesription))
        {
            $role->description = $newDesription;
            $role->update(
                $role->only(['description'])
            );
            return to_route('adminDashboard',['openContent' => 'rolesAdmin']);                 
        }
    }    
    
    public function removeRoute(Roles $role, string $routeName)
    {
        $current = $role->allowed_routes;
        $edit = $role->allow_edit;
        $data = [];
        if($current){
            $e = explode(",",$current);
            $key = array_search($routeName, $e);
            unset($e[$key]);
            $new = '';
            if(sizeof($e)){
                $new = implode(",", $e);
            }
            $data['allowed_routes'] = $new;            
        }
        if($edit)
        {
            $d = explode(",",$edit);
            $dkey = array_search($routeName,$d);
            if($dkey)
            {
                unset($d[$dkey]);
                $newE = '';
                if(sizeof($d))
                {
                    $newE = implode(",",$d);
                }
                $data['allow_edit'] = $newE;
            }
        }
        if(count($data))
        {
            Roles::where('id', $role->id)->update($data);            
        }
        return to_route('adminDashboard',['openContent' => 'rolesAdmin']);
    }
    

    public function showNameField(Roles $role)
    {
        $this->displayNameColumn = $role->id;
    }
    
    public function showDescriptionField(Roles $role)
    {
        $this->displayDescriptionColumn = $role->id;
    }    
    
    public function resetFields()
    {
        $this->displayNameColumn = '';
        $this->displayDescriptionColumn = '';
        $this->displayAccessColumn = '';       
    }    

    public function render()
    {
        $roles = $this->getRoles();
        return view('livewire.admin.roles-admin',[
            'roles' => $roles,
        ]);
    }
}
