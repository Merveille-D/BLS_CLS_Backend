<?php
namespace App\Repositories\Shareholder;

use App\Models\Shareholder\Capital;
use Illuminate\Support\Facades\Auth;

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

        $request['created_by'] = Auth::user()->id;
        $capital = $this->capital->create($request);
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
