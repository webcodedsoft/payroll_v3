$(document).ready(function() {

    var baseUrls = $('#static_url').val();
    var urls = baseUrls.concat('Controller/Company/UsersController.php');


    $(document).on('click', '#user_button', function(e) {

        var empty = false;
        if ($("#first_name").val() == "" || $("#last_name").val() == "" || $("#username").val() == "" || $("#email").val() == "" ||
            $("#password").val() == "" || $("#confirm_password").val() == "" || $("#phone_number").val() == "" || $("#access_permission").val() == "") {

            toastr.warning('All Fields Are Required', 'Warning!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 4000, "progressBar": true });
            empty = true;
            return empty;

        } else {

            var formData = new FormData();
            formData.append('user_id', $('#user_id').val());
            formData.append('first_name', $('#first_name').val());
            formData.append('last_name', $('#last_name').val());
            formData.append('username', $('#username').val());
            formData.append('email', $('#email').val());
            formData.append('password', $('#password').val());
            formData.append('confirm_password', $('#confirm_password').val());
            formData.append('phone_number', $('#phone_number').val());
            formData.append('access_permission', $('#access_permission').val());
            formData.append('user_button', $('#user_button').val());

            $.ajax({
                type: "POST",
                url: urls,
                dataType: 'json',
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $("#user_button").html("<i class='la la-spinner spinner'></i> Please Wait...");
                    $('#user_button').addClass('disabled');
                    $('#user_button').prop('disabled', true);
                },
                success: function(json) {
                    load_user_data_list();
                    toastr.info(json[0], 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 5000, "progressBar": true });
                    $("#user_button").html("<i class='ft-save'></i> Submit");
                    $('#user_button').removeClass('disabled');
                    $('#user_button').prop('disabled', false);
                    $('#create_user').modal('hide');

                    $('#first_name').val("");
                    $('#last_name').val("");
                    $('#username').val("");
                    $('#email').val("");
                    $('#password').val("");
                    $('#confirm_password').val("");
                    $('#phone_number').val("");
                    $('#access_permission').val("");
                },

                error: function(e) {

                }
            });
        }


    });



    load_user_data_list();

    function load_user_data_list(e) {
        //var baseUrls = $(location).attr('href');


        $('#users_list').DataTable({
            dom: 'Bftiplr',
            "processing": true,
            oLanguage: { sProcessing: '<div class="ball-pulse-sync loader-purple"><div></div><div></div><div></div><div></div></div>' },
            "serverSide": true,
            "searching": true,
            "bDestroy": true,
            "scrollCollapse": true,
            "responsive": true,
            "iDisplayLength": 10,
            "lengthMenu": [
                [10, 25, 50, 100, 1000000000],
                [10, 25, 50, 100, 'All']
            ],

            buttons: [
                'excelHtml5',
                'csvHtml5',
                'copy',
                'print',
                {
                    extend: 'pdfHtml5',
                    download: 'open'
                }
            ],
            "ajax": {
                url: urls,
                method: "POST",
                dataType: 'json',
                data: {
                    users_list_access: 'users_list_access',
                },
                error: function(xhr, code, error) {
                    console.log(xhr);
                    console.log(code);
                    console.log(error);
                }
            }
        });


    }


    $(document).on('click', '.block_user', function(e) {

        var user_id = $(this).attr("id");

        $.ajax({
            type: "POST",
            url: urls,
            dataType: 'json',
            data: { user_id: user_id, block_user: 'block_user' },
            beforeSend: function() {
                $("#user_actions").html("<i class='la la-spinner spinner'></i>");
                $('#user_actions').addClass('disabled');
                $('#user_actions').prop('disabled', true);
            },
            success: function(json) {
                toastr.info(json[0], 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 5000, "progressBar": true });
                $("#user_actions").html("<i class='la la-cog'></i>");
                $('#user_actions').removeClass('disabled');
                $('#user_actions').prop('disabled', false);
                load_user_data_list();
            },

            error: function(e) {

            }
        });
    });


    $(document).on('click', '.delete_user', function(e) {
        var user_id = $(this).attr("id");
        DeletePopOverAlert(user_id, "delete_user");
    });


    $(document).on('click', '.edit_user', function(e) {

        var user_id = $(this).attr("id");

        $.ajax({
            type: "POST",
            url: urls,
            dataType: 'json',
            data: {
                user_id: user_id,
                edit_user: "edit_user",
            },

            success: function(json) {
                $('#first_name').val(json[0].First_Name);
                $('#last_name').val(json[0].Last_Name);
                $('#username').val(json[0].Username);
                $('#email').val(json[0].Email);
                $('#edit_hide').hide();
                $('#phone_number').val(json[0].Phone_Number);
                $('#access_permission').val(json[0].Role).change();

                $('#user_id').val(json[0].ID);

                $("#user_button").html("<i class='la la-save'></i> Update");

                $("#create_user").modal('show');
                $("#create_company_btn").html("<i class='la la-save'></i> Update");
            },
        });

    });



    $(document).on('click', '#user_popup_close', function(e) {
        $('#first_name').val("");
        $('#last_name').val("");
        $('#username').val("");
        $('#email').val("");
        $('#password').val("");
        $('#confirm_password').val("");
        $('#phone_number').val("");
        $('#access_permission').val("").change();
        $('#edit_hide').show();

        $("#user_button").html("<i class='la la-save'></i> Create");

    });

    function DeletePopOverAlert(delete_value, delete_function) {


        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this data!",
            icon: "warning",
            showCancelButton: true,
            buttons: {
                cancel: {
                    text: "No, Cancel it!",
                    value: null,
                    visible: true,
                    className: "btn-warning",
                    closeModal: false,
                },
                confirm: {
                    text: "Yes, Delete it!",
                    value: true,
                    visible: true,
                    className: "",
                    closeModal: false
                }
            }
        }).then(isConfirm => {
            if (isConfirm) {
                swal("Deleted!", "Your data has been deleted.", "success");

                $.ajax({
                    type: 'POST',
                    url: urls,
                    dataType: 'json',
                    data: {
                        delete_value: delete_value,
                        delete_function: delete_function,
                    },
                    beforeSend: function() {
                        $("#user_actions").html("<i class='la la-spinner spinner'></i>");
                        $('#user_actions').addClass('disabled');
                        $('#user_actions').prop('disabled', true);
                    },
                    success: function(json) {
                        if (json == 'Deleted')
                            swal("Deleted!", "Your data has been deleted.", "success");
                        load_user_data_list();
                    },

                });

            } else {
                swal("Cancelled", "Your data is safe :)", "error");
            }
        });
    }
});