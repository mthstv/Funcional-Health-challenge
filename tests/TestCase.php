<?php

use GraphQLClient\Client;
use GraphQLClient\LaravelTestGraphQLClient;
use Laravel\Lumen\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /** @var Client */
    protected $graphql;

    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->graphql = new LaravelTestGraphQLClient(
            $this->app,
            env('APP_URL') . '/graphql'
        );
    }
}
