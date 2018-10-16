<?php

namespace Tests\Functional\Agency;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use Humanity\Api\V1\Transformers\UserTransformer;
use Humanity\Entities\User\Models\User;
use Humanity\Serializers\CustomSerializer;
use Tests\TestCase;

class UserFindTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    /** @test */
    public function it_should_get_one_user()
    {
        //ARRANGE
        $userData = factory(User::class)->create();

        //ACT
        $response = $this->get(
            url('/api/users', [User::ID => $userData->{User::ID}]),
            $this->getRequestHeaders()
        );

        $manager = new Manager;
        $manager->setSerializer(new CustomSerializer);
        $resource = new Item($userData, new UserTransformer());

        //ASSERT
        $this->assertEquals($manager->createData($resource)->toJson(), $response->getContent());
    }
}
