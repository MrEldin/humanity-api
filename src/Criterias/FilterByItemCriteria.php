<?php

namespace Humanity\Entities\Criterias;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FilterSitesCriteria
 * @package namespace Nodepole\Criteria;
 */
class FilterByItemCriteria implements CriteriaInterface
{
    private $column;
    private $field;

    public function __construct($column, $field)
    {
        $this->column = $column;
        $this->field = $field;
    }

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
        $model = $model->where($this->column, $this->field);

        return $model;
    }
}
