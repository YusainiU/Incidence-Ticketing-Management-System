<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;


class serviceLevelAgreement extends Model
{
    /** @use HasFactory<\Database\Factories\ServiceLevelAgreementFactory> */
    use HasFactory;
    protected $fillable = [
        'name',
        'short_description',
        'sla_key',
        'start_day',
        'end_day',
        'service_start_time',
        'service_end_time',
        'include_public_holiday',
        'cover_details',
        'active',
        'type',
        'response_time',
        'fixed_time',
    ];

    public static function getAllActiveSla()
    {
        return serviceLevelAgreement::where('active', '=', true)->orderBy('name')->get();
    }

    public static function secondsToHIS(int $seconds)
    {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $hr = str_pad($hours, 2, '0', STR_PAD_LEFT);
        $mn = str_pad($minutes, 2, '0', STR_PAD_LEFT);
        $result = "$hr:$mn:00";
        return $result;
    }

    public static function convertStringTimeToInt(int $seconds, string $timeType)
    {
        $his = self::convertSecondsToTime($seconds);
        $t = explode(":", $his);
        $h = (int) $t[0];
        $m = (int) $t[1];
        $result = 0;
        if ($timeType == 'hours') {
            $result = $h;
        }
        if ($timeType == 'minutes') {
            $result = $m;
        }
        return $result;
    }

    public static function convertTimeElementsToSeconds(int $hours, int $minutes)
    {
        return ($hours * 3600) + ($minutes * 60);
    }

    public static function displayPubHol($pubHol)
    {
        return $pubHol ? 'Yes' : 'No';
    }

    public static function displayStatus($active)
    {
        return $active ? 'Active' : 'Not Active';
    }

    public static function convertTimeToSecond(string $time): int
    {
        $d = explode(':', $time);
        return ($d[0] * 3600) + ($d[1] * 60);
    }

    public static function convertSecondsToTime($seconds)
    {

        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $seconds = $seconds % 60;
        return sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);

    }

    public function setSlaKeyAttribute($value)
    {
        $prefix = Config()->get('steps.prefix_slap');
        $this->attributes['sla_key'] = $prefix . time();
        /*
            To trigger the mutator, when creating an SLA
            set the sla_key to null .. example 
            
            ...
            $asset->sla_key = null; 
            $asset->save();

            This will auto create the sla_key  
        */
    }

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
            'include_public_holiday' => 'boolean',
        ];
    }

    private function buildResponseTimeResult($value)
    {
        $h = self::convertStringTimeToInt($value, 'hours');
        $m = self::convertStringTimeToInt($value, 'minutes');
        $f = self::secondsToHIS($value);

        return [
            'hours' => $h,
            'minutes' => $m,
            'seconds' => $value,
            'formatted' => $f,
        ];        
    }

    public function getServiceStartTimeAttribute($value)
    {
        $f = self::secondsToHIS($value);
        return [
            'formatted' => $f,
            'seconds' => $value,
        ];
    }

    public function getServiceEndTimeAttribute($value)
    {
        $f = self::secondsToHIS($value);
        return [
            'formatted' => $f,
            'seconds' => $value,
        ];
    }    

    public function getResponseTimeAttribute($value)
    {

        return $this->buildResponseTimeResult($value);

    }

    public function getFixedTimeAttribute($value)
    {
        return $this->buildResponseTimeResult($value);
    }

    public function getIncludePublicHolidayAttribute($value)
    {
        return $value ? 'Yes' : 'No';
    }

    public function getServiceDays(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => $attributes['start_day'] . " - " . $attributes['end_day'],
        );
    }
    
}
