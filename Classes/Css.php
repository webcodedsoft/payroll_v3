<?php

class Classes_Css{

    public static function getCss(){
        $data = new Controller_Company_Default_Datamanagement();
        $result = $data->WebData()->first();

        $html_code = '
         <link rel="stylesheet" type="text/css" href="' . $result["Web_Url"] . 'public/app-assets/css/vendors.css">

    <link rel="stylesheet" type="text/css" href="' . $result["Web_Url"] . 'public/app-assets/vendors/css/ui/jquery-ui.min.css">


    <link rel="stylesheet" type="text/css" href="' . $result["Web_Url"] . 'public/app-assets/fonts/meteocons/style.css">
    <link rel="stylesheet" type="text/css" href="' . $result["Web_Url"] . 'public/app-assets/vendors/css/tables/datatable/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="' . $result["Web_Url"] . 'public/app-assets/fonts/line-awesome/css/line-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="' . $result["Web_Url"] . 'public/app-assets/vendors/css/forms/selects/select2.min.css">
    <link rel="stylesheet" type="text/css" href="' . $result["Web_Url"] . 'public/app-assets/css/custom.css">
    <link rel="stylesheet" type="text/css" href="' . $result["Web_Url"] . 'public/app-assets/css/plugins/loaders/loaders.min.css">
    <link rel="stylesheet" type="text/css" href="' . $result["Web_Url"] . 'public/app-assets/css/core/colors/palette-loader.css">
    <!-- END VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="' . $result["Web_Url"] . 'public/app-assets/css/core/menu/menu-types/vertical-menu-modern.css">

    <!-- BEGIN MODERN CSS-->
    <link rel="stylesheet" type="text/css" href="' . $result["Web_Url"] . 'public/app-assets/css/app.css">
    <link rel="stylesheet" type="text/css" href="' . $result["Web_Url"] . 'public/app-assets/vendors/css/tables/jsgrid/jsgrid-theme.min.css">
    <link rel="stylesheet" type="text/css" href="' . $result["Web_Url"] . 'public/app-assets/vendors/css/tables/jsgrid/jsgrid.min.css">

    <!-- END MODERN CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="' . $result["Web_Url"] . 'public/app-assets/css/core/menu/menu-types/vertical-menu-modern.css">
    <link rel="stylesheet" type="text/css" href="' . $result["Web_Url"] . 'public/app-assets/css/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="' . $result["Web_Url"] . 'public/app-assets/fonts/simple-line-icons/style.css">
    <link rel="stylesheet" type="text/css" href="' . $result["Web_Url"] . 'public/app-assets/css/pages/dashboard-ecommerce.css">
    ';

    return $html_code;
    }
}