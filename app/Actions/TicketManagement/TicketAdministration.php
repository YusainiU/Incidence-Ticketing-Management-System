<?php

namespace App\Actions\TicketManagement;

use App\Actions\Steps\PublicHoliday;
use App\Models\taskLogs;
use App\Models\TaskSiteVisit;
use App\Notifications\stepsNotification;
use App\Actions\TaskManagement\TaskAdministration;
use App\Actions\LogManagement\LogAdministration;
use App\Models\slaTask;
use App\Models\ticket;
use App\Models\User;
use App\Mail\stepsEmail;
use Illuminate\Container\Attributes\Config;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


class TicketAdministration
{

    protected $listeners = ['updateBreachStatus' => 'updateSlaBreachForAllOpenTasks'];
    public PublicHoliday $publicHolidays;
    public $holidays = [];

    public function __construct()
    {
        $this->publicHolidays = app()->make('App\Actions\Steps\PublicHoliday');
        $this->holidays = $this->publicHolidays->getPublicHolidays();
    }

    public  function reopenTicket(ticket $ticket)
    {
        //Recreate a new ticket using the closed one
        $raisedBy = $ticket->raisedByUser();
        $raisedByUserId = $raisedBy? $raisedBy->id:null;
        $data = [
            'ticket_number' => null,
            'customer_id' => $ticket->customer->id,
            'sla_applications_id' => $ticket->sla_applications_id,
            'customer_reference' => $ticket->customer_reference,
            'category' => $ticket->category,
            'created_by' => Auth()->id(),
            'source' => $ticket->source,
            'list_of_assets' => $ticket->list_of_assets,
            'short_description' => $ticket->short_description,
            'description' => $ticket->description,
            'state' => Config()->get('steps.ticketManagement.state.open'),
            'raised_by_user' => $raisedByUserId,
            'raised_by_nonuser' => $ticket->raised_by_nonuser,
            'contact_telephone' => $ticket->contact_telephone,
            'contact_email' => $ticket->contact_email,
        ];
        $newTicket = $this->createNewTicket($data);
        if($newTicket){
            $newTicket->closed_ticket_id = $ticket->id;
            $newTicket->save();
            return $newTicket;
        }
        return false;    
    }

    public static function deleteTicketRelatedRecords($ticketId)
    {
        slaTask::where('ticket_id','=',$ticketId)->delete();
        taskLogs::where('ticket_id','=',$ticketId)->delete();
        TaskSiteVisit::where('ticket_id','=',$ticketId)->delete(); 
    }

    public static function restoreTicketRelatedRecords($ticketId)
    {
        slaTask::withTrashed()->where('ticket_id','=',$ticketId)->restore();
        taskLogs::withTrashed()->where('ticket_id','=',$ticketId)->restore();
        taskSiteVisit::withTrashed()->where('ticket_id','=',$ticketId)->restore();      
    }

    public function createNewTicket($data)
    {
        //dd($data);
        $ticket = ticket::create($data);
        if ($ticket) {
            //Create Log for ticket
            $logAdmin = new LogAdministration;
            $logText = $logAdmin->buildTicketCreatedText($ticket);
            $this->createLog($logAdmin, $ticket, $logText);
            //Get Respond/Fix By DateTime
            $respondby = $this->getRespondByDateTime($ticket);
            $fixby = $this->getFixByDateTime($ticket);
            //Create new task Service
            $taskService = new TaskAdministration;
            $task = $taskService->createNewTicketSlaTask($ticket, $respondby, $fixby);
            //Create log for task
            $logText = $logAdmin->buildSlaTaskCreatedText($task);
            $logType = config('steps.logs.type.sla_tasks');
            $this->createLog($logAdmin, $ticket, $logText, $logType);
        }

        return $ticket;
    }

    public function checkStatusForMultipleTickets(Collection $tickets)
    {
        $result = [];
        foreach ($tickets as $ticket) {
            $r = $this->retrieveTicketStatus($ticket);
            if($r) {
                $result[$ticket->id] = $r;
            }
        }
        return $result;
    }

