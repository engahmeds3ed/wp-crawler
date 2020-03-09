<?php


namespace Rocket\Tests\Unit;

use Rocket\Classes\Requests\Rocket_Request_Url;
use Rocket\Classes\Rocket_Cache;
use WPMedia\PHPUnit\Unit\TestCase;
use Brain\Monkey;

/**
 * Class Test_Request
 * @package Rocket\Tests\Unit
 */
class Test_Request extends TestCase
{

	/**
	 * Setup to be run before each test call.
	 */
	protected function setUp()
	{
		parent::setUp();
	}

	public function testValidInternalLinksRequestWithNoSchema() {
		$url = "";
		Monkey\Functions\expect( 'wp_remote_request' )
			->with( $url )
			->andReturn(
				[
					'body' => "Hi <a href='asa.html'>Ahmed</a>, this is my name also, please <a href='tell.html'>tell</a> me your name."
				]
			);
		Monkey\Functions\expect( 'wp_parse_url' )
			->with( $url )
			->andReturn(
				[
					'host' => ''
				]
			);
		Monkey\Functions\expect( 'home_url' )
			->andReturn( "" );
		$request = new Rocket_Request_Url( $url );
		$request->do_request();
		$actual = $request->get_response_body();
		$expected = [
			[
				'text' => 'Ahmed',
				'url' => 'asa.html'
			],
			[
				'text' => 'tell',
				'url' => 'tell.html'
			]
		];
		$this->assertEquals($expected, $actual);
	}

	public function testValidInternalLinksRequestWithSchema() {
		$url = "http://localhost/page";
		$home_url = "http://localhost/";

		Monkey\Functions\expect( 'home_url' )
			->andReturn( $home_url );

		Monkey\Functions\expect( 'wp_remote_request' )
			->with( $url )
			->andReturn(
				[
					'body' => "Hi <a href='http://localhost/ahmed'>Ahmed</a>, this is my name also, please <a href='https://google.com'>tell</a> me your name."
				]
			);
		Monkey\Functions\expect( 'wp_parse_url' )
			;
		Monkey\Functions\expect( 'wp_parse_url' )
			->with( $home_url )
			->andReturn(
				[
					'host' => 'localhost'
				]
			)
			->with( "http://localhost/ahmed" )
			->andReturn(
				[
					'host' => 'localhost'
				]
			)
			->with( "https://google.com" )
			->andReturn(
				[
					'host' => 'google.com'
				]
			);

		$request = new Rocket_Request_Url( $url );
		$request->do_request();

		$actual = $request->get_response_body();
		$expected = [
			[
				'text' => 'Ahmed',
				'url' => 'http://localhost/ahmed'
			]
		];
		$this->assertEquals($expected, $actual);
	}
}
