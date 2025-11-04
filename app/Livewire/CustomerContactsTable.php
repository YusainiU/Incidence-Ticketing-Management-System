<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Customer;
use App\Models\CustomerContacts;
use App\Models\User;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class CustomerContactsTable extends Component
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
        $this->resetPage('customer-contacts-table-page');
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
        return view('livewire.customer-contacts-table',[
            'contacts' => $query->paginate(10, pageName:'customer-contacts-table-page'),
        ]);
    }
}
