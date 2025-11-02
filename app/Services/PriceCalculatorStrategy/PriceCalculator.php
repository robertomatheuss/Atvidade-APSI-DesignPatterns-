<?php

namespace App\Services\PriceCalculatorStrategy;


use App\Services\PriceCalculatorStrategy\Estrategies\Discount\DiscountStrategy;

class PriceCalculator
{
    public function calculate(float $amount, DiscountStrategy $strategy): float
    {
        return $strategy->applyDiscount($amount);
    }
}
