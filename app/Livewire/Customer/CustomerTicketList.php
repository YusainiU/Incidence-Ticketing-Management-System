<?php

namespace App\Livewire\Customer;

use App\Actions\Steps\StepsUserRoles;
use App\Models\slaTask;
use App\Models\TaskSiteVisit;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use App\Models\ticket;
use Livewire\WithPagination;
use App\Models\User;
use App\Actions\TicketManagement\TicketAdministration;

class CustomerTicketList extends Component
{
     use WithPagination;
    public $customer_id;
    public $filter = '';
    public $selectTicket = '';
    public $showFilter = false;
    public ticket $moreOnThis;
    public slaTask $slaTask;
    public TaskSiteVisit $siteVisits;
    public $ticketInfos;    
    public function mount(StepsUserRoles $stepsUserRoles, TicketAdministration $ticketAdministration)
    {
        $this->customer_id = $stepsUserRoles->checkCustomer();
        $ticketAdministration->updateSlaBreachForAllOpenTasks();
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
        $query->where('customer_id','=', $this->customer_id);
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
    public function updatingFilter()
    {
        $this->resetPage('customer-ticket-list-page');
    }     
    public function render()
    {
        $query = $this->getTickets();
        return view('livewire.customer.customer-ticket-list', [
            'tickets' => $query->paginate(10,pageName:'customer-ticket-list-page'),
        ]);
    }
}
