<?php

namespace App\Http\Controllers;

use App\Services\NotificationFactory\NotificationFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class NotificationController extends Controller
{
    public function send(Request $request): JsonResponse
    {
        $data = $request->validate([
            'channel'   => ['required', Rule::in(['email', 'sms', 'push', 'auto'])],
            'recipient' => ['required', 'string', 'max:255'],
            'subject'   => ['nullable', 'string', 'max:255'],
            'content'   => ['required', 'string', 'max:2000'],
        ]);

        if (in_array($data['channel'], ['email', 'auto']) && str_contains(($data['recipient'] ?? ''), '@')) {
            // valida email
        } elseif ($data['channel'] === 'email') {
            $request->validate(['recipient' => 'email']);
        }

        if ($data['channel'] === 'sms') {
            // valida telefone
            $request->validate(['recipient' => 'regex:/^[0-9\+\-\(\) ]{8,20}$/']);
            // subject pode ser vazio em SMS
            $data['subject'] ??= '';
        }

        if ($data['channel'] === 'push') {
            // subject opcional push
            $data['subject'] ??= '';
        }

        $service = NotificationFactory::make($data['channel'], $data['recipient']);
        $ok = $service->sendNotification($data['recipient'], $data['subject'] ?? '', $data['content']);

        return response()->json(['ok' => $ok], $ok ? 200 : 500);
    }
}
