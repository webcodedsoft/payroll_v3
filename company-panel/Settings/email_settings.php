<?php include("../include/header.php"); ?>







    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
                <h3 class="content-header-title mb-0 d-inline-block">Email Settings</h3>
                <div class="row breadcrumbs-top d-inline-block">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo $result["Web_Url"]; ?>dashboard">Home</a>
                            </li>
                            <li class="breadcrumb-item"><a href="#">Users</a>
                            </li>
                            <li class="breadcrumb-item active">Email Settings
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
                                        <div class="col-md-6">

                                            <fieldset class="form-group">
                                                <label>SMTP HOST</label>
                                                <input type="text" class="font-weight-bold form-control" value="<?php echo $email_data["Email_Host"]; ?>" id="host" placeholder="SMTP Host">
                                                <small>Example: <code>smtp.gmail.com</code></small>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label>SMTP USER EMAIL</label>
                                                <input type="text" class="font-weight-bold form-control" value="<?php echo $email_data["Email"]; ?>" id="user" placeholder="SMTP User Email">
                                                <small>Example: <code>example@gmail.com</code></small>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label>SMTP USER EMAIL PASSWORD</label>
                                                <input type="text" class="font-weight-bold form-control" value="<?php echo $email_data["Email_Password"]; ?>" id="password" placeholder="SMTP User Email Password">
                                                <small>Example: <code>email password</code></small>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label>SMTP PORT</label>
                                                <input type="text" class="font-weight-bold form-control number_only" value="<?php echo $email_data["Port"]; ?>" id="port" placeholder="SMTP Port">
                                                <small>Recommended 465</small>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label>SMTP SECURITY</label>
                                                <select class="select2 font-weight-bold form-control" id="security">
                                                    <option <?php echo $email_data["Security"] == 'ssl' ? 'selected' : ''; ?> value="ssl">SSL</option>
                                                    <option <?php echo $email_data["Security"] == 'tls' ? 'selected' : ''; ?> value="tls">TLS</option>
                                                </select>
                                                <small>Recommended SSL</small>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label>SMTP AUTHENTICATION DOMAIN </label>
                                                <select class="select2 font-weight-bold form-control" id="domain">
                                                    <option <?php echo $email_data["Domain"] == 'true' ? 'selected' : ''; ?> value="true">TRUE</option>
                                                    <option <?php echo $email_data["Domain"] == 'false' ? 'selected' : ''; ?> value="false">FALSE</option>
                                                </select>
                                                <small>Recommended true</small>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <button type="button" id="email_btn" class="btn btn-info btn-block"><i class='ft-save'></i> Save Changes</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        </section>


    </div>


<?php include("../include/footer.php"); ?>