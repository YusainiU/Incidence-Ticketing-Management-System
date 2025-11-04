<?php

namespace App\Livewire\Admin;

use App\Actions\Steps\StepsUserRoles;
use App\Models\LoginRegister;
use Livewire\WithPagination;
use Livewire\Component;

class SuccessfulLogins extends Component
{

    use WithPagination;
    public $filter='';
    public function mount(StepsUserRoles $stepsUserRoles)
    {
        $access = $stepsUserRoles->checkAccess($this);
    }

    private function getSuccessfulAttempts()
    {
        $query = LoginRegister::query();
        if($this->filter)
        {
            $filterValue = "%{$this->filter}%";
            $query->whereAny(['username','ipAddress','userType'],'like',$filterValue);
        }
        $query->orderByDesc('created_at');
        return $query;      

    }

    public function clearAll()
    {
        LoginRegister::truncate();
    }

    public function updatingFilter()
    {
        $this->resetPage('successfulLogins-list-page');
    }      

    public function render()
    {
        $query = $this->getSuccessfulAttempts();
        return view('livewire.admin.successful-logins',[
            'attempts' => $query->paginate(10,pageName:'successfulLogins-list-page'),
        ]);
    }
}
