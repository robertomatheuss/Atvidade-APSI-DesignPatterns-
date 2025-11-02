<?php

namespace App\Services\ExportDecorator\ExportType;

use App\Services\ExportDecorator\DataExporter;

class XmlExporter implements DataExporter
{
    public function export(mixed $data): string
    {
        $xml = "<root>";

        foreach ($data as $key => $value) {
            $xml .= "<$key>$value</$key>";
        }

        $xml .= "</root>";

        return $xml;
    }
}
