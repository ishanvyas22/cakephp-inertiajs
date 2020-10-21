<?php

namespace Inertia\Test;

use Inertia\Plugin;
use TestApp\Application;
use Cake\TestSuite\TestCase;
use Cake\Http\MiddlewareQueue;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Http\Middleware\BodyParserMiddleware;

class PluginTest extends TestCase
{
    use IntegrationTestTrait;

    public function testBootstrap()
    {
        $plugin = new Plugin();
        $app = new Application(CONFIG);

        $plugin->bootstrap($app);
        $totalPlugins = $app->getPlugins();

        $this->assertCount(2, $totalPlugins);
        $this->assertSame('Inertia', $totalPlugins->get('Inertia')->getName());
        $this->assertSame('AssetMix', $totalPlugins->get('AssetMix')->getName());
    }

    public function testMiddleware()
    {
        $app = new Application(CONFIG);
        $middleware = new MiddlewareQueue();

        $middleware = $app->middleware($middleware);

        $this->assertInstanceOf(ErrorHandlerMiddleware::class, $middleware->get(0));
        $this->assertInstanceOf(AssetMiddleware::class, $middleware->get(1));
        $this->assertInstanceOf(BodyParserMiddleware::class, $middleware->get(2));
        $this->assertInstanceOf(RoutingMiddleware::class, $middleware->get(3));
    }
}
