<?php
// Application middleware
$app->add(new \Slim\Middleware\Session([
    'name' => 'fau_cookie',
    'autorefresh' => true,
    'lifetime' => '30 minutes',
    'secure' => true,
    'httponly' => true
]));

$app->add(new \ScholarshipApi\Middleware\TrailingSlash());
// e.g: $app->add(new \Slim\Csrf\Guard);