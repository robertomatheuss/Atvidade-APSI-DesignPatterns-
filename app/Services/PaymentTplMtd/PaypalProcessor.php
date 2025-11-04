<?php

namespace App\Services\PaymentTplMtd;

use App\Models\Payment\PaymentInfo;
use Illuminate\Support\Str;

class PaypalProcessor extends PaymentProcessor
{
    protected function validate(PaymentInfo $info): void
    {
        $email = (string)($info->meta['paypal_email'] ?? '');
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('PayPal e-mail inválido.');
        }
        if ($info->amount <= 0) {
            throw new \InvalidArgumentException('Valor inválido.');
        }
    }

    protected function process(PaymentInfo $info): string
    {
        return 'PP-' . Str::upper(Str::random(10));
    }

    protected function notify(PaymentInfo $info, string $tx): void
    {
        logger()->info('PayPal notify', ['payer'=>$info->payerId, 'tx'=>$tx]);
    }
}
