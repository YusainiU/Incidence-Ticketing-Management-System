<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Carbon;
use App\Models\ticket;

class MainDashboardTicketCreatedTodayWidget extends Component
{

    public int $total;

    public function createdToday()
    {
        $today = Carbon::today();
        $this->total = ticket::whereDate('created_at',$today)->count();
    }

    public function render()
    {
        $this->createdToday();
        return view('livewire.main-dashboard-ticket-created-today-widget');
    }
}
