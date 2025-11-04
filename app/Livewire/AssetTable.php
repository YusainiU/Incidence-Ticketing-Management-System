<?php

namespace App\Livewire;

use App\Actions\Steps\StepsUserRoles;
use Livewire\Component;
use App\Models\Asset;
use App\Models\Customer;
use Livewire\WithPagination;

class AssetTable extends Component
{

    use WithPagination;
    public $customer;
    public $filter = '';
    public $canEdit = false;    

    public function mount(StepsUserRoles $stepsUserRoles)
    {
        $access = $stepsUserRoles->checkAccess($this);
        $this->canEdit = $access['canEdit'];        
    }

    public function updatingFilter()
    {
        $this->resetPage('asset-list-page');
    }    
    public function render()
    {
        $query = Asset::query();
        if($this->filter)
        {
            $filterValue = "%{$this->filter}%";
            $query->whereAny(['short_description','asset_number','supplier_id'],'like',$filterValue);    
        }
        $query->where('customer_id','=',$this->customer->id)->get();                  
        return view('livewire.asset-table',[
            'assets' => $query->paginate(10, pageName:'asset-list-page'), 
        ]);
    }
}
