<?php

namespace App\Livewire;

use App\Models\taskLogs;
use Livewire\Component;

class MainDashboardUnrespondedComment extends Component
{

    public int $total = 0;

    public function unrespondedExternalComments()
    {
        $n = 0;
        $n = taskLogs::where('source','=','external')
            ->where('response_to_external_comment','=',null)
            ->whereRelation('ticket','closed_datetime','=',null)
            ->count();
        $this->total = $n;   
    }
    public function render()
    {
        $this->unrespondedExternalComments();
        return view('livewire.main-dashboard-unresponded-comment');
    }
}
