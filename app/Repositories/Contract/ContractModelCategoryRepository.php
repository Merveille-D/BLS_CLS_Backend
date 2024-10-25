<?php

namespace App\Repositories\Contract;

use App\Models\Contract\ContractModelCategory;

class ContractModelCategoryRepository
{
    public function __construct(private ContractModelCategory $contract_model_category) {}

    /**
     * @param  Request  $request
     * @return ContractModelCategory
     */
    public function store($request)
    {

        $contract_model_category = $this->contract_model_category->create($request->all());

        return $contract_model_category;
    }

    /**
     * @param  Request  $request
     * @return ContractModelCategory
     */
    public function update(ContractModelCategory $contract_model_category, $request)
    {

        $contract_model_category->update($request);

        return $contract_model_category;
    }
}
