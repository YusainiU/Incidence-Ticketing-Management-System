<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\slaTask;

class MainDashboardTicketBreachedWidget extends Component
{

    public int $total = 0;

    public function breachedOpenTickets()
    {
        $n = 0;
        $n = slaTask::where('breached_at','!=',null)
                ->whereRelation('ticket','closed_datetime','=',null)
                ->count();
        $this->total = $n;
    }

    public function render()
    {
        $this->breachedOpenTickets();
        return view('livewire.main-dashboard-ticket-breached-widget');
    }
}
