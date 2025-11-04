<?php

namespace App\Livewire;

use App\Actions\Steps\StepsUserRoles;
use App\Models\slaTask;
use App\Models\TaskSiteVisit;
use App\Models\ticket;
use App\Models\User;
use LivewireUI\Modal\ModalComponent;
use iamfarhad\LaravelAuditLog\Models\EloquentAuditLog;
use Illuminate\Support\Facades\Schema;
use function PHPUnit\Framework\isEmpty;

class TicketAuditLog extends ModalComponent
{
    public ticket $ticket;
    public $visits;
    public $response;
    public $logs;
    public $columnTypes = [];
    public $columnNames = [];
    public $contents = [];
    public $sections = [];

    public function mount(StepsUserRoles $stepsUserRoles)
    {
        $stepsUserRoles->checkAccess($this);
        $this->visits = $this->ticket->siteVisits;
        $this->response = $this->ticket->slaTasks;
        $this->getColumnDetails();
        //The Order is important - do not change the order
        $this->getTicketLog();
        $this->getVisitLog();
        $this->getSlaLog();
    }

    public function getTicketLog()
    {

        if(!$this->checkAuditTableExist('audit_tickets_logs'))
        {
            return false;
        }

        $this->logs = EloquentAuditLog::forEntity(ticket::class)
            ->forEntityId($this->ticket->id)
            ->forAction('updated')
            ->orderBy('created_at', 'desc')
            ->get();
        $this->parseJsonToCollection($this->logs, $this->ticket);
    }

    public function getVisitLog()
    {

        if(!$this->checkAuditTableExist('audit_task_site_visits_logs'))
        {
            return false;
        }

        if (!$this->visits->isEmpty()) {
            foreach ($this->visits as $visit) {
                $vlogs = EloquentAuditLog::forEntity(TaskSiteVisit::class)
                    ->forEntityId($visit->id)
                    ->orderBy('created_at', 'desc')
                    ->get();
                $this->parseJsonToCollection($vlogs, $visit);    
            }
        }else{
            $this->contents[] = null;
        }
    }

    public function getSlaLog()
    {

        if(!$this->checkAuditTableExist('audit_sla_tasks_logs'))
        {
            return false;
        }        

        if(!$this->response->isEmpty()) {
            foreach ($this->response as $resp) {
                $slas = EloquentAuditLog::forEntity(slaTask::class)
                    ->forEntityId($resp->id)
                    ->orderBy('created_at', 'desc')
                    ->get();
                $this->parseJsonToCollection($slas, $resp);    
            }
        }else{
            $this->contents[] = null;
        }
    }

    public function checkAuditTableExist($tableName)
    {
        return Schema::hasTable($tableName);
    }

    public function parseJsonToCollection($logs, $entity)
    {
        $entityName = $entity->getTable();
        $this->sections[] = $entityName;
        $contents = [];
        foreach ($logs as $log) {
            $old = $this->parseValues($log->old_values, $entity, 'old');
            $new = $this->parseValues($log->new_values, $entity, 'new');
            $causer = $log->causer_type;
            $createdBy = 'System';
            if ($causer == 'App\Models\User') {
                $causerObject = $causer::find($log->causer_id)->first();
                $createdBy = $causerObject->name;
            }

            $loop = $old;
            if(!$loop) $loop = $new;

            foreach ($loop as $f => $v) {
                if($f == 'updated_at') continue;
                $contents[] = [
                    'Column' => $f,
                    'Old Value' => $old ? $old[$f] : null,
                    'New Value' => $new ? $new[$f] :  null,
                    'Action' => $log->action,
                    'Created' => date('d-m-Y H:i', strtotime($log->created_at)),
                    'Created By' => $createdBy,
                ];
            }
        }
        if(count($contents)) {
            $this->columnNames = array_keys($contents[0]);
        }
        $this->contents[] = $contents;
    }

    public function parseValues($values, $entity, $flag)
    {
        if(!$values) return null;
        $columns = [];
        foreach ($values as $col => $value) {
            $type = $this->columnTypes[$col];
            if ($type == 'bigint') {
                $r = $value ? $this->getModelObject($col, $value, $entity, $flag) : null;
                if($entity->getTable() == 'task_site_visits' && $col == 'assigned_to') $col = 'assigned_to_visit';
                $columns[$col] = $r;
            } else {
                if (($type == 'timestamp' || $type == 'datetime') && $value) {
                    $value = date('d-m-Y H:i', strtotime($value));
                }
                $columns[$col] = $value ? $value : null;
            }
        }

        return $columns;
    }

    private function getModelObject($col, $value, $entity, $flag)
    {
        //Value -> old value
        //entity -> ticket object that carries a new value
        if ($col == 'assigned_to' && $entity->assigned_to) {
            if($flag == 'new') return $entity->assigned_to;
            if($flag == 'old'){
                if(is_numeric($value))
                {
                    return User::find($value)->name;
                }
                return $value;
            }          
        }
        if ($col == 'resolved_by' && $entity->resolved_by) {
            return $entity->resolvedBy->name;
        }        
        return null;
    }

    public function getColumnDetails()
    {
        $cols = Schema::getColumnListing('tickets');
        $types = [];
        foreach ($cols as $field) {
            $types[$field] = Schema::getColumnType('tickets', $field);
        }
        $vcols = Schema::getColumnListing('task_site_visits');
        foreach($vcols as $field) {
            $types[$field] = Schema::getColumnType('task_site_visits', $field);
        }
        $slas = Schema::getColumnListing('sla_tasks');
        foreach($slas as $field) {
            $types[$field] = Schema::getColumnType('sla_tasks', $field);
        }        
        $this->columnTypes = $types;
    }

    /**
     * Supported: 'sm', 'md', 'lg', 'xl', '2xl', '3xl', '4xl', '5xl', '6xl', '7xl'
     */
    public static function modalMaxWidth(): string
    {
        return '6xl';
    }
    public function render()
    {
        return view('livewire.ticket-audit-log');
    }
}
