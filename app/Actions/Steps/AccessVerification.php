<?php


namespace App\Actions\Steps;

use App\Models\AccessLog;
use App\Models\LoginRegister;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class AccessVerification
{

    public function checkIfUserIsBlocked($username)
    {
        $f = Cache::get(strtolower($username), null);
        if ($f) {
            return true;
        }
        return false;
    }

    public function getAccessLog($ip, $email)
    {
        $access = AccessLog::where('ipAddress', '=', $ip)
            ->where('username', '=', strtolower($email))
            ->where('expired', '=', false)
            ->first();

        return $access;

    }

    public function resetFailedAttempt($ip, $email)
    {
        $access = AccessLog::where('ipAddress', '=', $ip)
            ->where('username', '=', strtolower($email))
            ->where('expired', '=', true)
            ->first();
        if ($access) {
            $access->expired = true;
            $access->save();
        }
    }

    public function checkAccessLog(array $credentials)
    {
        $ip = $credentials['ip'];
        $email = $credentials['email'];
        $access = $this->getAccessLog($ip, $email);
        $blocked = false;
        if ($access) {
            $counter = $access->failedAttemptsCounter;
            $counter++;
            if ($counter >= Config('steps.loginAttempts')) {
                if ($counter == Config('steps.loginAttempts')) {
                    $blocked = true;
                    Cache::put(strtolower($credentials['email']), $credentials['ip'], now()->addMinutes(Config('steps.blockedDuration')));
                    $unblockedDateTime = Carbon::now()->addMinutes(Config('steps.blockedDuration'));
                    $access->failedAttemptsCounter = $counter;
                    $access->blockedDateTime = Carbon::now();
                    $access->unblockedDateTime = $unblockedDateTime;
                } else {
                    $access->expired=true;
                    $this->createNewAccessLog($credentials);
                }
            } else {
                $access->failedAttemptsCounter = $counter;
            }
            $access->update();
        } else {
            //create
            $this->createNewAccessLog($credentials);
        }
        return $blocked;
    }

    public function createNewAccessLog(array $credentials)
    {
        $data = [
            'username' => strtolower($credentials['email']),
            'ipAddress' => $credentials['ip'],
            'failedAttemptsCounter' => 1,
            'expired' => false,
        ];
        AccessLog::create($data);
    }

    public function registerSuccessfulLogin(array $credentials)
    {
        $data = [
            'username' => strtolower($credentials['email']),
            'ipAddress' => $credentials['ip'],
            'userType' => $credentials['user_identity'],
        ];
        LoginRegister::create($data);
    }





}