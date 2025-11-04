<?php

namespace App\Livewire;

use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use App\Models\taskLogs;

class ModalUnrespondedComment extends ModalComponent
{

    public $taskLogs;

    /**
    * Supported: 'sm', 'md', 'lg', 'xl', '2xl', '3xl', '4xl', '5xl', '6xl', '7xl'
    */
    public static function modalMaxWidth(): string
    {
        return '6xl';
    }
    
    public function unrespondedComments()
    {
        $this->taskLogs = taskLogs::unrespondedComment()
            ->orderByDesc('created_at')
            ->get();
    }
    public function render()
    {
        $this->unrespondedComments();
        return view('livewire.modal-unresponded-comment');
    }
}
