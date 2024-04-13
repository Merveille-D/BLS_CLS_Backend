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

        $Shareholder = $this->shareholder->create($request->all());
        return $Shareholder;
    }

    /**
     * @param Request $request
     *
     * @return Shareholder
     */
    public function update(Shareholder $shareholder, $request) {

        $shareholder->update($request);
        return $shareholder;
    }


}
