<?php

namespace App\Livewire;

use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\DB;
use App\Models\ticket;

class ModalToRespondToday extends ModalComponent
{

    public $tickets;
    
    public function toRespondByToday()
    {
        $this->tickets = ticket::respondToday()->get();            
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
        $this->toRespondByToday();
        return view('livewire.modal-to-respond-today');
    }
}
