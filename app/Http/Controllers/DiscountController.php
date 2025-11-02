<?php

namespace App\Http\Controllers;

use App\Services\PriceCalculatorStrategy\PriceCalculator;
use App\Services\PriceCalculatorStrategy\Estrategies\Discount\PercentDiscount;
use App\Services\PriceCalculatorStrategy\Estrategies\Discount\FixedDiscount;
use App\Services\PriceCalculatorStrategy\Estrategies\Discount\BuyXGetY;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function calculate(Request $req, PriceCalculator $calc)
    {
        $data = $req->validate([
            'amount' => 'required|numeric|min:0',
            'type'   => 'required|string|in:percent,fixed,buyxgety',
            'value'  => 'nullable|numeric|min:0',
            'x'      => 'nullable|integer|min:1',
            'y'      => 'nullable|integer|min:1',
            'unit'   => 'nullable|numeric|min:0.01'
        ]);

        // escolhe estratégia
        $strategy = match ($data['type']) {
            'percent'   => new PercentDiscount(($data['value'] ?? 0) / 100),
            'fixed'     => new FixedDiscount($data['value'] ?? 0),
            'buyxgety'  => new BuyXGetY($data['x'], $data['y'], $data['unit']),
        };

        $final = $calc->calculate($data['amount'], $strategy);

        return response()->json([
            'original' => $data['amount'],
            'final' => $final,
            'discountApplied' => $data['type'],
        ]);
    }
}
