<?php

namespace App\Http\Controllers;

use App\Models\Shop\Customer;
use App\Models\Shop\Product;
use App\Services\ShopFacade\OrderFacade;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function place(Request $request, OrderFacade $facade): JsonResponse
    {
        $data = $request->validate([
            'customer.id'    => 'required|string|max:32',
            'customer.name'  => 'required|string|max:80',
            'customer.email' => 'required|email',
            'products'       => 'required|array|min:1',
            'products.*.id'  => 'required|string',
            'products.*.name'=> 'required|string',
            'products.*.price'=> 'required|numeric|min:0.01',
            'products.*.qty' => 'required|integer|min:1',
        ]);

        $customer = new Customer(
            $data['customer']['id'],
            $data['customer']['name'],
            $data['customer']['email'],
        );

        $products = array_map(fn($p) => new Product(
            $p['id'], $p['name'], (float)$p['price'], (int)$p['qty']
        ), $data['products']);

        $result = $facade->placeOrder($customer, $products);

        return response()->json([
            'ok'       => $result->ok,
            'orderId'  => $result->orderId,
            'total'    => $result->total,
            'payment'  => $result->paymentTxn,
            'notes'    => $result->notes,
        ], $result->ok ? 200 : 422);
    }
}
