<?php

namespace App\Livewire;

use App\Actions\Steps\StepsUserRoles;
use LivewireUI\Modal\ModalComponent;
use App\Enums\CustomerPrimaryTypes;
use App\Enums\CustomerChildTypes;
use Livewire\Attributes\Validate;
use App\Models\Customer;

class CreateNewCustomer extends ModalComponent
{

    #[Validate('required')]
    public $name = '';
    #[Validate('required')]
    public $type = '';
    #[Validate('required_if:type,==,child_company')]
    public $child = '';
    public $short_description = '';

    public $options_type = [];
    public $options_child = [];
    public $canEdit = false;

    public static function modalMaxWidth(): string
    {
        return '7xl';
    }

    public function save()
    {
        $this->validate();
        $input = [
            'name' => $this->name,
            'primary_type' => $this->type,            
            'short_description' => $this->short_description,
        ];
        if($this->child)
        {
            $input['child_type'] = $this->child;
        }
        //dd($input);
        $customer = Customer::create($input);
        $this->redirect(route('customerProfile',['customer' => $customer]));
    }
    
    public function mount(StepsUserRoles $stepsUserRoles)
    {
        $access = $stepsUserRoles->checkAccess($this);
        $this->canEdit = $access['canEdit'];          
        $this->options_type = array_column(CustomerPrimaryTypes::cases(),'value');
        $this->options_child = array_column(CustomerChildTypes::cases(),'value');
    }

    public function render()
    {
        return view('livewire.create-new-customer');
    }
}
