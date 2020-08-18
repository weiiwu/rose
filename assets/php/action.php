<?php

    session_start();

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require './PHPMailer/src/Exception.php';
    require './PHPMailer/src/PHPMailer.php';
    require './PHPMailer/src/SMTP.php';

    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    require_once 'auth.php';
    $user = new Auth();

    //register
    if(isset($_POST['action']) && $_POST['action'] == 'register') {
        $first_name = $user->test_input($_POST['first_name']);
        $last_name = $user->test_input($_POST['last_name']);
        $email = $user->test_input($_POST['email']);
        $pass = $user->test_input($_POST['password']);

        $hpass = password_hash($pass, PASSWORD_DEFAULT);

        if($user->user_exist($email)) {
            echo $user->showMessage('warning', 'This E-mail is already registered!');
        
        }else{
            if($user->register($first_name,$last_name,$email,$hpass)){
                echo 'register';
                $_SESSION['user'] = $email;

                $mail->isSMTP();
                $mail->Host       = 'smtp.mailtrap.io';                 // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                               // Enable SMTP authentication
                $mail->Username   = Database::USERNAME;                 // SMTP username
                $mail->Password   = Database::PASSWORD;                 // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;     // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
                $mail->Port       = 587;

                $mail->setFrom($email, 'ROSE');
                $mail->addAddress($email);                              // Add a recipient

                $mail->isHTML(true);                                    // Set email format to HTML
                $mail->Subject = 'E-Mail Verification';
                $mail->Body    = '<h3>Click the below link to verify your E-Mail.<br><a href="http://localhost/rose/verify_email.php?email='.$email.'">http://localhost/rose/verify_email.php?email='.$email.'</a><hr />Regards<br>ROSE</h3>';

                $mail->send();

            }else{
                echo $user->showMessage('danger', 'Something went wrong, Please try again!');
            }
        }
    }

    //login
    if(isset($_POST['action']) && $_POST['action'] == 'login') {
        $email = $user->test_input($_POST['email']);
        $pass = $user->test_input($_POST['password']);

        $loggedInUser = $user->login($email);

        if($loggedInUser != null) {
            if(password_verify($pass, $loggedInUser['password'])) {
                if(!empty($_POST['rem'])) {
                    setcookie("email", $email, time()+(30*24*60*60), '/');
                    setcookie("password", $pass, time()+(30*24*60*60), '/');
                }else{
                    setcookie("email", "", 1, '/');
                    setcookie("password", "", 1, '/');
                }

                echo 'login';
                $_SESSION['user'] = $email;
            }else{
                echo $user->showMessage('danger', 'Password is incorrect!');
            }
        }else{
            echo $user->showMessage('danger', 'User not found!');
        }
    }

    //forgot password
    if(isset($_POST['action']) && $_POST['action'] == 'forgot') {
        $email = $user->test_input($_POST['email']);

        $user_found = $user->currentUser($email);

        if($user_found != null) {
            $token = uniqid();
            $token = str_shuffle($token);

            $user->forgot_password($token,$email);

            try{
                $mail->isSMTP();
                $mail->Host       = 'smtp.mailtrap.io';                 // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                               // Enable SMTP authentication
                $mail->Username   = Database::USERNAME;                 // SMTP username
                $mail->Password   = Database::PASSWORD;                 // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;     // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
                $mail->Port       = 587;

                $mail->setFrom($email, 'ROSE');
                $mail->addAddress($email);                              // Add a recipient

                $mail->isHTML(true);                                    // Set email format to HTML
                $mail->Subject = 'ROSE - Reset Password';
                $mail->Body    = '<h3>Click the below link to reset your password.<br><a href="http://localhost/rose/reset_pass.php?email='.$email.'&token='.$token.'">http://localhost/rose/reset_pass.php?email='.$email.'&token='.$token.'</a><hr />Regards<br>ROSE</h3>';

                $mail->send();
                echo $user->showMessage('success', 'The reset link in your e-mail ID has been sent, please check your e-mail.');

            }catch(Exception $e){
                echo $user->showMessage('danger', 'Something went wrong, please try again later!'); //$e->getMessage()
            }
        }else{
            echo $user->showMessage('info', 'This e-mail is not registered!');
        }
    }

    //Check user is logged in or not
    if(isset($_POST['action']) && $_POST['action'] == 'checkUser') {
        if(!$user->currentUser($_SESSION['user'])) {
            echo 'no';
            unset($_SESSION['user']);
        }
    }

?>