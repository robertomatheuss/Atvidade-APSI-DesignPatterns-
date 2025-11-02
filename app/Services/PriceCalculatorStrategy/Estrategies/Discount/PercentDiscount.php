<?php

namespace App\Services\PriceCalculatorStrategy\Estrategies\Discount;

class PercentDiscount implements DiscountStrategy
{
    public function __construct(private float $percent) {}

    public function applyDiscount(float $amount): float
    {
        return $amount - ($amount * $this->percent);
    }
}
