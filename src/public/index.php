<?php

require_once '../collections/articles.php';
require_once '../collections/authors.php';

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../../vendor/autoload.php';

header('Content-type:application/json;charset=utf-8');

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true
    ]
    ]);
    $app->options('/{routes:.+}', function ($request, $response, $args) {
        return $response;
    });
    
    $app->add(function ($req, $res, $next) {
        $response = $next($req, $res);
        return $response
                ->withHeader('Access-Control-Allow-Origin', 'http://localhost:7882')
                ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
    });
   
$app->get('/', function ($request, $response, $args) {
    
    $response->getBody()->write("<h1>hello world</h1>");
  
return $response;
});
//==================================> END POINTS FOR ARTICLES <==========================/
$app->get('/articles', function ($request, $response, $args=[]) {

    $articles = new Article();
    $response = $articles->getAllArticles();
    echo nl2br("\nList of articles:\n");
  
    
    echo json_encode(iterator_to_array($response));
});

// Retrieve user with id 
$app->get('/articles/{id}', function (Request $request, Response $response, array $args) {
    $article = new Article();
    $response = $article->getArticleById($args['id']);

    echo nl2br("\n article serching for:\n");
    foreach($response as $document) {
         echo nl2br($document->_id.' '.$document->title.' '.$document->body.' '.$document->date.' article has following comments :'."\n");
             foreach ($document->comments as $comment) {
             echo nl2br($comment."\n");
             }
      }



        
});

//add new article
$app->post('/articles', function ( Request $request, $response, $args) {
    // Create new article

     $parsedBody = $request->getParsedBody();
     $title = $parsedBody['title'] ?? false;
     $body = $parsedBody['body'] ?? false;
     $comments = $parsedBody['comments'] ?? false;

      $article = new Article();
      $article->insertArticle($title,$body,$comments);
    
});

// Update article identified by $args['id']
$app->put('/articles/{id}', function ($request, $response, $args) {
    $article = new Article();
    $parsedBody = $request->getParsedBody();
    $title = $parsedBody['title'] ?? false;
    $body = $parsedBody['body'] ?? false;
    $comments = $parsedBody['comments'] ?? false;
    $article->updateArticle($args['id'],$title, $body,$comments);
});

// Delete article identified by $args['id']
$app->delete('/articles/{id}', function ($request, $response, $args) {
    $article = new Article();
    $article->deleteArticle($args['id']);
});

// Delete all articles
$app->delete('/articles', function ($request, $response, $args) {
    $article = new Article();
    $article->deleteArticles();
});


//==================================> END POINTS FOR AUTHORS <==========================/
$app->get('/authors', function ($request, $response, $args=[]) {

    $authors = new Author();
    $response = $authors->getAllAuthors();
    echo nl2br("\nList of authors:\n");
    echo json_encode(iterator_to_array($response));
});

// Retrieve user with id 
$app->get('/authors/{id}', function (Request $request, Response $response, array $args) {
    $author = new Author();
    $response = $author->getAuthorById($args['id']);

    foreach($response as $document) {
        echo nl2br($document->_id.' '.$document->firstname.' '.$document->lastname.' '.$document->email.' '.$document->image."\n");
            
     }
});

//add new article
$app->post('/authors', function ($request, $response, $args) {
    // Create new author
    $author = new Author();
    $parsedBody = $request->getParsedBody();
    $firstname = $parsedBody['firstname'] ?? false;
    $lastname = $parsedBody['lastname'] ?? false;
    $email = $parsedBody['email'] ?? false;
    $image = $parsedBody['image'] ?? false;
    $response = $author->addAuthor($firstname,$lastname, $email,$image);

});

// Update article identified by $args['id']
$app->put('/authors/{id}', function ($request, $response, $args) {
    $author = new Author();
    $parsedBody = $request->getParsedBody();
    $firstname = $parsedBody['firstname'] ?? false;
    $lastname = $parsedBody['lastname'] ?? false;
    $email = $parsedBody['email'] ?? false;
    $image = $parsedBody['image'] ?? false;
    $author->updateAuthor($args['id'],$firstname,$lastname,$email,$image);
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






$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function($req, $res) {
    $handler = $this->notFoundHandler; // handle using the default Slim page not found handler
    return $handler($req, $res);
});
$app->run();
