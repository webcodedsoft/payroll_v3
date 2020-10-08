$(document).ready(function() {


    var baseUrls = $('#static_url').val();
    var urls = baseUrls.concat('Controller/Company/SettingsController.php');

    $(document).on("input", ".number_only", function(event) {
        this.value = this.value.replace(/[^\d]/g, '');

    });

    //file type validation comment
    $(".company_logo").change(function(e) {


        var file = this.files[0];

        var imagefile = file.type;
        var match = ["image/jpeg", "image/png", "image/jpg", "image/gif"];
        if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]) || (imagefile == match[3]))) {
            toastr.info('Please select a valid image file (JPEG/JPG/PNG/GIF).', 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000, "progressBar": true });
            $(".company_logo").val('');
            return false;
        }

        if ($(".company_logo")[0].files.length > 1) {
            toastr.info("You can select only 1 image, Please re-select", 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000, "progressBar": true });
            $(".company_logo").val("");
            return false;
        }

        if (file.size > 1448680) {
            toastr.info("Image size must not greater than 1.3 MB", 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000, "progressBar": true });
            $(".company_logo").val("");
            return false;
        }

    });






    $(document).on('click', '#role_permission_btn', function(e) {
        e.preventDefault();
        var module_access = [];
        var module_permission_create = [];
        var module_permission_read = [];
        var module_permission_delete = [];
        var module_permission_lock = [];
        var module_permission_unlock = [];

        var role = $("#role").val();

        $.each($("input[name='module_access']"), function() {
            if ($(this).is(":checked")) {
                module_access.push($(this).val());
            } else {
                module_access.push('Disabled');
            }
        });
        var module_accesss = module_access.join(",");

        $.each($("input[name='module_permission_create']"), function() {
            if ($(this).is(":checked")) {
                module_permission_create.push($(this).val());
            } else {
                module_permission_create.push('false');
            }
        });
        var module_permission_creates = module_permission_create.join(",");

        $.each($("input[name='module_permission_read']"), function() {
            if ($(this).is(":checked")) {
                module_permission_read.push($(this).val());
            } else {
                module_permission_read.push('false');
            }
        });
        var module_permission_reads = module_permission_read.join(",");

        $.each($("input[name='module_permission_delete']"), function() {
            if ($(this).is(":checked")) {
                module_permission_delete.push($(this).val());
            } else {
                module_permission_delete.push('false');
            }
        });
        var module_permission_deletes = module_permission_delete.join(",");

        $.each($("input[name='module_permission_lock']"), function() {
            if ($(this).is(":checked")) {
                module_permission_lock.push($(this).val());
            } else {
                module_permission_lock.push('false');
            }
        });
        var module_permission_locks = module_permission_lock.join(",");

        $.each($("input[name='module_permission_unlock']"), function() {
            if ($(this).is(":checked")) {
                module_permission_unlock.push($(this).val());
            } else {
                module_permission_unlock.push('false');
            }
        });
        var module_permission_unlocks = module_permission_unlock.join(",");

        //console.log(module_permission_unlocks);
        $.ajax({
            type: 'POST',
            url: urls,
            dataType: 'json',
            data: {
                role: role,
                module_access: module_accesss,
                module_permission_create: module_permission_creates,
                module_permission_read: module_permission_reads,
                module_permission_delete: module_permission_deletes,
                module_permission_lock: module_permission_locks,
                module_permission_unlock: module_permission_unlocks,
                role_permission_btn: 'role_permission_btn'
            },
            beforeSend: function() {

                $("#role_permission_btn").html("<i class='la la-spinner spinner'></i> Please Wait...");
                $('#role_permission_btn').addClass('disabled');
                $('#role_permission_btn').prop('disabled', true);
            },
            success: function(json) {
                toastr.info(json[0], 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 5000, "progressBar": true });
                $("#role_permission_btn").html("<i class='la la-save'></i> Save Changes");
                $('#role_permission_btn').removeClass('disabled');
                $('#role_permission_btn').prop('disabled', false);
            },
            error: function(e) {
                //console.log('Error' + e);
            }
        });

    });

    $(document).on('click', '#create_role_btn', function(e) {
        e.preventDefault();
        var role_name = $('#role_name').val();

        if ($("#create_role_btn").html() == ' <i class="la la-save"></i> Add Role') {
            if (role_name.length < 1) {
                toastr.warning("Enter Role Name", 'Warning!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 5000, "progressBar": true });
            } else {


                $.ajax({

                    type: 'POST',
                    url: urls,
                    dataType: 'json',
                    data: {
                        role_name: role_name,
                        create_role_btn: 'create_role_btn'
                    },
                    beforeSend: function() {

                        $("#create_role_btn").html("<i class='la la-spinner spinner'></i> Please Wait...");
                        $('#create_role_btn').addClass('disabled');
                        $('#create_role_btn').prop('disabled', true);
                    },
                    success: function(json) {
                        toastr.info(json[0], 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 5000, "progressBar": true });
                        $("#create_role_btn").html("<i class='la la-save'></i> Add Role");
                        $('#create_role_btn').removeClass('disabled');
                        $('#create_role_btn').prop('disabled', false);
                        $('#role_name').val("");
                        $("#create_role").modal('hide');
                        document.location.reload();
                    },
                    error: function(e) {
                        //console.log('Error' + e);
                    }
                });

            }
        }

    });


    $(":radio").change(function(event) {
        //e.preventDefault();
        var radio_value = $(this).val();
        $("#role").val(radio_value);

        $.ajax({
            type: 'POST',
            url: urls,
            dataType: 'json',
            data: {
                fetch_role_name: radio_value,
            },
            beforeSend: function() {
                $("#module_list").html("<i class='la la-spinner spinner'></i> Please Wait...");
                $("#permission_list").html("<i class='la la-spinner spinner'></i> Please Wait...");
            },
            success: function(json) {
                $("#module_list").html(json[0].module_list);
                $("#permission_list").html(json[0].permission_list);
                $("#module_access").html(radio_value + " Module Access");
            },
            error: function(e) {
                //console.log('Error' + e);
            }
        });
    });


    $(document).on('click', '.delete_role', function(e) {
        var delete_role_id = $(this).attr("id");
        var delete_function = "delete_role";
        DeletePopOverAlert(delete_role_id, delete_function);

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
                    success: function(json) {
                        if (json == 'Deleted')
                            swal("Deleted!", "Your data has been deleted.", "success");
                        document.location.reload();
                    },

                });

            } else {
                swal("Cancelled", "Your data is safe :)", "error");
            }
        });
    }




    $(document).on('click', '.edit_role', function(e) {
        var edit_role_name = $(this).attr("type");
        var edit_role_id = $(this).attr("id");

        $("#role_id").val(edit_role_id);
        $("#role_name").val(edit_role_name);
        $("#role_model").html('Edit Role');
        $("#create_role_btn").html('<i class="la la-save"></i> Save Changes');
    });



    $(document).on('click', '#create_role_btn_close', function(e) {
        $("#role_name").val('');
        $("#role_id").val('');
        $("#role_model").html('Add Role');
        $("#create_role").modal('hide');
        $("#create_role_btn").html('<i class="la la-save"></i> Add Role');
    });

    $(document).on('click', '.edit_role_btn', function(e) {

        if ($("#create_role_btn").html() == '<i class="la la-save"></i> Save Changes') {
            if ($("#role_name").val().length > 0) {

                var role_name = $("#role_name").val();
                var role_id = $("#role_id").val();

                $.ajax({
                    type: 'POST',
                    url: urls,
                    dataType: 'json',
                    data: {
                        role_name: role_name,
                        role_id: role_id,
                        edit_role_btn: 'edit_role_btn',
                    },
                    success: function(json) {
                        if (json == 'Deleted')
                            toastr.success("Role Name Successfully Change", 'Warning!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 5000, "progressBar": true });
                        $("#role_name").val('');
                        $("#role_id").val('');
                        document.location.reload();
                    },

                });

            } else {
                toastr.warning("Role Name cannot be empty", 'Warning!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 5000, "progressBar": true });
            }
        }

    });





    $(document).on('click', '#company_setting_btn', function(e) {
        var empty = false;
        if ($("#company_name").val() == "" || $("#company_email").val() == "" || $("#company_id").val() == "" || $("#company_phone_number").val() == "" ||
            $("#company_website").val() == "" || $("#company_header_report").val() == "" || $("#authorize_signature_name").val() == "" ||
            $("#authorize_signature_position").val() == "" || $("#company_address").val() == "") {

            toastr.warning('All Fields Are Required', 'Warning!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 4000, "progressBar": true });
            empty = true;
            return empty;

        } else {

            var formData = new FormData();

            $.each($('#company_logo')[0].files, function(i, file) {
                formData.append('company_logo[]', file);
            });

            formData.append('company_name', $('#company_name').val());
            formData.append('company_email', $('#company_email').val());
            formData.append('company_id', $('#company_id').val());
            formData.append('company_phone_number', $('#company_phone_number').val());
            formData.append('company_website', $('#company_website').val());
            formData.append('company_header_report', $('#company_header_report').val());
            formData.append('authorize_signature_name', $('#authorize_signature_name').val());
            formData.append('authorize_signature_position', $('#authorize_signature_position').val());
            formData.append('company_address', $('#company_address').val());
            formData.append('company_setting_btn', 'company_setting_btn');

            $.ajax({
                type: "POST",
                url: urls,
                dataType: 'json',
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $("#company_setting_btn").html("<i class='la la-spinner spinner'></i> Please Wait...");
                    $('#company_setting_btn').addClass('disabled');
                    $('#company_setting_btn').prop('disabled', true);
                },
                success: function(json) {
                    toastr.info(json[0], 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 5000, "progressBar": true });
                    $("#company_setting_btn").html("<i class='ft-save'></i> Save Changes");
                    $('#company_setting_btn').removeClass('disabled');
                    $('#company_setting_btn').prop('disabled', false);
                },
                error: function(e) {}
            });
        }

    });

    //$("#query_local_state_id option:selected").text();

    $('#country').change(function() {
        var country_id = $(this).val();
        $.ajax({
            url: urls,
            method: "POST",
            dataType: 'json',
            data: { country_id: country_id },
            success: function(json) {
                $('#currency_code').val(json[0].Code);
                $('#currency_symbol').html(json[0].Symbol);
                $('#currency_symbol_real').val(json[0].Symbol);

            },
            /*error: function (e) {
                console.log(e);
            }*/
        });

    });


    $(document).on('click', '#localization_btn', function(e) {

        if ($("#country").val() == "" || $("#date_format").val() == "" || $("#timezone").val() == "" || $("#language").val() == "" ||
            $("#currency_code").val() == "") {
            toastr.warning('All Fields Are Required', 'Warning!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 4000, "progressBar": true });
            empty = true;
            return empty;

        } else {
            var formData = new FormData();

            formData.append('country', $("#country option:selected").text());
            formData.append('date_format', $('#date_format').val());
            formData.append('timezone', $('#timezone').val());
            formData.append('language', $('#language').val());
            formData.append('currency_code', $('#currency_code').val());
            formData.append('currency_symbol', $('#currency_symbol_real').val());
            formData.append('localization_btn', 'localization_btn');

            $.ajax({
                type: "POST",
                url: urls,
                dataType: 'json',
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $("#localization_btn").html("<i class='la la-spinner spinner'></i> Please Wait...");
                    $('#localization_btn').addClass('disabled');
                    $('#localization_btn').prop('disabled', true);
                },
                success: function(json) {
                    toastr.info(json[0], 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 5000, "progressBar": true });
                    $("#localization_btn").html("<i class='ft-save'></i> Save Changes");
                    $('#localization_btn').removeClass('disabled');
                    $('#localization_btn').prop('disabled', false);
                },
                error: function(e) {}
            });
        }
    });




    $(document).on('click', '#theme_btn', function(e) {

        if ($("#website_name").val() == "" || $("#display_mode").val() == "") {
            toastr.warning('All Fields Are Required', 'Warning!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 4000, "progressBar": true });
            empty = true;
            return empty;

        } else {
            var formData = new FormData();

            $.each($('#logo')[0].files, function(i, file) {
                formData.append('logo[]', file);
            });

            $.each($('#favicon')[0].files, function(i, file) {
                formData.append('favicon[]', file);
            });

            formData.append('website_name', $("#website_name").val());
            formData.append('display_mode', $('#display_mode').val());
            formData.append('theme_orientation', $('#theme_orientation').val());
            formData.append('theme_btn', 'theme_btn');

            $.ajax({
                type: "POST",
                url: urls,
                dataType: 'json',
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $("#theme_btn").html("<i class='la la-spinner spinner'></i> Please Wait...");
                    $('#theme_btn').addClass('disabled');
                    $('#theme_btn').prop('disabled', true);
                },
                success: function(json) {
                    toastr.info(json[0], 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 5000, "progressBar": true });
                    $("#theme_btn").html("<i class='ft-save'></i> Save Changes");
                    $('#theme_btn').removeClass('disabled');
                    $('#theme_btn').prop('disabled', false);
                    document.location.reload();
                },
                error: function(e) {}
            });
        }
    });




    $(document).on('click', '#email_btn', function(e) {
        if ($("#host").val() == "" || $("#user").val() == "" || $("#password").val() == "" || $("#port").val() == "" || $("#security").val() == "" || $("#domain").val() == "") {
            toastr.warning('All Fields Are Required', 'Warning!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 4000, "progressBar": true });
            empty = true;
            return empty;

        } else {
            var formData = new FormData();

            formData.append('host', $("#host").val());
            formData.append('user', $('#user').val());
            formData.append('password', $('#password').val());
            formData.append('port', $('#port').val());
            formData.append('security', $('#security').val());
            formData.append('domain', $('#domain').val());
            formData.append('email_btn', 'email_btn');

            $.ajax({
                type: "POST",
                url: urls,
                dataType: 'json',
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $("#email_btn").html("<i class='la la-spinner spinner'></i> Please Wait...");
                    $('#email_btn').addClass('disabled');
                    $('#email_btn').prop('disabled', true);
                },
                success: function(json) {
                    toastr.success(json[0], 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 5000, "progressBar": true });
                    $("#email_btn").html("<i class='ft-save'></i> Save Changes");
                    $('#email_btn').removeClass('disabled');
                    $('#email_btn').prop('disabled', false);
                    // document.location.reload();
                },
                error: function(e) {}
            });
        }
    });



    $(document).on('click', '#change_password_btn', function(e) {
        if ($("#old_password").val() == "" || $("#new_password").val() == "" || $("#confirm_password").val() == "") {
            toastr.warning('All Fields Are Required', 'Warning!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 4000, "progressBar": true });
            empty = true;
            return empty;

        } else {
            var formData = new FormData();

            formData.append('old_password', $("#old_password").val());
            formData.append('new_password', $('#new_password').val());
            formData.append('confirm_password', $('#confirm_password').val());
            formData.append('change_password_btn', 'change_password_btn');

            $.ajax({
                type: "POST",
                url: urls,
                dataType: 'json',
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $("#change_password_btn").html("<i class='la la-spinner spinner'></i> Please Wait...");
                    $('#change_password_btn').addClass('disabled');
                    $('#change_password_btn').prop('disabled', true);
                },
                success: function(json) {
                    toastr.success(json[0], 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 5000, "progressBar": true });
                    $("#change_password_btn").html("<i class='ft-save'></i> Save Changes");
                    $('#change_password_btn').removeClass('disabled');
                    $('#change_password_btn').prop('disabled', false);
                    // document.location.reload();
                },
                error: function(e) {}
            });
        }
    });

});