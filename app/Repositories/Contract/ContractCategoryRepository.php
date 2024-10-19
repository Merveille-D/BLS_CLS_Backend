<?php
namespace App\Repositories\Contract;

use App\Models\Contract\ContractCategory;

class ContractCategoryRepository
{
    public function __construct(private ContractCategory $contractCategory) {

    }

    /**
     * @param Request $request
     *
     * @return ContractCategory
     */
    public function store($request) {

        $contractCategory = $this->contractCategory->create($request);
        return $contractCategory;
    }

    /**
     * @param Request $request
     *
     * @return ContractCategory
     */
    public function update(ContractCategory $contractCategory, $request) {

        $contractCategory->update($request);
        return $contractCategory;
    }


}
