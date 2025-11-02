<?php

namespace App\Services\ExportDecorator\ExportType;

use App\Services\ExportDecorator\DataExporter;

class CsvExporter implements DataExporter
{
    public function export(mixed $data): string
    {
        $csv = "";

        foreach ($data as $key => $value) {
            $csv .= "$key,$value\n";
        }

        return $csv;
    }
}
