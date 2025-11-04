<?php

namespace App\Livewire\Admin;

use App\Actions\Steps\StepsUserRoles;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class CacheTable extends Component
{

    use WithPagination;
    public $filter = '';
    public function mount(StepsUserRoles $stepsUserRoles)
    {
        $access = $stepsUserRoles->checkAccess($this);
    }

    public function getCache()
    {    
        
        $c = DB::table('cache');
        if($this->filter) {
            $filter = "%{$this->filter}%";
            $c->where('key','like',$filter)
            ->orWhere('value','like',$filter);
        }
        $c->orderByDesc('expiration');
        return $c;
        
    }

    public function clearCaches()
    {
        Cache::clear();
    }
    public function render()
    {
        $caches = $this->getCache();
        return view('livewire.admin.cache-table',[
            'caches' => $caches->paginate(10,pageName:'cache-list-page'),
        ]);
    }
}
