<?php include("../include/header.php"); ?>







    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
                <h3 class="content-header-title mb-0 d-inline-block">Contacts</h3>
                <div class="row breadcrumbs-top d-inline-block">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo $result["Web_Url"]; ?>dashboard">Home</a>
                            </li>
                            <li class="breadcrumb-item"><a href="#">Users</a>
                            </li>
                            <li class="breadcrumb-item active">Contacts
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
        <div class="content-detached content-right">
            <div class="content-body">
                <section class="row">
                    <div class="col-12">

                        <h1 class="card-title m-b-20" id="module_access">Administrator Module Access</h1>

                        <div class=" card">
                            <div class="card-content">
                                <div class="card-body">
                                    <!-- Module Access -->
                                    <ul class="list-group list-group-flush">

                                        <div id="module_list">

                                            <?php
                                            $data = new controller_company_default_datamanagement();
                                            $predefined_module = array();

                                            $module_access_result = $data->ModuleData()->results();
                                            $company_module_access_result = $data->CompanyModuleData('Administrator')->first();

                                            $module_names = explode(",", $company_module_access_result["Modules"]);
                                            $module_statuss = explode(",", $company_module_access_result["Status"]);

                                            $module_creates = explode(",", $company_module_access_result["Creates"]);
                                            $module_reads = explode(",", $company_module_access_result["ReadP"]);
                                            $module_deletes = explode(",", $company_module_access_result["Deletes"]);
                                            $module_locks = explode(",", $company_module_access_result["Locks"]);
                                            $module_unlocks = explode(",", $company_module_access_result["Unlocks"]);

                                            //Predefined Database Module
                                            foreach ($module_statuss as $key => $module_status) {
                                                $predefined_module_status[] = $module_status;
                                            }

                                            if (empty($module_names[0])) {
                                                foreach ($module_access_result as $key => $module_access_result_value) {
                                            ?>
                                                    <li class="list-group-item">
                                                        <label class="switch float-right-role"><input type="checkbox" value="<?php echo $module_access_result_value["Status"]; ?>" name="module_access" <?php echo $module_access_result_value["Status"] == 'Active' ? 'checked' : ''; ?>><span class="switch-button"></span> </label>
                                                        <?php echo $module_access_result_value["Module_Name"]; ?>
                                                    </li>
                                                <?php
                                                }
                                            } else {
                                                foreach ($module_names as $key => $module_name) {
                                                ?>
                                                    <li class="list-group-item">
                                                        <label class="switch float-right-role"><input type="checkbox" value="<?php echo $predefined_module_status[$key]; ?>" name="module_access" <?php echo $predefined_module_status[$key] == 'Active' ? 'checked' : ''; ?>><span class="switch-button"></span> </label>
                                                        <?php echo $module_name; ?>
                                                    </li>
                                            <?php
                                                }
                                            }

                                            ?>
                                        </div>
                                    </ul>
                                </div>
                            </div>
                        </div>


                        <!-- Module Permission Table -->
                        <div class=" card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped  ">
                                            <thead>
                                                <tr>
                                                    <th>Module Permission</th>
                                                    <th class="text-center">Create</th>
                                                    <th class="text-center">Read</th>
                                                    <th class="text-center">Delete</th>
                                                    <th class="text-center">Lock</th>
                                                    <th class="text-center">Unlock</th>
                                                </tr>
                                            </thead>
                                            <tbody id="permission_list">
                                                <?php

                                                if (empty($module_names[0])) {
                                                    foreach ($module_access_result as $key => $module_access_result_value) {
                                                ?>
                                                        <tr>
                                                            <td><?php echo $module_access_result_value["Module_Name"]; ?></td>
                                                            <td class="text-center">
                                                                <input type="checkbox" name="module_permission_create" value="true" <?php echo $module_access_result_value["Create"] == true ? 'checked' : ''; ?>>
                                                            </td>
                                                            <td class="text-center">
                                                                <input type="checkbox" name="module_permission_read" value="true" <?php echo $module_access_result_value["Read"] == true ? 'checked' : ''; ?>>
                                                            </td>
                                                            <td class="text-center">
                                                                <input type="checkbox" name="module_permission_delete" value="true" <?php echo $module_access_result_value["Delete"] == true ? 'checked' : ''; ?>>
                                                            </td>
                                                            <td class="text-center">
                                                                <input type="checkbox" name="module_permission_lock" value="true" <?php echo $module_access_result_value["Lock"] == true ? 'checked' : ''; ?>>
                                                            </td>
                                                            <td class="text-center">
                                                                <input type="checkbox" name="module_permission_unlock" value="true" <?php echo $module_access_result_value["Unlock"] == true ? 'checked' : ''; ?>>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                    }
                                                } else {
                                                    $module_permission_name = array();
                                                    //Module Name
                                                    foreach ($module_names as $module_key => $module_name) {
                                                        $module_permission_name[] = $module_name;
                                                    }
                                                    //Read Permission
                                                    foreach ($module_reads as $module_read) {
                                                        $module_read_permission[] = $module_read;
                                                    }
                                                    //Delete Permission
                                                    foreach ($module_deletes as $module_delete) {
                                                        $module_delete_permission[] = $module_delete;
                                                    }
                                                    //Lock Permission
                                                    foreach ($module_locks as $module_lock) {
                                                        $module_lock_permission[] = $module_lock;
                                                    }
                                                    //Unlock Permission
                                                    foreach ($module_unlocks as $module_unlock) {
                                                        $module_unlock_permission[] = $module_unlock;
                                                    }


                                                    foreach ($module_creates as $key => $module_create) {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $module_permission_name[$key]; ?></td>
                                                            <td class="text-center">
                                                                <input type="checkbox" name="module_permission_create" value="true" <?php echo $module_create == 'true' ? 'checked' : ''; ?>>
                                                            </td>
                                                            <td class="text-center">
                                                                <input type="checkbox" name="module_permission_read" value="true" <?php echo $module_read_permission[$key] == 'true' ? 'checked' : ''; ?>>
                                                            </td>
                                                            <td class="text-center">
                                                                <input type="checkbox" name="module_permission_delete" value="true" <?php echo $module_delete_permission[$key] == 'true' ? 'checked' : ''; ?>>
                                                            </td>
                                                            <td class="text-center">
                                                                <input type="checkbox" name="module_permission_lock" value="true" <?php echo $module_lock_permission[$key] == 'true' ? 'checked' : ''; ?>>
                                                            </td>
                                                            <td class="text-center">
                                                                <input type="checkbox" name="module_permission_unlock" value="true" <?php echo $module_unlock_permission[$key] == 'true' ? 'checked' : ''; ?>>
                                                            </td>
                                                        <?php
                                                    }
                                                        ?>
                                                        </tr>
                                                    <?php
                                                }
                                                    ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Save Button -->
                        <center>
                            <button type="button" id="role_permission_btn" class="btn btn-info round btn-min-width mr-1 mb-1">
                                <l class="la la-save"></l> Save Changes
                            </button>
                        </center>

                    </div>
                </section>
            </div>
        </div>
        <div class="sidebar-detached sidebar-left" ,=",">
            <div class="sidebar">
                <div class="bug-list-sidebar-content">
                    <!-- Predefined Views -->
                    <div class="card">

                        <!-- contacts search -->
                        <div class="card-body border-top-blue-grey border-top-lighten-5">
                            <div class="bug-list-search">
                                <div class="bug-list-search-content">
                                    <button type="button" class="btn btn-warning btn-block" data-toggle="modal" data-target="#create_role"><b>
                                            <l class="la la-plus"></l> Add Roles
                                        </b></button>

                                </div>
                            </div>
                        </div>
                        <!-- /contacts search -->
                        <!-- contacts view -->
                        <div class="card-body">



                            <?php

                            if (!empty($module_names[0])) {
                                $company_module_access_result = $data->CompanyModuleDataByID()->results();
                                foreach ($company_module_access_result as $key => $value) {
                            ?>
                                    <div class="account-type"><label>
                                            <input type="radio" name="rolename" value="<?php echo $value["Role_Name"]; ?>" class="account-type-radio" />
                                            <?php echo $value["Role_Name"]; ?></label>
                                        <?php
                                        if ($value["Role_Name"] != 'Administrator') {
                                        ?>
                                            <ul class="list-group">
                                                <li>
                                                    <l class="la la-trash-o danger delete_role" id="<?php echo $value["ID"]; ?>" data-toggle="tooltip" data-placement="right" data-original-title="Delete <?php echo $value["Role_Name"]; ?> Role"></l>
                                                </li>
                                                <li>
                                                    <l class="la la-check-square-o success edit_role" type="<?php echo $value["Role_Name"]; ?>" data-target="#create_role" id="<?php echo $value["ID"]; ?>" data-toggle="modal" data-placement="right"></l>
                                                </li>
                                            </ul>
                                        <?php
                                        }
                                        ?>

                                    </div>

                                <?php
                                }
                            } else {
                                ?>
                                <div class="account-type"><label>
                                        <input type="radio" name="rolename" value="Administrator" class="account-type-radio" />
                                        Administrator</label>
                                </div>

                            <?php
                            }

                            ?>
                        </div>

                        <input type="hidden" id="role" value="Administrator">
                    </div>
                    <!--/ Predefined Views -->
                </div>
            </div>
        </div>
    </div>


<?php include("../include/footer.php"); ?>