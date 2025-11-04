<?php

namespace App\Livewire;

use App\Actions\Steps\StepsUserRoles;
use Livewire\Livewire;
use LivewireUI\Modal\ModalComponent;
use App\Models\Product;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Config;

class CreateNewProduct extends ModalComponent
{

    #[Validate('required')]
    public $name = '';
    #[Validate('required')]
    public $product_code = '';
    public $short_description = '';
    #[Validate('required')]
    public $type = '';
    #[Validate('required')]
    public $make = '';
    public $model = '';
    public $version = '';


    public $productTypes = [];
    public $productMakes = [];
    public $title = 'Create New Product';
    public $canEdit = false;

    public function mount(StepsUserRoles $stepsUserRoles)
    {
        $access = $stepsUserRoles->checkAccess($this);
        $this->canEdit = $access['canEdit'];            
        $this->productTypes = Config::get('steps.productTypes');
        $this->productMakes = Config::get('steps.productManufacturer');
    }

    public function save()
    {
        $this->validate();
        $input = [
            'name' => $this->name,
            'product_code' => $this->product_code,
            'model' => $this->model,
            'short_description' => $this->short_description,
            'type' => $this->type,
            'make' => $this->make,
            'varsion' => $this->version,
        ];
        $product = Product::create($input);
        $this->redirect(route('productList',['product' => $product]));        
    }

    public function render()
    {
        return view('livewire.create-new-product');
    }
}
