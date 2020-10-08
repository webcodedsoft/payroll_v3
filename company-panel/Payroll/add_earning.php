<?php include("../include/header.php"); ?>


<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Add Employee Earning</h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo $result["Web_Url"]; ?>dashboard">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Employee Earning
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
                            <h4 class="card-title">Employee Earning</h4>
                        </div>
                        <div class="card-content collapse show ">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="projectinput2" data-i18n="payment_type">Select Employee Payment type<span class="danger">*</span></label>
                                    <select class="select2 form-control" id="earning_payment_type" name="earning_payment_type">
                                        <option disabled="" selected="">Select Employee Payment Type</option>
                                        <option value="30">Monthly</option>
                                        <option value="15">Semi Monthly</option>
                                        <option value="7">Weekly</option>
                                    </select>
                                </div>
                            </div>


                            <div class="card-body card-dashboard table-responsive">
                                <table class="table table-striped table-bordered" id="employee_earning_list">
                                    <thead>
                                        <tr>
                                            <th style="width: 250px"><span data-i18n="emp_first_name">Fullname</span> </th>
                                            <th><span data-i18n="emp_bonus">Bonus</span> </th>
                                            <th><span data-i18n="emp_commission">Comission</span> </th>
                                            <th><span data-i18n="emp_allowance">Allowance</span> </th>
                                            <th><span data-i18n="emp_other_earning">Other Earning</span> </th>
                                            <th><span data-i18n="extra_earning1">Extra 1.5</span> </th>
                                            <th><span data-i18n="extra_earning2">Extra 2.0</span> </th>
                                            <th><span data-i18n="ordinary">Ordinary</span> </th>
                                        </tr>
                                    </thead>
                                    <tbody id="employee_earning_table">
                                        <td colspan="10">
                                            <center> Please select filter</center>
                                        </td>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th><span data-i18n="emp_first_name">Fullname</span> </th>
                                            <th><span data-i18n="emp_bonus">Bonus</span> </th>
                                            <th><span data-i18n="emp_commission">Comission</span> </th>
                                            <th><span data-i18n="emp_allowance">Allowance</span> </th>
                                            <th><span data-i18n="emp_other_earning">Other Earning</span> </th>
                                            <th><span data-i18n="extra_earning1">Extra 1.5</span> </th>
                                            <th><span data-i18n="extra_earning2">Extra 2.0</span> </th>
                                            <th><span data-i18n="ordinary">Ordinary</span> </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="row col-md-12" style="padding-bottom:20px" id="computation_div">
                                <div class="col-md-4">
                                    <label>Select Payment Date:</label>
                                    <input type="date" class="form-control" id="payment_date" required placeholder="YYYY-MM-DD" name="dates" />
                                </div>
                                <div class="col-md-4">
                                    <label>Foreign Currency Exchange Rate:</label>
                                    <input type="text" class="form-control" id="exchang_rate" required placeholder="0" name="exchang_rate" />
                                </div>
                                <div class="col-md-4" style="padding-top: 18px">
                                    <button type="submit" id="add_earning" name="add_earning" class="btn waves-effect waves-light btn-block btn-info" data-i18n="submit_btn">
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