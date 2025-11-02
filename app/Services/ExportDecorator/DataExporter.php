<?php

namespace App\Services\ExportDecorator;

interface DataExporter
{
    # Recebe qualquer dado “serializável” e retorna a string exportada.
    public function export(mixed $data): string;
}
