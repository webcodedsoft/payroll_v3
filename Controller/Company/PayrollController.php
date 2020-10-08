<?php
require_once("../../core/init/init.php");

$payroll_model = new Model_Company_PayrollModel();

$_query = Classes_Db::getInstance();


if (isset($_POST["earning_access"])) {
    if (Classes_Inputs::exists('post')) {
        $payroll_model->LoadEmployeeEarning(Classes_Inputs::get('earning_payment_type'));
    }
}


if(isset($_POST["add_earning_btn"])){
    if(Classes_Inputs::exists('post')){
        $payroll_model->AddEmployeeEarning(Classes_Inputs::get('employee_id'), Classes_Inputs::get('bonus'), Classes_Inputs::get('comission'), Classes_Inputs::get('allowance'), Classes_Inputs::get('otherearning'), Classes_Inputs::get('extra1'), Classes_Inputs::get('extra2'), Classes_Inputs::get('ordinary'), Classes_Inputs::get('payment_date'), Classes_Inputs::get('exchang_rate'));
    }
}


if(isset($_POST["load_date_range_base_on_payment_type"])){
    if(Classes_Inputs::exists('post')){
        $payroll_model->LoadDateRangeByPaymentType(Classes_Inputs::get('update_earning_payment_type_value'));
    }
}


if (isset($_POST["fetch_employee_earning"])) {
    if (Classes_Inputs::exists('post')) {
        $payroll_model->LoadEarningData(Classes_Inputs::get('earning_update_date'), Classes_Inputs::get('update_earning_payment_type'));
    }
}


if(isset($_POST["update_earning_btn"])){
    if(Classes_Inputs::exists('post')){
        $payroll_model->UpdateEmployeeEarning(Classes_Inputs::get('employee_id_update'), Classes_Inputs::get('bonus_update'), Classes_Inputs::get('comission_update'), Classes_Inputs::get('allowance_update'), Classes_Inputs::get('otherearning_update'), Classes_Inputs::get('extra1_update'), Classes_Inputs::get('extra2_update'), Classes_Inputs::get('ordinary_update'), Classes_Inputs::get('payment_date_update'), Classes_Inputs::get('exchang_rate_update'));
    }
}


if(isset($_POST["load_date_range_base_on_employee_id"])){
    if(Classes_Inputs::exists('post')){
        $payroll_model->LoadDateRangeByEmployee(Classes_Inputs::get("employee_deduction_id"));
    }
}


if(isset($_POST["deduction_search_btn"])){
    if(Classes_Inputs::exists('post')){
        $payroll_model->LoadEmployeeDeduction(Classes_Inputs::get('earning_date_range_payment'), Classes_Inputs::get('employee_deduction_id'));
    }
}


if(isset($_POST["deduction_btn"])){
    if(Classes_Inputs::exists('post')){
        $payroll_model->ComputeDeduction(Classes_Inputs::get('employee_id_deduct'), Classes_Inputs::get('loan'), Classes_Inputs::get('assessment'), Classes_Inputs::get('othersdeduction'), Classes_Inputs::get('earning_date_range_payment'));
    }
} 


if(isset($_POST["load_employee_leave"])){
    if(Classes_Inputs::exists('post')){
        $payroll_model->LoadEmployeeLeaveData(Classes_Inputs::get('employee_leave_id'));
    }
}


if (isset($_POST["employee_leave_submit_btn"])) {
    if(Classes_Inputs::exists('post')){
        $payroll_model->AddEmployeeLeave(Classes_Inputs::get('leave_employee_id'), Classes_Inputs::get('employee_leave_type'), Classes_Inputs::get('leave_reason'), Classes_Inputs::get('leave_from'), Classes_Inputs::get('leave_to'), Classes_Inputs::get('leave_payment_type'));
    }
}

if(isset($_POST["employee_leave_list_access"])){
    if(Classes_Inputs::exists('post')){
        $payroll_model->LoadEmployeeLeaveTable();
    }
}


if (isset($_POST["delete_function"]) && $_POST["delete_function"] == "delete_leave") {
    if (Classes_Inputs::exists('post')) {
        $payroll_model->DeleteEmployeeLeave(Classes_Inputs::get('delete_value'));
        echo json_encode(array("Employee_Leave_Deleted"));
    }
}


if(isset($_POST["payroll_item_submit_btn"])){
    if(Classes_Inputs::exists('post')){
        $payroll_model->AddPayrollItem(Classes_Inputs::get('payroll_item_id'), Classes_Inputs::get('payroll_item_name'), Classes_Inputs::get('payroll_item_amount'), Classes_Inputs::get('assigned_option'), Classes_Inputs::get('assigned_employee_id'), Classes_Inputs::get('payroll_item_date'), Classes_Inputs::get('payroll_item_status'), Classes_Inputs::get('saving_type'));
    }
}


if (isset($_POST["payroll_item_list_access"])) {
    if (Classes_Inputs::exists('post')) {
        $payroll_model->LoadPayrollItem();
    }
}


if (isset($_POST["delete_function"]) && $_POST["delete_function"] == "delete_payroll_item") {
    if (Classes_Inputs::exists('post')) {
        $payroll_model->DeletePayrollItem(Classes_Inputs::get('delete_value'));
        echo json_encode(array("Payroll_Item_Deleted"));
    }
}

if(isset($_POST["edit_payroll_item"])){
    if(Classes_Inputs::exists('post')){
        $result = $_query->get('payroll_items', array('ID', '=', Classes_Inputs::get('payroll_item_id')));
        if ($result->count()) {
            echo json_encode(array($result->first()));
        }
    }
}


if (isset($_POST["manage_payroll_access"])) {
    if(Classes_Inputs::exists('post')){
        $payroll_model->LoadManagePayroll(Classes_Inputs::get('employee_id'), Classes_Inputs::get('payroll_date'));
    }
}


if (isset($_POST["delete_function"]) && $_POST["delete_function"] == "delete_selected_manage_payroll_btn") {
    if(Classes_Inputs::exists('post')){
        $payroll_model->DeleteManagePayroll(Classes_Inputs::get('delete_value'));
    }
}


if (isset($_POST["lock_unlock_selected_manage_payroll_btn"])) {
    if (Classes_Inputs::exists('post')) {
        $payroll_model->LockUnlockManagePayroll(Classes_Inputs::get('single_manage_payroll_select_id'));
    }
}

if(isset($_POST["send_payment_proof_to_selected_manage_payroll_btn"])){
    if(Classes_Inputs::exists('post')){
        $payroll_model->SendPaymentProof(Classes_Inputs::get('single_manage_payroll_select_id'));
    }
}