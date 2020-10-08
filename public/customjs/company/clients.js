$(document).ready(function() {

    var baseUrls = $('#static_url').val();
    var urls = baseUrls.concat('Controller/Company/ClientsController.php');


    $(document).on('click', '#client_button', function(e) {

        var empty = false;
        if ($("#company_name").val() == "" || $("#contact_person").val() == "" || $("#address").val() == "" || $("#email_address").val() == "" || $("#client_phone_number").val() == "" || $("#client_status").val() == "") {
            toastr.warning('All Fields Are Required', 'Warning!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 4000, "progressBar": true });
            empty = true;
            return empty;

        } else {

            if ($('#client_status').is(":checked")) {
                leave_type_status = 'Active';
            } else {
                leave_type_status = 'Disabled';
            }

            var formData = new FormData();
            formData.append('client_id', $('#client_id').val());
            formData.append('company_name', $('#company_name').val());
            formData.append('contact_person', $('#contact_person').val());
            formData.append('address', $('#address').val());
            formData.append('email_address', $('#email_address').val());
            formData.append('client_phone_number', $('#client_phone_number').val());
            formData.append('client_status', leave_type_status);
            formData.append('client_button', $('#client_button').val());

            $.ajax({
                type: "POST",
                url: urls,
                dataType: 'json',
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $("#client_button").html("<i class='la la-spinner spinner'></i> Please Wait...");
                    $('#client_button').addClass('disabled');
                    $('#client_button').prop('disabled', true);
                },
                success: function(json) {
                    load_clients_data_list();
                    toastr.info(json[0], 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 5000, "progressBar": true });
                    $("#client_button").html("<i class='ft-save'></i> Submit");
                    $('#client_button').removeClass('disabled');
                    $('#client_button').prop('disabled', false);
                    $('#create_client').modal('hide');
                    $("#client_status").prop('checked', false);

                    $('#client_id').val("");
                    $('#company_name').val("");
                    $('#contact_person').val("");
                    $('#address').val("");
                    $('#email_address').val("");
                    $('#client_phone_number').val("");
                    $('#client_status').val("").change();
                },

                error: function(e) {

                }
            });
        }


    });



    load_clients_data_list();

    function load_clients_data_list(e) {
        //var baseUrls = $(location).attr('href');


        $('#clients_list').DataTable({
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
                    clients_list_access: 'clients_list_access',
                },
                error: function(xhr, code, error) {
                    console.log(xhr);
                    console.log(code);
                    console.log(error);
                }
            }
        });


    }



    $(document).on('click', '.delete_client', function(e) {
        var client_id = $(this).attr("id");
        DeletePopOverAlert(client_id, "delete_client");
    });


    $(document).on('click', '.edit_client', function(e) {

        var client_id = $(this).attr("id");

        $.ajax({
            type: "POST",
            url: urls,
            dataType: 'json',
            data: {
                client_id: client_id,
                edit_client: "edit_client",
            },
            success: function(json) {

                $('#company_name').val(json[0].Company_Name);
                $('#contact_person').val(json[0].Contact_Person);
                $('#address').val(json[0].Address);
                $('#email_address').val(json[0].Email);
                $('#client_phone_number').val(json[0].Phone_Number);
                $('#client_id').val(json[0].ID);

                if (json[0].Status == 'Active') {
                    $("#client_status").prop('checked', true);
                } else {
                    $("#client_status").prop('checked', false);
                }

                $("#client_button").html("<i class='la la-save'></i> Update");
                $("#create_client").modal('show');
            },
        });

    });



    $(document).on('click', '#client_popup_close', function(e) {
        $('#client_id').val("");
        $('#company_name').val("");
        $('#contact_person').val("");
        $('#address').val("");
        $('#email_address').val("");
        $('#client_phone_number').val("");
        $("#client_status").prop('checked', false);
        $("#client_button").html("<i class='la la-save'></i> Create");

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
                        if (json == 'Deleted')
                            swal("Deleted!", "Your data has been deleted.", "success");
                        load_clients_data_list();
                    },

                });

            } else {
                swal("Cancelled", "Your data is safe :)", "error");
            }
        });
    }
});