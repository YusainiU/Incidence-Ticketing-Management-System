<?php

namespace App\Models;

use App\Enums\CustomerChildTypes;
use App\Enums\CustomerPrimaryTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Type\Integer;

class Customer extends Model
{
    /** @use HasFactory<\Database\Factories\CustomerFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'short_description',
        'primary_type',
        'child_type',
        'url',
        'address_1',
        'address_2',
        'address_3',
        'telephone_1',
        'telephone_2',
        'telephone_3',
        'parent_company',
        'active',
        'portal_enabled',
    ];

    public function getMainContacts(User $user)
    {
        return Customer::where(Customer::raw("(main_contact_1 = {$user->id} or main_contact_2 = {$user->id} or main_contact_3 = {$user->id})"))
        ->get()
        ->sortBy('name');
    }

    public function getParent($id)
    {
        return Customer::where('id',$id)->get()->first();
    }

    public function getCustomerTypeAttribute()
    {
        //dd($this->primary_type->value);
        return  CustomerPrimaryTypes::toName($this->primary_type->value);

    }

    protected function casts(): array
    {
        return [
            'primary_type' => CustomerPrimaryTypes::class,
            'child_type' => CustomerChildTypes::class,
            'active' => 'boolean',
            'portal_enabled' => 'boolean',
        ];
    }
    
    public function assets()
    {
        return $this->hasMany (Asset::class);
    }

    public function slaApplications()
    {
        return $this->hasMany(slaApplication::class);
    }

    public function contacts()
    {
        return $this->hasMany(User::class);
    }

    public function tickets()
    {
        return $this->hasMany(ticket::class)->where('closed_datetime',"=",null);
    }

    public function closedTickets()
    {
        return $this->hasMany(ticket::class)->where('closed_datetime',"!=",null);
    }    

}
