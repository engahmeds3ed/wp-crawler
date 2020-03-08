<?php


namespace Rocket\Tests\Unit;

use Rocket\Classes\Rocket_Cache;
use WPMedia\PHPUnit\Unit\TestCase;
use Brain\Monkey;

/**
 * Class Test_Cache
 * @package Rocket\Tests\Unit
 */
class Test_Cache extends TestCase
{
	/**
	 * Load Cache Object here.
	 *
	 * @var Rocket_Cache|null
	 */
	private $cache = null;

	/**
	 * Setup to be run before each test call.
	 */
	protected function setUp()
	{
		parent::setUp();

		$this->cache = new Rocket_Cache();
	}

	/**
	 * Check initially empty cache.
	 * @covers ::get_cache()
	 * @uses get_transient()
	 * @group Cache
	 *
	 * @throws Monkey\Expectation\Exception\ExpectationArgsRequired
	 */
	public function testEmptyCacheLinksAtFirst()
	{
		Monkey\Functions\expect( 'get_transient' )
			->with( '' )
			->andReturn( '' );
		$cache_value = $this->cache->get_cache();
		$this->assertEmpty($cache_value);
	}

	/**
	 * Check Not empty cache.
	 * @covers ::get_cache()
	 * @uses get_transient()
	 * @group Cache
	 *
	 * @throws Monkey\Expectation\Exception\ExpectationArgsRequired
	 */
	public function testArrayCachedValueNotEmptyAndHasRightItemsCount() {
		Monkey\Functions\expect( 'get_transient' )
			->with( [1, 2, 3] )
			->andReturn( [1, 2, 3] );
		$cache_value = $this->cache->get_cache();
		$this->assertNotEmpty($cache_value);
	}

	/**
	 * Check Count of cached value.
	 * @covers ::get_cache()
	 * @uses get_transient()
	 * @group Cache
	 *
	 * @throws Monkey\Expectation\Exception\ExpectationArgsRequired
	 */
	public function testArrayCachedValueHasRightItemsCount() {
		Monkey\Functions\expect( 'get_transient' )
			->with( [1, 2, 3] )
			->andReturn( [1, 2, 3] );
		$cache_value = $this->cache->get_cache();

		$this->assertEquals(count( $cache_value ), 3);
	}
}
