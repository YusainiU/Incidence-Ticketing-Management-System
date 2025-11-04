<?php

namespace App\Livewire;

use App\Actions\Steps\StepsUserRoles;
use Illuminate\Support\Facades\Auth;
use App\Actions\TicketManagement\TicketAdministration;
use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\Customer;
use Illuminate\Support\Facades\Config;
class CreateNewTicket extends Component
{

    public ?Customer $customer;
    public $customer_id = '';
    public $sla_applications_id = '';
    public $customer_reference = '';
    public $category = '';
    public $source = '';
    public $list_of_assets = '';
    public $short_description = '';
    public $description = '';
    public $state = 'Open';
    public $contact_telephone = null;
    public $contact_email = null;
    //protected TicketAdministration $ticketAdmin;
    public $slaps;
    public $categories;
    public $sources;
    public $contacts;
    public $assets;
    public $selected_assets = [];
    public $nonuser = null;
    public $selected_contacts = [];
    public $canEdit = false;
    public $ferrors = [];

    public function mount(StepsUserRoles $stepsUserRoles)
    {
        $access = $stepsUserRoles->checkAccess($this);
        $this->canEdit = $access['canEdit'];            
        $this->slaps = $this->customer->slaApplications;
        $this->categories = Config::get('steps.ticketManagement.category');
        $this->sources = Config::get('steps.ticketManagement.source');
        $this->contacts = $this->customer->contacts->where('active','=',true);
        $this->assets = $this->customer->assets;

    }
 
    public function createNewTicket(TicketAdministration $tickerAdmin)
    {

        $this->ferrors = [];

        $currentUserId = Auth::id();
        $cancel = false;

        $listOfAssets = null;
        if(count($this->selected_assets) > 0){
            $listOfAssets = implode(",", $this->selected_assets);
        }else{
            $this->ferrors[]="No Asset Selected";
            $cancel = true;
        }
        
        $sysUser = $this->selected_contacts ?: null;
        if($sysUser)
        {
            $sysu = $this->contacts->where('id','=',$sysUser)->first();
            $this->contact_telephone = $sysu->phone_number;
            $this->contact_email = $sysu->email;
        }else{
            if($this->nonuser){
                if(!$this->contact_email && !$this->contact_telephone){
                    $this->ferrors[]="Contact Email/Telephone is Required";
                    $cancel=true;
                }
            }else{
                $this->ferrors[]="Contact is Required";
                $cancel=true;;
            }
        }

        if(!$this->short_description){
            $this->ferrors[]="Short Description is Required";
            $cancel=true;
        }

        if(!$this->description){
            $this->ferrors[]="Description is Required";
            $cancel=true;
        }

        if(!$this->sla_applications_id){
            $this->ferrors[]="Type (SLA) is required";
            $cancel=true;
        }

        if($cancel) return false;
        
        $data = [
            'ticket_number' => null,
            'customer_id' => $this->customer->id,
            'sla_applications_id' => $this->sla_applications_id,
            'customer_reference' => $this->customer_reference,
            'category' => $this->category,
            'created_by' => $currentUserId,
            'source' => $this->source,
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
        $this->redirect(route('ticketProfile',['ticket' => $ticket]));
        
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
        return view('livewire.create-new-ticket');
    }
}
