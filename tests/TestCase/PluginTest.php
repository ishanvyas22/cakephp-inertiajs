<?php

namespace Inertia\Test;

use Cake\TestSuite\IntegrationTestCase;
use Inertia\Plugin;
use TestApp\Application;

class PluginTest extends IntegrationTestCase
{
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
