<?php
declare(strict_types=1);

namespace Inertia\Test\TestCase\View\Helper;

use Cake\TestSuite\TestCase;
use Cake\View\View;
use Inertia\View\Helper\InertiaHelper;

/**
 * Inertia\View\Helper\InertiaHelper Test Case
 */
class InertiaHelperTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Inertia\View\Helper\InertiaHelper
     */
    public $Inertia;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $view = new View();
        $this->Inertia = new InertiaHelper($view);
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testItReturnsRootTemplateDiv()
    {
        $page = [
            'component' => 'Users/Index',
            'url' => 'http://example.test/users',
            'props' => [
                'users' => [
                    ['id' => 1, 'name' => 'John Doe'],
                    ['id' => 2, 'name' => 'Jane Doe'],
                ],
            ],
        ];

        $result = $this->Inertia->make($page, 'app', 'container');

        $this->assertStringContainsString('<div id="app"', $result);
        $this->assertStringContainsString('page="{&quot;component&quot;:&quot;Users', $result);
        $this->assertStringContainsString('class="container"></div>', $result);
    }
}
