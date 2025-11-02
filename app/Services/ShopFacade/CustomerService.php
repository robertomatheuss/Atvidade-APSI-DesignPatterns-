<?php

namespace App\Services\ShopFacade;

use App\Models\Shop\Customer;

class CustomerService
{
    public function validate(Customer $c): bool
    {
        return filter_var($c->email, FILTER_VALIDATE_EMAIL) !== false && $c->name !== '';
    }
}
