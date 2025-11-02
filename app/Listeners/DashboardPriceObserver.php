<?php

namespace App\Listeners;

use App\Events\StockPriceChanged;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class DashboardPriceObserver
{
    public function handle(StockPriceChanged $event): void
    {
        if (!Cache::get("stocks:subs:{$event->symbol}")['dashboard'] ?? false) return;

        Log::info("[DASHBOARD] {$event->symbol} => {$event->price}");
        $key = 'stocks:observer_log';
        $log = Cache::get($key, []);
        $log[] = ['channel'=>'dashboard','symbol'=>$event->symbol,'price'=>$event->price];
        Cache::forever($key, $log);
    }
}
