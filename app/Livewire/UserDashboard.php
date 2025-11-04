<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('User Dashboard')]
class UserDashboard extends Component
{
    
    public function render()
    {
        return view('livewire.user-dashboard');
    }
}
