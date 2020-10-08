<?php
require_once("../../core/init/init.php");

$account_model = new Model_Company_AccountsModel();


if(isset($_POST["save_invoice_btn"])){
    if(Classes_Inputs::exists("post")){
        
        $account_model->CreateInvoice(
            Classes_Inputs::get("invoice_id"),
            Classes_Inputs::get("client_id"),
            Classes_Inputs::get("client_project"),
            Classes_Inputs::get("client_email"),
            Classes_Inputs::get("client_address"),
            Classes_Inputs::get("invoice_date"),
            Classes_Inputs::get("invoice_due_date"),
            Classes_Inputs::get("other_desc"),
            Classes_Inputs::get("invoice_discount"),
            Classes_Inputs::get("final_total"),
            Classes_Inputs::get("item_id"),
            Classes_Inputs::get("item_name"),
            Classes_Inputs::get("item_desc"),
            Classes_Inputs::get("item_cost"),
            Classes_Inputs::get("item_qty"),
            Classes_Inputs::get("item_amount"),
            Classes_Inputs::get("save_type"),
        );
    }

}

if(isset($_POST["invoice_list_access"])){
    if(Classes_Inputs::exists('post')){
         $account_model->LoadCreatedInvoice();
    }
}


if (isset($_POST["client_project_access"])) {
    if (Classes_Inputs::exists('post')) {
        $account_model->LoadProjectByClient(Classes_Inputs::get("client_id"));
    }
}


if(isset($_POST["invoice_email_btn"])){
    $account_model->MailInvoice(Classes_Inputs::get("invoice_id"));
}


if (isset($_POST["invoice_pdf_btn"])) {
    $account_model->DownloadInvoice(Classes_Inputs::get("invoice_id"));
}


if(isset($_POST["delete_function"]) && $_POST["delete_function"] == 'delete_invoice'){
    $account_model->DeleteInvoice(Classes_Inputs::get("delete_value"));
}


if (isset($_POST["delete_function"]) && $_POST["delete_function"] == 'remove_data_row') {
    $account_model->RemoveInvoiceItem(Classes_Inputs::get("delete_value"));
}