<?php

namespace Inertia\Middleware;

use Inertia\Utility\Message;
use Cake\Http\Response;

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
        $response = $next($request, $response);

        if (! $request->hasHeader('X-Inertia')) {
            return $response;
        }

        $this->setupDetector($request);

        if ($response instanceof Response
            && $response->getStatusCode() === Message::STATUS_FOUND
            && in_array($request->getMethod(), [Message::METHOD_PUT, Message::METHOD_PATCH, Message::METHOD_DELETE])
        ) {
            $response->withStatus(Message::STATUS_SEE_OTHER);
        }

        return $response;
    }

    /**
     * Set `inertia` detector in the request to use it throughout the application.
     *
     * @param  \Cake\Http\ServerRequest $request The request.
     * @return void
     */
    private function setupDetector($request)
    {
        $request->addDetector('inertia', function ($request) {
            return $request->hasHeader('X-Inertia');
        });
    }
}
