<?php

namespace App\Livewire\Customer;

use App\Actions\Steps\StepsUserRoles;
use App\Actions\TicketManagement\TicketAdministration;
use App\Models\Customer;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CustomerCreateTicket extends Component
{

    public $customer_id;
    public $customer;
    public $slaps;
    public $categories;
    public $sources;
    public $assets;
    public $selected_assets = [];
    public $sla_applications_id = '';
    public $customer_reference = '';
    public $selected_contacts;
    public $category = '';
    public $source = '';
    public $list_of_assets = '';
    public $short_description = '';
    public $description = '';
    public $state = 'Open';
    public $contacts;
    public $nonuser;    

    public function mount(StepsUserRoles $stepsUserRoles)
    {
        $this->customer_id = $stepsUserRoles->checkCustomer();
        $this->customer = Customer::find($this->customer_id);
        $this->slaps = $this->customer->slaApplications;
        $this->categories = Config()->get('steps.ticketManagement.category');
        $this->sources = Config()->get('steps.ticketManagement.source');
        $this->contacts = $this->customer->contacts->where('active','=',true);
        $this->assets = $this->customer->assets;
    }

    public function createNewTicket(TicketAdministration $tickerAdmin)
    {

        $currentUserId = Auth::id();

        $listOfAssets = null;
        if(count($this->selected_assets) > 0){
            $listOfAssets = implode(",", $this->selected_assets);
        }
        
        $sysUser = $this->selected_contacts ?: null;
        if($sysUser)
        {
            $sysu = $this->contacts->where('id','=',$sysUser)->first();
            $this->contact_telephone = $sysu->phone_number;
            $this->contact_email = $sysu->email;
        }

        
        $data = [
            'ticket_number' => null,
            'customer_id' => $this->customer->id,
            'sla_applications_id' => $this->sla_applications_id,
            'customer_reference' => $this->customer_reference,
            'category' => $this->category,
            'created_by' => $currentUserId,
            'source' => 'Portal',
            'list_of_assets' => $listOfAssets,
            'short_description' => $this->short_description,
            'description' => $this->description,
            'state' => $this->state,
            'raised_by_user' => $sysUser,
            'raised_by_nonuser' => $this->nonuser,
            'contact_telephone' => $this->contact_telephone,
            'contact_email' => $this->contact_email,
        ];
        $ticket = $tickerAdmin->createNewTicket($data);
        $this->redirect(route('customerTicketProfile',['ticket' => $ticket]));
        
    }
    
    public function resetContactValues()
    {
        $this->nonuser = '';
        $this->selected_contacts = [];
        $this->contact_telephone = '';
        $this->contact_email = '';
    }    
    public function render()
    {
        return view('livewire.customer.customer-create-ticket');
    }
}