    public function retrieveTicketStatus(ticket $ticket)
    {
        //Check breach status
        //Check ticket status
        //Check urgent log
        //Check Site Visit
        //Get response time
        //get Fix Time
        //Check latest note in the logs

        $taskLogs = $ticket->taskLogs;
        $tasks = $ticket->slaTasks;
        $visits = $ticket->siteVisits;
        $result = [];
        if ($taskLogs && $taskLogs->count()) {
            //check urgent log
            //check latest Urgent log update
            $desc = $taskLogs->sortByDesc('created_at');
            $customerLogs = $desc->where('source', '=', 'external');
            $lastCustomerLog = $customerLogs->first();
            $urgents = $taskLogs->where('require_attention', '=', true)->sortByDesc('created_at');
            $first = $urgents->first();
            $result["numberOfUrgetLogs"] = 0;
            $result["lastUrgentLog"] = null;
            $result["lastUrgentLogCreatedAt"] = null;
            $result["lastCustomerLog"] = null;
            $result["lastCustomerLogCreatedAt"] = null;
            $result["totalVisits"] = 0;
            $result["totalVisited"] = 0;
            $result['currentlyEnroute'] = 0;
            $result['currentlyOnsite'] = 0;
            $result['respondBy'] = 'Not Available';
            $result['fixBy'] = 'Not Available';
            $result['respondedAt'] = 'Not Available';
            $result['fixedAt'] = 'Not Available'; 
            $result['visitScheduled'] = false;
            
            $result['resolved'] = $ticket->resolved_datetime ? date('d-m-Y H:i', $ticket->resolved_datetime) : null;
            $result['currentlyWorking'] = $ticket->currently_working;
            $result['closed'] = $ticket->state == 'Closed';
            
            if ($first && $first->count()) {
                //$result["lastUrgentLog"] = $first;
                $result["numberOfUrgetLogs"] = $urgents->count();
                $result["lastUrgentLogCreatedAt"] = date('d-m-Y H:i', strtotime($first->created_at));
            }
            if ($lastCustomerLog && $lastCustomerLog->count()) {
                //$result["lastCustomerLog"] = $lastCustomerLog;
                $result["lastCustomerLogCreatedAt"] = date('d-m-Y H:i', strtotime($lastCustomerLog->created_at));
            }
        }
        if ($tasks && $tasks->count()) {
            $tasksDesc = $tasks->sortByDesc('created_at');
            $taskBreached = $tasksDesc->where('breached_at', '!=', null);
            $fixBreach = $tasks->where('fix_by_breach_at',"!=", null);
            $respondByBreach = $tasks->where('respond_by_breach_at',"!=", null);
            $firstTask = $tasks->first();
            $respondBy = $firstTask->respond_by;
            $fixBy = $firstTask->fix_by;
            $respondedAt = $firstTask->responded_at;
            $fixedAt = $firstTask->fixed_at;
            $respondByInfo = $respondBy ? date('d-m-Y H:i', strtotime($respondBy)) : 'Not Available';
            $fixByInfo = $fixBy ? date('d-m-Y H:i', strtotime($fixBy)) : 'Not Available';
            $respondedAtInfo = $respondedAt ? date('d-m-Y H:i', strtotime($respondedAt)) : 'Not Available';
            $fixedAtInfo = $fixedAt ? date('d-m-Y H:i', strtotime($fixedAt)) : 'Not Available';
            $result["taskBreached"] = 0;
            $result['breachType'] = '';
            if ($taskBreached && $taskBreached->count()) {
                $result["taskBreached"] = $taskBreached->count();
                if($fixBreach && $fixBreach->count()){
                    $result['breachType'] = 'Fix By Breach';   
                }
                if($respondByBreach && $respondByBreach->count()){
                    $result['breachType'] = 'Respond By Breach';   
                }                
            }
            $result['respondBy'] = $respondByInfo;
            $result['fixBy'] = $fixByInfo;
            $result['respondedAt'] = $respondedAtInfo;
            $result['fixedAt'] = $fixedAtInfo;
        }
        if($visits && $visits->count()){
            //Total Visits
            $visited = $visits->where('onsite_at','!=',null)->count();
            $enroute = $visits->where('onsite_at','=', null)
                ->where('enroute_at','!=', null)
                ->count();
            $onsite = $visits->where('onsite_at','!=', null)
                ->where('offsite_at','=', null)
                ->count();                
            $result['totalVisits'] = $visits->count();
            $result['totalVisited'] = $visited;
            $result['currentlyEnroute'] = $enroute;
            $result['currentlyOnsite'] = $onsite;
            $result['visitScheduled'] = true;
        }
        return $result;
    }

    private function createLog(LogAdministration $logAdministration, ticket $ticket, $logText, $logType = null)
    {
        $log = $logAdministration->createSystemLog($ticket, $logText, $logType);
        return $log;
    }

    public function closeTicket(ticket $ticket, slaTask $slaTask, array $data)
    {
        //ticket->closed_datetime
        //ticket->state = closed
        //slaTask->completed_at
        //slaTask->state = completed
        $stateTicket = config('steps.ticketManagement.state.closed');
        $stateTask = config('steps.taskManagement.state.Completed');
        $logType = config('steps.logs.type.completed');
        $closedAt = $data["date"] . " " . $data["time"];
        $closedAtTS = strtotime($closedAt);
        $ticket->closed_datetime = $closedAtTS;
        $ticket->state = $stateTicket;
        $result = $ticket->save();
        $slaTask->completed_at = $closedAt;
        $slaTask->state = $stateTask;
        $slaTask->save();
        $logAdmin = new LogAdministration;
        $logText = $logAdmin->buildCompletedText($closedAt);
        $logAdmin->createSystemLog($ticket, $logText, $logType);
        return $result;
    }

