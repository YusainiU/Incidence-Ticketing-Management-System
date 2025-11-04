<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginRegister extends Model
{
    protected $fillable = [
        'username',
        'ipAddress',
        'userType',
    ];    
}
