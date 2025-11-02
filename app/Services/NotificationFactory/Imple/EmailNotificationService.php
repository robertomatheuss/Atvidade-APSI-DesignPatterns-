<?php

namespace App\Services\NotificationFactory\Imple;

use Illuminate\Support\Facades\Log;
use App\Services\NotificationFactory\NotificationService;

class EmailNotificationService implements NotificationService
{
    public function sendNotification(string $recipient, string $subject, string $content): bool
    {
        Log::info('EMAIL sent', [
            'to' => $recipient,
            'subject' => $subject,
            'content' => $content,
        ]);
        return true;
    }
}
