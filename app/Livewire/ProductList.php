<?php

namespace App\Livewire;

use App\Actions\Steps\StepsUserRoles;
use Livewire\Component;
use App\Models\Product;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Config; 

class ProductList extends Component
{

    use WithPagination;

    public ?Product $product;

    public $filter = '';
    public $displayNameColumn = '';
    public $displayProductCodeColumn = '';
    public $displayDescriptionColumn = '';
    public $displayTypeColumn = '';
    public $displayMakeColumn = '';
    public $productTypes = [];
    public $manufacturers = [];
    public $flagNewProduct = false;
    public $canEdit = false;

    public function mount(StepsUserRoles $stepsUserRoles, Product $product)
    {

        $access = $stepsUserRoles->checkAccess($this);
        $this->canEdit = $access['canEdit'];
        $this->productTypes = Config::get('steps.productTypes');
        $this->manufacturers = Config::get('steps.productManufacturer');
        if($product->id){
            $this->showModal(true);
        }

    }

    public function showModal(bool $flag){
        $this->flagNewProduct = $flag;
    }

    public function openDetails(Product $product)
    {
        $this->redirect(route('productList',['product' => $product]));
    }

    public function changeName(Product $product, string $name)
    {   
        if(trim($name)){
            $product->name = $name;
            $product->update(
                $product->only(['name'])
            );
            $this->redirect('/dashboard/productList', navigate:true);
        }

    }

    public function changeProductCode(Product $product, string $productCode)
    {
        if(trim($productCode)){
            $product->product_code = $productCode;
            $product->update(
                $product->only(['product_code'])
            );
            $this->redirect('/dashboard/productList', navigate:true);
        }
    }

    public function changeDescription(Product $product, string $description)
    {
        if(trim($description)){
            $product->short_description = $description;
            $product->update(
                $product->only(['short_description'])
            );
            $this->redirect('/dashboard/productList', navigate:true);
        }
    }
    
    public function changeType(Product $product, string $type)
    {
        if(trim($type)){
            $product->type = $type;
            $product->update(
                $product->only(['type'])
            );
            $this->redirect('/dashboard/productList', navigate:true);
        }
    }

    public function changeMake(Product $product, string $make)
    {
        if(trim($make)){
            $product->make = $make;
            $product->update(
                $product->only(['make'])
            );
            $this->redirect('/dashboard/productList', navigate:true);
        }
    }    

    public function resetFields()
    {
        $this->displayNameColumn = '';
        $this->displayProductCodeColumn = '';
        $this->displayDescriptionColumn = '';
        $this->displayTypeColumn = '';
        $this->displayMakeColumn = '';       
    }
    
    public function showNameField(Product $product)
    {
        $this->displayNameColumn = $product->id;
    }

    public function showProductCodeField(Product $product)
    {
        $this->displayProductCodeColumn = $product->id;
    }    
    
    public function showDescriptionField(Product $product)
    {
        $this->displayDescriptionColumn = $product->id;
    }

    public function showTypeField(Product $product)
    {
        $this->displayTypeColumn = $product->id;
    }

    public function showMakeField(Product $product)
    {
        $this->displayMakeColumn = $product->id;
    }    
    
    public function render()
    {

        $query = Product::query();

        if($this->filter)
        {
            $filterValue = "%{$this->filter}%";
            $query->whereAny(['name','short_description','type','make'],'like',$filterValue)->get();    
        }
          
        return view('livewire.product-list', [
            'products' => $query->paginate(10, pageName:'product-list-page'),
        ]);
    }
}
