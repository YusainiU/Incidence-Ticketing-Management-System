<?php

namespace App\Livewire;

use App\Actions\Steps\StepsUserRoles;
use App\Models\User;
use App\Models\Roles;
use LivewireUI\Modal\ModalComponent;

class AddUserToRole extends ModalComponent
{
    public ?User $user;
    public ?Roles $allRoles;
    public $multi = [];
    public $selected = [];
    public $canEdit = false;
    public $isSuperAdmin = false;
    
    /**
    * Supported: 'sm', 'md', 'lg', 'xl', '2xl', '3xl', '4xl', '5xl', '6xl', '7xl'
    */    
    public static function modalMaxWidth(): string
    {
        return '2xl';
    }    

    public function mount(StepsUserRoles $stepsUserRoles)
    {
        $access = $stepsUserRoles->checkAccess($this);
        $this->canEdit = $access['canEdit'];
        $this->isSuperAdmin = $access['isSuperAdmin'];        
        $allActiveRoles = Roles::where('active','=', true)->get();
        $already_added = [];
        $roles = $this->user->roles;
        if ($roles) {
            foreach ($roles as $role) 
            {
                $already_added[] = $role->roles_id;
            }
        }
        
        if($allActiveRoles){
            foreach($allActiveRoles as $active)
            {
                if(!in_array($active->id, $already_added))
                {
                    if(!$this->isSuperAdmin && $active->name == 'Super Administrator'){
                        continue;
                    }
                    $this->multi[] = ['name' => $active->name, 'id' => $active->id];       
                }
            }
        }   
    }

    public function render()
    {
        return view('livewire.add-user-to-role');
    }
}
