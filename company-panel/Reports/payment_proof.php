<?php include("../include/header.php"); ?>



<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Payment Proof</h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo $result["Web_Url"]; ?>dashboard">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Payment Proof Detail
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

        <section id="form-repeater">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-content collapse show">
                            <div class="card-body">
                                <div class="repeater-default">
                                    <div data-repeater-list="car">
                                        <div data-repeater-item>

                                            <div class="row">

                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label for="projectinput2" data-i18n="payment_type">Select Employee Name<span class="danger">*</span></label>
                                                        <select class="select2 form-control" id="employee_id_payment_proof" name="employee_id_payment_proof">
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

                                                <div class="col-md-5">
                                                    <fieldset class="form-group">
                                                        <label for="projectinput2" data-i18n="select_date">Select Payment Date<span class="danger">*</span></label>
                                                        <select class="select2 form-control earning_date_range_payment_proof" id="earning_date_range_payment_proof">
                                                            <option value="" selected disabled>Choose Date...</option>
                                                            <?php
                                                            foreach ($earning_date_datas as $key => $earning_date_data) {
                                                            ?>
                                                                <option value="<?php echo $earning_date_data["Dates"]; ?>"><?php echo $earning_date_data["Dates"] . ' - ' . $earning_date_data["End_Date"]; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </fieldset>
                                                </div>


                                                <div class="col-md-2" style="padding-top: 18px">
                                                    <button type="button" id="payment_proof_btn" class="btn waves-effect waves-light btn-block btn-info" data-i18n="submit_btn">
                                                        <li class="la la-search"></li> Submit
                                                    </button>
                                                </div>

                                            </div>

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
        <div id="employee_payment_proof"></div>

        <!-- File export table -->
       
    </div>
</div>

<!-- ////////////////////////////////////////////////////////////////////////////-->

<?php include("../include/footer.php"); ?>