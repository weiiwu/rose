<?php
    require_once 'assets/php/header.php';
?>

<div class="container">
    <div class="row justify-content-center my-2">
        <div class="col-lg-6 mt-4" id="showAllNotification">
            
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>  

<script type="text/javascript">
    $(document).ready(function(){
        
        //Fetch notification
        fetchNotification();
        function fetchNotification(){
            $.ajax({
                url: 'assets/php/process.php',
                method: 'post',
                data: { action: 'fetchNotification' },
                success:function(response){
                    //console.log(response);
                    $("#showAllNotification").html(response);
                }
            });
        }

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

        //Remove notification
        $("body").on("click", ".close", function(e){
            e.preventDefault();

            notification_id = $(this).attr('id');

            $.ajax({
                url: 'assets/php/process.php',
                method: 'post',
                data: { notification_id: notification_id },
                success:function(response){
                    checkNotification();
                    fetchNotification();
                }
            });
        });
    });
</script>
</body>
</html>