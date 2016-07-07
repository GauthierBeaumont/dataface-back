<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SocietiesControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testShow()
	{
		$response = $this->call('GET', 'SocietiesController@show');
		$this->assertResponseOk();
	}

	// public function testEdit()
	// {
	// 	$response = $this->action('GET', 'SocietiesController@edit');
	// 	$this->assertResponseOk();
	// }

	// public function testStore()
	// {
	// 	$response = $this->action('POST', 'SocietiesController@store');
	// 	$this->assertResponseOk();
	// }

	// public function testUpdate()
	// {
	// 	$response = $this->action('PUT', 'SocietiesController@update');
	// 	$this->assertResponseOk();
	// }

}
