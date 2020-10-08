<?php
require_once("../../core/init/init.php");
require_once("validation_rules.php");

$admin_model = new Model_Admin_Admin();

$_query = Classes_Db::getInstance();
$validate = new Classes_Validations();

//Create Company
if (isset($_POST["create_company_btn"])) {
    if (Classes_Inputs::exists('post')) {

        if(!empty(Classes_Inputs::get("_id"))){

            $create_result = $admin_model->UpdateCompany(Classes_Inputs::get("company_email"), Classes_Inputs::get("company_id"), Classes_Inputs::get("_id"));
            if($create_result){
                echo json_encode(array("Company Successfully Updated"));
            }
           
        } else {

            $validation = $validate->checkRules($_POST, $GLOBALS["validations"]["create_company"]); //["company_email"]
            if ($validation->passed()) {
                $create_result = $admin_model->CreateCompany(Classes_Inputs::get("company_email"), Classes_Inputs::get("company_id"), Classes_Inputs::get("company_id"));
                echo json_encode(array("Company Successfully Created"));
            } else {
                //var_dump($validation->errors());
                echo json_encode($validation->errors());
            }
        }

        
    }

    
}

//Web Settings
if (isset($_POST["web_settings_btn"])) {
    if (Classes_Inputs::exists('post')) {
       
            $web_config_result = $admin_model->Web_Config(Classes_Inputs::get("phone_number"), Classes_Inputs::get("web_url"));
            if($web_config_result->count() > 0)
            {
            echo json_encode("Setting Successfully Change");
            }
            
            //var_dump($create_result);
          
    }
}


//Create Package
if (isset($_POST["package_button"])) {
    if (Classes_Inputs::exists('post')) {

        if (!empty(Classes_Inputs::get("edit_package_id"))) {

            $create_result = $admin_model->UpdatePackage(
                Classes_Inputs::get("plan_name"),
                Classes_Inputs::get("plan_amount"),
                Classes_Inputs::get("plan_type"),
                Classes_Inputs::get("no_user"),
                Classes_Inputs::get("plan_duration"),
                Classes_Inputs::get("storage_space"),
                Classes_Inputs::get("package_status"),
                Classes_Inputs::get("edit_package_id")
            );
            echo json_encode(array("Package Plan Successfully Updated"));

        } else {

           $validation = $validate->checkRules($_POST, $GLOBALS["validations"]["plan_creation"]);

            if ($validation->passed()) {

                $create_result = $admin_model->CreatePackage(
                    Classes_Inputs::get("plan_name"), 
                    Classes_Inputs::get("plan_amount"),
                    Classes_Inputs::get("plan_type"),
                    Classes_Inputs::get("no_user"),
                    Classes_Inputs::get("plan_duration"),
                    Classes_Inputs::get("storage_space"),
                    Classes_Inputs::get("package_status"
                ));

                echo json_encode(array("Package Plan Successfully Created"));
            } else {
                //var_dump($validation->errors());
                echo json_encode($validation->errors());
            }

        }
        
        
        //var_dump($create_result);

    }
}




//Fetching Package Plan for editing
if (isset($_POST["edit_package_btn"])) {

    if (Classes_Inputs::exists('post')) {
        $result = $_query->get('package_plan', array('ID', '=', Classes_Inputs::get('edit_package_id')));
        if ($result->count()) {
            $result->first();
            echo json_encode(array($result->first()));
        }
    }
}







//Registered Company List
if (isset($_POST["registered_company_list_access"])) {
    $company_list_result = $admin_model->LoadRegisterCompany();
}

//Delete Registered Company
if(isset($_POST["delete_function"])){
    if (Classes_Inputs::exists('post')) {

        if($_POST["delete_function"] === 'delete_company'){
            $company_delete_result = $admin_model->DeleteCompany(Classes_Inputs::get("delete_value"));
        } elseif ($_POST["delete_function"] === 'delete_package') {
            $package_delete_result = $admin_model->DeletePackage(Classes_Inputs::get("delete_value"));
        }
    }
}


//Fetching Registered Company for editing
if(isset($_POST["edit_company_btn"])){
    
    if (Classes_Inputs::exists('post')) {
        $result = $_query->get('company', array('ID', '=', Classes_Inputs::get('edit_company_id') ));
        if($result->count()){
            $result->first();
            echo json_encode(array($result->first() ));
        }
        
    }
}



//Fetching Subscription Package List
if(isset($_POST["subscription_package_list_access"])){
    $package_list_result = $admin_model->LoadSubscriptionPackage(Classes_Inputs::get("company_subscription_package_list_access"));
}



//Registered Company List
if (isset($_POST["complete_registered_company_list_access"])) {
    $company_list_result = $admin_model->CompleteRegisteredCompany();
}


//Company Status off/on
if(isset($_POST["company_status_btn"])){
    $company_status_result = $admin_model->CompanyStatus(Classes_Inputs::get("company_status_id"), Classes_Inputs::get("company_status"));
}


if(isset($_POST["package_plan_upgrade_btn"])){
    $company_list_result = $admin_model->SubscriptionUpgrade(Classes_Inputs::get("__package_id"), Classes_Inputs::get("__company_id"));

    if($company_list_result){
        echo json_encode(array("Company Plan Successfully Upgrade"));
    }
}