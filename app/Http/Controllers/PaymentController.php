<?php

namespace App\Http\Controllers;

use App\Services\PaymentAdapter\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(private PaymentService $payments) {}

    public function pay(Request $request): JsonResponse
    {
        $data = $request->validate([
            'orderId' => ['required', 'string', 'max:64'],
            'amount'  => ['required', 'numeric', 'min:0.01'],
        ]);

        $ok = $this->payments->pay($data['orderId'], (float)$data['amount']);

        return response()->json(['ok' => $ok], $ok ? 200 : 422);
    }
}
