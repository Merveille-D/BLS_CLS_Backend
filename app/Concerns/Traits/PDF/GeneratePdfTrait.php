<?php
namespace App\Concerns\Traits\PDF;

use Barryvdh\DomPDF\Facade\Pdf;

trait GeneratePdfTrait
{
    public function generateFromView($view_path, $data = [], $filename = 'test.pdf', $options = [])
    {
        $imagePath = public_path('bls-logo.png');
        $imageData = base64_encode(file_get_contents($imagePath));
        $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);
        $base64Image = 'data:image/' . $imageType . ';base64,' . $imageData;
        $data['base64Image'] = $base64Image;

        // $data['base64Image'] = generateBase64Image('bls-logo.png');
        $data['bankLogo'] = $base64Image ;// generateBase64Image('ecobank.png') ?? generateBase64Image('bls-logo.png');
        // return view($view_path, $data);
        $pdf = Pdf::loadView($view_path, $data);
        return $pdf->stream($filename, $options);
    }
}
