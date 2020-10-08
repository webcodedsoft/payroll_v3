<?php include("../include/header.php"); ?>






    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
                <h3 class="content-header-title mb-0 d-inline-block">Contacts</h3>
                <div class="row breadcrumbs-top d-inline-block">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo $result["Web_Url"]; ?>dashboard">Home</a>
                            </li>
                            <li class="breadcrumb-item"><a href="#">Users</a>
                            </li>
                            <li class="breadcrumb-item active">Contacts
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="content-header-right col-md-6 col-12">
                <div class="dropdown float-md-right">
                    <button class="btn btn-danger dropdown-toggle round btn-glow px-2" id="dropdownBreadcrumbButton" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>
                    <div class="dropdown-menu" aria-labelledby="dropdownBreadcrumbButton"><a class="dropdown-item" href="#"><i class="la la-calendar-check-o"></i> Calender</a>
                        <a class="dropdown-item" href="#"><i class="la la-cart-plus"></i> Cart</a>
                        <a class="dropdown-item" href="#"><i class="la la-life-ring"></i> Support</a>
                        <div class="dropdown-divider"></div><a class="dropdown-item" href="#"><i class="la la-cog"></i> Settings</a>
                    </div>
                </div>
            </div>
        </div>


        <section class="flexbox-container">
            <div class="col-12 d-flex align-items-center justify-content-center">
                <div class="col-md-12 col-10 box-shadow-2 p-0">
                    <div class="card border-grey border-lighten-3 px-1 py-1 m-0">
                        <div class="card-header border-0 pb-0">

                            <div class="card-title text-center">
                                <img style="width: 100px; height:100px;" src="<?php echo $result["Web_Url"]; ?>Folders/Company_Folders/<?php echo $company_data_f["Subscriber_ID"]; ?>/Logo/<?php echo $company_data_f["Company_Logo"]; ?>">
                            </div>
                        </div>
                        <div class="card-content">
                            <br />
                            <span>
                                <center>
                                    <h3><b>Company Settings</b></h3>
                                </center>
                            </span>
                            <p class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1"></p>
                            <div class="form-body">

                                <form action="">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="projectinput1">Enter Company Name</label>
                                                <input type="text" class="form-control" id="company_name" value="<?php echo $company_data_f["Company_Name"]; ?>" placeholder="Enter Company Name" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="projectinput2">Enter Company Email Address</label>
                                                <input type="email" class="form-control" value="<?php echo $company_data_f["Company_Email"]; ?>" id="company_email" placeholder="Enter Company Email Address" required>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="projectinput2">Enter Company ID Number</label>
                                                <input type="text" class="form-control number_only" id="company_id" value="<?php echo $company_data_f["Company_ID"]; ?>" placeholder="Enter Company ID Number" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="projectinput1">Enter Company Phone Number</label>
                                                <input type="text" class="form-control" id="company_phone_number" value="<?php echo $company_data_f["Company_Phone"]; ?>" placeholder="Enter Company Phone Number" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="projectinput2">Enter Company Website Address</label>
                                                <input type="text" class="form-control" id="company_website" value="<?php echo $company_data_f["Company_Website"]; ?>" placeholder="Enter Company Website Address" required>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="projectinput2">Enter Company Report Header</label>
                                                <input type="text" class="form-control" id="company_header_report" value="<?php echo $company_data_f["Company_Header"]; ?>" placeholder="Enter Company Report Header" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="projectinput1">Enter Company Authorize Signature Name</label>
                                                <input type="text" class="form-control" id="authorize_signature_name" value="<?php echo $company_data_f["Company_Sign_Name"]; ?>" placeholder="Enter Company Authorize Signature Name" required>
                                            </div>

                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="projectinput2">Enter Company Authorize Signature Position</label>
                                                <input type="text" class="form-control" id="authorize_signature_position" value="<?php echo $company_data_f["Company_Sign_Position"]; ?>" placeholder="Enter Company Authorize Signature Position" required>
                                            </div>

                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="projectinput2">Enter Company Address</label>
                                                <textarea class="form-control" rows="5" id="company_address" placeholder="Enter Company Address"><?php echo $company_data_f["Company_Address"]; ?></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Select Company Logo</label>
                                        <label id="projectinput7" class="file center-block">
                                            <input type="file" class="form-control company_logo" id="company_logo">
                                            <span class="file-custom"></span>
                                        </label>
                                    </div>


                                    <div class="card-body">
                                        <button type="button" id="company_setting_btn" class="btn btn-outline-info btn-block"><i class='ft-save'></i> Save Changes</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        </section>


    </div>


<?php include("../include/footer.php"); ?>