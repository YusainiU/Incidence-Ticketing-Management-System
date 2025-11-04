<?php

namespace App\Livewire\Admin;

use App\Actions\Steps\StepsUserRoles;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class ConfigurationList extends Component
{

    public $showMore = '';

    public function mount(StepsUserRoles $stepsUserRoles)
    {
        $access = $stepsUserRoles->checkAccess($this);
    }

    public function getConfigs()
    {
        $cfg = Config::get('steps');
        return $cfg;
    }

    public function showChild(string $key)
    {
        dd($key);
        $this->showMore = $key;
    }

    public function render()
    {
        $cfg = $this->getConfigs();
        return view('livewire.admin.configuration-list',['configs' => $cfg]);
    }
}
