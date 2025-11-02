<?php

namespace App\Services\NotificationFactory\Imple;

use Illuminate\Support\Facades\Log;
use App\Services\NotificationFactory\NotificationService;

class SmsNotificationService implements NotificationService
{
    public function sendNotification(string $recipient, string $subject, string $content): bool
    {
        Log::info('SMS sent', [
            'to' => $recipient,
            'content' => $content,
        ]);
        return true;
    }
}
