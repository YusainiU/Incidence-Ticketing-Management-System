<?php

namespace App\Livewire;

use App\Actions\TicketManagement\TicketAdministration;
use Livewire\Component;

class MainDashboard extends Component
{

    public $permissionAlert = false;
    //protected $listeners = ['alertNoPermission' => 'alertNoPermission'];

    public function mount(TicketAdministration $ticketAdministration)
    {
        $ticketAdministration->updateSlaBreachForAllOpenTasks();
    }

    public function render()
    {
        return view('livewire.main-dashboard');
    }
}
