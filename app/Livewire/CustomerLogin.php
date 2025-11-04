<?php

namespace App\Livewire;

use App\Actions\Steps\StepsUserRoles;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Actions\Steps\AccessVerification;


class CustomerLogin extends Component
{

    public $email = '';
    public $password = '';
    public $error = '';
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
    public function loginForCustomer(AccessVerification $accessVerification, Request $request)
    {

        $ip = $request->ip();        

        $msg = "Invalid Credentials";

        $credentials = [
            'email' => $this->email, 
            'password' => $this->password,
            'user_identity' => 'customer',
        ];

        $register = $credentials;
        $register['ip'] = $ip;        

        if (Auth::attempt($credentials)) {           
            $portalEnabled = StepsUserRoles::checkCustomerUserHasPortalAccess();
            if($portalEnabled){                
                stepsUserRoles::CreateUserIdentitySession();
                $accessVerification->resetFailedAttempt($ip, $this->email);
                $accessVerification->registerSuccessfulLogin($register);
                return redirect()->intended('customerViewProfile');
            }else{
                Auth::logout();
            }            
            $msg = 'Customer Portal is not Enabled';                        
        }
        
        //Failed        
        $credentials['ip'] = $ip;
        $accessVerification->checkAccessLog($credentials);                
        $this->redirectRoute('customerLogin',['error' => $msg]);
    }

    public function render()
    {
        return view('auth.customer-login');
    }
}
