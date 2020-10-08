<?php include("../include/header.php"); ?>


<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Association Settings </h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo $result["Web_Url"]; ?>dashboard">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Association Settings
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
                    <button type="button" class="btn btn-info round btn-min-width mr-1 mb-1" data-toggle="modal" data-target="#add_association"> <i class="la la-plus"></i> Add Association</button>
                </div>
            </div>

        </div>



        <!-- File export table -->
        <section id="file-export">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Association List</h4>
                        </div>
                        <div class="card-content collapse show ">
                            <div class="card-bodys card-dashboards table-responsive">


                                <table class="table table-striped table-bordered" id="association_list">
                                    <thead>
                                        <tr>
                                            <th><span data-i18n="association_code"> Association Code </span></th>
                                            <th><span data-i18n="percentage_rate"> Percentage Rate </span>%</th>
                                            <th><span data-i18n="created_date"> Created Date</span></th>
                                            <th><span data-i18n="created_by"> Created By</span></th>
                                            <th><span data-i18n="modified_date"> Modified Date</span></th>
                                            <th><span data-i18n="modified_by"> Modified By</span></th>
                                            <th><span data-i18n="status"> Status</span></th>
                                            <th><span data-i18n="actions"> Actions </span></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th><span data-i18n="association_code"> Association Code </span></th>
                                            <th><span data-i18n="percentage_rate"> Percentage Rate </span>%</th>
                                            <th><span data-i18n="created_date"> Created Date</span></th>
                                            <th><span data-i18n="created_by"> Created By</span></th>
                                            <th><span data-i18n="modified_date"> Modified Date</span></th>
                                            <th><span data-i18n="modified_by"> Modified By</span></th>
                                            <th><span data-i18n="status"> Status</span></th>
                                            <th><span data-i18n="actions"> Actions </span></th>
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