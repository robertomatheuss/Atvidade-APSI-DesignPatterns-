<?php

namespace App\Services\NotificationFactory;

use InvalidArgumentException;
use App\Services\NotificationFactory\NotificationFactory;
use App\Services\NotificationFactory\Imple\EmailNotificationService;
use App\Services\NotificationFactory\Imple\PushNotificationService;
use App\Services\NotificationFactory\Imple\SmsNotificationService;

class NotificationFactory
{
    public static function make(string $channel, string $recipient): NotificationService
    {
        $resolved = $channel;

        if ($channel === 'auto') {
            if (filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
                $resolved = 'email';
            } elseif (preg_match('/^\+?\d|^\(/', $recipient)) {
                $resolved = 'sms';
            } else {
                $resolved = 'push';
            }
        }

        return match ($resolved) {
            'email' => new EmailNotificationService(),
            'sms'   => new SmsNotificationService(),
            'push'  => new PushNotificationService(),
            default => throw new InvalidArgumentException("Canal inválido: $channel"),
        };
    }
}
