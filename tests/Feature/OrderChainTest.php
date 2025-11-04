<?php
namespace Tests\Feature;

use Tests\TestCase;

class OrderChainTest extends TestCase
{
    public function test_sucesso_calcula_subtotal()
    {
        $res = $this->postJson('/orders/simple-chain', [
            'items' => [
                ['sku'=>'A1','qty'=>2,'price'=>50.0],
                ['sku'=>'B2','qty'=>1,'price'=>20.0],
            ],
        ]);

        $res->assertOk();
        $this->assertTrue($res->json('ok'));
        $this->assertEquals(120, $res->json('order.subtotal')); 
    }

    public function test_falha_estoque_insuficiente_interrompe()
    {
        $res = $this->postJson('/orders/simple-chain', [
            'items' => [
                ['sku'=>'A1','qty'=>7,'price'=>10.0], 
            ],
        ]);

        $res->assertStatus(422);
        $this->assertFalse($res->json('ok'));
        $this->assertNull($res->json('order.subtotal')); // não passa no PricingCalculator
    }
}
