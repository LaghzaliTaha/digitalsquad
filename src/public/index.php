<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';


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
    return $response;
});

$app->get('/articles', function ($request, $response, $args=[]) {
    $response = require_once('../collections/articles.php');
    return $response;
});




// Retrieve user with id 
//this is a placeholder named id that requires one or more digits.
$app->get('/authors/{id:[0-9]+}', function (Request $request, Response $response, array $args) {
    $response->getBody()->write("<H1>Hello, ".$args['id']."</H1>");
    return $response;
});

$app->post('/authors', function ($request, $response, $args) {
    // Create new author
    
    
    return $response;
});

$app->put('/authors/{id}', function ($request, $response, $args) {
    // Update author identified by $args['id']
    // ...
    
    return $response;
});

$app->delete('/authors/{id}', function ($request, $response, $args) {
    // Delete author identified by $args['id']
    // ...
    
    return $response;
});


/*$app->any('/authors/[{id}]', function ($request, $response, $args) {
    // Apply changes to authors or author identified by $args['id'] if specified.
    // To check which method is used: $request->getMethod();
    // ...
    
    return $response;
});*/

$app->run();
