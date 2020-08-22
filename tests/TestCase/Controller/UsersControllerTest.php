<?php

namespace Inertia\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Inertia\Controller\InertiaResponseTrait;

class UsersControllerTest extends TestCase
{
    use InertiaResponseTrait;
    use IntegrationTestTrait;

    public function testItReturnsInertiaWebViewResponseWithDefaultConvention()
    {
        $this->get('/users/index');

        $this->assertResponseOk();
        $this->assertContentType('text/html');
        $this->assertTemplate('app');
        $this->assertResponseContains(json_encode('Users/Index'));
        $this->assertResponseContains(json_encode('http://localhost/users/index'));
        $this->assertResponseContains('"name":"InertiaTestApp"');
        $this->assertResponseContains('"props"');
    }

    public function testItReturnsInertiaWebViewResponseWithCustomComponent()
    {
        $this->get('/users/custom-component');

        $this->assertResponseOk();
        $this->assertContentType('text/html');
        $this->assertTemplate('app');
        $this->assertResponseContains(json_encode('Custom/Component'));
    }

    public function testItReturnsInertiaJsonViewResponseWhenRequestIsXInertia()
    {
        $this->configRequest([
            'headers' => ['X-Inertia' => 'true']
        ]);

        $this->get('/users/index');

        $this->assertResponseOk();
        $this->assertContentType('application/json');
    }
}
