<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use iamfarhad\LaravelAuditLog\Traits\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ticket extends Model
{

    use Auditable;
    use SoftDeletes;
    protected $fillable = [
        'ticket_number',
        'customer_id',
        'sla_applications_id',
        'customer_reference',
        'category',
        'created_by',
        'source',
        'list_of_assets',
        'short_description',
        'description',
        'state',
        'raised_by_user',
        'raised_by_nonuser',
        'contact_telephone',
        'contact_email',
        'assigned_to',
        'assigned_group',
        'currently_working',
        'working_time',
        'resolution',
        'resolution_details',
        'closed_datetime',
        'fixed_datetime',
        'resolved_datetime',
        'resolved_by',
    ];

    public function setTicketNumberAttribute($value)
    {
        $prefix = Config()->get('steps.prefix_ticket');
        $this->attributes['ticket_number'] = $prefix . time();
    }

    public function getResolvedByAttribute($value)
    {
        if($value){
            $u = User::find($value,['name']);
            if($u){
                return $u->name;
            }
        }
        return null;
    }

    public function getCreatedByAttribute($value)
    {
        if($value){
            $u = User::find($value, ['name']);
            if($u){
                return $u->name;
            }
        }
        return null;
    }

    public function getRaisedByUserAttribute($value)
    {
        if($value){
            return $this->raisedByUser()->name;
        }
        return null;
    }

    public function getAssignedToAttribute($value)
    {
        if($value) {
            $u = User::find($value, ['name']);
            if($u){
                return $u->name;
            }
        }
        return null;    
    }

    public function getClosureDateAttribute($value)
    {
        return date('d/m/Y H:i', $value);
    }

    public function createdAtFormatted(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => date('d/m/Y H:i', strtotime($attributes['created_at'])),
        );
    }
    
    public function createAtDayOfTheWeek()
    {
        return Attribute::make(
            get: fn($value, $attributes) => date('l', strtotime($attributes['created_at'])),
        );
    }

    public function fixedDateFormatted($value)
    {
        return Attribute::make(
            get: fn ($value, $attributes) => date('d/m/Y H:i', $attributes['fixed_datetime']),
        );

    }

    public function getResolvedDateAttribute($value)
    {
        return date('d/m/Y H:i', $value);     
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function slaApplication()
    {
        return $this->belongsTo(slaApplication::class, 'sla_applications_id');
    }

    public function raisedByUser()
    {
        $un = $this->getAttributes()['raised_by_user'];
        return User::find($un);
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function resolvedBy()
    {      
        return $this->belongsTo(User::class, 'resolved_by');
    }

    public function slaTasks()
    {
        return $this->hasMany(slaTask::class);
    }

    public function taskLogs()
    {
        return $this->hasMany(taskLogs::class)->orderByDesc('created_at');
    }

    public function siteVisits()
    {
        return $this->hasMany(TaskSiteVisit::class)->orderByDesc('created_at');
    }

    public function scopeRespondToday($query)
    {
        $today = date('Y-m-d', time());
        return $query->whereRelation('slaTasks',DB::raw("DATE_FORMAT(`respond_by`,'%Y-%m-%d')"),'=',$today);
    }

    protected function casts()
    {
	    return [
            'currently_working' => 'boolean',
	    ];
    }

}
