<?php

namespace App\Livewire;

use App\Actions\Steps\StepsUserRoles;
use App\Models\slaApplication;
use LivewireUI\Modal\ModalComponent;
use App\Models\Customer;
use App\Models\serviceLevelAgreement;
use Livewire\Attributes\Validate;
class CreateSlaApplication extends ModalComponent
{
    public ?Customer $customer;
    public $slas;
    #[Validate('required')]
    public $name = '';
    #[Validate('required')]
    public $short_description = '';
    #[Validate('required')]
    public $service_level_agreement_id = '';
    
    public $priority = 1;
    public $active = true;
    
    public function mount(StepsUserRoles $stepsUserRoles)
    {
        $access = $stepsUserRoles->checkAccess($this);
        $this->canEdit = $access['canEdit'];            
    }

    public function getAllActiveSla()
    {
        $this->slas = serviceLevelAgreement::getAllActiveSla();
    }

    public function save()
    {
        $this->validate();
        $inputs = [
            'name' => $this->name,
            'short_description' => $this->short_description,
            'service_level_agreement_id' => $this->service_level_agreement_id,
            'priority' => $this->priority,  
            'active' => $this->active,
            'customer_id' => $this->customer->id,
        ];
        $slap = slaApplication::create($inputs);
        if($this->customer){
            $this->redirect(route('customerProfile',['customer' => $this->customer]));
        }
    }

    public function render()
    {
        $this->getAllActiveSla();
        return view('livewire.create-sla-application');
    }
}
