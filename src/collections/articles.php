<?php

header('Content-type:application/json;charset=utf-8');
class Article{
    private $con;
    private $collection = 'articles';

   function __construct() {
    require_once("../database/connection.php");
    $db = new DbManager();
    //Connect to database
    $this->con = $db->getconnection();
  }

  function insertArticle($title,$body,$comments){

    try{
        $inserts = new MongoDB\Driver\BulkWrite;
        $inserts->insert(['date' => date('l d m Y h:i:s'), 'title' => $title, 'body' => $body,'comments' => $comments]);
        $this->con->executeBulkWrite("digitalsquad.articles", $inserts);
        echo "\ninserts passed successfully\n";
    }catch (MongoDBDriverExceptionException $e) {
        echo $e->getMessage();
        echo nl2br("n");
    }
}


    //Records Read
    function getAllArticles(){
    $filter = [];
    $option = [];

    $read = new MongoDB\Driver\Query($filter, $option);

    $all_articles = $this->con->executeQuery("digitalsquad.articles", $read);
        return $all_articles;
    
    }

    //Read Single Record ==> search for an article by _id
    function getArticleById($id1){
        $id           = new \MongoDB\BSON\ObjectId($id1);
        $filter      = ['_id' => $id];
        $options = [];
        $read = new MongoDB\Driver\Query($filter, $options);
        $cursor =$this->con->executeQuery("digitalsquad.articles", $read);
 

        return $cursor;
    }

    //Read Single Record ==> search for an article by title 
    function getArticleByTitle($title){
        $filter = ['title' => $title];
        $option = [];
        $read = new MongoDB\Driver\Query($filter, $option);
        $single_article = $this->con->executeQuery("digitalsquad.articles", $read);

        echo nl2br("\n article serching for:\n");

        foreach ($single_article as $article) {
            echo nl2br($article->_id.' '.$article->title.' '.$article->body.$article->date.' '.$article->date."\n");
            
        }
    }

    


    //Update Single Record
    function updateArticle($id1,$title,$body,$comments){
    $updates = new MongoDB\Driver\BulkWrite();
    $id           = new \MongoDB\BSON\ObjectId($id1);
   
    //multiple updates
    
   $updates->update(['_id' => $id], 
        ['$set' => ['title' => $title,
        'body' => $body,
        'comments' => $comments]],
      //  ['multi' => true, 'upsert' => false]
    );
   

    $result = $this->con->executeBulkWrite("digitalsquad.articles", $updates);

    if($result) {
        echo nl2br("\nRecord updated successfully \n");
    }
    }


    //Delete Single/Multiple Records
    function deleteArticle($id1){
    $delete = new MongoDB\Driver\BulkWrite();
    $id           = new \MongoDB\BSON\ObjectId($id1);
    $filter      = ['_id' => $id];
 
    $delete->delete(
        $filter 
    );

    $result = $this->con->executeBulkWrite("digitalsquad.articles", $delete);

    if($result) {
        echo nl2br("Record deleted successfully \n");
    }
    }

    //Delete Single/Multiple Records
    function deleteArticles(){
        $delete = new MongoDB\Driver\BulkWrite();
        $delete->delete([]
        );
    
        $result = $this->con->executeBulkWrite("digitalsquad.articles", $delete);
    
        if($result) {
            echo nl2br( " ALLRecords are deleted successfully \n");
        }
        }


}
     

 