<?php
namespace App\Services\OrderChainResponsability;

abstract class AbstractHandler implements OrderHandler {
    protected ?OrderHandler $next = null;

    public function setNext(OrderHandler $next): OrderHandler {
        $this->next = $next; return $next;
    }
    
    protected function next(array $ctx): array {
        return $this->next ? $this->next->handle($ctx) : $ctx;
    }
}
