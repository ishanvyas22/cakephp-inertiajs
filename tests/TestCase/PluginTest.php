<?php

namespace Inertia\Test;

use Inertia\Plugin;
use TestApp\Application;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

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
}
