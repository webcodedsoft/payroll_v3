<?php include("../include/header.php"); ?>


<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Marital Status Settings </h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo $result["Web_Url"]; ?>dashboard">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Marital Status
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


        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
            </div>

            <div class="content-header-right col-md-6 col-12">
                <div class="dropdown float-md-right">
                    <button type="button" onclick="location.href='<?php echo $result['Web_Url']; ?>add-employee'" class="btn btn-info round btn-min-width mr-1 mb-1"> <i class="la la-plus"></i> Add Employee</button>
                </div>
            </div>

        </div>


        <!-- File export table -->
        <section id="row-separator-form-layouts">
            <div class="row">
                <div class="col-md-12">
                    <div class="jqueryui-ele-container">
                        <div class="tabs-default">
                            <ul class="float-md-right">
                                <li><a href="#employee_grid_view"><i class="la la-navicon"></i></a></li>
                                <li><a href="#employee_list_view"><i class="la la-th"></i></a></li>
                            </ul>
                            <div id="employee_grid_view">
                                <br> <br><br>
                                <div class="row" id="employee_grid_view_display">
                                    <div class="col-xl-3 col-md-6 col-12">
                                        <div class="card box-shadow-1">

                                            <div class="float-right text-right ">
                                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                                <div class="heading-elements"><br>
                                                    <ul class="list-inline mb-0">
                                                        <div class="dropdown dropdown-action profile-action">
                                                            <a href="#" class="action-icon dropdown-toggles" data-toggle="dropdown" aria-expanded="false"><i class="la la-ellipsis-v"></i></a>
                                                            <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(24px, 32px, 0px);">
                                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_project"><i class="la la-pencil m-r-5"></i> Edit</a>
                                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_project"><i class="la la-trash-o m-r-5"></i> Delete</a>
                                                            </div>
                                                        </div>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <div class="card-body">
                                                    <img src="../../../app-assets/images/portrait/medium/avatar-m-4.png" class="rounded-circle  height-150" alt="Card image">
                                                </div>
                                                <div class="card-body">
                                                    <h4 class="card-title">Michelle Howard</h4>
                                                    <h6 class="card-subtitle text-muted">Managing Director</h6>
                                                </div>
                                                <div class="text-center">
                                                    <a href="#" class="btn btn-social-icon mr-1 mb-1 btn-outline-facebook">
                                                        <span class="la la-facebook"></span>
                                                    </a>
                                                    <a href="#" class="btn btn-social-icon mr-1 mb-1 btn-outline-twitter">
                                                        <span class="la la-twitter"></span>
                                                    </a>
                                                    <a href="#" class="btn btn-social-icon mb-1 btn-outline-linkedin">
                                                        <span class="la la-linkedin font-medium-4"></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <div id="employee_list_view">
                                <br> <br><br>
                                <section id="file-export">
                                    <div class="card">
                                        <div class="card-header">
                                        </div>
                                        <div class="card-content collapse show ">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered" id="employee_list">
                                                    <thead>
                                                        <tr>
                                                            <th><span data-i18n="id_numbers">Employee ID</span></th>
                                                            <th style="width: 250px"><span data-i18n="name_of_employee">Fullname</span></th>
                                                            <th><span data-i18n="hiring_dates">Start Date</span></th>
                                                            <th><span data-i18n="end_dates">End Date</span></th>
                                                            <th><span data-i18n="branch_name">Branch</span></th>
                                                            <th><span data-i18n="department_name">Department</span></th>
                                                            <th><span data-i18n="contract_end_note">Contract End Note</span></th>
                                                            <th><span data-i18n="currency">Currency</span></th>
                                                            <th><span data-i18n="salary">Salary</span></th>
                                                            <th><span data-i18n="reg_date">Register Date</span></th>
                                                            <th><span data-i18n="status">Status</span></th>
                                                            <th><span data-i18n="actions">Action</span></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th><span data-i18n="id_numbers">Employee ID</span></th>
                                                            <th style="width: 250px"><span data-i18n="name_of_employee">Fullname</span></th>
                                                            <th><span data-i18n="hiring_dates">Start Date</span></th>
                                                            <th><span data-i18n="end_dates">End Date</span></th>
                                                            <th><span data-i18n="branch_name">Branch</span></th>
                                                            <th><span data-i18n="department_name">Department</span></th>
                                                            <th><span data-i18n="contract_end_note">Contract End Note</span></th>
                                                            <th><span data-i18n="currency">Currency</span></th>
                                                            <th><span data-i18n="salary">Salary</span></th>
                                                            <th><span data-i18n="reg_date">Register Date</span></th>
                                                            <th><span data-i18n="status">Status</span></th>
                                                            <th><span data-i18n="actions">Action</span></th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
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

    </div>
</div>

<!-- ////////////////////////////////////////////////////////////////////////////-->

<?php include("../include/footer.php"); ?>