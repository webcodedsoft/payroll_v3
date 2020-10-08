$(document).ready(function() {


    var baseUrls = $('#static_url').val();
    var urls = baseUrls.concat('Controller/Company/ProjectsController.php');

    $(".tabs-default").tabs();


    $("#project_file").change(function(e) {


        var file = this.files[0];

        var imagefile = file.type;
        var match = ["image/jpeg", "image/png", "image/jpg", "image/gif"];

        if (file.size > 1448680) {
            toastr.info("File size must not greater than 1.3 MB", 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000, "progressBar": true });
            $("#project_file").val("");
            return false;
        }

    });




    $(document).on('click', '#project_button', function(e) {
        var empty = false;
        if ($("#project_name").val() == "" || $("#project_client").val() == "" || $("#project_start_date").val() == "" || $("#project_end_date").val() == "" ||
            $("#project_rate").val() == "" || $("#project_rate_type").val() == "" || $("#project_priority").val() == "" || $("#project_leader").val() == "" ||
            $("#project_description").val() == "") {

            toastr.warning('All Fields Are Required', 'Warning!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 4000, "progressBar": true });
            empty = true;
            return empty;

        } else {

            var formData = new FormData();

            $.each($('#project_file')[0].files, function(i, file) {
                formData.append('project_file[]', file);
            });

            formData.append('project_name', $('#project_name').val());
            formData.append('project_client', $('#project_client').val());
            formData.append('project_start_date', $('#project_start_date').val());
            formData.append('project_end_date', $('#project_end_date').val());
            formData.append('project_rate', $('#project_rate').val());
            formData.append('project_rate_type', $('#project_rate_type').val());
            formData.append('project_priority', $('#project_priority').val());
            formData.append('project_leader', $('#project_leader').val());
            formData.append('project_status', $('#project_status').val());
            formData.append('project_description', $('#project_description').val());

            formData.append('project_id', $('#project_id').val());

            formData.append('project_button', $('#project_button').val());

            $.ajax({
                type: "POST",
                url: urls,
                dataType: 'json',
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $("#project_button").html("<i class='la la-spinner spinner'></i> Please Wait...");
                    $('#project_button').addClass('disabled');
                    $('#project_button').prop('disabled', true);
                },
                success: function(json) {
                    toastr.info(json[0], 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 5000, "progressBar": true });
                    $("#project_button").html("<i class='ft-save'></i> Submit");
                    $('#project_button').removeClass('disabled');
                    $('#project_button').prop('disabled', false);

                    $('#project_name').val("");
                    $('#project_client').val("").change();
                    $('#project_start_date').val("");
                    $('#project_end_date').val("");
                    $('#project_rate').val("");
                    $('#project_rate_type').val("").change();
                    $('#project_priority').val("").change();
                    $('#project_leader').val("").change();
                    $('#project_status').val("").change();
                    $('#project_description').val("");
                    $("#create_project").modal('hide');

                    $('#project_id').val("");
                    load_projects_data_grid();
                    load_projects_data_list();
                },

                error: function(e) {

                }
            });
        }

    });




    load_projects_data_list();

    function load_projects_data_list(e) {

        $('#projects_list').DataTable({
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
                    projects_list_access: 'projects_list_access',
                },

                error: function(xhr, code, error) {
                    console.log(xhr);
                    console.log(code);
                    console.log(error);
                }
            }
        });


    }


    load_projects_data_grid();

    function load_projects_data_grid(e) {

        $.ajax({
            url: urls,
            method: "POST",
            dataType: 'json',
            data: {
                projects_grid_access: 'projects_grid_access',
            },
            success: function(data) {
                $('#projects_grid_display').html(data);
            },
            error: function(xhr, code, error) {

            }
        });
    }


    $(document).on('click', '.delete_project', function(e) {
        var project_id = $(this).attr("id");
        DeletePopOverAlert(project_id, "delete_project");
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
                        $("#project_actions").html("<i class='la la-spinner spinner'></i>");
                        $('#project_actions').addClass('disabled');
                        $('#project_actions').prop('disabled', true);
                    },
                    success: function(json) {
                        if (json == 'Deleted')
                            swal("Deleted!", "Your data has been deleted.", "success");
                        load_projects_data_grid();
                        load_projects_data_list();
                    },

                });

            } else {
                swal("Cancelled", "Your data is safe :)", "error");
            }
        });
    }



    $(document).on('click', '.edit_project', function(e) {

        var project_id = $(this).attr("id");

        $.ajax({
            type: "POST",
            url: urls,
            dataType: 'json',
            data: {
                project_id: project_id,
                edit_project: "edit_project",
            },
            success: function(json) {

                $('#project_name').val(json[0].Project_Name);
                $('#project_client').val(json[0].Client_ID).change();
                $('#project_start_date').val(json[0].Start_Date);
                $('#project_end_date').val(json[0].End_Date);
                $('#project_rate').val(json[0].Rate);
                $('#project_rate_type').val(json[0].Rate_Type).change();
                $('#project_priority').val(json[0].Priority).change();
                $('#project_leader').val(json[0].Leader).change();
                $('#project_status').val(json[0].Status).change();
                $('#project_description').text(json[0].Description);

                $('#project_id').val(json[0].Project_ID);

                $("#project_button").html("<i class='la la-save'></i> Update");
                $("#create_project").modal('show');
            },
        });

    });


});