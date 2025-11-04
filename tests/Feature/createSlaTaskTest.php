<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Actions\TicketManagement\TicketAdministration;
use App\Actions\TaskManagement\TaskAdministration;
use App\Models\ticket;
class createSlaTaskTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_create_sla_tas(): void
    {
        $t = new TicketAdministration();
        $tsk = new TaskAdministration();
        $ticket_id = 1;
        $tm = new ticket();
        $ticket = $tm->where('id','=',$ticket_id)->first();
        $respBy = $t->getRespondByDateTime($ticket);
        $fixedBy = $t->getFixByDateTime($ticket);
        $tsk->createNewTicketSlaTask($ticket,$respBy,$fixedBy);        
        dd($tsk);
    }
}
