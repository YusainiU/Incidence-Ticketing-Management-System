<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Asset;

class DbQueryTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        //['asset_number', 'short_description', 'supplier_id', 'customer_id', 'active']
        //$query = Asset::query();
        $qq = "%{omnis}%";


        $query = Asset::query();
        $query->where('product_id','like',$qq)
        ->orWhereHas('product', function($q) use($qq){
            $q->where('name','like', $qq);
        });

        dd($query->get()->toArray());
    }
}
