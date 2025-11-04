<?php

namespace App\Livewire;

use App\Actions\Steps\StepsUserRoles;
use App\Actions\TicketManagement\TicketAdministration;
use App\Models\slaTask;
use App\Models\ticket;
use Livewire\Component;
use Livewire\WithPagination;

class TicketDeletedList extends Component
{

    use WithPagination;

    public $filter = '';
    public $moreOnThis;
    public $slaTask;
    public $showFilter = false;

    public function mount(StepsUserRoles $stepsUserRoles)
    {
        $access = $stepsUserRoles->checkAccess($this);
        $this->canEdit = $access['canEdit'];            
    }
    
    public function updatingFilter()
    {
        $this->resetPage('deleted-ticket-list-page');
    }

    public function showDescription($ticket)
    {
        $t = ticket::withTrashed()->find($ticket["id"]);
        $task = slaTask::withTrashed()->where('ticket_id','=',$t->id)->first();
        $this->moreOnThis = $t;
        $this->slaTask = $task;
        $this->showFilter = !$this->showFilter;
    }
    
    public function restore($ticket)
    {
        $t = ticket::withTrashed()->find($ticket["id"]);
        if($t->restore()){
            TicketAdministration::restoreTicketRelatedRecords($ticket["id"]);
        }
    }

    public function render()
    {

        $query = ticket::query()->onlyTrashed();
        if($this->filter)
        {
            $filterValue = "%{$this->filter}%";
            $query->whereAny(['ticket_number','short_description'],'like',$filterValue);
            /* Note 'customer' is a method in ticket model class */
            $query->orwhereRelation('customer','name','like',$filterValue);
            /* Note 'assignedTo' is a method in ticket model class */
            $query->orwhereRelation('assignedTo','name','like',$filterValue); 
        }
        $query->orderByDesc('deleted_at');
        
        return view('livewire.ticket-deleted-list',[
            'tickets' => $query->paginate(10,pageName:'deleted-ticket-list-page'),
        ]);
    }
}
