<?php

namespace App\Livewire;

use App\Actions\Steps\StepsUserRoles;
use App\Actions\TicketManagement\TicketAdministration;
use App\Models\taskLogs;
use App\Models\ticket;
use LivewireUI\Modal\ModalComponent;
use App\Exports\taskLogsExport;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Distributions\Exponential;

class ProgressLogTimeline extends ModalComponent
{

     protected $listeners = ['commentResponded' => 'refreshTimeline'];

    public ticket $ticket;
    public $customerName;
    public $taskLogs;
    public $responseComment = '';
    public $openResponse = false;
    public $responseToLog = '';
    public $canEdit = false;
    
    public function mount(StepsUserRoles $stepsUserRoles)
    {
        $access = $stepsUserRoles->checkAccess($this);
        $stepsUserRoles->checkInternalUser();
        $this->canEdit = $access['canEdit'];
        $this->taskLogs = $this->ticket->taskLogs;
        $this->customerName = $this->taskLogs->first()->ticket->customer->name;
    }

    public function exportLogs()
    {
        $n = $this->customerName;
        $n = "Progress Logs - $n.xls";
        $exp = new taskLogsExport($this->ticket);
        return Excel::download($exp, $n);
    }

    public function refreshTimeline()
    {
        $this->taskLogs = taskLogs::where('ticket_id','=',$this->ticket->id)->orderByDesc('created_at')->get();
    }

    public function responseTrigger(taskLogs $taskLog)
    {
        $this->openResponse = !$this->openResponse;
        $this->responseToLog = $this->responseToLog ? '': $taskLog->id;
    }

    public function responseToComment(TicketAdministration $ticketAdministration, taskLogs $taskLog)
    {
        $n = trim($this->responseComment);
        if($n)
        {
            $ticketAdministration->createResponseToExternalComment($taskLog, $this->responseComment);
        }

        $this->responseComment = '';
        $this->responseTrigger($taskLog);
        $this->dispatch('commentResponded');
        
    }
    
    public function render()
    {
        return view('livewire.progress-log-timeline');
    }
}
