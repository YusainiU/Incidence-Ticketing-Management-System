<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserToRoles extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'roles_id',   
    ];

    public function getRoleName(int $roleId)
    {
        return Roles::find($roleId);
    }

    public function getRoles()
    {
        return $this->belongsTo(Roles::class,'roles_id');
    }

    public function getRolesActive()
    {
        return Roles::where('active','=',true);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }

}
