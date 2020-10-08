$(document).ready(function() {

    var baseUrls = $('#static_url').val();
    var urls = baseUrls.concat('Controller/Company/TerminationController.php');


    $(document).on('click', '#employee_completion_btn', function(e) {

        var empty = false;
        if ($("#completion_employee_id").val() == "" || $("#employee_ending_date").val() == "" || $("#employee_firing_type").val() == "") {
            toastr.warning('All Fields Are Required', 'Warning!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 4000, "progressBar": true });
        } else {

            var completion_employee_id = $("#completion_employee_id").val();
            var employee_ending_date = $("#employee_ending_date").val();
            var employee_firing_type = $("#employee_firing_type").val();

            $.ajax({
                type: "POST",
                url: urls,
                dataType: 'html',
                data: { completion_employee_id, employee_ending_date, employee_firing_type, employee_completion_btn: "employee_completion_btn" },
                beforeSend: function() {
                    $("#employee_completion_btn").html("<i class='la la-spinner spinner'></i> Please Wait...");
                    $('#employee_completion_btn').addClass('disabled');
                    $('#employee_completion_btn').prop('disabled', true);
                },
                success: function(json) {
                    $("#employee_completion_btn").html("<i class='ft-save'></i> Submit");
                    $('#employee_completion_btn').removeClass('disabled');
                    $('#employee_completion_btn').prop('disabled', false);
                    $("#employee_completion").html(json);
                },
                error: function(e) {

                }
            });
        }


    });


});