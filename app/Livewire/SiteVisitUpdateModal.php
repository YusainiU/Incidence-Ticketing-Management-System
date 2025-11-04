<?php

namespace App\Livewire;

use App\Actions\TicketManagement\TicketAdministration;
use LivewireUI\Modal\ModalComponent;
use App\Models\TaskSiteVisit;
use App\Models\User;
use Livewire\Attributes\Validate;


class SiteVisitUpdateModal extends ModalComponent
{
    public TaskSiteVisit $siteVisit;
    public $internalUsers;
    #[Validate("required")]
    public $short_description = '';
    #[Validate("required")]
    public $assigned_to = '';
    #[Validate("required")]
    public $scheduled_date = '';
    #[Validate("required_with:scheduled_date")]
    public $scheduled_time = '';
    public $description = '';
        #[Validate("required_with:enroute_time")]
    public $enroute_date = '';
    #[Validate("required_with:enroute_date")]
    public $enroute_time = '';
    public $onsite_date = '';
    #[Validate("required_with:onsite_date")]
    public $onsite_time = '';
    public $offsite_date = '';
    #[Validate("required_with:offsite_date")]
    public $offsite_time = '';    

    public function mount()
    {
        $this->internalUsers = User::getActiveInternalUsers();        
    }

    private function initFields()
    {
        $now_date = date('Y-m-d',time());
        $now_time = date('H:i',time());
        $this->short_description = $this->siteVisit->short_description;
        $this->assigned_to = $this->siteVisit->assigned_to;
        $this->scheduled_date = date('Y-m-d', strtotime($this->siteVisit->visit_scheduled_at));
        $this->scheduled_time = date('H:i', strtotime($this->siteVisit->visit_scheduled_at));
        $this->description = $this->siteVisit->description;             
        if($this->siteVisit->enroute_at){
            $this->enroute_date = date('Y-m-d', strtotime($this->siteVisit->enroute_at));
            $this->enroute_time = date('H:i', strtotime($this->siteVisit->enroute_at));
        }
        if($this->siteVisit->onsite_at){
            $this->onsite_date = date('Y-m-d', strtotime($this->siteVisit->onsite_at));
            $this->onsite_time = date('H:i', strtotime($this->siteVisit->onsite_at));
        }
        if($this->siteVisit->offsite_at){
            $this->offsite_date = date('Y-m-d', strtotime($this->siteVisit->offsite_at));
            $this->offsite_time = date('H:i', strtotime($this->siteVisit->offsite_at));
        }                  
    }
    public function save(TicketAdministration $ticketAdministration)
    {
        $this->validate();

        $usr = $this->assigned_to;
        $objUsr = json_decode($usr);
        $usrid = is_object($objUsr) ? $objUsr->id : $usr;

        $schtime = date('Y-m-d H:i:s', strtotime("$this->scheduled_date $this->scheduled_time"));
        
        $data = [
            'short_description' => $this->short_description,
            'assigned_to' => $usrid,
            'description' => $this->description,
            'visit_scheduled_at' => $schtime,
            'enroute_at' => null,
            'onsite_at' => null,
            'offsite_at' => null,
        ];
        if($this->enroute_date)
        {
            $enrtime = date('Y-m-d H:i:s',strtotime("$this->enroute_date $this->enroute_time"));
            $data['enroute_at'] = $enrtime;
        }        
        if($this->onsite_date)
        {
            $onstime = date('Y-m-d H:i:s',strtotime("$this->onsite_date $this->onsite_time"));
            $data['onsite_at'] = $onstime;
        }
        if($this->offsite_date)
        {
            $offtime = date('Y-m-d H:i:s',strtotime("$this->offsite_date $this->offsite_time"));
            $data['offsite_at'] = $offtime;
        }

        $ticketAdministration->updateSiteVisit($this->siteVisit, $data);

        $this->dispatch('visitHasBeenUpdated');

        $this->closeModal();

    }
    
    public function delete(TicketAdministration $ticketAdministration)
    {
        $ticketAdministration->logVisitDeletion($this->siteVisit);
        
        $this->siteVisit->delete();

        $this->dispatch('visitHasBeenUpdated');

        $this->closeModal();

    }

    public function render()
    {
        $this->initFields();
        return view('livewire.site-visit-update-modal');
    }
}
