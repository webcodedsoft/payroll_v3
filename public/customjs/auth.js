$(document).ready(function() {
    var baseUrls = $(location).attr('href');
    var urls = baseUrls.concat('Controller/Auth/authController.php');

    $("#login_password_div").hide();


    //Authenticate Email
    $(document).on('click', '#login_btn', function(e) {
        e.preventDefault();
        var login_email = $('#email_address').val();
        var login_password = $('#password').val();

        if ($("#login_btn").html() === '<i class="ft-unlock"></i> Continue') {



            if ($('#email_address').val() == "" || $('#email_address').val() === null) {
                toastr.info("Please enter your login email", 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 5000, "progressBar": true });
            } else {

                $.ajax({
                    type: 'POST',
                    url: urls,
                    dataType: 'json',
                    data: { login_email: login_email, login_btn: "login_btn" },

                    beforeSend: function() {
                        $("#login_btn").html("<i class='la la-spinner spinner'></i> Please Wait...");
                        $('#login_btn').addClass('disabled');
                        $('#login_btn').prop('disabled', true);
                    },
                    success: function(json) {

                        $("#login_password_div").show();
                        $("#login_btn").html("<i class='ft-unlock'></i> Submit");
                        $('#login_btn').removeClass('disabled');
                        $('#login_btn').prop('disabled', false);
                        $('#password').val("");

                        if (json[0] === 'Complete') {
                            $("#login_password_div").show();
                            $("#login_btn").html("<i class='ft-unlock'></i> Submit");
                            $('#login_btn').removeClass('disabled');
                            $('#login_btn').prop('disabled', false);

                        } else if (json[0] === 'Exist') {
                            window.location = baseUrls + "setup";
                        }
                        // else {
                        //     toastr.info("Email Address is not in our database", 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 5000, "progressBar": true });
                        //     $("#login_password_div").hide();
                        //     $("#login_btn").html("<i class='ft-unlock'></i> Continue");
                        //     $('#login_btn').removeClass('disabled');
                        //     $('#login_btn').prop('disabled', false);
                        // }

                    },
                    error: function(e) {
                        //console.log('Error' + e);
                    }
                });
            }

        } else {


            if ($('#email_address').val() == "" || $('#email_address').val() === null || $('#password').val() == "" || $('#password').val() === null) {
                toastr.info("Please enter your login email and password", 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 5000, "progressBar": true });
            } else {


                $.ajax({
                    type: 'POST',
                    url: urls,
                    dataType: 'json',
                    data: { login_email: login_email, login_password: login_password, login_btn: "login_btn" },

                    beforeSend: function() {
                        $("#login_btn").html("<i class='la la-spinner spinner'></i> Please Wait...");
                        $('#login_btn').addClass('disabled');
                        $('#login_btn').prop('disabled', true);
                    },
                    success: function(json) {

                        if (json[0] === 'Logged') {
                            $('#email_address').val("");
                            window.location = baseUrls + "dashboard";

                        } else {
                            toastr.info(json[0], 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 5000, "progressBar": true });
                            $("#login_password_div").hide();
                            $("#login_btn").html("<i class='ft-unlock'></i> Continue");
                            $('#login_btn').removeClass('disabled');
                            $('#login_btn').prop('disabled', false);
                        }

                    },
                    error: function(e) {
                        //console.log('Error' + e);
                    }
                });
            }

        }




    });



});