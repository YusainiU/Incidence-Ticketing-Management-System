<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class taskLogs extends Model
{
    use SoftDeletes;
    protected $fillable  = [
        "number",
	    "name",
        "short_description",
        "type",                    
        "source",                              
	    "user_id",
        "external_user",
        "sla_tasks_id",
        "ticket_id",
        "description",
        "notification_sent_at",
        "require_attention",
        "task_site_visit_id",
    ];

    public function setNumberAttribute($value)
    {
        $prefix = Config()->get('steps.prefix_log');
        $this->attributes['number'] = $prefix . time();
    }

    public function getUserIdAttribute($value)
    {
        if($value) {
            $u = User::find($value,['name']);
            return $u->name;
        }
        return null;
    }

    public function ticket()
    {
        return $this->belongsTo(ticket::class, 'ticket_id');
    }
   public function internalUser()
    {
        $u = $this->attributes()['user_id'];
        return User::find($u)->get();
        //return $this->belongsTo(User::class, 'user_id');
    }
    public function logNumber($value)
    {
        return $this->where('number','=',$value)->first();
    }

    public function scopeUnrespondedComment($query)
    {
        return $query->where('source','=','external')
            ->where('response_to_external_comment','=',null)
            ->whereRelation('ticket','closed_datetime','=',null);
    }
        
}
