<?php
require_once("../../core/init/init.php");

$configuration_model = new Model_Company_ConfigurationModel();

$_query = Classes_Db::getInstance();


if(isset($_POST["branch_submit_btn"])){
    if(Classes_Inputs::exists('post')){
        $configuration_model->AddBranch(Classes_Inputs::get("branch_id"), Classes_Inputs::get("branch_name"), Classes_Inputs::get("branch_address"), Classes_Inputs::get("branch_email"), Classes_Inputs::get("telephone1"), Classes_Inputs::get("telephone2"), Classes_Inputs::get("branch_status"));
    }
}

if(isset($_POST["branch_list_access"])){
    if(Classes_Inputs::exists("post")){
        $configuration_model->LoadBranch();
    }
}


if(isset($_POST["delete_function"]) && $_POST["delete_function"] == 'delete_branch'){
    if (Classes_Inputs::exists('post')) {
        $configuration_model->DeleteBranch(Classes_Inputs::get('delete_value'));
        echo json_encode(array("Deleted_Branch"));
    }
}

if(isset($_POST["edit_branch"])){
    if(Classes_Inputs::exists("post")){
        $result = $_query->get('branch', array('ID', '=', Classes_Inputs::get('branch_id')));
        if ($result->count()) {
            echo json_encode($result->first());
        }
    }
}


if (isset($_POST["department_submit_btn"])) {
    if (Classes_Inputs::exists('post')) {
        $configuration_model->AddDepartment(Classes_Inputs::get("department_id"), Classes_Inputs::get("department_name"), Classes_Inputs::get("department_desc"), Classes_Inputs::get("department_status"));
    }
}

if (isset($_POST["department_list_access"])) {
    if (Classes_Inputs::exists("post")) {
        $configuration_model->LoadDepartment();
    }
}


if (isset($_POST["delete_function"]) && $_POST["delete_function"] == 'delete_department') {
    if (Classes_Inputs::exists('post')) {
        $configuration_model->DeleteDepartment(Classes_Inputs::get('delete_value'));
        echo json_encode(array("Deleted_Department"));
    }
}


if (isset($_POST["edit_department"])) {
    if (Classes_Inputs::exists("post")) {
        $result = $_query->get('department', array('ID', '=', Classes_Inputs::get('department_id')));
        if ($result->count()) {
            echo json_encode($result->first());
        }
    }
}


if(isset($_POST["journal_submit_btn"])){
    if(Classes_Inputs::exists('post')){
        $configuration_model->UpdateJournal(Classes_Inputs::get("accounting_code"));
        echo json_encode(array("Journal Saved"));
    }
}


if(isset($_POST["journal_list_access"])){
    if(Classes_Inputs::exists('post')){
        $configuration_model->LoadJournal();
    }
}


if(isset($_POST["salary_tax_submit_btn"])){
    if(Classes_Inputs::exists('post')){
        $configuration_model->AddSalaryTax(Classes_Inputs::get('salary_id'), Classes_Inputs::get('salary_from'), Classes_Inputs::get('salary_to'), Classes_Inputs::get('tax_rate'), Classes_Inputs::get('salary_status'));
    }
}


if(isset($_POST["salary_tax_list_access"])){
    if(Classes_Inputs::exists('post')){
        $configuration_model->LoadSalaryTax();
    }
}

if(isset($_POST["edit_salary"])){
    if(Classes_Inputs::exists('post')){
        $result = $_query->get('salary_tax_settings', array('ID', '=', Classes_Inputs::get('salary_id')));
        if ($result->count()) {
            echo json_encode($result->first());
        }
    }
}


if (isset($_POST["delete_function"]) && $_POST["delete_function"] == 'delete_salary') {
    if (Classes_Inputs::exists('post')) {
        $configuration_model->DeleteSalaryTax(Classes_Inputs::get('delete_value'));
        echo json_encode(array("Deleted_Salary"));
    }
}



