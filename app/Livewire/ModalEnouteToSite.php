<?php

namespace App\Livewire;

use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use App\Models\TaskSiteVisit;
class ModalEnouteToSite extends ModalComponent
{
    public $enroutes;

    /**
    * Supported: 'sm', 'md', 'lg', 'xl', '2xl', '3xl', '4xl', '5xl', '6xl', '7xl'
    */
    public static function modalMaxWidth(): string
    {
        return '6xl';
    }
    
    public function enrouteToSite()
    {
        
        $this->enroutes = TaskSiteVisit::currentlyEnroute()
                ->orderByDesc('created_at')
                ->get();        
    }
    public function render()
    {
        $this->enrouteToSite();
        return view('livewire.modal-enoute-to-site');
    }
}
