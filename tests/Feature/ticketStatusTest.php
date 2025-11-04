<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\ticket;
use App\Actions\TicketManagement\TicketAdministration;

class ticketStatusTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $t = new TicketAdministration();
        $ticket_id = 6;
        $tm = new ticket();
        $ticket = $tm->where('id','=',$ticket_id)->first();
        $t->retrieveTicketStatus($ticket);

    }
}
