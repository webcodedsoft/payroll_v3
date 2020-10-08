<?php include("../include/header.php"); ?>




<div class="app-content content">

    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
                <h3 class="content-header-title mb-0 d-inline-block">Subscribed Companies</h3>
                <div class="row breadcrumbs-top d-inline-block">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo $result["Web_Url"]; ?>admin-dashboard">Home</a>
                            </li>
                            <li class="breadcrumb-item active">Subscribed Companies
                            </li>
                        </ol>
                    </div>
                </div>
            </div>

        </div>
        <div class="content-body">
            <!-- Company statistics -->
            <div class="row">
                <div class="col-xl-3 col-lg-6 col-12">
                    <div class="card pull-up">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="media-body text-left">
                                        <h3 class="info">850</h3>
                                        <h6>Joining</h6>
                                    </div>
                                    <div>
                                        <i class="icon-basket-loaded info font-large-2 float-right"></i>
                                    </div>
                                </div>
                                <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                    <div class="progress-bar bg-gradient-x-info" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-12">
                    <div class="card pull-up">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="media-body text-left">
                                        <h3 class="warning">$748</h3>
                                        <h6>Renewal</h6>
                                    </div>
                                    <div>
                                        <i class="icon-pie-chart warning font-large-2 float-right"></i>
                                    </div>
                                </div>
                                <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                    <div class="progress-bar bg-gradient-x-warning" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-12">
                    <div class="card pull-up">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="media-body text-left">
                                        <h3 class="success">146</h3>
                                        <h6>Renewal</h6>
                                    </div>
                                    <div>
                                        <i class="icon-user-follow success font-large-2 float-right"></i>
                                    </div>
                                </div>
                                <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                    <div class="progress-bar bg-gradient-x-success" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-12">
                    <div class="card pull-up">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="media-body text-left">
                                        <h3 class="danger">99.89 %</h3>
                                        <h6>Total Companies</h6>
                                    </div>
                                    <div>
                                        <i class="icon-heart danger font-large-2 float-right"></i>
                                    </div>
                                </div>
                                <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                    <div class="progress-bar bg-gradient-x-danger" role="progressbar" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Company statistics -->

            <!--                                                     <label class="switch"><input type="checkbox" id="work_inter_state" value="Work Inter-State" name="radio"><span class="switch-button"></span> </label>
 -->
           
            <!-- File export table -->
            <section id="file-export">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Registered Companies</h4>
                            </div>
                            <div class="card-content collapse show ">
                                <div class="card-bodys card-dashboards table-responsive">

                                    <table class="table table-striped table-bordered" id="complete_registered_company_list">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Client</th>
                                                <th>Plan</th>
                                                <th>Users</th>
                                                <th>Plan Duration</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Amount</th>
                                                <!-- <th>Join Date</th> -->
                                                <th>Plan Status</th>
                                                <th>Update Plan</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Client</th>
                                                <th>Plan</th>
                                                <th>Users</th>
                                                <th>Plan Duration</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Amount</th>
                                                <!-- <th>Join Date</th> -->
                                                <th>Plan Status</th>
                                                <th>Update Plan</th>
                                                <th>Status</th>
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
</div>
<!-- ////////////////////////////////////////////////////////////////////////////-->

<?php include("../include/footer.php"); ?>