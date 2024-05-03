<?php
namespace App\Repositories\Shareholder;

use App\Models\Gourvernance\BankInfo\BankInfo;
use App\Models\Shareholder\Capital;
use App\Models\Shareholder\Shareholder;

class ShareholderRepository
{
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

        $Shareholder = $this->shareholder->create($request->all());

        $bank_info = BankInfo::get()->first();
        if($bank_info) {
            $bank_info->update([
                'total_shareholders' => Shareholder::count()
            ]);
        }

        return $Shareholder;
    }

    /**
     * @param Request $request
     *
     * @return Shareholder
     */
    public function update(Shareholder $shareholder, $request) {

        $request['actions_number'] = $request['actions_encumbered'] + $request['actions_no_encumbered'];


        $shareholder->update($request);
        return $shareholder;
    }


}
