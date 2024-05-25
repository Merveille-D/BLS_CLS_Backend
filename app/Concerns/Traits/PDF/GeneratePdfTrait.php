<?php
namespace App\Concerns\Traits\PDF;

use Barryvdh\DomPDF\Facade\Pdf;

trait GeneratePdfTrait
{
    public function generateFromView($view_path, $data = [], $filename = 'test.pdf', $options = [])
    {
        //convert image to base64
        $imagePath = public_path('bls-logo.png');
        $imageData = base64_encode(file_get_contents($imagePath));
        $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);
        $base64Image = 'data:image/' . $imageType . ';base64,' . $imageData;
        $data['base64Image'] = $base64Image;

        $pdf = Pdf::loadView($view_path, $data);
        return $pdf->stream($filename, $options);
    }
}
