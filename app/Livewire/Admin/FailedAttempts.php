<?php

namespace App\Livewire\Admin;

use App\Actions\Steps\StepsUserRoles;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\AccessLog;

class FailedAttempts extends Component
{

    use WithPagination;
    public $filter = '';    
    public function mount(StepsUserRoles $stepsUserRoles)
    {
        $access = $stepsUserRoles->checkAccess($this);

    }

    private function getFailedAttempts()
    {
        $query = AccessLog::query();
        if($this->filter)
        {
            $filterValue = "%{$this->filter}%";
            $query->whereAny(['username','ipAddress','failedAttemptsCounter'],'like',$filterValue);
        }
        $query->orderByDesc('created_at');
        return $query;        
    }

    public function clearAll()
    {
        AccessLog::truncate();
    }

    public function updatingFilter()
    {
        $this->resetPage('failedAttempts-list-page');
    }  

    public function render()
    {
        $query = $this->getFailedAttempts();
        return view('livewire.admin.failed-attempts', [
            'attempts' => $query->paginate(10,pageName:'failedAttempts-list-page'),
        ]);
    }
}
