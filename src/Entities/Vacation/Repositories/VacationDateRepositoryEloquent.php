<?php

namespace Humanity\Entities\Vacation\Repositories;

use Humanity\Entities\Vacation\Contracts\VacationDateRepository;
use Humanity\Entities\Vacation\Models\VacationDate;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

class VacationDateRepositoryEloquent extends BaseRepository implements VacationDateRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return VacationDate::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
