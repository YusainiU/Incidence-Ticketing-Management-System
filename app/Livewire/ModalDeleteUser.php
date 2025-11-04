<?php

namespace App\Livewire;

use App\Actions\Steps\StepsUserRoles;
use Livewire\Component;
use App\Models\User;
use LivewireUI\Modal\ModalComponent;

class ModalDeleteUser extends ModalComponent
{

    public ?User $userToDelete;
    public User $user;

    public function mount(StepsUserRoles $stepsUserRoles)
    {
        $access = $stepsUserRoles->checkAccess($this);
        $this->canEdit = $access['canEdit'];                
        $this->user = $this->userToDelete;
        
    }

    public function deleteUser()
    {
        $this->user->delete();
        $this->redirect('/dashboard', navigate: true);
    }

    public function render()
    {
        return view('livewire.modal-delete-user');
    }
}
