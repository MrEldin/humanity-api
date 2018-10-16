<?php

namespace Tests\Functional\Agency;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use Humanity\Api\V1\Transformers\VacationTransformer;
use Humanity\Entities\Vacation\Models\Vacation;
use Humanity\Serializers\CustomSerializer;
use Tests\TestCase;

class VacationFindTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    /** @test */
    public function it_should_get_one_vacation()
    {
        //ARRANGE
        $vacationData = factory(Vacation::class)->create();

        //ACT
        $response = $this->get(
            url('/api/vacations', [Vacation::ID => $vacationData->{Vacation::ID}]),
            $this->getRequestHeaders()
        );

        $manager = new Manager;
        $manager->parseIncludes('dates');
        $manager->setSerializer(new CustomSerializer);
        $resource = new Item($vacationData, new VacationTransformer());

        //ASSERT
        $this->assertEquals($manager->createData($resource)->toJson(), $response->getContent());
    }
}
