$(document).ready(function() {

    $(document).on("input", ".number_only", function(event) {
        this.value = this.value.replace(/[^\d]/g, '');

    });
    var baseUrls = $('#static_url').val();
    var urls = baseUrls.concat('Controller/Company/DefaultController.php');

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




    //Create Company
    $(document).on('click', '#company_setup_btn', function(e) {
        var empty = false;
        if ($("#company_name").val() == "" || $("#company_email").val() == "" || $("#company_id").val() == "" || $("#company_phone_number").val() == "" ||
            $("#company_website").val() == "" || $("#company_header_report").val() == "" || $("#authorize_signature_name").val() == "" || $("#company_username").val() == "" ||
            $("#authorize_signature_position").val() == "" || $("#company_password").val() == "" || $("#company_address").val() == "") {

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
            formData.append('company_username', $('#company_username').val());
            formData.append('authorize_signature_position', $('#authorize_signature_position').val());
            formData.append('company_password', $('#company_password').val());
            formData.append('company_address', $('#company_address').val());
            formData.append('company_setup_btn', $('#company_setup_btn').val());

            $.ajax({
                type: "POST",
                url: urls,
                dataType: 'json',
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $("#company_setup_btn").html("<i class='la la-spinner spinner'></i> Please Wait...");
                    $('#company_setup_btn').addClass('disabled');
                    $('#company_setup_btn').prop('disabled', true);
                },
                success: function(json) {
                    toastr.info(json[0], 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 5000, "progressBar": true });
                    $("#company_setup_btn").html("<i class='ft-save'></i> Submit");
                    $('#company_setup_btn').removeClass('disabled');
                    $('#company_setup_btn').prop('disabled', false);

                    window.location = baseUrls + "roles-permissions";
                },

                error: function(e) {

                }
            });
        }

    });

});