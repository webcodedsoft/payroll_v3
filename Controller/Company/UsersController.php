<?php
require_once("../../core/init/init.php");
require_once("default/validation_rules.php");

$user_model = new Model_Company_UsersModel();

$_query = Classes_Db::getInstance();
$validate = new Classes_Validations();



if(isset($_POST["user_button"])){
    if(Classes_Inputs::exists('post')){
        if (!empty($_POST["user_id"])) {
            $user_model->AddUser(Classes_Inputs::get("user_id"), Classes_Inputs::get("first_name"), Classes_Inputs::get("last_name"), Classes_Inputs::get("username"), Classes_Inputs::get("email"), Classes_Inputs::get("password"), Classes_Inputs::get("phone_number"), Classes_Inputs::get("access_permission"));
            echo json_encode(array("User Successfully Update", "Update" => "Refresh"));
        } else {
            $validation = $validate->checkRules($_POST, $GLOBALS["validations"]["add_user"]);
            if ($validation->passed()) {
                $user_model->AddUser(Classes_Inputs::get("user_id"), Classes_Inputs::get("first_name"), Classes_Inputs::get("last_name"), Classes_Inputs::get("username"), Classes_Inputs::get("email"), Classes_Inputs::get("password"), Classes_Inputs::get("phone_number"), Classes_Inputs::get("access_permission"));
                echo json_encode(array("User Successfully Created"));
            } else {
                echo json_encode($validation->errors());
            }
        }
       
    }
}


if(isset($_POST["users_list_access"])){
    if(Classes_Inputs::exists("post")){
       $user_model->LoadUsers();

    }
}

if(isset($_POST["block_user"])){
    if(Classes_Inputs::exists('post')){
        $user_model->BlockUser(Classes_Inputs::get('user_id'));
        echo json_encode(array("User Successfully Blocked"));
    }
}

if (isset($_POST["delete_function"]) && $_POST["delete_function"] == "delete_user") {
    if (Classes_Inputs::exists('post')) {
        $user_model->DeleteUser(Classes_Inputs::get('delete_value'));
        echo json_encode(array("User Successfully Deleted"));
    }
}


if (isset($_POST["edit_user"])) {

    if (Classes_Inputs::exists('post')) {
        $result = $_query->get('users', array('ID', '=', Classes_Inputs::get('user_id')));
        if ($result->count()) {
            echo json_encode(array($result->first()));
        }
    }
}