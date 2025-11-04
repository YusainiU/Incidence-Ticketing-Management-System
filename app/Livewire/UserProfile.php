<?php

namespace App\Livewire;

use App\Actions\Steps\StepsUserRoles;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use App\Models\User;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Customer;

#[Title("User Profile")]
class UserProfile extends Component
{

    use WithFileUploads;

    public ?User $user;
    public $roles;
    public $photo;
    #[Validate('nullable|image|max:1024')]
    public $profile_photo_path = '';
    public $isUserAdmin = false;
    public $isInternalUser = false;
    public $profileIsSuperAdmin = false;
    public $profileIsAdmin = false;
    public $isSuperAdmin = false;
    public $isAdmin = false;
    public $isCustomer = false;
    public $customerName = '';
    public $userIdentity = '';
    public $customer;
    public $canEdit = false;
    public $canResetPassword = false;

    public function mount(StepsUserRoles $stepsUserRoles)
    {
        $access = $stepsUserRoles->checkAccess($this);
        $this->canEdit = $access['canEdit'];
        $this->isSuperAdmin = $access['isSuperAdmin'];
        $this->isAdmin = $access['isAdmin'];
        $this->roles = $this->user->roles;

        if(Auth()->user()->id == $this->user->id){
            $this->canResetPassword = true;
        }
        
        if($this->canEdit){
            $this->canResetPassword = true;
        }
    
        if($this->user->customer_id)
        {
            $this->customer = Customer::find($this->user->customer_id);
            $this->customerName = $this->customer->name;
            $this->isCustomer = true;
        }else{
            $this->isInternalUser = true;
        }
        $this->profileIdentity();        
    }

    public function profileIdentity()
    {
        $r = $this->user->roles;
        $arr = [];
        foreach($r as $ro){
            $arr[] = $ro->getRoles->name;
        }
        if(in_array('Super Administrator', $arr)){
            $this->profileIsSuperAdmin = true;
        }
        if(in_array('Administrator', $arr)){
            $this->profileIsAdmin = true;
        }        
    }

    public function removePhoto()
    {
        $to_remove = $this->user->profile_photo_path;
        //Storage::disk('public')->path($this->user->profile_photo_path);
        $this->user->profile_photo_path = '';
        $this->user->update(
            $this->only([
                'profile_photo_path',
            ])
        );
        Storage::disk('public')->delete($to_remove);
        return redirect()->route('userProfile', ['user' => $this->user->id]);

    }

    public function photoUpdate()
    {
        $this->validate();
        if ($this->photo) {
            $this->user->profile_photo_path = $this->photo->storePublicly('profile_photo', ['disk' => 'public']);
            $this->user->update(
                $this->only([
                    'profile_photo_path',
                ])
            );
            return redirect()->route('userProfile', ['user' => $this->user->id]);
        }
    }

    public function addUserRoles(StepsUserRoles $stepsUserRoles, Request $request, User $user)
    {

        $this->user = $user;
        $strselected = $request->selected_value;
        if ($strselected) {
            $selected = explode(',', $strselected);
            $stepsUserRoles->AddNewRole($user, $selected);
        }
        return redirect()->route('userProfile', ['user' => $this->user->id]);
    }

    public function removeUserRole(StepsUserRoles $stepsUserRoles, $roleId)
    {
        $stepsUserRoles->RemoveUserRoles($this->user, $roleId);
        return redirect()->route('userProfile', ['user' => $this->user->id]);
    }

    public function render()
    {
        return view('livewire.user-profile');
    }
}
