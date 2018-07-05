<?php
// Application middleware

$app->add(function($req, $res, $next) {
    $response = $next($req, $res);

    return $response->withAddedHeader('Access-Control-Allow-Origin', '*');
});

// e.g: $app->add(new \Slim\Csrf\Guard);