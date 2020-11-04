<?php

namespace Inertia\Test;

use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Http\MiddlewareQueue;
use Cake\Http\Middleware\BodyParserMiddleware;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Inertia\Plugin;
use TestApp\Application;

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

        $results = iterator_to_array($middleware);
        $this->assertInstanceOf(ErrorHandlerMiddleware::class, $results[0]);
        $this->assertInstanceOf(AssetMiddleware::class, $results[1]);
        $this->assertInstanceOf(BodyParserMiddleware::class, $results[2]);
        $this->assertInstanceOf(RoutingMiddleware::class, $results[3]);
    }
}
