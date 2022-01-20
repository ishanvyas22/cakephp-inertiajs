<?php

    use Cake\Routing\Route\DashedRoute;
    use Cake\Routing\RouteBuilder;

    /** @var RouteBuilder $routes */
    $routes->plugin(
        'Inertia',
        ['path' => '/inertia'],
        function (RouteBuilder $routes) {
            $routes->fallbacks(DashedRoute::class);
        }
    );
