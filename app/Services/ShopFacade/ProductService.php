<?php

namespace App\Services\ShopFacade;

use App\Models\Shop\Product;

class ProductService
{
    public function hasStock(Product $p): bool
    {
        return $p->qty > 0 && $p->qty <= 5;
    }

    public function subtotal(Product $p): float
    {
        return $p->price * $p->qty;
    }
}
