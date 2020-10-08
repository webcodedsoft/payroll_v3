<?php include("../include/header.php"); ?>


<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Clients</h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo $result["Web_Url"]; ?>dashboard">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Clients
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
                    <button type="button" class="btn btn-info round btn-min-width mr-1 mb-1" data-toggle="modal" data-target="#create_client"> <i class="la la-plus"></i> Add Client</button>
                </div>
            </div>

        </div>



        <!-- File export table -->
        <section id="file-export">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Client List</h4>
                        </div>
                        <div class="card-content collapse show ">
                            <div class="card-bodys card-dashboards table-responsive">

                                <table class="table table-striped table-bordered" id="clients_list">
                                    <thead>
                                        <tr>
                                            <th>Company Name</th>
                                            <th>Contact Person</th>
                                            <th>Address</th>
                                            <th>Email</th>
                                            <th>Phone Number</th>
                                            <th>Created Date</th>
                                            <th>Created By</th>
                                            <th>Modified Date</th>
                                            <th>Modified By</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>


                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Company Name</th>
                                            <th>Contact Person</th>
                                            <th>Address</th>
                                            <th>Email</th>
                                            <th>Phone Number</th>
                                            <th>Created Date</th>
                                            <th>Created By</th>
                                            <th>Modified Date</th>
                                            <th>Modified By</th>
                                            <th>Status</th>
                                            <th>Action</th>
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