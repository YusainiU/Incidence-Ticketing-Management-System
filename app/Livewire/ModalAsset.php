<?php

namespace App\Livewire;

use App\Models\Asset;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class ModalAsset extends ModalComponent
{
    public Asset $asset;

    /**
    * Supported: 'sm', 'md', 'lg', 'xl', '2xl', '3xl', '4xl', '5xl', '6xl', '7xl'
    */
    public static function modalMaxWidth(): string
    {
        return '6xl';
    }        
    public function render()
    {
        return view('livewire.modal-asset');
    }
}
