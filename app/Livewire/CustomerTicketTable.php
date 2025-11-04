<?php

namespace App\Livewire;

use App\Models\Customer;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ticket;
use App\Actions\TicketManagement\TicketAdministration;
class CustomerTicketTable extends Component
{

    use WithPagination;
    public Customer $customer; 
    public $filter = '';

    public function mount(TicketAdministration $ticketAdministration)
    {
        $tickets = $this->customer->tickets->where('closed_datetime', '=', null);
        if($tickets){
            foreach($tickets as $ticket)
            {
                $ticketAdministration->updateSlaBreachForOpenTicket($ticket);
            }
        }
    }

    public function updatingFilter()
    {
        $this->resetPage('customer-ticket-table-page');
    }   

    public function render()
    {

        $query = ticket::query();

        $query->where('customer_id','=',$this->customer->id)->where('closed_datetime','=', null);

        if($this->filter)
        {
            $filterValue = "%{$this->filter}%";
            $query->whereAny(['ticket_number','short_description','customer_reference'],'like',$filterValue);    
        }
    
        $tickets = $query->paginate(10, pageName:'customer-ticket-table-page');

        return view('livewire.customer-ticket-table',[
            'tickets' => $tickets,
        ]);        
        
    }
}
