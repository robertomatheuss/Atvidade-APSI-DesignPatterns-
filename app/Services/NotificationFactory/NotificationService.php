<?php

namespace App\Services\NotificationFactory;

interface NotificationService
{  
    public function sendNotification(string $recipient, string $subject, string $content): bool;
}
