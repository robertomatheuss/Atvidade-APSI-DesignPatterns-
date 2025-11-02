<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExportApiTest extends TestCase
{
    public function test_api_json_no_decorators()
    {
        $res = $this->postJson('/export', [
            'format' => 'json',
            'data'   => ['nome' => 'Dani', 'nota' => 10],
        ]);

        $res->assertOk()
            ->assertJsonPath('format', 'json')
            ->assertJsonPath('result', '{"nome":"Dani","nota":10}');
    }

    public function test_api_xml_with_validate()
    {
        $res = $this->postJson('/export', [
            'format'     => 'xml',
            'data'       => ['nome' => 'Dani', 'nota' => 10],
            'decorators' => ['validate'],
        ]);

        $res->assertOk()
            ->assertJsonPath('format', 'xml')
            ->assertJsonStructure(['result']);

        $xml = $res->json('result');
        $this->assertStringContainsString('<nome>Dani</nome>', $xml);
        $this->assertStringContainsString('<nota>10</nota>', $xml);
    }

    public function test_api_csv_with_encrypt_and_compress()
    {
        $res = $this->postJson('/export', [
            'format'     => 'csv',
            'data'       => ['nome' => 'Dani', 'nota' => 10],
            'decorators' => ['encrypt', 'compress'],
        ]);

        $res->assertOk()
            ->assertJsonPath('decorators.0', 'encrypt')
            ->assertJsonPath('decorators.1', 'compress')
            ->assertJsonStructure(['result']);

        $encoded = $res->json('result');
        $decoded = base64_decode($encoded, true);
        $this->assertNotFalse($decoded);

        $csv = "nome,Dani\nnota,10\n";
        $this->assertSame(strrev($csv), $decoded);
    }

    public function test_api_validate_rejects_non_array_data()
    {
        $res = $this->postJson('/export', [
            'format'     => 'json',
            'data'       => 'string simples',
            'decorators' => ['validate'],
        ]);

        $res->assertStatus(500);
    }
}
