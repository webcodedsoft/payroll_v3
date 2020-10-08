<?php include("../include/header.php"); ?>


<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Manage Employee Payroll </h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo $result["Web_Url"]; ?>dashboard">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Manage Employee Payroll
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
                            <h4 class="card-title">Manage Employee Payroll</h4>
                        </div>
                        <div class="card-content collapse show ">

                            <?php
                            if ($__earning_count > 0) {
                            ?>
                                <center>
                                    <div style="border-color: #607D8B; margin-bottom:20px; " class="col-md-12 bs-callout-blue-grey callout-border-rights callout-bordered callout-transparent mt-1 p-1">
                                        <div class="row">

                                            <div class="col-md-3">
                                                <h2><b><input type="checkbox" id="select_all_manage_payroll" name="select_all_manage_payroll" class="select_all_manage_payroll_all"> Select All</b></h2>
                                            </div>
                                            <div class="row" id="manage_payroll_btns">
                                                <div class="col-md-4" id="manage_payroll_delete_btn">
                                                    <span class="text-right"><button type="button" class="btn btn-danger delete_selected_manage_payroll_btn btn-min-width box-shadow-3 " id="delete_selected_manage_payroll_btn"><i class="la la-trash"></i> Delete Payroll</button></span>
                                                </div>

                                                <div class="col-md-4" id="manage_payroll_lock_unlock_btn">
                                                    <span class="text-right"><button type="button" class="btn btn-primary lock_unlock_selected_manage_payroll_btn btn-min-width box-shadow-3 " id="lock_unlock_selected_manage_payroll_btn"><i class="la la-unlock-alt"></i> Lock/Unlock Payroll</button></span>
                                                </div>

                                                <div class="col-md-4" id="manage_payroll_send_payment_proof">
                                                    <span class="text-right"><button type="button" class="btn btn-secondary send_payment_proof_to_selected_manage_payroll_btn btn-min-width box-shadow-3" id="send_payment_proof_to_selected_manage_payroll_btn"><i class="la la-envelope"></i> Send Payroll Payment Proof </button></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </center>
                            <?php
                            }
                            ?>


                            <div class="card-bodys card-dashboards table-responsive">

                                <table class="table table-striped table-bordered" id="manage_employee_payroll_list">
                                    <thead>
                                        <tr>
                                            <th><span data-i18n="fullname"> Fullname</span></th>
                                            <th><span data-i18n="department"> Department </span></th>
                                            <th><span data-i18n="basic_salary">Basic Salary</span></th>
                                            <th><span data-i18n="gross_salary">Gross Salary </span></th>
                                            <th><span data-i18n="deduction">Deduction </span></th>
                                            <th><span data-i18n="netpay">Netpay </span></th>
                                            <th><span data-i18n="created_date"> Created Date</span></th>
                                            <th><span data-i18n="created_by"> Created By</span></th>
                                            <th><span data-i18n="modified_date"> Modified Date</span></th>
                                            <th><span data-i18n="modified_by"> Modified By</span></th>
                                            <th><span data-i18n="status"> Status</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th><span data-i18n="fullname"> Fullname</span></th>
                                            <th><span data-i18n="department"> Department </span></th>
                                            <th><span data-i18n="basic_salary">Basic Salary</span></th>
                                            <th><span data-i18n="gross_salary">Gross Salary </span></th>
                                            <th><span data-i18n="deduction">Deduction </span></th>
                                            <th><span data-i18n="netpay">Netpay </span></th>
                                            <th><span data-i18n="created_date"> Created Date</span></th>
                                            <th><span data-i18n="created_by"> Created By</span></th>
                                            <th><span data-i18n="modified_date"> Modified Date</span></th>
                                            <th><span data-i18n="modified_by"> Modified By</span></th>
                                            <th><span data-i18n="status"> Status</span></th>
                                        </tr>
                                    </tfoot>
                                </table>

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