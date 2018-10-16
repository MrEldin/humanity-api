<?php

namespace Humanity\Entities\Vacation\Criterias;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FilterSitesCriteria
 * @package namespace Nodepole\Criteria;
 */
class ApprovedDatesCriteria implements CriteriaInterface
{

    /**
     * Apply criteria in query repository
     *
     * @param                     $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->whereHas("vacation", function ($query) {
            return $query->where("approved", true);
        });

        return $model;
    }
}
