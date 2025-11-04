<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TaskSiteVisit;
class MainDashboardOnsiteWidget extends Component
{

    public int $total = 0;

    public function currentlyEnroute()
    {
        $n = 0;

        $n = TaskSiteVisit::where('enroute_at','!=', null)
                ->where('offsite_at','=', null)
                ->where('onsite_at',"!=", null)
                ->whereRelation('ticket','closed_datetime','=', null)
                ->count();

        $this->total = $n;
    }
    public function render()
    {
        $this->currentlyEnroute();
        return view('livewire.main-dashboard-onsite-widget');
    }
}
