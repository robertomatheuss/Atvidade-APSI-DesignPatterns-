<?php

namespace Tests\Feature;

use Tests\TestCase;

class NotificationApiTest extends TestCase
{
    
     
    public function test_send_email_notification(): void
    {
        $res = $this->postJson('/notify', [
            'channel'   => 'email',
            'recipient' => 'user@example.com',
            'subject'   => 'Bem-vindo',
            'content'   => 'Sua conta foi criada.',
        ]);
        
        $res->assertOk()->assertJson(['ok' => true]);
    }


public function test_send_sms_notification(): void
{
    $res = $this->postJson('/notify', [
        'channel'   => 'sms',
        'recipient' => '+55 (82) 99999-9999',
        'content'   => 'Seu código é 123456',
    ]);
    
    $res->assertOk()->assertJson(['ok' => true]);
}

public function test_send_push_notification(): void
{
    $res = $this->postJson('/notify', [
        'channel'   => 'push',
        'recipient' => 'device_abc_123',
        'subject'   => 'Promoções',
        'content'   => 'Hoje tem ação especial!',
    ]);
    
    $res->assertOk()->assertJson(['ok' => true]);
}

public function test_channel_auto_infers_email(): void
{
    $res = $this->postJson('/notify', [
        'channel'   => 'auto',
        'recipient' => 'alguem@exemplo.com',
        'subject'   => 'Assunto',
        'content'   => 'Conteúdo',
    ]);
    
    $res->assertOk()->assertJson(['ok' => true]);
    }
    
    public function test_invalid_channel(): void
    {
        $res = $this->postJson('/notify', [
            'channel'   => 'fax',
            'recipient' => '123',
            'content'   => 'X',
        ]);

        $res->assertStatus(422); // validação do channel
    }
    
    
}
