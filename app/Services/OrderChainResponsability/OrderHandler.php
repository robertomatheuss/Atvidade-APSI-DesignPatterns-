<?php
namespace App\Services\OrderChainResponsability;

interface OrderHandler {
    public function setNext(OrderHandler $next): OrderHandler;
    public function handle(array $ctx): array; // retorna ['ok'=>bool,'order'=>[], 'notes'=>[]]
}
