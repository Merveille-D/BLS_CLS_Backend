<?php
namespace App\Repositories\Shareholder;

use App\Models\Shareholder\Capital;

class CapitalRepository
{
    public function __construct(private Capital $capital) {

    }

    /**
     * @param Request $request
     *
     * @return Capital
     */
    public function store($request) {

        $capital = $this->capital->create($request->all());
        return $capital;
    }

    /**
     * @param Request $request
     *
     * @return Capital
     */
    public function update(Capital $capital, $request) {

        $capital = $this->capital->update($request);
        return $capital;
    }


}
