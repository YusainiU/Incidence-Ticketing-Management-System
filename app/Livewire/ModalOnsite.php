<?php

namespace App\Livewire;

use LivewireUI\Modal\ModalComponent;
use App\Models\TaskSiteVisit;

class ModalOnsite extends ModalComponent
{

    public $onsites;

    public function currentlyOnsite()
    {
         
        $this->onsites = TaskSiteVisit::currentlyOnsite()
            ->orderByDesc('created_at')
            ->get();
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
        $this->currentlyOnsite();
        return view('livewire.modal-onsite');
    }
}
