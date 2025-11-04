<?php

namespace App\Livewire;

use App\Models\slaTask;
use Livewire\Component;
use Illuminate\Support\Carbon;

class MainDashboardToRespondTodayWidget extends Component
{

    public $total;

    public function createdToday()
    {
        $today = Carbon::today();
        $this->total = slaTask::whereRelation('ticket','closed_datetime','=',null)
        ->whereDate('respond_by','=',$today)->count();

    }
    public function render()
    {
        $this->createdToday();
        return view('livewire.main-dashboard-to-respond-today-widget');
    }
}
