<?php

namespace Tests\Feature;

use App\Actions\TicketManagement\TicketAdministration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\ticket;

class getRespondByTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    // public function test_example(): void
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

    public function test_respondby()
    {
        $t = new TicketAdministration();
        $ticket_id = 2;
        $tm = new ticket();
        $ticket = $tm->where('id','=',$ticket_id)->first();
        $respBy = $t->getRespondByDateTime($ticket);
        $fixedBy = $t->getFixByDateTime($ticket);
        dd("Respond By:$respBy -- Fixed By:$fixedBy");
        
        
    }
}
