<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


require_once("../database/connection.php");

     $collection = 'authors';
	
        $user1 = array(
            "firstname" => "taha",
            "lastname" => "laghzali",
            "email" => "tahalaghzali@gmail.com",
            "image" => "http://img.bbystatic.com/BestBuy_US/images/products/1276/127687_sa.jpg"
        );
        $user2 = array(
            "firstname" => "khaoula",
            "lastname" => "elmajni",
            "email" => "elmajnikhaoula99@gmail.com",
            "image" => "http://img.bbystatic.com/BestBuy_US/images/products/1276/127687_sa.jpg"
    );

        try{
            $inserts = new MongoDB\Driver\BulkWrite();
            $inserts->insert($user1);
            $inserts->insert($user2);
            $connection->executeBulkWrite("$dbname.$collection", $inserts);
            echo "\ninserts passed successfully\n";
        }catch (MongoDBDriverExceptionException $e) {
            echo $e->getMessage();
			echo nl2br("n");
        }

//Records Read
$filter = [];
$option = [];

$read = new MongoDB\Driver\Query($filter, $option);

$all_authors = $connection->executeQuery("$dbname.$collection", $read);

echo nl2br("\nList of authors:\n");
echo json_encode(iterator_to_array($all_authors));
/*foreach($all_authors as $author) {
	echo nl2br($author->_id.' '.$author->firstname.' '.$author->lastname.' '.$author->email."\n");
	
}*/


//Read Single Record ==> search for an author by name based on filter

$filter = ['firstname' => 'khaoula'];
$option = [];
$read = new MongoDB\Driver\Query($filter, $option);
$single_author = $connection->executeQuery("$dbname.$collection", $read);

echo nl2br("\n user serching for:\n");
echo json_encode(iterator_to_array($single_author));
/*foreach ($single_author as $author) {
	echo nl2br($author->_id.' '.$author->firstname.' '.$author->lastname.' '.$author->email."\n");
	
}*/

//Update Single Record
$updates = new MongoDB\Driver\BulkWrite();
//multiple updates
$updates->update(
    ['firstname' => 'khaoula'],
    ['$set' => ['firstname' => 'khaoula1']],
    ['multi' => true, 'upsert' => false]
);
$updates->update(
    ['firstname' => 'taha'],
    ['$set' => ['firstname' => 'taha1']],
    ['multi' => true, 'upsert' => false]
);

$result = $connection->executeBulkWrite("$dbname.$collection", $updates);

if($result) {
	echo nl2br("\nRecord updated successfully \n");
}

//Delete Single/Multiple Records

$delete = new MongoDB\Driver\BulkWrite();
$delete->delete(
    ['firstname' => 'khaoula'],
    ['limit' => 1]
);

$result = $connection->executeBulkWrite("$dbname.$collection", $delete);

if($result) {
	echo nl2br("Record deleted successfully \n");
}

