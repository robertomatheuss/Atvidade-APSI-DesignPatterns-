<?php

namespace App\Services\PriceCalculatorStrategy\Estrategies\Discount;

interface DiscountStrategy
{
    public function applyDiscount(float $amount): float;
}
