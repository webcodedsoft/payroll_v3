$(document).ready(function() {


    $(document).on("input", ".number_onlys", function(event) {
        this.value = this.value.replace(/[^\d*\.?]/g, '');

    });

    var baseUrls = $('#static_url').val();
    var urls = baseUrls.concat('Controller/Company/AccountsController.php');
    var count = 1;

    var count_input = 1;


    $(document).on('click', "#add_more_row", function(params) {
        count = count + 1;

        if (count < 6) {
            var html_code_append = '<tr id="row' + count + '">';
            html_code_append += '<td><input class="form-control item_name" id="item_name" type="text" style="min-width:150px"></td>';
            html_code_append += '<td><input class="form-control item_description" id="item_description" type="text" style="min-width:150px"></td>';
            html_code_append += '<td><input class="form-control item_cost number_onlys" id="item_cost' + count + '" style="width:100px" type="text"></td>';
            html_code_append += '<td><input class="form-control quantity number_onlys" data-row="qty" id="' + count + '" style="width:80px" type="text"></td>';
            html_code_append += '<td><input class="form-control item_amount number_onlys" readonly="" id="item_amount' + count + '" style="width:120px" type="text"></td>';
            html_code_append += '<td><a href="javascript:void(0)" class="text-danger remove_row" id="row' + count + '"  title="Remove"><i class="la la-trash-o"></i></a></td>';
            html_code_append += '</tr>';
            $("#additional_row").append(html_code_append);
        } else {
            toastr.warning('You can not add more than 5 fields', 'Warning!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 4000, "progressBar": true });
        }
    });


    $(document).on('click', ".remove_row", function(params) {
        var remove_row = $(this).attr("id");
        count = count - 2;
        $("#" + remove_row).remove();
    });



    $(document).keyup(function __handleChanges(e) {
        var input_id = e.target.id; //input id which is number auto increment
        var input_id_value = parseFloat(e.target.value); //input value real input value and this function is only work with qty input box
        var item_cost_value = parseFloat($("#item_cost" + input_id).val()); //Getting input from cost

        total_amount = item_cost_value * input_id_value; //parseFloat(); //Now performing calculation btw the qty and cost

        $("#item_amount" + input_id).val(total_amount); //Here trying to attach the value get from auto increment box into amount input box



        var item_amount = [];
        var final_total = 0;

        $(".item_amount").each(function() {
            item_amount.push($(this).val());
        });

        item_amount.forEach(function(params) {
            final_total += parseFloat(params) || 0;
        });

        //console.log(final_total);

        //$("#final_total").html(parseFloat(final_total).toFixed(2));

        if ($("#invoice_discount").val().length > 0) {
            var invoice_discount = parseFloat($("#invoice_discount").val());
            var discount_per = invoice_discount * final_total / 100;
            final_total = parseFloat(final_total) - discount_per;

        }


        $("#final_total").html(parseFloat(final_total).toFixed(2));
        $("#invoice_final_total").val(parseFloat(final_total).toFixed(2));

    });




    $(document).on('click', ".save_invoice_btn", function(e) {
        var save_type = $(this).attr("id");
        save_type = save_type == 'save_invoice' ? 'save_invoice' : 'save_invoice_send';

        var item_id = [];
        var item_name = [];
        var item_desc = [];
        var item_cost = [];
        var item_qty = [];
        var item_amount = [];

        //alert($("#item_amount").val());

        if ($("#invoice_client_id").val() == "" || $("#invoice_client_project").val() == "" || $("#invoice_client_email").val() == "" || $("#invoice_client_address").val() == "" ||
            $("#invoice_date").val() == "" || $("#invoice_due_date").val() == "" || $("#item_name").val() == "" || $("#item_description").val() == "" ||
            $("#item_cost").val() == "" || $("#quantity").val() == "" || $("#item_amount").val() == "") {
            toastr.warning('All Fields Are Required', 'Warning!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 4000, "progressBar": true });
            empty = true;
            return empty;

        } else {

            $(".item_id").each(function() {
                item_id.push($(this).val());
            });
            $(".item_name").each(function() {
                item_name.push($(this).val());
            });
            $(".item_description").each(function() {
                item_desc.push($(this).val());
            });
            $(".item_cost").each(function() {
                item_cost.push($(this).val());
            });
            $(".quantity").each(function() {
                item_qty.push($(this).val());
            });
            $(".item_amount").each(function() {
                item_amount.push($(this).val());
            });

            var invoice_id = $("#invoice_id").val();

            var client_id = $("#invoice_client_id").val();
            var client_project = $("#invoice_client_project").val();
            var client_email = $("#invoice_client_email").val();
            var client_address = $("#invoice_client_address").val();
            var invoice_date = $("#invoice_date").val();
            var invoice_due_date = $("#invoice_due_date").val();
            var other_desc = $("#other_desc").val();
            var invoice_discount = $("#invoice_discount").val();
            var final_total = $("#invoice_final_total").val();
            //                data: { client_id: client_id, client_project: client_project, client_email: client_email, client_address: client_address, invoice_date: invoice_date, invoice_due_date: invoice_due_date, item_name: item_name, item_desc: item_desc, item_cost: item_cost, item_qty: item_qty, item_amount: item_amount, save_type: save_type, save_invoice_btn: "save_invoice_btn" },

            $.ajax({
                type: "POST",
                url: urls,
                dataType: 'json',
                data: { invoice_id, client_id, client_project, client_email, client_address, invoice_date, invoice_due_date, other_desc, invoice_discount, final_total, item_id, item_name, item_desc, item_cost, item_qty, item_amount, save_type, save_invoice_btn: "save_invoice_btn" },
                // beforeSend: function() {
                //     $(".save_invoice_btn").html("<i class='la la-spinner spinner'></i> Please Wait...");
                //     $('.save_invoice_btn').addClass('disabled');
                //     $('.save_invoice_btn').prop('disabled', true);
                // },
                success: function(json) {
                    toastr.info(json[0], 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 5000, "progressBar": true });

                    if (json.Invoide_ID.length > 0) {
                        $(".save_invoice_btn").html("<i class='la la-save'></i> Submit Invoice");
                    } else {
                        $(".save_invoice_btn").html("<i class='la la-save'></i> Update Invoice");
                    }
                    $('.save_invoice_btn').removeClass('disabled');
                    $('.save_invoice_btn').prop('disabled', false);
                    if (json.Invoide_ID.length > 0) {
                        window.location = baseUrls + "view-invoice?invoice_id=" + json.Invoide_ID;
                    }
                },

                error: function(e) {

                }
            });

        }
    });




    $('#invoice_client_id').change(function(e) {
        var client_id = $(this).val();

        $.ajax({
            url: urls,
            method: "POST",
            dataType: 'json',
            data: { client_id: client_id, client_project_access: "client_project_access" },
            success: function(json) {

                $('#invoice_client_project').html(json.Output_Result).change();
                $('#invoice_client_email').val(json.Client_Email);
                $('#invoice_client_address').val(json.Client_Address);

            },

        });

    });


    $(document).on('click', ".invoice_email_btn", function(e) {
        var invoice_id = $(this).attr("id");

        $.ajax({
            url: urls,
            method: "POST",
            dataType: 'json',
            data: { invoice_id: invoice_id, invoice_email_btn: "invoice_email_btn" },
            beforeSend: function() {
                $(".invoice_email_btn").html("<i class='la la-spinner spinner'></i> Please Wait...");
                $('.invoice_email_btn').addClass('disabled');
                $('.invoice_email_btn').prop('disabled', true);
            },
            success: function(json) {
                $(".invoice_email_btn").html("<i class='la la-paper-plane-o'></i> Send to Mail");
                $('.invoice_email_btn').removeClass('disabled');
                $('.invoice_email_btn').prop('disabled', false);
            },

        });

    });



    $(document).on('click', ".invoice_pdf_btn", function(e) {
        var invoice_id = $(this).attr("id");

        $.ajax({
            url: urls,
            method: "POST",
            dataType: 'json',
            data: { invoice_id: invoice_id, invoice_pdf_btn: "invoice_pdf_btn" },
            beforeSend: function() {
                $(".invoice_pdf_btn").html("<i class='la la-spinner spinner'></i> Please Wait...");
                $('.invoice_pdf_btn').addClass('disabled');
                $('.invoice_pdf_btn').prop('disabled', true);
            },
            success: function(json) {
                $(".invoice_pdf_btn").html("<i class='la la-download'></i> Download PDF");
                $('.invoice_pdf_btn').removeClass('disabled');
                $('.invoice_pdf_btn').prop('disabled', false);
            },

        });

    });



    $("input#invoice_client_email").on({
        keydown: function(e) {
            if (e.which === 32)
                return false;
        },
        change: function() {
            this.value = this.value.replace(/\s/g, "");
        }
    });




    $(document).on('click', '#print', function(e) {

        var mode = 'iframe'; //popup
        var close = mode == "popup";
        var options = {
            mode: mode,
            popClose: close
        };
        $("div.printableArea").printArea(options);


    });





    load_invoice_data_list();

    function load_invoice_data_list(e) {
        //var baseUrls = $(location).attr('href');


        $('#invoice_list').DataTable({
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
                    invoice_list_access: 'invoice_list_access',
                },
                error: function(xhr, code, error) {
                    console.log(xhr);
                    console.log(code);
                    console.log(error);
                }
            }
        });


    }


    $(document).on('click', '.remove_data_row', function(e) {
        var invoice_id = $(this).attr("id");
        DeletePopOverAlert(invoice_id, "remove_data_row");
    });


    $(document).on('click', '.delete_invoice', function(e) {
        var invoice_id = $(this).attr("id");
        DeletePopOverAlert(invoice_id, "delete_invoice");
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
                        $("#invoice_actions").html("<i class='la la-spinner spinner'></i>");
                        $('#invoice_actions').addClass('disabled');
                        $('#invoice_actions').prop('disabled', true);
                    },
                    success: function(json) {
                        if (json == 'Delete_Row') {
                            //count = count - 2;
                            $("#" + delete_value).remove();
                            swal("Deleted!", "Your data has been deleted.", "success");

                        }
                        if (json == 'Deleted')
                            swal("Deleted!", "Your data has been deleted.", "success");
                        load_invoice_data_list();
                    },

                });

            } else {
                swal("Cancelled", "Your data is safe :)", "error");
            }
        });
    }


});