<?php

namespace Tests\Feature;

use Tests\TestCase;

class DiscountStrategyTest extends TestCase
{
    public function test_percent_discount()
    {
        $res = $this->postJson('/discount', [
            'amount' => 100,
            'type' => 'percent',
            'value' => 10
        ]);

        $this->assertEquals(90.0, $res->json('final'));

    }

    public function test_fixed_discount()
    {
        $res = $this->postJson('/discount', [
            'amount' => 100,
            'type' => 'fixed',
            'value' => 20
        ]);
        $this->assertEquals(80.0, $res->json('final'));

        #$res->assertOk()->assertJsonPath('final', 80.0);
    }

    public function test_buy_x_get_y()
    {
        $res = $this->postJson('/discount', [
            'amount' => 30,
            'type' => 'buyxgety',
            'x' => 2,
            'y' => 1,
            'unit' => 10,
        ]);
        $this->assertEquals(20.0, $res->json('final'));

        #$res->assertOk()->assertJsonPath('final', 20.0); 
    }
}
