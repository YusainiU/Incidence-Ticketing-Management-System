<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use iamfarhad\LaravelAuditLog\Traits\Auditable;

class TaskSiteVisit extends Model
{

    use SoftDeletes;
    use Auditable;
    protected $fillable = [
        'number',
        'short_description' ,
        'ticket_id' ,
        'assigned_to' ,
        'visit_scheduled_at' ,
        'first_visit' ,
        'scheduled_by' ,
        'description' ,
        'enroute_at' ,
        'onsite_at' ,
        'offsite_at',
    ];

    public function setNumberAttribute($value)
    {
        $prefix = Config()->get('steps.prefix_visit');
        $this->attributes['number'] = $prefix . time();
    }
    
    public function ticket()
    {
        return $this->belongsTo(ticket::class, 'ticket_id');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function scheduledBy()
    {
        return $this->belongsTo(User::class, 'scheduled_by');
    }

    public function scopeVisitEvents($query)
    {
        return $query->whereRelation('ticket','closed_datetime','=', null);
    }

    public function scopeSiteVisit($query)
    {
        return $query->where('onsite_at','=', null)
                ->where('offsite_at','=',null)
                ->whereRelation('ticket','closed_datetime','=', null);
    }

    public function scopeCurrentlyOnsite($query)
    {
        return $query->where('onsite_at','!=', null)
                ->where('offsite_at','=',null)
                ->where('enroute_at','!=', null)
                ->whereRelation('ticket','closed_datetime','=', null);
    }

    public function scopeCurrentlyEnroute($query)
    {
        return $query->where('onsite_at','=',null)
                ->where('offsite_at','=', null)
                ->where('enroute_at','!=', null)
                ->whereRelation('ticket','closed_datetime','=',null);
    }
    
}
