<?php

namespace App\Livewire\Customer;

use App\Actions\Steps\StepsUserRoles;
use App\Models\Customer;
use Livewire\Component;

class CustomerViewProfile extends Component
{

    public $customer_id = '';
    public $customer;
    public $contacts;
    public $tickets;
    public $assets;
    public $selectedTab;
    public $canCreate = true;
    public $displayModal = false;

    public function mount(StepsUserRoles $stepsUserRoles)
    {
        $this->customer_id = $stepsUserRoles->checkCustomer();
        $this->getCustomerDetails();
    }

    public function getCustomerDetails()
    {
        $this->customer = Customer::find($this->customer_id);
        $this->contacts = $this->customer->contacts;
        $this->tickets = $this->customer->tickets;
        $this->assets = $this->customer->assets;
        
    }

   public function showModal(bool $show)
    {
        $this->displayModal = $show;

    }
    
    public function selectTab(string $tab)
    {
        $this->selectedTab = $tab;
    }    

    public function render()
    {
        return view('livewire.customer.customer-view-profile');
    }
}
