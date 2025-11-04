<?php 

namespace App\Livewire\Customer;


use App\Models\Asset;
use App\Actions\Steps\StepsUserRoles;
use Livewire\Component;
use App\Actions\TicketManagement\TicketAdministration;
use App\Models\ticket;

class CustomerTicketProfile extends Component
{

    public ?ticket $ticket;
    public $assets;
    public $note = '';
    public $ticketStatusInformation;
    public $additionalInformation;
    public $actionExecuted = false;
    public $failures;
    public $ticketDuration = 0;
    public $selectedTab = '';



    public function mount(StepsUserRoles $stepsUserRoles, TicketAdministration $ticketAdministration)
    {
        $this->customer_id = $stepsUserRoles->checkCustomer();
        $this->ticketStatusInformation = $ticketAdministration->retrieveTicketStatus($this->ticket);
        $this->getAssets();
    }

    public function doAction(TicketAdministration $ticketAdministration)
    {
        //Create Progress Log
        if (trim($this->note)) {
            $log = $ticketAdministration->createProgressLog(
                $this->ticket,
                $this->note,
                true,
                false
            );
            if ($log) {
                $log->source = Config()->get('steps.logs.source.external');
                $log->save();
                $addInf[] = "Successfully added the progress log";
                $notify = $this->ticket->assignedTo;
                if($notify)
                {
                    $notify['name'] = $notify->name;
                    $notify['email'] = $notify->email;
                    $ticketAdministration->emailProgressNotification($this->ticket,$log,$this->note,$notify);
                }
                $this->actionExecuted = true;
                $this->note = '';                

            } else {
                $this->failures = "Error when adding the progress log";
            }
        }
    }

    public function checkResponseTime(TicketAdministration $util)
    {
        $this->ticketDuration = $util->timeFromCreate($this->ticket);
    }    

    public function getAssets()
    {
        $assets = $this->ticket->list_of_assets;
        if ($assets) {
            $a = explode(",", $assets);
            $this->assets = Asset::listAssets($a);
        }
    }
    
    public function selectTab(string $tab)
    {
        $this->selectedTab = $tab;
    }    
    
    public function render()
    {
        return view('livewire.customer.customer-ticket-profile');
    }
}
