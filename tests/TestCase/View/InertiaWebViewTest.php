<?php
namespace Inertia\Test\TestCase\View;

use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\TestSuite\TestCase;
use Inertia\View\InertiaWebView;

class InertiaWebViewTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $request = new ServerRequest();
        $response = new Response();
        $this->View = new InertiaWebView($request, $response);
    }

    public function testRendersDivWithIdAppAttribute()
    {
        $this->View->set('user', ['id' => 1, 'name' => 'John Doe']);

        $result = $this->View->render();

        $this->assertContains("<div class='container clearfix' id='app'", $result);
        $this->assertContains('"props":{"user":{"id":1,"name":"John Doe"}}', $result);
    }

    public function testRendersComponentName()
    {
        $this->View->set('component', 'Users/Index');
        $this->View->set('user', ['id' => 1, 'name' => 'John Doe']);

        $result = $this->View->render();

        $this->assertContains(json_encode('Users/Index'), $result);
    }
}
