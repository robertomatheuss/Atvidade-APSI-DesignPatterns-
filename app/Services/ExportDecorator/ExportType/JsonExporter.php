<?php

namespace App\Services\ExportDecorator\ExportType;

use App\Services\ExportDecorator\DataExporter;

class JsonExporter implements DataExporter
{
    public function export(mixed $data): string
    {
        return json_encode($data);
    }
}
