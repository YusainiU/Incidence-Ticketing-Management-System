<?php

namespace App\Livewire;

use App\Actions\Steps\StepsUserRoles;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Supplier;
use Livewire\Attributes\Validate;
use LivewireUI\Modal\ModalComponent;
use App\Models\Asset;

class CreateNewAsset extends ModalComponent
{

    public ?Customer $customer;
    public $listOfProducts = [];
    public $listOfSuppliers = [];
    public $listOfCustomers = [];

    #[Validate('required')]
    public $short_description = '';
    #[Validate('required')]
    public $product_id = '';
    #[Validate('required')]
    public $supplier_id = '';
    #[Validate('required')]
    public $customer_id = '';
    public $active = true;
    public $buy_price = 0.00;
    public $sell_price = 0.00;
    public $notes = '';
    public $license_number = '';
    public $location = '';
    public $technical_specifications = '';
    public $mac_address = '';
    public $ip_address = '';
    public $withCompanyId = false;

    public function mount(StepsUserRoles $stepsUserRoles)
    {

        $access = $stepsUserRoles->checkAccess($this);
        $this->canEdit = $access['canEdit'];             

        if ($this->customer->id) {
            $this->customer_id = $this->customer->id;
            $this->withCompanyId = true;
        }
        $this->getProducts();
        $this->getSuppliers();
        $this->getCustomers();
    }

    public function getProducts()
    {
        $arr = Product::select('id', 'name')->get()->sortBy('name')->toArray();
        $this->listOfProducts = array_values($arr);
    }

    public function getSuppliers()
    {
        $arr = Supplier::select('id', 'name')->get()->sortBy('name')->toArray();
        $this->listOfSuppliers = array_values($arr);
    }

    public function getCustomers()
    {
        $arr = Customer::select('id', 'name')->get()->sortBy('name')->toArray();
        $this->listOfCustomers = array_values($arr);
    }

    public function save()
    {
        $this->validate();

        $input = [
            'asset_number' => null,
            'short_description' => $this->short_description,
            'product_id' => $this->product_id,
            'supplier_id' => $this->supplier_id,
            'customer_id' => $this->customer_id,
            'buy_price' => $this->buy_price,
            'sell_price' => $this->sell_price,
            'license_number' => $this->license_number,
            'location' => $this->location,
            'technical_specifications' => $this->technical_specifications,
            'mac_address' => $this->mac_address,
            'ip_address' => $this->ip_address,
            'active' => $this->active,
        ];
        //dd($input);
        $asset = Asset::create($input);
        if($this->customer){
            $this->redirect(route('customerProfile',['customer' => $this->customer]));
        }
    }

    public function render()
    {
        return view('livewire.create-new-asset');
    }
}
