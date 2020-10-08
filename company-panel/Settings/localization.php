<?php include("../include/header.php"); ?>






    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
                <h3 class="content-header-title mb-0 d-inline-block">Basic Settings</h3>
                <div class="row breadcrumbs-top d-inline-block">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo $result["Web_Url"]; ?>dashboard">Home</a>
                            </li>
                            <li class="breadcrumb-item"><a href="#">Users</a>
                            </li>
                            <li class="breadcrumb-item active">Basic Settings
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
                                            <div class="form-group">
                                                <label for="projectinput1"> Default Country </label>
                                                <select class="select2 form-control" id="country">
                                                    <option selected disabled aria-selected="true" aria-disabled="true">Select Country</option>
                                                    <?php
                                                    foreach ($countrywithcurrency as $key => $countries) {
                                                    ?>
                                                        <option <?php echo $localization_data['Country'] == $countries['country'] ? 'selected ' : ''; ?> value="<?php echo $countries['ID']; ?>" name="<?php echo $countries['country']; ?>"><?php echo $countries['country']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
 
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput2"> Date Format </label>
                                                <select class="select2 form-control " id="date_format">
                                                    <option <?php echo $localization_data['Date_Format'] == 'Y-m-d' ? 'selected ' : ''; ?> value="Y-m-d" data--id="34"><?php echo date("Y-m-d"); ?></option>
                                                    <option <?php echo $localization_data['Date_Format'] == 'd/m/Y' ? 'selected ' : ''; ?> value="d/m/Y" data-id="29"><?php echo date("d/m/Y"); ?></option>
                                                    <option <?php echo $localization_data['Date_Format'] == 'd.m.Y' ? 'selected ' : ''; ?> value="d.m.Y" data-id="30"><?php echo date("d.m.Y"); ?></option>
                                                    <option <?php echo $localization_data['Date_Format'] == 'd-m-Y' ? 'selected ' : ''; ?> value="d-m-Y" data-id="31"><?php echo date("d-m-Y"); ?></option>
                                                    <option <?php echo $localization_data['Date_Format'] == 'm/d/Y' ? 'selected ' : ''; ?> value="m/d/Y" data-id="32"><?php echo date("m/d/Y"); ?></option>
                                                    <option <?php echo $localization_data['Date_Format'] == 'Y/m/d' ? 'selected ' : ''; ?> value="Y/m/d" data-id="33"><?php echo date("Y/m/d"); ?></option>
                                                    <option <?php echo $localization_data['Date_Format'] == 'Y M d' ? 'selected ' : ''; ?> value="Y M d" data-id="33"><?php echo date("Y M d"); ?></option>
                                                    <option <?php echo $localization_data['Date_Format'] == 'd M Y' ? 'selected ' : ''; ?> value="d M Y" data-id="33"><?php echo date("d M Y"); ?></option>
                                                    <option <?php echo $localization_data['Date_Format'] == 'F d Y' ? 'selected ' : ''; ?> value="F d Y" data-id="33"><?php echo date("F d Y"); ?></option>
                                                    <option <?php echo $localization_data['Date_Format'] == 'Y F D' ? 'selected ' : ''; ?> value="Y F D" data-id="33"><?php echo date("Y F D"); ?></option>
                                                </select>


                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput1">Timezone</label>
                                                <select class="select2 form-control" id="timezone">
                                                    <option selected disabled aria-selected="true" aria-disabled="true">Select Country Timezone</option>
                                                    <?php
                                                    foreach ($countrytimezones as $key => $countrytimezone) {
                                                    ?>
                                                        <option <?php echo $localization_data['Time_Zone'] == $countrytimezone['country_timestamp'] ? 'selected ' : ''; ?> value="<?php echo $countrytimezone['country_timestamp']; ?>"><?php echo $countrytimezone['country_timestamp']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput2"> Default Language </label>
                                                <select class="select2 form-control" id="language">
                                                    <option <?php echo $localization_data['Language'] == 'en' ? 'selected ' : ''; ?> value="en">English</option>
                                                    <option <?php echo $localization_data['Language'] == 'es' ? 'selected ' : ''; ?> value="es">Spanish</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput1"> Local Currency Code </label>
                                                <input type="text" class="form-control" id="currency_code" value="<?php echo $localization_data['Currency_Code']; ?>" disabled readonly placeholder="Currency Code" required>
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput2">Default Currency Symbol</label>
                                                <b class="form-control" id="currency_symbol"><?php echo $localization_data['Currency_Symbol']; ?></b>
                                                <input type="text" hidden id="currency_symbol_real" value="<?php echo $localization_data['Currency_Symbol']; ?>">
                                            </div>

                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <button type="button" id="localization_btn" class="btn btn-info btn-block"><i class='ft-save'></i> Save Changes</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        </section>


    </div>

<?php include("../include/footer.php"); ?>