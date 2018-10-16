<?php

namespace Humanity\Entities\Vacation\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Humanity\Entities\Vacation\Contracts\VacationRepository;
use Humanity\Entities\Vacation\Models\Vacation;

class VacationRepositoryEloquent extends BaseRepository implements VacationRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Vacation::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
