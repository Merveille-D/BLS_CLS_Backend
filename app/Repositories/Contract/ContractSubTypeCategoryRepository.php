<?php
namespace App\Repositories\Contract;

use App\Models\Contract\ContractSubTypeCategory;

class ContractSubTypeCategoryRepository
{
    public function __construct(private ContractSubTypeCategory $contractSubTypeCategory) {

    }

    /**
     * @param Request $request
     *
     * @return ContractSubTypeCategory
     */
    public function store($request) {

        $contractSubTypeCategory = $this->contractSubTypeCategory->create($request);
        return $contractSubTypeCategory;
    }

    /**
     * @param Request $request
     *
     * @return ContractSubTypeCategory
     */
    public function update(ContractSubTypeCategory $contractSubTypeCategory, $request) {

        $contractSubTypeCategory->update($request);
        return $contractSubTypeCategory;
    }


}
