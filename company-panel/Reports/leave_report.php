<?php include("../include/header.php"); ?>



<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Employee Vacation Report</h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo $result["Web_Url"]; ?>dashboard">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Employee Vacation Report
                        </li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-header-right col-md-6 col-12">
            <div class="dropdown float-md-right">
                <button class="btn btn-danger dropdown-toggle round btn-glow px-2" id="dropdownBreadcrumbButton" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>
            </div>
        </div>
    </div>
    <div class="content-body">

        <section id="form-repeater">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content collapse show">
                            <div class="card-body">
                                <div class="repeater-default">
                                    <div data-repeater-list="car">
                                        <div data-repeater-item>
                                            <div class="row">
                                                <div class="col-md-2"></div>
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label for="projectinput2" data-i18n="payment_type">Select Employee Name<span class="danger">*</span></label>
                                                        <select class="select2 form-control" id="leave_report_employee_id" name="leave_report_employee_id">
                                                            <option disabled="" selected="">Select Employee By Name</option>
                                                            <?php
                                                            foreach ($employee_earning_datas as $key => $employee_earning_data) {
                                                                $employee_data_earning = $data_connect->EmployeesDataByID($employee_earning_data["Employee_ID"])->first();
                                                            ?>
                                                                <option value="<?php echo $employee_earning_data["Employee_ID"]; ?>"><?php echo $employee_data_earning["First_Name"] . ' ' . $employee_data_earning["Last_Name"]; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- File export table -->
        <div id="employee_leave_report"></div>

        <!-- File export table -->

    </div>
</div>

<!-- ////////////////////////////////////////////////////////////////////////////-->

<?php include("../include/footer.php"); ?>