$(document).ready(function() {
    var baseUrls = $('#static_url').val();
    var urls = baseUrls.concat('Controller/Company/EmployeeController.php');

    $(".tabs-default").tabs();

    $('#employee_country').change(function() {
        var employee_country_id = $(this).val();

        $.ajax({
            url: urls,
            method: "POST",
            dataType: 'text',
            data: { employee_country_id: employee_country_id },
            success: function(json) {
                $('#employee_state').html(json);
            },
        });
    });




    /*Employee Creation Setup*/

    $(document).on('click', '#add_employee_btn', function(e) {

        if (!validateForm()) {
            toastr.warning('Please fill all highlighted fields', 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 4000, "progressBar": true });
        } else {

            var formData = new FormData();

            $.each($('#employee_image')[0].files, function(i, file) {
                formData.append('employee_image[]', file);
            });
            employee_country = $("#employee_country option:selected").text() == 'Select Employee Country' ? '' : $("#employee_country option:selected").text();

            formData.append('employee_id', $('#employee_id').val());
            formData.append('employee_employee_id', $('#employee_employee_id').val());
            formData.append('employee_fullname', $('#employee_fullname').val());
            formData.append('employee_lastname', $('#employee_lastname').val());
            formData.append('employee_date_of_birth', $('#employee_date_of_birth').val());
            formData.append('employee_gender', $('#employee_gender').val());
            formData.append('employee_phone_number', $('#employee_phone_number').val());
            formData.append('employee_branch', $('#employee_branch').val());
            formData.append('employee_department', $('#employee_department').val());
            formData.append('employee_position', $('#employee_position').val());
            formData.append('employee_hiring_date', $('#employee_hiring_date').val());
            formData.append('employee_address', $('#employee_address').val());
            formData.append('employee_license', $('#employee_license').val());
            formData.append('employee_marital_status', $('#employee_marital_status').val());
            formData.append('employee_country', employee_country);
            formData.append('employee_state', $('#employee_state').val());
            formData.append('employee_religion', $('#employee_religion').val());
            formData.append('employee_no_of_children', $('#employee_no_of_children').val());
            formData.append('emergency_primary_name', $('#emergency_primary_name').val());
            formData.append('emergency_primary_relationship', $('#emergency_primary_relationship').val());
            formData.append('emergency_primary_contact', $('#emergency_primary_contact').val());
            formData.append('emergency_secondary_name', $('#emergency_secondary_name').val());
            formData.append('emergency_secondary_relationship', $('#emergency_secondary_relationship').val());
            formData.append('emergency_secondary_contact', $('#emergency_secondary_contact').val());
            formData.append('employee_bank_name', $('#employee_bank_name').val());
            formData.append('employee_account_number', $('#employee_account_number').val());
            formData.append('employee_social_security_per', $('#employee_social_security_per').val());
            formData.append('employee_association_per', $('#employee_association_per').val());
            formData.append('employee_annual_vacation_day', $('#employee_annual_vacation_day').val());
            formData.append('employee_payment_type', $('#employee_payment_type').val());
            formData.append('employee_currency_type', $('#employee_currency_type').val());
            formData.append('employee_monthly_salary', $('#employee_monthly_salary').val());
            formData.append('employee_email_address', $('#employee_email_address').val());
            formData.append('employee_password', $('#employee_password').val());
            formData.append('add_employee_btn', 'add_employee_btn');


            $.ajax({
                type: "POST",
                url: urls,
                dataType: 'json',

                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $("#add_employee_btn").html("<i class='la la-spinner spinner'></i> Please Wait...");
                    $('#add_employee_btn').addClass('disabled');
                    $('#add_employee_btn').prop('disabled', true);
                },
                success: function(json) {

                    $('#add_employee_btn').removeClass('disabled');
                    $('#add_employee_btn').prop('disabled', false);

                    if (json.Action == 'Update') {
                        $("#add_employee_btn").html("<i class='la la-save'></i> Update Employee");

                        toastr.success(json[0], 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 5000, "progressBar": true });
                    } else {
                        $("#add_employee_btn").html("<i class='la la-save'></i> Add Employee");

                        ClearForm();
                        $('#employee_gender').val("").change();
                        $('#employee_branch').val("").change();
                        $('#employee_department').val("").change();
                        $('#employee_marital_status').val("").change();
                        $('#employee_country').val("").change();
                        $('#employee_country').val("").change();
                        $('#employee_state').val("").change();
                        $('#employee_religion').val("").change();
                        $('#employee_no_of_children').val("").change();
                        $('#employee_social_security_per').val("").change();
                        $('#employee_association_per').val("").change();
                        $('#employee_annual_vacation_day').val("").change();
                        $('#employee_payment_type').val("").change();
                        $('#employee_currency_type').val("").change();
                        $("#employee_country option:selected").text("Select Employee Country");

                        toastr.success(json[0], 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 5000, "progressBar": true });
                    }



                },


            });
        }

    });




    load_employee_data_list();

    function load_employee_data_list(e) {

        $('#employee_list').DataTable({
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
                    employee_listt_access: 'employee_listt_access',
                },
                error: function(xhr, code, error) {
                    console.log(xhr);
                    console.log(code);
                    console.log(error);
                }
            }
        });


    }


    $(document).on('click', '.delete_employee', function(e) {
        var employee_id = $(this).attr("id");
        DeletePopOverAlert(employee_id, "delete_employee");
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
                        load_employee_data_list();
                        LoadEmployeeGridView();
                    },

                });

            } else {
                swal("Cancelled", "Your data is safe :)", "error");
            }
        });
    }








    LoadEmployeeGridView();

    function LoadEmployeeGridView() {
        $.ajax({
            url: urls,
            method: "POST",
            dataType: 'json',
            data: {
                employee_grid_access: 'employee_grid_access',
            },
            success: function(data) {
                $('#employee_grid_view_display').html(data);
            },
            error: function(xhr, code, error) {

            }
        });
    }


    function ClearForm() {
        $("input").each(function() {
            if ($(this).val().length > 0) {
                $(this).val("");
            }
        });
    }


    function validateForm() {
        // This function deals with validation of the form fields
        var valid = true;
        $(".required").each(function() {
            if ($(this).val().length == 0) {
                $(this).removeClass("border-primary");
                $(this).addClass("border-danger");
                valid = false;
            } else {
                $(this).removeClass("border-danger");
                $(this).addClass("border-success");
            }
        });
        return valid; // return the valid status
    }
});