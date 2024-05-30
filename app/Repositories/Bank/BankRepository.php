<?php
namespace App\Repositories\Bank;

use App\Models\Bank\Bank;
use App\Models\Gourvernance\GourvernanceDocument;
use DateTime;
use Illuminate\Support\Facades\Auth;

class BankRepository
{
    public function __construct(private Bank $bank) {

    }

    /**
     * @param Request $request
     *
     * @return Bank
     */
    public function store($request) {

        if(!($request['type'] == 'link')) {
            $request['file_name'] = getFileName($request['file']);
            $request['file_url'] = uploadFile($request['file'], 'bank_documents');
        }
        $request['created_by'] = Auth::user()->id;
        $bank = $this->bank->create($request);
        return $bank;
    }

    /**
     * @param Request $request
     *
     * @return Bank
     */
    public function update(Bank $bank, $request) {

        if (isset($request['type'])) {
            if(!($request['type'] == 'link')) {
                $request['file_name'] = getFileName($request['file']);
                $request['file_url'] = uploadFile($request['file'], 'bank_documents');
            }
        }

        $bank->update($request);
        return $bank;
    }


}
