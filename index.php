<?php
  session_start();
  if(isset($_SESSION['user'])){
    header('location:home.php');
  }

  include_once 'assets/php/config.php';
  $db = new Database();

  $sql = "UPDATE visitors SET hits = hits+1 WHERE id = 0";
  $stmt = $db->conn->prepare($sql);
  $stmt->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='icon' href='favicon.ico' type='image/x-icon' />
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> -->
    <!-- <link href="assets/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="https://bootswatch.com/4/cosmo/bootstrap.css" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>
    <title>ROSE</title>
</head>
<body>

<div class="container">

<!-- Login Box Start -->
<div class="row justify-content-center wrapper" id="login-box">
      <div class="col-lg-6 my-auto">
        <div class="text-center">
            <img src="img/logo.png" alt="logo" width="50px">
            <p class="text-light">Rich Online Service</p>    
        </div>
      
        <div class="card-group myShadow">
          <div class="card rounded-left p-4" style="flex-grow:1.4;">
            <h3 class="text-center text-info">Sign in to ROSE</h3>
            <hr class="my-3">
            <form action="#" method="post" id="login-form">
            <div id="loginAlert"></div>
              <div class="input-group form-group">
                <div class="input-group-prepend">
                  <span class="input-group-text rounded-0"><i class="far fa-envelope"></i></span>
                </div>
                <input type="email" id="email" name="email" class="form-control rounded-0" placeholder="E-Mail" required value="<?php if(isset($_COOKIE['email'])) { echo $_COOKIE['email']; } ?>">
              </div>
              <div class="input-group form-group">
                <div class="input-group-prepend">
                  <span class="input-group-text rounded-0"><i class="fas fa-lock"></i></span>
                </div>
                <input type="password" id="password" name="password" class="form-control rounded-0" minlength="5" placeholder="Password" required value=<?php if(isset($_COOKIE['password'])) { echo $_COOKIE['password']; } ?>>
              </div>
              <div class="form-group">
                <div class="custom-control custom-checkbox float-left">
<input type="checkbox" class="custom-control-input" id="customCheck" name="rem" <?php if(isset($_COOKIE['email'])) { ?> checked <?php } ?>">
                  <label class="custom-control-label" for="customCheck">Remember me</label>
                </div>
                <div class="forgot float-right">
                  <a href="#" id="forgot-link">Forgot Password?</a>
                </div>
                <div class="clearfix"></div>
              </div>

              <div class="form-group">
                <button type="submit" id="login-btn" class="btn btn-outline-info btn-block"><i class="fas fa-sign-in-alt"></i> Sign In</button>
              </div>
            </form>
            <!-- <button class="btn btn-outline-light align-self-center mt-4 myLinkBtn" id="register-link">Sign Up</button> -->
            <div>New to ROSE? <a href="#" id="register-link">Create an account</a></div>
          </div>
          <!-- <div class="card justify-content-center rounded-right myColor p-4">
            <h3 class="text-center text-white">Hello Friends!</h3>
            <hr class="my-3 bg-light myHr">
            <p class="text-center text-light lead">Enter your personal details and start your journey
              with us!</p>
            <button class="btn btn-outline-light align-self-center mt-4 myLinkBtn" id="register-link">Sign Up</button>
          </div> -->
        </div>
      </div>
    </div>
    <!-- Login Box End -->

    <!-- Register Box Start -->
    <div class="row justify-content-center wrapper" style="display:none;" id="register-box">
      <div class="col-lg-6 my-auto">
        <div class="text-center">
            <img src="img/logo.png" alt="logo" width="50px">
            <p class="text-light">Rich Online Service</p>    
        </div>
        <div class="card-group myShadow">
          <!-- <div class="card rounded-left myColor p-4 justify-content-center">
            <h3 class="text-center text-white">Welcome Back!</h3>
            <hr class="my-4 bg-light myHr">
            <p class="text-center text-light lead">To keep connected with us please login with your personal info.</p>
            <button class="btn btn-outline-light mt-4 align-self-center myLinkBtn" id="login-link">Sign In</button>
          </div> -->
          <div class="card rounded-right p-4" style="flex-grow:1.4">
            <h3 class="text-center text-info">Create your account</h3>
            <hr class="my-3">
            <form action="#" method="post" id="register-form">
              <div id="regAlert"></div>
              <div class="input-group form-group">
                <div class="input-group-prepend">
                  <span class="input-group-text rounded-0"><i class="far fa-user"></i></span>
                </div>
                <input type="text" id="first_name" name="first_name" class="form-control rounded-0" placeholder="First Name" required>
              </div>
              <div class="input-group form-group">
                <div class="input-group-prepend">
                  <span class="input-group-text rounded-0"><i class="far fa-user"></i></span>
                </div>
                <input type="text" id="last_name" name="last_name" class="form-control rounded-0" placeholder="Last Name" required>
              </div>
              <div class="input-group form-group">
                <div class="input-group-prepend">
                  <span class="input-group-text rounded-0"><i class="far fa-envelope"></i></span>
                </div>
                <input type="email" id="remail" name="email" class="form-control rounded-0" placeholder="E-Mail" required>
              </div>
              <div class="input-group form-group">
                <div class="input-group-prepend">
                  <span class="input-group-text rounded-0"><i class="fas fa-lock"></i></span>
                </div>
                <input type="password" id="rpassword" name="password" class="form-control rounded-0" minlength="5" placeholder="Password" required>
              </div>
              <div class="input-group form-group">
                <div class="input-group-prepend">
                  <span class="input-group-text rounded-0"><i class="fas fa-lock"></i></span>
                </div>
                <input type="password" id="cpassword" name="cpassword" class="form-control rounded-0" minlength="5" placeholder="Confirm Password" required>
              </div>
              <div class="form-group">
                <div id="passError" class="text-danger font-weight-bold">
                
                </div>
              </div>
              <div class="form-group">
                <div id="passError" class="text-danger font-weight-bolder"></div>
              </div>
              <div class="form-group">
                <button type="submit" id="register-btn" class="btn btn-outline-info btn-block"><i class="fas fa-user-plus"></i> Sign Up</button>
              </div>
            </form>
            <!-- <button class="btn btn-outline-light mt-4 align-self-center myLinkBtn" id="login-link">Sign In</button> -->
            <div>Already have an account? <a href="#" id="login-link">Sign In</a></div>

          </div>
        </div>
      </div>
    </div>
    <!-- Register Box End  -->
 
    <!-- Forgot Box Start -->
    <div class="row justify-content-center wrapper" id="forgot-box" style="display: none;">
      <div class="col-lg-6 my-auto">
        <div class="text-center">
            <img src="img/logo.png" alt="logo" width="50px">
            <p class="text-light">Rich Online Service</p>    
        </div>
        <div class="card-group myShadow">
          <!-- <div class="card rounded-left myColor p-4 justify-content-center">
            <h3 class="text-center text-white">Reset Password!</h3>
            <hr class="my-4 bg-light myHr">
            <button class="btn btn-outline-light myLinkBtn align-self-center" id="back-link">Back</button>
          </div> -->
          <div class="bg-white rounded-right p-4">
            <h3 class="text-center text-info">Forgot Your Password?</h3>
            <hr class="my-3">
            <p class="lead text-center text-secondary">Please enter the e-mail adddress and we will send you password reset instructions on your e-mail!</p>
            <form action="#" method="post" id="forgot-form">
              <div id="forgotAlert"></div>
              <div class="input-group form-group">
                <div class="input-group-prepend">
                  <span class="input-group-text rounded-0"><i class="far fa-envelope"></i></span>
                </div>
                <input type="email" id="femail" name="email" class="form-control rounded-0" placeholder="E-Mail" required>
              </div>
              <div class="form-group">
                <button type="submit" id="forgot-btn" class="btn btn-outline-info btn-block"><i class="fas fa-reply"></i> Reset Password</button>
              </div>
            </form>
            <!-- <button class="btn btn-outline-light myLinkBtn align-self-center" id="back-link">Back</button> -->
            <div><a href="#" id="back-link">Back</a></div>

          </div>
        </div>
      </div>
    </div>
    <!-- Forgot Box End -->
