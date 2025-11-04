<?php

namespace App\Services\PaymentTplMtd;

use App\Models\Payment\PaymentInfo;
use Illuminate\Support\Str;

class CreditCardProcessor extends PaymentProcessor
{
    protected function validate(PaymentInfo $info): void
    {
        $card = (string)($info->meta['card'] ?? '');
        if ($card === '' || strlen(preg_replace('/\D/','',$card)) < 13) {
            throw new \InvalidArgumentException('Cartão inválido.');
        }
        if ($info->amount <= 0) {
            throw new \InvalidArgumentException('Valor inválido.');
        }
    }

    protected function process(PaymentInfo $info): string
    {
        return 'CC-' . Str::upper(Str::random(10));
    }
}
