<?php

namespace InertiaCake\Middleware;

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

        //     return Response::make('', 409, ['X-Inertia-Location' => $request->fullUrl()]);
        // }

        // if ($response instanceof Redirect && $response->getStatusCode() === 302 && in_array($request->method(), ['PUT', 'PATCH', 'DELETE'])) {
        //     $response->setStatusCode(303);
        // }

        return $response;
    }
}
