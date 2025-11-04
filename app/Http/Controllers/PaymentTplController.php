<?php

namespace App\Http\Controllers;

use App\Models\Payment\PaymentInfo;
use App\Services\PaymentTplMtd\CreditCardProcessor;
use App\Services\PaymentTplMtd\PaypalProcessor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PaymentTplController extends Controller
{
    public function pay(Request $r): JsonResponse
    {
        $data = $r->validate([
            'method'        => ['required', Rule::in(['credit_card','paypal'])],
            'payerId'       => ['required','string','max:64'],
            'amount'        => ['required','numeric','min:0.01'],
            'card'          => ['nullable','string'],
            'paypal_email'  => ['nullable','string'],          
        ]);

        $info = new PaymentInfo(
            $data['payerId'],
            (float)$data['amount'],
            ['card'=>$data['card'] ?? null, 'paypal_email'=>$data['paypal_email'] ?? null]
        );

        $processor = match ($data['method']) {
            'credit_card' => new CreditCardProcessor(),
            'paypal'      => new PaypalProcessor(),
        };

        try {
            $result = $processor->processPayment($info);
            return response()->json($result);
        } catch (\Throwable $e) {
            return response()->json(['ok'=>false,'error'=>$e->getMessage()], 422);
        }
    }
}
