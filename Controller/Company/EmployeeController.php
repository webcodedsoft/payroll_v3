<?php
require_once("../../core/init/init.php");

$employee_model = new Model_Company_EmployeeModel();

$_query = Classes_Db::getInstance();



if(isset($_POST["employee_country_id"])){
    if(Classes_Inputs::exists('post')){
        $employee_model->getCountryState(Classes_Inputs::get('employee_country_id'));
    }
}


if(isset($_POST["add_employee_btn"])){
    if(Classes_Inputs::exists('post')){

        $employee_data = $_query->query('SELECT * FROM employee WHERE ID = ? AND Subscriber_ID = ?', array(Classes_Inputs::get('employee_id'), Classes_Session::get('Loggedin_Session')));
        $employee_data = $employee_data->first();
        

       
        $employee_image = $employee_data["Image"];

        $upload_reponse = Classes_Upload::uploading($_FILES['employee_image'], Classes_Inputs::get("employee_fullname"), Classes_Session::get('Loggedin_Session') . "/Employee_Image");

        if ($upload_reponse["Status"] == 'Done' || $upload_reponse["Status"] == 'No Image') {

            $upload_reponse_new = $upload_reponse["Message"] != false ? $upload_reponse["Message"] : $employee_image ;
            
            $employee_model->createCompany(
            Classes_Inputs::get('employee_id'), $upload_reponse_new, Classes_Inputs::get('employee_employee_id'),
            Classes_Inputs::get('employee_fullname'), Classes_Inputs::get('employee_lastname'),
            Classes_Inputs::get('employee_date_of_birth'), Classes_Inputs::get('employee_gender'),
            Classes_Inputs::get('employee_phone_number'), Classes_Inputs::get('employee_branch'),
            Classes_Inputs::get('employee_department'), Classes_Inputs::get('employee_position'),
            Classes_Inputs::get('employee_hiring_date'), Classes_Inputs::get('employee_address'),
            Classes_Inputs::get('employee_license'), Classes_Inputs::get('employee_marital_status'),
            Classes_Inputs::get('employee_country'), Classes_Inputs::get('employee_state'),
            Classes_Inputs::get('employee_religion'), Classes_Inputs::get('employee_no_of_children'),
            Classes_Inputs::get('emergency_primary_name'), Classes_Inputs::get('emergency_primary_relationship'),
            Classes_Inputs::get('emergency_primary_contact'), Classes_Inputs::get('emergency_secondary_name'),
            Classes_Inputs::get('emergency_secondary_relationship'), Classes_Inputs::get('emergency_secondary_contact'),
            Classes_Inputs::get('employee_bank_name'), Classes_Inputs::get('employee_account_number'),
            Classes_Inputs::get('employee_social_security_per'), Classes_Inputs::get('employee_association_per'),
            Classes_Inputs::get('employee_annual_vacation_day'), Classes_Inputs::get('employee_payment_type'),
            Classes_Inputs::get('employee_currency_type'), Classes_Inputs::get('employee_monthly_salary'),
            Classes_Inputs::get('employee_email_address'), Classes_Inputs::get('employee_password'),
        );
    } else {
            echo json_encode($upload_reponse["Message"]);
    }
      
    }
}


if(isset($_POST["employee_grid_access"])){
    if(Classes_Inputs::exists('post')){
        $employee_model->getEmployeeGridView();
    }
}


if (isset($_POST["employee_listt_access"])) {
    if (Classes_Inputs::exists('post')) {
        $employee_model->getEmployeeListView();
    }
}

    if (isset($_POST["delete_function"]) && $_POST["delete_function"] == "delete_employee") {
        if (Classes_Inputs::exists('post')) {
            $employee_model->deleteEmployee(Classes_Inputs::get('delete_value'));
            echo json_encode(array("Employee Successfully Deleted"));
        }
    }