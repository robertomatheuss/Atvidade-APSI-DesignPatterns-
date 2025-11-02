<?php

namespace App\Listeners;

use App\Events\StockPriceChanged;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SmsPriceObserver
{
    public function handle(StockPriceChanged $event): void
    {
        if (!Cache::get("stocks:subs:{$event->symbol}")['sms'] ?? false) return;

        Log::info("[SMS] {$event->symbol} => {$event->price}");
        $this->appendLog('sms', $event->symbol, $event->price);
    }

    private function appendLog(string $channel, string $symbol, float $price): void
    {
        $key = 'stocks:observer_log';
        $log = Cache::get($key, []);
        $log[] = compact('channel','symbol','price');
        Cache::forever($key, $log);
    }
}
