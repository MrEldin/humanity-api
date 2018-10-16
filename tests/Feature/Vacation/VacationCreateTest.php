<?php

namespace Tests\Functional\Agency;

use Humanity\Entities\Vacation\Models\Vacation;
use Humanity\Entities\User\Models\User;
use Humanity\Entities\Vacation\Models\VacationDate;
use Tests\TestCase;

class VacationCreateTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    /** @test */
    public function it_should_create_vacation()
    {
        //ARRANGE
        $vacationData = factory(Vacation::class)->make();
        $vacationDateData =  factory(VacationDate::class, 3)->make();

        $vacationData->dates = $vacationDateData->pluck(VacationDate::DATE)->toArray();

        //ACT
        $response = $this->post(
            url('/api/vacations'),
            $vacationData->toArray(),
            $this->getRequestHeaders()
        );

        $vacationData->{Vacation::USER_ID} = $this->authenticatedUser->{User::ID};

        //ASSERT
        $this->assertDatabaseHas(Vacation::TABLE, $vacationData->only([
            Vacation::NAME,
            Vacation::USER_ID
        ]));

        foreach ($vacationData->dates as $date) {
            $this->assertDatabaseHas(VacationDate::TABLE, [VacationDate::DATE => $date]);
        }
    }
}
