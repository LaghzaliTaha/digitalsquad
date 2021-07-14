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

//==================================> END POINTS FOR AUTHORS <==========================/
$app->get('/authors', function ($request, $response, $args=[]) {

    $authors = new Author();
    $response = $authors->getAllAuthors();
    echo nl2br("\nList of articles:\n");
    foreach($response as $author) {
        echo nl2br($author->_id.' '.$author->firstname.' '.$author->lastname.' '.$author->email.' '.$author->image."\n");
        
    }
});

// Retrieve user with id 
$app->get('/authors/{id}', function (Request $request, Response $response, array $args) {
    $author = new Author();
    $response = $author->getAuthorById($args['id']);

    echo nl2br("\n user serching for:\n");
    echo nl2br($response->_id.' '.$response->firstname.' '.$response->lastname.' '.$response->email.' '.$response->image."\n");
        
});

//add new article
$app->post('/authors', function ($request, $response, $args) {
    // Create new author
    $author = new Author();
    $response = $author->addAuthor("khaoula","khaoula","elmajnikhaoula99@gmail.com","http://img.bbystatic.com/BestBuy_US/images/products/4390/43900_sa.jpg");

});

// Update article identified by $args['id']
$app->put('/authors/{id}', function ($request, $response, $args) {
    $author = new Author();
    $author->updateAuthor($args['id'],"khaoula1","khaoula1","elmajnikhaoula99@gmail.com","http://img.bbystatic.com/BestBuy_US/images/products/4390/43900_sa.jpg");
});

// Delete article identified by $args['id']
$app->delete('/authors/{id}', function ($request, $response, $args) {
    $author = new Author();
    $author->deleteAuthor($args['id']);
});

// Delete all articles
$app->delete('/authors', function ($request, $response, $args) {
    $author = new Author();
    $author->deleteAuthors();
});





//Retrieve user with title
/*$app->get('/articles/{title}', function (Request $request, Response $response, array $args) {
    $articles = new Article();
    $response = $articles->getArticleByTitle($args['title']);

    echo nl2br("\n article serching for:\n");

        foreach ($response as $article) {
            echo nl2br($article->_id.' '.$article->title.' '.$article->body.$article->date.' '.$article->date."\n");
            
        }
});*/


/*$app->any('/authors/[{id}]', function ($request, $response, $args) {
    // Apply changes to authors or author identified by $args['id'] if specified.
    // To check which method is used: $request->getMethod();
    // ...
    
    return $response;
});*/

$app->run();