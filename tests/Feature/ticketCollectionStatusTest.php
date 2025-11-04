<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\ticket;
use App\Actions\TicketManagement\TicketAdministration;

class ticketCollectionStatusTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $tickets = ticket::where('closed_datetime','!=',null)->get();
        //dd($tickets);
        $t = new TicketAdministration;
        $t->checkStatusForMultipleTickets($tickets);

    }
}
