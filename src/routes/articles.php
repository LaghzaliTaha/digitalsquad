<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';

$app = new \Slim\App;

$app->get('/', function ($request, $response, $args) {
    
    $response->getBody()->write("<h1>hello world</h1>");
    return $response;

});
//==================================> END POINTS FOR ARTICLES <==========================/
$app->get('/articles', function ($request, $response, $args=[]) {

    $articles = new Article();
    $response = $articles->getAllArticles();
    echo nl2br("\nList of articles:\n");
    foreach($response as $article) {
        echo nl2br($article->_id.' '.$article->title.' '.$article->body.' '.$article->date.' article has following comments :'."\n");
        foreach ($article->comments as $comment) {
            echo nl2br($comment."\n");
        }
    }
});

// Retrieve user with id 
$app->get('/articles/{id}', function (Request $request, Response $response, array $args) {
    $article = new Article();
    $response = $article->getArticleById($args['id']);

    echo nl2br("\n article serching for:\n");
    echo nl2br($response->_id.' '.$response->title.' '.$response->body.' '.$response->date.' article has following comments :'."\n");
        foreach ($response->comments as $comment) {
            echo nl2br($comment."\n");
        }
        
});

//add new article
$app->post('/articles', function ($request, $response, $args) {
    // Create new article
    
    $article = new Article();
    $comments = ["comment1","comment1","comment1","comment1","comment1"];
    $article->insertArticle("article1","khaoula khaoula khaoula khaoula khaoulakhaoula",$comments);
    
});

// Update article identified by $args['id']
$app->put('/articles/{id}', function ($request, $response, $args) {
    $article = new Article();
    $comments = ["comment1","comment1"];
    $article->updateArticle($args['id'],"khaoula1","khaoula1",$comments);
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


$app->run();