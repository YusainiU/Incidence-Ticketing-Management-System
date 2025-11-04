<?php

namespace App\Livewire;

use App\Actions\Steps\StepsUserRoles;
use App\Enums\CustomerContactRoles;
use Livewire\Component;
use App\Models\User;
use App\Models\Customer;
use App\Models\CustomerContacts;

class CustomerContact extends Component
{
    
    public ?User $user;
    public ?Customer $customer;
    public $roles = [];
    public $canEdit = false;
    public function mount(StepsUserRoles $stepsUserRoles)
    {   
        $access = $stepsUserRoles->checkAccess($this);
        $this->canEdit = $access['canEdit'];               
        $this->customer = Customer::where('id',$this->user->customer_id)->get()->first();
        $this->getRoles();
    }

    public function getRoles()
    {
        $roles = CustomerContacts::where('user_id',$this->user->id)
            ->get()
            ->sortBy('customerRole')
            ->toArray();
        $this->roles = array_values($roles);
    }

    public function removeRole(int $roleId)
    {
        CustomerContacts::where('id',$roleId)->limit(1)->delete();
        $this->redirect(route('userProfile',['user' => $this->user]));
    }

    public function render()
    {
        return view('livewire.customer-contact');
    }
}
