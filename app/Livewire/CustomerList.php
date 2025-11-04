<?php

namespace App\Livewire;

use App\Actions\Steps\StepsUserRoles;
use Livewire\Component;
use App\Models\Customer;
use Livewire\WithPagination;
use App\Enums\CustomerPrimaryTypes;

class CustomerList extends Component
{

    use WithPagination;

    public $filter = '';
    public $canEdit = false; 

    public function mount(StepsUserRoles $stepsUserRoles)
    {
        $access = $stepsUserRoles->checkAccess($this);
        $canEdit = $access['canEdit'];
    }

    public function updatingFilter()
    {
        $this->resetPage('customer-list-page');
    }    

    public function render()
    {
        $query = Customer::query();

        if($this->filter)
        {
            $filterValue = "%{$this->filter}%";
            $query->whereAny(['name','short_description','primary_type',],'like',$filterValue);
    
        }
        
        $query->orderBy('name')->get();        

        return view('livewire.customer-list', [
            'customers' => $query->paginate(10, pageName:'customer-list-page'),
        ]);
    }
}
