<?php

namespace App\Livewire;

use App\Actions\Steps\StepsUserRoles;
use Livewire\Component;
use App\Models\User;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Title("User List")]
class UsersList extends Component
{

    use WithPagination;

    public $filter = '';
    public $toggleStatus = '';
    public $isUserAdmin = false;
    public $isAdmin = true;
    public $customers;

    public function mount(StepsUserRoles $stepsUserRoles){
        $access = $stepsUserRoles->checkAccess();
        $this->isAdmin = $access['isSuperAdmin'];
        if(!$this->isAdmin){
            $this->isAdmin = $access['isAdmin'];
        }
        $this->isUserAdmin = $access['canEdit'];
    }

    public function getCustomerCompanies(){
        $this->customers = User::customerCompanies()->get();
    }

    public function users()
    {
        return view('livewire.users-list',[
            'users' => User::all(),
        ]);
    }

    public function toggleActive(string $setToggle)
    {
        $this->toggleStatus = $setToggle;
    }

    /*
        Livewire Life Hook
    */
    public function updatingFilter()
    {
        $this->resetPage('user-list-page');
    }

    public function render()
    {
        
        $this->getCustomerCompanies();

        $query = User::query();

        if($this->filter)
        {
            $filterValue = "%{$this->filter}%";
            $query->whereAny(['name','phone_number','email','user_identity'],'like',$filterValue);    
        }

        if($this->toggleStatus){
            if($this->toggleStatus == 'active')
            {
                $query->where('active','=',true);
            }elseif($this->toggleStatus == 'notActive'){
                $query->where('active','=',false);
            }
        }

        $query->orderBy('name')->get();

        return view('livewire.users-list',[
            'users' => $query->paginate(10,pageName: 'user-list-page'),
        ]);
    }
}
