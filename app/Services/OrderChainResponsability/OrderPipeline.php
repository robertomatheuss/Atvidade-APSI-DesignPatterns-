<?php
namespace App\Services\OrderChainResponsability;

class OrderPipeline {
    public static function build(): OrderHandler {
        $h1 = new InventoryValidator();
        $h2 = new PricingCalculator();
        $h1->setNext($h2);
        return $h1;
    }
}
