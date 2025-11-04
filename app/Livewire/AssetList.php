<?php

namespace App\Livewire;

use App\Models\Supplier;
use Livewire\WithPagination;
use App\Actions\Steps\StepsUserRoles;
use App\Models\Asset;
use App\Models\Product;
use App\Models\Customer;
use Livewire\Component;

class AssetList extends Component
{

    use WithPagination;
    public $filter = '';
    public $filterByProduct = '';
    public $filterByDescription = '';
    public $filterByCustomer = '';
    public $filterBySupplier = '';
    public $filterByAsset =  '';
    public $productIds = [];
    public $customerIds = [];
    public $supplierIds = [];
    public $triggerFilter = '';
    public $currentFilter = '';
    public $filterActive = '';

    public function mount(StepsUserRoles $stepsUserRoles)
    {
        $access = $stepsUserRoles->checkAccess($this);
    }

    public function getList()
    {
        $query = Asset::query();
        if($this->triggerFilter){ 
            switch($this->triggerFilter){
                case 'product':
                    $query->OrWhereIn('product_id',$this->productIds);
                    break;
                case 'description':
                    $query->OrWhere('short_description','like', "%{$this->currentFilter}%");
                    break;
                case 'customer':
                    $query->orWhereIn('customer_id', $this->customerIds);
                    break;
                case 'supplier':
                    $query->orWhereIn('supplier_id', $this->supplierIds);
                    break;
                case 'asset':
                    $query->orWhere('asset_number','like',"%{$this->currentFilter}%");
                    break;
                case 'active':
                    if($this->currentFilter != 'All'){
                        $act = $this->currentFilter == 'Active' ? true : false; 
                        $query->OrWhere('active','=', $act);
                    }
                    break;
                default:
                    break;
            }                   
        }
        $query->orderBy('short_description')->get();
        return $query;
    }

    public function toggleActive($state)
    {
        $s = 'All';
        if($state == 'active'){
            $s = 'Active';
        }
        if($state == 'notActive'){
            $s = 'Not Active';
        }
        $this->currentFilter = $s;
        $this->resetAllFilters();
        $this->triggerFilter = 'active';
    }

    public function filterProduct()
    {
        $this->currentFilter = $this->filterByProduct;
        $this->resetAllFilters();
        $this->productIds = Product::where('name','like',"%{$this->currentFilter}%")->get()->modelKeys();
        $this->triggerFilter = 'product';        
    }

    public function filterCustomer()
    {
        $this->currentFilter = $this->filterByCustomer;
        $this->resetAllFilters();
        $this->customerIds = Customer::where('name','like',"%{$this->currentFilter}%")->get()->modelKeys();
        $this->triggerFilter = 'customer';        
    }

    public function filterSupplier()
    {
        $this->currentFilter = $this->filterBySupplier;
        $this->resetAllFilters();
        $this->supplierIds =  Supplier::where('name','like',"%{$this->currentFilter}%")->get()->modelKeys();
        $this->triggerFilter = 'supplier';        
    }    

    public function filterDescription()
    {
        $this->currentFilter = $this->filterByDescription;
        $this->resetAllFilters();
        $this->triggerFilter = 'description';
    }

    public function filterAsset()
    {
        $this->currentFilter = $this->filterByAsset;
        $this->resetAllFilters();
        $this->triggerFilter = 'asset';
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function resetAllFilters()
    {
        $this->productIds = [];
        $this->customerIds = [];
        $this->supplierIds = [];
        $this->triggerFilter = '';
        $this->filterByProduct = '';
        $this->filterByDescription = '';
        $this->filterByCustomer = '';
        $this->filterBySupplier = '';
        $this->filterByAsset = '';        
    }
    public function render()
    {
        $query = $this->getList();
        return view('livewire.asset-list',[
            'assets' => $query->paginate(10,['*']),
        ]);
    }
}
