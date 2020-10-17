<?php
require_once("../../core/init/init.php");
//require_once("../Admin/validation_rules.php");

$role_permission_model = new Model_Company_SettingsModel();

$_query = Classes_Db::getInstance();


if (isset($_POST["role_permission_btn"])) {
   
    if (Classes_Inputs::exists('post')) {
        //var_dump(Classes_Inputs::get("module_access"));
        $role_permission_model = $role_permission_model->RolePermission(Classes_Inputs::get("module_access"), Classes_Inputs::get("role"), Classes_Inputs::get("module_permission_create"), Classes_Inputs::get("module_permission_read"), Classes_Inputs::get("module_permission_delete"), Classes_Inputs::get("module_permission_lock"), Classes_Inputs::get("module_permission_unlock") );
             //$response_result[] = array("Company Successfully Created");
            // echo json_encode($response_result);
       
    }
}
 

if(isset($_POST["create_role_btn"])){

    if(Classes_Inputs::exists('post')){
        $addrole_permission_model = $role_permission_model->AddRole(Classes_Inputs::get("role_name"));
    }
}


if(isset($_POST["fetch_role_name"])){
    if (Classes_Inputs::exists('post')) {
        $fetch_permission_model = $role_permission_model->FetchingPermissions(Classes_Inputs::get("fetch_role_name"));
    }
}



if(isset($_POST["delete_function"])){
    if(Classes_Inputs::exists('post')){
        $delete_permission_model = $role_permission_model->DeleteRole(Classes_Inputs::get("delete_value"));
    }
}


if(isset($_POST["edit_role_btn"])){
    if(Classes_Inputs::exists('post')){
        $edit_permission_model = $role_permission_model->EditRole(Classes_Inputs::get("role_name"), Classes_Inputs::get("role_id"));
    }
}



 
if (isset($_POST["company_setting_btn"])) {
    if (Classes_Inputs::exists('post')) {

       
        $comp_data = $_query->get('company', array('Subscriber_ID', '=', Classes_Session::get('Loggedin_Session')));
        $comp_data = $comp_data->first();
        

        $company_UID = $comp_data["Subscriber_ID"];
        $company_email = $comp_data["Company_Email"];
        $company_logo = $comp_data["Company_Logo"];
        $plan_status = $comp_data["Plan_Status"];

        $upload_reponse = Classes_Upload::uploading($_FILES['company_logo'], Classes_Inputs::get("company_name"), $company_UID."/Logo");

        if ($upload_reponse["Status"] == 'Done' || $upload_reponse["Status"] == 'No Image') {

            $upload_reponse_new = $upload_reponse["Message"] != false ? $upload_reponse["Message"] : $company_logo;
            $default_model = $role_permission_model->CompanyUpdate($upload_reponse_new, Classes_Inputs::get("company_name"), Classes_Inputs::get("company_email"), Classes_Inputs::get("company_id"), Classes_Inputs::get("company_phone_number"), Classes_Inputs::get("company_website"), Classes_Inputs::get("company_header_report"), Classes_Inputs::get("authorize_signature_name"), Classes_Inputs::get("authorize_signature_position"), Classes_Inputs::get("company_address"));

            $response_result[] = array("Company Successfully Update");
            echo json_encode($response_result);

        } else {
            echo json_encode(array($upload_reponse["Message"]));
        }
    }
}



if(isset($_POST["country_id"])){
    if (Classes_Inputs::exists('post')) {
        $country_data = $_query->get('country_currency', array('ID', '=', Classes_Inputs::get('country_id')));
        $country_data = $country_data->first();
        $response_result[] = array("Code" => $country_data["code"], "Symbol" => $country_data["hex"]);
        echo json_encode($response_result);
    }
}



if (isset($_POST["localization_btn"])) {
    if (Classes_Inputs::exists('post')) {
            $localization_model = $role_permission_model->Localization(Classes_Inputs::get("country"), Classes_Inputs::get("date_format"), Classes_Inputs::get("timezone"), Classes_Inputs::get("language"), Classes_Inputs::get("currency_code"), Classes_Inputs::get("currency_symbol"));
            $response_result[] = array("Data Successfully Change");
            echo json_encode($response_result);
    }
}


if (isset($_POST["theme_btn"])) {
    if (Classes_Inputs::exists('post')) {

        $theme_data = $_query->get('theme', array('Subscriber_ID', '=', Classes_Session::get('Loggedin_Session')));
        $theme_data = $theme_data->first();

        $_logo = $theme_data["Logo"];
        $_favicon = $theme_data["Favicon"];

        $upload_logo_reponse = Classes_Upload::uploading($_FILES['logo'], 'logo', Classes_Session::get('Loggedin_Session')."/Logo");
        $upload_favicon_reponse = Classes_Upload::uploading($_FILES['favicon'], 'favicon', Classes_Session::get('Loggedin_Session')."/Logo");


        if ($upload_logo_reponse["Status"] == 'Done' || $upload_logo_reponse["Status"] == 'No Image') {

            $upload_logo_reponse_new = $upload_logo_reponse["Message"] != false ? $upload_logo_reponse["Message"] : $_logo;
            $upload_favicon_reponse_new = $upload_favicon_reponse["Message"] != false ? $upload_favicon_reponse["Message"] : $_favicon;

            $theme_model = $role_permission_model->Theme($upload_logo_reponse_new, $upload_favicon_reponse_new, Classes_Inputs::get("website_name"), Classes_Inputs::get("display_mode"), Classes_Inputs::get("theme_orientation"));

            $response_result[] = array("Settings Successfully Change");
            echo json_encode($response_result);

        } else {
            echo json_encode(array($upload_reponse["Message"]));
        }

   
    }
}


if (isset($_POST["email_btn"])) {
    if (Classes_Inputs::exists('post')) {
        $email_model = $role_permission_model->Email(Classes_Inputs::get("host"), Classes_Inputs::get("user"), Classes_Inputs::get("password"), Classes_Inputs::get("port"), Classes_Inputs::get("security"), Classes_Inputs::get("domain"));
        $response_result[] = array("Settings Successfully Change");
        echo json_encode($response_result);
    }
}


if(isset($_POST["change_password_btn"])){
    if(Classes_Inputs::exists('post')){
        $password_model = $role_permission_model->ChangePassword(Classes_Inputs::get("old_password"), Classes_Inputs::get("new_password"), Classes_Inputs::get("confirm_password"));
    }
}