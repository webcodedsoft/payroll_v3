<?php
require_once("../../core/init/init.php");
//require_once("../admin/validation_rules.php");

$performance_model = new Model_Company_PerformanceModel();

$_query = Classes_Db::getInstance();


if(isset($_POST["delete_function"]) && $_POST["delete_function"] == 'delete_image'){
    if(Classes_Inputs::exists('post')){
        $upload_reponse = Classes_Upload::deleteimage(Classes_Inputs::get("delete_value"), Classes_Session::get('Loggedin_Session')."");
        if ($upload_reponse) {
            echo json_encode("Deleted");
        }
    }
}
 


if(isset($_POST["storage_view"])){
    $performance_model->StorageAnalysis();
}


if (Classes_Inputs::get('file_name') ) {

    $path = '../../Folders/Company_Folders/'.Classes_Session::get('Loggedin_Session').'/'. Classes_Inputs::get('file_name');

    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($path));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($path));
    ob_clean();
    flush();
    readfile($path);
    exit;
}



if (isset($_POST["subscribed_package_list_access"])){
    if(Classes_Inputs::exists('post')){
            $package_list_result = $performance_model->LoadSubscribedPackage();
    }
}


if(isset($_POST["folder_list_view"])){
    if (Classes_Inputs::exists('post')) {
        $folders = Classes_Upload::getFolders(Classes_Session::get('Loggedin_Session'));
        $folders_file_count = $folders["Folder_File_Count"];
        $folder_list_output = '';
        foreach ($folders["Folder_Name"] as $key => $folders_name) {
            //var_dump($folders_file_count[$key]);
            $file_count = $folders_file_count[$key] > 1 ? ' ('. $folders_file_count[$key].' Files )' : ' ('. $folders_file_count[$key]. ' File )';
            $folder_list_output.= '<li class="active">
                                        <a href="javascript:void(0)" id="folder_view" data-name="' . $folders_name . '"><i class="icon-folder-alt"></i> '. $folders_name.' '. $file_count.'</a>
                                    </li>';
        }
        echo json_encode($folder_list_output);
        
    }
}

if (isset($_POST["folder_view"])) {
    if(Classes_Inputs::exists('post')){
        $file_list_result = $performance_model->FolderFileView(Classes_Inputs::get("folder_name"));
        echo json_encode($file_list_result);
    }
}