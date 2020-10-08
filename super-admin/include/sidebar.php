<?php include("pop-up.php"); ?>

<body class="vertical-layout vertical-menu-modern 2-columns   menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
    <!-- fixed-top-->
    <nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-dark navbar-shadow">
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

                </ul>
            </div>
            <div class="navbar-container content">
                <div class="collapse navbar-collapse" id="navbar-mobile">
                    <ul class="nav navbar-nav mr-auto float-left">
                        <li class="nav-item d-none d-md-block"><a class="nav-link nav-link-expand" href="#"><i class="ficon ft-maximize"></i></a></li>


                    </ul>
                    <ul class="nav navbar-nav float-right">
                        <li class="dropdown dropdown-user nav-item">
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
                        <li class="dropdown dropdown-language nav-item"><a class="dropdown-toggle nav-link" id="dropdown-flag" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="flag-icon flag-icon-gb"></i><span class="selected-language"></span></a>
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
    <!-- ////////////////////////////////////////////////////////////////////////////-->
    <div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">

                <li class=" navigation-header">
                    <span data-i18n="nav.category.forms">Home</span><i class="la la-ellipsis-h ft-minus" data-toggle="tooltip" data-placement="right" data-original-title="Forms"></i>
                </li>

                <li class=" nav-item"><a href="<?php echo $result["Web_Url"]; ?>admin-dashboard"><i class="la la-dashboard"></i><span class="menu-title" data-i18n="">Dashboard</span></a>
                </li>

                <li class=" nav-item"><a href="<?php echo $result["Web_Url"]; ?>registered-company"><i class="la la-bank"></i><span class="menu-title" data-i18n="">Registered Company</span></a>
                </li>

                <li class=" nav-item"><a href="<?php echo $result["Web_Url"]; ?>subscription-package"><i class="la la-hand-pointer-o"></i><span class="menu-title" data-i18n="">Subscription Package</span></a>
                </li>

                <li class=" nav-item"><a href="<?php echo $result["Web_Url"]; ?>general-settings"><i class="la la-gear"></i><span class="menu-title" data-i18n="">Settings</span></a>
                </li>

                <input type="hidden" id="static_url" value="<?php echo $result["Web_Url"]; ?>">
            </ul>
        </div>
    </div>