$(document).ready(function() {

    $(document).on('click', '.delete_image', function(e) {
        var delete_data_id = $(this).attr("id");
        var delete_function = "delete_image";
        DeletePopOverAlert(delete_data_id, delete_function);
    });

    var baseUrls = $('#static_url').val();
    var urls = baseUrls.concat('Controller/Company/PerformanceController.php');

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
                    success: function(json) {
                        if (json == 'Deleted')
                            swal("Deleted!", "Your data has been deleted.", "success");
                        subscribed_package_list();
                    },

                });

            } else {
                swal("Cancelled", "Your data is safe :)", "error");
            }
        });
    }



    StorageView();

    function StorageView() {
        var ctx = $("#storage_chart");
        $.ajax({
            url: urls,
            type: "POST",
            dataType: 'json',
            data: { storage_view: "storage_view" },
            success: function(json) {
                // Chart Options
                var chartOptions = {
                    responsive: true,
                    maintainAspectRatio: false,
                    responsiveAnimationDuration: 500,
                };

                // Chart Data
                var chartData = {
                    labels: ["Storage", "Free Space", "Used Space"],
                    datasets: [{
                        label: "Storage Space",
                        data: [json.Storage, json.Free_Space, json.Used_Space],
                        backgroundColor: ['#00A5A8', '#626E82', '#FF7D4D'],
                    }]
                };

                var config = {
                    type: 'pie',
                    // Chart Options
                    options: chartOptions,

                    data: chartData
                };

                // Create the chart
                var pieSimpleChart = new Chart(ctx, config);
            },
            error: function(e) {}
        });
    }




    subscribed_package_list();

    function subscribed_package_list(e) {
        //var baseUrls = $(location).attr('href');


        $('#subscribed_package_list').DataTable({
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
                    subscribed_package_list_access: 'subscribed_package_list_access',
                },
                error: function(xhr, code, error) {
                    console.log(xhr);
                    console.log(code);
                    console.log(error);
                }
            }
        });


    }



    folder_list_view();

    function folder_list_view(e) {
        $.ajax({
            url: urls,
            type: "POST",
            dataType: 'json',
            data: { folder_list_view: "folder_list_view" },
            success: function(json) {
                $("#file_pro_list").html(json);
            },
            error: function(e) {}
        });


    }



    $(document).on('click', '#folder_view', function(e) {

        var folder_name = $(this).data("name");

        $.ajax({
            type: "POST",
            url: urls,
            dataType: 'json',
            data: { folder_name: folder_name, folder_view: 'folder_view' },
            success: function(json_result) {
                $("#file_list_view").html(json_result);
            },

            error: function(e) {

            }
        });
    });

});