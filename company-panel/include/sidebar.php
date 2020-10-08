<?php

if ($theme_data["Theme_Orientation"] == 'Horizontal') {
?>

    <body class="horizontal-layout horizontal-menu 2-columns menu-expanded <?php echo $theme_data["Display_Mode"] == 'Dark' ? 'dark-mode' : 'light-mode'; ?>" data-open="hover" data-menu="horizontal-menu" data-col="2-columns">
        <!-- fixed-top-->
        <nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow navbar-static-top <?php echo $theme_data["Display_Mode"] == 'Dark' ? 'navbar-dark' : 'navbar-light'; ?> navbar-brand-center">
            <div class="navbar-wrapper">
                <div class="navbar-header">
                    <ul class="nav navbar-nav flex-row">
                        <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
                        <li class="nav-item">
                            <a class="navbar-brand" href="index.html">
                                <img class="brand-logo" alt="modern admin logo" src="../../../app-assets/images/logo/logo.png">
                                <h3 class="brand-text">Modern Admin</h3>
                            </a>
                        </li>
                        <li class="nav-item d-md-none">
                            <a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="la la-ellipsis-v"></i></a>
                        </li>
                    </ul>
                </div>

                <div class="navbar-container content">
                    <div class="collapse navbar-collapse" id="navbar-mobile">
                        <ul class="nav navbar-nav mr-auto float-left">
                            <li class="nav-item d-none d-md-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu"></i></a></li>
                            <li class="nav-item d-none d-md-block"><a class="nav-link nav-link-expand" href="#"><i class="ficon ft-maximize"></i></a></li>
                        </ul>
                        <ul class="nav navbar-nav float-right">
                            <li class="dropdown dropdown-usernav-item has-sub">
                                <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                                    <span class="mr-1">Hello,
                                        <span class="user-name text-bold-700">John Doe</span>
                                    </span>
                                    <span class="avatar avatar-online">
                                        <img src="../../../app-assets/images/portrait/small/avatar-s-19.png" alt="avatar"><i></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#"><i class="ft-power"></i> Logout</a>
                                </div>
                            </li>
                            <li class="dropdown dropdown-languagenav-item has-sub"><a class="dropdown-toggle nav-link" id="dropdown-flag" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="flag-icon flag-icon-gb"></i><span class="selected-language"></span></a>
                                <div class="dropdown-menu" aria-labelledby="dropdown-flag"><a class="dropdown-item" href="#"><i class="flag-icon flag-icon-gb"></i> English</a>
                                    <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-fr"></i> French</a>
                                    <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-cn"></i> Chinese</a>
                                    <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-de"></i> German</a>
                                </div>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <div class="header-navbar navbar-expand-sm navbar navbar-horizontal navbar-fixed <?php echo $theme_data["Display_Mode"] == 'Dark' ? 'navbar-dark' : 'navbar-light'; ?> navbar-without-dd-arrow navbar-shadow" role="navigation" data-menu="menu-wrapper">
            <div class="navbar-container main-menu-content" data-menu="menu-container">

                <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">

                    <!-- Dashboard -->
                    <li><a class=" nav-link dropdown-items" href="<?php echo $result["Web_Url"]; ?>dashboard"><i class="la la-home"></i> <span data-i18n="dashboard">Dashboard</span></a></li>

                    <!-- Performance -->
                    <li class="dropdown nav-item " data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="la la-pie-chart"></i><span data-i18n="performance">Performance</span></a>
                        <ul class="dropdown-menu">
                            <li data-menu=""><a class="dropdown-item" href="<?php echo $result["Web_Url"]; ?>file-management" data-toggle="dropdown" data-i18n="file_manager">File Manager</a>
                            </li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo $result["Web_Url"]; ?>subscription" data-toggle="dropdown" data-i18n="subscription">Subscription</a>
                            </li>
                        </ul>
                    </li>


                    <!-- Configuration -->
                    <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="la la-wrench"></i><span data-i18n="configuration">Configuration</span></a>
                        <ul class="dropdown-menu">
                            <li data-menu=""><a class="dropdown-item" href="<?php echo $result["Web_Url"]; ?>branch-setting" data-toggle="dropdown" data-i18n="branch_setting">Branch Setting</a>
                            </li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo $result["Web_Url"]; ?>department-setting" data-toggle="dropdown" data-i18n="subscription">Department Setting</a>
                            </li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo $result["Web_Url"]; ?>journal-setting" data-toggle="dropdown" data-i18n="journal_setting">Journal Setting</a>
                            </li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo $result["Web_Url"]; ?>salary-tax-settings" data-toggle="dropdown" data-i18n="salary_tax">Salary & Tax Settings</a>
                            </li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo $result["Web_Url"]; ?>social-security-settings" data-toggle="dropdown" data-i18n="social_security">Social Security Settings</a>
                            </li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo $result["Web_Url"]; ?>association-settings" data-toggle="dropdown" data-i18n="association">Association Settings</a>
                            </li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo $result["Web_Url"]; ?>currency" data-toggle="dropdown" data-i18n="currency">Currency</a>
                            </li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo $result["Web_Url"]; ?>vacation-setting" data-toggle="dropdown" data-i18n="vacation_setting">Vacation Settings</a>
                            </li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo $result["Web_Url"]; ?>family-tax" data-toggle="dropdown" data-i18n="family_tax">Family Tax</a>
                            </li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo $result["Web_Url"]; ?>marital-status" data-toggle="dropdown" data-i18n="marital_status">Marital Status</a>
                            </li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo $result["Web_Url"]; ?>leave-type" data-toggle="dropdown" data-i18n="leave_type">Leave Type</a>
                            </li>
                        </ul>
                    </li>


                    <!-- Master Employee -->
                    <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="la la-user"></i><span data-i18n="master_employee">Master Employee</span></a>
                        <ul class="dropdown-menu">
                            <li data-menu=""><a class="dropdown-item" href="<?php echo $result["Web_Url"]; ?>add-employee" data-toggle="dropdown" data-i18n="add_employee">Add Employee</a>
                            </li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo $result["Web_Url"]; ?>employee-list" data-toggle="dropdown" data-i18n="employee_list">Employee List</a>
                            </li>
                        </ul>
                    </li>


                    <!-- Accounts -->
                    <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="la la-files-o"></i><span data-i18n="accounts">Accounts</span></a>
                        <ul class="dropdown-menu">
                            <li data-menu=""><a class="dropdown-item" href="<?php echo $result["Web_Url"]; ?>invoice" data-toggle="dropdown" data-i18n="invoice">Invoice</a>
                            </li>
                            <!-- <li data-menu=""><a class="dropdown-item" href="<?php echo $result["Web_Url"]; ?>expenses" data-toggle="dropdown" data-i18n="expenses">Expenses</a>
                            </li> -->
                            <li data-menu=""><a class="dropdown-item" href="<?php echo $result["Web_Url"]; ?>assets" data-toggle="dropdown" data-i18n="assets">Assets</a>
                            </li>
                            <!-- <li data-menu=""><a class="dropdown-item" href="<?php echo $result["Web_Url"]; ?>taxes" data-toggle="dropdown" data-i18n="taxes">Taxes</a>
                            </li> -->
                        </ul>
                    </li>


                    <!-- Payroll -->
                    <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="la la-money"></i><span data-i18n="payroll">Payroll</span></a>
                        <ul class="dropdown-menu">
                            <li data-menu=""><a class="dropdown-item" href="<?php echo $result["Web_Url"]; ?>add-earning" data-toggle="dropdown" data-i18n="add_earning">Add Earning</a>
                            </li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo $result["Web_Url"]; ?>update-earning" data-toggle="dropdown" data-i18n="earning_update">Earning Update</a>
                            </li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo $result["Web_Url"]; ?>deduction" data-toggle="dropdown" data-i18n="add_deduction">Add Deduction</a>
                            </li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo $result["Web_Url"]; ?>employee-leave" data-toggle="dropdown" data-i18n="employee_leave">Employee Leave</a>
                            </li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo $result["Web_Url"]; ?>payroll-item" data-toggle="dropdown" data-i18n="payroll_item">Add Payroll Items</a>
                            </li>

                            <li data-menu=""><a class="dropdown-item" href="<?php echo $result["Web_Url"]; ?>manage-payroll" data-toggle="dropdown" data-i18n="manage_payroll">Manage Employee Payroll</a>
                            </li>
                        </ul>
                    </li>



                    <!-- Report -->
                    <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="la la-bar-chart"></i><span data-i18n="report">Report</span></a>
                        <ul class="dropdown-menu">
                            <li data-menu=""><a class="dropdown-item" href="<?php echo $result["Web_Url"]; ?>worksheet" data-toggle="dropdown" data-i18n="payroll_worksheet">Payroll Worksheet</a>
                            </li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo $result["Web_Url"]; ?>payroll-summary" data-toggle="dropdown" data-i18n="payroll_summary">Payroll Summary</a>
                            </li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo $result["Web_Url"]; ?>salary-report" data-toggle="dropdown" data-i18n="monthly_salary">Monthly Salary</a>
                            </li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo $result["Web_Url"]; ?>row-report" data-toggle="dropdown" data-i18n="list_of_rows">List of Rows</a>
                            </li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo $result["Web_Url"]; ?>aguinaldo" data-toggle="dropdown" data-i18n="employee_aguinaldo">Employee Aguinaldo</a>
                            </li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo $result["Web_Url"]; ?>employee-history" data-toggle="dropdown" data-i18n="history_of_employee">History of Employee</a>
                            </li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo $result["Web_Url"]; ?>leave-report" data-toggle="dropdown" data-i18n="leave_report">Leave Report</a>
                            </li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo $result["Web_Url"]; ?>salary-letter" data-toggle="dropdown" data-i18n="salary_letter">Salary Letter</a>
                            </li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo $result["Web_Url"]; ?>payment-proof" data-toggle="dropdown" data-i18n="payment_proof">Payment Proof</a>
                            </li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo $result["Web_Url"]; ?>journal-report" data-toggle="dropdown" data-i18n="journal_report">Journal Report</a>
                            </li>
                        </ul>
                    </li>


                    <!-- Contract Completion -->
                    <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="la la-graduation-cap"></i><span data-i18n="contract_completion">Contract Completion</span></a>
                        <ul class="dropdown-menu">
                            <li data-menu=""><a class="dropdown-item" href="<?php echo $result["Web_Url"]; ?>completion" data-toggle="dropdown" data-i18n="contract_completion">Contract Completion</a>
                            </li>

                        </ul>
                    </li>



                    <!-- Settings -->
                    <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="la la-gear"></i><span data-i18n="settings">Settings</span></a>
                        <ul class="dropdown-menu">
                            <li data-menu=""><a class="dropdown-item" href="<?php echo $result["Web_Url"]; ?>company-settings" data-toggle="dropdown" data-i18n="company_setting">Company Settings</a>
                            </li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo $result["Web_Url"]; ?>localization" data-toggle="dropdown" data-i18n="localization">Localization</a>
                            </li>
                            <li class="active" data-menu=""><a class="dropdown-item" href="<?php echo $result["Web_Url"]; ?>theme-settings" data-toggle="dropdown" data-i18n="theme_setting">Theme Settings</a>
                            </li>
                            <li class="active" data-menu=""><a class="dropdown-item" href="<?php echo $result["Web_Url"]; ?>roles-permissions" data-toggle="dropdown" data-i18n="role_permission">Roles & Permissions</a>
                            </li>
                            <li class="active" data-menu=""><a class="dropdown-item" href="<?php echo $result["Web_Url"]; ?>email-settings" data-toggle="dropdown" data-i18n="email_setting">Email Settings</a>
                            </li>
                            <li class="active" data-menu=""><a class="dropdown-item" href="<?php echo $result["Web_Url"]; ?>change-password" data-toggle="dropdown" data-i18n="change_password">Change Password</a>
                            </li>
                        </ul>
                    </li>


                    <!-- Projects -->
                    <!-- Clients -->
                    <!-- Users -->
                    <!-- Assets -->
                    <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="la la-ellipsis-h"></i><span data-i18n="more">More...</span></a>
                        <ul class="dropdown-menu">
                            <li data-menu=""><a class="dropdown-item" href="<?php echo $result["Web_Url"]; ?>projects" data-toggle="dropdown" data-i18n="projects">Projects</a>
                            </li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo $result["Web_Url"]; ?>clients" data-toggle="dropdown" data-i18n="clients">Clients</a>
                            </li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo $result["Web_Url"]; ?>users" data-toggle="dropdown" data-i18n="users">Users</a>
                            </li>
                            <!--<li data-menu=""><a class="dropdown-item" href="<?php echo $result["Web_Url"]; ?>assets" data-toggle="dropdown" data-i18n="assets">Assets</a>
                            </li>-->
                        </ul>
                    </li>

                </ul>
            </div>
        </div>
    <?php
} else {
    ?>

        <body class="vertical-layout vertical-menu-modern <?php echo $theme_data["Display_Mode"] == 'Dark' ? 'dark-mode' : 'light-mode'; ?> content-detached-left-sidebar  fixed-navbar menu-expanded" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
            <!-- fixed-top-->
            <nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top <?php echo $theme_data["Display_Mode"] == 'Dark' ? 'navbar-semi-dark' : 'navbar-semi-light'; ?>  navbar-shadow">
                <div class="navbar-wrapper">
                    <div class="navbar-header">
                        <ul class="nav navbar-nav flex-row">
                            <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
                            <li class="nav-item mr-auto">
                                <a class="navbar-brand" href="index.html">
                                    <img class="brand-logo" alt="modern admin logo" src="public/app-assets/images/logo/logo.png">
                                    <h3 class="brand-text">Modern Admin</h3>
                                </a>
                            </li>
                            <li class="nav-item d-md-none">
                                <a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="la la-ellipsis-v"></i></a>
                            </li>
                        </ul>
                    </div>


                    <div class="navbar-container content">
                        <div class="collapse navbar-collapse" id="navbar-mobile">
                            <ul class="nav navbar-nav mr-auto float-left">
                                <li class="nav-item d-none d-md-block"><a class="nav-link nav-link-expand" href="#"><i class="ficon ft-maximize"></i></a></li>


                                <li class="nav-item d-none d-md-block float-right"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="toggle-icon ft-toggle-right font-medium-3 dark" data-ticon="ft-toggle-right"></i></a></li>


                            </ul>
                            <ul class="nav navbar-nav float-right">
                                <li class="dropdown dropdown-usernav-item has-sub">
                                    <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                                        <span class="mr-1">Hello,
                                            <span class="user-name text-bold-700">John Doe</span>
                                        </span>
                                        <span class="avatar avatar-online">
                                            <img src="../../../app-assets/images/portrait/small/avatar-s-19.png" alt="avatar"><i></i></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#"><i class="ft-power"></i> Logout</a>
                                    </div>
                                </li>
                                <li class="dropdown dropdown-languagenav-item has-sub"><a class="dropdown-toggle nav-link" id="dropdown-flag" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="flag-icon flag-icon-gb"></i><span class="selected-language"></span></a>
                                    <div class="dropdown-menu" aria-labelledby="dropdown-flag"><a class="dropdown-item" href="#"><i class="flag-icon flag-icon-gb"></i> English</a>
                                        <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-fr"></i> French</a>
                                        <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-cn"></i> Chinese</a>
                                        <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-de"></i> German</a>
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="main-menu menu-fixed <?php echo $theme_data["Display_Mode"] == 'Dark' ? 'menu-dark' : 'menu-light'; ?> menu-accordion menu-shadow" data-scroll-to-active="true">
                <div class="main-menu-content">
                    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">

                        <!-- Home -->
                        <li class="nav-item"><a href="dashboard"><i class="la la-home"></i><span class="menu-title" data-i18n="dashboard">Dashboard</span></a>
                        </li>


                        <!-- Performance -->
                        <li class="nav-item has-sub"><a href="#"><i class="la la-pie-chart"></i><span class="menu-title" data-i18n="performance">Performance</span></a>
                            <ul class="menu-content">
                                <li <?php echo strpos($server, 'file-management') ? 'class="active"' : '' ?>><a class="menu-item" href="<?php echo $result["Web_Url"]; ?>file-management" data-i18n="add_employee">File Manager</a>
                                </li>
                                <li <?php echo strpos($server, 'subscription') ? 'class="active"' : '' ?>><a class="menu-item" href="<?php echo $result["Web_Url"]; ?>subscription" data-i18n="subscription">Subscription</a>
                                </li>
                            </ul>
                        </li>

                        <!-- Configuration -->
                        <li class="nav-item has-sub"><a href="#"><i class="la la-wrench"></i><span class="menu-title" data-i18n="configuration">Configuration</span></a>
                            <ul class="menu-content">
                                <li <?php echo strpos($server, 'branch-setting') ? 'class="active"' : '' ?>><a class="menu-item" href="<?php echo $result["Web_Url"]; ?>branch-setting" data-i18n="branch_setting">Branch Setting</a>
                                </li>
                                <li <?php echo strpos($server, 'department-setting') ? 'class="active"' : '' ?>><a class="menu-item" href="<?php echo $result["Web_Url"]; ?>department-setting" data-i18n="department_setting">Department Setting</a>
                                </li>
                                <li <?php echo strpos($server, 'journal-setting') ? 'class="active"' : '' ?>><a class="menu-item" href="<?php echo $result["Web_Url"]; ?>journal-setting" data-i18n="journal_setting">Journal Setting</a>
                                </li>
                                <li <?php echo strpos($server, 'salary-tax-settings') ? 'class="active"' : '' ?>><a class="menu-item" href="<?php echo $result["Web_Url"]; ?>salary-tax-settings" data-i18n="salary_tax">Salary & Tax Settings</a>
                                </li>
                                <li <?php echo strpos($server, 'social-security-settings') ? 'class="active"' : '' ?>><a class="menu-item" href="<?php echo $result["Web_Url"]; ?>social-security-settings" data-i18n="social_security">Social Security Settings</a>
                                </li>
                                <li <?php echo strpos($server, 'association-settings') ? 'class="active"' : '' ?>><a class="menu-item" href="<?php echo $result["Web_Url"]; ?>association-settings" data-i18n="association">Association Settings</a>
                                </li>
                                <li <?php echo strpos($server, 'currency') ? 'class="active"' : '' ?>><a class="menu-item" href="<?php echo $result["Web_Url"]; ?>currency" data-i18n="currency">Currency </a>
                                </li>
                                <li <?php echo strpos($server, 'vacation-setting') ? 'class="active"' : '' ?>><a class="menu-item" href="<?php echo $result["Web_Url"]; ?>vacation-setting" data-i18n="vacation_setting">Vacation Settings</a>
                                </li>
                                <li <?php echo strpos($server, 'family-tax') ? 'class="active"' : '' ?>><a class="menu-item" href="<?php echo $result["Web_Url"]; ?>family-tax" data-i18n="family_tax">Family Tax </a>
                                </li>
                                <li <?php echo strpos($server, 'marital-status') ? 'class="active"' : '' ?>><a class="menu-item" href="<?php echo $result["Web_Url"]; ?>marital-status" data-i18n="marital_status">Marital Status </a>
                                </li>
                                <li <?php echo strpos($server, 'leave-type') ? 'class="active"' : '' ?>><a class="menu-item" href="<?php echo $result["Web_Url"]; ?>leave-type" data-i18n="leave_type">Leave Type </a>
                                </li>
                            </ul>
                        </li>



                        <!-- Master Employee -->
                        <li class="nav-item has-sub"><a href="#"><i class="la la-user"></i><span class="menu-title" data-i18n="master_employee">Master Employee</span></a>
                            <ul class="menu-content">
                                <li <?php echo strpos($server, 'add-employee') || strpos($server, 'edit-employee') ? 'class="active"' : '' ?>><a class="menu-item" href="<?php echo $result["Web_Url"]; ?>add-employee" data-i18n="add_employee">Add Employee</a>
                                </li>
                                <li <?php echo strpos($server, 'employee-list') || strpos($server, 'view-employee') ? 'class="active"' : '' ?>><a class="menu-item" href="<?php echo $result["Web_Url"]; ?>employee-list" data-i18n="employee_list">Employee List</a>
                                </li>
                            </ul>
                        </li>


                        <!-- Project -->
                        <li <?php echo strpos($server, 'projects') ? 'class="active"' : '' ?> class="nav-item"><a href="<?php echo $result["Web_Url"]; ?>projects"><i class="la la-rocket"></i><span class="menu-title" data-i18n="projects">Projects</span></a>
                        </li>


                        <!-- Clients -->
                        <li <?php echo strpos($server, 'clients') ? 'class="active"' : '' ?> class="nav-item"><a href="<?php echo $result["Web_Url"]; ?>clients"><i class="la la-group"></i><span class="menu-title" data-i18n="clients">Clients</span></a>
                        </li>


                        <!-- User -->
                        <li <?php echo strpos($server, 'users') ? 'class="active"' : '' ?> class="nav-item"><a href="<?php echo $result["Web_Url"]; ?>users"><i class="la la-user-plus"></i><span class="menu-title" data-i18n="users">Users</span></a>
                        </li>

                        <!-- Assets 
                        <li <?php echo strpos($server, 'assets') ? 'class="active"' : '' ?> class="nav-item"><a href="<?php echo $result["Web_Url"]; ?>assets"><i class="la la-object-ungroup"></i><span class="menu-title" data-i18n="assets">Assets</span></a>
                        </li>-->


                        <!-- Accounts -->
                        <li class="nav-item has-sub"><a href="#"><i class="la la-files-o"></i><span class="menu-title" data-i18n="accounts">Accounts</span></a>
                            <ul class="menu-content">
                                <li <?php echo strpos($server, 'invoice') || strpos($server, 'create-invoice') ? 'class="active"' : '' ?>><a class="menu-item" href="<?php echo $result["Web_Url"]; ?>invoice" data-i18n="invoice">Invoice</a>
                                </li>
                                <!--<li <?php echo strpos($server, 'expenses') ? 'class="active"' : '' ?>><a class="menu-item" href="<?php echo $result["Web_Url"]; ?>expenses" data-i18n="expenses">Expenses</a>
                        </li>-->
                                <li <?php echo strpos($server, 'assets') ? 'class="active"' : '' ?>><a class="menu-item" href="<?php echo $result["Web_Url"]; ?>assets" data-i18n="assets">Assets</a>
                                </li>

                                <!-- <li <?php echo strpos($server, 'taxes') ? 'class="active"' : '' ?>><a class="menu-item" href="<?php echo $result["Web_Url"]; ?>taxes" data-i18n="taxes">Taxes</a>
                        </li> -->

                            </ul>
                        </li>


                        <!-- Payroll -->
                        <li class="nav-item has-sub"><a href="#"><i class="la la-money"></i><span class="menu-title" data-i18n="payroll">Payroll</span></a>
                            <ul class="menu-content">
                                <li <?php echo strpos($server, 'add-earning') ? 'class="active"' : '' ?>><a class="menu-item" href="<?php echo $result["Web_Url"]; ?>add-earning" data-i18n="add_earning">Add Earning</a>
                                </li>
                                <li <?php echo strpos($server, 'update-earning') ? 'class="active"' : '' ?>><a class="menu-item" href="<?php echo $result["Web_Url"]; ?>update-earning" data-i18n="earning_update">Earning Update</a>
                                </li>

                                <li <?php echo strpos($server, 'deduction') ? 'class="active"' : '' ?>><a class="menu-item" href="<?php echo $result["Web_Url"]; ?>deduction" data-i18n="add_deduction">Add Deduction</a>
                                </li>
                                <li <?php echo strpos($server, 'employee-leave')  !== false ? 'class="active"' : '' ?>><a class="menu-item" href="<?php echo $result["Web_Url"]; ?>employee-leave" data-i18n="employee_leave">Employee Leave</a>
                                </li>
                                <li <?php echo strpos($server, 'payroll-item') ? 'class="active"' : '' ?>><a class="menu-item" href="<?php echo $result["Web_Url"]; ?>payroll-item" data-i18n="add_earning">Add Payroll Items</a>
                                </li>

                                <li <?php echo strpos($server, 'manage-payroll') ? 'class="active"' : '' ?>><a class="menu-item" href="<?php echo $result["Web_Url"]; ?>manage-payroll" data-i18n="manage_payroll">Manage Employee Payroll</a>
                                </li>
                            </ul>
                        </li>

                        <!-- Reports -->
                        <li class="nav-item has-sub "><a href="#"><i class="la la-bar-chart"></i><span class="menu-title" data-i18n="report">Report</span></a>
                            <ul class="menu-content">
                                <li <?php echo strpos($server, 'worksheet') ? 'class="active"' : '' ?>><a class="menu-item" href="<?php echo $result["Web_Url"]; ?>worksheet" data-i18n="payroll_worksheet">Payroll Worksheet</a>
                                </li>
                                <li <?php echo strpos($server, 'payroll-summary') ? 'class="active"' : '' ?>><a class="menu-item" href="<?php echo $result["Web_Url"]; ?>payroll-summary" data-i18n="payroll_summary">Payroll Summary</a>
                                </li>
                                <li <?php echo strpos($server, 'salary-report') ? 'class="active"' : '' ?>><a class="menu-item" href="<?php echo $result["Web_Url"]; ?>salary-report" data-i18n="monthly_salary">Monthly Salary</a>
                                </li>
                                <li <?php echo strpos($server, 'row-report') ? 'class="active"' : '' ?>><a class="menu-item" href="<?php echo $result["Web_Url"]; ?>row-report" data-i18n="list_of_rows">List of Rows</a>
                                </li>
                                <li <?php echo strpos($server, 'aguinaldo') ? 'class="active"' : '' ?>><a class="menu-item" href="<?php echo $result["Web_Url"]; ?>aguinaldo" data-i18n="employee_aguinaldo">Employee Aguinaldo</a>
                                </li>
                                <li <?php echo strpos($server, 'employee-history') ? 'class="active"' : '' ?>><a class="menu-item" href="<?php echo $result["Web_Url"]; ?>employee-history" data-i18n="history_of_employee">History of Employee </a>
                                </li>
                                <li <?php echo strpos($server, 'leave-report') !== false ? 'class="active"' : '' ?>><a class="menu-item" href="<?php echo $result["Web_Url"]; ?>leave-report" data-i18n="leave_report">Leave Report </a>
                                </li>
                                <li <?php echo strpos($server, 'salary-letter') ? 'class="active"' : '' ?>><a class="menu-item" href="<?php echo $result["Web_Url"]; ?>salary-letter" data-i18n="salary_letter">Salary Letter </a>
                                </li>

                                <li <?php echo strpos($server, 'payment-proof') ? 'class="active"' : '' ?>><a class="menu-item" href="<?php echo $result["Web_Url"]; ?>payment-proof" data-i18n="payment_proof">Payment Proof </a>
                                </li>
                                <li <?php echo strpos($server, 'journal-report') ? 'class="active"' : '' ?>><a class="menu-item" href="<?php echo $result["Web_Url"]; ?>journal-report" data-i18n="journal_report">Journal Report </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Contract Completion -->
                        <li class="nav-item <?php echo strpos($server, 'completion') ? 'active' : '' ?>"><a href="<?php echo $result["Web_Url"]; ?>completion"><i class="la la-graduation-cap"></i><span class="menu-title" data-i18n="contract_completion">Contract Completion</span></a>
                        </li>

                        <!-- Settings -->
                        <li class="nav-item has-sub "><a href="#"><i class="la la-gear"></i><span class="menu-title" data-i18n="nav.invoice.main">Settings</span></a>
                            <ul class="menu-content">
                                <li <?php echo strpos($server, 'company-settings') ? 'class="active"' : '' ?>><a class="menu-item" href="<?php echo $result["Web_Url"]; ?>company-settings" data-i18n="company_setting">Company Settings</a>
                                </li>
                                <li <?php echo strpos($server, 'localization') ? 'class="active"' : '' ?>><a class="menu-item" href="<?php echo $result["Web_Url"]; ?>localization" data-i18n="localization">Localization</a>
                                </li>
                                <li <?php echo strpos($server, 'theme-settings') ? 'class="active"' : '' ?>><a class="menu-item" href="<?php echo $result["Web_Url"]; ?>theme-settings" data-i18n="theme_setting">Theme Settings</a>
                                </li>
                                <li <?php echo strpos($server, 'roles-permissions') ? 'class="active"' : '' ?>><a class="menu-item" href="<?php echo $result["Web_Url"]; ?>roles-permissions" data-i18n="role_permission">Roles & Permissions</a>
                                </li>
                                <li <?php echo strpos($server, 'email-settings') ? 'class="active"' : '' ?>><a class="menu-item" href="<?php echo $result["Web_Url"]; ?>email-settings" data-i18n="email_setting">Email Settings</a>
                                </li>

                                <li <?php echo strpos($server, 'change-password') ? 'class="active"' : '' ?>><a class="menu-item" href="<?php echo $result["Web_Url"]; ?>change-password" data-i18n="change_password">Change Password</a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </div>
            </div>
        <?php
    }
        ?>

        <div class="app-content content <?php echo $theme_data["Display_Mode"] == 'Dark' ? 'dark-mode-text' : 'light-mode-text'; ?>">



            <!-- ////////////////////////////////////////////////////////////////////////////-->


            <?php require_once("popup.php"); ?>