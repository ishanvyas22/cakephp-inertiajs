<?php
declare(strict_types=1);

namespace TestApp;

use Cake\Http\BaseApplication;
use Cake\Http\MiddlewareQueue;

class Application extends BaseApplication
{
    /**
     * Setup the middleware queue your application will use.
     *
     * @param \Cake\Http\MiddlewareQueue $middlewareQueue The middleware queue to setup.
     * @return \Cake\Http\MiddlewareQueue The updated middleware queue.
     */
    public function middleware($middlewareQueue): MiddlewareQueue
    {
        return $middlewareQueue;
    }
}