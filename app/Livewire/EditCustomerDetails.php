<?php

namespace App\Livewire;

use App\Actions\Steps\StepsUserRoles;
use App\Models\Customer;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use App\Enums\CustomerChildTypes;
use App\Enums\CustomerPrimaryTypes;
use Livewire\Attributes\Validate;

class EditCustomerDetails extends ModalComponent
{

    public ?Customer $customer;

    #[Validate('required')]
    public $name = '';
    public $short_description = '';
    #[Validate('required')]
    public $primary_type = '';
    #[Validate('required_if:primary_type,==,child_company')]
    public $child_type = '';
    #[Validate('required')]
    public $address_1 = '';
    public $address_2 = '';
    public $address_3 = '';
    public $telephone_1 = '';
    public $url = '';
    #[Validate('required_if:primary_type,==,child_company')]
    public $parent_company;
    public $options_type = [];
    public $options_child = [];
    public $customers = [];
    public $active = true; 
    public $canEdit = false;
    public $portal_enabled = false;

    public function mount(StepsUserRoles $stepsUserRoles)
    {
        $access = $stepsUserRoles->checkAccess($this);
        $this->canEdit = $access['canEdit'];           
        $customer = $this->customer;
        $this->name = $customer->name;
        $this->short_description = $customer->short_description;
        $this->primary_type = $customer->primary_type->toString();
        $this->address_1 = $customer->address_1;
        $this->address_2 = $customer->address_2;
        $this->address_3 = $customer->address_3;
        $this->telephone_1 = $customer->telephone_1;
        $this->url = $customer->url;
        $this->active = $customer->active;
        $this->portal_enabled = $customer->portal_enabled;
        if($customer->child_type){
            $this->child_type = $customer->child_type->toString();
        }
        if($customer->parent_company){
            $this->parent_company = $customer->parent_company;
        }
        $this->options_type = array_column(CustomerPrimaryTypes::cases(),'value');
        $this->options_child = array_column(CustomerChildTypes::cases(),'value');
        $this->getCustomers();        
    }

    public static function modalMaxWidth(): string
    {
        return '7xl';
    }

    public function getCustomers()
    {
        $arr = Customer::select('id','name')->get()->sortBy('name')->toArray();
        $this->customers = array_values($arr);
    }
    
    public function save()
    {
        $this->validate();
        $update = [
            'name',
            'short_description',
            'address_1',
            'address_2',
            'address_3',
            'url',
            'telephone_1',
            'primary_type',
            'portal_enabled',
        ];
        if($this->primary_type == 'child_company'){
            $update[] = "child_type";
            $update[] = "parent_company";
        }        
        $this->customer->update( $this->only($update));
        $this->redirect(route('customerProfile',['customer' => $this->customer]));
    }

    public function render()
    {
        return view('livewire.edit-customer-details');
    }
}
