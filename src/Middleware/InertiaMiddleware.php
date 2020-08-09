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
        // Calling $next() delegates control to the *next* middleware
        // In your application's queue.
        $response = $next($request, $response);

        if (! $request->hasHeader('X-Inertia')) {
            return $response;
        }

        // if ($request->getMethod() === 'GET' && $request->getHeader('X-Inertia-Version') !== Inertia::getVersion()) {
        //     if ($request->getSession()) {
        //         $request->getSession()->reflash();
        //     }

        //     return Response::make('', Message::STATUS_CONFLICT, ['X-Inertia-Location' => $request->fullUrl()]);
        // }

        if ($response instanceof Response
            && $response->getStatusCode() === Message::STATUS_FOUND
            && in_array($request->getMethod(), [Message::METHOD_PUT, Message::METHOD_PATCH, Message::METHOD_DELETE])
        ) {
            $response->withStatus(Message::STATUS_SEE_OTHER);
        }

        return $response;
    }
}
