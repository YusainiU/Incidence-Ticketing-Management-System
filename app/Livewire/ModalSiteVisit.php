<?php

namespace App\Livewire;

use LivewireUI\Modal\ModalComponent;
use App\Models\TaskSiteVisit;

class ModalSiteVisit extends ModalComponent
{
    public $visits;

    /**
    * Supported: 'sm', 'md', 'lg', 'xl', '2xl', '3xl', '4xl', '5xl', '6xl', '7xl'
    */
    public static function modalMaxWidth(): string
    {
        return '6xl';
    }
    
    public function siteVisits()
    {
        $this->visits = TaskSiteVisit::siteVisit()
                ->orderByDesc('created_at')
                ->get();  
    }
    public function render()
    {
        $this->siteVisits();
        return view('livewire.modal-site-visit');
    }
}
