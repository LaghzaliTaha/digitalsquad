<?php


header('Content-type:application/json;charset=utf-8');
class Author{
    private $con;
    private $collection = 'authors';

   function __construct() {
    require_once("../database/connection.php");
    $db = new DbManager();
    //Connect to database
    $this->con = $db->getconnection();
  }

  //add new author
  function addAuthor($firstname,$lastname,$email,$image){
    
 

    try{
        $inserts = new MongoDB\Driver\BulkWrite;
        $inserts->insert(  [ 'firstname' => $firstname,
        'lastname' => $lastname,
        'email' => $email,
        'image' => $image] );
        $this->con->executeBulkWrite("digitalsquad.authors", $inserts);
        echo "\ninserts passed successfully\n";
    }catch (MongoDBDriverExceptionException $e) {
        echo $e->getMessage();
        echo nl2br("n");
    }
  }

  //Records Read
  function getAllAuthors(){
    $filter = [];
    $option = [];
    
    $read = new MongoDB\Driver\Query($filter, $option);
    
    $all_authors = $this->con->executeQuery("digitalsquad.authors", $read);
    
    return $all_authors;
  
  }

    //Read Single Record ==> search for an author by name based on filter
  function getAuthorById($id1){

    $id           = new \MongoDB\BSON\ObjectId($id1);
    $filter      = ['_id' => $id];
    $options = [];
    $read = new MongoDB\Driver\Query($filter, $options);
    $cursor =$this->con->executeQuery("digitalsquad.authors", $read);
    return $cursor;
  }

   //Update Single Record
  function updateAuthor($id1,$firstname,$lastname,$email,$image){
     
        $updates = new MongoDB\Driver\BulkWrite();
        $id           = new \MongoDB\BSON\ObjectId($id1);
        $updates->update(
            ['_id' => $id],
            ['$set' => ['firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'image' => $image]],
           // ['multi' => true, 'upsert' => false]
        );

        $result = $this->con->executeBulkWrite("digitalsquad.authors", $updates);

        if($result) {
            echo nl2br("\nRecord updated successfully \n");
        }else {
            echo nl2br("\nRecord not updated \n");
        }
}


//Delete Single/Multiple Records
function deleteAuthor($id1){
$delete = new MongoDB\Driver\BulkWrite();
$id           = new \MongoDB\BSON\ObjectId($id1);
$filter      = ['_id' => $id];
$delete->delete(
    $filter 
);

$result = $this->con->executeBulkWrite("digitalsquad.authors", $delete);

if($result) {
	echo nl2br("Record deleted successfully \n");
}else {
    echo nl2br("\nRecord not deleted \n");
}
}


//Delete all Records
function deleteAuthors(){
    $delete = new MongoDB\Driver\BulkWrite();
    $delete->delete(
       []
    );
    
    $result = $this->con->executeBulkWrite("digitalsquad.authors", $delete);
    
    if($result) {
        echo nl2br(" ALL Record deleted successfully \n");
    }else {
        echo nl2br("\nRecord not deleted \n");
    }
    }

}

	
        






