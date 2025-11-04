<?php

namespace App\Livewire\Admin;

use App\Actions\Steps\StepsUserRoles;
use Illuminate\Support\Facades\Route;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\WithPagination;
use Illuminate\Support\Collection;
use Livewire\Component;

class RouteList extends Component
{

    use WithPagination;
    public function mount(StepsUserRoles $stepsUserRoles)
    {
        $access = $stepsUserRoles->checkAccess($this);
    }

    public function getRouteList()
    {
        $r = Route::getRoutes()->getRoutesByName();
        return $r;
    }

    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }    

    public function render()
    {
        $t = $this->getRouteList();
        $t_routes = $this->paginate($t, 10);
        return view('livewire.admin.route-list',[
            't_routes' => $t_routes,
        ]);
    }
}
