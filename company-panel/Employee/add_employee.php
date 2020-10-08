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




        <!-- File export table -->
        <section id="row-separator-form-layouts">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="row-separator-colored-controls">Add Employee</h4>
                            <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body">

                                <form class="form form-horizontal row-separator">
                                    <div class="form-body">

                                        <input type="hidden" id="employee_id" value="<?php echo $employee_view_datas_by_id["ID"] ;?>" class="form-control">
                                        <!-- Profile Information -->
                                        <h4 class="form-section"><i class="la la-user"></i> Profile Information</h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control" for="employee_employee_id">Employee ID</label>
                                                    <div class="col-md-9">
                                                        <input type="text" id="employee_employee_id" value="<?php echo $employee_view_datas_by_id["Emp_ID"]; ?>" class="form-control border-primary required" placeholder="Enter Employee ID" name="employee_employee_id">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control" for="employee_fullname">Fullname</label>
                                                    <div class="col-md-9">
                                                        <input type="text" id="employee_fullname" value="<?php echo $employee_view_datas_by_id["First_Name"]; ?>" class="form-control border-primary required" placeholder="Enter Fullname" name="employee_fullname">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control" for="employee_lastname">Last Name</label>
                                                    <div class="col-md-9">
                                                        <input type="text" id="employee_lastname" value="<?php echo $employee_view_datas_by_id["Last_Name"]; ?>" class="form-control border-primary required" placeholder="Enter Last Name" name="employee_lastname">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control" for="employee_date_of_birth">Date of Birth</label>
                                                    <div class="col-md-9">
                                                        <input type="date" id="employee_date_of_birth" value="<?php echo $employee_view_datas_by_id["DOB"]; ?>" class="form-control border-primary required" placeholder="Enter Date of Birth" name="employee_date_of_birth">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control" for="employee_gender">Gender</label>
                                                    <div class="col-md-9">
                                                        <select class="select2 form-control border-primary" id="employee_gender" style="width: 100%;">
                                                            <option disabled selected>Select Employee Gender</option>
                                                            <option <?php echo $employee_view_datas_by_id["Gender"] == 'Male' ? 'selected' : ''; ?> value="Male">Male</option>
                                                            <option <?php echo $employee_view_datas_by_id["Gender"] == 'Female' ? 'selected' : ''; ?> value="Female">Female</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control" for="employee_phone_number">Phone Number</label>
                                                    <div class="col-md-9">
                                                        <input type="text" id="employee_phone_number" value="<?php echo $employee_view_datas_by_id["Phone_Number"]; ?>" class="form-control border-primary required" placeholder="Enter Phone Number" name="employee_phone_number">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control" for="employee_branch">Branch</label>
                                                    <div class="col-md-9">
                                                        <select class="select2 form-control border-primary" id="employee_branch" style="width: 100%;">
                                                            <option disabled selected>Select Employee Branch</option>
                                                            <?php
                                                            foreach ($branch_datas as $key => $branch_data) {
                                                            ?>
                                                                <option <?php echo $employee_view_datas_by_id["Branch"] == $branch_data["ID"] ? 'selected' : ''; ?> value="<?php echo $branch_data["ID"]; ?>"><?php echo $branch_data["Branch_Name"]; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control" for="employee_department">Department</label>
                                                    <div class="col-md-9">
                                                        <select class="select2 form-control border-primary" id="employee_department" style="width: 100%;">
                                                            <option disabled selected>Select Employee Department</option>
                                                            <?php
                                                            foreach ($department_datas as $key => $department_data) {
                                                            ?>
                                                                <option <?php echo $employee_view_datas_by_id["Department"] == $department_data["ID"] ? 'selected' : ''; ?> value="<?php echo $department_data["ID"]; ?>"><?php echo $department_data["Department_Name"]; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control" for="employee_position">Position</label>
                                                    <div class="col-md-9">
                                                        <input type="text" id="employee_position" value="<?php echo $employee_view_datas_by_id["Position"]; ?>" class="form-control border-primary required" placeholder="Enter Position" name="employee_position">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control" for="employee_hiring_date">Hiring Date</label>
                                                    <div class="col-md-9">
                                                        <input type="date" id="employee_hiring_date" value="<?php echo $employee_view_datas_by_id["HireDate"]; ?>" class="form-control border-primary required" placeholder="Enter Hiring Date" name="employee_hiring_date">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row last">
                                                    <label class="col-md-3 label-control" for="employee_address">Address</label>
                                                    <div class="col-md-9">
                                                        <textarea id="employee_address" rows="1" class="form-control border-primary required" name="employee_address" placeholder="Address"><?php echo $employee_view_datas_by_id["Address"]; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>



                                        <!-- Personal Informations -->
                                        <h4 class="form-section"><i class="la la-clone"></i> Personal Informations </h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control" for="employee_license">Employee License</label>
                                                    <div class="col-md-9">
                                                        <input class="form-control border-primary required" value="<?php echo $employee_view_datas_by_id["License"]; ?>" type="text" placeholder="Employee Type of License" id="employee_license">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control" for="employee_marital_status">Marital Civil Status</label>
                                                    <div class="col-md-9">
                                                        <select class="select2 form-control border-primary" id="employee_marital_status" style="width: 100%;">
                                                            <option disabled selected>Select Marital Civil Status</option>
                                                            <?php
                                                            foreach ($marital_status_datas as $key => $marital_status_data) {
                                                            ?>
                                                                <option <?php echo $employee_view_datas_by_id["Marital"] == $marital_status_data["ID"] ? 'selected' : ''; ?> value="<?php echo $marital_status_data["ID"]; ?>"><?php echo $marital_status_data["Married_Name"]; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control" for="employee_country">Country</label>
                                                    <div class="col-md-9">
                                                        <select class="select2 form-control border-primary" id="employee_country" style="width: 100%;">
                                                            <option disabled selected>Select Employee Country</option>
                                                            <?php
                                                            foreach ($countries_datas as $key => $countries_data) {
                                                            ?>
                                                                <option <?php echo $employee_view_datas_by_id["Nationality"] == $countries_data["name"] ? 'selected' : ''; ?> value="<?php echo $countries_data["id"]; ?>"><?php echo $countries_data["name"]; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control" for="employee_state">State</label>
                                                    <div class="col-md-9">
                                                        <select class="select2 form-control border-primary employee_state" id="employee_state" style="width: 100%;">
                                                            <option disabled selected>Select Employee Country First</option>
                                                            <option selected value="<?php echo $employee_view_datas_by_id["City"]; ?>"><?php echo $employee_view_datas_by_id["City"]; ?></option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control" for="employee_religion">Religion</label>
                                                    <div class="col-md-9">
                                                        <select class="select2 form-control border-primary" id="employee_religion" style="width: 100%;">
                                                            <option disabled selected>Select Employee Religion</option>
                                                            <option <?php echo $employee_view_datas_by_id["Religion"] == 'Muslim' ? 'selected' : ''; ?> value="Muslim">Muslim</option>
                                                            <option <?php echo $employee_view_datas_by_id["Religion"] == 'Christian' ? 'selected' : ''; ?> value="Christian">Christian</option>
                                                            <option <?php echo $employee_view_datas_by_id["Religion"] == 'Hindu' ? 'selected' : ''; ?> value="Hindu">Hindu</option>
                                                            <option <?php echo $employee_view_datas_by_id["Religion"] == 'Other' ? 'selected' : ''; ?> value="Other">Other</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control" for="employee_no_of_children">No. of Children</label>
                                                    <div class="col-md-9">
                                                        <select class="select2 form-control border-primary" id="employee_no_of_children" style="width: 100%;">
                                                            <option disabled selected>Select No. of Children</option>
                                                            <?php
                                                            foreach ($family_datas as $key => $family_data) {
                                                            ?>
                                                                <option <?php echo $employee_view_datas_by_id["Kids"] == $family_data["ID"] ? 'selected' : ''; ?> value="<?php echo $family_data["ID"]; ?>"><?php echo $family_data["Kids_Num"] > 1 ? $family_data["Kids_Num"] . ' Kids' : $family_data["Kids_Num"] . ' Kid'; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- Emergency Contact -->
                                        <h4 class="form-section"><i class="la la-phone"></i> Emergency Contact </h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="primary">Primary Contact</label>
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control" for="emergency_primary_name">Name</label>
                                                    <div class="col-md-9">
                                                        <input class="form-control border-primary required" value="<?php echo $employee_view_datas_by_id["Emergency_Primary_Name"]; ?>" type="text" placeholder="Name" id="emergency_primary_name">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control" for="emergency_primary_relationship">Relationship</label>
                                                    <div class="col-md-9">
                                                        <input class="form-control border-primary required" value="<?php echo $employee_view_datas_by_id["Emergency_Primary_Relationship"]; ?>" type="text" placeholder="Relationship" id="emergency_primary_relationship">
                                                    </div>
                                                </div>
                                                <div class="form-group row last">
                                                    <label class="col-md-3 label-control" for="emergency_primary_contact">Contact Number</label>
                                                    <div class="col-md-9">
                                                        <input class="form-control border-primary required" value="<?php echo $employee_view_datas_by_id["Emergency_Primary_Contact"]; ?>" type="text" placeholder="Contact Number" id="emergency_primary_contact">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="danger">Secondary Contact</label>
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control" for="emergency_secondary_name">Name</label>
                                                    <div class="col-md-9">
                                                        <input class="form-control border-primary" value="<?php echo $employee_view_datas_by_id["Emergency_Secondary_Name"]; ?>" type="text" placeholder="Name" id="emergency_secondary_name">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control" for="emergency_secondary_relationship">Relationship</label>
                                                    <div class="col-md-9">
                                                        <input class="form-control border-primary" value="<?php echo $employee_view_datas_by_id["Emergency_Secondary_Relationship"]; ?>" type="text" placeholder="Relationship" id="emergency_secondary_relationship">
                                                    </div>
                                                </div>
                                                <div class="form-group row last">
                                                    <label class="col-md-3 label-control" for="emergency_secondary_contact">Contact Number</label>
                                                    <div class="col-md-9">
                                                        <input class="form-control border-primary" value="<?php echo $employee_view_datas_by_id["Emergency_Secondary_Contact"]; ?>" type="text" placeholder="Contact Number" id="emergency_secondary_contact">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- Bank information -->
                                        <h4 class="form-section"><i class="la la-bank"></i> Bank information </h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control" for="employee_bank_name">Bank Name</label>
                                                    <div class="col-md-9">
                                                        <input class="form-control border-primary required" value="<?php echo $employee_view_datas_by_id["Bank_Name"]; ?>" type="text" placeholder="Bank Name" id="employee_bank_name">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control" for="employee_account_number">Bank Account Number</label>
                                                    <div class="col-md-9">
                                                        <input class="form-control border-primary required" value="<?php echo $employee_view_datas_by_id["Account_Number"]; ?>" type="text" placeholder="Bank Account Number" id="employee_account_number">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- Manage Deductions -->
                                        <h4 class="form-section"><i class="la la-money"></i> Manage Deductions </h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control" for="employee_social_security_per">Social Security Percentage</label>
                                                    <div class="col-md-9">
                                                        <select class="select2 form-control border-primary" id="employee_social_security_per" style="width: 100%;">
                                                            <option disabled selected>Select Social Security Percentage</option>
                                                            <?php
                                                            foreach ($social_security_datas as $key => $social_security_data) {
                                                            ?>
                                                                <option <?php echo $employee_view_datas_by_id["Social_Security"] == $social_security_data["ID"] ? 'selected' : ''; ?> value="<?php echo $social_security_data["ID"]; ?>"><?php echo $social_security_data["Sos_Code"]; ?> (<?php echo $social_security_data["Rate"]; ?>%)</option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control" for="employee_association_per">Association Percentage</label>
                                                    <div class="col-md-9">
                                                        <select class="select2 form-control border-primary" id="employee_association_per" style="width: 100%;">
                                                            <option disabled selected>Select Association Percentage</option>
                                                            <?php
                                                            foreach ($association_datas as $key => $association_data) {
                                                            ?>
                                                                <option <?php echo $employee_view_datas_by_id["Association"] == $association_data["ID"] ? 'selected' : ''; ?> value="<?php echo $association_data["ID"]; ?>"><?php echo $association_data["Association_Code"]; ?> (<?php echo $association_data["Association_Rate"]; ?>%)</option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control" for="employee_annual_vacation_day">Annual Vacation Days</label>
                                                    <div class="col-md-9">
                                                        <select class="select2 form-control border-primary" id="employee_annual_vacation_day" style="width: 100%;">
                                                            <option disabled selected>Select Annual Vacation Days</option>
                                                            <?php
                                                            foreach ($vacation_datas as $key => $vacation_data) {
                                                            ?>
                                                                <option <?php echo $employee_view_datas_by_id["Vacation"] == $vacation_data["ID"] ? 'selected' : ''; ?> value="<?php echo $vacation_data["ID"]; ?>"><?php echo $vacation_data["Vacation_Name"]; ?> (<?php echo $vacation_data["Vacation_Day"] > 1 ? $vacation_data["Vacation_Day"] . ' Days' : $vacation_data["Vacation_Day"] . ' Day'; ?>)</option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- Basic Salary Information-->
                                        <h4 class="form-section"><i class="la la-credit-card"></i> Basic Salary Information </h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control" for="employee_payment_type">Payment Type</label>
                                                    <div class="col-md-9">
                                                        <select class="select2 form-control border-primary" id="employee_payment_type" style="width: 100%;">
                                                            <option disabled selected>Select Payment Type</option>
                                                            <option <?php echo $employee_view_datas_by_id["Payment_Type"] == '30' ? 'selected' : ''; ?> value="30">Monthly</option>
                                                            <option <?php echo $employee_view_datas_by_id["Payment_Type"] == '15' ? 'selected' : ''; ?> value="15">Semi Monthly</option>
                                                            <option <?php echo $employee_view_datas_by_id["Payment_Type"] == '7' ? 'selected' : ''; ?> value="7">Weekly</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control" for="employee_currency_type">Currency</label>
                                                    <div class="col-md-9">
                                                        <select class="select2 form-control border-primary" id="employee_currency_type" style="width: 100%;">
                                                            <option disabled selected>Select Currency</option>
                                                            <?php
                                                            foreach ($currency_datas as $key => $currency_data) {
                                                            ?>
                                                                <option <?php echo $employee_view_datas_by_id["Currency"] == $currency_data["ID"] ? 'selected' : ''; ?> value="<?php echo $currency_data["ID"]; ?>"><?php echo $currency_data["Currency_Name"]; ?> (<?php echo $currency_data["Currency_Code"] . ' ' . $currency_data["Currency_Symbol"]; ?>)</option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control" for="employee_monthly_salary">Monthly Salary</label>
                                                    <div class="col-md-9">
                                                        <input class="form-control border-primary number_only required" value="<?php echo $employee_view_datas_by_id["Salary"]; ?>" type="text" placeholder="Monthly Salary" id="employee_monthly_salary">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- Other Information-->
                                        <h4 class="form-section"><i class="la la-eye"></i> Other Information </h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control" for="employee_email_address">Email Address</label>
                                                    <div class="col-md-9">
                                                        <input class="form-control border-primary required" value="<?php echo $employee_view_datas_by_id["Email"]; ?>" type="email" placeholder="Email Address" id="employee_email_address">
                                                    </div>
                                                </div>
                                            </div>
                                            <?php 
                                            if(empty(Classes_Inputs::get('employee_id'))){?>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control" for="employee_password">Employee Password</label>
                                                    <div class="col-md-9">
                                                        <input class="form-control border-primary required" type="password" placeholder="Employee Password" id="employee_password">
                                                    </div>
                                                </div>
                                            </div>
                                            <?php }?>
                                        </div>


                                        <div class="form-group row">
                                            <label class="col-md-3 label-control">Select Employee Image</label>
                                            <div class="col-md-9">
                                                <label id="projectinput8" class="file center-block">
                                                    <input type="file" class="form-control" id="employee_image">
                                                    <span class="file-custom"></span>
                                                </label>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="form-actions right">
                                        <button type="button" onclick="location.href='<?php echo $result['Web_Url']; ?>/employee-list'" class="btn btn-warning mr-1">
                                            <i class="la la-remove"></i> Cancel
                                        </button>
                                        <button type="button" id="add_employee_btn" class="btn btn-primary">
                                            <i class="la la-save"></i><?php if(empty(Classes_Inputs::get('employee_id'))){?> Add Employee <?php } else { ?> Update Employee <?php }?> 
                                        </button>
                                    </div>
                                </form>
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