<?php

namespace Tests\Feature;

use Tests\TestCase;

class PaymentTemplateTest extends TestCase
{
    public function test_credit_card_ok()
    {
        $res = $this->postJson('/payments/template', [
            'method'  => 'credit_card',
            'payerId' => 'U1',
            'amount'  => 123.45,
            'card'    => '4111111111111111',
        ]);

        $res->assertOk()
            ->assertJsonPath('ok', true)
            ->assertJsonStructure(['tx','gateway','amount']);
    }

    public function test_paypal_ok()
    {
        $res = $this->postJson('/payments/template', [
            'method'       => 'paypal',
            'payerId'      => 'U2',
            'amount'       => 50.00,
            'paypal_email' => 'user@example.com',
        ]);

        $res->assertOk()
            ->assertJsonPath('ok', true)
            ->assertJsonStructure(['tx','gateway','amount']);
    }

}
