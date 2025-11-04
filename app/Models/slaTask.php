<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use iamfarhad\LaravelAuditLog\Traits\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class slaTask extends Model
{
    use Auditable;
    use SoftDeletes;
    protected $fillable = [
        'number',
        'name',
        'short_description',
        'task_type',
        'ticket_id',
        'sla_applications_id',
        'respond_by',
        'fix_by',
        'responded_at',
        'fixed_at',
        'completed_at',
        'paused_at',
        'resumed_at',
        'breached_at',
        'active',
    ];


    public function getDateInDMY($value)
    {
        $t = date('d-m-Y H:i:s',strtotime($value));
        return $t;
    }

    public function checkIfBreach($value)
    {
        if($value)
        {
            return true;
        }else{
            return false;
        }
    }

    public function setNumberAttribute($value)
    {
        $prefix = COnfig()->get('steps.prefix_sla');
        $this->attributes['number'] = $prefix . time();
    }

    public function slaApplication()
    {
        return $this->belongsTo(slaApplication::class, 'sla_applications_id');
    }
    
    public function ticket()
    {
        return $this->belongsTo(ticket::class, 'ticket_id');
    }

    public function scopeEvents($query){
        return $query->whereRelation('ticket','closed_datetime','=', null);
    }

    public function scopeBreached($query)
    {
        return $query->where('breached_at','!=',null)->whereRelation('ticket','closed_datetime','=',null);
    }

}
