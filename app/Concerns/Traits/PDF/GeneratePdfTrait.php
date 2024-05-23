<?php
namespace App\Concerns\Traits\PDF;

use Barryvdh\DomPDF\Facade\Pdf;

trait GeneratePdfTrait
{
    public function generateFromView($view_path, $data = [], $filename = 'document.pdf', $options = [])
    {
        // $pdf = app('dompdf.wrapper');
        $pdf = Pdf::loadView($view_path, $data);
        return $pdf->stream($filename, $options);
    }
}
