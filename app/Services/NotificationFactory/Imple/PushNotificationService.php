<?php

namespace App\Services\NotificationFactory\Imple;

use Illuminate\Support\Facades\Log;
use App\Services\NotificationFactory\NotificationService;

class PushNotificationService implements NotificationService
{
    public function sendNotification(string $recipient, string $subject, string $content): bool
    {
        Log::info('PUSH sent', [
            'device_or_token' => $recipient,
            'title' => $subject,
            'content' => $content,
        ]);
        return true;
    }
}
    