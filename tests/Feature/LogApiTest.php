<?php

namespace Tests\Feature;

use App\Services\LogServiceSingleton;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogApiTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        app(LogServiceSingleton::class)->flush();
    }

    public function test_post_cria_log_e_get_lista(): void
    {
        // cria um log
        $res = $this->postJson('/logs', [
            'level' => 'info',
            'message' => 'Primeiro log',
        ]);

        $res->assertCreated();

        // lista
        $list = $this->getJson('/logs');
        $list->assertOk()
             ->assertJsonFragment(['level' => 'info', 'message' => 'Primeiro log']);
    }

    public function test_limite_de_100_logs(): void
    {
        // cria 105
        for ($i = 1; $i <= 105; $i++) {
            $this->postJson('/logs', [
                'level' => 'error',
                'message' => "Log $i",
            ])->assertCreated();
        }

        // lista e verifica que só há 100
        $list = $this->getJson('/logs')->assertOk();
        $data = $list->json();
        $this->assertCount(100, $data);

        // deve conter do 6 ao 105 (os 100 últimos), mais novo primeiro
        $this->assertSame('Log 105', $data[0]['message']);
        $this->assertSame('Log 6', $data[99]['message']);
    }

    public function test_validacao_de_campos(): void
    {
        $this->postJson('/logs', [
            'level' => 'debug', // inválido
            'message' => 'x',
        ])->assertStatus(422);

        $this->postJson('/logs', [
            'level' => 'info',
        ])->assertStatus(422);
    }
}
