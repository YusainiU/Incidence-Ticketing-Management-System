<?php

namespace App\Livewire;

use App\Actions\Steps\StepsUserRoles;
use App\Actions\TicketManagement\TicketAdministration;
use App\Models\TaskSiteVisit;
use App\Models\User;
use Livewire\Component;
use App\Models\ticket;
use App\Models\Asset;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;

class TicketProfile extends Component
{

    protected $listeners = ['visitHasBeenUpdated' => 'refreshVisit'];
    public ?ticket $ticket;
    public $assets;
    public $internalUsers;
    public $ticketDuration = 0;
    public $tasks;
    public $detailsUpdated = false;
    public $actionExecuted = false;
    public $failures = '';
    public $additionalInformation = '';
    public $selectedTab = '';
    public $ticketIsClosed = false;
    public $ticketStatusInformation = '';

    //Update Details
    public $short_description = '';
    public $customer_reference = '';
    public $category = '';
    public $description = '';

    //Ticket Action
    public $assignedTo = '';
    public $remoteResponseDate = '';
    public $remoteResponseTime = '';
    public $fixDate = '';
    public $fixTime = '';
    public $closeDate = '';
    public $closeTime = '';
    public $iAmWorking = false;
    public $note = '';
    public $noteIsImportant = false;
    public $notifyCustomer = false;

    //Resolution
    public $resolution = '';
    public $disableResolution = false;
    public $resolutionExecuted = false;
    public $resolveDate = '';
    public $resolveTime = '';
    public $resolveBy = '';
    public $resolutionNote = '';
    public $notifyResolutionToCustomer = '';

    //Visit

    #[Validate('required')]
    public $visit_short_description = '';
    public $visit_assigned_to = '';
    public $visit_first = false;
    public $visit_scheduled_date = '';
    public $visit_scheduled_time = '';
    public $visit_description = '';
    public $visit_enroute = '';
    public $visit_onsite = '';
    public $visit_offsite = '';
    public $visitCreated = false;
    public $allVisits;
    public $showVisitTable = false;
    public $canEdit = false;
   

    public function mount(TicketAdministration $ticketAdministration, StepsUserRoles $stepsUserRoles)
    {
        $access = $stepsUserRoles->checkAccess($this);
        $this->canEdit = $access['canEdit'];          
        $this->getAssets();
        $this->tasks = $this->ticket->slaTasks;
        $this->short_description = $this->ticket->short_description;
        $this->customer_reference = $this->ticket->customer_reference;
        $this->category = $this->ticket->category;
        $this->description = $this->ticket->description;
        $this->resolution = $this->ticket->resolution;
        $this->internalUsers = User::getActiveInternalUsers();
        if ($this->ticket->assigned_to) {
            //$this->assignedTo = $this->internalUsers->where('id', $this->ticket->assigned_to)->first();
            $this->assignedTo = $this->ticket->assigned_to;
        }
        $this->iAmWorking = $this->ticket->currently_working;
        $task = $this->tasks->first();
        if ($task) {
            if ($task->responded_at) {
                $ts = strtotime($task->responded_at);
                $this->remoteResponseDate = date('Y-m-d', $ts);
                $this->remoteResponseTime = date('H:i:s', $ts);
            }
            if ($task->fixed_at) {
                $ts = strtotime($task->fixed_at);
                $this->fixDate = date('Y-m-d', $ts);
                $this->fixTime = date('H:i:s', $ts);
            }
        }

        if($this->ticket->resolution)
        {
            $this->disableResolution = true;
            $resolvd = date('Y-m-d', $this->ticket->resolved_datetime);
            $resolvt = date('H:i', $this->ticket->resolved_datetime);
            $this->resolution = $this->ticket->resolution;
            $this->resolveDate = $resolvd;
            $this->resolveTime = $resolvt;
            $this->resolutionNote = $this->ticket->resolution_details;            
            if($this->ticket->resolved_by)
            {
                $this->resolveBy = $this->ticket->resolvedBy;
            }

        }
           
        if($this->ticket->closed_datetime)
        {
            $this->ticketIsClosed = true;
            $this->closeDate = date('Y-m-d', $this->ticket->closed_datetime);
            $this->closeTime = date('H:i', $this->ticket->closed_datetime);
        }

        if($this->ticket->siteVisits){
            $this->allVisits = $this->ticket->siteVisits;
            $this->showVisitTable = true;
        }

        $this->ticketStatusInformation = $ticketAdministration->retrieveTicketStatus($this->ticket);
        if(!sizeof($this->ticketStatusInformation)){
            $this->ticketStatusInformation = null;
        }

    }

