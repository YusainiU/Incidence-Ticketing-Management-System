<?php

namespace App\Livewire;

use App\Actions\Steps\StepsUserRoles;
use Illuminate\Container\Attributes\Config;
use Livewire\Component;
use App\Models\Customer;
use App\Models\slaApplication;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Exports\ticketExport;
use Maatwebsite\Excel\Facades\Excel;


class CustomerProfile extends Component
{
    public ?Customer $customer;
    public $contactsWithRoles;
    public $tickets;
    public $closedTickets;
    public $selectedTab = '';
    public $active = true;

    public $displayModal = false;

    public $assets = [];
    public $slas;
    public $canEdit = false;
    public $slaAssetWarning = [];
    public $mapQuery = '';

    public function mount(StepsUserRoles $stepsUserRoles)
    {
        $this->slaAssetWarning = [];
        $access = $stepsUserRoles->checkAccess($this);
        $this->canEdit = $access['canEdit'];          
        $this->active = $this->customer->active;
        $this->getAssets($this->customer);
        $this->getSlas($this->customer);
        $this->getCustomerContactsWithRoles($this->customer);
        $this->tickets = $this->customer->tickets;
        $this->buildAddressMap();

        //Check whether customer has folder
        $folder = $stepsUserRoles->checkCustomerFolder($this->customer);
        if(!$folder)
        {
            $folder = $stepsUserRoles->createCustomerFolder($this->customer);             
        }
        session()->put('currentFolderId', $folder->id);       
    }

    public function buildAddressMap()
    {
        $f = ['address_1','address_2','address_3'];
        $a = [];
        foreach($f as $v)
        {
            if($this->customer->$v){
                $a[]=$this->customer->$v;
            }
        }
        if(sizeof($a)){
            $m = implode("+",$a);
            $m = str_replace(' ','+', $m);
            $m = "https://www.google.com/maps?q={$m}";
            $this->mapQuery = $m;
        }
    }

    public function exportOpenTickets()
    {
        $t = env('TICKET_MONIKER_PLURAL');
        $n = str_replace(' ','_',$this->customer->name);
        $n = str_replace(" ","_","All $t $n");

        $exp = new ticketExport($this->customer);
        return Excel::download($exp,"$n.xls");
    }

    public function showModal(bool $show)
    {
        $this->displayModal = $show;

    }

    public function getSlas(Customer $customer)
    {
        $this->slas = slaApplication::getCustomerSlas($customer);
        
        if(!$this->slas->toArray()){
            $this->slaAssetWarning[] = "There is no Service Level Agreement is associated with this site";
        }
    }

    public function getAssets(Customer $customer)
    {

        $assets = DB::table('assets')
            ->join('suppliers', 'assets.supplier_id', '=', 'suppliers.id')
            ->join('products', 'assets.product_id', '=', 'products.id')
            ->select('assets.*', 'suppliers.name as supplier_name', 'products.name as product_name')
            ->where('assets.customer_id','=',$customer->id)
            ->orderBy('assets.short_description')
            ->get()
            ->toArray();

        $this->assets = array_values($assets);
        if(!$this->assets){
            $this->slaAssetWarning[] = 'There is no Asset Associated with this site';
        }

    }

    public function getCustomerContactsWithRoles(Customer $customer)
    {
        $this->contactsWithRoles = User::join('customer_contacts', 'users.id', '=', 'customer_contacts.user_id')
            ->where('users.user_identity', '=', 'customer')
            ->where('users.customer_id', '=', $customer->id)
            ->get();
            if(!$this->contactsWithRoles->toArray()){
                $this->slaAssetWarning[]="There is no contact with roles associated with this site";
            }
    }

    public function deactivate()
    {
        $this->customer->update(['active' => false]);
        $this->redirect(route('customerProfile', ['customer' => $this->customer]));
    }

    public function activate()
    {
        $this->customer->update(['active' => true]);
        $this->redirect(route('customerProfile', ['customer' => $this->customer]));
    }

    public function selectTab(string $tab)
    {
        $this->selectedTab = $tab;
    }

    public function render()
    {
        // $this->getCustomerContactsWithRoles($this->customer);
        return view('livewire.customer-profile');
    }
}