    public function setSiteVisit(ticket $ticket, $data)
    {
        $visits = $ticket->siteVisits;
        $result = false;
        $firstVisit = false;
        $assin = json_decode($data["assigned_to"]);
        $dte = date('d-m-Y H:i', strtotime($data["visit_scheduled_at"]));
        if ($visits->count()) {
            $first = $visits->where('first_visit', '=', true)->first();
            $firstVisit = isset($first->first_visit) ? true : false;
            $result = true;
        }
        if ($firstVisit) {
            $data['first_visit'] = false;
        }
        $data['assigned_to'] = $assin->id;

        //Create Site Visit
        $visit = TaskSiteVisit::create($data);
        if ($visit) {
            //Create Log
            $logAdmin = new LogAdministration;
            $currentUserName = Auth::user()->name;
            $logType = config('steps.logs.type.site_visit');
            $logText = $logAdmin->buildVisitLog($currentUserName, $assin->name, $dte);
            $log = $logAdmin->createSystemLog($ticket, $logText, $logType);
            if ($log) {
                $log->task_site_visit_id = $visit->id;
                $log->save();
            }
            if (trim($data['description'])) {
                //Create Log for Visit Note
                $logType = config('steps.logs.type.site_visit_note');
                $logText = $logAdmin->buildVisitNote($currentUserName, $data['description']);
                $visitLog = $logAdmin->createSystemLog($ticket, $logText, $logType);
                $visitLog->task_site_visit_id = $visit->id;
                $visitLog->save();
            }
        }
        return $result;
    }

    public function updateSiteVisit(TaskSiteVisit $siteVisit, $data)
    {
        
        $siteVisitClone = clone $siteVisit;

        foreach($data as $k => $v)
        {
            $siteVisit->$k = $v;
        }
        
        $saved = $siteVisit->save();

        $this->trackVisitChangesForLog($siteVisitClone, $data);

        return $saved;
    }

    public function logVisitDeletion(TaskSiteVisit $siteVisit)
    {

        $ticket = $siteVisit->ticket;
        $logAdmin = new LogAdministration;
        $currentUserName = Auth::user()->name;
        $logType = config('steps.logs.type.site_visit');
        $logText = $logAdmin->buildVisitDeletion($siteVisit->short_description, $currentUserName);
        $deleteLog = $logAdmin->createSystemLog($ticket, $logText, $logType);
        $deleteLog->task_site_visit_id = $siteVisit->id;
        $result = $deleteLog->save();
        return $result;
    }

    private function trackVisitChangesForLog(TaskSiteVisit $siteVisit, $data)
    {
        $logAdmin = new LogAdministration;
        $currentUserName = Auth::user()->name;
        $logType = config('steps.logs.type.site_visit');
        $ticket = $siteVisit->ticket;
        $currentAssignedTo = $siteVisit->assignedTo->name;
        $objAssignedTo = user::find($data['assigned_to']);
        $newAssignedTo = $objAssignedTo->name;

        if ($siteVisit->visit_scheduled_at != $data['visit_scheduled_at']) {

            $logText = $logAdmin->buildVisitUpdatedScheduledLog($siteVisit->visit_scheduled_at, $data['visit_scheduled_at'], $currentUserName);
            $vsl = $logAdmin->createSystemLog($ticket, $logText, $logType);
            if ($vsl) {
                $vsl->task_site_visit_id = $siteVisit->id;
                $vsl->save();
            }
        }
        if ($siteVisit->assigned_to != $data['assigned_to']) {
            //Assigned To has been changed
            $logText = $logAdmin->buildVisitUpdatedAssignedTo($currentAssignedTo, $newAssignedTo, $currentUserName);
            $asl = $logAdmin->createSystemLog($ticket, $logText, $logType);
            if ($asl) {
                $asl->task_site_visit_id = $siteVisit->id;
                $asl->save();
            }            
        }
        if ($siteVisit->enroute_at != $data['enroute_at']) {
            $logd['user'] = $currentUserName;
            if($data['enroute_at']){
                $logd['action'] = 'update';
                $logd['assignee'] = $newAssignedTo;
                $logd['datetime'] = $data['enroute_at'];
            }else{
                $logd['action'] = 'remove';
            }
            $logType = config('steps.logs.type.site_visit_enroute');
            $logText = $logAdmin->buildVisitUpdatedEnroute($logd);
            $enl = $logAdmin->createSystemLog($ticket, $logText, $logType);
            if ($enl) {
                $enl->task_site_visit_id = $siteVisit->id;
                $enl->save();
            }              
        }
        if ($siteVisit->offsite_at != $data['offsite_at']) {
            $logf['user'] = $currentUserName;
            if($data['offsite_at']){
                $logf['action'] = 'update';
                $logf['assignee'] = $newAssignedTo;
                $logf['datetime'] = $data['offsite_at'];
            }else{
                $logf['action'] = 'remove';
            }
            $logType = config('steps.logs.type.site_visit_offsite');
            $logText = $logAdmin->buildVisitUpdatedOffsite($logf);
            $ofl = $logAdmin->createSystemLog($ticket, $logText, $logType);
            if ($ofl) {
                $ofl->task_site_visit_id = $siteVisit->id;
                $ofl->save();
            }                             
        }
        if ($siteVisit->onsite_at != $data['onsite_at']) {
            $logn['user'] = $currentUserName;
            if($data['onsite_at']){
                $logn['action'] = 'update';
                $logn['assignee'] = $newAssignedTo;
                $logn['datetime'] = $data['onsite_at'];
            }else{
                $logn['action'] = 'remove';
            }
            $logType = config('steps.logs.type.site_visit_onsite');
            $logText = $logAdmin->buildVisitUpdatedOnsite($logn);
            $onl = $logAdmin->createSystemLog($ticket, $logText, $logType);
            if ($onl) {
                $onl->task_site_visit_id = $siteVisit->id;
                $onl->save();
            }            
        }

    }

