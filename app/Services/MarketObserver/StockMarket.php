<?php

namespace App\Services\MarketObserver;

use App\Events\StockPriceChanged;
use Illuminate\Support\Facades\Cache;

class StockMarket
{
    private function key(string $symbol): string
    {
        return "stocks:subs:".strtoupper($symbol); // ex.: stocks:subs:AAPL
    }

    # Inscreve um canal para um símbolo 
    public function subscribe(string $symbol, string $channel): array
    {
        $symbol = strtoupper($symbol);
        $subs = Cache::get($this->key($symbol), []);
        $subs[$channel] = true;
        Cache::forever($this->key($symbol), $subs);
        return $subs;
    }

    # Cancela inscrição do canal para o símbolo
    public function unsubscribe(string $symbol, string $channel): array
    {
        $symbol = strtoupper($symbol);
        $subs = Cache::get($this->key($symbol), []);
        unset($subs[$channel]);
        Cache::forever($this->key($symbol), $subs);
        return $subs;
    }

    public function subscriptions(string $symbol): array
    {
        return Cache::get($this->key(strtoupper($symbol)), []);
    }

    # Simula mudança de preço e notifica observadores
    public function changePrice(string $symbol, float $price): void
    {
        event(new StockPriceChanged(strtoupper($symbol), $price));
    }
}
