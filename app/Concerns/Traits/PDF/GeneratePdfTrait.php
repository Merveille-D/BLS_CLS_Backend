<?php
namespace App\Concerns\Traits\PDF;

use Barryvdh\DomPDF\Facade\Pdf;

trait GeneratePdfTrait
{
    public function generateFromView($view_path, $data = [], $filename = 'test.pdf', $options = [])
    {
        $data['base64Image'] = generateBase64Image('bls-logo.png');
        $data['bankLogo'] = generateBase64Image('afrikskills-logo.webp') ?? generateBase64Image('bls-logo.png');
        // return view($view_path, $data);
        $pdf = Pdf::loadView($view_path, $data);
        return $pdf->stream($filename, $options);
    }
}
