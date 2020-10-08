<?php include("../include/header.php"); ?>







    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
                <h3 class="content-header-title mb-0 d-inline-block">Theme Settings</h3>
                <div class="row breadcrumbs-top d-inline-block">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo $result["Web_Url"]; ?>dashboard">Home</a>
                            </li>
                            <li class="breadcrumb-item"><a href="#">Users</a>
                            </li>
                            <li class="breadcrumb-item active">Theme Settings
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
                <div class="col-md-8 col-10 box-shadow-2 p-0">
                    <div class="card border-grey border-lighten-3 px-1 py-1 m-0">
                        <div class="card-content">
                            <div class="form-body">
                                <form action="">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <fieldset class="form-group">
                                                <label>Website Name</label>
                                                <input type="text" class="font-weight-bold form-control" value="<?php echo $theme_data["Website_Name"]; ?>" id="website_name" placeholder="Website Name">
                                            </fieldset>
                                        </div>
                                        <div class="row col-md-12">
                                            <div class="col-md-7">
                                                <fieldset class="form-group">
                                                    <label>Theme Logo</label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="logo">
                                                        <label class="custom-file-label" for="logo">No file Selected</label>
                                                    </div>
                                                    <small class="form-text text-muted">Recommended image size is 40px x 40px</small>
                                                </fieldset>
                                            </div>

                                            <?php
                                            if (!empty($theme_data["Logo"])) {
                                            ?>
                                                <div class="col-md-2">
                                                    <img style="width: 100px; height:50px;" src="<?php echo $result["Web_Url"]; ?>Folders/Company_Folders/<?php echo $company_data_f["Subscriber_ID"]; ?>/Logo/<?php echo $theme_data["Logo"]; ?>" alt="">
                                                </div>
                                            <?php
                                            } ?>

                                        </div>

                                        <div class="row col-md-12">
                                            <div class="col-md-7">
                                                <fieldset class="form-group">
                                                    <label>Theme Favicon</label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="favicon">
                                                        <label class="custom-file-label" for="favicon">No file Selected</label>
                                                    </div>
                                                    <small class="form-text text-muted">Recommended image size is 16px x 16px</small>
                                                </fieldset>
                                            </div>

                                            <?php
                                            if (!empty($theme_data["Favicon"])) {
                                            ?>
                                                <div class="col-md-2">
                                                    <img style="width: 16px; height:16px;" src="<?php echo $result["Web_Url"]; ?>Folders/Company_Folders/<?php echo $company_data_f["Subscriber_ID"]; ?>/Logo/<?php echo $theme_data["Favicon"]; ?>" alt="">
                                                </div>
                                            <?php
                                            } ?>
                                        </div>


                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <label for="projectinput2"> Display Mode </label>
                                                <select class="select2 form-control" id="display_mode">
                                                    <option <?php echo $theme_data["Display_Mode"] == 'Dark' ? 'selected' : '' ?> value="Dark">Dark Mode</option>
                                                    <option <?php echo $theme_data["Display_Mode"] == 'Light' ? 'selected' : '' ?> value="Light">Light Mode</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <label for="projectinput2"> Theme Orientation </label>
                                                <select class="select2 form-control" id="theme_orientation">
                                                    <option <?php echo $theme_data["Theme_Orientation"] == 'Horizontal' ? 'selected' : '' ?> value="Horizontal">Horizontal Orientation</option>
                                                    <option <?php echo $theme_data["Theme_Orientation"] == 'Vertical' ? 'selected' : '' ?> value="Vertical">Vertical Orientation</option>
                                                </select>
                                            </div>
                                        </div>


                                    </div>

                                    <div class="card-body">
                                        <button type="button" id="theme_btn" class="btn btn-info btn-block"><i class='ft-save'></i> Save Changes</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        </section>


    </div>


<?php include("../include/footer.php"); ?>