if(isset($_POST["social_submit_btn"])){
    if(Classes_Inputs::exists('post')){
        $configuration_model->AddSocialSecurity(Classes_Inputs::get('sos_id'), Classes_Inputs::get('sos_code'), Classes_Inputs::get('sos_rate'), Classes_Inputs::get('sos_status'));
    }
}


if(isset($_POST["social_security_list_access"])){
    if(Classes_Inputs::exists('post')){
        $configuration_model->LoadSocialSecurity();
    }
}


if (isset($_POST["edit_social"])) {
    if (Classes_Inputs::exists('post')) {
        $result = $_query->get('social_security', array('ID', '=', Classes_Inputs::get('sos_id')));
        if ($result->count()) {
            echo json_encode($result->first());
        }
    }
}


if (isset($_POST["delete_function"]) && $_POST["delete_function"] == 'delete_social') {
    if (Classes_Inputs::exists('post')) {
        $configuration_model->DeleteSocialSecurity(Classes_Inputs::get('delete_value'));
        echo json_encode(array("Deleted_Social"));
    }
}


if (isset($_POST["association_submit_btn"])) {
    if (Classes_Inputs::exists('post')) {
        $configuration_model->AddAssociation(Classes_Inputs::get('association_id'), Classes_Inputs::get('association_code'), Classes_Inputs::get('association_rate'), Classes_Inputs::get('association_status'));
    }
}


if (isset($_POST["association_list_access"])) {
    if (Classes_Inputs::exists('post')) {
        $configuration_model->LoadAssociation();
    }
}


if (isset($_POST["edit_association"])) {
    if (Classes_Inputs::exists('post')) {
        $result = $_query->get('association', array('ID', '=', Classes_Inputs::get('association_id')));
        if ($result->count()) {
            echo json_encode($result->first());
        }
    }
}


if (isset($_POST["delete_function"]) && $_POST["delete_function"] == 'delete_association') {
    if (Classes_Inputs::exists('post')) {
        $configuration_model->DeleteAssociation(Classes_Inputs::get('delete_value'));
        echo json_encode(array("Deleted_Association"));
    }
}


if (isset($_POST["currency_submit_btn"])) {
    if (Classes_Inputs::exists('post')) {
        $configuration_model->AddCurrency(Classes_Inputs::get('currency_id'), Classes_Inputs::get('country_currency_name'), Classes_Inputs::get('currency_name'), Classes_Inputs::get('currency_codes'), Classes_Inputs::get('currency_symbols'), Classes_Inputs::get('curreny_type'), Classes_Inputs::get('currency_status'));
    }
}


if (isset($_POST["currency_list_access"])) {
    if (Classes_Inputs::exists('post')) {
        $configuration_model->LoadCurrency();
    }
}


if (isset($_POST["edit_currency"])) {
    if (Classes_Inputs::exists('post')) {
        $result = $_query->get('currency', array('ID', '=', Classes_Inputs::get('currency_id')));
        if ($result->count()) {
            echo json_encode($result->first());
        }
    }
}


if (isset($_POST["delete_function"]) && $_POST["delete_function"] == 'delete_currency') {
    if (Classes_Inputs::exists('post')) {
        $configuration_model->DeleteCurrency(Classes_Inputs::get('delete_value'));
        echo json_encode(array("Deleted_Currency"));
    }
}




if (isset($_POST["vacation_submit_btn"])) {
    if (Classes_Inputs::exists('post')) {
        $configuration_model->AddVacation(Classes_Inputs::get('vacation_id'), Classes_Inputs::get('vacation_name'), Classes_Inputs::get('vacation_num_day'), Classes_Inputs::get('vacation_status'));
    }
}


if (isset($_POST["vacation_list_access"])) {
    if (Classes_Inputs::exists('post')) {
        $configuration_model->LoadVacation();
    }
}


if (isset($_POST["edit_vacation"])) {
    if (Classes_Inputs::exists('post')) {
        $result = $_query->get('vacation', array('ID', '=', Classes_Inputs::get('vacation_id')));
        if ($result->count()) {
            echo json_encode($result->first());
        }
    }
}


