<?php


namespace App\Actions\Steps;

use App\Models\slaTask;
use App\Models\TaskSiteVisit;
use App\Models\ticket;
//use illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Calendar
{

    public $dateSelected;
    public $holidayDescription;

    public function getMonthDetails(int $month, int $year)
    {       
        $firstDayOfTheMonth = mktime(0,0,0,$month,1,$year);
        $firstDayOfTheWeek = date('w',$firstDayOfTheMonth);
        $numberOfDaysInTheMonth = date('t', $firstDayOfTheMonth);
        $date = getdate($firstDayOfTheMonth);
        $this->dateSelected = date('d-m-Y',$firstDayOfTheMonth);
        $monthName = $date['month'];
        $paddedMonthNumber = str_pad($month, 2, "0", STR_PAD_LEFT);
        $dayOfTheWeek = $date['wday'];
        $publicHolidays = $this->getPublicHolidays();
        $result = [
            'firstDayOfTheMonth' =>$firstDayOfTheMonth,
            'firstDayOfTheWeek' => $firstDayOfTheWeek,
            'numberOfDaysInTheMonth' => $numberOfDaysInTheMonth,
            'nameOfTheMonth' => $monthName,
            'paddedMonthNumber' => $paddedMonthNumber,
            'dayOfTheWeek' => $dayOfTheWeek,
            'publicHolidays' => $publicHolidays,
            'HolidayDescriptions' => $this->holidayDescription,
        ];
        return $result;
    }

    public function getAllDatesInAMonthOf($month, $year)
    {
        $days = cal_days_in_month(0, $month, $year);
        $start = 0;
        while($start <= $days)
        {
            $start++;
            $ts = strtotime("$year-$month-$start");
            $d = date('d-m-Y',$ts);
            $result[$start] = [
                'date' => $d,
                'weekNumber' => date('w',$ts),
            ];
        }
        return $result;
    }

    public function getEvents($date)
    {
        //Date format '2025-07-26';
        //$eTicketCreated = $this->eventsTicketCreatedOn($date);
        $eRespondBy = $this->eventsTicketRespondByOn($date);
        $eFixBy = $this->eventsTicketFixByOn($date);
        $eRespondByBreach = $this->eventsRespondByBreachOn($date);
        $eFixByBreach = $this->eventsFixByBreachOn($date);
        $eVisit = $this->eventsVisitScheduledOn($date);
        $eEnroute = $this->eventsEnrouteOn($date);
        $eOnsite = $this->eventsOnsiteOn($date);
        $eOffsite = $this->eventsOffsiteOn($date);

        $events = [
            'RespondBy' => $eRespondBy,
            'FixBy' => $eFixBy,
            'RespondByBreach' => $eRespondByBreach,
            'FixByBreach' => $eFixByBreach,
            'Visits' => $eVisit,
            'Enroute' => $eEnroute,
            'Onsite' => $eOnsite,
            'Offsite' => $eOffsite,
        ];
        
        return $events;
    }
    
    public function eventsTicketCreatedOn($date)
    {
        $r = ticket::where(DB::raw('DATE(`created_at`)'),'=',$date)
            ->where('closed_datetime','!=', null)
            ->get();
        return $r;
    }

    public function eventsTicketRespondByOn($date)
    {
        $r = slaTask::events()
            ->where(DB::raw('DATE(`respond_by`)'),'=',$date)
            ->get();
        return $r;
    }

    public function eventsTicketFixByOn($date)
    {
        $r = slaTask::events()
            ->where(DB::raw('DATE(`fix_by`)'),'=',$date)
            ->get();
        return $r;
    }

    public function eventsRespondByBreachOn($date)
    {
        $r = slaTask::events()
            ->where(DB::raw('DATE(`breached_at`)'),'=',$date)
            ->get();
        return $r;
    }    

    public function eventsFixByBreachOn($date)
    {
        $r = slaTask::events()
            ->where(DB::raw('DATE(`fix_by_breach_at`)'),'=',$date)
            ->get();
        return $r;
    }

    public function eventsVisitScheduledOn($date)
    {
        $r = TaskSiteVisit::visitEvents()->where(DB::raw('DATE(`visit_Scheduled_at`)'),'=',$date)->get();
        return $r;
    }

    public function eventsEnrouteOn($date)
    {
        $r = TaskSiteVisit::visitEvents() 
            ->where(DB::raw('DATE(`enroute_at`)'),'=',$date)
            ->get();
        return $r;
    }
    
    public function eventsOnsiteOn($date)
    {
        $r = TaskSiteVisit::visitEvents() 
            ->where(DB::raw('DATE(`onsite_at`)'),'=',$date)
            ->get();
        return $r;
    }
    
    public function eventsOffsiteOn($date)
    {
        $r = TaskSiteVisit::visitEvents()
            ->where(DB::raw('DATE(`offsite_at`)'),'=',$date)
            ->get();
        return $r;
    }    


    public function getDaysOfTheWeek()
    {
        $daysOfWeek = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
        return $daysOfWeek;
    }

    public function getPublicHolidays()
    {
        $publicHolidays = new PublicHoliday();
        $pubs = $publicHolidays->getPublicHolidays($this->dateSelected);
        $this->holidayDescription = $publicHolidays->holidayDetails;
        return $pubs;
    }

}