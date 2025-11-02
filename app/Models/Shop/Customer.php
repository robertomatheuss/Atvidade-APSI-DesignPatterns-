<?php

namespace App\Models\Shop;

class Customer
{
    public function __construct(
        public string $id,
        public string $name,
        public string $email,
    ) {}
}
