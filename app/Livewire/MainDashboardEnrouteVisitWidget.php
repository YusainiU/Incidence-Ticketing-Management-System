<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TaskSiteVisit;

class MainDashboardEnrouteVisitWidget extends Component
{
    public int $total = 0;

    public function currentlyEnroute()
    {
        $n = 0;

        $n = TaskSiteVisit::where('onsite_at','=',null)
                ->where('offsite_at','=', null)
                ->where('enroute_at','!=', null)
                ->whereRelation('ticket','closed_datetime','=',null)
                ->count(); 
                
        $this->total = $n;
    }
    public function render()
    {
        $this->currentlyEnroute();
        return view('livewire.main-dashboard-enroute-visit-widget');
    }
}
