<?php

namespace App\Livewire;


use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Actions\Steps\StepsUserRoles;
use App\Actions\Steps\AccessVerification;
class LoginInternal extends Component
{

    public $email = '';
    public $password = '';
    public $error;
    public $isBlocked = false;
    public $blockedMsg;

    public function verifyUsername()
    {    
        if($this->email)
        {
            $accessVerification = new AccessVerification();
            $blockedMsg = "You have exceeded the allowed " . config('steps.loginAttempts') . " attempts. Please wait " . Config('steps.blockedDuration') . " minutes before trying again";
            $isBlocked = $accessVerification->checkIfUserIsBlocked($this->email);
            if($isBlocked) {
                $this->isBlocked = $isBlocked;
                $this->error = $blockedMsg;
            }
        }                
    }

    public function loginForInternal(AccessVerification $accessVerification, Request $request)
    {

        $ip = $request->ip();
        
        $msg = "Invalid Credentials";

        $credentials = [
            'email' => $this->email,
            'password' => $this->password,
            'user_identity' => 'internal',
        ];

        $register = $credentials;
        $register['ip'] = $ip;

        if (Auth::attempt($credentials)) {
            stepsUserRoles::CreateUserIdentitySession();
            $accessVerification->resetFailedAttempt($ip, $this->email);
            $accessVerification->registerSuccessfulLogin($register);
            return redirect()->intended('dashboard');
        }

        //Failed        
        $credentials['ip'] = $ip;
        $accessVerification->checkAccessLog($credentials);
        $this->redirectRoute('internalLogin', ['error' => $msg]);

    }

    public function render()
    {
        return view('auth.login-internal');
        ;
    }
}
