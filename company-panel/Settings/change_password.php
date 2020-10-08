<?php include("../include/header.php"); ?>






    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
                <h3 class="content-header-title mb-0 d-inline-block">Change Passowrd</h3>
                <div class="row breadcrumbs-top d-inline-block">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo $result["Web_Url"]; ?>dashboard">Home</a>
                            </li>
                            <li class="breadcrumb-item"><a href="#">Users</a>
                            </li>
                            <li class="breadcrumb-item active">Change Passowrd
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
                <div class="col-md-6 col-6 box-shadow-2 p-0">
                    <div class="card border-grey border-lighten-3 px-1 py-1 m-0">
                        <div class="card-content">
                            <div class="form-body">
                                <form action="">
                                    <div class="col-md-12">
                                        <fieldset class="form-group">
                                            <label>Old Password </label>
                                            <input type="password" class="font-weight-bold form-control" id="old_password" placeholder="Enter Old Password">
                                        </fieldset>
                                    </div>
                                    <div class="col-md-12">
                                        <fieldset class="form-group">
                                            <label>New Password</label>
                                            <input type="password" class="font-weight-bold form-control" id="new_password" placeholder="Enter New Password">
                                        </fieldset>
                                    </div>

                                    <div class="col-md-12">
                                        <fieldset class="form-group">
                                            <label>Confirm New Password</label>
                                            <input type="password" class="font-weight-bold form-control" id="confirm_password" placeholder="Confirm New Password">
                                        </fieldset>
                                    </div>

                                    <div class="card-body">
                                        <button type="button" id="change_password_btn" class="btn btn-info btn-block"><i class='ft-save'></i> Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        </section>


    </div>


<?php include("../include/footer.php"); ?>