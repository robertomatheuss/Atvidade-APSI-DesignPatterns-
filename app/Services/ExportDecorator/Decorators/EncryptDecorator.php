<?php

namespace App\Services\ExportDecorator\Decorators;

class EncryptDecorator extends ExporterDecorator
{
    public function export(mixed $data): string
    {
        $result = $this->exporter->export($data);
        return strrev($result); // só um exemplo simples
    }
}
