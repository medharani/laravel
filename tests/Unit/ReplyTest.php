<?php

namespace Tests\Unit;


use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransctions;


class ReplyTest extends TestCase
{

	 use DatabaseMigrations;
    /**
     @test
     */
    function it_has_an_owner()
    {
       // $this->assertTrue(true);
    	$reply = factory('App\Reply')->create();

    	$this->assertInstanceOf('App\User', $reply->owner);
    }
}
