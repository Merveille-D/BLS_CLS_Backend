<?php
namespace App\Repositories\BankInfo;

use App\Models\Gourvernance\BankInfo\BankInfo;
use App\Models\Shareholder\Shareholder;

class BankInfoRepository
{
    public function __construct(private BankInfo $bank_info) {

    }

    /**
     * @param Request $request
     *
     * @return BankInfo
     */
    public function store($request) {

        $requestData = $request;

        if($request['logo']) {
            $path = uploadFile($request['logo'], 'bank_infos');
            $requestData = $request->except('logo');
            $requestData['logo'] = $path;
        }

        $requestData['total_shareholders'] = Shareholder::count();

        $bank_info = BankInfo::first(); 
        if ($bank_info) {

            dd($requestData);
            $bank_info->update($requestData); 

        } else {
            $bank_info = BankInfo::create($requestData); 
        }

        return $bank_info;
    }

    /**
     * @param Request $request
     *
     * @return BankInfo
     */
    public function update(BankInfo $bank_info, $request) {

        $bank_info->update($request);
        return $bank_info;
    }
}