    public function setResolution(ticket $ticket, slaTask $slaTask, array $data)
    {
        /*
            slaTask->status = 'resolved'
            ticket->state = 'Resolved'
            ticket->resolution
            ticket->resolution_details
            ticket->resolved_datetime
        */

        $stateTicket = config('steps.ticketManagement.state.resolved');
        $stateTask = config('steps.taskManagement.state.Resolved');
        $logType = config('steps.logs.type.resolution');
        $logType = config('steps.logs.type.resolution');
        $resolvedBy = json_decode($data["resolvedBy"]);
        $rdate = $data["resolvedDate"] . " " . $data["resolvedTime"];
        $rdateTS = strtotime($rdate);
        $ticket->state = $stateTicket;
        $ticket->resolution = $data['resolution'];
        $ticket->resolved_datetime = $rdateTS;
        $ticket->resolution_details = $data["resolutionNote"];
        $ticket->resolved_by = $resolvedBy->id;
        $result = $ticket->save();
        if ($result) {
            $slaTask->state = $stateTask;
            $slaTask->save();
            $logAdmin = new LogAdministration;
            $logText = $logAdmin->buildResolveText($resolvedBy->name, $rdate);
            $log = $logAdmin->createSystemLog($ticket, $logText, $logType);
            if ($data["emailResolution"]) {
                //Email Resolution Log to customer
                $this->sendProgressNotification($ticket, $log, $logText);
                $log->notification_sent_at = date('Y-m-d H:i:s', time());
                $log->save();
            }
        }

        return $result;
    }
    public function setRemoteResponse(ticket $ticket, slaTask $slaTask, array $data)
    {
        $date = $data['date'];
        $time = $data['time'];
        $responded_at = "$date $time";
        $assigned = $ticket->assigned_to;
        $result = false;

        //Update Sla Task
        if ($slaTask->responded_at != $responded_at) {
            $slaTask->responded_at = $responded_at;
            $result = $slaTask->save();
            $this->checkATaskBreach($slaTask, $ticket);

            //Prepare and create Log
            $logType = config('steps.logs.type.sla_tasks');
            $logAdmin = new LogAdministration;
            $logText = $logAdmin->buildRemoteResponseLogText($responded_at, $assigned);
            $this->createLog($logAdmin, $ticket, $logText, $logType);

        }

        return $result;

    }

    public function setFix(ticket $ticket, slaTask $slaTask, array $data)
    {
        $date = $data['date'];
        $time = $data['time'];
        $fixed_at = "$date $time";
        $assigned = $ticket->assigned_to;
        $result = false;

        //Update Sla Task
        if ($slaTask->fixed_at != $fixed_at) {
            $slaTask->fixed_at = $fixed_at;
            $result = $slaTask->save();
            $this->checkATaskBreach($slaTask, $ticket);

            //Prepare and create log
            $logType = config('steps.logs.type.sla_tasks');
            $logAdmin = new LogAdministration;
            $logText = $logAdmin->buildFixedAtLogText($fixed_at, $assigned);
            $this->createLog($logAdmin, $ticket, $logText, $logType);

        }

        return $result;

    }

