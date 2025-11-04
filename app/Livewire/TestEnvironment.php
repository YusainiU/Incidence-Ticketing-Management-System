<?php

namespace App\Livewire;

use App\Actions\Steps\StepsUserRoles;
use Livewire\Component;
use App\Enums\CustomerPrimaryTypes;

class TestEnvironment extends Component
{

    public $isUserAdmin = false;
    public $isSalesManager = false;
    public $customerTypes=[];

    public function mount(StepsUserRoles $stepsUserRoles)
    {
        
        $customerTypes = CustomerPrimaryTypes::cases();
        $this->customerTypes = $customerTypes;
        foreach($customerTypes as $type){
            $customerTypes[$type->value] = $type->name;
        }
        
        $stepsUserRoles->canAccess();
        $this->isSalesManager = $stepsUserRoles->canView('Sales Manager');
        $this->isUserAdmin = $stepsUserRoles->canView('User Administrator');
    }

    public function render()
    {
        return view('livewire.test-environment');
    }
}
