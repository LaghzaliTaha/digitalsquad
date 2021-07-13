<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';

$app = new \Slim\App;

$app->get('/', function ($request, $response, $args) {
    
    $response->getBody()->write("<h1>hello world</h1>");
    return $response;

});

$app->get('/articles', function ($request, $response, $args=[]) {
    $response = require_once('../collections/articles.php');
    return $response ;
});

$app->get('/articles/{id:[0-9]+}', function (Request $request, Response $response, array $args) {
    $response->getBody()->write("<H1>Hello, ".$args['id']."</H1>");
    return $response;
});

$app->post('/articles', function ($request, $response, $args) {
    // Create new article
    // ...
    
    return $response;
});

$app->put('/articles/{id}', function ($request, $response, $args) {
    // Update article identified by $args['id']
    // ...
    
    return $response;
});

$app->delete('/articles/{id}', function ($request, $response, $args) {
    // Delete article identified by $args['id']
    // ...
    
    return $response;
});

$app->run();