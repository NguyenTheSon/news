<?php
    //ini_set('display_errors', 'On');
    require 'class.phpmailer.php';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $_GET['name'] =  $_REQUEST['name'];
        $_GET['email'] =  $_REQUEST['email'];
        $_GET['message'] =  $_REQUEST['message'];
        $_GET['number'] =  $_REQUEST['number'];
    }
    if(!$_GET['name']){ 
        echo json_encode(array(
            'success' => 0,
            'errorCode' => 1,
            'message' => 'No name provided'
        )); 
        
        return;  
    } 
    if(!$_GET['email']){  
        echo json_encode(array(
            'success' => 0,
            'errorCode' => 2,
            'message' => 'No email address provided'
        )); 
        
        return;  
    } 
    if(!$_GET['message']){ 
        echo json_encode(array(
            'success' => 0,
            'errorCode' => 3,
            'message' => 'No message provided'
        )); 
        
        return;  
    } 

    if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*$/i", $_GET['email'])) {  
        echo json_encode(array(
            'success' => 0,
            'errorCode' => 2,
            'message' => 'No email address provided'
        )); 
        
        return;  
    }

    mb_language("japanese");           //言語(日本語)
    mb_internal_encoding("UTF-8");

    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SetFrom($_GET['email'], $_GET['name']);

    $mail->AddAddress('info@alt.ai', 'al+');
    $mail->Subject = 'You have a message sent from al+';
    $mail->SMTPAuth   = true;                  // enable SMTP authentication
    $mail->SMTPSecure = "tls";                 // sets the prefix to the servier
    $mail->Host       = "alt-inc.sakura.ne.jp";      // sets GMAIL as the SMTP server
    $mail->Port       = 587;                   // set the SMTP port for the GMAIL server
    $mail->Username   = "developer@alt.ai";  // GMAIL username
    $mail->Password   = "Yer8mhjs";            // GMAIL password
    $mail->CharSet = "iso-2022-jp";
    $mail->Encoding = "7bit";


    $message = "Phone: " . $_GET['number'] . "<br /><br /> Message:" . mb_convert_encoding($_GET['message'],"JIS","UTF-8");
    $messageAlt = "Phone: " . $_GET['number'] . "\r\n\r\n Message:" . mb_convert_encoding($_GET['message'],"JIS","UTF-8");

    $mail->MsgHTML($message);
    $mail->AltBody = $messageAlt;

    if(!$mail->Send()) {

        echo json_encode(array(
            'success' => 0,
            'errorCode' => 4,
            'message' => $mail->ErrorInfo
        )); 
        
        return;     
    } else {

        echo json_encode(array(
            'success' => 1,
            'message' => "We'll be in touch real soon!"
        )); 
        
        return;     
    }
?>