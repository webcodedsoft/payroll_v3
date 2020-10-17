<?php error_reporting(0); require_once("data_connection.php"); ?>

<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Modern admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities with bitcoin dashboard.">
    <meta name="keywords" content="admin template, modern admin template, dashboard template, flat admin template, responsive admin template, web app, crypto dashboard, bitcoin dashboard">
    <meta name="author" content="PIXINVENT">
    <title>Dashboard eCommerce - Modern Admin - Clean Bootstrap 4 Dashboard HTML Template
        + Bitcoin Dashboard</title>
    <link rel="apple-touch-icon" href="<?php echo $result["Web_Url"]; ?>public/app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo $result["Web_Url"]; ?>public/app-assets/images/ico/favicon.ico">
    <!-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Quicksand:300,400,500,700" rel="stylesheet">
    <link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css" rel="stylesheet"> -->
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo $result["Web_Url"]; ?>public/app-assets/css/vendors.css">

    <link rel="stylesheet" type="text/css" href="<?php echo $result["Web_Url"]; ?>public/app-assets/vendors/css/ui/jquery-ui.min.css">


    <link rel="stylesheet" type="text/css" href="<?php echo $result["Web_Url"]; ?>public/app-assets/fonts/meteocons/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $result["Web_Url"]; ?>public/app-assets/vendors/css/tables/datatable/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $result["Web_Url"]; ?>public/app-assets/vendors/css/tables/extensions/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $result["Web_Url"]; ?>public/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css">

    <link rel="stylesheet" type="text/css" href="<?php echo $result["Web_Url"]; ?>public/app-assets/fonts/line-awesome/css/line-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $result["Web_Url"]; ?>public/app-assets/vendors/css/forms/selects/select2.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $result["Web_Url"]; ?>public/app-assets/css/custom.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $result["Web_Url"]; ?>public/app-assets/css/plugins/loaders/loaders.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $result["Web_Url"]; ?>public/app-assets/css/core/colors/palette-loader.css">
    <!-- END VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo $result["Web_Url"]; ?>public/app-assets/css/core/menu/menu-types/vertical-menu-modern.css">

    <!-- BEGIN MODERN CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo $result["Web_Url"]; ?>public/app-assets/css/app.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $result["Web_Url"]; ?>public/app-assets/vendors/css/tables/jsgrid/jsgrid-theme.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $result["Web_Url"]; ?>public/app-assets/vendors/css/tables/jsgrid/jsgrid.min.css">

    <!-- END MODERN CSS-->




    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo $result["Web_Url"]; ?>public/app-assets/css/core/menu/menu-types/vertical-menu-modern.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $result["Web_Url"]; ?>public/app-assets/css/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $result["Web_Url"]; ?>public/app-assets/fonts/simple-line-icons/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $result["Web_Url"]; ?>public/app-assets/css/pages/dashboard-ecommerce.css">
    <!-- END Page Level CSS-->

    <link rel="stylesheet" type="text/css" href="<?php echo $result["Web_Url"]; ?>public/app-assets/css/plugins/ui/jqueryui.css">


    <!-- BEGIN Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo $result["Web_Url"]; ?>public/app-assets/vendors/css/extensions/sweetalert.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $result["Web_Url"]; ?>public/app-assets/css/plugins/extensions/toastr.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $result["Web_Url"]; ?>public/app-assets/vendors/css/extensions/toastr.css">
    <!-- END Custom CSS-->



</head>

<input type="hidden" id="static_url" value="<?php echo $result["Web_Url"]; ?>">

<!-- <?php

if (!strpos($server, 'setup')) {
    include("../include/sidebar.php");
}

?> -->