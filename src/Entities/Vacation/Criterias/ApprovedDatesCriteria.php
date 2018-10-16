<?php

namespace Humanity\Entities\Vacation\Criterias;

use Humanity\Entities\User\Models\User;
use Humanity\Entities\Vacation\Models\Vacation;
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
            $query = $query->where(Vacation::APPROVED, true);

            if(auth()->user()->hasPermissionTo('create-vacation')){
                $query->where(Vacation::USER_ID, auth()->user()->{User::ID});
            }
        });

        return $model;
    }
}
