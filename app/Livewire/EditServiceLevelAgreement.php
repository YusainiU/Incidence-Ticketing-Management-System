<?php

namespace App\Livewire;

use App\Actions\Steps\StepsUserRoles;
use App\Models\serviceLevelAgreement;
use LivewireUI\Modal\ModalComponent;
use Livewire\Attributes\Validate;
use Carbon\CarbonPeriod;

class EditServiceLevelAgreement extends ModalComponent
{

    #[Validate('required')]
    public $name = '';
    #[Validate('required')]
    public $short_description = '';
    #[Validate('required')]
    public $start_day;
    #[Validate('required')]
    public $end_day;
    #[Validate('required')]
    public $service_start_time = '';
    #[Validate('required')]
    public $service_end_time = '';
    public $include_public_holiday = false;
    public $active = true;
    public $cover_details = '';
    public $daysOfWeek = [];
    #[Validate('required')]
    public $type = '';
    public $response_time = '';
    public $fixed_time = '';
    #[Validate('required:numeric')]
    public $response_time_hours = 0;
    #[Validate('required:numeric')]
    public $response_time_mins = 0;
    #[Validate('required:numeric')]
    public $fixed_time_hours = 0;
    #[Validate('required:numeric')]
    public $fixed_time_mins = 0;
    public $slaTypes = [];
    public ?serviceLevelAgreement $sla;
    public $canEdit = false;
    
    public function mount(StepsUserRoles $stepsUserRoles)
    {
        $access = $stepsUserRoles->checkAccess($this);
        $this->canEdit = $access['canEdit'];           
        $this->populateFields();
    }

    public function populateFields()
    {
        $this->name = $this->sla->name;
        $this->short_description = $this->sla->short_description;
        $this->start_day = $this->sla->start_day;
        $this->end_day = $this->sla->end_day;
        $this->service_start_time = $this->sla->service_start_time['formatted'];
        $this->service_end_time = $this->sla->service_end_time['formatted'];
        $this->response_time = serviceLevelAgreement::secondsToHIS($this->sla->response_time['seconds']);
        $this->response_time_hours = $this->sla->response_time['hours'];
        $this->response_time_mins = $this->sla->response_time['minutes'];
        $this->fixed_time = serviceLevelAgreement::secondsToHIS($this->sla->fixed_time['seconds']);
        $this->fixed_time_hours =  $this->sla->fixed_time['hours'];
        $this->fixed_time_mins = $this->sla->fixed_time['minutes'];
        $this->include_public_holiday = $this->sla->include_public_holiday == 'No' ? false : true;
        $this->active = $this->sla->active;
        $this->type = $this->sla->type;
    }

    public function getDaysOfWeek()
    {
        $days = CarbonPeriod::create(now()->startOfWeek(), now()->endOfWeek())->toArray();
        foreach ($days as $day) {
            $this->daysOfWeek[] = $day->format('l');
        }
    }

    public function save()
    {

        $this->validate();

        $respt = serviceLevelAgreement::convertTimeElementsToSeconds(
            $this->response_time_hours,
            $this->response_time_mins
        );
        $fixedt = serviceLevelAgreement::convertTimeElementsToSeconds(
            $this->fixed_time_hours,
            $this->fixed_time_mins
        );

        $this->service_start_time = serviceLevelAgreement::convertTimeToSecond($this->service_start_time);
        $this->service_end_time = serviceLevelAgreement::convertTimeToSecond($this->service_end_time);
        $this->response_time = $respt;
        $this->fixed_time = $fixedt;
        $this->include_public_holiday = $this->include_public_holiday ? 1:0;
        $this->sla->update(
            $this->only([
                'name',
                'short_description',
                'start_day',
                'end_day',
                'service_start_time',
                'service_end_time',
                'include_public_holiday',
                'response_time',
                'fixed_time',
            ])
        );
        $this->redirect(route('serviceLevelAgreementList', ['sla' => $this->sla]));
    }

    public function render()
    {
        $this->getDaysOfWeek();
        $this->slaTypes = config('steps.slaTypes');
        return view('livewire.edit-service-level-agreement');
    }
}
