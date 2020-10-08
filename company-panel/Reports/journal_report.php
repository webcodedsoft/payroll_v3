<?php include("../include/header.php"); ?>



<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Journal Report</h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo $result["Web_Url"]; ?>dashboard">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Journal Report
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
                                                <div class="col-md-2"></div>
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label for="projectinput2" data-i18n="payment_type">Select Date<span class="danger">*</span></label>
                                                        <select class="select2 form-control" id="journal_report_date" name="journal_report_date">
                                                            <option value="" selected disabled>Choose Date...</option>
                                                            <?php
                                                            foreach ($earning_date_datas as $key => $earning_date_data) {
                                                                $start_date = date($localization_data["Date_Format"], strtotime($earning_date_data["Dates"]));
                                                                $end_date = date($localization_data["Date_Format"], strtotime($earning_date_data["End_Date"]));

                                                            ?>
                                                                <option value="<?php echo $earning_date_data["Dates"]; ?>"><?php echo $start_date . ' - ' . $end_date; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2"></div>
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
        <div id="journal_report_result"></div>

        <!-- File export table -->

    </div>
</div>

<!-- ////////////////////////////////////////////////////////////////////////////-->

<?php include("../include/footer.php"); ?>