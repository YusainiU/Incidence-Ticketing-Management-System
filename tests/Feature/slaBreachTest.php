<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Actions\TicketManagement\TicketAdministration;
use App\Actions\TaskManagement\TaskAdministration;
use App\Models\ticket;
use App\Models\slaTask;

// use App\Models\Customer;
// use App\Exports\ticketExport;
// use Maatwebsite\Excel\Facades\Excel;  

class slaBreachTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_sla_breach(): void
    {
        
        $t = new TicketAdministration();
        $tsk = slaTask::where('id','=',5)->first();
        $r = $t->checkSlaBreach($tsk);
       //dd($r);

        // $customer = Customer::find(1);
        // $f = Excel::download(new ticketExport($customer),'excelTest.xls');
        // dd($f);        
        
    }
}
