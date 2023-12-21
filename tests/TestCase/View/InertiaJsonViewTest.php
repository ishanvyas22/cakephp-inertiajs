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

        $request = new ServerRequest();
        $response = new Response();

        // Set `inertia` detector to test `InertiaJsonView` class
        $request->addDetector('inertia', function ($request) {
            return true;
        });

        $this->View = new InertiaJsonView($request, $response);
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
            'component' => '/',
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
