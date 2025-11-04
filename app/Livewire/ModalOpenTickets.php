<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ticket;
use LivewireUI\Modal\ModalComponent;
class ModalOpenTickets extends ModalComponent
{
    public $tickets;

    /**
    * Supported: 'sm', 'md', 'lg', 'xl', '2xl', '3xl', '4xl', '5xl', '6xl', '7xl'
    */
    public static function modalMaxWidth(): string
    {
        return '6xl';
    }

    public function openTickets()
    {
        $this->tickets = ticket::where('closed_datetime', '=', null)->orderByDesc('created_at')->get();
    }
    public function render()
    {
        $this->openTickets();
        return view('livewire.modal-open-tickets');
    }
}
