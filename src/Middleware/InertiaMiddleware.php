<?php

namespace Inertia\Middleware;

use Cake\Http\Response;
use Inertia\Utility\Message;

class InertiaMiddleware
{
    /**
     * Invoke method.
     *
     * @param \Cake\Http\ServerRequest $request The request.
     * @param \Cake\Http\Response $response The response.
     * @param callable $next Callback to invoke the next middleware.
     * @return \Cake\Http\Response A response
     */
    public function __invoke($request, $response, $next)
    {
        if (! $request->hasHeader('X-Inertia')) {
            return $next($request, $response);
        }

        $this->setupDetectors($request);

        $response = $next($request, $response);

        if (
            $response instanceof Response
            && $response->getStatusCode() === Message::STATUS_FOUND
            && in_array($request->getMethod(), [Message::METHOD_PUT, Message::METHOD_PATCH, Message::METHOD_DELETE])
        ) {
            $response = $response->withStatus(Message::STATUS_SEE_OTHER);
        }

        return $response
            ->withHeader('Vary', 'Accept')
            ->withHeader('X-Inertia', 'true');
    }

    /**
     * Set detectors in the request to use it throughout the application.
     *
     * @param  \Cake\Http\ServerRequest $request The request.
     * @return void
     */
    private function setupDetectors($request)
    {
        $request->addDetector('inertia', function ($request) {
            return $request->hasHeader('X-Inertia');
        });

        $request->addDetector('inertia-partial-component', function ($request) {
            return $request->hasHeader('X-Inertia-Partial-Component');
        });

        $request->addDetector('inertia-partial-data', function ($request) {
            return $request->hasHeader('X-Inertia-Partial-Data');
        });
    }
}
