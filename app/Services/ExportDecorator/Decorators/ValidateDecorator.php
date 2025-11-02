<?php

namespace App\Services\ExportDecorator\Decorators;

class ValidateDecorator extends ExporterDecorator
{
    public function export(mixed $data): string
    {
        if (!is_array($data)) {
            throw new \Exception("Dados devem ser array!");
        }

        return $this->exporter->export($data);
    }
}