    public function setIamWorking(ticket $ticket, bool $workFlag)
    {
        $result = false;
        if ($ticket->currently_working != $workFlag) {
            $ticket->currently_working = $workFlag;
            $result = $ticket->save();
            $logAdmin = new LogAdministration;
            $logText = $logAdmin->buildCurrentWorkingText($ticket);
            $this->createLog($logAdmin, $ticket, $logText);
        }
        return $result;
    }

    public function createResponseToExternalComment(taskLogs $taskLog, $comment)
    {
        $ticket = $taskLog->ticket;
        $logAdmin = new LogAdministration;
        $log = $logAdmin->createSystemLog($ticket, $comment);
        if($log)
        {
            $log->response_to_external_comment = $taskLog->number;
            $taskLog->response_to_external_comment = $log->number;
            $log->save();
            $taskLog->save();
        }
        return $log;
    }

    public function createResponseToInternalComment(taskLogs $taskLog, $comment)
    {
        $ticket = $taskLog->ticket;
        $logAdmin = new LogAdministration;
        $log = $logAdmin->createSystemLog($ticket, $comment);
        if($log)
        {
            $log->source = config('steps.logs.source.external');
            $log->save();
        }
        return $log;
    }

    public function createProgressLog(ticket $ticket, string $log, bool $urgentFlag, bool $notificationFlag)
    {
        $logType = config('steps.logs.type.ticket');
        $logAdmin = new LogAdministration;
        $logDate = date('d-m-Y H:i', time());
        $loggedBy = Auth::user()->name;
        $logInfo = "$loggedBy - $logDate";
        $logExtra = $loggedBy;
        $logText = $logAdmin->buildProgressLogText($log, $logInfo, $logExtra);
        $log = $this->createLog($logAdmin, $ticket, $logText, $logType);
        if ($urgentFlag && $log) {
            $log->require_attention = $urgentFlag;
            $log->save();
        }
        if ($notificationFlag) {
            $this->sendProgressNotification($ticket, $log, $logText);
            $log->notification_sent_at = date('Y-m-d H:i:s', time());
            $log->save();
        }
        return $log;
    }

    public function emailProgressNotification(ticket $ticket, taskLogs $taskLog, $log, $sendTo = [
        'email' => null, 
        'name' => null,]
    )
    {
        $from = Auth::user()->name;
        $title = "Progress Log ( $ticket->ticket_number ) - $ticket->short_description";
        $email = '';
        $usr = '';        
        if($sendTo['email'] && $sendTo['name']){
            $email = filter_var($sendTo['email'], FILTER_VALIDATE_EMAIL);
            $usr = $from;
            if($email)
            {
                $data["name"] = $sendTo['name'];
                $data["subject"] = $title;
                $data["title"] = $title;
                $data["message"] = $log;
                Mail::to($email)->send(new stepsEmail($data));    
            }        
        }
        if($usr && $email)
        {
            $logAdmin = new LogAdministration;
            $logText = $logAdmin->buildProgressEmailLog($taskLog, $usr);
            $log = $this->createLog($logAdmin, $ticket, $logText);
            return true;            
        }
        return false;
    }

    private function sendProgressNotification(ticket $ticket, taskLogs $taskLog, $log)
    {
        $from = Auth::user()->name;
        $title = "Progress Log ( $ticket->ticket_number ) - $ticket->short_description";
        $email = '';
        $usr = '';
        if ($ticket->raised_by_user) {
            $usr = $ticket->raised_by_user;
            $user = $ticket->raisedByUser();
            $email = $user->email;
            $message["from"] = "From: $from";
            $message["title"] = "Subject: $title";
            $message["greeting"] = "For attention: $usr";
            $message["content"] = $log;
            $message["datetime"] = "Timestamp: " . date('d-m-Y H:s', time());
            $user->notify(new stepsNotification($message));
        }
        if ($ticket->raised_by_nonuser && $ticket->contact_email) {
            $email = $ticket->contact_email;
            $usr = $ticket->raised_by_nonuser;
            $data["name"] = $usr;
            $data["subject"] = $title;
            $data["title"] = $title;
            $data["message"] = $log;
            Mail::to($email)->send(new stepsEmail($data));
        }
        if ($email && $usr) {
            //Create Log
            $logAdmin = new LogAdministration;
            $logText = $logAdmin->buildProgressEmailLog($taskLog, $usr);
            $log = $this->createLog($logAdmin, $ticket, $logText);
            return true;
        }
        return false;
    }

    public function setAssignedTo(ticket $ticket, User $assigned_to)
    {
        $ticket->assigned_to = $assigned_to->id;
        $result = $ticket->save();
        $logAdmin = new LogAdministration;
        $logText = $logAdmin->buildAssignedToText($assigned_to);
        $this->createLog($logAdmin, $ticket, $logText);
        return $result;
    }

