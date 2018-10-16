<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Humanity\Entities\Role\Models\Role;
use Tests\Traits\AuthenticatedUser;
use Faker\Factory;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations, AuthenticatedUser;


    /* @var Generator $faker */
    protected $faker;

    public function setUp()
    {
        parent::setUp();

        (new \TestingDatabaseSeeder())->run();

        $this->createAuthenticatedUser('super-admin');

        $this->faker = Factory::create();
    }
}
