<?php

namespace App\Services\ShopFacade;

use App\Models\Shop\Customer;
use App\Models\Shop\Product;
use App\Models\Shop\OrderResult;

class OrderFacade
{
    public function __construct(
        private CustomerService $customers = new CustomerService(),
        private ProductService  $products  = new ProductService(),
        private PaymentService  $payments  = new PaymentService(),
        private OrderService    $orders    = new OrderService(),
    ) {}

    # placeOrder: ponto único
    public function placeOrder(Customer $customer, array $products): OrderResult
    {
        $notes = [];

        if (!$this->customers->validate($customer)) {
            $notes[] = 'Cliente inválido.';
            return new OrderResult(false, '', 0.0, null, $notes);
        }

        $total = 0.0;
        foreach ($products as $p) {
            if (!$this->products->hasStock($p)) {
                $notes[] = "Sem estoque: {$p->id}";
                return new OrderResult(false, '', 0.0, null, $notes);
            }
            $total += $this->products->subtotal($p);
        }

        $txn = $this->payments->charge($total, $customer->id);
        if ($txn === '') {
            $notes[] = 'Pagamento recusado.';
            return new OrderResult(false, '', 0.0, null, $notes);
        }

        $orderId = $this->orders->generateOrderId();
        $notes[] = 'Pedido criado com sucesso.';

        return new OrderResult(true, $orderId, $total, $txn, $notes);
    }
}
