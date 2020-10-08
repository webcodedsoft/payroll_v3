<?php
require_once("../../core/init/init.php");

$reports_model = new Model_Company_ReportsModel();

$_query = Classes_Db::getInstance();


if(isset($_POST["load_date_range_base_on_employee_id_proof"])){
    if(Classes_Inputs::exists('post')){
        $reports_model->LoadDateRangeByEmployee(Classes_Inputs::get("employee_id_payment_proof"));
    }
}


if(isset($_POST["payment_proof_btn"])){
    if(Classes_Inputs::exists('post')){
       $reports_model->LoadPaymentProof(Classes_Inputs::get('employee_id_payment_proof'), Classes_Inputs::get('earning_date_range_payment_proof'));
    }
}



if (isset($_POST["payment_proof_email_btn"])) {
    if (Classes_Inputs::exists('post')) {
        $reports_model->MailPaymentProof(Classes_Inputs::get("earning_id"));
    }
}


if (isset($_POST["payment_proof_pdf_btn"])) {
    if (Classes_Inputs::exists('post')) {
        $reports_model->DownloadPaymentProof(Classes_Inputs::get("earning_id"));
    }
}


if(isset($_POST["employee_worksheet_list_access"])){
    if(Classes_Inputs::exists('post')){
        $reports_model->LoadPayrollWorksheet(Classes_Inputs::get('worksheet_payment_type'), Classes_Inputs::get('worksheet_payment_date'), Classes_Inputs::get('worksheet_payment_department'));
    }
}


if (isset($_POST["employee_summary_worksheet_list_access"])) {
    if (Classes_Inputs::exists('post')) {
        $reports_model->LoadPayrollWorksheetSummary(Classes_Inputs::get('summary_worksheet_employee_id'), Classes_Inputs::get('worksheet_summary_payment_date'));
    }
}


if (isset($_POST["employee_monthly_salary_report_list_access"])) {
    if (Classes_Inputs::exists('post')) {
        $reports_model->LoadPayrollMonthlyReport(Classes_Inputs::get('monthly_salary_report_date'));
    }
}


if (isset($_POST["employee_payroll_row_report_list_access"])) {
    if (Classes_Inputs::exists('post')) {
        $reports_model->LoadPayrollRowReport(Classes_Inputs::get('payment_date_from'), Classes_Inputs::get('payment_date_to'));
    }
}


if (isset($_POST["load_employee_id_aguinaldo"])) {
    if (Classes_Inputs::exists('post')) {
        $reports_model->LoadAguinaldoReport(Classes_Inputs::get('employee_id_aguinaldo'));
    }
}


if (isset($_POST["load_date_range_base_on_employee_id_history"])) {
    if (Classes_Inputs::exists('post')) {
        $reports_model->LoadYearDateRangeByEmployee(Classes_Inputs::get("employee_id_earning_history"));
    }
}


if (isset($_POST["earning_payroll_history_list_access"])) {
    if (Classes_Inputs::exists('post')) {
        $reports_model->LoadEmployeePayrollHistory(Classes_Inputs::get('employee_id_earning_history'), Classes_Inputs::get('earning_date_range_payment_history'));
    }
}


if (isset($_POST["load_leave_report_employee_id"])) {
    if (Classes_Inputs::exists('post')) {
        $reports_model->LoadLeaveReport(Classes_Inputs::get('leave_report_employee_id'));
    }
}



if (isset($_POST["leave_report_email_btn"])) {
    if (Classes_Inputs::exists('post')) {
        $reports_model->MailLeaveReport(Classes_Inputs::get("earning_id"));
    }
}


if (isset($_POST["leave_report_pdf_btn"])) {
    if (Classes_Inputs::exists('post')) {
        $reports_model->DownloadLeaveReport(Classes_Inputs::get("earning_id"));
    }
}



if (isset($_POST["load_salary_letter_employee_id"])) {
    if (Classes_Inputs::exists('post')) {
        $reports_model->LoadSalaryLetter(Classes_Inputs::get('salary_letter_employee_id'));
    }
}



if (isset($_POST["salary_letter_email_btn"])) {
    if (Classes_Inputs::exists('post')) {
        $reports_model->MailSalaryLetter(Classes_Inputs::get("salary_letter_employee_id"));
    }
}


if (isset($_POST["salary_letter_pdf_btn"])) {
    if (Classes_Inputs::exists('post')) {
        $reports_model->DownloadSalaryLetter(Classes_Inputs::get("salary_letter_employee_id"));
    }
}


if (isset($_POST["load_journal_report"])) {
    if (Classes_Inputs::exists('post')) {
        $reports_model->LoadJournalReport(Classes_Inputs::get('journal_report_date'));
    }
}

if (isset($_POST["journal_report_pdf_btn"])) {
    if (Classes_Inputs::exists('post')) {
        $reports_model->DownloadJournalReport(Classes_Inputs::get("journal_report_date"));
    }
}