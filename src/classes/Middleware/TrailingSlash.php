<?php

namespace ScholarshipApi\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Middleware to add or remove the trailing slash.
 */
class TrailingSlash
{
    /**
     * @var bool Add or remove the slash
     */
    private $addSlash;

    /**
     * Configure whether add or remove the slash.
     *
     * @param bool $addSlash
     */
    public function __construct($addSlash = true)
    {
        $this->addSlash = (bool) $addSlash;
    }

    /**
     * Execute the middleware.
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param callable               $next
     *
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        $uri = $request->getUri();
        $path = $uri->getPath();

        //Add/remove slash
        if (strlen($path) > 1) {
            if ($this->addSlash) {
                if (substr($path, -1) !== '/' && !pathinfo($path, PATHINFO_EXTENSION)) {
                    $path .= '/';
                }
            } else {
                $path = rtrim($path, '/');
            }
        } elseif ($path === '') {
            $path = '/';
        }

        //redirect
        if ($uri->getPath() !== $path) {
            return $response->withRedirect($uri->withPath($path), 301);
        }

        return $next($request->withUri($uri->withPath($path)), $response);
    }
}