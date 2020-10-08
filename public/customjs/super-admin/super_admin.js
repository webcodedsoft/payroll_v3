$(document).ready(function() {
    //var formdata = $('form').serialize(); //All input in urlencoded form
    // var formdata = { formdata: formdata.val() } //For only one input
    //obj[item.name] = item.value;

    //formdata[0].value //To Access value
    var baseUrls = $('#static_url').val();

    $(document).on("input", ".number_only", function(event) {
        this.value = this.value.replace(/[^\d]/g, '');

    });

    var urls = baseUrls.concat('Controller/Admin/adminController.php');

    //Create Company
    $(document).on('click', '#create_company_btn', function(e) {
        e.preventDefault();

        var formdata = $('form').serializeArray(); //All input in Array form
        var company_email = $('#company_email').val();
        var company_id = $('#company_id').val();
        var _id = $('#id').val();

        if ($('#company_email').val() == "" || $('#company_email').val() === null || $('#company_id').val() == "" || $('#company_id').val() === null) {

            toastr.info("All fields are required", 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 5000, "progressBar": true });

        } else {

            $.ajax({
                type: 'POST',
                url: urls,
                dataType: 'json',
                data: { company_email: company_email, company_id: company_id, _id: _id, create_company_btn: 'create_company_btn' },

                beforeSend: function() {

                    $("#create_company_btn").html("<i class='la la-spinner spinner'></i> Please Wait...");
                    $('#create_company_btn').addClass('disabled');
                    $('#create_company_btn').prop('disabled', true);
                },
                success: function(json) {
                    toastr.info(json[0], 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 5000, "progressBar": true });
                    $("#create_company_btn").html("<i class='la la-save'></i> Create");
                    $('#create_company_btn').removeClass('disabled');
                    $('#create_company_btn').prop('disabled', false);
                    $("#create_company").modal('hide');

                    $('#company_email').val("");
                    $('#company_id').val("");
                    $('#id').val("");

                    load_registered_company_list();


                },
                error: function(e) {
                    //console.log('Error' + e);
                }
            });
        }


    });



    //Web Settings
    $(document).on('click', '#web_settings_btn', function(e) {
        e.preventDefault();

        var formdata = $('form').serializeArray(); //All input in Array form

        var phone_number = $('#phone_number').val();
        var web_url = $('#web_url').val();

        if ($('#phone_number').val() == "" || $('#web_url').val() === null) {

            toastr.info("All fields are required", 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 5000, "progressBar": true });

        } else {

            $.ajax({
                type: 'POST',
                url: urls,
                dataType: 'json',
                data: { phone_number: phone_number, web_url: web_url, web_settings_btn: 'web_settings_btn' },
                beforeSend: function() {

                    $("#web_settings_btn").html("<i class='la la-spinner spinner'></i> Please Wait...");
                    $('#web_settings_btn').addClass('disabled');
                    $('#web_settings_btn').prop('disabled', true);
                },
                success: function(json) {
                    toastr.info(json, 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 5000, "progressBar": true });
                    $("#web_settings_btn").html("<i class='la la-save'></i> Save Changes");
                    $('#web_settings_btn').removeClass('disabled');
                    $('#web_settings_btn').prop('disabled', false);
                },
                error: function(e) {
                    //console.log('Error' + e);
                }
            });
        }


    });






    //Subscription Package Creation
    $(document).on('click', '#package_button', function(e) {
        e.preventDefault();

        var formdata = $('form').serializeArray(); //All input in Array form

        var plan_name = $('#plan_name').val();
        var plan_amount = $('#plan_amount').val();
        var plan_type = $('#plan_type').val();
        var no_user = $('#no_user').val();
        var plan_duration = $('#plan_duration').val();
        var storage_space = $('#storage_space').val();
        var package_status = $('#package_status').val();
        var edit_package_id = $('#plan_id').val();

        if ($('#package_status').is(":checked")) {
            package_status = 'Active';
        } else {
            package_status = 'Disabled';
        }
        if ($('#plan_name').val() === null || $('#plan_amount').val() === null || $('#plan_type').val() === null || $('#no_user').val() === null) {

            toastr.info("All fields are required", 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 5000, "progressBar": true });

        } else {
            $.ajax({
                type: 'POST',
                url: urls,
                dataType: 'json',
                data: {
                    plan_name: plan_name,
                    plan_amount: plan_amount,
                    plan_type: plan_type,
                    no_user: no_user,
                    plan_duration: plan_duration,
                    storage_space: storage_space,
                    package_status: package_status,
                    edit_package_id: edit_package_id,
                    package_button: 'package_button'
                },
                beforeSend: function() {

                    $("#package_button").html("<i class='la la-spinner spinner'></i> Please Wait...");
                    $('#package_button').addClass('disabled');
                    $('#package_button').prop('disabled', true);
                },
                success: function(json) {
                    toastr.info(json[0], 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 5000, "progressBar": true });
                    $("#package_button").html("<i class='la la-save'></i> Create");
                    $('#package_button').removeClass('disabled');
                    $('#package_button').prop('disabled', false);
                    subscription_package_list();
                    $("#create_package").modal('hide');
                    $('#plan_id').val("");
                    $('#plan_name').val("");
                    $('#plan_amount').val("");
                    $('#plan_type').val("").change();
                    $('#no_user').val("").change();
                    $('#plan_duration').val("").change();
                    $('#storage_space').val("").change();

                },
                error: function(e) {
                    //console.log('Error' + e);
                }
            });
        }


    });



    //Registered Company Table
    load_registered_company_list();

    function load_registered_company_list(e) {
        //var baseUrls = $(location).attr('href');


        $('#registered_company_list').DataTable({
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
                    registered_company_list_access: 'registered_company_list_access',
                },
                error: function(xhr, code, error) {
                    console.log(xhr);
                    console.log(code);
                    console.log(error);
                }
            }
        });


    }



    //Delete Company Alert
    $(document).on('click', '.delete_company', function(e) {
        var delete_value = $(this).attr("id");
        var delete_function = "delete_company";
        DeletePopOverAlert(delete_value, delete_function);

    });




    $(document).on('click', '.edit_company', function(e) {

        var edit_company_id = $(this).attr("id");

        $.ajax({
            type: "POST",
            url: urls,
            dataType: 'json',
            data: {
                edit_company_id: edit_company_id,
                edit_company_btn: "edit_company_btn",
            },
            success: function(json) {
                $('#company_email').val(json[0].Company_Email);
                $('#company_id').val(json[0].Company_ID);
                $('#id').val(json[0].ID);
                $("#create_company").modal('show');
                $("#create_company_btn").html("<i class='la la-save'></i> Update");
            },
        });

    });


    $(document).on('click', '#create_company_btn_close', function() {
        $('#company_email').val("");
        $('#company_id').val("");
        $('#id').val("");
        $("#create_company_btn").html("<i class='la la-save'></i> Create");
    });



    subscription_package_list();

    function subscription_package_list(e) {
        //var baseUrls = $(location).attr('href');


        $('#subscription_package_list').DataTable({
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
                    subscription_package_list_access: 'subscription_package_list_access',
                },
                error: function(xhr, code, error) {
                    console.log(xhr);
                    console.log(code);
                    console.log(error);
                }
            }
        });


    }



    //Delete Package
    $(document).on('click', '.delete_package', function(e) {
        var delete_value = $(this).attr("id");
        var delete_function = "delete_package";
        DeletePopOverAlert(delete_value, delete_function);

    });



    //Edit Package
    $(document).on('click', '.edit_package', function(e) {

        var edit_package_id = $(this).attr("id");

        $.ajax({
            type: "POST",
            url: urls,
            dataType: 'json',
            data: {
                edit_package_id: edit_package_id,
                edit_package_btn: "edit_package_btn",
            },
            success: function(json) {
                $('#plan_id').val(json[0].ID);
                $('#plan_name').val(json[0].Plan_Name);
                $('#plan_amount').val(json[0].Plan_Amount);
                $('#plan_type').val(json[0].Plan_Type).change();
                $('#no_user').val(json[0].No_User).change();
                $('#plan_duration').val(json[0].Plan_Duration).change();
                $('#storage_space').val(json[0].Storage_Space).change();

                if (json[0].Package_Status == 'Active') {
                    $('#package_status').prop("checked", true);
                } else {
                    //$('#package_status').is(":checked")
                }

                $("#create_package").modal('show');
                $("#package_button").html("<i class='la la-save'></i> Update");
            },
        });

    });



    $(document).on('click', '#package_popup_close', function() {
        $('#plan_id').val("");
        $('#plan_name').val("");
        $('#plan_amount').val("");
        $('#plan_type').val("").change();
        $('#no_user').val("").change();
        $('#plan_duration').val("").change();
        $('#storage_space').val("").change();
        $("#package_button").html("<i class='la la-save'></i> Create");
    });







    //Complete Registered Company Table
    load_complete_registered_company_list();

    function load_complete_registered_company_list(e) {
        //var baseUrls = $(location).attr('href');


        $('#complete_registered_company_list').DataTable({
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
                    complete_registered_company_list_access: 'complete_registered_company_list_access',
                },
                error: function(xhr, code, error) {
                    console.log(xhr);
                    console.log(code);
                    console.log(error);
                }
            }
        });


    }



    //Set Company to Disabled
    $(document).on('click', '.company_status', function(e) {

        var company_status_id = $(this).attr("id");

        if ($('.company_status').is(":checked")) {
            company_status = 'Active';
        } else {
            company_status = 'Disabled';
        }


        $.ajax({
            type: "POST",
            url: urls,
            dataType: 'json',
            data: {
                company_status_id: company_status_id,
                company_status: company_status,
                company_status_btn: "company_status_btn",
            },
            success: function(json) {
                //load_complete_registered_company_list();
            },
        });

    });




    //Change Package Plan Table
    $('#change_company_subscription_package_list').DataTable({
        "serverSide": true,
        "bDestroy": true,
        "responsive": true,
        "ajax": {
            url: urls,
            method: "POST",
            dataType: 'json',
            data: {
                subscription_package_list_access: 'subscription_package_list_access',
                company_subscription_package_list_access: 'company_subscription_package_list_access'
            },
            error: function(xhr, code, error) {
                console.log(xhr);
                console.log(code);
                console.log(error);
            }
        }
    });


    //Assign Company ID to Company Package Change Plan Model
    $(document).on('click', '.change_plan', function(e) {
        var __company_id = $(this).attr("id");
        $('#__company_id').val(__company_id);
        $("#change_company_package_plan").modal('show');
    });



    //Upgrade Package Plan
    $(document).on('click', '.upgrade_package_plan', function(e) {
        var __package_id = $(this).attr("id");
        var __company_id = $('#__company_id').val();

        $.ajax({
            type: "POST",
            url: urls,
            dataType: 'json',
            data: {
                __package_id: __package_id,
                __company_id: __company_id,
                package_plan_upgrade_btn: "package_plan_upgrade_btn",
            },
            success: function(json) {
                load_complete_registered_company_list();
                $("#change_company_package_plan").modal('hide');
                toastr.info(json[0], 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 5000, "progressBar": true });
            },
        });

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
                        load_registered_company_list();
                        subscription_package_list();
                    },

                });

            } else {
                swal("Cancelled", "Your data is safe :)", "error");
            }
        });
    }


});