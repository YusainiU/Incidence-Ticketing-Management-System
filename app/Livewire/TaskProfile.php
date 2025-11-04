<?php

namespace App\Livewire;

use App\Actions\TaskManagement\TaskAdministration;
use App\Actions\TicketManagement\TicketAdministration;
use Livewire\Component;

class TaskProfile extends Component
{

    private TaskAdministration $taskService;

    public function mount(TaskAdministration $taskAdministration)
    {
        $this->taskService = $taskAdministration;
    }
    public function render()
    {
        return view('livewire.task-profile');
    }
}
