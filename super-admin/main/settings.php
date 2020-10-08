<?php include("../include/header.php"); ?>


<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
                <h3 class="content-header-title mb-0 d-inline-block">Web Settings</h3>
                <div class="row breadcrumbs-top d-inline-block">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo $result["Web_Url"]; ?>admin-dashboard">Home</a>
                            </li>
                            <li class="breadcrumb-item active">Web Settings
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
                    </div>
                </div>
            </div>

            <!-- File export table -->

            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Web Settings</h4>
                        </div>
                        <form method="post"></form>
                        <div class="card-block">
                            <div class="card-body">
                                <fieldset class="form-group">
                                    <input type="text" class="form-control" value="<?php echo $result["Web_Contact"]; ?>" placeholder="Contact Number" id="phone_number" name="phone_number">
                                </fieldset>

                                <fieldset class="form-group">
                                    <input type="text" class="form-control" value="<?php echo $result["Web_Url"]; ?>" placeholder="Website Url" id="web_url" name="web_url">
                                </fieldset>
                            </div>
                            <input type="hidden" class="form-control" id="change_password" name="change_password">
                            <center><button type="button" class="btn btn-info round btn-min-width mr-1 mb-1 " id="web_settings_btn"> <i class="la la-save"></i> Save Changes</button></center>

                        </div>
                        </form>
                    </div>
                </div>

                <div class="col-xl-6 col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Password Settings</h4>
                        </div>
                        <div class="card-block">
                            <div class="card-body">

                                <fieldset class="form-group">
                                    <input type="password" class="form-control" placeholder="Current Password" name="current_password" id="current_password">
                                </fieldset>

                                <fieldset class="form-group">
                                    <input type="password" class="form-control" placeholder="Old Password" name="old_password" id="old_password">
                                </fieldset>

                                <fieldset class="form-group">
                                    <input type="password" class="form-control" placeholder="New Login Password" name="password_again" id="password_again">
                                </fieldset>
                            </div>

                            <center><button type="button" class="btn btn-info round btn-min-width mr-1 mb-1" id="change_password"> <i class="la la-save"></i> Save Changes</button></center>

                        </div>
                    </div>
                </div>

            </div>


            <!-- File export table -->

        </div>
    </div>
</div>
<!-- ////////////////////////////////////////////////////////////////////////////-->

<?php include("../include/footer.php"); ?>