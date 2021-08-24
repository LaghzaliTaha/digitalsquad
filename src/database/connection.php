<?php



        
class DbManager {

	//Database configuration
	private $dbhost = 'cluster0.8l5vi.mongodb.net';//localhost
    private $dbport = '27017';
    private $article = 'khaoulaelmajni';
    private $password = 'MC285849';
    private $dbname = 'digitalsquad';
	private $connection;
	
	function __construct(){
        //connectionecting to MongoDB
        try {
			//Establish database connectionection
            $this->connection = new MongoDB\Driver\Manager('mongodb+srv://'.$this->article.':'.$this->password.'@cluster0.8l5vi.mongodb.net/test?authSource=admin&replicaSet=atlas-tcpnwo-shard-0&readPreference=primary&ssl=true');
            echo json_encode(
                array("message" => "connection passed successfully")
                 );
        }catch (MongoDBDriverExceptionException $e) {
            echo $e->getMessage();
			echo nl2br("n");
        }
    }

	function getconnection() {
		return $this->connection;
	}

}





        ?>