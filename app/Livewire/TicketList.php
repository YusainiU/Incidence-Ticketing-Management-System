<?php

namespace App\Livewire;

use App\Actions\Steps\StepsUserRoles;
use App\Models\slaTask;
use App\Models\TaskSiteVisit;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use App\Models\ticket;
use Livewire\WithPagination;
use App\Models\User;
use App\Actions\TicketManagement\TicketAdministration;

class TicketList extends Component
{

    use WithPagination;
    public $roleCanView = 'Ticket Administrator';
    public $filter = '';
    public $selectTicket = '';
    public $showFilter = false;
    public ticket $moreOnThis;
    public slaTask $slaTask;
    public TaskSiteVisit $siteVisits;
    public $reassignment = false;
    public ticket $reassignTicket;
    public $internalUsers;
    public $ticketInfos;
    public $canEdit = false;
    
    public function mount(StepsUserRoles $stepsUserRoles, TicketAdministration $ticketAdministration)
    {
        $access = $stepsUserRoles->checkAccess($this);
        $this->canEdit = $access['canEdit'];
        $this->selectTicket = 'open';
        $this->internalUsers = User::where('active','=',true)
            ->where('user_identity','=','internal')
            ->orderBy('name')->get();
        $ticketAdministration->updateSlaBreachForAllOpenTasks();
    }

    public function changeAssignedTo(ticket $ticket,$value)
    {
        $ticketAdmin = new TicketAdministration;
        if($value) {
            $val = json_decode($value);
            $usr = $this->internalUsers->where('id','=',$val->id)->first();
            $ticketAdmin->setAssignedTo($ticket, $usr);
        }else{
            $ticketAdmin->unassignedUser($ticket);
        }
    }

    public function reassignUser(ticket $ticket)
    {
        $this->reassignTicket = $ticket;
        $this->reassignment = !$this->reassignment;
    }
    public function showDescription(ticket $ticket)
    {
        $this->moreOnThis = $ticket;
        $this->slaTask = $ticket->slaTasks->first();
        $this->showFilter = !$this->showFilter;
    }
    public function getTickets()
    {
        $query = ticket::query();
        $this->ticketInfos = '';

        if($this->selectTicket == 'open')
        {
            $query->where('closed_datetime','=',null);
            $this->getTicketInfo($query);
        }
        if($this->selectTicket == 'resolved')
        {
            $query->where('resolved_datetime','!=',null);
            $query->where('closed_datetime','=',null);
            $this->getTicketInfo($query);
        }
        if($this->selectTicket == 'closed')
        {
            $query->where('closed_datetime','!=',null);
        }        
        if($this->filter)
        {
            $filterValue = "%{$this->filter}%";
            $query->whereAny(['ticket_number','short_description'],'like',$filterValue);
            /* Note 'customer' is a method in ticket model class */
            $query->orwhereRelation('customer','name','like',$filterValue);
            /* Note 'assignedTo' is a method in ticket model class */
            $query->orwhereRelation('assignedTo','name','like',$filterValue);
        }

        $query->orderByDesc('created_at');

        return $query;

    }

    public function getTicketInfo(Builder $query)
    {
        $t = new TicketAdministration;
        $this->ticketInfos = $t->checkStatusForMultipleTickets($query->get());
    }

    public function changeTicketSelection(string $selected)
    {
        $this->selectTicket = $selected;
        $this->render();
    }

    public function deletedTickets()
    {
        $this->redirect('ticketDeletedList');
    }

    public function updatingFilter()
    {
        $this->resetPage('ticket-list-page');
    }    
    public function render()
    {
        $query = $this->getTickets();
        return view('livewire.ticket-list',[
            'tickets' => $query->paginate(10,pageName:'ticket-list-page'),
        ]);
    }
}
