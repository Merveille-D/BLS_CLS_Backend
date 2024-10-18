<?php

namespace App\Http\Controllers\API\V1\Gourvernance\BankInfo;

use App\Http\Controllers\Controller;
use App\Http\Requests\BankInfo\StoreBankInfoRequest;
use App\Http\Requests\BankInfo\UpdateBankInfoRequest;
use App\Models\Gourvernance\BankInfo\BankInfo;
use App\Models\Shareholder\Capital;
use App\Models\Shareholder\Shareholder;
use App\Repositories\BankInfo\BankInfoRepository;
use Illuminate\Validation\ValidationException;

class BankInfoController extends Controller
{

    public function __construct(private BankInfoRepository $bank_info) {

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bank_info = BankInfo::get()->first();

        if(!$bank_info) {
            $bank_info['total_shareholders'] = Shareholder::count();
        }

        $bank_info['majority_shareholder'] = Shareholder::orderBy('actions_number', 'desc')->first();
        $bank_info['capital'] = Capital::get()->last();

        return api_response(true, "Infos de la banque", $bank_info, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBankInfoRequest $request)
    {

        try {
            $bank_info = $this->bank_info->store($request);
            return api_response(true, "Infos de la banque", $bank_info, 200);
        }catch (ValidationException $e) {
                return api_response(false, "Echec de l'enregistrement", $e->errors(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(BankInfo $bank_info)
    {
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBankInfoRequest $request, BankInfo $bank_info)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BankInfo $bank_info)
    {
       
    }
}
