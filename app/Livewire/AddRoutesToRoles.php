<?php

namespace App\Livewire;

use App\Actions\Steps\StepsUserRoles;
use App\Models\Roles;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\Config;

class AddRoutesToRoles extends ModalComponent
{

    public Roles $role;
    public $routes = [];
    public $allRoutes = [];
    public $existing = '';
    public $allRoutesFromConfig = [];
    public $routeName = '';
    public $isSuperAdmin = false;

    public static function modalMaxWidth(): string
    {
        return '2xl';
    }    

    public function prepareRoutes()
    {
        $allRoutes = Route::getRoutes();
        $routeNames = $allRoutes->getRoutesByName();
        $this->allRoutes = array_unique(array_keys($routeNames));
        $this->allRoutesFromConfig = Config::get('steps.routes');
        if($this->role->allowed_routes)
        {
            $e = explode(",", $this->role->allowed_routes);
            foreach($e as $v)
            {
                $key = array_search($v, $this->allRoutesFromConfig);
                if($key)
                {
                    unset($this->allRoutesFromConfig[$key]);
                }
            }
        }

        array_multisort($this->allRoutesFromConfig);        
    }

    public function addRouteToRole(Request $request)
    {
        $this->role = Roles::where('id',$request->input('role'))->get()->first();         
        $selected = $request->input('MultiSelectRoute_'.$this->role->id);
        $allowEdit = $request->input('allow_edit');
        $current = $this->role->allowed_routes;
        $currentEdit = $this->role->allow_edit;
        $addAll = false;
        //======================================

        if($selected == 'add_all')
        {
            //Add All Routes
            $all = Config::get('steps.routes');
            $selected = implode(",",array_values($all));
            $current = null;
            $addAll = true;
        }     
        
        $data['allowed_routes'] = $this->buildRouteString($selected, $current);
        if($allowEdit)
        {
            $data['allow_edit'] = $this->buildRouteString($selected, $currentEdit);
        }else{
            if($addAll)
            {
                $data['allow_edit'] = null;
            }
        }             
        Roles::where('id', $this->role->id)->update($data);
        return redirect()->route('adminDashboard',['openContent' => 'rolesAdmin']);
    }

    private function buildRouteString(string $selected, string $current = null)
    {
        $eu = [];
        if($current)
        {
            $eu = explode(",", $current);            
        }
        
        $eu[] = $selected;
        $new = array_unique($eu);
        $routeString = implode(",", $new);
        return $routeString;                
    }
    
    public function mount(StepsUserRoles $stepsUserRoles)  
    {
        $access = $stepsUserRoles->checkAccess($this);
        $this->routeName = $access['route'];
        $this->isSuperAdmin = $access['isSuperAdmin'];
        $this->prepareRoutes();
    }

    public function render()
    {
        return view('livewire.add-routes-to-roles');
    }
}
