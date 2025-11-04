<?php

namespace App\Livewire;

use LivewireUI\Modal\ModalComponent;

class ImportProducts extends ModalComponent
{

    /**
    * Supported: 'sm', 'md', 'lg', 'xl', '2xl', '3xl', '4xl', '5xl', '6xl', '7xl'
    */
    public static function modalMaxWidth(): string
    {
        return '6xl';
    }    

    public function render()
    {
        return view('livewire.import-products');
    }
}