if (isset($_POST["delete_function"]) && $_POST["delete_function"] == 'delete_vacation') {
    if (Classes_Inputs::exists('post')) {
        $configuration_model->DeleteVacation(Classes_Inputs::get('delete_value'));
        echo json_encode(array("Deleted_Vacation"));
    }
}



if (isset($_POST["family_tax_submit_btn"])) {
    if (Classes_Inputs::exists('post')) {
        $configuration_model->AddFamilyTax(Classes_Inputs::get('family_tax_id'), Classes_Inputs::get('number_of_kids'), Classes_Inputs::get('tax_amount'), Classes_Inputs::get('family_tax_status'));
    }
}


if (isset($_POST["family_tax_list_access"])) {
    if (Classes_Inputs::exists('post')) {
        $configuration_model->LoadFamilyTax();
    }
}


if (isset($_POST["edit_family_tax"])) {
    if (Classes_Inputs::exists('post')) {
        $result = $_query->get('family_tax', array('ID', '=', Classes_Inputs::get('family_tax_id')));
        if ($result->count()) {
            echo json_encode($result->first());
        }
    }
}


if (isset($_POST["delete_function"]) && $_POST["delete_function"] == 'delete_family_tax') {
    if (Classes_Inputs::exists('post')) {
        $configuration_model->DeleteFamilyTax(Classes_Inputs::get('delete_value'));
        echo json_encode(array("Deleted_Family_Tax"));
    }
}



if (isset($_POST["marital_status_submit_btn"])) {
    if (Classes_Inputs::exists('post')) {
        $configuration_model->AddMaritalStatus(Classes_Inputs::get('marital_status_id'), Classes_Inputs::get('status_name'), Classes_Inputs::get('status_amount'), Classes_Inputs::get('marital_status_status'));
    }
}


if (isset($_POST["marital_status_list_access"])) {
    if (Classes_Inputs::exists('post')) {
        $configuration_model->LoadMaritalStatus();
    }
}


if (isset($_POST["edit_marital_status"])) {
    if (Classes_Inputs::exists('post')) {
        $result = $_query->get('marital_status', array('ID', '=', Classes_Inputs::get('marital_status_id')));
        if ($result->count()) {
            echo json_encode($result->first());
        }
    }
}


if (isset($_POST["delete_function"]) && $_POST["delete_function"] == 'delete_marital_status') {
    if (Classes_Inputs::exists('post')) {
        $configuration_model->DeleteMaritalStatus(Classes_Inputs::get('delete_value'));
        echo json_encode(array("Deleted_Marital_Status"));
    }
}


if(isset($_POST["leave_type_submit_btn"])){
    if(Classes_Inputs::exists('post')){
        $configuration_model->AddLeaveType(Classes_Inputs::get('leave_type'), Classes_Inputs::get('leave_type_number_of_day'), Classes_Inputs::get('leave_type_id'), Classes_Inputs::get('leave_type_status'));
    }
}



if (isset($_POST["leave_type_list_access"])) {
    if (Classes_Inputs::exists('post')) {
        $configuration_model->LoadLeaveType();
    }
}


if (isset($_POST["edit_leave_type"])) {
    if (Classes_Inputs::exists('post')) {
        $result = $_query->get('leave_type', array('ID', '=', Classes_Inputs::get('leave_type_id')));
        if ($result->count()) {
            echo json_encode($result->first());
        }
    }
}


if (isset($_POST["delete_function"]) && $_POST["delete_function"] == 'delete_leave_type') {
    if (Classes_Inputs::exists('post')) {
        $configuration_model->DeleteLeaveType(Classes_Inputs::get('delete_value'));
        echo json_encode(array("Deleted_Leave_Type"));
    }
}






if (isset($_POST["currency_country_id"])) {
    if (Classes_Inputs::exists('post')) {
        $country_data = $_query->get('country_currency', array('country', '=', Classes_Inputs::get('currency_country_id')));
        $country_data = $country_data->first();
        $response_result[] = array("Currency" => $country_data["currency"], "Code" => $country_data["code"], "Symbol" => $country_data["hex"]);
        echo json_encode($response_result);
    }
}