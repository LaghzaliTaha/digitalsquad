<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

$app = new \Slim\App;

$app->get('/', function ($request, $response, $args) {
    
    $response->getBody()->write("<h1>hello world</h1>");
    return $response;

});

/*$app->get('/authors', function ($request, $response, $args=[]) {
    $data= json_decode(file_get_contents('authors.json'), true);
    //$response->getBody()->write($data["data"]);
    $response = $response->withHeader('Content-type', 'application/json');
    $response = $response->withJson($data, 201);
    return $response ;

});*/

$app->get('/authors', function ($request, $response, $args=[]) {
    $response = require_once('../collections/authors.php');
    
    return $response ;
});

$app->run();