</div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>  

    <script>
    $(document).ready(function(){
      $("#register-link").click(function(){
        $("#login-box").hide();
        $("#register-box").show();
      });
      $("#login-link").click(function(){
        $("#login-box").show();
        $("#register-box").hide();
      });
      $("#forgot-link").click(function(){
        $("#login-box").hide();
        $("#forgot-box").show();
      });
      $("#back-link").click(function(){
        $("#login-box").show();
        $("#forgot-box").hide();
      });

      //register
      $("#register-btn").click(function(e){
        if($("#register-form")[0].checkValidity()){
          e.preventDefault();
          
          $("#register-btn").html('Please Wait...');

          if($("#rpassword").val() != $("#cpassword").val()){
            $("#passError").text('*Passwords did not match!');
            $("#register-btn").val('Sign Up');
          
          }else{
            $("#passError").text('');
            $.ajax({
              url: 'assets/php/action.php',
              method: 'post',
              data: $("#register-form").serialize()+'&action=register',
              success:function(response){
                $("#register-btn").val('Sign Up');

                if(response === 'register'){
                  window.location = 'home.php';
                }else{
                  $("#regAlert").html(response);
                }
              }
            });
          }
        }
      });

      //login ajax request
      $("#login-btn").click(function(e){
        if($("#login-form")[0].checkValidity()){
          e.preventDefault();

          $("#login-btn").html('Please wait...');

          $.ajax({
            url: 'assets/php/action.php',
            method: 'post',
            data: $("#login-form").serialize()+'&action=login',
            success: function(response) {
              //console.log(response);
              $("#login-btn").val('Sign In');
              if(response === 'login') {
                window.location = 'home.php';
              }else{
                $("#loginAlert").html(response);
              }
            }
          })
        }
      });

      //forget password
      $("#forgot-btn").click(function(e){
        if($("#forgot-form")[0].checkValidity()){
          e.preventDefault();

          $("#forgot-btn").html('Please wait...');

          $.ajax({
            url: 'assets/php/action.php',
            method: 'post',
            data: $("#forgot-form").serialize()+'&action=forgot',
            success: function(response){
              $("#forgot-btn").val('Reset Password');
              $("#forgot-form")[0].reset();
              $("#forgotAlert").html(response);
              //console.log(response);
            }
          });
        }
      });

    });
    </script>
</body>
</html>