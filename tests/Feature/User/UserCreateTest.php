<?php

namespace Tests\Functional\Agency;

use Illuminate\Http\Response;
use Humanity\Entities\User\Models\User;
use Tests\TestCase;

class UserCreateTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    /** @test */
    public function it_should_create_user()
    {
        //ARRANGE
        $userData = factory(User::class)->make()->toArray();

        $userData['password'] = 'secret';

        //ACT
        $response = $this->post(
            url('/api/users'),
            $userData,
            $this->getRequestHeaders()
        );

        //ASSERT
        unset($userData['password']);
        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseHas(User::TABLE, $userData);
    }
}
