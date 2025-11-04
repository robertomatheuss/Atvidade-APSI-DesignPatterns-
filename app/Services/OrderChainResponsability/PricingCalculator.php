<?php
namespace App\Services\OrderChainResponsability;

class PricingCalculator extends AbstractHandler {
    public function handle(array $ctx): array {
        $subtotal = 0.0;
        foreach ($ctx['order']['items'] as $it) {
            $subtotal += $it['price'] * $it['qty'];
        }
        $ctx['order']['subtotal'] = $subtotal;
        $ctx['order']['total']    = $subtotal;
        $ctx['notes'][] = "Subtotal: {$subtotal}.";
        return $this->next($ctx); // fim da cadeia
    }
}
