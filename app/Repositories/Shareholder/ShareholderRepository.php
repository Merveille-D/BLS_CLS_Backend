<?php
namespace App\Repositories\Shareholder;

use App\Concerns\Traits\PDF\GeneratePdfTrait;
use App\Models\Gourvernance\BankInfo\BankInfo;
use App\Models\Shareholder\Capital;
use App\Models\Shareholder\Shareholder;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ShareholderRepository
{
    use GeneratePdfTrait;
    public function __construct(private Shareholder $shareholder) {

    }

    /**
     * @param Request $request
     *
     * @return Shareholder
     */
    public function store($request) {

        $request['actions_number'] = $request['actions_encumbered'] + $request['actions_no_encumbered'];

        $capital = Capital::get()->last();

        if($capital) {
            $total_actions = $capital->amount / $capital->par_value ;
            $percentage = ($request['actions_number'] / $total_actions) * 100;
        }

        $request['percentage'] = $percentage ?? null;

        $request['created_by'] = Auth::user()->id;
        $shareholder = $this->shareholder->create($request);

        $this->updateBankInfo();

        return $shareholder;
    }

    /**
     * @param Request $request
     *
     * @return Shareholder
     */
    public function update(Shareholder $shareholder, $request) {

        $request['actions_number'] = $request['actions_encumbered'] + $request['actions_no_encumbered'];

        $capital = Capital::get()->last();

        if($capital) {
            $total_actions = $capital->amount / $capital->par_value ;
            $percentage = ($request['actions_number'] / $total_actions) * 100;
        }

        $request['percentage'] = $percentage ?? null;

        $shareholder->update($request);
        return $shareholder;
    }

    public function updateBankInfo() {

        $bank_info = BankInfo::get()->first();
        if($bank_info) {
            $bank_info->update([
                'total_shareholders' => Shareholder::count()
            ]);
        }
    }

    public function generatePdfCertificat($request)
    {
        $shareholder = Shareholder::find($request['shareholder_id']);

        $filename = Str::slug('Certificat actions'). '_'.date('YmdHis') . '.pdf';
        $logo = generateBase64Image('afrikskills-logo.webp') ?? generateBase64Image('bls-logo.png');
        $pdf = Pdf::loadView('pdf.certificat.certificat', [
            'shareholder' => $shareholder,
            'logo' => $logo
        ])->setPaper('A4', 'landscape');
        return $pdf->stream($filename,);
    }

}
