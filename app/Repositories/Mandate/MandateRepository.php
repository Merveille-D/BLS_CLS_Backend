<?php
namespace App\Repositories\Mandate;

use App\Models\Gourvernance\Mandate;

class MandateRepository
{
    public function __construct(private Mandate $mandate) {

    }

    /**
     * @param Request $request
     *
     * @return Mandate
     */
    public function store($request) {

        if(!($request['type'] == 'link')) {
            $request['file_name'] = getFileName($request['file']);
        }
        $mandate = $this->mandate->create($request->all());
        return $mandate;
    }

    /**
     * @param Request $request
     *
     * @return Mandate
     */
    public function update(Mandate $mandate, $request) {

        if (isset($request['type'])) {
            if(!($request['type'] == 'link')) {
                $request['file_name'] = getFileName($request['file']);
            }
        }

        $mandate->update($request);
        return $mandate;
    }


}
