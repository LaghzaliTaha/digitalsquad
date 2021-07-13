<?php

include_once("../database/connection.php");

     $collection = 'articles';

    function insertArticle(){
        $article = array(
            "date" => date('l d m Y h:i:s'),
            "title" => "Lorem ipsum",
            "body" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur autem odio cum suscipit consectetur illum ab quam architecto tempora voluptates. Itaque nihil libero iste harum pariatur molestiae ipsam commodi dolorem?",
            "comments" => ["comment1","comment2","comment3","comment4"]
        );
        

        try{
            $inserts = new MongoDB\Driver\BulkWrite();
            $inserts->insert($article1);
            $connection->executeBulkWrite("$dbname.$collection", $inserts);
            echo "\ninserts passed successfully\n";
        }catch (MongoDBDriverExceptionException $e) {
            echo $e->getMessage();
			echo nl2br("n");
        }
    }


//Records Read
function readAllArticles(){
    $filter = [];
    $option = [];
    
    $read = new MongoDB\Driver\Query($filter, $option);
    
    $all_articles = $connection->executeQuery("$dbname.$collection", $read);
    
    echo nl2br("\nList of articles:\n");
    
    foreach($all_articles as $article) {
        echo nl2br($article->_id.' '.$article->title.' '.$article->body.$article->date.' article has following comments :'."\n");
        foreach ($article->comments as $comment) {
            echo nl2br($comment."\n");
        }
    }
}



//Read Single Record ==> search for an article by name based on filter
function readArticleByName(){
    $filter = ['title' => 'lorem ipsum'];
    $option = [];
    $read = new MongoDB\Driver\Query($filter, $option);
    $single_article = $connection->executeQuery("$dbname.$collection", $read);
    
    echo nl2br("\n article serching for:\n");
    
    foreach ($single_article as $article) {
        echo nl2br($article->_id.' '.$article->title.' '.$article->body.$article->date.' '.$article->date."\n");
        
    }
}


//Update Single Record
function updateArticle(){
    $updates = new MongoDB\Driver\BulkWrite();
    //multiple updates
    $updates->update(
        ['title' => 'lorem ipsum'],
        ['$set' => ['title' => 'khaoula elmajni']],
        ['multi' => true, 'upsert' => false]
    );
    /*$updates->update(
        ['title' => 'lorem ipsum1'],
        ['$set' => ['title' => 'digital squad']],
        ['multi' => true, 'upsert' => false]
    );*/
    
    $result = $connection->executeBulkWrite("$dbname.$collection", $updates);
    
    if($result) {
        echo nl2br("\nRecord updated successfully \n");
    }
}


//Delete Single/Multiple Records
function deleteArticle(){
    $delete = new MongoDB\Driver\BulkWrite();
    $delete->delete(
        ['title' => 'lorem ipsum1'],
        ['limit' => 12]
    );
    
    $result = $connection->executeBulkWrite("$dbname.$collection", $delete);
    
    if($result) {
        echo nl2br("Record deleted successfully \n");
    }
}

