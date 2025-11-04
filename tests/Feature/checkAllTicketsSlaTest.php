<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Actions\TicketManagement\TicketAdministration;
use App\Actions\TaskManagement\TaskAdministration;
use App\Models\ticket;

class checkAllTicketsSlaTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_check_all_ticket_slas(): void
    {
        $t = new TicketAdministration();
        $tn = ticket::where('id',6)->first();
        $r = $t->getRespondByDateTime($tn);
        //dd(date('d-m-Y H:i:s',strtotime($tn->created_at)));
        //dd($r);
    }
}
