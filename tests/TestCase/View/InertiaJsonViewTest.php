<?php
declare(strict_types=1);

namespace Inertia\Test\TestCase\View;

use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\TestSuite\TestCase;
use Inertia\View\InertiaJsonView;

class InertiaJsonViewTest extends TestCase
{
    public $View;

    public function setUp(): void
    {
        parent::setUp();

        /**
         * Prepare request
         */
        $request = new ServerRequest();
        $request = $request
            ->withParam('controller', 'Pages')
            ->withParam('action', 'display');
        // Set `inertia` detector to test `InertiaJsonView` class
        $request->addDetector('inertia', function ($request) {
            return true;
        });
        $request->addDetector('inertia-partial-component', function ($request) {
            return false;
        });
        $request->addDetector('inertia-partial-data', function ($request) {
            return false;
        });

        $this->View = new InertiaJsonView($request, new Response());
    }

    public function testReturnsJsonResponseWithGivenData()
    {
        $user = ['id' => 1, 'name' => 'John Doe'];

        $this->View->set(compact('user'));

        $resultJson = json_encode(json_decode($this->View->render()));
        $resultArray = json_decode($resultJson, true);

        $this->assertEquals('application/json', $this->View->getResponse()->getType());
        $this->assertArrayHasKey('component', $resultArray);
        $this->assertArrayHasKey('url', $resultArray);
        $this->assertArrayHasKey('props', $resultArray);
        $this->assertArrayHasKey('user', $resultArray['props']);
        $this->assertJsonStringEqualsJsonString(json_encode([
            'component' => 'Pages/Display',
            'url' => 'http://localhost/',
            'props' => ['user' => $user],
        ]), $resultJson);
    }

    public function testJsonViewReturnsCustomComponentName()
    {
        $component = 'Users/Index';
        $user = ['id' => 1, 'name' => 'John Doe'];

        $this->View->set(compact('component', 'user'));

        $resultJson = json_encode(json_decode($this->View->render()));

        $this->assertJsonStringEqualsJsonString(json_encode([
            'component' => 'Users/Index',
            'url' => 'http://localhost/',
            'props' => ['user' => $user],
        ]), $resultJson);
    }
}
