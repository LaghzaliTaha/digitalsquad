
<?php require_once 'validate.php'; ?>
 <?php

const wrong_email ="Please Type Correct Email";
const empty_email = "Please enter your email ";
const sent_email="Email is sent!";
const try_again="Something is wrong  try again";
    use PHPMailer\PHPMailer\PHPMailer;
    if (isset($_POST['email']) && !empty($_POST['email'])) {
       $email = $_POST['email'];

        require_once "PHPMailer/PHPMailer.php";
        require_once "PHPMailer/SMTP.php";
        require_once "PHPMailer/Exception.php";
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: PUT, GET, POST");
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
        $mail = new PHPMailer();

        //SMTP Settings
        $mail->isSMTP();
        $mail->Host = "smtp.elasticemail.com";
        $mail->SMTPAuth = true;
        $mail->Username = 'laghzalitaha0@gmail.com';
        $mail->Password = '5EC801332BE1910DD92D9FD8A31596EFA31C';


        $mail->Port =2525;

        //Email Settings
          $mail->isHTML(true);
            if(valideemail($email))
            {
                            $mail->setFrom($email,$email);
                            $mail->addAddress("digitalsquad648@gmail.com");
                            $mail->Subject = "Demande de contact";
                            $userName=explode('@' ,$email);
                            $body = file_get_contents('msgmail.html');
                            $body = str_replace('$userName', $userName[0], $body);
                            $mail->MsgHTML($body, dirname(__FILE__));
                            if ($mail->send()) {
                                    $success = 1;
                                    $msg=sent_email;
                            } else {
                                    $success =0;

                                    $msg= try_again ;
                            }
            }else
            {
                     $success =0;
                     $msg=wrong_email ;

            }
        }
        else
        {    $success =0;
             $msg=empty_email;
        }





        $res =["success" => $success , "msg" => $msg] ;
        echo json_encode($res);
?>