    public function unassignedUser(ticket $ticket)
    {
        $logAdmin = new LogAdministration;
        $logText = $logAdmin->buildUnassignedText($ticket);
        $this->createLog($logAdmin, $ticket, $logText);
        $ticket->assigned_to = null;
        $result = $ticket->save();
        return $result;
    }

    public function updateSlaBreachForAllOpenTasks()
    {
        $tasks = slaTask::where('completed_at', null)->get();
        $this->slaBreachUpdate($tasks);
    }

    public function updateSlaBreachForOpenTicket(ticket $ticket)
    {
        $tasks = $ticket->slaTasks->where('completed_at','=',null);
        $this->slaBreachUpdate($tasks);
    }
    public function slaBreachUpdate($tasks)
    {
        
        if ($tasks) {
            foreach ($tasks as $task) {
                $this->checkATaskBreach($task, $task->ticket);
            }
        }
    }

    public function checkATaskBreach(slaTask $task, ticket $ticket)
    {
        $now = date('Y-m-d H:i:s');
        $updateBreach = false;
        $r = $this->checkSlaBreach($task);
        if ($r['respond_by_breach']) {
            $task->respond_by_breach_at = $now;
            $updateBreach = true;
        }
        if ($r['fix_by_breach']) {
            $task->fix_by_breach_at = $now;
            $updateBreach = true;
        }
        //Only update breached_at if it has no value
        if ($updateBreach && !$task->breached_at) {
            $task->breached_at = $now;
            $task->save();
            //Prepare and create Log
            $logAdmin = new LogAdministration;
            $logText = $logAdmin->buildBreachLogText($now);
            $this->createLog($logAdmin, $ticket, $logText);
        }
    }

    public function checkSlaBreach(slaTask $slaTask)
    {
        $sla = $slaTask;

        $now = time();
        $breach = false;
        $respond_by_breach = false;
        $fix_by_breach = false;
        //$test = [];

        $respondedAt = $sla->responded_at ? strtotime($sla->responded_at) : null;
        $fixedAt = $sla->fixed_at ? strtotime($sla->fixed_at) : null;
        $respby = $sla->respond_by ? strtotime($sla->respond_by) : null;
        $fixby = $sla->fix_by ? strtotime($sla->fix_by) : null;

        //[1] If respondby or fix by have passed current datetime -> breach by default
        //$test[] = "$now (now) > $respby (respby) && !$respondedAt (respondedAt)";
        if ($now > $respby && !$respondedAt) {
            $respond_by_breach = true;
            $breach = true;
            //$test[] = "breach is true";
        }

        //$test[] = "$now (now) > $fixby (fixby) && !$respondedAt (respondedAt)";
        if ($now > $fixby && !$fixedAt) {
            $fix_by_breach = true;
            $breach = true;
            //$test[] = "breach is true";
        }

        /*
            [3] and [4] Check ..
                - if responded_at/fixed_at has value and ..
                - if responded_at/fixed_at is after respond_by/fixed_by and ...
                - if breached_at is empty

        */
        //[3]
        //$test[] = "$respondedAt (respondedAt) && $respondedAt (respondedAt) > $respby (respby) && !$sla->breached_at (sla->breached_at)";
        if ($respondedAt && $respondedAt > $respby && !$sla->breached_at) {
            $respond_by_breach = true;
            $breach = true;
            //$test[] = "breach is true";
        }

        //[4] Check fixed_at
        //$test[]="$fixedAt (fixedAt && $fixedAt (fixedAt) > $fixby (fixby) && && !$sla->breached_at (sla->breached_at)";
        if ($fixedAt && $fixedAt > $fixby && !$sla->breached_at) {
            $fix_by_breach = true;
            $breach = true;
            //$test[] = "breach is true";
        }

        $result = [
            'breach' => $breach,
            'respond_by_breach' => $respond_by_breach,
            'fix_by_breach' => $fix_by_breach,
        ];

        //dd($test);
        return $result;

    }

    public function timeFromCreate(ticket $ticket)
    {
        $startDate = $ticket->created_at;
        $dur = round((time() - strtotime($startDate)) / 3600, 1);
        return $dur;
    }


    public function timeDiff(int $start, int $end)
    {
        $timediff = $start - $end;
        $result = $this->parseSeconds($timediff);
        return $result;

    }

    public function parseSeconds($seconds)
    {

        $days = intval($seconds / 86400);
        $remain = $seconds % 86400;
        $hours = intval($remain / 3600);
        $remain = $remain % 3600;
        $mins = intval($remain / 60);
        $secs = $remain % 60;

        return [
            'days' => $days,
            'hours' => $hours,
            'mins' => $mins,
            'seconds' => $secs,
        ];

    }

