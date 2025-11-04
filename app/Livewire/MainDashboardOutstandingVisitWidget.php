<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TaskSiteVisit;

class MainDashboardOutstandingVisitWidget extends Component
{
    public int $total = 0;

    public function outstandingSiteVisit()
    {
        
        $n = 0;
        $n = TaskSiteVisit::where('onsite_at','=', null)
                ->where('offsite_at','=',null)
                ->whereRelation('ticket','closed_datetime','=', null)
                ->count();        
        $this->total = $n;
                       
    }
    public function render()
    {
        $this->outstandingSiteVisit();
        return view('livewire.main-dashboard-outstanding-visit-widget');
    }
}
