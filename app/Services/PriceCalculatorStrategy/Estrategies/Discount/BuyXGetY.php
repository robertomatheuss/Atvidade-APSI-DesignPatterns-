<?php

namespace App\Services\PriceCalculatorStrategy\Estrategies\Discount;

class BuyXGetY implements DiscountStrategy
{
    public function __construct(private int $x, private int $y, private float $unitPrice) {}

    public function applyDiscount(float $amount): float
    {
        // quantidade simulada = total / valor unitário
        $quantity = $amount / $this->unitPrice;

        $freeItems = intdiv($quantity, $this->x + $this->y) * $this->y;
        $discount = $freeItems * $this->unitPrice;

        return $amount - $discount;
    }
}
