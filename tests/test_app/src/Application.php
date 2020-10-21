<?php

namespace TestApp;

use Cake\Core\Configure;
use Cake\Http\BaseApplication;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Http\Middleware\BodyParserMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;
use Cake\Error\Middleware\ErrorHandlerMiddleware;

class Application extends BaseApplication
{
    /**
     * Setup the middleware queue your application will use.
     *
     * @param \Cake\Http\MiddlewareQueue $middlewareQueue The middleware queue to setup.
     * @return \Cake\Http\MiddlewareQueue The updated middleware queue.
     */
    public function middleware($middlewareQueue)
    {
        return $middlewareQueue
            ->add(new ErrorHandlerMiddleware(null, Configure::read('Error')))
            ->add(new AssetMiddleware())
            ->add(new BodyParserMiddleware())
            ->add(new RoutingMiddleware($this));
    }
}
