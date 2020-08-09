<?php
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
    public function setUp()
    {
        parent::setUp();
        $view = new View();
        $this->Inertia = new InertiaHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Inertia);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
