<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use App\Enums\UserIdentity;
use App\Models\Customer;

class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'first_name',
        'last_name',
        'phone_number',
        'active',
        'user_identity',
        'customer_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'active' => 'boolean',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'user_identity' => UserIdentity::class,
        ];
    }

    public static function getActiveInternalUsers()
    {
        return Self::where('user_identity','=','internal')
            ->where('active','=',true)
            ->orderBy('name')
            ->get();
    }

    public function roles()
    {
        return $this->hasMany (UserToRoles::class);
    }
    
    public function customerRoles()
    {
        return $this->hasMany(CustomerContacts::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function scopeCustomerCompanies($query)
    {
        return $query->join('customers', 'users.customer_id','=','customers.id')
            ->where('users.user_identity','=','customer')
            ->select('users.id','users.customer_id','customers.name');
    }

}
