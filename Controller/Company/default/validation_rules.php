<?php

$GLOBALS["validations"] = array(
    "add_user" => array(
        "first_name" => array(
            "name" => "First Name",
            'required' => "required",
        ),
        "last_name" => array(
            "name" => "Last Name",
            'required' => "required",
        ),
        "username" => array(
            "name" => "Username",
            'required' => "required",
        ),
        "email" => array(
            "name" => "Email",
            "user_email_unique" => true,
            "email_matches" => true,
            "required" => "required",
        ),
        "password" => array(
            "name" => "Password",
            'required' => "required",
        ),
        "confirm_password" => array(
            "name" => "Confirm Password",
            'required' => "required",
            'confirm_match' => 'password',
        ),
        "phone_number" => array(
            "name" => "Phone Number",
            'required' => "required",
        ),
        "access_permission" => array(
            "name" => "Access Permission",
            'required' => "required",
        ),

    ),

);
