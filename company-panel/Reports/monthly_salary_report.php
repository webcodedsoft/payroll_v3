<?php include("../include/header.php"); ?>



<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Payroll Monthly Salary Report</h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo $result["Web_Url"]; ?>dashboard">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Payroll Monthly Salary Report
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
                            <h4 class="card-title" data-i18n="payroll_worksheet">Payroll Monthly Salary Report</h4>
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
                                    <fieldset class="form-group">
                                        <label for="projectinput2" data-i18n="select_date">Select Date<span class="danger">*</span></label>
                                        <select class="select2 form-control monthly_salary_report_date" id="monthly_salary_report_date">
                                            <option value="" selected disabled>Choose Date...</option>
                                            <option value="01">January</option>
                                            <option value="02">February</option>
                                            <option value="03">March</option>
                                            <option value="04">April</option>
                                            <option value="05">May</option>
                                            <option value="06">June</option>
                                            <option value="07">July</option>
                                            <option value="08">August</option>
                                            <option value="09">September</option>
                                            <option value="10">October</option>
                                            <option value="11">November</option>
                                            <option value="12">December</option>
                                        </select>

                                    </fieldset>
                                </div>
                            </div>
                        </div>


                        <div class="card-body card-dashboard table-responsive">
                            <table class="table table-striped table-bordered" id="load_payroll_monthly_salary_report">
                                <thead>
                                    <tr>
                                        <th><span data-i18n="emp_id">Employee ID</span></th>
                                        <th class="no-sort"><span data-i18n="name_of_employee">Fullname</span></th>
                                        <th class="no-sort"><span data-i18n="social_security">Social Security</span></th>
                                        <th class="no-sort"><span data-i18n="association">Association </span></th>
                                        <th class="no-sort"><span data-i18n="currency">Currency</span></th>
                                        <th class="no-sort"><span data-i18n="gross_salary">Gross Salary</span></th>
                                        <th class="no-sort"><span data-i18n="date">Payroll Date</span></th>
                                    </tr>
                                </thead>
                                <tbody>


                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th><span data-i18n="emp_id">Employee ID</span></th>
                                        <th class="no-sort"><span data-i18n="name_of_employee">Fullname</span></th>
                                        <th class="no-sort"><span data-i18n="social_security">Social Security</span></th>
                                        <th class="no-sort"><span data-i18n="association">Association </span></th>
                                        <th class="no-sort"><span data-i18n="currency">Currency</span></th>
                                        <th class="no-sort"><span data-i18n="gross_salary">Gross Salary</span></th>
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