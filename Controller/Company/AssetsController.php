<?php
require_once("../../core/init/init.php");
require_once("default/validation_rules.php");

$asset_model = new Model_Company_AssetsModel();

$_query = Classes_Db::getInstance();



if (isset($_POST["assets_button"])) {
    if (Classes_Inputs::exists('post')) {
            $asset_model->AddAsset(Classes_Inputs::get("asset_id"), Classes_Inputs::get("asset_name"), Classes_Inputs::get("purchase_date"), Classes_Inputs::get("purchase_from"), 
                Classes_Inputs::get("manufacturer"), Classes_Inputs::get("model"), Classes_Inputs::get("serial_number"), Classes_Inputs::get("supplier"),
                Classes_Inputs::get("condition"), Classes_Inputs::get("warranty"), Classes_Inputs::get("amount"), Classes_Inputs::get("description"),Classes_Inputs::get("status"),
            );
    }
}


if (isset($_POST["assets_list_access"])) {
    if (Classes_Inputs::exists("post")) {
        $asset_model->LoadAssets();
    }
}



if (isset($_POST["delete_function"]) && $_POST["delete_function"] == "delete_asset") {
    if (Classes_Inputs::exists('post')) {
        $asset_model->DeleteAssets(Classes_Inputs::get('delete_value'));
        echo json_encode(array("Asset Successfully Deleted"));
    }
}


if (isset($_POST["edit_asset"])) {
    if (Classes_Inputs::exists('post')) {
        $result = $_query->get('assets', array('ID', '=', Classes_Inputs::get('asset_id')));
        if ($result->count()) {
            echo json_encode(array($result->first()));
        }
    }
}
