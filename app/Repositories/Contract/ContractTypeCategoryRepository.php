<?php
namespace App\Repositories\Contract;

use App\Models\Contract\ContractTypeCategory;

class ContractTypeCategoryRepository
{
    public function __construct(private ContractTypeCategory $contractTypeCategory) {

    }

    /**
     * @param Request $request
     *
     * @return ContractTypeCategory
     */
    public function store($request) {

        $contractTypeCategory = $this->contractTypeCategory->create($request);
        return $contractTypeCategory;
    }

    /**
     * @param Request $request
     *
     * @return ContractTypeCategory
     */
    public function update(ContractTypeCategory $contractTypeCategory, $request) {

        $contractTypeCategory->update($request);
        return $contractTypeCategory;
    }


}
