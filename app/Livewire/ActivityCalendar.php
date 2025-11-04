<?php

namespace App\Livewire;

use App\Actions\Steps\Calendar;
use App\Actions\Steps\StepsUserRoles;
use Livewire\Component;

class ActivityCalendar extends Component
{

    public $selectedMonth;
    public $selectedYear;
    public $monthDetails;
    public $daysOftheWeek;
    public $totalRows = 6;
    public $events;
    public function mount(StepsUserRoles $stepsUserRoles)
    {        
        $stepsUserRoles->checkInternalUser();
        $this->initCalendar(time());
    }

    public function currentMonth()
    {
        $this->initCalendar(time());
    }

    public function nextMonth()
    {
        if($this->selectedMonth == 12){
            $this->selectedYear++;
            $this->selectedMonth = 1;
        }else{
            $this->selectedMonth++;
        }
        $ts = mktime(0,0,0,$this->selectedMonth,1,$this->selectedYear);
        $this->initCalendar($ts);
    }

    public function previousMonth()
    {
        if($this->selectedMonth == 1){
            $this->selectedYear--;
            $this->selectedMonth=12;
        }else{
            $this->selectedMonth--;
        }
        $ts = mktime(0,0,0,$this->selectedMonth,1,$this->selectedYear);
        $this->initCalendar($ts);
    }

    public function initCalendar(int $timestamp)
    {
        $this->getMonthAndYear($timestamp);
        $this->buildCalendar();
    }

    public function getMonthAndYear(int $timestamp)
    {
        $calendar = new Calendar();
        $this->selectedMonth = date('n', $timestamp);
        $this->selectedYear = date('Y', $timestamp);
        $this->monthDetails = $calendar->getMonthDetails($this->selectedMonth, $this->selectedYear);
        $this->daysOftheWeek = $calendar->getDaysOfTheWeek();
    }

    public function buildCalendar()
    {

        $calendar = new Calendar();

        $rowCounter = 0;
        $cellCounter = 0;
        $dateCounter = 0;
        $firstDayIdentified = false;
        $cell = [];

        $month = $this->monthDetails;
        $firstDayOfTheWeek = $month['firstDayOfTheWeek'];
        $numberOfDaysInTheMonth = $month['numberOfDaysInTheMonth'];
        
        while($rowCounter < $this->totalRows){
            $rowCounter++;
            foreach($this->daysOftheWeek as $dayNumber => $dayName){
                $cellCounter++;
                //Identify the cell for the first day of the month
                if(!$firstDayIdentified){
                    if(intval($dayNumber) == $firstDayOfTheWeek){                        
                        $firstDayIdentified = true;
                        $dateCounter++;
                        $date = date('d-m-Y', strtotime("$this->selectedYear-$this->selectedMonth-$dateCounter"));
                        $rc = $this->getEvents($calendar,$date);
                        $cell[$cellCounter] = $rc;
                    }
                }else{
                    if($firstDayIdentified && $dateCounter < $numberOfDaysInTheMonth){
                        $dateCounter++;                    
                        $date = date('d-m-Y', strtotime("$this->selectedYear-$this->selectedMonth-$dateCounter"));
                        $rc = $this->getEvents($calendar,$date);
                        $cell[$cellCounter] = $rc;
                    }                    
                }
            }
        }
        $this->events = $cell;
    }

    public function getEvents(Calendar $calendar, $date)
    {
        $rv = date('Y-m-d', strtotime($date));
        $e = $calendar->getEvents($rv);
        $respondBy = $e['RespondBy'];
        $RespondByBreach = $e['RespondByBreach'];
        $FixBy = $e['FixBy'];
        $Visit = $e['Visits'];
        $Enroute = $e['Enroute'];
        $Onsite = $e['Onsite'];
        $Offsite = $e['Offsite'];
        return [
            'Date' => $date,
            'RespondBy' => !$respondBy->isEmpty() ? $respondBy : null,
            'RespondByBreach' => !$RespondByBreach->isEmpty() ? $RespondByBreach : null,
            'FixBy' => !$FixBy->isEmpty() ? $FixBy : null,
            'Visit' => !$Visit->isEmpty() ? $Visit : null,
            'Enroute' => !$Enroute->isEmpty() ? $Enroute : null,
            'Onsite' => !$Onsite->isEmpty() ? $Onsite : null,
            'Offsite' => !$Offsite->isEmpty() ? $Offsite : null,
        ];
    }

    public function render()
    {
        return view('livewire.activity-calendar');
    }
}