    public function parseTimeStampToSeconds($timestamp)
    {
        $r = date('H:i:s', $timestamp);
        $s = explode(":", $r);
        $h = (int) $s[0];
        $m = (int) $s[1];
        $i = (int) $s[2];
        $result = ($h * 3600) + ($m * 60) + $i;
        return $result;
    }

    public function daysOfWeek()
    {
        $timestamp = strtotime('next Sunday');
        $days = array();
        for ($i = 0; $i < 7; $i++) {
            $days[] = strtolower(date('l', $timestamp));
            $timestamp = strtotime('+1 day', $timestamp);
        }
        return $days;
    }

    public function isDayInsideSla(int $slaStartDate, string $slaStartDay, string $slaEndDay, string $dayToVerify)
    {
        $w = $this->daysOfWeek();
        $f = array_flip($w);
        $f['sunday'] = 7;
        foreach ($w as $key => $day) {
            if ($day == strtolower($this->startDay)) {
                $start = $f[strtolower($slaStartDay)];
                $end = $f[strtolower($slaEndDay)];
                $v = $f[strtolower($dayToVerify)];
                if ($v >= $start && $end >= $v) {
                    return true;
                }
            }
        }
        return false;
    }

    public function secondsToHM($seconds)
    {

        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        return [
            'hours' => $hours,
            'minutes' => $minutes,
        ];
    }
    private $startDate = '';
    private $responseTime = 0;
    private $startDay = '';
    private $endDay = '';
    private $serviceStartAt = 0;
    private $serviceEndAt = 0;
    private $createdDay = '';
    private $includePublicHoliday = false;

    private function buildCalcData(ticket $ticket, $field)
    {

        $rpt = $ticket->slaApplication->serviceLevelAgreement->response_time;
        $fxt = $ticket->slaApplication->serviceLevelAgreement->fixed_time;
        $stt = $ticket->slaApplication->serviceLevelAgreement->service_start_time;
        $pub = $ticket->slaApplication->serviceLevelAgreement->include_public_holiday;
        $set = $this->serviceEndAt = $ticket->slaApplication->serviceLevelAgreement->service_end_time;

        $response_time = $rpt['seconds'];
        $service_start_time = $stt['seconds'];
        $service_end_time = $set['seconds'];
        $fixed_time = $fxt['seconds'];

        if ($field == 'response_time') {
            $this->responseTime = $response_time;
        }

        if ($field == 'fix_time') {
            $this->responseTime = $fixed_time;
        }

        $this->startDate = strtotime($ticket->created_at);
        $this->startDay = $ticket->slaApplication->serviceLevelAgreement->start_day;
        $this->endDay = $ticket->slaApplication->serviceLevelAgreement->end_day;
        $this->serviceStartAt = $service_start_time;
        $this->serviceEndAt = $service_end_time;
        $this->createdDay = strtolower(date('l', strtotime($ticket->created_at)));
        $this->includePublicHoliday = $pub;

    }
    public function getRespondByDateTime(ticket $ticket)
    {
        $this->buildCalcData($ticket, 'response_time');
        $respondBy = $this->calcRespondByTime();
        return $respondBy;

    }

