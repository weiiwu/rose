<?php
    require_once 'assets/php/auth.php';

    $user = new Auth();
    $msg = '';

    if(isset($_GET['email']) && isset($_GET['token'])) {
        $email = $user->test_input($_GET['email']);
        $token = $user->test_input($_GET['token']);

        $auth_user = $user->reset_pass_auth($email, $token);

        if($auth_user != null) {
            if(isset($_POST['submit'])) {
                $newpass = $_POST['pass'];
                $cnewpass = $_POST['cpass'];

                $hnewpass = password_hash($newpass, PASSWORD_DEFAULT);

                if($newpass == $cnewpass) {
                    $user->update_new_pass($hnewpass, $email);
                    $msg = 'Password Changed Successfully!<br><a href="index.php" title="Home">Login Here</a>';
                }else{
                    $msg = 'Password did not match';
                }
            }
        }else{
            header('location:index.php');
            exit();
        }
    }else{
        header('location:index.php');
        exit();   
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='icon' href='favicon.ico' type='image/x-icon' />
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>
    <title>ROSE - Reset Password</title>
</head>
    <body>
        <div class="container">
            <div class="row justify-content-center wrapper" id="login-box">
            <div class="col-lg-6 my-auto">
            <div class="text-center">
                <img src="img/logo.png" alt="logo" width="50px">
                <p class="text-light">Rich Online Service</p>    
            </div>
        
            <div class="card-group myShadow">
            <div class="card rounded-left p-4" style="flex-grow:1.4;">
                <h3 class="text-center text-info">Reset Password</h3>
                <hr class="my-3">
                <form action="#" method="post" id="login-form">
                <div class="text-center text-warning lead mb-2"><?= $msg; ?></div>
                <div class="input-group form-group">
                    <div class="input-group-prepend">
                    <span class="input-group-text rounded-0"><i class="fas fa-lock"></i></span>
                    </div>
                    <input type="password" name="pass" class="form-control rounded-0" minlength="5" placeholder="New Password" required minlength="5">
                </div>

                <div class="input-group form-group">
                    <div class="input-group-prepend">
                    <span class="input-group-text rounded-0"><i class="fas fa-lock"></i></span>
                    </div>
                    <input type="password" name="cpass" class="form-control rounded-0" minlength="5" placeholder="Confirm New Password" required minlength="5">
                </div>

                <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-outline-info btn-block"><i class="fas fa-reply"></i> Reset Password</button>
                </div>
                </form>

            </div>

            </div>
        </div>
        </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>  

    </body>
</html>

