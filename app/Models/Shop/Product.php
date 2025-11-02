<?php

namespace App\Models\Shop;

class Product
{
    public function __construct(
        public string $id,
        public string $name,
        public float  $price,
        public int    $qty // quantidade solicitada
    ) {}
}
