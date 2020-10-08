$(document).ready(function() {

    var baseUrls = $('#static_url').val();
    var urls = baseUrls.concat('Controller/Company/PayrollController.php');

    $('#computation_div').fadeOut();

    $('#earning_payment_type').change(function(e) {
        var earning_payment_type = $(this).val();

        $.ajax({
            url: urls,
            method: "POST",
            dataType: 'json',
            data: { earning_access: 'earning_access', earning_payment_type },

            success: function(json) {
                $('#computation_div').fadeIn();

                $('#employee_earning_table').html(json[0]);
            },

        });
    });




    $(document).on('click', '#add_earning', function(e) {

        var empty = false;

        var employee_id = [];
        var bonus = [];
        var comission = [];
        var allowance = [];
        var otherearning = [];
        var extra1 = [];
        var extra2 = [];
        var ordinary = [];

        if ($("#payment_date").val() == "") {
            toastr.warning('Select Payment Date', 'Warning!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 4000, "progressBar": true });
            empty = true;
            return empty;

        } else {

            $(".employee_id").each(function() {
                employee_id.push($(this).val());
            });
            $(".bonus").each(function() {
                bonus.push($(this).val());
            });
            $(".comission").each(function() {
                comission.push($(this).val());
            });
            $(".allowance").each(function() {
                allowance.push($(this).val());
            });
            $(".otherearning").each(function() {
                otherearning.push($(this).val());
            });

            $(".extra1").each(function() {
                extra1.push($(this).val());
            });
            $(".extra2").each(function() {
                extra2.push($(this).val());
            });

            $(".ordinary").each(function() {
                ordinary.push($(this).val());
            });

            var payment_date = $("#payment_date").val();
            var exchang_rate = $("#exchang_rate").val();

            $.ajax({
                type: "POST",
                url: urls,
                dataType: 'json',
                data: { employee_id, bonus, comission, allowance, otherearning, extra1, extra2, ordinary, payment_date, exchang_rate, add_earning_btn: 'add_earning_btn' },
                beforeSend: function() {
                    $("#add_earning").html("<i class='la la-spinner spinner'></i> Please Wait...");
                    $('#add_earning').addClass('disabled');
                    $('#add_earning').prop('disabled', true);
                },
                success: function(json) {
                    toastr.info(json[0], 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 5000, "progressBar": true });
                    $("#add_earning").html("<i class='la la-save'></i> Submit");
                    $('#add_earning').removeClass('disabled');
                    $('#add_earning').prop('disabled', false);

                },

                error: function(e) {

                }
            });
        }


    });



    /*Employee Earning With Date range*/
    $('#update_earning_payment_type').change(function(e) {
        var update_earning_payment_type_value = $(this).val();

        $.ajax({
            url: urls,
            method: "POST",
            dataType: 'text',
            data: { update_earning_payment_type_value, load_date_range_base_on_payment_type: "Date_Range" },
            success: function(date_range) {
                $('#earning_update_date').html(date_range);
            },
            error: function(e) {
                //console.log(e);
            },
        });

    });



    $('#update_computation_div').fadeOut();
    /*Load Employee Earning Record Data Table btn*/
    $(document).on('click', '#earning_update_search_btn', function(e) {
        var earning_update_date = $("#earning_update_date").val();
        var update_earning_payment_type = $("#update_earning_payment_type").val();
        $.ajax({
            type: "POST",
            url: urls,
            dataType: 'json',
            data: { earning_update_date, update_earning_payment_type, fetch_employee_earning: "fetch_employee_earning" },
            success: function(json) {
                console.log(json);
                $('#employee_earning_update_table').html(json[0]);
                $('#update_exchange_rate').val(json[1]);
                $('#update_computation_div').fadeIn();
            },
        });
    });



    $(document).on('click', '#update_earning_btn', function(e) {

        var empty = false;

        var employee_id_update = [];
        var bonus_update = [];
        var comission_update = [];
        var allowance_update = [];
        var otherearning_update = [];
        var extra1_update = [];
        var extra2_update = [];
        var ordinary_update = [];

        if ($("#earning_update_date").val() == "") {
            toastr.warning('Select Payment Date', 'Warning!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 4000, "progressBar": true });
            empty = true;
            return empty;

        } else {

            $(".employee_id_update").each(function() {
                employee_id_update.push($(this).val());
            });
            $(".bonus_update").each(function() {
                bonus_update.push($(this).val());
            });
            $(".comission_update").each(function() {
                comission_update.push($(this).val());
            });
            $(".allowance_update").each(function() {
                allowance_update.push($(this).val());
            });
            $(".otherearning_update").each(function() {
                otherearning_update.push($(this).val());
            });

            $(".extra1_update").each(function() {
                extra1_update.push($(this).val());
            });
            $(".extra2_update").each(function() {
                extra2_update.push($(this).val());
            });

            $(".ordinary_update").each(function() {
                ordinary_update.push($(this).val());
            });

            var payment_date_update = $("#earning_update_date").val();
            var exchang_rate_update = $("#update_exchange_rate").val();

            $.ajax({
                type: "POST",
                url: urls,
                dataType: 'json',
                data: { employee_id_update, bonus_update, comission_update, allowance_update, otherearning_update, extra1_update, extra2_update, ordinary_update, payment_date_update, exchang_rate_update, update_earning_btn: 'update_earning_btn' },
                beforeSend: function() {
                    $("#update_earning_btn").html("<i class='la la-spinner spinner'></i> Please Wait...");
                    $('#update_earning_btn').addClass('disabled');
                    $('#update_earning_btn').prop('disabled', true);
                },
                success: function(json) {
                    toastr.info(json[0], 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 5000, "progressBar": true });
                    $("#update_earning_btn").html("<i class='la la-save'></i> Submit");
                    $('#update_earning_btn').removeClass('disabled');
                    $('#update_earning_btn').prop('disabled', false);

                },

                error: function(e) {

                }
            });
        }


    });



    $('#employee_deduction_id').change(function(e) {
        var employee_deduction_id = $(this).val();
        $.ajax({
            url: urls,
            method: "POST",
            dataType: 'html',
            data: { employee_deduction_id, load_date_range_base_on_employee_id: "employee_id" },
            success: function(earning_date_range_payment) {
                $('#earning_date_range_payment').html(earning_date_range_payment);
            },
            error: function(e) {

            },
        });

    });


    $('#deduction_computation_div').fadeOut();
    $(document).on('click', '#deduction_search_btn', function(e) {

        var earning_date_range_payment = $("#earning_date_range_payment").val();
        var employee_deduction_id = $("#employee_deduction_id").val();

        $.ajax({
            url: urls,
            method: "POST",
            dataType: 'json',
            data: { earning_date_range_payment, employee_deduction_id, deduction_search_btn: "deduction_search_btn" },
            success: function(json) {
                $('#employee_deduction_table').html(json);
                $('#deduction_computation_div').fadeIn();
            },
        });


    });



    $(document).on('click', '#deduction_btn', function(e) {
        var empty = false;

        var employee_id_deduct = [];
        var loan = [];
        var assessment = [];
        var othersdeduction = [];

        if ($("#earning_date_range_payment").val() == "") {
            toastr.warning('Select Payment Date', 'Warning!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 4000, "progressBar": true });
            empty = true;
            return empty;

        } else {

            $(".employee_id_deduct").each(function() {
                employee_id_deduct.push($(this).val());
            });
            $(".loan").each(function() {
                loan.push($(this).val());
            });
            $(".assessment").each(function() {
                assessment.push($(this).val());
            });
            $(".othersdeduction").each(function() {
                othersdeduction.push($(this).val());
            });


            var earning_date_range_payment = $("#earning_date_range_payment").val();

            $.ajax({
                type: "POST",
                url: urls,
                dataType: 'json',
                data: { employee_id_deduct, loan, assessment, othersdeduction, earning_date_range_payment, deduction_btn: 'deduction_btn' },
                beforeSend: function() {
                    $("#deduction_btn").html("<i class='la la-spinner spinner'></i> Please Wait...");
                    $('#deduction_btn').addClass('disabled');
                    $('#deduction_btn').prop('disabled', true);
                },
                success: function(json) {
                    toastr.info(json[0], 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 5000, "progressBar": true });
                    $("#deduction_btn").html("<i class='la la-save'></i> Submit");
                    $('#deduction_btn').removeClass('disabled');
                    $('#deduction_btn').prop('disabled', false);

                },

                error: function(e) {}
            });
        }


    });



    $('#employee_leave_id').change(function(e) {
        var employee_leave_id = $(this).val();
        $.ajax({
            url: urls,
            method: "POST",
            dataType: 'json',
            data: { employee_leave_id, load_employee_leave: "load_employee_leave" },
            success: function(json) {
                $('#employee_leave_table').html(json[0]);
            },
            error: function(e) {

            },
        });

    });



    $(document).on('click', '#employee_leave_submit_btn', function(e) {
        var empty = false;

        if ($("#employee_leave_type").val() == "" || $("#leave_from").val() == "" || $("#leave_to").val() == "") {
            toastr.warning('Select Payment Date', 'Warning!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 4000, "progressBar": true });
            empty = true;
            return empty;

        } else {

            var leave_employee_id = $("#leave_employee_id").val();
            var employee_leave_type = $("#employee_leave_type").val();
            var leave_reason = $("#leave_reason").val();
            var leave_from = $("#leave_from").val();
            var leave_to = $("#leave_to").val();
            var leave_payment_type = $("#leave_payment_type").val();

            $.ajax({
                type: "POST",
                url: urls,
                dataType: 'json',
                data: { leave_employee_id, employee_leave_type, leave_reason, leave_from, leave_to, leave_payment_type, employee_leave_submit_btn: 'employee_leave_submit_btn' },
                beforeSend: function() {
                    $("#employee_leave_submit_btn").html("<i class='la la-spinner spinner'></i> Please Wait...");
                    $('#employee_leave_submit_btn').addClass('disabled');
                    $('#employee_leave_submit_btn').prop('disabled', true);
                },
                success: function(json) {
                    toastr.info(json[0], 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 5000, "progressBar": true });
                    $("#employee_leave_submit_btn").html("<i class='la la-save'></i> Submit");
                    $('#employee_leave_submit_btn').removeClass('disabled');
                    $('#employee_leave_submit_btn').prop('disabled', false);
                    $('#add_employee_leave').modal('hide');
                    load_employee_leave_list();
                    $('#leave_employee_id').val("");
                    $('#employee_leave_type').val("").change();
                    $('#leave_reason').val("");
                    $('#leave_from').val("");
                    $('#leave_to').val("");
                    $('#leave_payment_type').val("");
                },
                error: function(e) {}
            });
        }


    });




    load_employee_leave_list();

    function load_employee_leave_list(e) {

        $('#employee_leave_list').DataTable({
            dom: 'Bftiplr',
            "processing": true,
            oLanguage: { sProcessing: '<div class="ball-pulse-sync loader-purple"><div></div><div></div><div></div><div></div></div>' },
            "serverSide": true,
            "searching": true,
            "bDestroy": true,
            "scrollCollapse": true,
            "responsive": false,
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
                    employee_leave_list_access: 'employee_leave_list_access',
                },
                error: function(xhr, code, error) {
                    console.log(xhr);
                    console.log(code);
                    console.log(error);
                }
            }
        });


    }


    $(document).on('click', '.delete_leave', function(e) {
        var employee_leave_id = $(this).attr("id");
        DeletePopOverAlert(employee_leave_id, "delete_leave");
    });

    $(document).on('click', '#employee_leave_close_btn', function(e) {

        $('#leave_employee_id').val("");
        $('#employee_leave_type').val("").change();
        $('#leave_reason').val("");
        $('#leave_from').val("");
        $('#leave_to').val("");
        $('#leave_payment_type').val("");

    });


    $('#assigned_option_div').fadeOut();


    $('input[type=radio][name=assigned_option]').change(function(e) {
        if (this.value == "Select Employee") {
            $('#assigned_option_div').fadeIn();
        } else {
            $('#assigned_option_div').fadeOut();
        }
    });


    $('#payroll_item_update').fadeOut();
    $(document).on('click', '.payroll_item_submit_btn', function(e) {
        var empty = false;

        if ($("#payroll_item_name").val() == "" || $("#payroll_item_amount").val() == "" || $("#payroll_item_date").val() == null) {
            toastr.warning('Payroll Item Name, Item Amount, Item Date cannot be empty', 'Warning!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 4000, "progressBar": true });
            empty = true;
            return empty;

        } else {
            var saving_type = $(this).attr("id");
            var payroll_item_id = $("#payroll_item_id").val();
            var payroll_item_name = $("#payroll_item_name").val();
            var payroll_item_amount = $("#payroll_item_amount").val();
            var assigned_option = $("input[name=assigned_option]:checked").val();
            var assigned_employee_id = $("#assigned_employee_id").val();
            var payroll_item_date = $("#payroll_item_date").val();
            //console.log(payroll_item_date);

            if ($('#payroll_item_status').is(":checked")) {
                payroll_item_status = 'Active';
            } else {
                payroll_item_status = 'Disabled';
            }

            $.ajax({
                type: "POST",
                url: urls,
                dataType: 'json',
                data: { payroll_item_id, payroll_item_name, payroll_item_amount, assigned_option, assigned_employee_id, payroll_item_date, payroll_item_status, saving_type, payroll_item_submit_btn: 'payroll_item_submit_btn' },
                beforeSend: function() {
                    $("#payroll_item_submit_btn").html("<i class='la la-spinner spinner'></i> Please Wait...");
                    $('#payroll_item_submit_btn').addClass('disabled');
                    $('#payroll_item_submit_btn').prop('disabled', true);
                },
                success: function(json) {
                    toastr.info(json[0], 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 5000, "progressBar": true });

                    $('#create_option').fadeIn();
                    $('#payroll_item_update').fadeOut();

                    $('#payroll_item_submit_btn').removeClass('disabled');
                    $('#payroll_item_submit_btn').prop('disabled', false);
                    $('#add_payroll_item').modal('hide');
                    load_payroll_item_list();
                    $('#payroll_item_id').val("");
                    $('#payroll_item_name').val("");
                    $('#payroll_item_amount').val("");
                    $("#assigned_option_dont").prop('checked', true);
                    $('#assigned_employee_id').val("").change();
                    $('#payroll_item_date').val("").change();
                    $("#payroll_item_status").prop('checked', false);
                },
                error: function(e) {}
            });
        }


    });


    load_payroll_item_list();

    function load_payroll_item_list(e) {

        $('#payroll_item_list').DataTable({
            dom: 'Bftiplr',
            "processing": true,
            oLanguage: { sProcessing: '<div class="ball-pulse-sync loader-purple"><div></div><div></div><div></div><div></div></div>' },
            "serverSide": true,
            "searching": true,
            "bDestroy": true,
            "scrollCollapse": true,
            "responsive": false,
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
                    payroll_item_list_access: 'payroll_item_list_access',
                },
                error: function(xhr, code, error) {
                    console.log(xhr);
                    console.log(code);
                    console.log(error);
                }
            }
        });


    }




    $(document).on('click', '.delete_payroll_item', function(e) {
        var delete_method = $(this).attr("id");
        var payroll_item_id = $(this).data("id");
        methods_and_id = { "Delete_Method": delete_method, "Payroll_Item_ID": payroll_item_id }
        DeletePopOverAlert(methods_and_id, "delete_payroll_item");
    });



    $(document).on('click', '.edit_payroll_item', function(e) {
        var payroll_item_id = $(this).attr("id");

        $.ajax({
            type: "POST",
            url: urls,
            dataType: 'json',
            data: {
                payroll_item_id: payroll_item_id,
                edit_payroll_item: "edit_payroll_item",
            },
            success: function(json) {

                $('#payroll_item_name').val(json[0].Payroll_Item_Name);
                $('#payroll_item_amount').val(json[0].Payroll_Item_Amount);
                $('#assigned_option').val(json[0].Payroll_Item_Assigned);
                $('#assigned_employee_id').val(json[0].Payroll_Item_Assigned_To).change();
                $('#payroll_item_date').val(json[0].Payroll_Item_Date).change();
                $('#payroll_item_id').val(json[0].ID);


                if (json[0].Payroll_Item_Assigned == 'Select Employee') {
                    $("#assigned_option_select").prop('checked', true);
                    $('#assigned_option_div').fadeIn();
                } else if (json[0].Payroll_Item_Assigned == "All Employees") {
                    $("#assigned_option_all").prop('checked', true);
                } else if (json[0].Payroll_Item_Assigned == "Don't Assigned") {
                    $("#assigned_option_dont").prop('checked', true);
                }

                if (json[0].Status == 'Active') {
                    $("#payroll_item_status").prop('checked', true);
                } else {
                    $("#payroll_item_status").prop('checked', false);
                }
                $('#create_option').fadeOut();
                $('#payroll_item_update').fadeIn();

                $("#add_payroll_item").modal('show');
            },
        });

    });



    $(document).on('click', '#payroll_item_close_btn', function(e) {
        $('#payroll_item_id').val("");
        $('#payroll_item_name').val("");
        $('#payroll_item_amount').val("");
        $("#assigned_option_dont").prop('checked', true);
        $('#assigned_employee_id').val("").change();
        $('#payroll_item_date').val("").change();
        $("#payroll_item_status").prop('checked', false);
        $('#create_option').fadeIn();
        $('#payroll_item_update').fadeOut();
        $('#assigned_option_div').fadeOut();
    });




    load_manage_payroll_table_list();

    function load_manage_payroll_table_list(e) {

        $('#manage_employee_payroll_list').DataTable({
            dom: 'Bftiplr',
            "processing": true,
            oLanguage: { sProcessing: '<div class="ball-pulse-sync loader-purple"><div></div><div></div><div></div><div></div></div>' },
            "serverSide": true,
            "searching": true,
            "bDestroy": true,
            "scrollCollapse": true,
            "responsive": false,
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
                    manage_payroll_access: 'manage_payroll_access',
                },
                error: function(xhr, code, error) {
                    console.log(xhr);
                    console.log(code);
                    console.log(error);
                }
            }
        });


    }




    $('#manage_payroll_btns').fadeOut();
    var selected_payroll_count = 0;
    var unselected_payroll_count = 0;
    var total_selected_payroll_count = 0;

    $(".select_all_manage_payroll_all").change(function() {
        if (this.checked) {
            $(".single_manage_payroll_select").each(function() {
                this.checked = true;
                $('#manage_payroll_btns').fadeIn();
                total_selected_payroll_count = $('[name=select_all_manage_payroll]').length - 1;
                $("#delete_selected_manage_payroll_btn").html('<i class="la la-trash"></i> Delete (' + total_selected_payroll_count + ') Selected Payroll');
                $("#lock_unlock_selected_manage_payroll_btn").html('<i class="la la-unlock-alt"></i> Lock/Unlock (' + total_selected_payroll_count + ') Selected Payroll');
                $("#send_payment_proof_to_selected_manage_payroll_btn").html('<i class="la la-envelope"></i> Send Payment Proof To (' + total_selected_payroll_count + ') Selected Employee');
            });
        } else {
            $(".single_manage_payroll_select").each(function() {
                this.checked = false;
                $('#manage_payroll_btns').fadeOut();
            });
        }
    });

    $(document).on('click', '.single_manage_payroll_select', function(e) {
        if ($(this).is(":checked")) {
            total_selected_payroll_count += 1;
            total_selected_payroll_count = total_selected_payroll_count;
            //console.log("Single First Check " + total_selected_payroll_count);
            $('#manage_payroll_btns').fadeIn();
            $("#delete_selected_manage_payroll_btn").html('<i class="la la-trash"></i> Delete (' + total_selected_payroll_count + ') Selected Payroll');
            $("#lock_unlock_selected_manage_payroll_btn").html('<i class="la la-unlock-alt"></i> Lock/Unlock (' + total_selected_payroll_count + ') Selected Payroll');
            $("#send_payment_proof_to_selected_manage_payroll_btn").html('<i class="la la-envelope"></i> Send Payment Proof To (' + total_selected_payroll_count + ') Selected Employee');


            var isAllChecked = 0;
            $(".single_manage_payroll_select").each(function() {
                if (!this.checked) {
                    unselected_payroll_count += 1;
                    isAllChecked = 1;
                    //console.log("I know " + isAllChecked);
                }

            });

            if (isAllChecked == 0) {
                $(".select_all_manage_payroll_all").prop("checked", true);
            }
        } else {

            total_selected_payroll_count -= 1;
            total_selected_payroll_count = total_selected_payroll_count;

            //console.log("Single Uncheck " + unselected_payroll_count);
            $(".select_all_manage_payroll_all").prop("checked", false);
            if (total_selected_payroll_count > 0) {
                $('#manage_payroll_btns').fadeIn();
                $("#delete_selected_manage_payroll_btn").html('<i class="la la-trash"></i> Delete (' + total_selected_payroll_count + ') Selected Payroll');
                $("#lock_unlock_selected_manage_payroll_btn").html('<i class="la la-unlock-alt"></i> Lock/Unlock (' + total_selected_payroll_count + ') Selected Payroll');
                $("#send_payment_proof_to_selected_manage_payroll_btn").html('<i class="la la-envelope"></i> Send Payment Proof To (' + total_selected_payroll_count + ') Selected Employee');

            } else {
                $('#manage_payroll_btns').fadeOut();
            }

        }
        //console.log("Total Selected " + total_selected_payroll_count);
    });





    $(document).on('click', '#delete_selected_manage_payroll_btn', function(e) {
        var single_manage_payroll_select_id = [];

        if (total_selected_payroll_count < 1) {
            toastr.warning('Please Select atleast One Payroll', 'Warning!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 4000, "progressBar": true });
        } else {
            $(".single_manage_payroll_select:checkbox:checked").each(function() {
                single_manage_payroll_select_id.push($(this).val());
            });

            DeletePopOverAlert(single_manage_payroll_select_id, "delete_selected_manage_payroll_btn");
        }

    });


    $(document).on('click', '#lock_unlock_selected_manage_payroll_btn', function(e) {
        var empty = false;
        var single_manage_payroll_select_id = [];

        if (total_selected_payroll_count < 1) {
            toastr.warning('Please Select atleast One Payroll', 'Warning!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 4000, "progressBar": true });
            empty = true;
            return empty;

        } else {

            $(".single_manage_payroll_select:checkbox:checked").each(function() {
                single_manage_payroll_select_id.push($(this).val());
            });

            $.ajax({
                type: "POST",
                url: urls,
                dataType: 'json',
                data: { single_manage_payroll_select_id, lock_unlock_selected_manage_payroll_btn: 'lock_unlock_selected_manage_payroll_btn' },
                beforeSend: function() {
                    $("#lock_unlock_selected_manage_payroll_btn").html("<i class='la la-spinner spinner'></i> Please Wait...");
                    $('#lock_unlock_selected_manage_payroll_btn').addClass('disabled');
                    $('#lock_unlock_selected_manage_payroll_btn').prop('disabled', true);
                },
                success: function(json) {
                    toastr.info(json[0], 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 5000, "progressBar": true });

                    $('#lock_unlock_selected_manage_payroll_btn').removeClass('disabled');
                    $('#lock_unlock_selected_manage_payroll_btn').prop('disabled', false);

                    $(".select_all_manage_payroll_all").prop("checked", false);
                    total_selected_payroll_count = 0;

                    load_manage_payroll_table_list();
                    $('#manage_payroll_btns').fadeOut();
                    $("#delete_select_manage_payroll_btn").html('<i class="la la-trash"></i> Delete Payroll');
                    $("#lock_unlock_select_manage_payroll_btn").html('<i class="la la-unlock-alt"></i> Lock/Unlock Payroll');
                    $("#send_payment_proof_to_select_manage_payroll_btn").html('<i class="la la-envelope"></i> Send Payroll Payment Proof');

                },
                error: function(e) {}
            });
        }


    });


    $(document).on('click', '#send_payment_proof_to_selected_manage_payroll_btn', function(e) {
        var empty = false;
        var single_manage_payroll_select_id = [];

        if (total_selected_payroll_count < 1) {
            toastr.warning('Please Select atleast One Payroll', 'Warning!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 4000, "progressBar": true });
            empty = true;
            return empty;

        } else {

            $(".single_manage_payroll_select:checkbox:checked").each(function() {
                single_manage_payroll_select_id.push($(this).val());
            });

            $.ajax({
                type: "POST",
                url: urls,
                dataType: 'json',
                data: { single_manage_payroll_select_id, send_payment_proof_to_selected_manage_payroll_btn: 'send_payment_proof_to_selected_manage_payroll_btn' },
                beforeSend: function() {
                    $("#send_payment_proof_to_selected_manage_payroll_btn").html("<i class='la la-spinner spinner'></i> Please Wait...");
                    $('#send_payment_proof_to_selected_manage_payroll_btn').addClass('disabled');
                    $('#send_payment_proof_to_selected_manage_payroll_btn').prop('disabled', true);
                },
                success: function(json) {
                    toastr.info(json, 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 5000, "progressBar": true });

                    $('#send_payment_proof_to_selected_manage_payroll_btn').removeClass('disabled');
                    $('#send_payment_proof_to_selected_manage_payroll_btn').prop('disabled', false);

                    $(".select_all_manage_payroll_all").prop("checked", false);
                    total_selected_payroll_count = 0;

                    load_manage_payroll_table_list();
                    $('#manage_payroll_btns').fadeOut();
                    $("#delete_select_manage_payroll_btn").html('<i class="la la-trash"></i> Delete Payroll');
                    $("#lock_unlock_select_manage_payroll_btn").html('<i class="la la-unlock-alt"></i> Lock/Unlock Payroll');
                    $("#send_payment_proof_to_select_manage_payroll_btn").html('<i class="la la-envelope"></i> Send Payroll Payment Proof');

                },
                error: function(e) {}
            });
        }


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
                        $("#client_actions").html("<i class='la la-spinner spinner'></i>");
                        $('#client_actions').addClass('disabled');
                        $('#client_actions').prop('disabled', true);
                    },
                    success: function(json) {
                        swal("Deleted!", "Your data has been deleted.", "success");

                        if (json == 'Employee_Leave_Deleted')
                            load_employee_leave_list();
                        if (json == 'Payroll_Item_Deleted')
                            load_payroll_item_list();
                        if (json == 'Selected_Payroll_Deleted') {
                            $(".select_all_manage_payroll_all").prop("checked", false);
                            total_selected_payroll_count = 0;
                            load_manage_payroll_table_list();
                            $('#manage_payroll_btns').fadeOut();
                            $("#delete_select_manage_payroll_btn").html('<i class="la la-trash"></i> Delete Payroll');
                            $("#lock_unlock_select_manage_payroll_btn").html('<i class="la la-unlock-alt"></i> Lock/Unlock Payroll');
                            $("#send_payment_proof_to_select_manage_payroll_btn").html('<i class="la la-envelope"></i> Send Payroll Payment Proof');
                        }
                    },

                });

            } else {
                swal("Cancelled", "Your data is safe :)", "error");
            }
        });
    }




});