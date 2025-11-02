<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class StockObserverTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Cache::forget('stocks:observer_log');
        Cache::forget('stocks:subs:AAPL');
    }

    public function test_unsubscribe_stop_notifications(): void
    {
        // inscreve e depois cancela
        $this->postJson('/stocks/subscribe', [
            'symbol'=>'AAPL','channel'=>'email'
        ]);
        $this->postJson('/stocks/unsubscribe', [
            'symbol'=>'AAPL','channel'=>'email'
        ]);

        $this->postJson('/stocks/price', [
            'symbol'=>'AAPL','price'=>200
        ]);

        $log = Cache::get('stocks:observer_log', []);
        // não deve ter log para email
        $this->assertTrue(collect($log)->where('channel','email')->isEmpty());
    }
}
