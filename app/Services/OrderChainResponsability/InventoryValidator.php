<?php
namespace App\Services\OrderChainResponsability;

class InventoryValidator extends AbstractHandler {
    
    // estoque fake: cada SKU possui de 1 a 5 unidades
    public function handle(array $ctx): array {
        foreach ($ctx['order']['items'] as $it) {
            if ($it['qty'] < 1 || $it['qty'] > 5) {
                $ctx['ok'] = false;
                $ctx['notes'][] = "Sem estoque para {$it['sku']}.";
                return $ctx; // interrompe
            }
        }
        $ctx['notes'][] = 'Estoque ok.';
        return $this->next($ctx);
    }
}
