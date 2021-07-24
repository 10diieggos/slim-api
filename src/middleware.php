<?php

use Slim\App;

return function (App $app) {
    $container = $app->getContainer();
    
    //php composer.phar require tuupola/slim-jwt-auth
    $app->add(new Tuupola\Middleware\JwtAuthentication([
        "header" => "X-Token",
        "regexp" => "/(.*)/",
        "path" => ["/api"],
        "ignore" => ["/api/token"],
        "secret" => $container->get('settings')['secretKey']
    ]));

    //The following code should enable lazy CORS.
    $app->add(function ($req, $res, $next) {
        $response = $next($req, $res);
        return $response
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
    });
    
};
