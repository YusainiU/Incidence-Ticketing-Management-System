<?php

namespace App\Livewire;

use LivewireUI\Modal\ModalComponent;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\ResetsUserPasswords;
use App\Actions\Fortify\PasswordValidationRules;

class ResetUserPassword extends ModalComponent implements ResetsUserPasswords
{

    use PasswordValidationRules;
    public User $user;
    public $password = null;
    public $password_confirmation = null;

    public function save()
    {
        $input['password'] = $this->password;
        $input['password_confirmation'] = $this->password_confirmation;
        $this->resetPassword($input);
    }

    public function resetPassword($input): void
    {
        Validator::make($input, [
            'password' => $this->passwordRules(),
        ])->validate();

        $this->user->forceFill([
            'password' => Hash::make($input['password']),
        ])->save();

        $this->redirect(route('userProfile',['user' => $this->user]));

    }    


    /**
    * Supported: 'sm', 'md', 'lg', 'xl', '2xl', '3xl', '4xl', '5xl', '6xl', '7xl'
    */
    public static function modalMaxWidth(): string
    {
        return '6xl';
    }

    public function render()
    {
        return view('livewire.reset-user-password');
    }
}
