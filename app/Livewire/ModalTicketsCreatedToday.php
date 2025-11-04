<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ticket;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Carbon;

class ModalTicketsCreatedToday extends ModalComponent
{
    public $tickets;
    public $today;

    /**
    * Supported: 'sm', 'md', 'lg', 'xl', '2xl', '3xl', '4xl', '5xl', '6xl', '7xl'
    */
    public static function modalMaxWidth(): string
    {
        return '6xl';
    }
    public function createdToday()
    {
        $today = Carbon::today();
        $this->today = $today;
        $this->tickets = ticket::whereDate('created_at',$today)->orderByDesc('created_at')->get();
    }

    public function render()
    {
        $this->createdToday();
        return view('livewire.modal-tickets-created-today');
    }
}
