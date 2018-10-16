<?php

namespace Tests\Functional\Agency;

use Illuminate\Http\Response;
use Humanity\Entities\Vacation\Models\Vacation;
use Tests\TestCase;

class VacationUpdateTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    /** @test */
    public function it_should_update_vacation()
    {
        //ARRANGE
        $vacationData = factory(Vacation::class)->create();
        $vacationUpdateData = factory(Vacation::class)->make();

        //ACT
        $response = $this->put(
            url('/api/vacations', ['id' => $vacationData->{Vacation::ID}]),
            $vacationUpdateData->toArray(),
            $this->getRequestHeaders()
        );

        //ASSERT
        $response->assertStatus(Response::HTTP_ACCEPTED);
        $this->assertDatabaseHas(Vacation::TABLE, $vacationUpdateData->toArray());
    }

}
