<?php

namespace Inertia;

use Cake\Core\BasePlugin;
use Inertia\Middleware\InertiaMiddleware;

/**
 * Plugin for Inertia
 */
class Plugin extends BasePlugin
{
    /**
     * Add plugin specific middleware.
     *
     * @param \Cake\Http\MiddlewareQueue $middleware The middleware queue to update.
     * @return \Cake\Http\MiddlewareQueue
     */
    public function middleware($middleware)
    {
        // Add middleware here.
        $middleware->add(new InertiaMiddleware());

        return $middleware;
    }
}
