<?php

namespace App\Livewire;

use App\Actions\Steps\StepsUserRoles;
use Livewire\Attributes\Validate;
use App\Models\Roles;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\Route;

class CreateNewRole extends ModalComponent
{

    public ?Roles $role;

    #[Validate('required')]
    public $name;
    #[Validate('required')]
    public $description;
    public $active = true;
    public $canEdit = false;

    public function mount(StepsUserRoles $stepsUserRoles)
    {
        $access = $stepsUserRoles->checkAccess($this);
        $this->canEdit = $access['canEdit'];

    }

    public function isDuplicated()
    {
        $names = Roles::select('name')->get()->toArray();
        $n = str_replace(' ', '', strtolower($this->name));
        $exist = false;
        foreach ($names as $nn) {
            $nnn = str_replace(' ', '', strtolower($nn['name']));
            if ($nnn == $n) {
                $exist = true;
                break;
            }
        }
        if ($exist) {
            return true;
        }
        return false;
    }

    public function createNewRole()
    {

        $this->validate();

        $isDuplicated = $this->isDuplicated();

        if (!$isDuplicated) {

            Roles::create($this->only([
                'name',
                'description',
                'active',
            ]));

            return redirect()->route('adminDashboard', ['openContent' => 'rolesAdmin']);
        }else{
            $this->addError('name','Duplicated Name');
        }
    }

    public function render()
    {
        return view('livewire.create-new-role');
    }
}
