<?php

namespace App\Actions\TaskManagement;

use App\Models\slaTask;
use App\Models\ticket;

class TaskAdministration
{

    public function createNewTicketSlaTask(Ticket $ticket, $respondBy, $fixBy)
    {
        //dd($data);
        $taskType = config('steps.taskManagement.type');
        $data = [
            'number' => null,
            'name' => $ticket->short_description,
            'task_type' => $taskType['sla'],
            'short_description' => $ticket->short_description,
            'ticket_id' => $ticket->id,
            'sla_applications_id' => $ticket->sla_applications_id,
            'respond_by' => $respondBy,
            'fix_by' => $fixBy,
            'state' => 'open',
            'active' => true,
        ];
        $task = slaTask::create($data);
        return $task;
    }

    
}
