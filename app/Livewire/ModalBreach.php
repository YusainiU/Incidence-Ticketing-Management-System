<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\slaTask;
use LivewireUI\Modal\ModalComponent;

class ModalBreach extends ModalComponent
{

    public $slaTasks;


    /**
    * Supported: 'sm', 'md', 'lg', 'xl', '2xl', '3xl', '4xl', '5xl', '6xl', '7xl'
    */
    public static function modalMaxWidth(): string
    {
        return '6xl';
    }    
    public function breachedOpenTickets()
    {
        $this->slaTasks = slaTask::breached()->get();
    }    
    public function render()
    {
        $this->breachedOpenTickets();
        return view('livewire.modal-breach');
    }
}
