<?php
session_start();
error_reporting(0);
ob_start();

$GLOBALS["config"] = array(
    "mysql" => array(
        "hostname" => "us-cdbr-east-02.cleardb.com",
        "username" => "bff129ea04f84e",
        "password" => "983eb71e",
        "db_name" => "heroku_4e1379a3a4824c5"

    ),
    "remember_me" => array(
        "cookie_name" => "_payrollcookie",
        "cookie_expiry" => 50000
    ),

    "permission" => array(),

    "sessions" => array(
        "session_name" => "login_user"
    ),
);


spl_autoload_register(function($class){

    //$filename = str_replace('_', '/', strtolower($class)).'.php';
    $filename = str_replace('_', '/', $class) . '.php';
    $filenames = "../../".$filename;
    
    if (file_exists($filenames)) {
        require_once($filenames);
    }


});
