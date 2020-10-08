$(document).ready(function() {

    var baseUrls = $('#static_url').val();
    var urls = baseUrls.concat('Controller/Company/ReportsController.php');


    $('#employee_id_payment_proof').change(function(e) {
        var employee_id_payment_proof = $(this).val();
        $.ajax({
            url: urls,
            method: "POST",
            dataType: 'html',
            data: { employee_id_payment_proof, load_date_range_base_on_employee_id_proof: "employee_id_proof" },
            success: function(earning_date_range_payment_proof_report) {
                $('#earning_date_range_payment_proof').html(earning_date_range_payment_proof_report);
            },
            error: function(e) {},
        });
    });


    /*Employee Payment Proof*/
    $(document).on('click', '#payment_proof_btn', function(e) {

        var employee_id_payment_proof = $("#employee_id_payment_proof").val();
        var earning_date_range_payment_proof = $("#earning_date_range_payment_proof").val();

        if ($("#employee_id_payment_proof").val() == null || $("#earning_date_range_payment_proof").val() == null) {
            toastr.error("Please Select All Filter", 'Error!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000, "progressBar": true });
        } else {
            $.ajax({
                type: "POST",
                url: urls,
                dataType: 'json',
                data: { employee_id_payment_proof, earning_date_range_payment_proof, "payment_proof_btn": "payment_proof_btn" },
                success: function(json) {
                    $("#employee_payment_proof").html(json[0]);
                },
                error: function(e) {}
            });

        }
    });


    $(document).on('click', ".payment_proof_email_btn", function(e) {
        var earning_id = $(this).attr("id");

        $.ajax({
            url: urls,
            method: "POST",
            dataType: 'json',
            data: { earning_id: earning_id, payment_proof_email_btn: "payment_proof_email_btn" },
            beforeSend: function() {
                $(".payment_proof_email_btn").html("<i class='la la-spinner spinner'></i> Please Wait...");
                $('.payment_proof_email_btn').addClass('disabled');
                $('.payment_proof_email_btn').prop('disabled', true);
            },
            success: function(json) {
                toastr.success(json, 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 5000, "progressBar": true });
                $(".payment_proof_email_btn").html("<i class='la la-paper-plane-o'></i> Send to Mail");
                $('.payment_proof_email_btn').removeClass('disabled');
                $('.payment_proof_email_btn').prop('disabled', false);
            },

        });

    });


    $(document).on('click', ".payment_proof_pdf_btn", function(e) {
        var earning_id = $(this).attr("id");

        $.ajax({
            url: urls,
            method: "POST",
            dataType: 'json',
            data: { earning_id: earning_id, payment_proof_pdf_btn: "payment_proof_pdf_btn" },
            beforeSend: function() {
                $(".payment_proof_pdf_btn").html("<i class='la la-spinner spinner'></i> Please Wait...");
                $('.payment_proof_pdf_btn').addClass('disabled');
                $('.payment_proof_pdf_btn').prop('disabled', true);
            },
            success: function(json) {
                $(".payment_proof_pdf_btn").html("<i class='la la-download'></i> Download PDF");
                $('.payment_proof_pdf_btn').removeClass('disabled');
                $('.payment_proof_pdf_btn').prop('disabled', false);
            },

        });

    });


    $(document).on('click', '#payroll_worksheet_search_btn', function(e) {

        var worksheet_payment_type = $(".worksheet_payment_type").val();
        var worksheet_payment_date = $(".worksheet_payment_date").val();
        var worksheet_payment_department = $("#worksheet_by_department").val();

        if (worksheet_payment_type !== null || worksheet_payment_date !== null || worksheet_payment_department !== null) {
            load_payroll_worksheet_list(worksheet_payment_type, worksheet_payment_date, worksheet_payment_department);
        } else {
            toastr.error("Please select any of the filter", 'Error!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000, "progressBar": true });
        }

    });


    load_payroll_worksheet_list();


    function load_payroll_worksheet_list(worksheet_payment_type = '', worksheet_payment_date = '', worksheet_payment_department = '') {

        $('#load_payroll_worksheet_list_table').DataTable({
            dom: 'Bftiplr',
            "processing": true,
            oLanguage: { sProcessing: '<div class="ball-pulse-sync loader-purple"><div></div><div></div><div></div><div></div></div>' },
            "serverSide": true,
            "searching": true,
            "bDestroy": true,
            "scrollCollapse": true,
            aoColumnDefs: [{ orderable: false, targets: "no-sort" }],
            "scrollX": "100%",
            "scrollY": "100%",

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
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    download: 'open'
                        // extend: 'pdfHtml5',
                        // download: 'open'
                }
            ],
            "ajax": {
                url: urls,
                method: "POST",
                dataType: 'json',
                data: { worksheet_payment_type, worksheet_payment_date, worksheet_payment_department, employee_worksheet_list_access: 'employee_worksheet_list_access' },
                error: function(xhr, code, error) {
                    console.log(xhr);
                    console.log(code);
                    console.log(error);
                }
            },
            "footerCallback": function(row, data, start, end, display) {
                var api = this.api(),
                    data;


                // Remove the formatting to get integer data for summation
                var intVal = function(i) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                        i : 0;
                };

                // Total over all pages
                total_basic = api.column(3).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                total_bonus = api.column(7).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                total_comission = api.column(8).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                total_allowance = api.column(9).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                total_other_earning = api.column(10).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                total_gross = api.column(11).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                total_sos = api.column(12).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                total_asos = api.column(13).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                total_tax = api.column(14).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                total_loan = api.column(15).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                total_ass = api.column(16).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                total_other_deduct = api.column(17).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                total_deduct = api.column(18).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                total_netpay = api.column(19).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);

                var numFormat = $.fn.dataTable.render.number('\,', '.', 2).display;
                // Update footer
                $(api.column(3).footer()).html(' (' + numFormat(total_basic) + ' )');
                $(api.column(7).footer()).html(' (' + numFormat(total_bonus) + ' )');
                $(api.column(8).footer()).html(' (' + numFormat(total_comission) + ' )');
                $(api.column(9).footer()).html(' (' + numFormat(total_allowance) + ' )');
                $(api.column(10).footer()).html(' (' + numFormat(total_other_earning) + ' )');
                $(api.column(11).footer()).html(' (' + numFormat(total_gross) + ' )');
                $(api.column(12).footer()).html(' (' + numFormat(total_sos) + ' )');
                $(api.column(13).footer()).html(' (' + numFormat(total_asos) + ' )');
                $(api.column(14).footer()).html(' (' + numFormat(total_tax) + ' )');
                $(api.column(15).footer()).html(' (' + numFormat(total_loan) + ' )');
                $(api.column(16).footer()).html(' (' + numFormat(total_ass) + ' )');
                $(api.column(17).footer()).html(' (' + numFormat(total_other_deduct) + ' )');
                $(api.column(18).footer()).html(' (' + numFormat(total_deduct) + ' )');
                $(api.column(19).footer()).html(' (' + numFormat(total_netpay) + ' )');

            }
        });


    }




    $(document).on('click', '#payroll_summary_worksheet_search_btn', function(e) {

        var summary_worksheet_employee_id = $("#summary_worksheet_employee_id").val();
        var worksheet_summary_payment_date = $("#worksheet_summary_payment_date").val();

        if (summary_worksheet_employee_id !== null || worksheet_summary_payment_date !== null) {
            load_payroll_summary_worksheet_list(summary_worksheet_employee_id, worksheet_summary_payment_date);
        } else {
            toastr.error("Please select any of the filter", 'Error!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000, "progressBar": true });
        }

    });

    load_payroll_summary_worksheet_list();

    function load_payroll_summary_worksheet_list(summary_worksheet_employee_id = '', worksheet_summary_payment_date = '') {

        $('#load_payroll_summary_worksheet_list_table').DataTable({
            dom: 'Bftiplr',
            "processing": true,
            oLanguage: { sProcessing: '<div class="ball-pulse-sync loader-purple"><div></div><div></div><div></div><div></div></div>' },
            "serverSide": true,
            "searching": true,
            "bDestroy": true,
            "scrollCollapse": true,
            aoColumnDefs: [{ orderable: false, targets: "no-sort" }],
            "scrollX": "100%",
            "scrollY": "100%",

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
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    download: 'open'
                }
            ],
            "ajax": {
                url: urls,
                method: "POST",
                dataType: 'json',
                data: { summary_worksheet_employee_id, worksheet_summary_payment_date, employee_summary_worksheet_list_access: 'employee_summary_worksheet_list_access' },
                error: function(xhr, code, error) {
                    console.log(xhr);
                    console.log(code);
                    console.log(error);
                }
            },
            "footerCallback": function(row, data, start, end, display) {
                var api = this.api(),
                    data;


                // Remove the formatting to get integer data for summation
                var intVal = function(i) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                        i : 0;
                };

                // Total over all pages
                total_basic = api.column(3).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                total_bonus = api.column(7).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                total_comission = api.column(8).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                total_allowance = api.column(9).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                total_other_earning = api.column(10).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                total_gross = api.column(11).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                total_sos = api.column(12).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                total_asos = api.column(13).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                total_tax = api.column(14).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                total_loan = api.column(15).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                total_ass = api.column(16).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                total_other_deduct = api.column(17).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                total_deduct = api.column(18).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                total_netpay = api.column(19).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);

                var numFormat = $.fn.dataTable.render.number('\,', '.', 2).display;
                // Update footer
                $(api.column(3).footer()).html(' (' + numFormat(total_basic) + ' )');
                $(api.column(7).footer()).html(' (' + numFormat(total_bonus) + ' )');
                $(api.column(8).footer()).html(' (' + numFormat(total_comission) + ' )');
                $(api.column(9).footer()).html(' (' + numFormat(total_allowance) + ' )');
                $(api.column(10).footer()).html(' (' + numFormat(total_other_earning) + ' )');
                $(api.column(11).footer()).html(' (' + numFormat(total_gross) + ' )');
                $(api.column(12).footer()).html(' (' + numFormat(total_sos) + ' )');
                $(api.column(13).footer()).html(' (' + numFormat(total_asos) + ' )');
                $(api.column(14).footer()).html(' (' + numFormat(total_tax) + ' )');
                $(api.column(15).footer()).html(' (' + numFormat(total_loan) + ' )');
                $(api.column(16).footer()).html(' (' + numFormat(total_ass) + ' )');
                $(api.column(17).footer()).html(' (' + numFormat(total_other_deduct) + ' )');
                $(api.column(18).footer()).html(' (' + numFormat(total_deduct) + ' )');
                $(api.column(19).footer()).html(' (' + numFormat(total_netpay) + ' )');

            }
        });

    }



    $('#monthly_salary_report_date').change(function(e) {
        var monthly_salary_report_date = $(this).val();

        if (monthly_salary_report_date !== null) {
            load_payroll_monthly_salary_report_list(monthly_salary_report_date);
        } else {
            toastr.error("Please select date filter", 'Error!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000, "progressBar": true });
        }
    });


    load_payroll_monthly_salary_report_list();

    function load_payroll_monthly_salary_report_list(monthly_salary_report_date) {

        $('#load_payroll_monthly_salary_report').DataTable({
            dom: 'Bftiplr',
            "processing": true,
            oLanguage: { sProcessing: '<div class="ball-pulse-sync loader-purple"><div></div><div></div><div></div><div></div></div>' },
            "serverSide": true,
            "searching": true,
            "bDestroy": true,
            "scrollCollapse": true,

            aoColumnDefs: [{ orderable: false, targets: "no-sort" }],
            "scrollX": "100%",
            "scrollY": "100%",

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
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    download: 'open'
                        // extend: 'pdfHtml5',
                        // download: 'open'
                }
            ],
            "ajax": {
                url: urls,
                method: "POST",
                dataType: 'json',
                data: { monthly_salary_report_date, employee_monthly_salary_report_list_access: 'employee_monthly_salary_report_list_access' },
                error: function(xhr, code, error) {
                    console.log(xhr);
                    console.log(code);
                    console.log(error);
                }
            },
            "footerCallback": function(row, data, start, end, display) {
                var api = this.api(),
                    data;


                // Remove the formatting to get integer data for summation
                var intVal = function(i) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                        i : 0;
                };

                // Total over all pages
                total_basic = api.column(5).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                // Total over this page
                //pageTotal = api.column(4, {page: 'current'}).data().reduce(function(a, b) {return intVal(a) + intVal(b);}, 0);

                var numFormat = $.fn.dataTable.render.number('\,', '.', 2).display;
                // Update footer
                $(api.column(5).footer()).html(' (' + numFormat(total_basic) + ' )');


                //alert(pageTotal);
            }
        });

    }




    $(document).on('click', '#payroll_worksheet_search_btn', function(e) {

        var payment_date_from = $("#payment_date_from").val();
        var payment_date_to = $("#payment_date_to").val();

        if (payment_date_from !== '' || payment_date_to !== '') {
            load_payroll_row_report_list(payment_date_from, payment_date_to);
        } else {
            toastr.error("Please select date range filter", 'Error!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000, "progressBar": true });
        }

    });


    load_payroll_row_report_list();

    function load_payroll_row_report_list(payment_date_from, payment_date_to) {

        $('#load_payroll_row_list_table').DataTable({
            dom: 'Bftiplr',
            "processing": true,
            oLanguage: { sProcessing: '<div class="ball-pulse-sync loader-purple"><div></div><div></div><div></div><div></div></div>' },
            "serverSide": true,
            "searching": true,
            "bDestroy": true,
            "scrollCollapse": true,

            aoColumnDefs: [{ orderable: false, targets: "no-sort" }],
            "scrollX": "100%",
            "scrollY": "100%",

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
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    download: 'open'
                },
                {
                    extend: 'colvis',
                    text: 'Hide Rows',
                    collectionLayout: 'fixed two-column',
                },
            ],
            "ajax": {
                url: urls,
                method: "POST",
                dataType: 'json',
                data: { payment_date_from, payment_date_to, employee_payroll_row_report_list_access: 'employee_payroll_row_report_list_access' },
                error: function(xhr, code, error) {
                    console.log(xhr);
                    console.log(code);
                    console.log(error);
                }
            },
        });

    }


    $('#employee_id_aguinaldo').change(function(e) {
        var employee_id_aguinaldo = $(this).val();
        $.ajax({
            url: urls,
            method: "POST",
            dataType: 'html',
            data: { employee_id_aguinaldo, load_employee_id_aguinaldo: "employee_id_aguinaldo" },
            success: function(employee_aguinaldo_report) {
                $('#employee_aguinaldo_report').html(employee_aguinaldo_report);
                //console.log(employee_aguinaldo_report);
            },
            error: function(e) {},
        });
    });




    $('#employee_id_earning_history').change(function(e) {
        var employee_id_earning_history = $(this).val();
        $.ajax({
            url: urls,
            method: "POST",
            dataType: 'html',
            data: { employee_id_earning_history, load_date_range_base_on_employee_id_history: "employee_id_history" },
            success: function(earning_date_range_payment_history_report) {
                $('#earning_date_range_payment_history').html(earning_date_range_payment_history_report);
            },
            error: function(e) {},
        });
    });


    $(document).on('click', '#employee_payroll_history_btn', function(e) {

        var employee_id_earning_history = $("#employee_id_earning_history").val();
        var earning_date_range_payment_history = $("#earning_date_range_payment_history").val();

        if (employee_id_earning_history !== '' || earning_date_range_payment_history !== '') {
            load_employee_payroll_history_report_list(employee_id_earning_history, earning_date_range_payment_history);
        } else {
            toastr.error("Please select date range filter", 'Error!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000, "progressBar": true });
        }

    });


    load_employee_payroll_history_report_list();

    function load_employee_payroll_history_report_list(employee_id_earning_history = '', earning_date_range_payment_history = '') {

        $('#load_employee_payroll_history_list_table').DataTable({
            dom: 'Bftiplr',
            "processing": true,
            oLanguage: { sProcessing: '<div class="ball-pulse-sync loader-purple"><div></div><div></div><div></div><div></div></div>' },
            "serverSide": true,
            "searching": true,
            "bDestroy": true,
            "scrollCollapse": true,

            aoColumnDefs: [{ orderable: false, targets: "no-sort" }],
            "scrollX": "100%",
            "scrollY": "100%",

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
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    download: 'open'
                },
            ],
            "ajax": {
                url: urls,
                method: "POST",
                dataType: 'json',
                data: { employee_id_earning_history, earning_date_range_payment_history, earning_payroll_history_list_access: 'earning_payroll_history_list_access' },
                error: function(xhr, code, error) {
                    console.log(xhr);
                    console.log(code);
                    console.log(error);
                }
            },
        });

    }


    $('#leave_report_employee_id').change(function(e) {
        var leave_report_employee_id = $(this).val();
        $.ajax({
            url: urls,
            method: "POST",
            dataType: 'html',
            data: { leave_report_employee_id, load_leave_report_employee_id: "employee_id_leave" },
            success: function(employee_leave_report) {
                $('#employee_leave_report').html(employee_leave_report);
                //console.log(employee_aguinaldo_report);
            },
            error: function(e) {},
        });
    });


    $(document).on('click', ".leave_report_email_btn", function(e) {
        var earning_id = $(this).attr("id");

        $.ajax({
            url: urls,
            method: "POST",
            dataType: 'json',
            data: { earning_id: earning_id, leave_report_email_btn: "leave_report_email_btn" },
            beforeSend: function() {
                $(".leave_report_email_btn").html("<i class='la la-spinner spinner'></i> Please Wait...");
                $('.leave_report_email_btn').addClass('disabled');
                $('.leave_report_email_btn').prop('disabled', true);
            },
            success: function(json) {
                toastr.success(json, 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 5000, "progressBar": true });
                $(".leave_report_email_btn").html("<i class='la la-paper-plane-o'></i> Send to Mail");
                $('.leave_report_email_btn').removeClass('disabled');
                $('.leave_report_email_btn').prop('disabled', false);
            },

        });

    });


    $(document).on('click', ".leave_report_pdf_btn", function(e) {
        var earning_id = $(this).attr("id");

        $.ajax({
            url: urls,
            method: "POST",
            dataType: 'json',
            data: { earning_id: earning_id, leave_report_pdf_btn: "leave_report_pdf_btn" },
            beforeSend: function() {
                $(".leave_report_pdf_btn").html("<i class='la la-spinner spinner'></i> Please Wait...");
                $('.leave_report_pdf_btn').addClass('disabled');
                $('.leave_report_pdf_btn').prop('disabled', true);
            },
            success: function(json) {
                $(".leave_report_pdf_btn").html("<i class='la la-download'></i> Download PDF");
                $('.leave_report_pdf_btn').removeClass('disabled');
                $('.leave_report_pdf_btn').prop('disabled', false);
            },

        });

    });



    $('#salary_letter_employee_id').change(function(e) {
        var salary_letter_employee_id = $(this).val();
        $.ajax({
            url: urls,
            method: "POST",
            dataType: 'html',
            data: { salary_letter_employee_id, load_salary_letter_employee_id: "employee_id_salary_letter" },
            success: function(employee_salary_letter) {
                $('#employee_salary_letter').html(employee_salary_letter);
                //console.log(employee_salary_letter);
            },
            error: function(e) {},
        });
    });


    $(document).on('click', ".salary_letter_email_btn", function(e) {
        var salary_letter_employee_id = $(this).attr("id");

        $.ajax({
            url: urls,
            method: "POST",
            dataType: 'json',
            data: { salary_letter_employee_id: salary_letter_employee_id, salary_letter_email_btn: "salary_letter_email_btn" },
            beforeSend: function() {
                $(".salary_letter_email_btn").html("<i class='la la-spinner spinner'></i> Please Wait...");
                $('.salary_letter_email_btn').addClass('disabled');
                $('.salary_letter_email_btn').prop('disabled', true);
            },
            success: function(json) {
                toastr.success(json, 'Message!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 5000, "progressBar": true });
                $(".salary_letter_email_btn").html("<i class='la la-paper-plane-o'></i> Send to Mail");
                $('.salary_letter_email_btn').removeClass('disabled');
                $('.salary_letter_email_btn').prop('disabled', false);
            },

        });

    });


    $(document).on('click', ".salary_letter_pdf_btn", function(e) {
        var salary_letter_employee_id = $(this).attr("id");

        $.ajax({
            url: urls,
            method: "POST",
            dataType: 'json',
            data: { salary_letter_employee_id: salary_letter_employee_id, salary_letter_pdf_btn: "salary_letter_pdf_btn" },
            beforeSend: function() {
                $(".salary_letter_pdf_btn").html("<i class='la la-spinner spinner'></i> Please Wait...");
                $('.salary_letter_pdf_btn').addClass('disabled');
                $('.salary_letter_pdf_btn').prop('disabled', true);
            },
            success: function(json) {
                $(".salary_letter_pdf_btn").html("<i class='la la-download'></i> Download PDF");
                $('.salary_letter_pdf_btn').removeClass('disabled');
                $('.salary_letter_pdf_btn').prop('disabled', false);
            },

        });

    });



    $('#journal_report_date').change(function(e) {
        var journal_report_date = $(this).val();
        $.ajax({
            url: urls,
            method: "POST",
            dataType: 'html',
            data: { journal_report_date, load_journal_report: "load_journal_report" },
            success: function(journal_report_result) {
                $('#journal_report_result').html(journal_report_result);
                //console.log(employee_salary_letter);
            },
            error: function(e) {},
        });
    });


    $(document).on('click', ".journal_report_pdf_btn", function(e) {
        var journal_report_date = $(this).attr("id");

        $.ajax({
            url: urls,
            method: "POST",
            dataType: 'json',
            data: { journal_report_date: journal_report_date, journal_report_pdf_btn: "journal_report_pdf_btn" },
            beforeSend: function() {
                $(".journal_report_pdf_btn").html("<i class='la la-spinner spinner'></i> Please Wait...");
                $('.journal_report_pdf_btn').addClass('disabled');
                $('.journal_report_pdf_btn').prop('disabled', true);
            },
            success: function(json) {
                $(".journal_report_pdf_btn").html("<i class='la la-download'></i> Download PDF");
                $('.journal_report_pdf_btn').removeClass('disabled');
                $('.journal_report_pdf_btn').prop('disabled', false);
            },

        });

    });


});