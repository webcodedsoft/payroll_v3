$(document).ready(function() {

    var baseUrls = $('#static_url').val();
    var urls = baseUrls.concat('Controller/Company/AssetsController.php');


    $(document).on('click', '#assets_button', function(e) {

        var empty = false;
        if ($("#asset_name").val() == "" || $("#purchase_date").val() == "" || $("#purchase_from").val() == "" || $("#manufacturer").val() == "" ||
            $("#model").val() == "" || $("#serial_number").val() == "" || $("#supplier").val() == "" || $("#condition").val() == "" || $("#warranty").val() == "" ||
            $("#amount").val() == "" || $("#description").val() == "" || $("#status").val() == "") {
            toastr.warning('All Fields Are Required', 'Warning!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 4000, "progressBar": true });
            empty = true;
            return empty;

        } else {

            var formData = new FormData();
            formData.append('asset_id', $('#asset_id').val());
            formData.append('asset_name', $('#asset_name').val());
            formData.append('purchase_date', $('#purchase_date').val());
            formData.append('purchase_from', $('#purchase_from').val());
            formData.append('manufacturer', $('#manufacturer').val());
            formData.append('model', $('#model').val());
            formData.append('serial_number', $('#serial_number').val());
            formData.append('supplier', $('#supplier').val());
            formData.append('condition', $('#condition').val());
            formData.append('warranty', $('#warranty').val());
            formData.append('amount', $('#amount').val());
            formData.append('description', $('#description').val());
            formData.append('status', $('#status').val());
            formData.append('assets_button', $('#assets_button').val());

            $.ajax({
                type: "POST",
                url: urls,
                dataType: 'json',
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $("#assets_button").html("<i class='la la-spinner spinner'></i> Please Wait...");
                    $('#assets_button').addClass('disabled');
                    $('#assets_button').prop('disabled', true);
                },
                success: function(json) {
                    load_assets_data_list();
                    toastr.info(json[0], 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 5000, "progressBar": true });
                    $("#assets_button").html("<i class='ft-save'></i> Submit");
                    $('#assets_button').removeClass('disabled');
                    $('#assets_button').prop('disabled', false);
                    $('#create_assets').modal('hide');

                    $('#asset_name').val("");
                    $('#purchase_date').val("");
                    $('#purchase_from').val("");
                    $('#manufacturer').val("");
                    $('#model').val("");
                    $('#serial_number').val("");
                    $('#supplier').val("");
                    $('#condition').val("");
                    $('#warranty').val("");
                    $('#amount').val("");
                    $('#description').val("");
                    $('#status').val("").change();
                },

                error: function(e) {

                }
            });
        }


    });



    load_assets_data_list();

    function load_assets_data_list(e) {

        $('#assets_list').DataTable({
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
                    assets_list_access: 'assets_list_access',
                },
                error: function(xhr, code, error) {
                    console.log(xhr);
                    console.log(code);
                    console.log(error);
                }
            }
        });


    }



    $(document).on('click', '.delete_asset', function(e) {
        var asset_id = $(this).attr("id");
        DeletePopOverAlert(asset_id, "delete_asset");
    });


    $(document).on('click', '.edit_asset', function(e) {

        var asset_id = $(this).attr("id");

        $.ajax({
            type: "POST",
            url: urls,
            dataType: 'json',
            data: {
                asset_id: asset_id,
                edit_asset: "edit_asset",
            },
            success: function(json) {

                $('#asset_name').val(json[0].Asset_Name);
                $('#purchase_date').val(json[0].Purchase_Date);
                $('#purchase_from').val(json[0].Purchase_From);
                $('#manufacturer').val(json[0].Manufacturer);
                $('#model').val(json[0].Model);
                $('#serial_number').val(json[0].Serial_Number);
                $('#supplier').val(json[0].Supplier);
                $('#condition').val(json[0].Conditions);
                $('#warranty').val(json[0].Warranty);
                $('#amount').val(json[0].Amount);
                $('#description').val(json[0].Description);
                $('#status').val(json[0].Status).change();
                $('#asset_id').val(json[0].ID);

                $("#assets_button").html("<i class='la la-save'></i> Update");
                $("#create_assets").modal('show');
            },
        });

    });



    $(document).on('click', '#assets_popup_close', function(e) {
        $('#asset_name').val("");
        $('#purchase_date').val("");
        $('#purchase_from').val("");
        $('#manufacturer').val("");
        $('#model').val("");
        $('#serial_number').val("");
        $('#supplier').val("");
        $('#condition').val("");
        $('#warranty').val("");
        $('#amount').val("");
        $('#description').val("");
        $('#status').val("").change();

        $("#assets_button").html("<i class='la la-save'></i> Create");

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
                        if (json == 'Deleted')
                            swal("Deleted!", "Your data has been deleted.", "success");
                        load_assets_data_list();
                    },

                });

            } else {
                swal("Cancelled", "Your data is safe :)", "error");
            }
        });
    }
});