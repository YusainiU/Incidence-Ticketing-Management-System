<?php

namespace App\Livewire;

use App\Actions\Steps\StepsUserRoles;
use Livewire\Component;
use App\Models\Roles;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

#[Title("Roles")]
class UserRoles extends Component
{

    use WithPagination;

    //public ?Roles $roles;
    public $filter = '';
    public $displayNameColumn = '';
    public $displayDescriptionColumn='';
    public $displayAccessColumn='';
    public $toggleStatus='';
    public $routes = [];
    public $allowed_routes = [];
    public $allow_edit = false;
    public $canEdit = false;
    public $isSuperAdmin = false;
  
    public function mount(StepsUserRoles $stepsUserRoles)
    {
        $access = $stepsUserRoles->checkAccess($this);
        $this->canEdit = $access['canEdit'];
        $this->isSuperAdmin = $access['isSuperAdmin'];         
         if(!sizeof($this->routes)){
            $this->prepareRoutes();
         }
    }

    public function prepareRoutes(){
        $allRoutes = Route::getRoutes();
        $routeNames = $allRoutes->getRoutesByName();
        $this->routes = array_keys($routeNames);   
    }

    public function setToggleStatus(string $toggle)
    {
        $this->toggleStatus = $toggle;
    }

    public function changeRoleStatus(Roles $role)
    {
        $role->active = !$role->active;
        $role->update(
            $role->only(['active'])
        );
        $this->redirect('/dashboard/userRoles', navigate:true);
    }

    public function changeName(Roles $role, string $newName)
    {
        if(trim($newName)){
            $role->name = $newName;
            $role->update(
                $role->only(['name'])
            );
            $this->redirect('/dashboard/userRoles', navigate:true);            
        }
    }

    public function changeDescription(Roles $role, string $newDesription)
    {
        if(trim($newDesription))
        {
            $role->description = $newDesription;
            $role->update(
                $role->only(['description'])
            );
            $this->redirect('/dashboard/userRoles', navigate:true);                 
        }
    }

    public function removeRoute(Roles $role, string $routeName)
    {
        $current = $role->allowed_routes;
        $edit = $role->allow_edit;
        $data = [];
        if($current){
            $e = explode(",",$current);
            $key = array_search($routeName, $e);
            unset($e[$key]);
            $new = '';
            if(sizeof($e)){
                $new = implode(",", $e);
            }
            $data['allowed_routes'] = $new;            
        }
        if($edit)
        {
            $d = explode(",",$edit);
            $dkey = array_search($routeName,$d);
            if($dkey)
            {
                unset($d[$dkey]);
                $newE = '';
                if(sizeof($d))
                {
                    $newE = implode(",",$d);
                }
                $data['allow_edit'] = $newE;
            }
        }
        if(count($data))
        {
            Roles::where('id', $role->id)->update($data);            
        }
        $this->redirect('/dashboard/userRoles', navigate:false);
    }

    public function resetFields()
    {
        $this->displayNameColumn = '';
        $this->displayDescriptionColumn = '';
        $this->displayAccessColumn = '';       
    }

    public function showNameField(Roles $role)
    {
        $this->displayNameColumn = $role->id;
    }

    public function showDescriptionField(Roles $role)
    {
        $this->displayDescriptionColumn = $role->id;
    }

    public function showAccessField(Roles $role)
    {
        $this->displayAccessColumn = $role->id;
    }    

    public function render()
    {
        
        $query = Roles::query();

        if($this->toggleStatus){
            if($this->toggleStatus == 'active'){
                $query->where('active','=', true)->get();        
            }
            if($this->toggleStatus == 'notActive')
            {
                $query->where('active','=', false)->get();        
            }
        }
        if($this->filter)
        {
            $filterValue = "%{$this->filter}%";
            $query->whereAny(['name','description',],'like',$filterValue)->get();               
        }

        return view('livewire.user-roles',[
            'roles' => $query->paginate(5,pageName: 'roles-list-page'),
        ]);
    }
}
