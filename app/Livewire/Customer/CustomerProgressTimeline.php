<?php

namespace App\Livewire\Customer;

use App\Actions\Steps\StepsUserRoles;
use App\Actions\TicketManagement\TicketAdministration;
use App\Models\Customer;
use App\Models\taskLogs;
use App\Models\ticket;
use LivewireUI\Modal\ModalComponent;

class CustomerProgressTimeline extends ModalComponent
{

     protected $listeners = ['InternalCommentResponded' => 'refreshTimeline'];

    public ticket $ticket;
    public $customer_id;
    public $customer;
    public $customerName;
    public $taskLogs;
    public $responseComment = '';
    public $openResponse = false;
    public $responseToLog = '';
    
    public function mount(StepsUserRoles $stepsUserRoles)
    {
        $this->customer_id = $stepsUserRoles->checkCustomer();
        $this->customer = $this->ticket->customer;
        $this->customerName = $this->customer->name;
        if($this->customer_id == $this->customer->id){
            $this->taskLogs = $this->ticket->taskLogs;            
        }     
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
            $ticketAdministration->createResponseToInternalComment($taskLog, $this->responseComment);
        }

        $this->responseComment = '';
        $this->responseTrigger($taskLog);
        $this->dispatch('InternalCommentResponded');
        
    }            
    public function render()
    {
        return view('livewire.customer.customer-progress-timeline');
    }
}
