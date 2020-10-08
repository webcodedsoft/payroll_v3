<?php
require_once("../../core/init/init.php");

$client_model = new Model_Company_Clientsmodel();

$_query = Classes_Db::getInstance();



if (isset($_POST["client_button"])) {
    if (Classes_Inputs::exists('post')) {
        $client_model->AddClient(
            Classes_Inputs::get("client_id"),
            Classes_Inputs::get("company_name"),
            Classes_Inputs::get("contact_person"),
            Classes_Inputs::get("address"),
            Classes_Inputs::get("email_address"),
            Classes_Inputs::get("client_phone_number"),
            Classes_Inputs::get("client_status")
        );
    }
}


if (isset($_POST["clients_list_access"])) {
    if (Classes_Inputs::exists("post")) {
        $client_model->LoadClients();
    }
}



if (isset($_POST["delete_function"]) && $_POST["delete_function"] == "delete_client") {
    if (Classes_Inputs::exists('post')) {
        $client_model->DeleteClients(Classes_Inputs::get('delete_value'));
        echo json_encode(array("Client Successfully Deleted"));
    }
}


if (isset($_POST["edit_client"])) {

    if (Classes_Inputs::exists('post')) {
        $result = $_query->get('clients', array('ID', '=', Classes_Inputs::get('client_id')));
        if ($result->count()) {
            echo json_encode(array($result->first()));
        }
    }
}
