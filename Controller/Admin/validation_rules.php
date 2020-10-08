<?php

$GLOBALS["validations"] = array(
    "create_company" => array(
        "company_email" => array(
            "name" => "Company Email",
            "email_unique" => true,
            "email_matches" => true,
            "required" => "required",
        ),

        "company_id" => array(
            "name" => "Company ID",
            'unique_id' => true,
        ),
    ),

    "plan_creation" => array(
        //Package Rules
        "plan_name" => array(
            "name" => "Plan Name",
            "required" => "required",
        ),

        "plan_amount" => array(
            "name" => "Plan Amount",
            "is_number" => true,
            //"required" => "required",
        ),
        "plan_type" => array(
            "required" => "required",
            "name" => "Plan Type",
        ),
        "no_user" => array(
            "required" => "required",
            "name" => "Number of User",
        ),
        "plan_duration" => array(
            "required" => "required",
            "name" => "Plan Duration",
        ),
        "storage_space" => array(
            "required" => "required",
            "name" => "Plan Storage Space",
        ),
        
    ),
   

    
);
