<?php

namespace App\Livewire;

use App\Actions\Steps\StepsUserRoles;
use LivewireUI\Modal\ModalComponent;
use App\Models\User;
use App\Enums\CustomerContactRoles;
use Livewire\Attributes\Validate;
use App\Models\CustomerContacts;

class AddCustomerContactToRole extends ModalComponent
{

    public ?User $user;
    public $roles;

    #[Validate("required")]
    public $role;
    public $description;


    public function mount(StepsUserRoles $stepsUserRoles)
    {
        $access = $stepsUserRoles->checkAccess($this);
        $this->canEdit = $access['canEdit'];        
        $this->getRoles();
       
    }

    public function save()
    {
        $this->validate();
        $input = [
            'user_id' => $this->user->id,
            'customerRole' => $this->role,
            'description' => $this->description,
        ];
        $addedRole = CustomerContacts::create($input);
        $this->redirect(route('userProfile',['user' => $this->user]));

    }

    public function getRoles()
    {
        $this->roles = CustomerContactRoles::cases();
    }

    public function render()
    {
        return view('livewire.add-customer-contact-to-role');
    }
}
