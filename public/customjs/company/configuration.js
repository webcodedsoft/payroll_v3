$(document).ready(function() {
    var baseUrls = $('#static_url').val();
    var urls = baseUrls.concat('Controller/Company/ConfigurationController.php');


    /*Branch Settings*/
    $(document).on('click', '#branch_submit_btn', function(e) {

        if ($('#branch_name').val() == "" && $('#address').val() == "") {
            toastr.warning('Please all fields are required', 'Warning!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000, "progressBar": true });
        } else {
            branch_name = $('#branch_name').val();
            branch_address = $('#branch_address').val();
            telephone1 = $('#telephone1').val();
            telephone2 = $('#telephone2').val();
            branch_email = $('#branch_email').val();
            branch_id = $('#branch_id').val();


            if ($('#branch_status').is(":checked")) {
                branch_status = 'Active';
            } else {
                branch_status = 'Disabled';
            }


            $.ajax({
                type: "POST",
                url: urls,
                dataType: 'json',
                data: { branch_name, branch_address, telephone1, telephone2, branch_email, branch_id, branch_status, branch_submit_btn: "branch_submit_btn", },
                beforeSend: function() {
                    $("#branch_submit_btn").html("<i class='la la-spinner spinner'></i> Please Wait...");
                    $('#branch_submit_btn').addClass('disabled');
                    $('#branch_submit_btn').prop('disabled', true);
                },
                success: function(json) {

                    toastr.success(json, 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000, "progressBar": true });

                    $("#branch_submit_btn").html("<i class='la la-save'></i> Create");
                    $('#branch_submit_btn').removeClass('disabled');
                    $('#branch_submit_btn').prop('disabled', false);
                    $('#add_branch').modal('hide');

                    load_branch_data_list();

                    $('#branch_name').val("");
                    $('#branch_address').val("");
                    $('#telephone1').val("");
                    $('#telephone2').val("");
                    $('#branch_email').val("");
                    $('#branch_id').val("");
                    $('#branch_status').prop('checked', false);

                },
                error: function(e) {
                    $("#branch_submit_btn").html("<i class='la la-save'></i> Create");
                    $('#branch_submit_btn').removeClass('disabled');
                    $('#branch_submit_btn').prop('disabled', false);

                    load_branch_data_list();
                }
            });

        }
    });



    load_branch_data_list();

    function load_branch_data_list(e) {

        $('#branch_list').DataTable({
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
                    branch_list_access: 'branch_list_access',
                },
                error: function(xhr, code, error) {
                    console.log(xhr);
                    console.log(code);
                    console.log(error);
                }
            }
        });


    }


    $(document).on('click', '.delete_branch', function(e) {
        var branch_id = $(this).attr("id");
        DeletePopOverAlert(branch_id, "delete_branch");
    });


    $(document).on('click', '.edit_branch', function(e) {

        var branch_id = $(this).attr("id");

        $.ajax({
            type: "POST",
            url: urls,
            dataType: 'json',
            data: {
                branch_id: branch_id,
                edit_branch: "edit_branch",
            },
            success: function(json) {

                if (json.Status == 'Active') {
                    $("#branch_status").prop('checked', true);
                } else {
                    $("#branch_status").prop('checked', false);
                }
                $('#branch_title').html("Edit Branch");
                $('#branch_name').val(json.Branch_Name);
                $('#branch_address').val(json.Branch_Address);
                $('#telephone1').val(json.Branch_Phone1);
                $('#telephone2').val(json.Branch_Phone2);
                $('#branch_email').val(json.Branch_Email);
                $('#branch_id').val(json.ID);

                $("#branch_submit_btn").html("<i class='la la-save'></i> Update");
                $("#add_branch").modal('show');
            },
        });

    });


    /*Branch Close btn*/
    $(document).on('click', '#branch_close_btn', function() {
        $('#branch_title').html("Add Branch");
        $('#branch_name').val("");
        $('#branch_address').val("");
        $('#telephone1').val("");
        $('#telephone2').val("");
        $('#branch_email').val("");
        $('#branch_id').val("");
        $("#branch_status").prop('checked', false);
        $("#branch_submit_btn").html("<i class='la la-save'></i> Create");
    });




    /*Department Settings*/
    $(document).on('click', '#department_submit_btn', function(e) {

        if ($('#department_name').val() == "") {
            toastr.warning('Department Name is Required', 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000, "progressBar": true });
        } else {
            department_name = $('#department_name').val();
            department_desc = $('#department_desc').val();
            department_id = $('#department_id').val();
            department_id = $('#department_id').val();

            if ($('#department_status').is(":checked")) {
                department_status = 'Active';
            } else {
                department_status = 'Disabled';
            }


            $.ajax({
                type: "POST",
                url: urls,
                dataType: 'json',
                data: { department_name, department_desc, department_id, department_status, department_submit_btn: "department_submit_btn" },
                beforeSend: function() {
                    $("#department_submit_btn").html("<i class='la la-spinner spinner'></i> Please Wait...");
                    $('#department_submit_btn').addClass('disabled');
                    $('#department_submit_btn').prop('disabled', true);
                },
                success: function(json) {
                    toastr.success(json, 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000, "progressBar": true });
                    $("#department_submit_btn").html("<i class='la la-save'></i> Create");
                    $('#department_submit_btn').removeClass('disabled');
                    $('#department_submit_btn').prop('disabled', false);
                    $('#add_department').modal('hide');
                    $('#department_title').html("Add Department");

                    load_department_data_list();

                    $('#department_name').val("");
                    $('#department_desc').val("");
                    $('#department_id').val("");

                },
                error: function(e) {
                    $("#department_submit_btn").html("<i class='la la-save'></i> Create");
                    $('#department_submit_btn').removeClass('disabled');
                    $('#department_submit_btn').prop('disabled', false);

                    load_department_data_list();
                }
            });

        }
    });



    load_department_data_list();

    function load_department_data_list(e) {

        $('#department_list').DataTable({
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
                    department_list_access: 'department_list_access',
                },
                error: function(xhr, code, error) {
                    console.log(xhr);
                    console.log(code);
                    console.log(error);
                }
            }
        });


    }


    $(document).on('click', '.delete_department', function(e) {
        var department_id = $(this).attr("id");
        DeletePopOverAlert(department_id, "delete_department");
    });



    $(document).on('click', '.edit_department', function(e) {

        var department_id = $(this).attr("id");

        $.ajax({
            type: "POST",
            url: urls,
            dataType: 'json',
            data: {
                department_id: department_id,
                edit_department: "edit_department",
            },
            success: function(json) {

                if (json.Status == 'Active') {
                    $("#department_status").prop('checked', true);
                } else {
                    $("#department_status").prop('checked', false);
                }
                $('#department_title').html("Edit Department");
                $('#department_name').val(json.Department_Name);
                $('#department_desc').val(json.Department_Desc);
                $('#department_id').val(json.ID);

                $("#department_submit_btn").html("<i class='la la-save'></i> Update");
                $("#add_department").modal('show');
            },
        });

    });


    /*Department Close btn*/
    $(document).on('click', '#department_close_btn', function() {

        $('#department_title').html("Add Department");
        $('#department_name').val("");
        $('#department_desc').val("");
        $('#department_id').val("");
        $("#department_status").prop('checked', false);
        $("#department_submit_btn").html("<i class='la la-save'></i> Create");
    });



    /*Manage Journal Update */
    $(document).on('click', '#journal_submit_btn', function(e) {

        var accounting_code = [];

        $.each($("input[name='accounting_code']"), function() {
            accounting_code.push($(this).val());
        });

        accounting_code = accounting_code.join(",");

        $.ajax({
            type: "POST",
            url: urls,
            dataType: 'json',
            data: { accounting_code, journal_submit_btn: "journal_submit_btn" },
            success: function(json) {
                toastr.success('Entry Successfully Saved...', 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 5000, "progressBar": true });
                load_journal_data_list();
                $('#edit_journal').modal('hide');

            },
            error: function(e) {}

        });


    });



    load_journal_data_list();

    function load_journal_data_list(e) {

        $('#journal_list').DataTable({
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
                    journal_list_access: 'journal_list_access',
                },
                error: function(xhr, code, error) {
                    console.log(xhr);
                    console.log(code);
                    console.log(error);
                }
            }
        });


    }




    /* Add Salary Tax */
    $(document).on('click', '#salary_tax_submit_btn', function(e) {

        if ($('#salary_from').val() == "" || $('#salary_to').val() == "" || $('#tax_rate').val() == "") {
            toastr.warning('All fields are required', 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000, "progressBar": true });
        } else {
            salary_from = $('#salary_from').val();
            salary_to = $('#salary_to').val();
            tax_rate = $('#tax_rate').val();
            salary_id = $('#salary_id').val();
            salary_status = $('#salary_status').val();

            if ($('#salary_status').is(":checked")) {
                salary_status = 'Active';
            } else {
                salary_status = 'Disabled';
            }

            $.ajax({
                type: "POST",
                url: urls,
                dataType: 'json',
                data: { salary_from, salary_to, tax_rate, salary_id, salary_status, salary_tax_submit_btn: "salary_tax_submit_btn" },
                beforeSend: function() {
                    $("#salary_tax_submit_btn").html("<i class='la la-spinner spinner'></i> Please Wait...");
                    $('#salary_tax_submit_btn').addClass('disabled');
                    $('#salary_tax_submit_btn').prop('disabled', true);
                },
                success: function(json) {
                    toastr.success(json, 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000, "progressBar": true });
                    $("#salary_tax_submit_btn").html("<i class='la la-save'></i> Add Salary Tax");
                    $('#salary_tax_submit_btn').removeClass('disabled');
                    $('#salary_tax_submit_btn').prop('disabled', false);
                    $('#add_salary_tax').modal('hide');

                    load_salary_tax_data_list();

                    $('#salary_title').html("Add Salary Tax");
                    $('#salary_from').val("");
                    $('#salary_to').val("");
                    $('#tax_rate').val("");
                    $('#salary_id').val("");
                    $("#salary_status").prop('checked', false);

                },
                error: function(e) {
                    $("#salary_tax_submit_btn").html("<i class='la la-save'></i> Add Salary Tax");
                    $('#salary_tax_submit_btn').removeClass('disabled');
                    $('#salary_tax_submit_btn').prop('disabled', false);

                    load_salary_tax_data_list();
                }
            });

        }
    });



    $(document).on('click', '.edit_salary', function(e) {

        var salary_id = $(this).attr("id");

        $.ajax({
            type: "POST",
            url: urls,
            dataType: 'json',
            data: { salary_id, edit_salary: "edit_salary", },
            success: function(json) {
                if (json.Status == 'Active') {
                    $("#salary_status").prop('checked', true);
                } else {
                    $("#salary_status").prop('checked', false);
                }

                $('#salary_title').html("Edit Salary Tax");
                $('#salary_from').val(json.Salary_From);
                $('#salary_to').val(json.Salary_To);
                $('#tax_rate').val(json.Tax_Rate);
                $('#salary_id').val(json.ID);

                $("#salary_tax_submit_btn").html("<i class='la la-save'></i> Update Salary Tax");
                $("#add_salary_tax").modal('show');
            },
        });

    });


    /*Salary Close btn*/
    $(document).on('click', '#salary_tax_close_btn', function() {
        $('#salary_title').html("Add Salary Tax");
        $('#salary_from').val("");
        $('#salary_to').val("");
        $('#tax_rate').val("");
        $('#salary_id').val("");
        $("#salary_status").prop('checked', false);
        $("#salary_tax_submit_btn").html("<i class='la la-save'></i> Add Salary Tax");
    });


    $(document).on('click', '.delete_salary', function(e) {
        var salary_id = $(this).attr("id");
        DeletePopOverAlert(salary_id, "delete_salary");
    });



    load_salary_tax_data_list();

    function load_salary_tax_data_list(e) {

        $('#salary_tax_list').DataTable({
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
                    salary_tax_list_access: 'salary_tax_list_access',
                },
                error: function(xhr, code, error) {
                    console.log(xhr);
                    console.log(code);
                    console.log(error);
                }
            }
        });


    }


    /*Social Security Settings*/
    $(document).on('click', '#social_submit_btn', function(e) {

        if ($('#sos_code').val() == "" && $('#sos_rate').val() == "") {
            toastr.warning('Please all fields are required', 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000, "progressBar": true });
        } else {
            sos_code = $('#sos_code').val();
            sos_rate = $('#sos_rate').val();
            sos_id = $('#sos_id').val();

            if ($('#social_status').is(":checked")) {
                sos_status = 'Active';
            } else {
                sos_status = 'Disabled';
            }

            $.ajax({
                type: "POST",
                url: urls,
                dataType: 'json',
                data: { sos_code, sos_rate, sos_id, sos_status, social_submit_btn: 'social_submit_btn' },
                beforeSend: function() {
                    $("#social_submit_btn").html("<i class='la la-spinner spinner'></i> Please Wait...");
                    $('#social_submit_btn').addClass('disabled');
                    $('#social_submit_btn').prop('disabled', true);
                },
                success: function(json) {
                    toastr.success(json, 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000, "progressBar": true });

                    $("#social_submit_btn").html("<i class='la la-save'></i> Add Social Security");
                    $('#social_submit_btn').removeClass('disabled');
                    $('#social_submit_btn').prop('disabled', false);
                    $('#add_social_security').modal('hide');

                    load_social_security_data_list();

                    $('#social_security_title').html("Add Social Security");
                    $('#sos_code').val("");
                    $('#sos_rate').val("");
                    $('#sos_id').val("");
                    $("#social_status").prop('checked', false);

                },
                error: function(e) {
                    $('#sos_code').val("");
                    $('#sos_rate').val("");
                    $('#sos_id').val("");

                    load_social_security_data_list();
                }
            });

        }
    });


    $(document).on('click', '.delete_social', function(e) {
        var sos_id = $(this).attr("id");
        DeletePopOverAlert(sos_id, "delete_social");
    });



    $(document).on('click', '.edit_social', function(e) {

        var sos_id = $(this).attr("id");

        $.ajax({
            type: "POST",
            url: urls,
            dataType: 'json',
            data: { sos_id, edit_social: "edit_social", },
            success: function(json) {
                if (json.Status == 'Active') {
                    $("#social_status").prop('checked', true);
                } else {
                    $("#social_status").prop('checked', false);
                }
                $('#social_security_title').html("Edit Social Security");
                $('#sos_code').val(json.Sos_Code);
                $('#sos_rate').val(json.Rate);
                $('#sos_id').val(json.ID);

                $("#social_submit_btn").html("<i class='la la-save'></i> Update Social Security");
                $('#add_social_security').modal('show');
            },
        });

    });


    load_social_security_data_list();

    function load_social_security_data_list(e) {

        $('#social_security_list').DataTable({
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
                    social_security_list_access: 'social_security_list_access',
                },
                error: function(xhr, code, error) {
                    console.log(xhr);
                    console.log(code);
                    console.log(error);
                }
            }
        });


    }


    /*Social Security Close btn*/
    $(document).on('click', '#social_close_btn', function() {
        $('#social_security_title').html("Add Association");
        $('#sos_code').val("");
        $('#sos_rate').val("");
        $('#sos_id').val("");
        $("#social_status").prop('checked', false);
        $("#social_submit_btn").html("Submit");
    });


    /*Association Settings*/
    $(document).on('click', '#association_submit_btn', function(e) {

        if ($('#association_code').val() == "" && $('#association_rate').val() == "") {
            toastr.warning('Please all fields are required', 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000, "progressBar": true });
        } else {
            association_code = $('#association_code').val();
            association_rate = $('#association_rate').val();
            association_id = $('#association_id').val();

            if ($('#association_status').is(":checked")) {
                association_status = 'Active';
            } else {
                association_status = 'Disabled';
            }

            $.ajax({
                type: "POST",
                url: urls,
                dataType: 'json',
                data: { association_code, association_rate, association_id, association_status, association_submit_btn: 'association_submit_btn' },
                beforeSend: function() {
                    $("#association_submit_btn").html("<i class='la la-spinner spinner'></i> Please Wait...");
                    $('#association_submit_btn').addClass('disabled');
                    $('#association_submit_btn').prop('disabled', true);
                },
                success: function(json) {

                    toastr.success(json, 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000, "progressBar": true });
                    $("#association_submit_btn").html("<i class='la la-save'></i> Add Association");
                    $('#association_submit_btn').removeClass('disabled');
                    $('#association_submit_btn').prop('disabled', false);
                    $('#add_association').modal('hide');
                    load_association_data_list();

                    $('#association_code').val("");
                    $('#association_rate').val("");
                    $('#association_id').val("");
                    $("#association_status").prop('checked', false);

                    $('#association_title').html("Add Association");
                },
                error: function(e) {
                    $("#association_submit_btn").html("<i class='la la-save'></i> Add Association");
                    $('#association_submit_btn').removeClass('disabled');
                    $('#association_submit_btn').prop('disabled', false);
                    $('#add_association').modal('hide');
                }
            });

        }
    });


    $(document).on('click', '.delete_association', function(e) {
        var association_id = $(this).attr("id");
        DeletePopOverAlert(association_id, "delete_association");
    });



    $(document).on('click', '.edit_association', function(e) {

        var association_id = $(this).attr("id");

        $.ajax({
            type: "POST",
            url: urls,
            dataType: 'json',
            data: { association_id, edit_association: "edit_association", },
            success: function(json) {
                if (json.Status == 'Active') {
                    $("#association_status").prop('checked', true);
                } else {
                    $("#association_status").prop('checked', false);
                }
                $('#association_title').html("Edit Association");
                $('#association_code').val(json.Association_Code);
                $('#association_rate').val(json.Association_Rate);
                $('#association_id').val(json.ID);

                $("#association_submit_btn").html("<i class='la la-save'></i> Update Association");
                $('#add_association').modal('show');
            },
        });

    });

    load_association_data_list();

    function load_association_data_list(e) {

        $('#association_list').DataTable({
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
                    association_list_access: 'association_list_access',
                },
                error: function(xhr, code, error) {
                    console.log(xhr);
                    console.log(code);
                    console.log(error);
                }
            }
        });


    }


    /*Social Security Close btn*/
    $(document).on('click', '#association_close_btn', function() {
        $('#association_title').html("Add Association");
        $('#association_code').val("");
        $('#association_rate').val("");
        $('#association_id').val("");
        $("#association_status").prop('checked', false);
        $("#association_submit_btn").html("<i class='la la-save'></i> Add Association");
    });



    /*Currency Settings*/
    $(document).on('click', '#currency_submit_btn', function(e) {

        if ($('#currency_country_id').val() == "" || $('.currency_names').val() == "" || $('#currency_codes').val() == "" || $('#currency_symbols').html() == "" || $('#curreny_type').val() == "" || $('#currency_status').val() == "") {
            toastr.warning('Please all fields are required', 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000, "progressBar": true });
        } else {

            country_currency_name = $("#currency_country_id").val();
            currency_name = $('.currency_names').val();
            currency_codes = $('.currency_codes').val();
            currency_symbols = $('.currency_symbols').html();
            curreny_type = $('#curreny_type').val();
            currency_status = $('#currency_status').val();
            currency_id = $('#currency_id').val();

            if ($('#currency_status').is(":checked")) {
                currency_status = 'Active';
            } else {
                currency_status = 'Disabled';
            }

            $.ajax({
                type: "POST",
                url: urls,
                dataType: 'json',
                data: { country_currency_name, currency_name, currency_codes, currency_symbols, curreny_type, currency_id, currency_status, currency_submit_btn: 'currency_submit_btn' },
                beforeSend: function() {
                    $("#currency_submit_btn").html("<i class='la la-spinner spinner'></i> Please Wait...");
                    $('#currency_submit_btn').addClass('disabled');
                    $('#currency_submit_btn').prop('disabled', true);
                },
                success: function(json) {

                    toastr.success(json, 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000, "progressBar": true });
                    $("#currency_submit_btn").html("<i class='la la-save'></i> Add Currency");
                    $('#currency_submit_btn').removeClass('disabled');
                    $('#currency_submit_btn').prop('disabled', false);
                    $('#add_currency').modal('hide');
                    load_currency_data_list();

                    $('#currency_title').html("Add Currency");

                    $('#currency_country_id').val("").change();
                    $('.currency_names').val("");
                    $('.currency_codes').val("");
                    $('.currency_symbol_reals').val("");
                    $('#curreny_type').val("").change();
                    $('#currency_id').val("");
                    $("#currency_status").prop('checked', false);
                },
                error: function(e) {
                    $("#currency_submit_btn").html("<i class='la la-save'></i> Add Currency");
                    $('#currency_submit_btn').removeClass('disabled');
                    $('#currency_submit_btn').prop('disabled', false);
                }
            });

        }
    });


    $(document).on('click', '.delete_currency', function(e) {
        var currency_id = $(this).attr("id");
        DeletePopOverAlert(currency_id, "delete_currency");
    });



    $(document).on('click', '.edit_currency', function(e) {

        var currency_id = $(this).attr("id");

        $.ajax({
            type: "POST",
            url: urls,
            dataType: 'json',
            data: { currency_id, edit_currency: "edit_currency", },
            success: function(json) {

                if (json.Status == 'Active') {
                    $("#currency_status").prop('checked', true);
                } else {
                    $("#currency_status").prop('checked', false);
                }
                $('#currency_title').html("Edit Association");

                //$("#currency_country_id option").text(json.Country_Name).change();
                $('#currency_country_id').val(json.Country_Name).change();
                $('.currency_names').val(json.Currency_Name);
                $('.currency_codes').val(json.Currency_Code);
                $('.currency_symbols').html(json.Currency_Symbol);
                $('.currency_symbol_reals').val(json.Currency_Symbol);
                $('#curreny_type').val(json.Currency_Type).change();
                $('#currency_id').val(json.ID);

                $("#currency_submit_btn").html("<i class='la la-save'></i> Update Currency");
                $('#add_currency').modal('show');
            },
        });

    });

    load_currency_data_list();

    function load_currency_data_list(e) {

        $('#currency_list').DataTable({
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
                    currency_list_access: 'currency_list_access',
                },
                error: function(xhr, code, error) {
                    console.log(xhr);
                    console.log(code);
                    console.log(error);
                }
            }
        });


    }


    /*Currency Close btn*/
    $(document).on('click', '#currency_close_btn', function() {
        $('#currency_title').html("Add Currency");
        $('#currency_country_id').val("").change();
        $('.currency_names').val("");
        $('.currency_codes').val("");
        $('.currency_symbols').html("");
        $('.currency_symbol_reals').val("");
        $('#curreny_type').val("").change();
        $('#currency_id').val("");
        $("#association_status").prop('checked', false);
        $("#currency_submit_btn").html("<i class='la la-save'></i> Add Currency");
    });



    /*Vacation Days Settings*/
    $(document).on('click', '#vacation_submit_btn', function(e) {

        if ($('#vacation_name').val() == "" && $('#vacation_num_day').val() == "") {
            toastr.warning('Please all fields are required', 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000, "progressBar": true });
        } else {
            vacation_name = $('#vacation_name').val();
            vacation_num_day = $('#vacation_num_day').val();
            vacation_id = $('#vacation_id').val();

            if ($('#vacation_status').is(":checked")) {
                vacation_status = 'Active';
            } else {
                vacation_status = 'Disabled';
            }

            $.ajax({
                type: "POST",
                url: urls,
                dataType: 'json',
                data: { vacation_name, vacation_num_day, vacation_id, vacation_status, vacation_submit_btn: 'vacation_submit_btn' },
                beforeSend: function() {
                    $("#vacation_submit_btn").html("<i class='la la-spinner spinner'></i> Please Wait...");
                    $('#vacation_submit_btn').addClass('disabled');
                    $('#vacation_submit_btn').prop('disabled', true);
                },
                success: function(json) {
                    toastr.success(json, 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000, "progressBar": true });
                    $("#vacation_submit_btn").html("<i class='la la-save'></i> Add Vacation");
                    $('#vacation_submit_btn').removeClass('disabled');
                    $('#vacation_submit_btn').prop('disabled', false);
                    $('#add_vacation').modal('hide');
                    load_vacation_data_list();

                    $('#vacation_name').val("");
                    $('#vacation_num_day').val("");
                    $('#vacation_id').val("");
                    $("#vacation_status").prop('checked', false);

                    $('#vacation_title').html("Add Vacation");
                },
                error: function(e) {
                    $("#vacation_submit_btn").html("<i class='la la-save'></i> Add Vacation");
                    $('#vacation_submit_btn').removeClass('disabled');
                    $('#vacation_submit_btn').prop('disabled', false);
                    $('#add_vacation').modal('hide');

                    load_vacation_data_list();
                }
            });

        }
    });


    $(document).on('click', '.delete_vacation', function(e) {
        var vacation_id = $(this).attr("id");
        DeletePopOverAlert(vacation_id, "delete_vacation");
    });


    $(document).on('click', '.edit_vacation', function(e) {

        var vacation_id = $(this).attr("id");

        $.ajax({
            type: "POST",
            url: urls,
            dataType: 'json',
            data: { vacation_id, edit_vacation: "edit_vacation", },
            success: function(json) {

                if (json.Status == 'Active') {
                    $("#vacation_status").prop('checked', true);
                } else {
                    $("#vacation_status").prop('checked', false);
                }
                $('#vacation_title').html("Edit Vacation");
                $('#vacation_name').val(json.Vacation_Name);
                $('#vacation_num_day').val(json.Vacation_Day);
                $('#vacation_id').val(json.ID);
                $("#vacation_submit_btn").html("<i class='la la-save'></i> Update Vacation");
                $('#add_vacation').modal('show');
            },
        });

    });


    load_vacation_data_list();

    function load_vacation_data_list(e) {

        $('#vacation_list').DataTable({
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
                    vacation_list_access: 'vacation_list_access',
                },
                error: function(xhr, code, error) {
                    console.log(xhr);
                    console.log(code);
                    console.log(error);
                }
            }
        });


    }


    /*Vacation Close btn*/
    $(document).on('click', '#vacation_close_btn', function() {
        $('#vacation_title').html("Add Vacation");
        $('#vacation_name').val("");
        $('#vacation_num_day').val("");
        $('#vacation_id').val("");
        $("#vacation_status").prop('checked', false);
        $("#vacation_submit_btn").html("<i class='la la-save'></i> Add Vacation");
    });



    /*Family Tax Settings*/
    $(document).on('click', '#family_tax_submit_btn', function(e) {

        if ($('#number_of_kids').val() == "" && $('#tax_amount').val() == "") {
            toastr.warning('Please all fields are required', 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000, "progressBar": true });
        } else {
            number_of_kids = $('#number_of_kids').val();
            tax_amount = $('#tax_amount').val();
            family_tax_id = $('#family_tax_id').val();

            if ($('#family_tax_status').is(":checked")) {
                family_tax_status = 'Active';
            } else {
                family_tax_status = 'Disabled';
            }

            $.ajax({
                type: "POST",
                url: urls,
                dataType: 'json',
                data: { number_of_kids, tax_amount, family_tax_id, family_tax_status, family_tax_submit_btn: 'family_tax_submit_btn' },
                beforeSend: function() {
                    $("#family_tax_submit_btn").html("<i class='la la-spinner spinner'></i> Please Wait...");
                    $('#family_tax_submit_btn').addClass('disabled');
                    $('#family_tax_submit_btn').prop('disabled', true);
                },
                success: function(json) {

                    toastr.success(json, 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000, "progressBar": true });
                    $("#family_tax_submit_btn").html("<i class='la la-save'></i> Add Family Tax");
                    $('#family_tax_submit_btn').removeClass('disabled');
                    $('#family_tax_submit_btn').prop('disabled', false);
                    $('#add_family_tax').modal('hide');
                    load_family_tax_data_list();

                    $('#number_of_kids').val("");
                    $('#tax_amount').val("");
                    $('#family_tax_id').val("");
                    $("#family_tax_status").prop('checked', false);

                    $('#family_tax_title').html("Add Family Tax");
                },
                error: function(e) {
                    $("#family_tax_submit_btn").html("<i class='la la-save'></i> Add Family Tax");
                    $('#family_tax_submit_btn').removeClass('disabled');
                    $('#family_tax_submit_btn').prop('disabled', false);

                    load_family_tax_data_list();
                }
            });

        }
    });


    $(document).on('click', '.delete_family_tax', function(e) {
        var family_tax_id = $(this).attr("id");
        DeletePopOverAlert(family_tax_id, "delete_family_tax");
    });


    $(document).on('click', '.edit_family_tax', function(e) {

        var family_tax_id = $(this).attr("id");

        $.ajax({
            type: "POST",
            url: urls,
            dataType: 'json',
            data: { family_tax_id, edit_family_tax: "edit_family_tax", },
            success: function(json) {

                if (json.Status == 'Active') {
                    $("#family_tax_status").prop('checked', true);
                } else {
                    $("#family_tax_status").prop('checked', false);
                }
                $('#family_tax_title').html("Edit Family Tax");
                $('#number_of_kids').val(json.Kids_Num);
                $('#tax_amount').val(json.Kid_Amount);
                $('#family_tax_id').val(json.ID);
                $("#family_tax_submit_btn").html("<i class='la la-save'></i> Update Family Tax");
                $('#add_family_tax').modal('show');
            },
        });

    });



    load_family_tax_data_list();

    function load_family_tax_data_list(e) {

        $('#family_tax_list').DataTable({
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
                    family_tax_list_access: 'family_tax_list_access',
                },
                error: function(xhr, code, error) {
                    console.log(xhr);
                    console.log(code);
                    console.log(error);
                }
            }
        });


    }


    /*Family Tax Close btn*/
    $(document).on('click', '#family_tax_close_btn', function() {
        $('#family_tax_title').html("Add Family Tax");
        $('#number_of_kids').val("");
        $('#tax_amount').val("");
        $('#family_tax_id').val("");
        $("#family_tax_status").prop('checked', false);
        $("#family_tax_submit_btn").html("<i class='la la-save'></i> Add Family Tax");
    });



    /*Marital Status Settings*/
    $(document).on('click', '#marital_status_submit_btn', function(e) {

        if ($('#status_name').val() == "" && $('#status_amount').val() == "") {
            toastr.warning('Please all fields are required', 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000, "progressBar": true });
        } else {
            status_name = $('#status_name').val();
            status_amount = $('#status_amount').val();
            marital_status_id = $('#marital_status_id').val();

            if ($('#marital_status_status').is(":checked")) {
                marital_status_status = 'Active';
            } else {
                marital_status_status = 'Disabled';
            }

            $.ajax({
                type: "POST",
                url: urls,
                dataType: 'json',
                data: { status_name: status_name, status_amount: status_amount, marital_status_id: marital_status_id, marital_status_status: marital_status_status, marital_status_submit_btn: 'marital_status_submit_btn' },
                beforeSend: function() {
                    $("#marital_status_submit_btn").html("<i class='la la-spinner spinner'></i> Please Wait...");
                    $('#marital_status_submit_btn').addClass('disabled');
                    $('#marital_status_submit_btn').prop('disabled', true);
                },
                success: function(json) {

                    toastr.success(json, 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000, "progressBar": true });
                    $("#marital_status_submit_btn").html("<i class='la la-save'></i> Add Marital Status");
                    $('#marital_status_submit_btn').removeClass('disabled');
                    $('#marital_status_submit_btn').prop('disabled', false);
                    $('#add_marital_status').modal('hide');
                    load_marital_status_data_list();

                    $('#status_name').val("");
                    $('#status_amount').val("");
                    $('#marital_status_id').val("");
                    $("#marital_status_status").prop('checked', false);
                    $('#marital_status_title').html("Add Marital Status");
                },
                error: function(e) {
                    $("#marital_status_submit_btn").html("<i class='la la-save'></i> Add Marital Status");
                    $('#marital_status_submit_btn').removeClass('disabled');
                    $('#marital_status_submit_btn').prop('disabled', false);

                    load_marital_status_data_list();
                }
            });

        }
    });




    $(document).on('click', '.delete_marital_status', function(e) {
        var marital_status_id = $(this).attr("id");
        DeletePopOverAlert(marital_status_id, "delete_marital_status");
    });


    $(document).on('click', '.edit_marital_status', function(e) {

        var marital_status_id = $(this).attr("id");

        $.ajax({
            type: "POST",
            url: urls,
            dataType: 'json',
            data: { marital_status_id, edit_marital_status: "edit_marital_status", },
            success: function(json) {

                if (json.Status == 'Active') {
                    $("#marital_status_status").prop('checked', true);
                } else {
                    $("#marital_status_status").prop('checked', false);
                }
                $('#marital_status_title').html("Edit Marital Status");
                $('#status_name').val(json.Married_Name);
                $('#status_amount').val(json.Married_Amount);
                $('#marital_status_id').val(json.ID);
                $("#marital_status_submit_btn").html("<i class='la la-save'></i> Update Marital Status");
                $('#add_marital_status').modal('show');
            },
        });

    });


    load_marital_status_data_list();

    function load_marital_status_data_list(e) {

        $('#marital_status_list').DataTable({
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
                    marital_status_list_access: 'marital_status_list_access',
                },
                error: function(xhr, code, error) {
                    console.log(xhr);
                    console.log(code);
                    console.log(error);
                }
            }
        });


    }


    /*Family Tax Close btn*/
    $(document).on('click', '#marital_status_close_btn', function() {
        $('#marital_status_title').html("Add Marital Status");
        $('#status_name').val("");
        $('#status_amount').val("");
        $('#marital_status_id').val("");
        $("#marital_status_status").prop('checked', false);
        $("#marital_status_submit_btn").html("<i class='la la-save'></i> Add Marital Status");
    });






    /*Leave Type Settings*/
    $(document).on('click', '#leave_type_submit_btn', function(e) {

        if ($('#leave_type').val() == "" && $('#leave_type_number_of_day').val() == "") {
            toastr.warning('Please all fields are required', 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000, "progressBar": true });
        } else {
            leave_type = $('#leave_type').val();
            leave_type_number_of_day = $('#leave_type_number_of_day').val();
            leave_type_id = $('#leave_type_id').val();

            if ($('#leave_type_status').is(":checked")) {
                leave_type_status = 'Active';
            } else {
                leave_type_status = 'Disabled';
            }

            $.ajax({
                type: "POST",
                url: urls,
                dataType: 'json',
                data: { leave_type, leave_type_number_of_day, leave_type_id, leave_type_status, leave_type_submit_btn: 'leave_type_submit_btn' },
                beforeSend: function() {
                    $("#leave_type_submit_btn").html("<i class='la la-spinner spinner'></i> Please Wait...");
                    $('#leave_type_submit_btn').addClass('disabled');
                    $('#leave_type_submit_btn').prop('disabled', true);
                },
                success: function(json) {

                    toastr.success(json, 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000, "progressBar": true });
                    $("#leave_type_submit_btn").html("<i class='la la-save'></i> Add Leave Type");
                    $('#leave_type_submit_btn').removeClass('disabled');
                    $('#leave_type_submit_btn').prop('disabled', false);
                    $('#add_leave_type').modal('hide');
                    load_leave_type_data_list();

                    $('#leave_type_title').html("Add Leave Type");
                    $('#leave_type').val("");
                    $('#leave_type_number_of_day').val("");
                    $('#leave_type_id').val("");
                    $("#leave_type_status").prop('checked', false);
                    $("#leave_type_submit_btn").html("<i class='la la-save'></i> Add Leave Type");
                },
                error: function(e) {
                    $("#leave_type_submit_btn").html("<i class='la la-save'></i> Add Leave Type");
                    $('#leave_type_submit_btn').removeClass('disabled');
                    $('#leave_type_submit_btn').prop('disabled', false);
                    load_leave_type_data_list();
                }
            });

        }
    });


    $(document).on('click', '.delete_leave_type', function(e) {
        var leave_type_id = $(this).attr("id");
        DeletePopOverAlert(leave_type_id, "delete_leave_type");
    });



    $(document).on('click', '.edit_leave_type', function(e) {

        var leave_type_id = $(this).attr("id");

        $.ajax({
            type: "POST",
            url: urls,
            dataType: 'json',
            data: { leave_type_id, edit_leave_type: "edit_leave_type", },
            success: function(json) {

                if (json.Status == 'Active') {
                    $("#leave_type_status").prop('checked', true);
                } else {
                    $("#leave_type_status").prop('checked', false);
                }
                $('#leave_type_title').html("Edit Leave Type");
                $('#leave_type').val(json.Leave_Type);
                $('#leave_type_number_of_day').val(json.Number_of_Days);
                $('#leave_type_id').val(json.ID);
                $("#leave_type_submit_btn").html("<i class='la la-save'></i> Update Leave Type");
                $('#add_leave_type').modal('show');
            },
        });

    });




    load_leave_type_data_list();

    function load_leave_type_data_list(e) {

        $('#leave_type_list').DataTable({
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
                    leave_type_list_access: 'leave_type_list_access',
                },
                error: function(xhr, code, error) {
                    console.log(xhr);
                    console.log(code);
                    console.log(error);
                }
            }
        });


    }


    $(document).on('click', '#leave_type_close_btn', function() {
        $('#leave_type_title').html("Add Leave Type");
        $('#leave_type').val("");
        $('#leave_type_number_of_day').val("");
        $('#leave_type_id').val("");
        $("#leave_type_status").prop('checked', false);
        $("#leave_type_submit_btn").html("<i class='la la-save'></i> Add Leave Type");
    });




    $('#currency_country_id').change(function() {
        var currency_country_id = $(this).val();
        $.ajax({
            url: urls,
            method: "POST",
            dataType: 'json',
            data: { currency_country_id: currency_country_id },
            success: function(json) {
                $('#currency_name').val(json[0].Currency);
                $('.currency_codes').val(json[0].Code);
                $('.currency_symbols').html(json[0].Symbol);
                $('.currency_symbol_reals').val(json[0].Symbol);
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
                    beforeSend: function() {
                        $("#user_actions").html("<i class='la la-spinner spinner'></i>");
                        $('#user_actions').addClass('disabled');
                        $('#user_actions').prop('disabled', true);
                    },
                    success: function(json) {
                        swal("Deleted!", "Your data has been deleted.", "success");
                        if (json == 'Deleted_Branch')
                            load_branch_data_list();
                        if (json == 'Deleted_Department')
                            load_department_data_list();
                        if (json == 'Deleted_Salary')
                            load_salary_tax_data_list();
                        if (json == 'Deleted_Social')
                            load_social_security_data_list();
                        if (json == 'Deleted_Association')
                            load_association_data_list();
                        if (json == 'Deleted_Currency')
                            load_currency_data_list();
                        if (json == 'Deleted_Vacation')
                            load_vacation_data_list();
                        if (json == 'Deleted_Family_Tax')
                            load_family_tax_data_list();
                        if (json == 'Deleted_Marital_Status')
                            load_marital_status_data_list();
                        if (json == 'Deleted_Leave_Type')
                            load_leave_type_data_list();
                    },

                });

            } else {
                swal("Cancelled", "Your data is safe :)", "error");
            }
        });
    }



});