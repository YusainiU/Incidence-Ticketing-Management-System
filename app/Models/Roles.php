<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Roles extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        "name",
        "description",
        "active",
        "allowed_routes",
        "allow_edit",
    ];

    protected function cast()
    {
        return ['active' => 'boolean',];
    }

    public function userWithRoles()
    {
        return $this->hasMany(UserToRoles::class);
    }


}

