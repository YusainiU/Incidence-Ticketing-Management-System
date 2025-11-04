<?php

namespace App\Livewire;

use App\Actions\Steps\StepsUserRoles;
use Livewire\Component;
use App\Models\serviceLevelAgreement;
use Livewire\WithPagination;
 
class ServiceLevelAgreementList extends Component
{

    use WithPagination;
    public $filter = '';
    public $canEdit = false;

    public function mount(StepsUserRoles $stepsUserRoles)
    {
        $access = $stepsUserRoles->checkAccess($this);
        $this->canEdit = $access['canEdit'];
    }

    public function render()
    {
        $query = serviceLevelAgreement::query();
        $query->where('active','=',true);

        if($this->filter)
        {
            $filterValue = "%{$this->filter}%";
            $query->whereAny(['name','short_description','type'],'like',$filterValue)->get();    
        }        
        return view('livewire.service-level-agreement-list',[
            'slas' => $query->paginate(10, pageName:'sla-list-page'),
        ]);
    }
}
