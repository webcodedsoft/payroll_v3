<?php include("../include/header.php"); ?>




<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Subscriptions</h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo $result["Web_Url"]; ?>dashboard">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Subscriptions
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



        <div class="col-xl-12 col-lg-12">
            <div class="cards">

                <div class="card-content">
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-linetriangle">
                            <li class="nav-item">
                                <a class="nav-link active" id="baseIcon-tab31" data-toggle="tab" aria-controls="tabIcon31" href="#monthly" aria-expanded="true"><i class="la la-calendar"></i> Monthly Plan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="baseIcon-tab32" data-toggle="tab" aria-controls="tabIcon32" href="#yearly" aria-expanded="false"><i class="la la-calendar"></i> Yearly Plan</a>
                            </li>

                        </ul>
                        <div class="tab-content px-1 pt-1">

                            <div role="tabpanel" class="tab-pane active" id="monthly" aria-expanded="true" aria-labelledby="baseIcon-tab31">
                                <section id="user-profile-cards" class="row mt-2">

                                    <?php
                                    $monthly_packages = $data_connect->SubscriptionPackage('Monthly')->results();

                                    foreach ($monthly_packages as $monthly_package) {
                                        //var_dump($monthly_package);
                                    ?>
                                        <div class="col-xl-4 col-md-6 col-12">
                                            <div class="card">
                                                <div class="text-center">
                                                    <div class="card-body">
                                                        <h4 class="card-title" style="font-size: 20px;"><b><?php echo $monthly_package["Plan_Name"]; ?></b></h4>
                                                        <h6 class="card-subtitle"><b style="font-size: 50px">$<?php echo $monthly_package["Plan_Amount"]; ?></b></h6>
                                                    </div>
                                                </div>
                                                <div class="list-group list-group-flush">
                                                    <b class="list-group-item"><i class="la la-check success"></i> <?php echo $monthly_package["No_User"]; ?> Users</b>
                                                    <b class="list-group-item"><i class="la la-check success"></i><?php echo $monthly_package["Storage_Space"]; ?> Storage</b>
                                                    <b class="list-group-item"><i class="la la-check success"></i> <?php echo $monthly_package["Plan_Type"]; ?></b>
                                                    <b class="list-group-item"><i class="la la-check success"></i> 24/7 Customer Support</b>
                                                </div>
                                                <div class="card-body">
                                                    <center>
                                                        <?php echo $company_data_f["Plan_ID"] == $monthly_package["Plan_ID"] ? '<span class="badge badge-default badge-success">Current Plan</span>
                                                        ' : '<span class="badge badge-default badge-secondary">Contact the Owner for Upgrade</span>'; ?>
                                                    </center>
                                                </div>

                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>

                                </section>
                            </div>

                            <div class="tab-pane" id="yearly" aria-labelledby="baseIcon-tab32">
                                <section id="user-profile-cards" class="row mt-2">
                                    <?php
                                    $yearly_packages = $data_connect->SubscriptionPackage('Yearly')->results();
                                    foreach ($yearly_packages as $yearly_package) {
                                        //var_dump($yearly_package);
                                    ?>
                                        <div class="col-xl-4 col-md-6 col-12">
                                            <div class="card">
                                                <div class="text-center">
                                                    <div class="card-body">
                                                        <h4 class="card-title" style="font-size: 20px;"><b><?php echo $yearly_package["Plan_Name"]; ?></b></h4>
                                                        <h6 class="card-subtitle"><b style="font-size: 50px">$<?php echo $yearly_package["Plan_Amount"]; ?></b></h6>
                                                    </div>
                                                </div>
                                                <div class="list-group list-group-flush">
                                                    <b class="list-group-item"><i class="la la-check success"></i> <?php echo $yearly_package["No_User"]; ?> Users</b>
                                                    <b class="list-group-item"><i class="la la-check success"></i><?php echo $yearly_package["Storage_Space"]; ?> Storage</b>
                                                    <b class="list-group-item"><i class="la la-check success"></i> <?php echo $yearly_package["Plan_Type"]; ?></b>
                                                    <b class="list-group-item"><i class="la la-check success"></i> 24/7 Customer Support</b>
                                                </div>
                                                <div class="card-body">
                                                    <center>
                                                        <?php echo $company_data_f["Plan_ID"] == $yearly_package["Plan_ID"] ? '<span class="badge badge-default badge-success">Current Plan</span>
                                                        ' : '<span class="badge badge-default badge-secondary">Contact the Owner for Upgrade</span>'; ?>
                                                    </center>
                                                </div>

                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>

                                </section>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- File export table -->
        <section id="file-export">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Subscription List</h4>
                        </div>
                        <div class="card-content collapse show ">
                            <div class="card-bodys card-dashboards table-responsive">

                                <table class="table table-striped table-bordered" id="subscribed_package_list">
                                    <thead>
                                        <tr>
                                            <th>Plan Name</th>
                                            <th>Plan Type</th>
                                            <th>Users</th>
                                            <th>Plan Duration</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Amount</th>
                                            <th>Allocated Space</th>
                                            <th>Plan Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Plan Name</th>
                                            <th>Plan Type</th>
                                            <th>Users</th>
                                            <th>Plan Duration</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Amount</th>
                                            <th>Allocated Space</th>
                                            <th>Plan Status</th>
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