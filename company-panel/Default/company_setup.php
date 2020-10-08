<?php include("../include/header.php"); ?>
<br /><br />




<section class="flexbox-container">
    <div class="col-12 d-flex align-items-center justify-content-center">
        <div class="col-md-8 col-10 box-shadow-2 p-0">
            <div class="card border-grey border-lighten-3 px-1 py-1 m-0">
                <div class="card-header border-0 pb-0">

                    <div class="card-title text-center">
                        <img style="width: 150px; height:50px;" src="<?php echo $result["Web_Url"]; ?>Folders/brand/payroll.png">
                    </div>
                </div>
                <div class="card-content">
                    <br />
                    <span>
                        <center>
                            <h3><b>Company Setup</b></h3>
                        </center>
                    </span>
                    <p class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1"></p>
                    <div class="form-body">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="projectinput1">Enter Company Name</label>
                                    <input type="text" class="form-control" id="company_name" placeholder="Enter Company Name" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="projectinput2">Enter Company Email Address</label>
                                    <input type="email" class="form-control" readonly disabled value="<?php echo $company_data["Company_Email"]; ?>" id="company_email" placeholder="Enter Company Email Address" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="projectinput2">Enter Company ID Number</label>
                                    <input type="text" class="form-control" readonly disabled id="company_id" value="<?php echo $company_data["Company_ID"]; ?>" placeholder="Enter Company ID Number" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="projectinput1">Enter Company Phone Number</label>
                                    <input type="text" class="form-control number_only" id="company_phone_number" placeholder="Enter Company Phone Number" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="projectinput2">Enter Company Website Address</label>
                                    <input type="text" class="form-control" id="company_website" placeholder="Enter Company Website Address" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="projectinput2">Enter Company Report Header</label>
                                    <input type="text" class="form-control" id="company_header_report" placeholder="Enter Company Report Header" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="projectinput1">Enter Company Authorize Signature Name</label>
                                    <input type="text" class="form-control" id="authorize_signature_name" placeholder="Enter Company Authorize Signature Name" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="projectinput2">Enter Company Administrator Username</label>
                                            <input type="text" class="form-control" id="company_username" placeholder="Enter Company Administrator Username" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="projectinput2">Enter Company Authorize Signature Position</label>
                                    <input type="text" class="form-control" id="authorize_signature_position" placeholder="Enter Company Authorize Signature Position" required>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="projectinput2">Enter Company Administrator Password</label>
                                            <input type="password" class="form-control" id="company_password" placeholder="Enter Company Administrator Password" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="projectinput2">Enter Company Address</label>
                                    <textarea class="form-control" rows="5" id="company_address" placeholder="Enter Company Address"></textarea>
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
                            <button type="button" id="company_setup_btn" class="btn btn-outline-info btn-block"><i class='ft-save'></i> Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>

<br><br><br><br><br><br><br><br><br>
<?php include("../include/footer.php"); ?>