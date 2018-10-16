<?php

namespace Tests\Functional\Vacation;

use Humanity\Entities\Vacation\Models\VacationDate;
use Illuminate\Http\Response;
use Humanity\Entities\Vacation\Models\Vacation;
use Tests\TestCase;

class VacationCreateXTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }


    /**
     * @test
     * @dataProvider agencyCreateInvalidData
     * @param $data
     * @param $message
     * @param $type
     */
    public function it_should_fail_create_vacation_on_invalid_request($data, $message, $type)
    {
        //ARRANGE
        $vacation = factory(Vacation::class)->create();

        $vacationData = $vacation->toArray();
        $vacationData[$type] = $data[$type];

        //ACT
        $response = $this->post(
            url('/api/vacations'),
            $vacationData,
            $this->getRequestHeaders()
        );

        //ASSERT
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertEquals($message, $response->getOriginalContent()['errors']->get($type)[0]);
    }

    public function agencyCreateInvalidData()
    {
        return [
            #0 Empty vacation name
            [
                [
                    Vacation::NAME => ''
                ],
                'The name field is required.',
                Vacation::NAME
            ],
            #1 Wrong dates value
            [
                [
                    'dates' => 'asdassaads'
                ],
                'The dates must be an array.',
                'dates'
            ],
            #1 Empty dates value
            [
                [
                    'dates' => []
                ],
                'The dates field is required.',
                'dates'
            ]
        ];
    }
}
