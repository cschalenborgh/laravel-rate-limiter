<?php

namespace Cschalenborgh\RateLimiter\Tests;

use PHPUnit\Framework\TestCase;
use Illuminate\Cache\CacheManager;
use Cschalenborgh\RateLimiter\RateLimiter;
use Illuminate\Container\Container as Container;
use Illuminate\Config\Repository as Repository;
use Illuminate\Support\Facades\Facade as Facade;

class RateLimiterTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $app = new Container();
        $app->singleton('app', 'Illuminate\Container\Container');
        $app->singleton('config', 'Illuminate\Config\Repository');
        $app['config']->set('cache.default', 'array');
        $app['config']->set('cache.stores.array', [
            'driver'   => 'array',
        ]);
        $app->bind('cache', function ($app) {
            return new CacheManager($app);
        });

        Facade::setFacadeApplication($app);
    }

    public function testRateLimiter()
    {
        $name = uniqid('label', true);
        $max_requests = 10;
        $period = 2;

        $rl = new RateLimiter($name, $max_requests, $period);
        $rl->purge($name);

        $this->assertEquals($max_requests, $rl->getAllowance($name));

        for ($i = 0; $i < $max_requests; $i++) {
            $this->assertEquals($max_requests - $i, $rl->getAllowance($name));
            $this->assertTrue($rl->check($name));
        }

        $this->assertEquals(0, $rl->getAllowance($name));
        $this->assertFalse($rl->check($name));

        sleep($period);

        $this->assertEquals($max_requests, $rl->getAllowance($name));
        $this->assertTrue($rl->check($name));
    }

    public function testPurge()
    {
        $name = uniqid('label', true);
        $max_requests = 10;
        $period = 2;

        $rl = new RateLimiter($name, $max_requests, $period);
        $rl->check($name);

        $this->assertEquals(($max_requests - 1), $rl->getAllowance($name));
        $rl->purge($name);
        $this->assertEquals($max_requests, $rl->getAllowance($name));
    }

    public function testGetKeyTime()
    {
        $name = 'barfoo';
        $id = 'foobar';
        $rl = new RateLimiter($name, 1, 2);

        $reflectionClass = new \ReflectionClass($rl);
        $reflectionMethod = $reflectionClass->getMethod('keyTime');
        $reflectionMethod->setAccessible(true);

        $result = $reflectionMethod->invokeArgs($rl, [$id]);

        $this->assertEquals($name.':'.$id.':time', $result);
    }

    public function testGetKeyAllow()
    {
        $name = 'barfoo';
        $id = 'foobar';
        $rl = new RateLimiter($name, 1, 2);

        $reflectionClass = new \ReflectionClass($rl);
        $reflectionMethod = $reflectionClass->getMethod('keyAllow');
        $reflectionMethod->setAccessible(true);

        $result = $reflectionMethod->invokeArgs($rl, [$id]);

        $this->assertEquals($name.':'.$id.':allow', $result);
    }
}
