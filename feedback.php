<?php
    require_once 'assets/php/header.php';
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8 mt-3">
        <?php if($verified == 'Verified!'): ?>
            <div class="card border-info">
                <div class="card-header lead text-center bg-info text-light">Send Feedback to Admin</div>
                <div class="card-body">
                    <form action="" method="post" class="px-4" id="feedback-form">
                        <div class="form-group">
                            <input type="text" name="subject" class="form-control rounded-0" placeholder="Write your subject" required>
                        </div>

                        <div class="form-group">
                            <textarea name="feedback" class="form-control rounded-0" id="" cols="30" rows="10"  placeholder="Write your feedback here" required></textarea>
                        </div>

                        <div class="form-group">
                            <input type="submit" name="feedbackBtn" id="feedbackBtn" value="Send Feedback" class="btn btn-info btn-block">
                        </div>
                    </form>
                </div>
            </div>
            <?php else: ?>
                <h3 class="text-center text-danger mt-5">Verify your E-mail first to send feedabck to Admin.</h3>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>  
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<script type="text/javascript">
    $(document).ready(function(){
        //Send Feedback
        $("#feedbackBtn").click(function(e){
            if($("#feedback-form")[0].checkValidity()){
                e.preventDefault();

                $(this).val('Please wait...');

                $.ajax({
                    url: 'assets/php/process.php',
                    method: 'post',
                    data: $("#feedback-form").serialize()+'&action=feedback',
                    success:function(response){
                        //console.log(response);
                        $("#feedback-form")[0].reset();
                        $("#feedbackBtn").val('Send Feedback');
                        Swal.fire({
                            title: 'Feedback sent to the Admin',
                            icon: 'success'
                        })
                    }
                });                
            }
        });

        //Check notification
        checkNotification();
        function checkNotification(){
            $.ajax({
                url: 'assets/php/process.php',
                method: 'post',
                data: { action: 'checkNotification' },
                success:function(response) {
                    //console.log(response);
                    $("#checkNotification").html(response);
                }
            });
        }
    });


</script>
</body>
</html>