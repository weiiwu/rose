<?php
    require_once 'assets/php/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <?php if(!$verified): ?>
                <div class="alert alert-danger alert-dismissable text-center mt-2 m-0">
                    <button class="close" type="button" data-dismiss="alert">&times;</button>
                    <strong>Your E-mail is not verified! We've sent you an E-mail Verification link on your E-mail, please check & verify now!</strong>
                </div>
            <?php endif; ?>
            <h4 class="text-center text-bark mt-2">Wrtie Your Notes Here</h4>
        </div>
    </div>
    <div class="card border-info">
        <h5 class="card-header bg-light d-flex justify-content-between">
            <span class="text-dark lead align-self-center">All Notes</span>
            <a href="#" class="btn btn-info" data-toggle="modal" data-target="#addNoteModal"><i class="fas fa-plus-circle"></i> Add New Note</a>
        </h5>
        <div class="card-body">
            <div class="table-responsive" id="showNote">
                <p class="text-center lead mt-5">Please wait...</p>
            </div>
        </div>
    </div>
</div>

<!-- Add Note Modal -->
<div class="modal fade" id="addNoteModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h4 class="modal-title text-light"><i class="fas fa-plus-circle"></i> Add New Note</h4>
                <button type="button" class="close text-light" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="#" method="post" id="add-note-form" class="px-3">
                    <div class="form-group">
                        <input type="text" name="title" class="form-control" placeholder="Enter Title" required>
                    </div>
                    <div class="form-group">
                        <textarea name="note" rows="6" class="form-control" placeholder="Write Note Here" required></textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="addNote" value="Add Note" id="addNoteBtn" class="btn btn-info btn-block">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Add Note Modal -->

<!-- Edit Note Modal -->
<div class="modal fade" id="editNoteModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h4 class="modal-title text-light"><i class="fas fa-edit"></i> Edit Note</h4>
                <button type="button" class="close text-light" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="#" method="post" id="edit-note-form" class="px-3">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <input type="text" name="title" id="title" class="form-control" placeholder="Enter Title" required>
                    </div>
                    <div class="form-group">
                        <textarea name="note" id="note" rows="6" class="form-control" placeholder="Write Note Here" required></textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="editNote" value="Update Note" id="editNoteBtn" class="btn btn-info btn-block">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Edit Note Modal -->

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>  
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script type="text/javascript">
    $(document).ready(function(){

        //Add Note
        $("#addNoteBtn").click(function(e){
            if($("#add-note-form")[0].checkValidity()){
                e.preventDefault();

                $("#addNoteBtn").val('Please wait...');

                $.ajax({
                    url: 'assets/php/process.php',
                    method: 'post',
                    data: $("#add-note-form").serialize()+'&action=add_note',
                    success:function(response){
                        //console.log(response);
                        $("#addNoteBtn").val('Add Note');
                        $("#add-note-form")[0].reset();
                        $("#addNoteModal").modal('hide');
                        Swal.fire({
                            title: 'Note added',
                            icon: 'success'
                        });

                        displayAllNotes();

                    }
                });
            }
        });

        //Edit Note
        $("body").on("click", ".editBtn", function(e){
            e.preventDefault();

            edit_id = $(this).attr('id');
            //console.log(edit_id);

            $.ajax({
                url: 'assets/php/process.php',
                method: 'post',
                data: { edit_id: edit_id },
                success: function(response) {
                    //console.log(response);
                    data = JSON.parse(response);
                    $("#id").val(data.id);
                    $("#title").val(data.title);
                    $("#note").val(data.note);
                }
            })
        });

        //Update Note
        $("#editNoteBtn").click(function(e){
            if($("#edit-note-form")[0].checkValidity()){
                e.preventDefault();

                $.ajax({
                    url: 'assets/php/process.php',
                    method: 'post',
                    data: $("#edit-note-form").serialize()+"&action=update_note",
                    success: function(response) {
                        //console.log(response);
                        Swal.fire({
                            title: 'Note updated',
                            icon: 'success'
                        });
                        $("#edit-note-form")[0].reset();
                        $("#editNoteModal").modal('hide');
                        displayAllNotes();
                    }
                });
            }
        });

        //Delete Note
        $("body").on("click", ".deleteBtn", function(e) {
            e.preventDefault();
            del_id = $(this).attr('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: 'assets/php/process.php',
                        method: 'post',
                        data: { del_id: del_id},
                        success: function(response){
                            Swal.fire(
                                'Deleted!',
                                'Note deleted.',
                                'success'
                            )
                            displayAllNotes();
                        }
                    });
                }
            })
        })

        //View Note
        $("body").on("click", ".infoBtn", function(e) {
            e.preventDefault();

            info_id = $(this).attr('id');

            $.ajax({
                url: 'assets/php/process.php',
                method: 'post',
                data: { info_id: info_id},
                success: function(response) {
                    //console.log(response);
                    data = JSON.parse(response);
                    Swal.fire({
                        title: '<strong>Note #'+data.id+'</strong>',
                        icon: 'info',
                        html: '<strong>'+data.title+'</strong><hr>'+data.note+'<hr>'+'<small><i>Written on :'+data.created_at+'<br>Updated on :'+data.updated_at+'<i></small>',
                        showCloseButton: true,
                    })
                }
            })
        })

        displayAllNotes();

        //Show All Notes 
        function displayAllNotes() {
            $.ajax({
                url: 'assets/php/process.php',
                method: 'post',
                data: { action: 'display_notes' },
                success: function(response) {
                    //console.log(response);
                    $("#showNote").html(response);
                    $("table").DataTable({
                        order: [0, 'desc']
                    });

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

        //Check user is logged in or not
        $.ajax({
            url: 'assets/php/action.php',
            method: 'post',
            data: { action: 'checkUser'},
            success:function(response) {
                if(response === 'no') {
                    window.location = 'index.php';
                }
            }
        })

    });
</script>
</body>
</html>