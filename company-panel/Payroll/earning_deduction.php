<?php include("../include/header.php"); ?>


<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Update Employee Deduction</h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo $result["Web_Url"]; ?>dashboard">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Employee Deduction
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


        <!-- File export table -->
        <section id="file-export">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Employee Deduction</h4>
                        </div>
                        <div class="card-content collapse show ">

                            <div class="row" style="padding-left: 20px">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="projectinput2" data-i18n="payment_type">Select Employee Payment type<span class="danger">*</span></label>
                                        <select class="select2 form-control" id="employee_deduction_id" name="employee_deduction_id">
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

                                <div class="col-md-4">
                                    <fieldset class="form-group">
                                        <label for="projectinput2" data-i18n="select_date">Select Payment Date<span class="danger">*</span></label>
                                        <select class="select2 form-control earning_date_range_payment" id="earning_date_range_payment">
                                            <option value="" selected disabled>Choose Date...</option>
                                            <?php
                                            foreach ($earning_date_datas as $key => $earning_date_data) {
                                            ?>
                                                <option value="<?php echo $earning_date_data["Dates"]; ?>"><?php echo $earning_date_data["Dates"] . ' - ' . $earning_date_data["End_Date"]; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </fieldset>
                                </div>

                                <div class="col-md-2" style="padding-top: 18px">
                                    <button type="button" id="deduction_search_btn" class="btn waves-effect waves-light btn-block btn-info" data-i18n="submit_btn">
                                        <li class="la la-search"></li> Submit
                                    </button>
                                </div>
                            </div>


                            <div class="card-body card-dashboard table-responsive">
                                <table class="table table-striped table-bordered" id="employee_deduction_list">
                                    <thead>
                                        <tr>
                                            <th style="width: 250px"><span data-i18n="emp_first_name">Fullname</span> </th>
                                            <th><span data-i18n="emp_loan">Loan</span> </th>
                                            <th><span data-i18n="emp_commission">Assessment</span> </th>
                                            <th><span data-i18n="emp_other_deduction">Other</span> </th>
                                        </tr>
                                    </thead>
                                    <tbody id="employee_deduction_table">
                                        <td colspan="10">
                                            <center> Please select filter</center>
                                        </td>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th><span data-i18n="emp_first_name">Fullname</span> </th>
                                            <th><span data-i18n="emp_loan">Loan</span> </th>
                                            <th><span data-i18n="emp_commission">Assessment</span> </th>
                                            <th><span data-i18n="emp_other_deduction">Other</span> </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="row col-md-12" style="padding-bottom:20px" id="deduction_computation_div">
                                <div class="col-md-4">
                                </div>

                                <div class="col-md-4" style="padding-top: 18px">
                                    <button type="submit" id="deduction_btn" name="deduction_btn" class="btn waves-effect waves-light btn-block btn-info" data-i18n="submit_btn">
                                        <li class="la la-save"></li> Submit
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- File export table -->

    </div>
</div>

<!-- ////////////////////////////////////////////////////////////////////////////-->

<?php include("../include/footer.php"); ?>