<?php

namespace Inertia\Test\TestCase\Controller;

use Cake\TestSuite\TestCase;
use Inertia\Controller\InertiaResponse;
use Cake\TestSuite\IntegrationTestTrait;

class UsersControllerTest extends TestCase
{
    use IntegrationTestTrait, InertiaResponse;

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
}