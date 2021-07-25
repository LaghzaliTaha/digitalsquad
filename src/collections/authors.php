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
    $user = array(
        "firstname" => $firstname,
        "lastname" => $lastname,
        "email" => $email,
        "image" => $image
    );

    try{
        $inserts = new MongoDB\Driver\BulkWrite();
        $inserts->insert($user);
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
    /*echo nl2br("\nList of authors:\n");
    echo json_encode(iterator_to_array($all_authors));*/
  }

    //Read Single Record ==> search for an author by name based on filter
  function getAuthorById($id){

$filter = ['_id' => $id];
$option = [];
$read = new MongoDB\Driver\Query($filter, $option);
$single_author = $this->con->executeQuery("digitalsquad.authors", $read);
return $single_author;
  }

   //Update Single Record
  function updateAuthor($id,$firstname,$lastname,$email,$image){
     
$updates = new MongoDB\Driver\BulkWrite();

$updates->update(
    ['firstname' => 'taha'],
    ['$set' => ['firstname' => 'khaoula1',
    'lastname' => $lastname,
    'email' => $email,
    'image' => $image]],
    ['multi' => true, 'upsert' => false]
);

$result = $this->con->executeBulkWrite("digitalsquad.authors", $updates);

if($result) {
	echo nl2br("\nRecord updated successfully \n");
}else {
    echo nl2br("\nRecord not updated \n");
}
}


//Delete Single/Multiple Records
function deleteAuthor($id){
$delete = new MongoDB\Driver\BulkWrite();
$delete->delete(
    ['_id' => $id],
    ['limit' => 1]
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
        ['_id' => ''],
        ['limit' => 100]
    );
    
    $result = $this->con->executeBulkWrite("digitalsquad.authors", $delete);
    
    if($result) {
        echo nl2br("Record deleted successfully \n");
    }else {
        echo nl2br("\nRecord not deleted \n");
    }
    }

}

	
        






