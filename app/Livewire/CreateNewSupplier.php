<?php

namespace App\Livewire;

use App\Actions\Steps\StepsUserRoles;
use Livewire\Component;
use App\Models\Supplier;
use Livewire\Attributes\Validate;
use LivewireUI\Modal\ModalComponent;

class CreateNewSupplier extends ModalComponent
{

    #[Validate('required')]
    public $name = '';
    #[Validate('required')]
    public $address_1 = '';
    public $address_2 = '';
    public $address_3 = '';
    public $address_4 = '';
    #[Validate('required')]
    public $telephone = '';
    #[Validate('nullable|email')]
    public $email = '';
    #[Validate('nullable|url')]
    public $url = '';
    public $active = true;
    public $canEdit = false;

    public function mount(StepsUserRoles $stepsUserRoles)
    {
        $access = $stepsUserRoles->checkAccess($this);
        $this->canEdit = $access['canEdit'];             
    }

    public function save()
    {
        $this->validate();
        $input = [
            'name' => $this->name,
            'address_1' => $this->address_1,
            'address_2' => $this->address_2,
            'address_3' => $this->address_3,
            'address_4' => $this->address_4,
            'telephone' => $this->telephone,
            'email' => $this->email,
            'url' => $this->url,
            'active' => $this->active,
        ];
        $supplier = Supplier::create($input);
        $this->redirect(route('supplierList',['supplier' => $supplier]));
    }

    public function render()
    {
        return view('livewire.create-new-supplier');
    }
}
