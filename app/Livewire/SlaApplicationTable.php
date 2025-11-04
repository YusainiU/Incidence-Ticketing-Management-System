<?php

namespace App\Livewire;

use App\Actions\Steps\StepsUserRoles;
use Livewire\Component;
use App\Models\slaApplication;
use App\Models\Customer;
use Livewire\WithPagination;
class SlaApplicationTable extends Component
{

    use WithPagination;
    public Customer $customer;
    public $filter = '';
    public $canEdit = false;

    public function mount(StepsUserRoles $stepsUserRoles)
    {
        $access = $stepsUserRoles->checkAccess($this);
        $this->canEdit = $access['canEdit'];
    }

    public function getSlaps()
    {
        $this->slaps = slaApplication::where('customer_id','=',$this->customer->id)
            ->orderBy('name')
            ->get();
    }

    public function updatingFilter()
    {
        $this->resetPage('slap-list-page');
    }    
    public function render()
    {
        $query = slaApplication::query();
        if($this->filter)
        {
            $filterValue = "%{$this->filter}%";
            $query->whereAny(['name','short_description','service_level_agreement_id'],'like',$filterValue);    
        }
        $query->where('customer_id','=',$this->customer->id)->get();          

        return view('livewire.sla-application-table',[
            'slaps' => $query->paginate(10, pageName:'slap-list-page'), 
        ]);
    }
}
