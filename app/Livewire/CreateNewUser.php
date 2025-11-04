<?php

namespace App\Livewire;

use App\Actions\Fortify\StepsCreateNewUser;
use App\Actions\Steps\StepsUserRoles;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Title;
use App\Models\User;
use App\Enums\UserIdentity;
use App\Models\Customer;

#[Title('Create New user')]
class CreateNewUser extends ModalComponent
{

    public ?User $user;

    #[Validate('required')]
    public $name = '';
    #[Validate('required')]
    public $firstName = '';
    #[Validate('required')]
    public $lastName = '';        
    #[Validate('required|email')]
    public $email = '';
    #[Validate('required')]
    public $phone_number = '';
    public $active = true;
    #[Validate('required')]
    #[Validate('min:8', message: 'Minimum 8 characters')]
    public $password = '';

    #[Validate('required')]
    #[Validate('min:8', message: 'Minimum 8 characters')]
    public $confirm_password = '';
    
    #[Validate('required')]
    public $user_identity='';
    #[Validate('required_if:user_identity,==,customer')]
    public $customer_id='';
    public $customers = [];
    public $user_identity_options = [];

    public function mount(StepsUserRoles $stepsUserRoles)
    {
        $access = $stepsUserRoles->checkAccess($this);
        $this->canEdit = $access['canEdit'];            
        $this->getUserIdent();
        $this->getCustomers();
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
        
    public function createUser()
    {
        $this->validate();

        if($this->password !== $this->confirm_password)
        {
            $this->addError('confirm_password_error', 'Passwords are not the same');
        }else{

            $input = [
                'name' => $this->name,
                'first_name' => $this->firstName,
                'last_name' => $this->lastName,
                'phone_number' => $this->phone_number,
                'email' => $this->email,
                'active' => $this->active,
                'password' => $this->password,
            ];

            if($this->user_identity)
            {
                $input['user_identity'] = $this->user_identity;
                if($this->user_identity == 'customer')
                {
                    $input['customer_id'] = $this->customer_id;
                }else{
                    $input['customer_id'] = null;
                }
            }

            $steps = app()->make(StepsCreateNewUser::class);
            $steps->create($input);
            $this->redirect('/dashboard', navigate: true);
        }
    }

    public function render()
    {
        return view('livewire.create-new-user');
    }
}
