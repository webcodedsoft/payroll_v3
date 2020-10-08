<?php include("../include/header.php"); ?>



<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Employee Payroll History</h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo $result["Web_Url"]; ?>dashboard">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Employee Payroll History
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

        <section id="column-selectors">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" data-i18n="payroll_worksheet">Employee Payroll History</h4>
                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                                </ul>
                            </div>
                        </div>


                        <div class="card-content collapse show ">

                            <div class="row" style="padding-left: 40px">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="projectinput2" data-i18n="payment_type">Select Employee Name<span class="danger">*</span></label>
                                        <select class="select2 form-control" id="employee_id_earning_history" name="employee_id_earning_history">
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
                                        <select class="select2 form-control earning_date_range_payment_history" id="earning_date_range_payment_history">
                                            <option value="" selected disabled>Choose Date...</option>
                                            <?php
                                            foreach ($earning_year_dates as $key => $earning_year_date) {
                                                $date_s = $earning_year_date["Dates"];
                                            ?>
                                                <option value="<?php echo $date_s . '-01'; ?>">January <?php echo $date_s; ?></option>
                                                <option value="<?php echo $date_s . '-02'; ?>">February <?php echo $date_s; ?></option>
                                                <option value="<?php echo $date_s . '-03'; ?>">March <?php echo $date_s; ?></option>
                                                <option value="<?php echo $date_s . '-04'; ?>">April <?php echo $date_s; ?></option>
                                                <option value="<?php echo $date_s . '-05'; ?>">May <?php echo $date_s; ?></option>
                                                <option value="<?php echo $date_s . '-06'; ?>">June <?php echo $date_s; ?></option>
                                                <option value="<?php echo $date_s . '-07'; ?>">July <?php echo $date_s; ?></option>
                                                <option value="<?php echo $date_s . '-08'; ?>">August <?php echo $date_s; ?></option>
                                                <option value="<?php echo $date_s . '-09'; ?>">September <?php echo $date_s; ?></option>
                                                <option value="<?php echo $date_s . '-10'; ?>">October <?php echo $date_s; ?></option>
                                                <option value="<?php echo $date_s . '-11'; ?>">November <?php echo $date_s; ?></option>
                                                <option value="<?php echo $date_s . '-12'; ?>">December <?php echo $date_s; ?></option>

                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </fieldset>
                                </div>


                                <div class="col-md-2" style="padding-top: 18px">
                                    <button type="button" id="employee_payroll_history_btn" class="btn waves-effect waves-light btn-block btn-info" data-i18n="submit_btn">
                                        <li class="la la-search"></li> Submit
                                    </button>
                                </div>

                            </div>
                        </div>



                        <div class="card-body card-dashboard table-responsive">
                            <table class="table table-striped table-bordered" id="load_employee_payroll_history_list_table">
                                <thead>
                                    <tr>
                                        <th><span data-i18n="emp_id">Employee ID</span></th>
                                        <th><span data-i18n="name_of_employee">Employee Full Name</span></th>
                                        <th class="no-sort"><span data-i18n="emp_bonus">Bonus</span></th>
                                        <th class="no-sort"><span data-i18n="emp_commission">Comission</span></th>
                                        <th class="no-sort"><span data-i18n="emp_allowance">Allowance</span></th>
                                        <th class="no-sort"><span data-i18n="emp_other_earning">Other Earning</span></th>
                                        <th class="no-sort"><span data-i18n="extra_hour1">Extra Hours 1.5</span></th>
                                        <th class="no-sort"><span data-i18n="extra_hour2">Extra Hours 2.0</span></th>
                                        <th class="no-sort"><span data-i18n="ordinary">Ordinary</span></th>
                                        <th class="no-sort"><span data-i18n="loan">Loan</span></th>
                                        <th class="no-sort"><span data-i18n="assessment">Assessment</span></th>
                                        <th class="no-sort"><span data-i18n="other_deduction">Other Deduction</span></th>
                                        <th class="no-sort"><span data-i18n="basic_salary">Basic Salary</span></th>
                                        <th class="no-sort"><span data-i18n="gross_salary">Gross Salary</span></th>
                                        <th class="no-sort"><span data-i18n="netpay">NetPay</span></th>
                                        <th class="no-sort"><span data-i18n="date">Payroll Date</span></th>
                                    </tr>
                                </thead>
                                <tbody>


                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th><span data-i18n="emp_id">Employee ID</span></th>
                                        <th><span data-i18n="name_of_employee">Employee Full Name</span></th>
                                        <th class="no-sort"><span data-i18n="emp_bonus">Bonus</span></th>
                                        <th class="no-sort"><span data-i18n="emp_commission">Comission</span></th>
                                        <th class="no-sort"><span data-i18n="emp_allowance">Allowance</span></th>
                                        <th class="no-sort"><span data-i18n="emp_other_earning">Other Earning</span></th>
                                        <th class="no-sort"><span data-i18n="extra_hour1">Extra Hours 1.5</span></th>
                                        <th class="no-sort"><span data-i18n="extra_hour2">Extra Hours 2.0</span></th>
                                        <th class="no-sort"><span data-i18n="ordinary">Ordinary</span></th>
                                        <th class="no-sort"><span data-i18n="loan">Loan</span></th>
                                        <th class="no-sort"><span data-i18n="assessment">Assessment</span></th>
                                        <th class="no-sort"><span data-i18n="other_deduction">Other Deduction</span></th>
                                        <th class="no-sort"><span data-i18n="basic_salary">Basic Salary</span></th>
                                        <th class="no-sort"><span data-i18n="gross_salary">Gross Salary</span></th>
                                        <th class="no-sort"><span data-i18n="netpay">NetPay</span></th>
                                        <th class="no-sort"><span data-i18n="date">Payroll Date</span></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>



                    </div>
                </div>
            </div>
        </section>


        <!-- File export table -->
        <div id="employee_payment_proof"></div>

        <!-- File export table -->

    </div>
</div>

<!-- ////////////////////////////////////////////////////////////////////////////-->

<?php include("../include/footer.php"); ?>