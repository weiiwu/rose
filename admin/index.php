<?php
    session_start();
    if(isset($_SESSION['username'])) {
        header('location:admin_dashboard.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Admin</title>
    <link href="assets/css/styles.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://bootswatch.com/4/cosmo/bootstrap.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>

</head>
<body class="bg-secondary">
    <div class="container h-100">
        <div class="row h-100 align-items-center justify-content-center">
            <div class="col-lg-5">
                <div class="card border-primary shadow-lg">
                    <div class="card-header bg-primary">
                        <h3 class="m-0 text-light">
                            <i class="fas fa-user-cog"></i> ROSE - Admin Portal
                        </h3>
                    </div>
                    <div class="card-body">
                        <form action="" method="post" class="px-3" id="admin-login-form">
                            <div id="adminLoginAlert"></div>
                            <div class="form-group">
                                <input type="text" name="username" class="form-control form-control-sm rounded-0" placeholder="Username" required autofocus>
                            </div>   

                            <div class="form-group">
                                <input type="password" name="password" class="form-control form-control-sm rounded-0" placeholder="Password" required>
                            </div>

                            <div class="form-group">
                                <input type="submit" name="admin-login" value="Login" class="btn btn-primary btn-block btn-sm rounded-0" id="adminLoginBtn">
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

    <script type="text/javascript">
        $(document).ready(function() {
            $("#adminLoginBtn").click(function(e) {
                if($("#admin-login-form")[0].checkValidity()) {
                    e.preventDefault();

                    $(this).val('Please wait...');
                    $.ajax({
                        url: 'assets/php/admin_action.php',
                        method: 'post',
                        data: $("#admin-login-form").serialize()+'&action=adminLogin',
                        success:function(response){
                            if(response === 'admin_login') {
                                window.location = 'admin_dashboard.php'
                            }else{
                                $("#adminLoginAlert").html(response);
                            }
                            $("#adminLoginBtn").val('Login');
                        }
                    });
                }
            });
        });

    </script>

</body>
</html>