    public function refreshVisit(TicketAdministration $ticketAdministration)
    {
        $this->selectedTab = 'Visit';
        $this->allVisits = TaskSiteVisit::where('ticket_id','=',$this->ticket->id)->orderByDesc('created_at')->get();
        $this->ticketStatusInformation = $ticketAdministration->retrieveTicketStatus($this->ticket);
    }

    public function updateTicket()
    {
        $this->detailsUpdated = true;
        $update = [
            'short_description' => $this->short_description,
            'customer_reference' => $this->customer_reference,
            'description' => $this->description,
        ];
        $this->ticket->update($update);
    }

    public function doResolve(TicketAdministration $ticketAdministration)
    {
        $this->validate([
            'resolution' => 'required_with:resolutionNote,resolveDate,resolveTime,resolveBy',
            'resolveDate' => 'required_with:resolution,resolutionNote,resolveBy',
            'resolveTime' => 'required_with:resolveDate',
            'resolutionNote' => 'required_with:resolution,resolveDate,resolveTime,resolveBy',
        ]);
        $data = [
            'resolution' => $this->resolution,
            'resolvedBy' => $this->resolveBy,
            'resolvedDate' => $this->resolveDate,
            'resolvedTime' => $this->resolveTime,
            'resolutionNote' => $this->resolutionNote,
            'emailResolution' => $this->notifyResolutionToCustomer,
        ];
        $slat = $this->tasks->where('task_type', '=', 'Service Level Agreement')->first();  
        $result = $ticketAdministration->setResolution($this->ticket, $slat, $data);
        if($result)
        {
            $this->resolutionExecuted = true;
        }
    }

    public function doVisit(TicketAdministration $ticketAdministration)
    {
        $validated = $this->validate([
            'visit_short_description' => 'required',
            'visit_assigned_to' => 'required',
            'visit_scheduled_date' => 'required | required_with:visit_scheduled_time',
            'visit_scheduled_time' => 'required | required_with:visit_scheduled_date',
        ]);
        
        $data = [
            'number' => null,
            'ticket_id' => $this->ticket->id,
            'short_description' => $this->visit_short_description,
            'assigned_to' => $this->visit_assigned_to,
            'scheduled_by' => Auth::user()->id,
            'first_visit' => $this->visit_first,
            'description' => $this->visit_description,
            'visit_scheduled_at' => "$this->visit_scheduled_date $this->visit_scheduled_time",
        ];

        $result = $ticketAdministration->setSiteVisit($this->ticket, $data);
        if($result)
        {
            $this->visitCreated = true;
            $this->visit_short_description = '';
            $this->visit_assigned_to = '';
            $this->visit_first = false;
            $this->visit_description = '';
            $this->visit_scheduled_date = '';
            $this->visit_scheduled_time = '';
            $this->allVisits = TaskSiteVisit::where('ticket_id','=',$this->ticket->id)->orderByDesc('created_at')->get();
            $this->showVisitTable = true;            
        }
        $this->dispatch('visitHasBeenUpdated');    
    }

