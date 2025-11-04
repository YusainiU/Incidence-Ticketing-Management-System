<?php

namespace App\Livewire;

use App\Actions\Steps\StepsUserRoles;
use Livewire\Component;
use App\Models\Supplier;
use Livewire\WithPagination;

class SupplierList extends Component
{

    use WithPagination;

    public $filter = '';
    public $flagNewSupplier=false;
    public ?Supplier $supplier;
    public $canEdit = false;

    public function mount(StepsUserRoles $stepsUserRoles, Supplier $supplier)
    {
        $access = $stepsUserRoles->checkAccess($this);
        $this->canEdit = $access['canEdit'];

        if($supplier->id){
            $this->supplier = $supplier;
            $this->showModal(true);
        }
    }

    public function showModal(bool $flag){
        $this->flagNewSupplier = $flag;
    }
    
    public function openDetails(Supplier $supplier)
    {
        $this->redirect(route('supplierList',['supplier' => $supplier]));
    }    

    public function updatingFilter()
    {
        $this->resetPage('customer-list-page');
    }
    
    public function setActiveStatus(Supplier $supplier)
    {
        $supplier->active = !$supplier->active;
        $supplier->update(
            $supplier->only(['active'])
        );
        $this->resetPage('customer-list-page');
    }

    public function render()
    {

        $query = Supplier::query();
        if($this->filter)
        {
            $filterValue = "%{$this->filter}%";
            $query->whereAny(['name','address_1'],'like',$filterValue)->get();    
        }           
        return view('livewire.supplier-list',[
            'suppliers' => $query->paginate(10, pageName:'supplier-list-page'),            
        ]);
    }
}
