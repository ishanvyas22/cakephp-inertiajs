<?php

namespace Inertia\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Inertia\Controller\InertiaResponseTrait;
use Inertia\Utility\Message;

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
        $this->assertResponseContains('&quot;Users\/Index&quot');
        $this->assertResponseContains('&quot;http:\/\/localhost\/users\/index&quot');
        $this->assertResponseContains('&quot;name&quot;:&quot;InertiaTestApp&quot;');
        $this->assertResponseContains('props');
    }

    public function testItReturnsInertiaWebViewResponseWithCustomComponent()
    {
        $this->get('/users/custom-component');

        $this->assertResponseOk();
        $this->assertContentType('text/html');
        $this->assertTemplate('app');
        $this->assertResponseContains(htmlentities(json_encode('Custom/Component')));
    }

    public function testItReturnsInertiaJsonViewResponseWhenRequestIsXInertia()
    {
        $this->configRequest([
            'headers' => ['X-Inertia' => 'true'],
        ]);

        $this->get('/users/index');

        $this->assertResponseOk();
        $this->assertContentType('application/json');
    }

    public function testPartiaReloads()
    {
        $this->configRequest([
            'headers' => [
                'X-Inertia' => 'true',
                'X-Inertia-Partial-Data' => 'posts,postsCount',
                'X-Inertia-Partial-Component' => 'Users/Index',
            ],
        ]);

        $this->get('/users/index');

        $this->assertContentType('application/json');
        $this->assertResponseOk();

        $expected = json_encode([
            'component' => 'Users/Index',
            'url' => 'http://localhost/users/index',
            'props' => [
                'posts' => [
                    [
                        'title' => 'Title 1',
                        'body' => 'Body of title 1',
                    ],
                    [
                        'title' => 'Title 2',
                        'body' => 'Body of title 2',
                    ],
                ],
                'postsCount' => 2,
            ],
        ], JSON_PRETTY_PRINT);
        $this->assertEquals($expected, $this->_getBodyAsString());
    }

    public function testItRedirectsWithSeeOtherResponseCode()
    {
        $this->configRequest([
            'headers' => ['X-Inertia' => 'true'],
        ]);

        $this->put('/users/store', ['test' => 'data']);

        $this->assertResponseCode(Message::STATUS_SEE_OTHER);
    }

    public function testItReturnsHtmlResultFor404()
    {
        $this->configRequest([
            'headers' => [
                'X-Inertia' => 'true',
                'X-Requested-With' => 'XMLHttpRequest',
            ],
        ]);

        $this->get('/404');

        $this->assertResponseCode(404);
        $this->assertContentType('text/html');
    }

    public function testItReturnsHtmlResultFor500()
    {
        $this->configRequest([
            'headers' => [
                'X-Inertia' => 'true',
                'X-Requested-With' => 'XMLHttpRequest',
            ],
        ]);

        $this->get('/users/internal-server-error');

        $this->assertResponseCode(500);
        $this->assertContentType('text/html');
    }

    public function testItSetsFlashDataIntoProps()
    {
        $this->configRequest([
            'headers' => ['X-Inertia' => 'true'],
        ]);

        $this->get('/users/check-flash-data');
        $responseArray = json_decode($this->_getBodyAsString(), true);

        $this->assertResponseOk();
        $this->assertArrayHasKey('flash', $responseArray['props']);
        $this->assertEquals([
            [
                'message' => 'User saved successfully.',
                'key' => 'flash',
                'element' => 'Flash/success',
                'params' => [],
            ],
        ], $responseArray['props']['flash']);
    }
}
