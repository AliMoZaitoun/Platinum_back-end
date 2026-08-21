<?php

namespace App\Services\Report;

use Spatie\LaravelPdf\Facades\Pdf;

class PdfExportService
{
    public function generate(string $view, array $data, string $fileName = 'report.pdf')
    {
        $logoPath = public_path('images/logo.png');

        $data['logo_path'] = $logoPath;
        $data['generation_date'] = now()->format('Y-m-d H:i');

        return Pdf::view($view, $data)
            ->format('a4')
            ->margins(10, 10, 10, 10)
            ->withBrowsershot(function ($browsershot) {
                $browsershot->setNodeBinary('/usr/bin/node')
                    ->setNpmBinary('/usr/bin/npm')
                    ->setChromePath('/usr/bin/chromium-browser')
                    ->noSandbox();
            })
            ->name($fileName)
            ->download();
    }
}
