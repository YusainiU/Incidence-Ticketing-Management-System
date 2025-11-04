<?php

namespace App\Livewire\Admin;

use App\Actions\Steps\StepsUserRoles;
use Livewire\Component;

class AdminDashboard extends Component
{

    public $canEdit = false;
    public $content = 'failedAttempts';
    public $openContent = '';

    public function mount(StepsUserRoles $stepsUserRoles)
    {
        $access = $stepsUserRoles->checkAccess($this);
        $this->canEdit = $access['canEdit'];
        if($this->openContent)
        {
            $this->content = $this->openContent;
            $this->openContent = '';
        }
    }

    public function selectContent(string $content) 
    {
        $this->content = $content;
    }

    public function render()
    {
        return view('livewire.admin.admin-dashboard');
    }
}
