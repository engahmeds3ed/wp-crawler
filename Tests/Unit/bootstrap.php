<?php
namespace Rocket\Tests\Unit;

use Brain\Monkey;

define("ROCKET_IN_TESTING", true);
require_once( dirname( dirname( __DIR__ ) ) . DIRECTORY_SEPARATOR . "wp-crawler.php" );
$crawler = new \Rocket_Crawler();
$crawler->setup_test();
