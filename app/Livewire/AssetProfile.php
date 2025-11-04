<?php

namespace App\Livewire;

use App\Actions\Steps\StepsUserRoles;
use Livewire\Component;
use App\Models\Asset;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Customer;

class AssetProfile extends Component
{

    public ?Product $product;
    public ?Supplier $supplier;
    public ?Asset $asset;
    public ?Customer $customer;
    public $suppliers;
    public $updateFlag = '';
    public $canEdit = false;

    public function mount(StepsUserRoles $stepsUserRoles)
    {

        $access = $stepsUserRoles->checkAccess($this);
        $this->canEdit = $access['canEdit'];

        $this->getDetails($this->asset);
        $this->getSupplierList();       
    }

    public function getSupplierList()
    {
        $this->suppliers = Supplier::where('active','=',true)->orderBy('name')->get();
    }
    public function getDetails(Asset $asset)
    {
        $this->product = Asset::getProduct($asset->product_id);
        $this->supplier = Asset::getSupplier($asset->supplier_id);
        $this->customer = Asset::getCustomer($asset->customer_id);
    }
    public function setUpdateFlag(string $flag)
    {
        $this->updateFlag = $flag;
    }
    public function resetFlag()
    {
        $this->updateFlag = '';
    }

    public function updateRecord(string $fieldName, string $fieldValue)
    {
        $checkConfig = [
            'supplier_id'   => 'integer:required',
            'buy_price'     => 'decimal:2',
            'sell_price'    => 'decimal:2',
            'active'        => 'boolean:',
            'license_number' => 'string:',
            'location'      => 'string:',
            'ip_address'    => 'string:',
            'mac_address'   => 'string:',
            'technical_specifications'   => 'string:',
        ];
        $selectedField = $fieldName;
        $hasConfig = $checkConfig[$fieldName];
        if($hasConfig)
        {
            $validated = true;
            $split = explode(":",$hasConfig);
            if($split[0] == 'decimal'){
                $fieldValue = (float) $fieldValue;
            }
            if($split[1] == 'required' && $fieldValue == ''){
                $validated = false;
            }
            if($fieldName == 'active'){
                $fieldValue = !$this->asset->active;
            }
            if($split[0] == 'integer'){
                
                if($fieldName == 'supplier_id'){
                    $a = Asset::getSupplier($fieldValue);
                    $fieldValue = $a->id;
                }else{
                    $fieldValue = (int) $fieldValue;
                }
            }
            if($validated){
                $this->asset->$fieldName = $fieldValue;
                $this->asset->save();
                $this->getDetails($this->asset);
            }
            //$this->redirect(route('assetProfile',['asset' => $this->asset]));
        }

    }

    public function render()
    {
        return view('livewire.asset-profile');
    }
}
