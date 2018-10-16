<?php

namespace Tests\Functional\Agency;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use Humanity\Api\V1\Transformers\VacationTransformer;
use Humanity\Entities\Vacation\Models\Vacation;
use Humanity\Serializers\CustomSerializer;
use Tests\TestCase;

class VacationIndexTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    /** @test */
    public function it_should_get_all_vacations()
    {
        //ARRANGE
        $vacationData = factory(Vacation::class, 2)->create();

        //ACT
        $response = $this->get(
            url('/api/vacations'),
            $this->getRequestHeaders()
        );

        $manager = new Manager;
        $manager->setSerializer(new CustomSerializer);
        $resource = new Collection($vacationData, new VacationTransformer());

        //ASSERT
        $this->assertEquals($manager->createData($resource)->toJson(), $response->getContent());
    }
}
