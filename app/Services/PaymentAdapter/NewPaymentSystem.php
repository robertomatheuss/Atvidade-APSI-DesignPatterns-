<?php

namespace App\Services\PaymentAdapter;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class NewPaymentSystem
{
    /**
     * API nova: recebe um PaymentRequest (incompatível com a interface legada).
     * Retorna array com sucesso e transactionId (simulação).
     */
    public function executePayment(PaymentRequestDTO $request): array
    {
        $tx = Str::uuid()->toString();

        Log::info('NEW_PAYMENT_SYSTEM - executePayment', [
            'orderId' => $request->orderId,
            'amount'  => $request->amount,
            'tx'      => $tx,
        ]);

        return ['success' => true, 'transactionId' => $tx];
    }
}
