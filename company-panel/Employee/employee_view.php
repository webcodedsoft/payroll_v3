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
                    <button type="button" onclick="location.href='<?php echo $result['Web_Url']; ?>employee-list'" class="btn btn-info round btn-min-width mr-1 mb-1"> <i class="la la-th"></i> Employee List</button>
                </div>
            </div>

        </div>

        <!-- File export table -->
        <section id="row-separator-form-layouts">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="profile-view">
                                        <div class="profile-img-wrap">
                                            <div class="profile-img">
                                                <a href="#"><img alt="" class="rounded-circle" src="<?php echo $employee_image; ?>"></a>
                                            </div>
                                        </div>
                                        <div class="profile-basic">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <div class="profile-info-left">
                                                        <h3 class="user-name m-t-0 mb-0"><?php echo $employee_view_datas_by_id["First_Name"]; ?> <?php echo $employee_view_datas_by_id["Last_Name"]; ?></h3>
                                                        <h6 class="text-muted"><?php echo $branch_results["Branch_Name"]; ?></h6>
                                                        <h6 style="padding-top: 10px" class="text-muted"><?php echo $department_results["Department_Name"]; ?></h6>
                                                        <div class="staff-id">Employee ID : <b><?php echo $employee_view_datas_by_id["Emp_ID"]; ?></b> </div>
                                                        <div style="padding-top: 10px" class="smalls doj text-muted">Date of Join : <?php echo $join_date; ?></div>
                                                        <div class="staff-msg"><a class="btn btn-custom" href="javascript:void(0)"></a></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-7">
                                                    <ul class="personal-info">
                                                        <li>
                                                            <div class="title">Phone:</div>
                                                            <div class="text"><a href="javascript:void(0)"><?php echo $employee_view_datas_by_id["Phone_Number"]; ?></a></div>
                                                        </li>
                                                        <li>
                                                            <div class="title">Email:</div>
                                                            <div class="text"><a href="javascript:void(0)"><?php echo $employee_view_datas_by_id["Email"]; ?></a></div>
                                                        </li>
                                                        <li>
                                                            <div class="title">Birthday:</div>
                                                            <div class="text"><?php echo date($localization_data["Date_Format"], strtotime($employee_view_datas_by_id["DOB"])); ?></div>
                                                        </li>
                                                        <li>
                                                            <div class="title">Address:</div>
                                                            <div class="text"><?php echo $employee_view_datas_by_id["Address"]; ?></div>
                                                        </li>
                                                        <li>
                                                            <div class="title">Gender:</div>
                                                            <div class="text"><?php echo $employee_view_datas_by_id["Gender"]; ?></div>
                                                        </li>

                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pro-edit success"><a class="edit-icon info" href="<?php echo $result["Web_Url"]; ?>edit-employee?employee_id=<?php echo $employee_view_datas_by_id["Employee_ID"]; ?>"><i class="la la-pencil"></i></a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card tab-box">
                        <div class="row user-tabs">
                            <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                                <ul class="nav nav-tabs nav-tabs-bottom">
                                    <li class="nav-item"><a href="#emp_profile" data-toggle="tab" class="nav-link active">Profile</a></li>
                                    <li class="nav-item"><a href="#emp_projects" data-toggle="tab" class="nav-link">Projects</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="tab-content">

                        <!-- Profile Info Tab -->
                        <div id="emp_profile" class="pro-overview tab-pane fade active show">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card profile-box flex-fill">
                                        <div class="card-body">
                                            <h3 class="card-title">Personal Informations </h3>
                                            <ul class="personal-info">
                                                <li>
                                                    <div class="title">License.</div>
                                                    <div class="text"><?php echo $employee_view_datas_by_id["License"]; ?></div>
                                                </li>
                                                <li>
                                                    <div class="title">Marital Status</div>
                                                    <div class="text"><?php echo $marital_results["Married_Name"]; ?></div>
                                                </li>
                                                <li>
                                                    <div class="title">Nationality</div>
                                                    <div class="text"><?php echo $employee_view_datas_by_id["Nationality"]; ?></div>
                                                </li>
                                                <li>
                                                    <div class="title">Religion</div>
                                                    <div class="text"><?php echo $employee_view_datas_by_id["Religion"]; ?></div>
                                                </li>
                                                <li>
                                                    <div class="title">City</div>
                                                    <div class="text"><?php echo $employee_view_datas_by_id["City"]; ?></div>
                                                </li>
                                                <li>
                                                    <div class="title">No. of children</div>
                                                    <div class="text"><?php echo $family_tax_results["Kids_Num"]; ?></div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card profile-box flex-fill">
                                        <div class="card-body">
                                            <h3 class="card-title">Emergency Contact </h3>
                                            <h5 class="section-title">Primary</h5>
                                            <ul class="personal-info">
                                                <li>
                                                    <div class="title">Name</div>
                                                    <div class="text"><?php echo $employee_view_datas_by_id["Emergency_Primary_Name"]; ?></div>
                                                </li>
                                                <li>
                                                    <div class="title">Relationship</div>
                                                    <div class="text"><?php echo $employee_view_datas_by_id["Emergency_Primary_Relationship"]; ?></div>
                                                </li>
                                                <li>
                                                    <div class="title">Phone </div>
                                                    <div class="text"><?php echo $employee_view_datas_by_id["Emergency_Primary_Contact"]; ?></div>
                                                </li>
                                            </ul>
                                            <?php if (!empty($employee_view_datas_by_id["Emergency_Secondary_Name"])) { ?>
                                                <hr>
                                                <h5 class="section-title">Secondary</h5>
                                                <ul class="personal-info">
                                                    <li>
                                                        <div class="title">Name</div>
                                                        <div class="text"><?php echo $employee_view_datas_by_id["Emergency_Secondary_Name"]; ?></div>
                                                    </li>
                                                    <li>
                                                        <div class="title">Relationship</div>
                                                        <div class="text"><?php echo $employee_view_datas_by_id["Emergency_Secondary_Relationship"]; ?></div>
                                                    </li>
                                                    <li>
                                                        <div class="title">Phone </div>
                                                        <div class="text"><?php echo $employee_view_datas_by_id["Emergency_Secondary_Contact"]; ?></div>
                                                    </li>
                                                </ul>
                                            <?php }; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card profile-box flex-fill">
                                        <div class="card-body">
                                            <h3 class="card-title">Bank information</h3>
                                            <ul class="personal-info">
                                                <li>
                                                    <div class="title">Bank name</div>
                                                    <div class="text"><?php echo $employee_view_datas_by_id["Bank_Name"]; ?></div>
                                                </li>
                                                <li>
                                                    <div class="title">Bank account No.</div>
                                                    <div class="text"><?php echo $employee_view_datas_by_id["Account_Number"]; ?></div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card profile-box flex-fill">
                                        <div class="card-body">
                                            <h3 class="card-title">Deduction Informations </h3>
                                            <div class="table-responsive">
                                                <table class="table table-nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th>Social Security Percentage</th>
                                                            <th>Association Percentage</th>
                                                            <th>Annual Vacation Days</th>
                                                            <th>Tax Rate</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><?php echo $social_results["Sos_Code"]; ?> (<?php echo $social_results["Rate"]; ?>%)</td>
                                                            <td><?php echo $association_tax_results["Association_Code"]; ?> (<?php echo $association_tax_results["Association_Rate"]; ?>%)</td>
                                                            <td><?php echo $vacation_results["Vacation_Name"]; ?> (<?php echo $vacation_results["Vacation_Day"]; ?> Days)</td>
                                                            <td><?php echo $tax_results["Tax_Rate"]; ?>%</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card profile-box flex-fill">
                                        <div class="card-body">
                                            <h3 class="card-title">Basic Salary Information </h3>
                                            <ul class="personal-info">
                                                <li>
                                                    <div class="title">Payment Type</div>
                                                    <div class="text"><?php echo $payment_type; ?></div>
                                                </li>
                                                <li>
                                                    <div class="title">Monthly Salary</div>
                                                    <div class="text"><?php echo $employee_view_datas_by_id["Salary"]; ?></div>
                                                </li>
                                                <li>
                                                    <div class="title">Currency</div>
                                                    <div class="text"><?php echo $currency_results["Currency_Code"]; ?> (<?php echo $currency_results["Currency_Symbol"]; ?>)</div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- /Profile Info Tab -->

                        <!-- Projects Tab -->
                        <div class="tab-pane fade" id="emp_projects">
                            <div class="row">

                                <?php if ($employee_assigned_pro_count > 0) {

                                    foreach ($employee_assigned_pro_results as $key => $data_value) {
                                        $employee_query_value = $data_connect->EmployeesDataByID($data_value["Leader"])->first();
                                        $full_name = $employee_query_value["First_Name"] . ' ' . $employee_query_value["Last_Name"];

                                        if ($data_value["Status"] == 'Active') {
                                            $project_status = '<span class="badge badge-default badge-primary">' . $data_value["Status"] . '</span>';
                                        } elseif ($data_value["Status"] == 'Complete') {
                                            $project_status = '<span class="badge badge-default badge-success">' . $data_value["Status"] . '</span>';
                                        } elseif ($data_value["Status"] == 'Inactive') {
                                            $project_status = '<span class="badge badge-default badge-danger">' . $data_value["Status"] . '</span>';
                                        }

                                        if ($data_value["Priority"] == 'High') {
                                            $project_priority = '<span class="badge badge-default badge-danger">' . $data_value["Priority"] . '</span>';
                                        } elseif ($data_value["Priority"] == 'Medium') {
                                            $project_priority = '<span class="badge badge-default badge-warning">' . $data_value["Priority"] . '</span>';
                                        } elseif ($data_value["Priority"] == 'Low') {
                                            $project_priority = '<span class="badge badge-default badge-primary">' . $data_value["Priority"] . '</span>';
                                        }
                                        $project_description = strlen($data_value["Description"]) > 200 ? substr($data_value["Description"], 0, 200) . '...' : $data_value["Description"];

                                        $project_view_link = '<a class="info" style="font-size: 15px" href="' . $result["Web_Url"] . 'overview?pro_id=' . $data_value["Project_ID"] . '">' . $data_value["Project_Name"] . ' </a> ';
                                ?>
                                        <div class="col-lg-4 col-sm-6 col-md-4 col-xl-3">
                                            <div class="card">
                                                <div class="card-header" style="border-bottom: double; padding:1rem 1rem">
                                                    <h4 class="card-title"><b> <?php echo $project_view_link; ?></b></h4>
                                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                                    <div class="heading-elements">
                                                        <ul class="list-inline mb-0">
                                                            <div class="dropdown dropdown-action profile-action">
                                                                <a href="#" class="action-icon dropdown-toggles" data-toggle="dropdown" aria-expanded="false"><i class="la la-ellipsis-v"></i></a>
                                                                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(24px, 32px, 0px);">
                                                                    <a class="dropdown-item edit_project" href="#" data-toggle="modal" id="<?php echo $data_value[" ID"]; ?>"><i class="la la-pencil m-r-5"></i> Edit</a>
                                                                    <a class="dropdown-item delete_project" href="#" data-toggle="modal" id="<?php echo $data_value[" ID"]; ?>"><i class="la la-trash-o m-r-5"></i> Delete</a>
                                                                </div>
                                                            </div>
                                                        </ul>
                                                    </div>

                                                    <br />
                                                    <h6 class="block text-ellipsis m-b-15">
                                                        <span class="text-xs">Status:</span> <span class="text-muted"><?php echo $project_status; ?></span>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <span class="text-xs">Priority:</span> <span class="text-muted"><?php echo $project_priority; ?></span>
                                                    </h6>
                                                </div>
                                                <div class="card-content">
                                                    <div class="card-body">
                                                        <?php echo $project_description; ?>
                                                        <div class="pro-deadline m-b-15">
                                                            <div class="sub-title">
                                                                <b>Deadline:</b>
                                                            </div>
                                                            <div class="text-muteds">
                                                                <b><?php echo date($localization_data["Date_Format"], strtotime($data_value["End_Date"])); ?></b>
                                                            </div>
                                                        </div>

                                                        <div class="project-members m-b-15"><br />
                                                            <div><b>Project Leader :</b></div>
                                                            <ul class="team-members">
                                                                <b><?php echo $full_name; ?></b>
                                                            </ul>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                <?php
                                    }
                                } ?>
                            </div>
                        </div>
                        <!-- /Projects Tab -->

                    </div>
                </div>
            </div>
        </section>
        <!-- File export table -->

    </div>
</div>

<!-- ////////////////////////////////////////////////////////////////////////////-->

<?php include("../include/footer.php"); ?>