<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StockPriceChanged
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public string $symbol,
        public float $price
    ) {}
}
    