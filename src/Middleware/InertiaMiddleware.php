<?php
declare(strict_types=1);

namespace Inertia\Middleware;

use Cake\Http\ServerRequest;
use Inertia\Utility\Message;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class InertiaMiddleware implements MiddlewareInterface
{
    /**
     * Invoke method.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request The request.
     * @param \Psr\Http\Server\RequestHandlerInterface $handler The request handler.
     * @return \Psr\Http\Message\ResponseInterface A response.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($request instanceof ServerRequest) {
            $this->setupDetectors($request);
        }
        if (!$request->hasHeader('X-Inertia')) {
            return $handler->handle($request);
        }

        $response = $handler->handle($request);
        if (
            $response->getStatusCode() === Message::STATUS_FOUND
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
     * @param \Cake\Http\ServerRequest $request The request.
     * @return void
     */
    private function setupDetectors(ServerRequest $request): void
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
