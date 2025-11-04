<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessLog extends Model
{
    protected $fillable = [
        'username',
        'ipAddress',
        'failedAttemptsCounter',
        'blockedDateTime',
        'unblockedDateTime',
        'expired',
    ];

    protected function casts(): array
    {
        return [
            'expired' => 'boolean',
        ];
    }    
    
}
