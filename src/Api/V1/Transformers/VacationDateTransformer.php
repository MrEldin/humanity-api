<?php

namespace Humanity\Api\V1\Transformers;

use Humanity\Entities\Vacation\Models\VacationDate;
use League\Fractal\TransformerAbstract;
use Humanity\Entities\Vacation\Models\Vacation;

/**
 * @SWG\Definition (
 *      definition="VacationDateTransformerV1",
 *      required={},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer"
 *      ),
 *      @SWG\Property(
 *          property="date",
 *          description="date",
 *          type="string"
 *      )
 * )
 *
 * Class VacationTransformer
 *
 * @package Tempest\Api\V1\Transformers
 */
class VacationDateTransformer extends TransformerAbstract
{
    /**
     * Resources that can be included if requested.
     *
     * @var array
     */
    protected $availableIncludes = ['vacation'];

    /**
     * Transform user data
     *
     * @param VacationDate $vacationDate
     * @return array
     */
    public function transform(VacationDate $vacationDate)
    {
        return [
            'id'   => (int)$vacationDate->{VacationDate::ID},
            'date' => $vacationDate->{VacationDate::DATE}
        ];
    }

    protected function includeVacation(VacationDate $vacationDate)
    {
        return $this->item($vacationDate->vacation, new VacationTransformer(), false);
    }
}
