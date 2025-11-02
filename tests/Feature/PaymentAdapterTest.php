<?php

namespace Tests\Feature;

use App\Services\PaymentAdapter\Adapter\NewPaymentAdapter;
use App\Services\PaymentAdapter\LegacyPaymentProcessor;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaymentAdapterTest extends TestCase
{
    use WithFaker;

    public function test_container_binds_legacy_to_adapter(): void
    {
        $impl = app(LegacyPaymentProcessor::class);
        $this->assertInstanceOf(NewPaymentAdapter::class, $impl);
    }

    public function test_api_process_payment_ok(): void
    {
        $payload = [
            'orderId' => 'ORD-'.mt_rand(1000,9999),
            'amount'  => 100.50,
        ];

        $res = $this->postJson('/payments', $payload);

        $res->assertOk()
            ->assertJson(['ok' => true]);
    }

    public function test_api_validation_error(): void
    {
        $res = $this->postJson('/payments', [
            'orderId' => '',
            'amount'  => 0,
        ]);

        $res->assertStatus(422);
    }
}
