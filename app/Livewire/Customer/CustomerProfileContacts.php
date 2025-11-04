<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use App\Models\Customer;
use App\Models\User;
use Livewire\WithPagination;

class CustomerProfileContacts extends Component
{

    use WithPagination;
    public $customer;
    public $filter = '';  
    public function mount(Customer $customer)
    {
        $this->customer = $customer;
    }
    public function updatingFilter()
    {
        $this->resetPage('customer-profile-contacts-page');
    }       
    public function render()
    {
        $query = User::query();
        $query->where('customer_id','=',$this->customer->id);
        if($this->filter)
        {
            $filterValue = "%{$this->filter}%";
            $query->whereAny(['name','email','first_name','last_name'],'like',$filterValue);    
        }         
        return view('livewire.customer.customer-profile-contacts',[
            'contacts' => $query->paginate(10, pageName:'customer-profile-contacts-page'),
        ]);
    }
}
