<?php

namespace Tests\Functional\Agency;

use Humanity\Entities\Vacation\Models\VacationDate;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use Humanity\Api\V1\Transformers\VacationTransformer;
use Humanity\Entities\Vacation\Models\Vacation;
use Humanity\Serializers\CustomSerializer;
use Tests\TestCase;

class VacationTotalTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    /** @test */
    public function it_should_get_total_vacations()
    {
        //ARRANGE
        $vacationData = factory(Vacation::class)->create([
            Vacation::APPROVED => true
        ]);
        $vacationDates = factory(VacationDate::class, 3)->make();

        foreach ($vacationDates as $date) {
            $vacationData->dates()->create($date->toArray());
        }

        //ACT
        $response = $this->get(
            url('/api/vacations/total'),
            $this->getRequestHeaders()
        );

        $manager = new Manager;
        $manager->setSerializer(new CustomSerializer);
        $resource = new Item($vacationData, new VacationTransformer());

        //ASSERT
        $this->assertCount(3, $response->getOriginalContent());
    }
}
