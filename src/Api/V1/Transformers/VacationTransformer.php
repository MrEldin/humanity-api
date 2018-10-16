<?php

namespace Humanity\Api\V1\Transformers;

use League\Fractal\TransformerAbstract;
use Humanity\Entities\Vacation\Models\Vacation;

/**
 * @SWG\Definition (
 *      definition="PhaseTransformerV1",
 *      required={},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer"
 *      ),
 *      @SWG\Property(
 *          property="name",
 *          description="name",
 *          type="string"
 *      )
 * )
 *
 * Class VacationTransformer
 *
 * @package Tempest\Api\V1\Transformers
 */
class VacationTransformer extends TransformerAbstract
{
    /**
     * Resources that can be included if requested.
     *
     * @var array
     */
    protected $availableIncludes = ['user'];

    /**
     * Resources that can be included if requested.
     *
     * @var array
     */
    protected $defaultIncludes = ['dates'];

    /**
     * Transform user data
     *
     * @param Vacation $vacation
     * @return array
     */
    public function transform(Vacation $vacation)
    {
        return [
            'id'       => (int)$vacation->{Vacation::ID},
            'name'     => $vacation->{Vacation::NAME},
            'approved' => (boolean) $vacation->{Vacation::APPROVED}
        ];
    }

    /**
     * @param Vacation $vacation
     * @return \League\Fractal\Resource\Item
     */
    protected function includeUser(Vacation $vacation)
    {
        return $this->item($vacation->user, new UserTransformer(), false);
    }

    /**
     * @param Vacation $vacation
     * @return \League\Fractal\Resource\Collection
     */
    protected function includeDates(Vacation $vacation)
    {
        return $this->collection($vacation->dates, new VacationDateTransformer(), false);
    }
}
