<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ticket;

class MainDashboardOpenTicketWidget extends Component
{

    public int $total;
    public function openTickets()
    {
        $this->total = ticket::where('closed_datetime','=',null)->count();
    }
    public function render()
    {

        $this->openTickets();

        return view('livewire.main-dashboard-open-ticket-widget');
    }
}
