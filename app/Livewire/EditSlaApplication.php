<?php

namespace App\Livewire;

use App\Actions\Steps\StepsUserRoles;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use App\Models\slaApplication;
use App\Models\serviceLevelAgreement;
use Livewire\Attributes\Validate;
use App\Models\Customer;
class EditSlaApplication extends ModalComponent
{
    public slaApplication $slap;
    public $customer;
    public $slas;
    #[Validate('required')]
    public $name = '';
    #[Validate('required')]
    public $short_description = '';
    #[Validate('required')]
    public $service_level_agreement_id = '';
    public $priority = 1;
    public $active = true;
    public $canEdit = false;    

    public function mount(StepsUserRoles $stepsUserRoles)
    {
        $access = $stepsUserRoles->checkAccess($this);
        $this->canEdit = $access['canEdit'];            
        $this->getAllActiveSla();
        $this->setFields();
        $this->getCustomer();
    }

    public function getSlap($id)
    {
        $this->slap = slaApplication::where('id','=',$id)->get()->first();
    }

    public function setFields()
    {
        $this->name = $this->slap->name;
        $this->service_level_agreement_id = $this->slap->service_level_agreement_id;
        $this->short_description = $this->slap->short_description;
        $this->active = $this->slap->active;
    }

    public function getCustomer()
    {
        $this->customer = Customer::find($this->slap->customer_id);
    }

    public function save()
    {
        $this->validate();       
        $this->slap->update(
            $this->only([
                'name',
                'short_description',
                'service_level_agreement_id',
                'active',        
            ])
        );
        $this->redirect(route('customerProfile',['customer' => $this->customer]));        
    }
    public function getAllActiveSla()
    {
        $this->slas = serviceLevelAgreement::getAllActiveSla();
    }    

    public function render()
    {
        return view('livewire.edit-sla-application');
    }
}
