<?php

namespace App\Livewire;

use App\Actions\Steps\StepsUserRoles;
use App\Providers\StepsServiceProvider;
use LivewireUI\Modal\ModalComponent;
use Livewire\Attributes\Validate;
use App\Models\User;
use App\Models\Customer;
use App\Enums\UserIdentity;

class EditUserDetails extends ModalComponent
{
    public ?User $userdata;
    public User $user;

    #[Validate('required')]
    public $name = '';
    #[Validate('required|email')]
    public $email = '';
    #[Validate('required')]
    public $phone_number = '';
    public $active = true;
    
    #[Validate('required')]
    public $user_identity='';
    #[Validate('required_if:user_identity,==,customer')]
    public $customer_id='';
    public $customers = [];
    public $user_identity_options = [];
    public $selected_customer_name = '';    

 
    public function mount(StepsUserRoles $stepsUserRoles)
    {
        $access = $stepsUserRoles->checkAccess($this);
        $this->canEdit = $access['canEdit'];
        $this->user = $this->userdata;

        $this->getUserIdent();
        $this->getCustomers();

        $this->name = $this->userdata->name;
        $this->email = $this->userdata->email;
        $this->phone_number = $this->userdata->phone_number;
        $this->active = $this->userdata->active;
        $this->user_identity = $this->userdata->user_identity;
        $this->customer_id = $this->userdata->customer_id;
        if($this->userdata->customer)
        {
            $this->selected_customer_name = $this->userdata->customer->name;
        }

    }

    public function getUserIdent()
    {
        $identityOptions = UserIdentity::cases();
        foreach($identityOptions as $opt){
            $this->user_identity_options[UserIdentity::toDisplayName($opt->value)] = $opt->value;
        }       
    }

    public function getCustomers()
    {
        $c = Customer::select('id','name')->get()->sortBy('name');
        if($c){
            foreach($c as $customer){
                $this->customers[] = ['id' => $customer->id,'name' => $customer->name];
            }
        }

    }    


    public function save()
    {

        $identType = gettype($this->user_identity);
        if($identType == 'object'){
            $identValue = $this->user_identity->toString();
        }else{
            $identValue = $this->user_identity;
        }

        $this->validate();

        if($identValue != 'customer')
        {
            $this->customer_id = null;
        }

        $this->user->update(
            $this->only([
                'name',
                'email',
                'phone_number',
                'active',
                'user_identity',
                'customer_id'
            ])
        );

        return redirect()->route('addNewRoles', ['user' => $this->user]);
        
    }

    public function render()
    {
        return view('livewire.edit-user-details');
    }
}
