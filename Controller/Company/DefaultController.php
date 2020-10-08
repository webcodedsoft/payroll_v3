<?php
require_once("../../core/init/init.php");

$default_model = new Model_Company_DefaultModel();

$_query = Classes_Db::getInstance();

 

if (isset($_POST["company_setup_btn"])) {
    if (Classes_Inputs::exists('post')) {

        $comp_data = $_query->get('company', array('Company_Email', '=', Classes_Session::get('Setup_Session')));
        $comp_data = $comp_data->first();

        $company_UID = $comp_data["Subscriber_ID"];
        $company_email = $comp_data["Company_Email"];
        $company_logo = $comp_data["Company_Logo"];
        $plan_status = $comp_data["Plan_Status"];

        $upload_reponse = Classes_Upload::uploading($_FILES['company_logo'], Classes_Inputs::get("company_name"), $company_UID."/Logo");

        if ($upload_reponse["Status"] == 'Done' || $upload_reponse["Status"] == 'No Image') {

            $upload_reponse_new = $upload_reponse["Message"] != false ? $upload_reponse["Message"] : $company_logo;

            $default_model = $default_model->CompanySetup($company_UID, $company_email, $upload_reponse_new, $plan_status, Classes_Inputs::get("company_name"), Classes_Inputs::get("company_phone_number"), Classes_Inputs::get("company_website"), Classes_Inputs::get("company_header_report"), Classes_Inputs::get("authorize_signature_name"), Classes_Inputs::get("company_username"), Classes_Inputs::get("authorize_signature_position"), Classes_Inputs::get("company_password"), Classes_Inputs::get("company_address"));
            $response_result[] = array("Company Successfully Created");
            echo json_encode($response_result);

        } else {
            echo json_encode(array($upload_reponse["Message"]));
        }

    }
}


// if ($upload_reponse || !$upload_reponse) {
//     $upload_reponse = $upload_reponse != false ? $upload_reponse : $company_logo;
//     $default_model = $default_model->CompanySetup($company_UID, $company_email, $upload_reponse_new, $plan_status, Classes_Inputs::get("company_name"), Classes_Inputs::get("company_phone_number"), Classes_Inputs::get("company_website"), Classes_Inputs::get("company_header_report"), Classes_Inputs::get("authorize_signature_name"), Classes_Inputs::get("company_username"), Classes_Inputs::get("authorize_signature_position"), Classes_Inputs::get("company_password"), Classes_Inputs::get("company_address"));

//     $response_result[] = array("Company Successfully Created");
//     echo json_encode($response_result);
// } else {
//     echo json_encode(array("Something Went Wrong, Please Try Again"));
// }
