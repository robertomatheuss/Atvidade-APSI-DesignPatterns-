<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ExportDecorator\ExportType\JsonExporter;
use App\Services\ExportDecorator\ExportType\XmlExporter;
use App\Services\ExportDecorator\ExportType\CsvExporter;
use App\Services\ExportDecorator\Decorators\ValidateDecorator;
use App\Services\ExportDecorator\Decorators\CompressDecorator;
use App\Services\ExportDecorator\Decorators\EncryptDecorator;

class ExportController extends Controller
{
    public function export(Request $request)
    {
        $format = $request->input('format'); 
        $data = $request->input('data');
        $decorators = $request->input('decorators', []); // ["validate","encrypt"]

        // Escolhe exportador base
        $exporter = match ($format) {
            "xml"  => new XmlExporter(),
            "csv"  => new CsvExporter(),
            default => new JsonExporter()
        };

        foreach ($decorators as $d) {
            $exporter = match ($d) {
                "validate" => new ValidateDecorator($exporter),
                "compress" => new CompressDecorator($exporter),
                "encrypt"  => new EncryptDecorator($exporter),
                default => $exporter
            };
        }

        return response()->json([
            "format" => $format,
            "decorators" => $decorators,
            "result" => $exporter->export($data)
        ]);
    }
}
