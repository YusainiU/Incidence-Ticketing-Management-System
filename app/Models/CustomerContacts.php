<?php

namespace App\Models;

use App\Enums\CustomerContactRoles;
use Illuminate\Database\Eloquent\Model;

class CustomerContacts extends Model
{
    protected $fillable = [
        'user_id',
        'customerRole',
        'description',        
    ];

    protected $casts = [
        'customerRole' => CustomerContactRoles::class,
    ];  

    protected function casts()
    {
        return [
            'customerRole' => CustomerContactRoles::class,
        ];
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
