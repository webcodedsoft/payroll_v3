<?php include("../include/header.php"); ?>



<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Employee Salary Letter</h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo $result["Web_Url"]; ?>dashboard">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Employee Salary Letter
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
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="projectinput2" data-i18n="payment_type">Select Employee Name<span class="danger">*</span></label>
                                                        <select class="select2 form-control" id="completion_employee_id" name="completion_employee_id">
                                                            <option disabled="" selected="">Select Employee By Name</option>
                                                            <?php
                                                            foreach ($employee_earning_datas as $key => $employee_earning_data) {
                                                                $employee_data = $data_connect->EmployeesDataByID($employee_earning_data["Employee_ID"])->first();
                                                            ?>
                                                                <option value="<?php echo $employee_earning_data["Employee_ID"]; ?>"><?php echo $employee_data["First_Name"] . ' ' . $employee_data["Last_Name"]; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="input-daterange col-md-3">
                                                    <label for="projectinput2" data-i18n="payment_type">Select Ending Date<span class="danger">*</span></label>
                                                    <input type="date" required class="form-control" placeholder="Select Date" id="employee_ending_date" name="employee_ending_date" />
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="projectinput2" data-i18n="firing_type">Select Firing Types<span class="danger">*</span></label>
                                                        <select class="select2 form-control" id="employee_firing_type" name="employee_firing_type">
                                                            <option selected disabled>Firing Types</option>
                                                            <option value="Right">Firing With Right</option>
                                                            <option value="No">Firing Without Right</option>
                                                            <option value="Decision">Employee Decision</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-2" style="padding-top: 20px">
                                                    <button type="button" id="employee_completion_btn" class="btn waves-effect waves-light btn-block btn-info" data-i18n="submit_btn"><i class="la la-save"></i> Submit</button>
                                                </div>

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
        <div id="employee_completion"></div>

        <!-- File export table -->

    </div>
</div>

<!-- ////////////////////////////////////////////////////////////////////////////-->

<?php include("../include/footer.php"); ?>