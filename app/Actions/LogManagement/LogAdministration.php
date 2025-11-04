<?php

namespace App\Actions\LogManagement;

use App\Models\slaTask;
use App\Models\taskLogs;
use App\Models\ticket;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LogAdministration
{

    public function createSystemLog(ticket $ticket, string $logText, $logType = null)
    {
        $ext = $ticket->raised_by_nonuser;
        $source = $ext ? config('steps.logs.source.external') : $source = config('steps.logs.source.internal');
        $type = $logType ? $logType : config('steps.logs.type.system');

        $currentUserId = $currUserId = auth()->id();
        $name = $ticket->ticket_number;
        $ticket_id = $ticket->id;

        $data = [
            'number' => null,
            'name' => $name,
            'short_description' => $name,
            'type' => $type,
            'source' => $source,
            'user_id' => $currentUserId,
            'ticket_id' => $ticket_id,
            'description' => $logText,
            //sla_task_id
        ];

        if ($type == config('steps.logs.type.sla_tasks')) {
            $sla = $ticket->slaTasks->first();
            $data['sla_tasks_id'] = $sla->id;
        }

        $log = taskLogs::create($data);
        return $log;
    }

    public function buildVisitUpdatedScheduledLog($newSchedule, $oldSchedule, $user)
    {
        $phrase = Config('steps-logs.siteVisit.scheduledUpdated');
        $searchFor = ['%SCHEDULED%', '%DATETIME%', '%USER%'];
        $replaceWith = [$newSchedule, $oldSchedule, $user];
        $logString = str_replace($searchFor, $replaceWith, $phrase);
        return $logString;
    }

    public function buildVisitUpdatedAssignedTo($oldAssignee, $newAssignee, $user)
    {
        $phrase = Config('steps-logs.siteVisit.assignedToUpdated');
        $searchFor = ['%CURRENT%', '%NEW%', '%USER%'];
        $replaceWith = [$oldAssignee, $newAssignee, $user];
        $logString = str_replace($searchFor, $replaceWith, $phrase);
        return $logString;
    }

    public function buildVisitUpdatedEnroute(array $data)
    {
        if ($data['action'] == 'update') {
            $phrase = Config('steps-logs.siteVisit.enrouteUpdated');
            $searchFor = ['%ASSIGNEE%', '%DATETIME%', '%USER%'];
            $replaceWith = [$data['assignee'], $data['datetime'], $data['user']];
        }
        if($data['action'] == 'remove'){
            $phrase = Config('steps-logs.siteVisit.enrouteRemoved');
            $searchFor = '%USER%';
            $replaceWith = $data['user'];
        }
        $logString = str_replace($searchFor, $replaceWith, $phrase);
        return $logString;
    }

    public function buildVisitUpdatedOnsite(array $data)
    {
        if ($data['action'] == 'update') {
            $phrase = Config('steps-logs.siteVisit.onsiteUpdate');
            $searchFor = ['%ASSIGNEE%', '%DATETIME%', '%USER%'];
            $replaceWith = [$data['assignee'], $data['datetime'], $data['user']];
        }
        if($data['action'] == 'remove'){
            $phrase = Config('steps-logs.siteVisit.onsiteRemoved');
            $searchFor = '%USER%';
            $replaceWith = $data['user'];
        }
        $logString = str_replace($searchFor, $replaceWith, $phrase);
        return $logString;        
    }

    public function buildVisitUpdatedOffsite(array $data)
    {
        if ($data['action'] == 'update') {
            $phrase = Config('steps-logs.siteVisit.offsiteUpdate');
            $searchFor = ['%ASSIGNEE%', '%DATETIME%', '%USER%'];
            $replaceWith = [$data['assignee'], $data['datetime'], $data['user']];
        }
        if($data['action'] == 'remove'){
            $phrase = Config('steps-logs.siteVisit.offsiteRemoved');
            $searchFor = '%USER%';
            $replaceWith = $data['user'];
        }
        $logString = str_replace($searchFor, $replaceWith, $phrase);
        return $logString;
    }

    public function buildVisitLog($assignee, $scheduler, $datetime)
    {
        /*
            assignee -- person to visit
            scheduler -- person who arranged the visit
        */
        $phrase = config('steps-logs.siteVisit.visitCreated');
        $searchFor = ['%ASSIGNEE%', '%SCHEDULER%', '%DATETIME%'];
        $replaceWith = [$assignee, $scheduler, $datetime];
        $logString = str_replace($searchFor, $replaceWith, $phrase);
        return $logString;
    }

    public function buildVisitNote($createdBy, $visitNote)
    {
        $phrase = config('steps-logs.siteVisit.VisitNote');
        $searchFor = ['%CREATEDBY%', '%NOTE%'];
        $replaceWith = [$createdBy, $visitNote];
        $logString = str_replace($searchFor, $replaceWith, $phrase);
        return $logString;
    }

    public function buildVisitDeletion($shortDescription, $user)
    {
        $now = date('d-m-Y H:i', time());
        $phrase = config('steps-logs.siteVisit.delete');
        $searchFor = ['%DESCRIPTION%','%DATETIME%', '%USER%'];
        $replaceWith = [$shortDescription, $now, $user];
        $logString = str_replace($searchFor, $replaceWith, $phrase);
        return $logString;        
    }

    public function buildResolveText($user, $datetime)
    {
        $phrase = config('steps-logs.ProgressLogs.resolve');
        $searchFor = ['%USER%', '%DATETIME%'];
        $replaceWith = [$user, $datetime];
        $logString = str_replace($searchFor, $replaceWith, $phrase);
        return $logString;
    }

    public function buildCompletedText($dateCompleted)
    {
        $user = Auth::user()->name;
        $phrase = config('steps-logs.ProgressLogs.complete');
        $searchFor = '%USER%';
        $replaceWith = $user;
        $logString = str_replace($searchFor, $replaceWith, $phrase);
        return $logString;
    }
    public function buildAssignedToText(User $assignedTo)
    {
        $user = Auth::user()->name;
        $now = date('d-m-Y H:i', time());
        $phrase = config('steps-logs.ProgressLogs.assignedTo');
        $searchFor = ['%USER%', '%ASSIGNEE%', '%DATETIME%'];
        $replaceWith = [$user, $assignedTo->name, $now];
        $logString = str_replace($searchFor, $replaceWith, $phrase);
        return $logString;
    }

    public function buildUnassignedText(ticket $ticket)
    {
        $user = Auth::user()->name;
        $now = date('d-m-Y H:i', time());
        $assignee = $ticket->assignedTo->name;
        $phrase = config('steps-logs.ProgressLogs.unassigned');
        $searchFor = ['%USER%', '%ASSIGNEE%', '%DATETIME%'];
        $replaceWith = [$user, $assignee, $now];
        $logString = str_replace($searchFor, $replaceWith, $phrase);
        return $logString;
    }

    public function buildProgressEmailLog(taskLogs $taskLog, $receiver)
    {
        $phrase = config('steps-logs.ProgressLogs.email');
        $searchFor = ['%LOGNUMBER%', '%RECEIVER%'];
        $replaceWith = [$taskLog->number, $receiver];
        $logString = str_replace($searchFor, $replaceWith, $phrase);
        return $logString;
    }

    public function buildCurrentWorkingText(ticket $ticket)
    {
        $user = Auth::user()->name;
        if ($ticket->currently_working) {
            $phrase = config('steps-logs.ProgressLogs.working');
        } else {
            $phrase = config('steps-logs.ProgressLogs.unsetWorking');
        }
        $searchFor = '%USER%';
        $replaceWith = $user;
        $logString = str_replace($searchFor, $replaceWith, $phrase);
        return $logString;
    }

    public function buildTicketCreatedText(ticket $ticket)
    {
        $createdByName = $ticket->raised_by_nonuser;
        $created = date('d-m-Y H:i', strtotime($ticket->created_at));
        if (!$createdByName) {
            $createdByName = $ticket->raised_by_user;
        }
        $phrase = config('steps-logs.ticket.create');
        $searchFor = ['%CREATED%', '%BY%'];
        $replaceWith = [$created, $createdByName];
        $logString = str_replace($searchFor, $replaceWith, $phrase);
        return $logString;
    }

    public function buildSlaTaskCreatedText(slaTask $slaTask)
    {
        $created = date('d-m-Y H:i', strtotime($slaTask->created_at));
        $phrase = config('steps-logs.slaTask.create');
        $searchFor = '%CREATED%';
        $replaceWith = $created;
        $logString = str_replace($searchFor, $replaceWith, $phrase);
        return $logString;
    }

    public function buildProgressLogText($logText, $logInfo, $logExtraInfo)
    {
        $phrase = config('steps-logs.ProgressLogs.create');
        $searchFor = ['%INFO%', '%NOTE%', '%EXTRAINFO%'];
        $replaceWith = [$logInfo, $logText, $logExtraInfo];
        $logString = str_replace($searchFor, $replaceWith, $phrase);
        return $logString;
    }

    public function buildRemoteResponseLogText($remoteResponseDateTime, $respondedBy)
    {
        $phrase = config('steps-logs.ProgressLogs.remoteResponse');
        $searchFor = ['%RESPONSE%', '%BY%'];
        $replaceWith = [$remoteResponseDateTime, $respondedBy];
        $logString = str_replace($searchFor, $replaceWith, $phrase);
        return $logString;
    }

    public function buildFixedAtLogText($fixedAtDateTime, $fixedBy)
    {
        $phrase = config('steps-logs.ProgressLogs.fixedAt');
        $searchFor = ['%FIX%', '%BY%'];
        $replaceWith = [$fixedAtDateTime, $fixedBy];
        $logString = str_replace($searchFor, $replaceWith, $phrase);
        return $logString;
    }

    public function buildBreachLogText($breachDateTime)
    {
        $phrase = config('steps-logs.ProgressLogs.breach');
        $searchFor = '%BREACH%';
        $replaceWith = $breachDateTime;
        $logString = str_replace($searchFor, $replaceWith, $phrase);
        return $logString;
    }


}