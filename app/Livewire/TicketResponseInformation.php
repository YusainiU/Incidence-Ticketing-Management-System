<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ticket;

class TicketResponseInformation extends Component
{
    public ticket $ticket;
    public function render()
    {
        return view('livewire.ticket-response-information');
    }
}
