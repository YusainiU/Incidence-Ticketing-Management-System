<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use App\Actions\Steps\StepsUserRoles;
use App\Models\Asset;
use App\Models\Customer;
use Livewire\WithPagination;

class CustomerProfileAssets extends Component
{

    use WithPagination;
    public $customer;
    public $filter = '';
    public $canEdit = false;    

    public function updatingFilter()
    {
        $this->resetPage('customer-asset-list-page');
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
        return view('livewire.customer.customer-profile-assets',[
            'assets' => $query->paginate(10, pageName:'customer-asset-list-page'),]);
    }
}
