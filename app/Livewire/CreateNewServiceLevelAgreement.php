<?php

namespace App\Livewire;

use App\Actions\Steps\StepsUserRoles;
use LivewireUI\Modal\ModalComponent;
use Livewire\Attributes\Validate;
use App\Models\serviceLevelAgreement;
use Carbon\CarbonPeriod;

class CreateNewServiceLevelAgreement extends ModalComponent
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

    #[Validate('required:numeric')]
    public $response_time_hours = 0;
    #[Validate('required:numeric')]
    public $response_time_mins = 0;
    #[Validate('required:numeric')]
    public $fixed_time_hours = 0;
    #[Validate('required:numeric')]
    public $fixed_time_mins = 0;
    public $include_public_holiday = false;
    public $active = true;
    public $cover_details = '';
    public $daysOfWeek = [];
    #[Validate('required')]
    public $type = '';
    public $response_time = '';
    public $fixed_time = '';
    public $slaTypes = [];
    public $canEdit = false;

    public function mount(StepsUserRoles $stepsUserRoles)
    {
        $access = $stepsUserRoles->checkAccess($this);
        $this->canEdit = $access['canEdit'];          
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

        $startInSecs = serviceLevelAgreement::convertTimeToSecond($this->service_start_time);
        $endInSecs = serviceLevelAgreement::convertTimeToSecond($this->service_end_time);

        $input = [
            'name' => $this->name,
            'short_description' => $this->short_description,
            'sla_key' => null,
            'start_day' => $this->start_day,
            'end_day' => $this->end_day,
            'service_start_time' => $startInSecs,
            'service_end_time' => $endInSecs,
            'active' => $this->active,
            'include_public_holiday' => $this->include_public_holiday,
            'type' => $this->type,
            'response_time' => $respt,
            'fixed_time' => $fixedt,
        ];
        $sla = ServiceLevelAgreement::create($input);
        $this->redirect(route('serviceLevelAgreementList', ['sla' => $sla]));
    }

    public function render()
    {
        $this->getDaysOfWeek();
        $this->slaTypes = config('steps.slaTypes');
        return view('livewire.create-new-service-level-agreement');
    }
}
