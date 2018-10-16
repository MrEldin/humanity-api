<?php

namespace Tests\Functional\Agency;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use Humanity\Api\V1\Transformers\VacationTransformer;
use Humanity\Entities\Vacation\Models\Vacation;
use Humanity\Serializers\CustomSerializer;
use League\Fractal\Resource\Item;
use Tests\TestCase;

class VacationApproveTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    /** @test */
    public function it_should_approve_vacation()
    {
        //ARRANGE
        $vacationData = factory(Vacation::class)->create();

        //ACT
        $response = $this->put(
            url("/api/vacations/approve/{$vacationData->{Vacation::ID}}"),
            $this->getRequestHeaders()
        );

        $vacationData->{Vacation::APPROVED} = true;

        $manager = new Manager;
        $manager->parseIncludes(["dates"]);
        $manager->setSerializer(new CustomSerializer);
        $resource = new Item($vacationData, new VacationTransformer());

        //ASSERT
        $this->assertDatabaseHas(Vacation::TABLE, [
            Vacation::ID       => $vacationData->{Vacation::ID},
            Vacation::APPROVED => true
        ]);
    }

    /** @test */
    public function it_should_not_approve_vacation()
    {
        //ARRANGE
        $vacationData = factory(Vacation::class)->create();

        //ACT
        $response = $this->put(
            url("/api/vacations/disapprove/{$vacationData->{Vacation::ID}}"),
            $this->getRequestHeaders()
        );

        $manager = new Manager;
        $manager->setSerializer(new CustomSerializer);
        $resource = new Item($vacationData, new VacationTransformer());

        //ASSERT
        $this->assertDatabaseHas(Vacation::TABLE, [
            Vacation::ID       => $vacationData->{Vacation::ID},
            Vacation::APPROVED => false
        ]);
    }
}
