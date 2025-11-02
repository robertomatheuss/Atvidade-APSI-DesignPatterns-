<?php

namespace Tests\Feature;

use Tests\TestCase;

class OrderFacadeTest extends TestCase
{
    public function test_place_order_ok(): void
    {
        $payload = [
            'customer' => ['id'=>'C1','name'=>'Dani','email'=>'dani@ex.com'],
            'products' => [
                ['id'=>'P1','name'=>'Livro','price'=>40.0,'qty'=>2],
                ['id'=>'P2','name'=>'Caderno','price'=>10.0,'qty'=>1],
            ],
        ];

        $res = $this->postJson('/orders/place', $payload);

        $res->assertOk()
            ->assertJsonPath('ok', true)
            ->assertJsonStructure(['orderId','total','payment','notes']);
    }

    public function test_place_order_invalid_customer(): void
    {
        $payload = [
            'customer' => ['id'=>'C1','name'=>'','email'=>'email-invalido'],
            'products' => [['id'=>'P1','name'=>'Livro','price'=>40.0,'qty'=>1]],
        ];

        $res = $this->postJson('/orders/place', $payload);
        $res->assertStatus(422); // validação do controller
    }

    public function test_place_order_no_stock(): void
    {
        // qty 10 > 5 (regra do ProductService), deve falhar
        $payload = [
            'customer' => ['id'=>'C1','name'=>'Dani','email'=>'dani@ex.com'],
            'products' => [['id'=>'P1','name'=>'Livro','price'=>40.0,'qty'=>10]],
        ];

        $res = $this->postJson('/orders/place', $payload);

        // 422 vindo do retorno da facade (ok=false)
        $res->assertStatus(422)
            ->assertJsonPath('ok', false);
    }
}
