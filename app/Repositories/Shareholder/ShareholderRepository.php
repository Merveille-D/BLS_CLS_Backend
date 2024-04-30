<?php
namespace App\Repositories\Shareholder;

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

        $Shareholder = $this->shareholder->create($request->all());
        return $Shareholder;
    }

    /**
     * @param Request $request
     *
     * @return Shareholder
     */
    public function update(Shareholder $shareholder, $request) {

        if($request->has('actions_encumbered') || $request->has('actions_no_encumbered')) {
            $request['actions_number'] = $request['actions_encumbered'] + $request['actions_no_encumbered'];
        }
        
        $shareholder->update($request);
        return $shareholder;
    }


}
