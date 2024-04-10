<?php
namespace App\Repositories;

use App\Models\Bank\Bank;
use App\Models\Gourvernance\GourvernanceDocument;
use DateTime;

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

        if($request['type'] == 'file') {
            $request['file_name'] = getFileName($request['file']);
            $request['file_url'] = uploadFile($request['file'], 'bank_documents');
        }
        $bank = $this->bank->create($request->all());
        return $bank;
    }

     /**
     * @param Request $request
     *
     * @return Bank
     */
    public function update(Bank $bank, $request) {

        if (isset($request['type'])) {
            if($request['type'] == 'file') {
                $request['file_name'] = getFileName($request['file']);
                $request['file_url'] = uploadFile($request['file'], 'bank_documents');
            }
        }

        $bank->update($request);
        return $bank;
    }


}