    public function getFixByDateTime($ticket)
    {
        $this->buildCalcData($ticket, 'fix_time');
        $fixBy = $this->calcRespondByTime();
        return $fixBy;
    }
    public function calcRespondByTime()
    {

        $serviceTime = $this->serviceEndAt - $this->serviceStartAt;

        //DIAGNOSTIC
        // $logs = [];
        // $logs["startDate"] = $this->startDate;
        // $logs["startDay"] = $this->startDay;
        // $logs["Service End At"] = $this->serviceEndAt;
        // $logs["Service Start At"] = $this->serviceStartAt;
        // $logs["Service Start At"] = $this->serviceStartAt;
        // $logs["StartDay"] = $this->startDay;
        // $logs["EndtDay"] = $this->endDay;
        // $logs["createdDay"] = $this->createdDay;
        //dd($logs);

        //Check Start Day and get the initialised start date
        $weekdays = $this->daysOfWeek();
        $nextday = $this->startDate;
        $initDate = 0;

        // while(!$this->isDayInsideSla($nextday, $this->startDay, $this->endDay, $this->createdDay))
        // {
        //     $nextday = date(strtotime('+1 day', $nextday));
        // }

        $initDate = $nextday;

        //DIAGNOSTIC
        // $logs["initDate"] = date('l',$initDate);

        //check the initialised date time is inside the sla service time
        $totalSeconds = 0;
        $toRespondByTime = 0;
        $toRespondByDate = $initDate;

        if ($this->serviceEndAt == 0) {
            $this->serviceEndAt = 86400;
        }

        $limit = 20;

        if ($initDate) {
            $counter = 0;

            //DIAGNOSTIC
            // $logs["----- Start While Loop ------- "] = 'WHILE';

            while ($counter < $limit) {
                $counter++;
            
                //DIAGNOSTIC
                // $logs["WHILE LOOP COUNTER $counter"] = $counter;
            
                $responserCounter = 0;
                $initDay = strtolower(date('l', $initDate));
            
                //DIAGNOSTIC
                // $logs["initDay $counter"] = $initDay;
                
                $isIncluded = $this->isDayInsideSla($initDate, $this->startDay, $this->endDay, $initDay);

                //DIAGNOSTIC
                // $logs["IsIncluded $counter"] = $isIncluded; 
                // $logs["Total Seconds $counter"] = $totalSeconds;

                if (!$isIncluded) {

                    //DIAGNOSTIC
                    // $logs["Exclude the date"] = 'Yes'; 
                    
                    $initDate = strtotime('+1 day', $initDate);
                    continue;
                }

                //Check whether the date is a public holiday if SLA specifies
                if($this->includePublicHoliday){
                    $dmy = date('d-m-Y', $initDate);
                    if(in_array($dmy, $this->holidays)){

                        //DIAGNOSTIC
                        // $logs["Public Holiday"] = 'Yes'; 
                        
                        $initDate = strtotime('+1 day', $initDate);
                        continue;
                    }
                }

                //DIAGNOSTIC
                // $logs["----- if total seconds is more than 0 $counter ------- "] = 'IF';

                if ($totalSeconds > 0) {
                    $initSeconds = $this->serviceStartAt + $totalSeconds;

                    //DIAGNOSTIC
                    // $logs["initSeconds $counter"] = $initSeconds;

                    if ($initSeconds <= $this->serviceEndAt) {
                        $toRespondByTime = $initSeconds;
                        $toRespondByDate = $initDate;
                        break;
                    } else {
                        $totalSeconds = $initSeconds - $this->serviceEndAt;
                    }

                } else {

                    //DIAGNOSTIC
                    // $logs["----- if total seconds is 0 $counter ------- "] = 'ELSE';
                    // $logs["initDate $counter"] = $initDate;

                    $initTime = $this->parseTimeStampToSeconds($initDate);

                    //DIAGNOSTIC
                    // $logs["initTime $counter"] = $initTime;

                    $initSeconds = $initTime;

                    //DIAGNOSTIC
                    // $logs["initSeconds $counter"] = $initSeconds;

                    if ($initSeconds < $this->serviceEndAt) {
                    
                        //DIAGNOSTIC
                        // $logs["condition 1 $counter"] = "$initSeconds < $this->serviceEndAt";

                        $responserCounter = $initSeconds;
                        //Ticket is created before the service end time
                        if ($initSeconds < $this->serviceStartAt) {

                            //DIAGNOSTIC
                            // $logs["condition 2 $counter"] = "$initSeconds < $this->serviceStartAt";

                            $responserCounter = $this->serviceStartAt;

                        }

                        $responserCounter += $this->responseTime;

                        //DIAGNOSTIC
                        // $logs["responseCounter $counter"] = $responserCounter;

                        if ($responserCounter > $this->serviceEndAt) {
                            $totalSeconds = $responserCounter - $this->serviceEndAt;
                        } else {
                            $toRespondByTime = $responserCounter;
                            $toRespondByDate = $initDate;
                            break;
                        }
                    }
                    if ($initSeconds > $this->serviceEndAt) {
                        //Ticket is created after the service time end
                        $totalSeconds = 0;
                        //Changed the initDate to the serviceStartAt
                        $iHIS = $this->parseSeconds($this->serviceStartAt);
                        $iYMD = date('Y-m-d', $initDate);
                        $initDate = strtotime($iYMD." ".$iHIS['hours'].":".$iHIS['mins'].":".$iHIS['seconds']);
                        
                        //DIAGNOSTIC
                        $logs["Total Seconds is 0 $counter"] = $initDate;
                    
                    }
                }

                //DIAGNOSTIC
                // $logs["----- END IF $counter ------- "] = 'END';
                // $logs["Total Seconds End $counter"] = $totalSeconds;

                $initDate = strtotime('+1 day', $initDate);

            }

            //DIAGNOSTIC
            // $logs["Respond By Time"] = $this->parseSeconds($toRespondByTime);
            // $logs["Respond By Date"] = date('d-m-Y', $toRespondByDate);
            // dd($logs);

            $rde = date('Y-m-d', $toRespondByDate);
            $rte = $this->parseSeconds($toRespondByTime);
            $resulttime = $rte['hours'] . ":" . $rte['mins'] . ":" . $rte['seconds'];
            $resultDateTime = "$rde $resulttime";

            return $resultDateTime;

        }


    }

}
