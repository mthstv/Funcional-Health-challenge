<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class AccountTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAccount()
    {
        $this->call('POST', '/graphql', ['conta' => rand(10000, 99999)]);
    }
}
