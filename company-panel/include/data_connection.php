<?php
error_reporting(0);

require_once("../../core/init/init.php");
$_query = Classes_Db::getInstance();

$data_connect = new Controller_Company_Default_Datamanagement();
$result = $data_connect->WebData()->first();

if (Classes_Session::exsit('Setup_Session')) {
    $company_data = $data_connect->CompanyData(Classes_Session::get('Setup_Session'))->first();
}


if (Classes_Session::exsit('Loggedin_Session')) {
    $company_data_f = $data_connect->CompanyDataByID()->first();
}

if (Classes_Session::exsit('Login_ID')) {
    $is_loginUser = $data_connect->isLogin()->first();
}

$countrywithcurrency = $data_connect->CountryWithCurrency()->results();

$countrytimezones = $data_connect->CountryTimezone()->results();

$localization_data = $data_connect->LocalizationData()->first();

$theme_data = $data_connect->ThemeData()->first();

$email_data = $data_connect->EmailData()->first();


$role_permission_data = $data_connect->RolePermissionData()->results();


$client_datas = $data_connect->ClientData()->results();

$employee_datas = $data_connect->EmployeesData()->results();


$journal_datas = $data_connect->JournalData()->first();

$branch_datas = $data_connect->BranchData()->results();
$department_datas = $data_connect->DepartmentData()->results();
$marital_status_datas = $data_connect->MaritalStatusData()->results();
$countries_datas = $data_connect->CountriesListData()->results();
$social_security_datas = $data_connect->SocialSecurityData()->results();

$vacation_datas = $data_connect->VacationData()->results();

$association_datas = $data_connect->AssociationData()->results();

$currency_datas = $data_connect->CurrencyData()->results();
$family_datas = $data_connect->FamilyTaxData()->results();


$employee_earning_datas = $data_connect->EmployeesEarningData()->results();
$earning_date_datas = $data_connect->EarningDateData()->results();
$__employee_earning = $data_connect->EmployeeEarningByID();
$__earning_count = $__employee_earning->count();

$__earnings = $__employee_earning->results();

$earning_year_dates = $data_connect->EarningYearDate()->results();

$server =  $_SERVER["REQUEST_URI"];

if (Classes_Inputs::exists('get')) {
    if (Classes_Inputs::get("pro_id")) {
        $project_datas = $data_connect->ProjectData(Classes_Inputs::get("pro_id"))->first();
        $employee_datas_by_id = $data_connect->EmployeesDataByID($project_datas["Leader"])->first();
        $department_results = $data_connect->DepartmentDataByID($employee_datas_by_id["Department"])->first();

    }



    if(Classes_Inputs::get("invoice_id")){
        $invoicedata = $data_connect->InvoiceData(Classes_Inputs::get("invoice_id"))->first();
        
        $invoice_item_data = $data_connect->InvoiceItemData(Classes_Inputs::get("invoice_id"))->results();
        $client_datas_by_id = $data_connect->ClientDataByID($invoicedata["Client_ID"])->first();
        
        $invoice_project_datas = $data_connect->ProjectData($invoicedata["Project_ID"])->first();

    }



    if (Classes_Inputs::get("employee_id")) {
        $employee_view_datas_by_id = $data_connect->EmployeesDataByID(Classes_Inputs::get("employee_id"))->first();
        $employee_image = empty($employee_view_datas_by_id["Image"]) ? $result["Web_Url"] . 'Folders/brand/no_image.png' : $result["Web_Url"] . 'Folders/Company_Folders/' . Classes_Session::get('Loggedin_Session') . '/Employee_Image/' . $employee_view_datas_by_id["Image"];
        //$employee_image = '<span class="avatar avatar-online"> <img src="' . $employee_image . '" class="rounded-circle" style="width: 50px; height: 30px;" alt="Employee Image"></span>';
       
        $department_results = $data_connect->DepartmentDataByID($employee_view_datas_by_id["Department"])->first();
        $branch_results = $data_connect->BranchDataByID($employee_view_datas_by_id["Branch"])->first();
        $marital_results = $data_connect->MaritalDataByID($employee_view_datas_by_id["Marital"])->first();
        $family_tax_results = $data_connect->FamilyTaxDataByID($employee_view_datas_by_id["Kids"])->first();
        $social_results = $data_connect->SocialSecurityDataByID($employee_view_datas_by_id["Social_Security"])->first();
        $association_tax_results = $data_connect->AssociationDataByID($employee_view_datas_by_id["Association"])->first();
        $vacation_results = $data_connect->VacationDataByID($employee_view_datas_by_id["Vacation"])->first();
        $tax_results = $data_connect->SalaryTaxDataByID($employee_view_datas_by_id["Tax_ID"])->first();
        $currency_results = $data_connect->CurrencyDataByID($employee_view_datas_by_id["Currency"])->first();

        $employee_assigned_pro = $data_connect->projectDataByEmployee(Classes_Inputs::get("employee_id"));
        $employee_assigned_pro_count = $employee_assigned_pro->count();
        $employee_assigned_pro_results = $employee_assigned_pro->results();

        $join_date = date($localization_data["Date_Format"], strtotime($employee_view_datas_by_id["HireDate"]));

        if($employee_view_datas_by_id["Payment_Type"] == '30'){
            $payment_type = 'Monthly';
        } elseif ($employee_view_datas_by_id["Payment_Type"] == '15') {
            $payment_type = 'Semi Monthly';
        } elseif ($employee_view_datas_by_id["Payment_Type"] == '7') {
            $payment_type = 'Weekly';
        }

    }
}




