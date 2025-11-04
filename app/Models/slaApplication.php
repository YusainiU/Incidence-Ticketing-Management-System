<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\DB;

class slaApplication extends Model
{
    protected $fillable = [
        'name',
        'short_description',
        'customer_id',
        'service_level_agreement_id',
        'priority',
        'active',
    ];

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
        ];
    }
    
    public static function getCustomerSlas(Customer $customer)
    {
        //return slaApplication::where('customer_id','=',$customer_id)->get();
        $slas = DB::table('sla_applications')
        ->where('sla_applications.customer_id','=',$customer->id)
        ->rightJoin('service_level_agreements', 'sla_applications.service_level_agreement_id', '=', 'service_level_agreements.id')
        ->select(
            'sla_applications.name as slapName',
            'sla_applications.id as slapId',
            'sla_applications.short_description as slapDescription',  
            'sla_applications.active as slapActive',  
            'service_level_agreements.*',
            'service_level_agreements.name as slaName'
        )
        ->get();
        return $slas;

    }

    public function getServiceLevelAgreement()
    {
        return $this->belongsTo(serviceLevelAgreement::class,'service_level_agreement_id');
    }

    public static function getSla(int $id)
    {
        return slaApplication::find($id);
    }

    public static function getCustomerSlaName(slaApplication $slap)
    {
        return serviceLevelAgreement::where('id','=',$slap->service_level_agreement_id)->get();
        
    }

    public function serviceLevelAgreement(){
        return $this->belongsTo(serviceLevelAgreement::class);
    }


}
