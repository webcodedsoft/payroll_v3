<?php
require_once("../../core/init/init.php");
//require_once("../admin/validation_rules.php");

$termination_model = new Model_Company_TerminationModel();

$_query = Classes_Db::getInstance();


if (isset($_POST["employee_completion_btn"])) {
    if (Classes_Inputs::exists('post')) {
        $termination_model->Completetion(Classes_Inputs::get("completion_employee_id"), Classes_Inputs::get("employee_ending_date"), Classes_Inputs::get("employee_firing_type"));
    }
}
