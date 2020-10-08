<!-- Create Role Model Model -->
<div class="modal fade text-left" data-backdrop="false" id="create_role" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title text-text-bold-600" id="role_model" data-i18n="">Add Role</label>
                <button type="button" class="close" data-dismiss="modal" id="create_role_btn_close" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form">
                <div class="modal-body">
                    <div class="form-group">
                        <label data-i18n="role_name">Role Name: </label>
                        <input type="text" require placeholder="Role Name" id="role_name" name="role_name" class="form-control">
                        <input type="hidden" id="role_id" name="role_id" class="form-control">

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="reset" id="create_role_btn_close" class="btn btn-outline-danger round  mr-1 mb-1" data-i18n="" data-dismiss="modal">Close</button>
                    <button type="button" id="create_role_btn" class="btn btn-success round  mr-1 mb-1 edit_role_btn" data-i18n=""> <i class="la la-save"></i> Add Role</button>

                </div>
            </form>
        </div>
    </div>
</div>

<!-- Create Users Model -->
<div class="modal fade text-left" data-backdrop="false" id="create_user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title text-text-bold-600" id="myModalLabel33" data-i18n="">Add User</label>
                <button type="button" class="close" id="user_popup_close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label data-i18n="">First Name: </label>
                            <div class="form-group">
                                <input type="text" require placeholder="First Name" id="first_name" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label data-i18n="">Last Name: </label>
                            <div class="form-group">
                                <input type="text" require placeholder="Last Name" id="last_name" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label data-i18n="">Username: </label>
                            <div class="form-group">
                                <div class="form-group">
                                    <input type="text" require placeholder="Username" id="username" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label data-i18n="">Email: </label>
                            <div class="form-group">
                                <div class="form-group">
                                    <input type="text" require placeholder="Email Address" id="email" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="edit_hide">
                        <div class="col-md-6">
                            <label data-i18n="">Password: </label>
                            <div class="form-group">
                                <div class="form-group">
                                    <input type="password" require placeholder="Password" id="password" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label data-i18n="">Confirm Password: </label>
                            <div class="form-group">
                                <div class="form-group">
                                    <input type="password" require placeholder="Confirm Password" id="confirm_password" class="form-control">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label data-i18n="">Phone Number: </label>
                            <div class="form-group">
                                <div class="form-group">
                                    <input type="text" require placeholder="Phone Number" id="phone_number" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label data-i18n="">Access Permission: </label>
                            <div class="form-group">
                                <select class="select2 form-control" id="access_permission" style="width: 100%;">
                                    <option disabled selected>Select User Access Permission</option>
                                    <?php
                                    foreach ($role_permission_data as $key => $role_permission_data_value) {
                                    ?>
                                        <option value="<?php echo $role_permission_data_value["Role_Name"]; ?>"><?php echo $role_permission_data_value["Role_Name"]; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <input type="hidden" id="user_id" class="form-control">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-outline-danger round  mr-1 mb-1" id="user_popup_close" data-dismiss="modal" data-i18n="">Close</button>
                    <button type="button" class="btn btn-success round  mr-1 mb-1" data-i18n="" id="user_button"><i class="la la-save"></i> Create</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Create Assets Model -->
<div class="modal fade text-left" data-backdrop="false" id="create_assets" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title text-text-bold-600" id="myModalLabel33" data-i18n="">Add Asset</label>
                <button type="button" class="close" id="assets_popup_close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label data-i18n="">Asset Name: </label>
                            <div class="form-group">
                                <input type="text" require placeholder="Asset Name" id="asset_name" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label data-i18n="">Purchase Date: </label>
                            <div class="form-group">
                                <input type="date" require placeholder="Purchase Date" id="purchase_date" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label data-i18n="">Purchase From: </label>
                            <div class="form-group">
                                <div class="form-group">
                                    <input type="text" require placeholder="Purchase From" id="purchase_from" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label data-i18n="">Manufacturer: </label>
                            <div class="form-group">
                                <div class="form-group">
                                    <input type="text" require placeholder="Manufacturer" id="manufacturer" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label data-i18n="">Model: </label>
                            <div class="form-group">
                                <div class="form-group">
                                    <input type="text" require placeholder="Model" id="model" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label data-i18n="">Serial Number: </label>
                            <div class="form-group">
                                <div class="form-group">
                                    <input type="text" require placeholder="Serial Number" id="serial_number" class="form-control">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label data-i18n="">Supplier: </label>
                            <div class="form-group">
                                <div class="form-group">
                                    <input type="text" require placeholder="Supplier" id="supplier" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label data-i18n="">Condition: </label>
                            <div class="form-group">
                                <div class="form-group">
                                    <input type="text" require placeholder="Condition" id="condition" class="form-control">
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="asset_id" class="form-control">
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <label data-i18n="">Warranty: </label>
                            <div class="form-group">
                                <div class="form-group">
                                    <input type="text" require placeholder="Warranty" id="warranty" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label data-i18n="">Amount: </label>
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><?php echo $localization_data["Currency_Symbol"]; ?></span>
                                </div>
                                <input type="text" require class="form-control" placeholder="Amount" id="amount" aria-describedby="basic-addon1">
                            </div>
                        </div>

                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <label data-i18n="">Description: </label>
                            <div class="form-group">
                                <div class="form-group">
                                    <textarea type="text" require placeholder="Description" id="description" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label data-i18n="">Status: </label>
                            <div class="form-group">
                                <div class="form-group">
                                    <select class="select2 form-control" id="status" style="width: 100%;">
                                        <option disabled selected>Select Asset Status</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Approve">Approve</option>
                                        <option value="Deployed">Deployed</option>
                                        <option value="Damaged">Damaged</option>
                                    </select> </div>
                            </div>
                        </div>

                    </div>


                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-outline-danger round  mr-1 mb-1" id="assets_popup_close" data-dismiss="modal" data-i18n="">Close</button>
                    <button type="button" class="btn btn-success round  mr-1 mb-1" data-i18n="" id="assets_button"><i class="la la-save"></i> Create</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Create Clients Model -->
<div class="modal fade text-left" data-backdrop="false" id="create_client" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title text-text-bold-600" id="myModalLabel33" data-i18n="">Add Client</label>
                <button type="button" class="close" id="client_popup_close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label data-i18n="">Company Name: </label>
                            <div class="form-group">
                                <input type="text" require placeholder="Company Name" id="company_name" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label data-i18n="">Contact Person: </label>
                            <div class="form-group">
                                <input type="text" require placeholder="Contact Person" id="contact_person" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label data-i18n="">Address: </label>
                            <div class="form-group">
                                <div class="form-group">
                                    <input type="text" require placeholder="Address" id="address" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label data-i18n="">Email: </label>
                            <div class="form-group">
                                <div class="form-group">
                                    <input type="text" require placeholder="Email Address" id="email_address" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="edit_hide">
                        <div class="col-md-6">
                            <label data-i18n="">Phone Number: </label>
                            <div class="form-group">
                                <div class="form-group">
                                    <input type="text" require placeholder="Phone Number" id="client_phone_number" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label data-i18n="">Status: </label>
                            <div class="form-group">
                                <label class="switch"><input type="checkbox" id="client_status" value="Active"><span class="switch-button"></span> </label>
                            </div>


                        </div>
                    </div>


                    <input type="hidden" id="client_id" class="form-control">

                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-outline-danger round  mr-1 mb-1" id="client_popup_close" data-dismiss="modal" data-i18n="">Close</button>
                    <button type="button" class="btn btn-success round  mr-1 mb-1" data-i18n="" id="client_button"><i class="la la-save"></i> Create</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Create Project Model -->
<div class="modal fade text-left" data-backdrop="false" id="create_project" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title text-text-bold-600" id="myModalLabel33" data-i18n="">Create Project</label>
                <button type="button" class="close" id="project_popup_close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label data-i18n="">Project Name: </label>
                            <div class="form-group">
                                <input type="text" require placeholder="Project Name" id="project_name" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label data-i18n="">Client: </label>
                            <div class="form-group">
                                <select class="select2 form-control" id="project_client" style="width: 100%;">
                                    <option disabled selected>Select Rate Type</option>
                                    <?php
                                    foreach ($client_datas as $key => $client_data) {
                                    ?>
                                        <option value="<?php echo $client_data["Client_ID"]; ?>"><?php echo $client_data["Company_Name"]; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label data-i18n="">Start Date: </label>
                            <div class="form-group">
                                <div class="form-group">
                                    <input type="date" require placeholder="Start Date" id="project_start_date" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label data-i18n="">End Date: </label>
                            <div class="form-group">
                                <div class="form-group">
                                    <input type="date" require placeholder="End Date" id="project_end_date" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label data-i18n="">Rate: </label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><?php echo $localization_data["Currency_Symbol"]; ?></span>
                                        </div>
                                        <input type="text" require class="form-control" placeholder="Rate" id="project_rate" aria-describedby="basic-addon1">
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="select2 form-control" id="project_rate_type" style="width: 100%;">
                                            <option disabled selected>Select Rate Type</option>
                                            <option value="Fixed">Fixed</option>
                                            <option value="Hourly">Hourly</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label data-i18n="">Priority: </label>
                            <div class="form-group">
                                <div class="form-group">
                                    <select class="select2 form-control" id="project_priority" style="width: 100%;">
                                        <option disabled selected>Select Project Priority</option>
                                        <option value="High">High</option>
                                        <option value="Medium">Medium</option>
                                        <option value="Low">Low</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label data-i18n="">Add Project Leader: </label>
                            <div class="form-group">
                                <div class="form-group">
                                    <select class="select2 form-control" id="project_leader" style="width: 100%;">
                                        <option disabled selected>Select Project Leader</option>
                                        <?php
                                        foreach ($employee_datas as $key => $employee_data) {
                                            $department_results_pro = $data_connect->DepartmentDataByID($employee_data["Department"])->first();

                                        ?>
                                            <option value="<?php echo $employee_data["Employee_ID"]; ?>"><?php echo $employee_data["First_Name"] . " " . $employee_data["Last_Name"]; ?> { <?php echo $department_results_pro["Department_Name"]; ?> }</option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label data-i18n="">Status: </label>
                            <div class="form-group">
                                <div class="form-group">
                                    <select class="select2 form-control" id="project_status" style="width: 100%;">
                                        <option disabled selected>Select Project Status</option>
                                        <option value="Active">Active</option>
                                        <option value="Complete">Complete</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>



                        <div class="col-md-12">
                            <label data-i18n="">Description: </label>
                            <div class="form-group">
                                <div class="form-group">
                                    <textarea type="text" rows="5" require placeholder="Description" id="project_description" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="project_id" class="form-control">
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Upload Files</label>
                                <label id="projectinput7" class="file center-block">
                                    <input type="file" class="form-control project_file" multiple id="project_file">
                                    <span class="file-custom"></span>
                                </label>
                            </div>
                        </div>
                    </div>


                    <div class="modal-footer">
                        <button type="reset" class="btn btn-outline-danger round  mr-1 mb-1" id="project_popup_close" data-dismiss="modal" data-i18n="">Close</button>
                        <button type="button" class="btn btn-success round  mr-1 mb-1" data-i18n="" id="project_button"><i class="la la-save"></i> Create</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Create Branch Model-->
<div class="modal fade text-left" data-backdrop="false" id="add_branch" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title text-text-bold-600" id="branch_title" data-i18n="add_branch">Add Branch</label>
                <button type="button" class="close" id="branch_close_btn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#">
                <input type="hidden" id="branch_id" name="">

                <div class="modal-body">
                    <div class="row col-md-12">
                        <div class="col-md-6">
                            <label data-i18n="branch_name">Branch Name </label>
                            <div class="form-group">
                                <input type="text" id="branch_name" placeholder="Enter Branch Name" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label data-i18n="email">Email </label>
                            <div class="form-group">
                                <input type="text" id="branch_email" placeholder="Enter Branch Email" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label data-i18n="telephone1">Telephone 1 </label>
                            <div class="form-group">
                                <input type="text" id="telephone1" placeholder="Enter Branch Telephone 1" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label data-i18n="telephone2">Telephone 2 </label>
                            <div class="form-group">
                                <input type="text" id="telephone2" placeholder="Enter Branch Telephone 2" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label data-i18n="address">Address </label>
                            <div class="form-group">
                                <textarea class="form-control" rows="2" id="branch_address" placeholder="Enter Branch Address"></textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label data-i18n="">Status: </label>
                            <div class="form-group">
                                <label class="switch"><input type="checkbox" id="branch_status" value="Active"><span class="switch-button"></span> </label>
                            </div>
                        </div>

                    </div>


                </div>

                <div class="modal-footer">
                    <button type="reset" class="btn btn-outline-danger round  mr-1 mb-1" id="branch_close_btn" data-i18n="close_btn" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success round  mr-1 mb-1" id="branch_submit_btn" data-i18n="submit_btn"><i class="la la-save"></i> Create</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Create Department Model -->
<div class="modal fade text-left" data-backdrop="false" id="add_department" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title text-text-bold-600" id="department_title" data-i18n="add_department">Add Department</label>
                <button type="button" class="close" id="department_close_btn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#">
                <input type="hidden" id="department_id" name="">

                <div class="modal-body">
                    <label data-i18n="department_name">Department Name </label>
                    <div class="form-group">
                        <input type="text" id="department_name" placeholder="Enter Department Name" class="form-control">
                    </div>
                    <label data-i18n="department_desc">Department Description </label>
                    <div class="form-group">
                        <textarea class="form-control" rows="3" id="department_desc" placeholder="Enter Department Description"></textarea>
                    </div>

                    <label data-i18n="">Status: </label>
                    <div class="form-group">
                        <label class="switch"><input type="checkbox" id="department_status" value="Active"><span class="switch-button"></span> </label>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="reset" class="btn btn-outline-danger round  mr-1 mb-1" id="department_close_btn" data-i18n="close_btn" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success round  mr-1 mb-1" id="department_submit_btn" data-i18n="submit_btn"><i class="la la-save"></i> Create</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Edit Journal Model -->
<div class="modal fade text-left" id="edit_journal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title text-text-bold-600" id="myModalLabel33" data-i18n="add_journal">Edit Journal</label>
                <button type="button" class="close" id="journal_close_btn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#">
                <input type="hidden" id="journal_id" name="">

                <div class="modal-body">

                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th style="color: black">Accounting Name</th>
                                    <th style="color: black">Accounting Code</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                $accounting_codes = $journal_datas["Accounting_Code"];
                                $accounting_name = $journal_datas["Accounting_Name"];

                                //var_dump($accounting_codes);
                                $accounting_codes = explode(",", $accounting_codes);
                                $accounting_name = explode(",", $accounting_name);


                                foreach ($accounting_codes as $key => $accounting_code) {

                                    //$journal_id = $journal_data['ID'];
                                    //$accounting_code = $journal_data['Accounting_Code'];
                                    //$accounting_name = $accounting_name[$key];
                                ?>
                                    <tr>
                                        <div class="row col-md-12">
                                            <div class="col-md-6">
                                                <td><label data-i18n="<?php echo "$accounting_name[$key]"; ?>"><?php echo "$accounting_name[$key]"; ?> </label></td>
                                            </div>

                                            <div class="col-md-6">
                                                <td>
                                                    <div class="form-group">
                                                        <input type="text" id="<?php echo "$accounting_code"; ?>" value="<?php echo "$accounting_code"; ?>" name="accounting_code" placeholder="Enter <?php echo "$accounting_name[$key]"; ?> Code" class="form-control accounting_code">
                                                    </div>
                                                </td>
                                            </div>
                                        </div>

                                    </tr>

                                    <input type="checkbox" hidden checked id="journal_id" name="journal_id" class="journal_id" value="<?php echo "$journal_id"; ?>">


                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-outline-danger round  mr-1 mb-1" id="journal_close_btn" data-i18n="close_btn" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success round  mr-1 mb-1" id="journal_submit_btn" data-i18n="submit_btn"><i class="la la-save"></i> Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Create Salary & Tax Model -->
<div class="modal fade text-left" data-backdrop="false" id="add_salary_tax" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title text-text-bold-600" data-i18n="add_salary_tax_rate" id="salary_title">Add Salary Tax</label>
                <button type="button" class="close" id="salary_tax_close_btn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#">
                <input type="hidden" id="salary_id" name="">

                <div class="modal-body">
                    <label data-i18n="salary_range1">Salary Range From:* </label>
                    <div class="form-group">
                        <input type="text" data-i18n="salary_amount_from_placeholder" id="salary_from" placeholder="Enter Salary Amount From" class="form-control">
                    </div>
                    <label data-i18n="salary_range2">Salary Range To:* </label>
                    <div class="form-group">
                        <input type="text" data-i18n="salary_amount_to_placeholder" id="salary_to" placeholder="Enter Salary Amount To" class="form-control">
                    </div>
                    <label data-i18n="tax_rate">Tax Rate %:* </label>
                    <div class="form-group">
                        <input type="text" data-i18n="tax_rate_placeholder" id="tax_rate" placeholder="Enter Tax Rate" class="form-control">
                    </div>

                    <label data-i18n="">Status: </label>
                    <div class="form-group">
                        <label class="switch"><input type="checkbox" id="salary_status" value="Active"><span class="switch-button"></span> </label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="reset" class="btn btn-outline-danger round  mr-1 mb-1" id="salary_tax_close_btn" data-i18n="close_btn" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success round  mr-1 mb-1" id="salary_tax_submit_btn" data-i18n="submit_btn"><i class="la la-save"></i> Add Salary Tax</button>
                </div>

            </form>
        </div>
    </div>
</div>


<!-- Create Social Security Model -->
<div class="modal fade text-left" data-backdrop="false" id="add_social_security" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title text-text-bold-600" id="social_security_title" data-i18n="add_social_security">Add Social Security</label>
                <button type="button" class="close" id="social_close_btn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#">
                <input type="hidden" id="sos_id" name="">

                <div class="modal-body">
                    <label data-i18n="sos_code">Sos Code:* </label>
                    <div class="form-group">
                        <input type="text" id="sos_code" placeholder="Enter Social Security Code" class="form-control">
                    </div>
                    <label data-i18n="sos_rate">Sos Rate %: </label>
                    <div class="form-group">
                        <input type="text" id="sos_rate" placeholder="Enter Social Security Rate" class="form-control">
                    </div>

                    <label data-i18n="">Status: </label>
                    <div class="form-group">
                        <label class="switch"><input type="checkbox" id="social_status" value="Active"><span class="switch-button"></span> </label>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-outline-danger round  mr-1 mb-1" id="social_close_btn" data-i18n="close_btn" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success round  mr-1 mb-1" id="social_submit_btn" data-i18n="submit_btn"><i class="la la-save"></i> Add Social Security</button>
                </div>

            </form>
        </div>
    </div>
</div>


<!-- Create Association Model -->
<div class="modal fade text-left" data-backdrop="false" id="add_association" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title text-text-bold-600" id="association_title" data-i18n="add_association">Add Association</label>
                <button type="button" class="close" id="association_close_btn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#">
                <input type="hidden" id="association_id" name="">

                <div class="modal-body">
                    <label data-i18n="association_code">Association Code:* </label>
                    <div class="form-group">
                        <input type="text" id="association_code" placeholder="Enter Association Code" class="form-control">
                    </div>
                    <label data-i18n="association_rate">Association Rate %: </label>
                    <div class="form-group">
                        <input type="text" id="association_rate" placeholder="Enter Association Rate" class="form-control">
                    </div>
                    <label data-i18n="">Status: </label>
                    <div class="form-group">
                        <label class="switch"><input type="checkbox" id="association_status" value="Active"><span class="switch-button"></span> </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-outline-danger round  mr-1 mb-1" id="association_close_btn" data-i18n="close_btn" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success round  mr-1 mb-1" id="association_submit_btn" data-i18n="submit_btn"><i class="la la-save"></i> Add Association</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Create Currency Model -->
<div class="modal fade text-left" data-backdrop="false" id="add_currency" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title text-text-bold-600" id="currency_title" data-i18n="add_currency">Add Currency</label>
                <button type="button" class="close" id="currency_close_btn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#">
                <input type="hidden" id="currency_id" name="">

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label data-i18n="currency_country_name">Currency Country Name: </label>
                            <div class="form-group">
                                <select class="select2 form-control" id="currency_country_id" style="width: 100%;">
                                    <option selected disabled aria-selected="true" aria-disabled="true">Select Country</option>
                                    <?php
                                    foreach ($countrywithcurrency as $key => $countries) {
                                    ?>
                                        <option value="<?php echo $countries['country']; ?>" name="<?php echo $countries['ID']; ?>"><?php echo $countries['country']; ?></option>
                                    <?php
                                    }
                                    ?>

                                </select>
                            </div>
                        </div>
                    </div>


                    <label data-i18n="currency_name">Currency Name: </label>
                    <div class="form-group">
                        <input type="text" id="currency_name" readonly placeholder="Enter Currency Name" class="form-control currency_names">
                    </div>
                    <label data-i18n="currency_code">Currency Code: </label>
                    <div class="form-group">
                        <input type="text" id="currency_code" readonly placeholder="Enter Currency Code" class="form-control currency_codes">
                    </div>
                    <label data-i18n="currency_symbol">Currency Symbol: </label>
                    <div class="form-group">
                        <b class="form-control currency_symbols" readonly style="height: 40px"></b>
                        <input type="text" hidden placeholder="Enter Currency Symbol" class="form-control currency_symbol_reals">
                    </div>

                    <div class="form-group">
                        <label for="location1" data-i18n="curreny_format">Currency Type:</label>
                        <select class="select2 form-control" id="curreny_type" name="location" style="width: 100%;">
                            <option selected disabled>Select Currency Type</option>
                            <option value="Local Currency">Local Currency</option>
                            <option value="Foreign Currency">Foreign Currency</option>
                        </select>
                    </div>

                    <label data-i18n="">Status: </label>
                    <div class="form-group">
                        <label class="switch"><input type="checkbox" id="currency_status" value="Active"><span class="switch-button"></span> </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-outline-danger round  mr-1 mb-1" id="currency_close_btn" data-i18n="close_btn" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success round  mr-1 mb-1" id="currency_submit_btn" data-i18n="submit_btn"><i class="la la-save"></i> Add Currency</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Create Vacation Days Model -->
<div class="modal fade text-left" data-backdrop="false" id="add_vacation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title text-text-bold-600" id="vacation_title" data-i18n="add_vacation">Add Vacation</label>
                <button type="button" class="close" id="vacation_close_btn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#">
                <input type="hidden" id="vacation_id" name="">

                <div class="modal-body">
                    <label data-i18n="vacation_name">Vacation Name: </label>
                    <div class="form-group">
                        <input type="text" id="vacation_name" placeholder="Enter Vacation Name" class="form-control">
                    </div>
                    <label data-i18n="vacation_num_day">Number of Days: </label>
                    <div class="form-group">
                        <input type="text" id="vacation_num_day" placeholder="Enter Number of Days" class="form-control number_only">
                    </div>
                    <label data-i18n="">Status: </label>
                    <div class="form-group">
                        <label class="switch"><input type="checkbox" id="vacation_status" value="Active"><span class="switch-button"></span> </label>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-outline-danger round  mr-1 mb-1" id="vacation_close_btn" data-i18n="close_btn" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success round  mr-1 mb-1" id="vacation_submit_btn" data-i18n="submit_btn"><i class="la la-save"></i> Add Vacation</button>
                </div>

            </form>
        </div>
    </div>
</div>


<!-- Create Family Tax Model -->
<div class="modal fade text-left" data-backdrop="false" id="add_family_tax" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title text-text-bold-600" id="family_tax_title" data-i18n="add_family_tax">Add Family Tax</label>
                <button type="button" class="close" id="family_tax_close_btn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#">
                <input type="hidden" id="family_tax_id" name="">

                <div class="modal-body">
                    <label data-i18n="number_of_kids">Kids Number:* </label>
                    <div class="form-group">
                        <input type="text" id="number_of_kids" placeholder="Enter Number of Kids" class="form-control number_only">
                    </div>
                    <label data-i18n="tax_amount">Kids Tax Amount:* </label>
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><?php echo $localization_data["Currency_Symbol"]; ?></span>
                        </div>
                        <input type="text" require class="form-control number_only" placeholder="Enter Kids Tax Amount" id="tax_amount" aria-describedby="basic-addon1">
                    </div>

                    <label data-i18n="">Status: </label>
                    <div class="form-group">
                        <label class="switch"><input type="checkbox" id="family_tax_status" value="Active"><span class="switch-button"></span> </label>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-outline-danger round  mr-1 mb-1" id="family_tax_close_btn" data-i18n="close_btn" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success round  mr-1 mb-1" id="family_tax_submit_btn" data-i18n="submit_btn"><i class="la la-save"></i> Add Family Tax</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Create Marital Status Model -->
<div class="modal fade text-left" data-backdrop="false" id="add_marital_status" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title text-text-bold-600" id="marital_status_title" data-i18n="add_marital_status">Add Marital Status</label>
                <button type="button" class="close" id="marital_status_close_btn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#">
                <input type="hidden" id="marital_status_id" name="">

                <div class="modal-body">
                    <label data-i18n="status_name">Civil Status </label>
                    <div class="form-group">
                        <input type="text" id="status_name" placeholder="Enter Marital Status" class="form-control">
                    </div>
                    <label data-i18n="status_amount">Civil Status Amount </label>
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><?php echo $localization_data["Currency_Symbol"]; ?></span>
                        </div>
                        <input type="text" require class="form-control number_only" placeholder="Enter Marital Status Amount" id="status_amount" aria-describedby="basic-addon1">
                    </div>

                    <label data-i18n="">Status: </label>
                    <div class="form-group">
                        <label class="switch"><input type="checkbox" id="marital_status_status" value="Active"><span class="switch-button"></span> </label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="reset" class="btn btn-outline-danger round  mr-1 mb-1" id="marital_status_close_btn" data-i18n="close_btn" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success round  mr-1 mb-1" id="marital_status_submit_btn" data-i18n="submit_btn"><i class="la la-save"></i> Add Marital Status</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Create Leave Type Model-->
<div class="modal fade text-left" data-backdrop="false" id="add_leave_type" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title text-text-bold-600" id="leave_type_title" data-i18n="add_leave_type">Add Leave Type</label>
                <button type="button" class="close" id="leave_type_close_btn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#">
                <input type="hidden" id="leave_type_id" name="">

                <div class="modal-body">
                    <label data-i18n="leave_type">Leave Type </label>
                    <div class="form-group">
                        <input type="text" id="leave_type" placeholder="Enter Leave Type" class="form-control">
                    </div>
                    <label data-i18n="leave_type_number_of_day">Number of Days </label>
                    <div class="form-group">
                        <input type="text" id="leave_type_number_of_day" placeholder="Enter Number of Days" class="form-control number_only">
                    </div>
                    <label data-i18n="">Status: </label>
                    <div class="form-group">
                        <label class="switch"><input type="checkbox" id="leave_type_status" value="Active"><span class="switch-button"></span> </label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="reset" class="btn btn-outline-danger round  mr-1 mb-1" id="leave_type_close_btn" data-i18n="close_btn" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success round  mr-1 mb-1" id="leave_type_submit_btn" data-i18n="submit_btn"><i class="la la-save"></i> Add Leave Type</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Add Employee Leave Model -->
<div class="modal fade text-left" data-backdrop="false" id="add_employee_leave" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="add_employee_leave_title" data-i18n="add_employee_vacation">Add Employee Leave</h4>
                <button type="button" class="close" data-dismiss="modal" id="employee_leave_close_btn" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" style="color: black">

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">

                            <label for="projectinput2" data-i18n="select_employee_by_name">Select Employee By Name <span class="danger">*</span></label>
                            <select class="select2 form-control" style="width: 300px" id="employee_leave_id" name="employee_leave_id">
                                <option disabled="" selected="">Select Employee By Name</option>
                                <?php
                                foreach ($employee_datas as $key => $employee_data) {
                                ?>
                                    <option value="<?php echo $employee_data["Employee_ID"]; ?>"><?php echo $employee_data["First_Name"] . ' ' . $employee_data["Last_Name"]; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Working Days</th>
                                <th>Available Days</th>
                                <th>Leave Type</th>
                                <th>Leave Reason</th>
                                <th>Date (From - To)</th>
                            </tr>
                        </thead>
                        <tbody id="employee_leave_table">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-outline-danger round  mr-1 mb-1" id="employee_leave_close_btn" data-i18n="close_btn" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success round  mr-1 mb-1" id="employee_leave_submit_btn" data-i18n="submit_btn"><i class="la la-save"></i> Add Leave</button>
            </div>

        </div>
    </div>
</div>



<!-- Create Payroll Item Model-->
<div class="modal fade text-left" data-backdrop="false" id="add_payroll_item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title text-text-bold-600" id="payroll_item_title" data-i18n="add_payroll_item">Add Payroll Item</label>
                <button type="button" class="close" id="payroll_item_close_btn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#">
                <input type="hidden" id="payroll_item_id" name="">

                <div class="modal-body">
                    <label data-i18n="payroll_item_name">Payroll Item Name </label>
                    <div class="form-group">
                        <input type="text" id="payroll_item_name" placeholder="Enter Payroll Item Name" class="form-control">
                    </div>
                    <label data-i18n="leave_type_number_of_day">Payroll Item Amount </label>
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><?php echo $localization_data["Currency_Symbol"]; ?></span>
                        </div>
                        <input type="text" require class="form-control number_only" placeholder="Enter Payrol Item Amount" id="payroll_item_amount" aria-describedby="basic-addon1">
                    </div>

                    <label data-i18n="">Assigned to: </label>
                    <div class="row" style="margin-top: 10px;">
                        <div class="col-md-4">
                            <fieldset class="radio">
                                <label>
                                    <input type="radio" name="assigned_option" checked id="assigned_option_dont" value="Don't Assigned"> Don't Assigned
                                </label>
                            </fieldset>
                        </div>

                        <div class="col-md-4">
                            <fieldset class="radio">
                                <label>
                                    <input type="radio" name="assigned_option" id="assigned_option_all" value="All Employees"> All Employees
                                </label>
                            </fieldset>
                        </div>

                        <div class="col-md-4">
                            <fieldset class="radio">
                                <label>
                                    <input type="radio" name="assigned_option" id="assigned_option_select" value="Select Employee"> Select Employee
                                </label>
                            </fieldset>
                        </div>
                    </div>

                    <div id="assigned_option_div">
                        <label data-i18n="" style="margin-top: 10px">Select Employee: </label>
                        <div class="form-group">
                            <select class="select2 form-control" id="assigned_employee_id" style="width: 100%;">
                                <option disabled selected>Select Employee</option>
                                <?php
                                foreach ($employee_datas as $key => $employee_data) {
                                ?>
                                    <option value="<?php echo $employee_data["Employee_ID"]; ?>"><?php echo $employee_data["First_Name"] . ' ' . $employee_data["Last_Name"]; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>


                    <div class="form-group" style="margin-top: 10px">
                        <label data-i18n="">Payroll Item Date: </label>
                        <select class="select2 form-control" id="payroll_item_date" style="width: 100%;">
                            <option disabled selected>Select Payroll Item Date</option>
                            <?php
                            for ($i = date("m"); $i < 13; $i++) {
                                $i = $i > 9 ? $i :  $i == date("m") ? $i :   '0' . $i;
                            ?>
                                <option value="<?php echo $i . '-' . date("Y"); ?>"><?php echo date("F-Y", strtotime('01-' . $i . '-' . date("Y"))); ?></option>
                            <?php

                            }

                            ?>
                        </select>
                    </div>

                    <label data-i18n="" style="margin-top: 10px">Status: </label>
                    <div class="form-group">
                        <label class="switch"><input type="checkbox" id="payroll_item_status" value="Active"><span class="switch-button"></span> </label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="reset" class="btn btn-outline-danger round  mr-1 mb-1" id="payroll_item_close_btn" data-i18n="close_btn" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success round  mr-1 mb-1 payroll_item_submit_btn" id="payroll_item_submit_btn" data-i18n="payroll_item_update" data-dismiss="modal"><i class="la la-save"></i> Update Payroll Item</button>

                    <div class="btn-group mr-1 mb-1" style="margin-top: 7px" id="create_option">
                        <button type="button" class="btn btn-success round mr-1 mb-1 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="la la-save"></i> Add Payroll Item</button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item payroll_item_submit_btn" id="add_payroll_item" href="javascript:void(0)">Add</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item payroll_item_submit_btn" id="add_payroll_item_assigned" href="javascript:void(0)">Add & Assigned</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>