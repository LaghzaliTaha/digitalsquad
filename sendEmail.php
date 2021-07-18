
<?php require_once 'validate.php'; ?>
 <?php   use PHPMailer\PHPMailer\PHPMailer;
    if (isset($_POST['email']) && !empty($_POST['email'])) {
       $email = $_POST['email'];
      
        require_once "PHPMailer/PHPMailer.php";
        require_once "PHPMailer/SMTP.php";
        require_once "PHPMailer/Exception.php";

        $mail = new PHPMailer();

        //SMTP Settings
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = 'digitalsquad648@gmail.com';
        $mail->Password = 'Digitalsquad648@@';
        $mail->Port = 465;
        $mail->SMTPSecure = "ssl";

        //Email Settings
          $mail->isHTML(true);
            if(valideemail($email))
            {
                            $mail->setFrom($email,$email);
                            $mail->addAddress("digitalsquad648@gmail.com"); //enter you email address
                            $mail->Subject = "New Contact";
                            $mail->Body = "nabil here";
                            $mail->msgHTML(file_get_contents('msgmail.html'), dirname(__FILE__));

                            if ($mail->send()) {
                                $success = 1;
                            $msg= "Email is sent!";
                            } else {
                                $success =0;
                            $msg= "Something is wrong:" . $mail->ErrorInfo;
                            }  
            }else
            {
                     $success =0;
                     $msg="Please Type Correct Email";
             
            } 
        }
        else
        {    $success =0;
             $msg="Please enter your email ";
        }
    
     

       

        $res =["success" => $success , "msg" => $msg] ; 
        echo json_encode($res);  //  }
?>
