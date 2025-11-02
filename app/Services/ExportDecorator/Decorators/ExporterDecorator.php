<?php

namespace App\Services\ExportDecorator\Decorators;

use App\Services\ExportDecorator\DataExporter;

abstract class ExporterDecorator implements DataExporter
{
    public function __construct(protected DataExporter $exporter) {}
}
