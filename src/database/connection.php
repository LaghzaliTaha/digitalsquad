<?php
//Database configuration
	 $dbhost = 'cluster0.8l5vi.mongodb.net';//cluster0.8l5vi.mongodb.net//localhost
	 $dbport = '27017';
     $article = 'khaoulaelmajni';
     $password = 'MC285849';
     $dbname = 'digitalsquad';


     //string : mongodb+srv://khaoulaelmajni:MC285849@cluster0.8l5vi.mongodb.net/test?authSource=admin&replicaSet=atlas-tcpnwo-shard-0&readPreference=primary&ssl=true
        //connectionecting to MongoDB
        try {
			//Establish database connectionection
            //$connection = new MongoDB\Driver\Manager('mongodb://'.$dbhost.':'.$dbport);
            $connection = new MongoDB\Driver\Manager('mongodb+srv://'.$article.':'.$password.'@cluster0.8l5vi.mongodb.net/test?authSource=admin&replicaSet=atlas-tcpnwo-shard-0&readPreference=primary&ssl=true');
            echo json_encode(
                array("message" => "connection passed successfully")
                 );
        }catch (MongoDBDriverExceptionException $e) {
            echo $e->getMessage();
			echo nl2br("n");
        }




        ?>