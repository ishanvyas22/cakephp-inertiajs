<?php
namespace InertiaCake\Test\TestCase\Controller\Component;

use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;
use InertiaCake\Controller\Component\RenderComponent;

/**
 * InertiaCake\Controller\Component\RenderComponent Test Case
 */
class RenderComponentTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \InertiaCake\Controller\Component\RenderComponent
     */
    public $Render;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Render = new RenderComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Render);

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
