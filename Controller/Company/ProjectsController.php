<?php
require_once("../../core/init/init.php");
require_once("../admin/validation_rules.php");

$project_model = new Model_Company_ProjectsModel();

$_query = Classes_Db::getInstance();



if (isset($_POST["project_button"])) {
    if (Classes_Inputs::exists('post')) {

        $upload_reponse = Classes_Upload::uploading($_FILES['project_file'], Classes_Inputs::get("project_name"), Classes_Session::get("Loggedin_Session")."/Projects"."");
        
        if($upload_reponse["Status"] == 'Done' || $upload_reponse["Status"] == 'No Image'){

                $upload_reponse_new = $upload_reponse["Message"] != false ? $upload_reponse["Message"] : "";
                $project_model_data = $project_model->CreateProject(Classes_Inputs::get("project_id"), $upload_reponse_new, Classes_Inputs::get("project_name"), Classes_Inputs::get("project_client"), Classes_Inputs::get("project_start_date"), Classes_Inputs::get("project_end_date"), Classes_Inputs::get("project_rate"), Classes_Inputs::get("project_rate_type"), Classes_Inputs::get("project_priority"), Classes_Inputs::get("project_leader"), Classes_Inputs::get('project_status'), Classes_Inputs::get("project_description"));
        }
        else {
            echo json_encode(array($upload_reponse["Message"]));
        }
        
    }
}


if(isset($_POST["projects_list_access"])){
    if(Classes_Inputs::exists('post')){
        $project_model->ProjectListView();
    }
}


if (isset($_POST["projects_grid_access"])) {
    if (Classes_Inputs::exists('post')) {
        $project_model->ProjectGridView();
    }
}


if(isset($_POST["delete_function"]) && $_POST["delete_function"] == 'delete_project'){
    if(Classes_Inputs::exists('post')){
        $project_model->DeleteProject(Classes_Inputs::get("delete_value"));
    }
}


if (isset($_POST["edit_project"])) {

    if (Classes_Inputs::exists('post')) {
        $result = $_query->get('projects', array('ID', '=', Classes_Inputs::get('project_id')));
        if ($result->count()) {
            echo json_encode(array($result->first()));
        }
    }
}