    public function doAction(TicketAdministration $ticketAdministration)
    {
        $this->validate([
            'remoteResponseDate' => 'required_with:assigned_to',
            'remoteResponseTime' => 'required_with:remoteResponseDate',
            'fixDate' => 'required_with:assigned_to',
            'fixTime' => 'required_with:fixDate',
            'closeDate' => 'required_with:assigned_to, note',
            'closeTime' => 'required_with:closeDate',                 
        ]);

        $ok = false;
        $fail = [];
        $addInf = [];
        $inf = 'Specify Assigned To first before setting remote response and fix date and time';

        $assignedToId = is_object($this->assignedTo) ? $this->assignedTo->id : $this->assignedTo;
        $slat = $this->tasks->where('task_type', '=', 'Service Level Agreement')->first();

        //Set assigned to
        if ($this->ticket->assigned_to != $assignedToId) {
            if ($this->assignedTo) {
                //Assign
                $usr = $this->internalUsers->where('id', $this->assignedTo)->first();
                $ok = $ticketAdministration->setAssignedTo($this->ticket, $usr);
                $uname = $usr->name;
                if (!$ok) {
                    $fail[] = "Failed to assigned to $uname";
                } else {
                    $addInf[] = "Successfully Assigned to $uname";
                }
            } else {
                //Unassigned Ticket
                $unas = $this->ticket->assignedTo->name;
                $ok = $ticketAdministration->unassignedUser($this->ticket);
                if ($ok) {
                    $addInf[] = "Successfully Unassigned $unas";
                } else {
                    $fail[] = "Failed to unassigned $unas";
                }
            }
        }

        //Set remote response date and time
        if ($this->remoteResponseDate) {
            if (!$this->assignedTo) {
                $fail[] = $inf;
            } else {
                $data = [
                    'date' => $this->remoteResponseDate,
                    'time' => $this->remoteResponseTime
                ];
                $ok = $ticketAdministration->setRemoteResponse($this->ticket, $slat, $data);
                $dte = $this->remoteResponseDate . " " . $this->remoteResponseTime;
                if ($ok) {
                    $addInf[] = "Successfully set the remote response to $dte";
                }
            }
        }
        ;

        // Set Fix Date and Time
        if ($this->fixDate) {
            if (!$this->assignedTo) {
                $fail[] = $inf;
            } else {
                $data = [
                    'date' => $this->fixDate,
                    'time' => $this->fixTime
                ];
                $ok = $ticketAdministration->setFix($this->ticket, $slat, $data);
                $dtf = $this->fixDate . " " . $this->fixTime;
                if ($ok) {
                    $addInf[] = "Successfullt set the fix date and time to $dtf";
                }
            }
        }
        ;

        //Set Working flag
        if ($this->ticket->currently_working != $this->iAmWorking) {
            $ok = $ticketAdministration->setIamWorking($this->ticket, $this->iAmWorking);
        }

        //Create Progress Log
        if (trim($this->note)) {
            $ok = $ticketAdministration->createProgressLog(
                $this->ticket,
                $this->note,
                $this->noteIsImportant,
                $this->notifyCustomer
            );
            if ($ok) {
                $addInf[] = "Successfully added the progress log";
                $this->note = '';
                $this->noteIsImportant = false;
                $this->notifyCustomer = false;

            } else {
                $fail[] = "Error when adding the progress log";
            }
        }

        if ($this->closeDate && $this->closeTime) {
            $data = [
                'date' => $this->closeDate,
                'time' => $this->closeTime
            ];

            $ok = $ticketAdministration->closeTicket($this->ticket, $slat, $data);
            $cls = $this->closeDate . " " . $this->closeTime;
            if ($ok) {
                $addInf[] = "Successfully set the completed date and time to $cls";
            }
        }

        if (sizeof($fail)) {
            $failStatement = implode(", ", $fail);
            $this->failures = $failStatement;
        }

        if (sizeof($addInf)) {
            $this->additionalInformation = implode(", ", $addInf);
        }

        if ($ok) {
            $this->actionExecuted = true;
        }

    }

    public function selectTab(string $tab)
    {
        $this->selectedTab = $tab;
    }

    public function getAssets()
    {
        $assets = $this->ticket->list_of_assets;
        if ($assets) {
            $a = explode(",", $assets);
            $this->assets = Asset::listAssets($a);
        }
    }

    public function checkResponseTime(TicketAdministration $util)
    {
        $this->ticketDuration = $util->timeFromCreate($this->ticket);
    }

    public function getRespondByTime(TicketAdministration $util)
    {
        $respondBy = $util->getRespondByDateTime($this->ticket);
    }

    public function delete()
    {
        $id = $this->ticket->id;
        if($this->ticket->delete()){
            TicketAdministration::deleteTicketRelatedRecords($id);
        }
        redirect()->route('ticketList');
    }

    public function reopen(TicketAdministration $ticketAdministration)
    {
        $newTicket = $ticketAdministration->reopenTicket($this->ticket);
        if($newTicket){
            return redirect(route('ticketProfile',['ticket' => $newTicket]));        
        }
    }

    public function render()
    {

        return view('livewire.ticket-profile');
    }
}
