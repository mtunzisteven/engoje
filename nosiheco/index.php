<?php

    session_start();

// This is the main controller

$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
if ($action == NULL){
    $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
}


switch($action){
    case 'about':
        include "views/about.php";
        break;

    case 'services':
        include "views/services.php";
        break;

    case 'contact':
        include "views/contact.php";
        break;

    case 'contact-button':
        header("Location: /views/contact.php");
        break;

    case 'contactForm':
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING); 
        $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

        $_SESSION['name'] = $name;
        $_SESSION['phone'] = $phone;
        $_SESSION['email'] = $email;
        $_SESSION['message'] = $message;


        if(!(empty($name) || empty($phone) || empty($email) || empty($message))){
            // Send the email to the site owner.

            // Message to be sent
            $send = "<table><tr><th>A Website User Submitted a Message</th><th></th></tr>";
            $send .= "<tr><th style='text-align:left'>Name:</th><td>$name</td></tr>";
            $send .= "<tr><th style='text-align:left'>Phone:</th><td>$phone</td></tr>";
            $send .= "<tr><th style='text-align:left'>Email:</th><td>$email</td></tr>";
            $send .= "<tr><th style='text-align:left'>Message:</th><td></td></tr>";
            $send .= "<tr><td>$message</td></tr></table>";

            // Header information
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            $headers .= 'From:No Reply<noreply@nosihe.co.za>' . "\r\n";
            $headers .= 'Reply-To:Info<info@nosihe.co.za>' . "\r\n";
            $headers .= 'Cc:Thembeka<thembeka@nosihe.co.za>' . "\r\n";
            $headers .= 'Cc:Nosihe<nosihe.consulting@gmail.com>' . "\r\n";
            $headers .= 'Bcc:Mtunzi<mtunzisteven@gmail.com>' . "\r\n";

            $mailto = "nosihe.consulting@gmail.com";
            $subject = "Contact Form Submission";

            $sent = mail($mailto, $subject, $send, $headers);

            if($sent){

                $_SESSION['sent'] = $sent;
                $_SESSION['status-message'] = "<p class='contact-message mt-2'>Your message was submitted successfully. We'll get back to you ASAP.</p>";

            }
        }else{

            $_SESSION['status-message'] = "<p class='contact-message mt-2'>Your message was not submitted. Please try again, and make sure all inforamtion is inserted properly.</p>";

        }

        header ("Location: /contact/");
        break;

    case 'home':
    default:
        include "views/home.php";
        break;
}