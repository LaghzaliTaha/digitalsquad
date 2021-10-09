
<?php require_once 'validate.php'; ?>
 <?php

const wrong_email ="Please Type Correct Email";
const empty_email = "Please enter your email ";
const sent_email="Email is sent!";
const try_again="Something is wrong  try again";

    if (isset($_POST['email']) && !empty($_POST['email'])) {
       $email = $_POST['email'];
       }

$url = 'https://api.elasticemail.com/v2/email/send';

try{
        $post = array('from' => 'laghzalitaha0@gmail.com',
		'fromName' => 'digitalsquad.ma',
		'apikey' => '6B10CBC949516C30802AFFF1A9AFDAE1793A3958A16B8CA9AF803299B68AB5E6B8C5A591CEAD57525F91EDDFE0580BA8',
		'subject' => 'Your Subject',
		'to' => 'laghzalitaha0@gmail.com',
		'bodyHtml' => '<h1>Html Body</h1>',
		'bodyText' => 'Text Body',
		'isTransactional' => false);

		$ch = curl_init();
		curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => $post,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
			CURLOPT_SSL_VERIFYPEER => false
        ));

        $result=curl_exec ($ch);
        curl_close ($ch);

        echo $result;
}
catch(Exception $ex){
	echo $ex->getMessage();
}


        $res =["success" => $result , "msg" => $msg] ;
        echo json_encode($res);
?>
