<?php

namespace App\Services\ExportDecorator\Decorators;

class CompressDecorator extends ExporterDecorator
{
    public function export(mixed $data): string
    {
        $result = $this->exporter->export($data);
        return base64_encode($result);
    }
}
