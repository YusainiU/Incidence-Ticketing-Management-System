<?php

namespace App\Livewire;

use App\Actions\Steps\StepsUserRoles;
use Livewire\Component;

class ProjectFileManager extends Component
{
    
    public function mount(StepsUserRoles $stepsUserRoles)
    {
        $access = $stepsUserRoles->checkAccess($this);
        session()->put('currentFolderId',2);
    }

    public function render()
    {
        return view('livewire.project-file-manager');
    }
}
