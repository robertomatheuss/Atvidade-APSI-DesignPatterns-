<?php

namespace App\Services\PaymentTplMtd;

use App\Models\Payment\PaymentInfo;

abstract class PaymentProcessor
{
    // TEMPLATE METHOD
    public final function processPayment(PaymentInfo $info): array
    {
        $this->validate($info);
        $tx = $this->process($info);
        $this->notify($info, $tx);

        return [
            'ok'      => true,
            'tx'      => $tx,
            'gateway' => static::class,
            'amount'  => $info->amount,
        ];
    }

    // Passos que as subclasses IMPLEMENTAM
    abstract protected function validate(PaymentInfo $info): void;
    abstract protected function process(PaymentInfo $info): string;

    // Hook default
    protected function notify(PaymentInfo $info, string $tx): void
    {
        logger()->info('Payment notify', ['payer'=>$info->payerId, 'tx'=>$tx, 'amount'=>$info->amount]);
    }
}
