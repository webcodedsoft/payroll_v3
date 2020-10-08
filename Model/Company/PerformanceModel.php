<?php
class Model_Company_PerformanceModel
{
    public function __construct()
    {
        $this->_query = Classes_Db::getInstance();

        $data = new Controller_Company_Default_Datamanagement();
        $this->module_access_result = $data->ModuleData()->results();

        $this->localization = $data->LocalizationData()->first();

        $this->web_data = $data->WebData()->first();
    }
 
    public function LoadSubscribedPackage(){
        $data = array();
        $serial_id = 0;

        $search_value = $_POST["search"]["value"];
        
        $column_order = array('Plan_Name', 'Plan_Amount', 'Plan_Type', 'Plan_Duration', 'Storage', 'Created_Date');
        if ($_POST['order']) {
            $order_by = $column_order[$_POST['order'][0]['column']] . ' ' . $_POST['order']['0']['dir'];
        }


        $query = $this->_query->query("SELECT * FROM subscribed_companies WHERE Subscriber_ID = ?", Classes_Session::get("Loggedin_Session"));
        $total_package_filter = $query->count();

        if ($_POST['length'] != -1) {
            $limit = " " . $_POST['start'] . ", " . $_POST['length'] . " ";
        }

        if (!empty($_POST["search"]["value"])) {
            $sql_package = "SELECT * FROM subscribed_companies WHERE Subscriber_ID = ? AND (Plan_Name LIKE ? OR Plan_Amount LIKE ? OR Plan_Type LIKE ? OR Plan_Duration LIKE ? OR Storage LIKE ? OR Created_Date LIKE ?) ORDER BY $order_by LIMIT $limit";
            $data_value = array(Classes_Session::get("Loggedin_Session"), '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%');
            $query_result_c = $this->_query->query($sql_package, $data_value);
        } else {
            $sql_package = "SELECT * FROM subscribed_companies WHERE Subscriber_ID = ? ORDER BY $order_by LIMIT $limit";
            $query_result_c = $this->_query->query($sql_package, array(Classes_Session::get("Loggedin_Session")));
        }



        $total_package_data = $query_result_c->count();

        $fetching_results = $query_result_c->results();
        $serial_id = 1;
        foreach ($fetching_results as $key => $data_value) {

            if($data_value["Status"] == 'Active'){
                $plan_status = '<span class="badge badge-default badge-success">' . $data_value["Status"] . '</span>';
            } else {
                $plan_status = '<span class="badge badge-default badge-danger">' . $data_value["Status"] . '</span>';
            }
            

            if ($data_value["Plan_Duration"] == 30) {
                $plan_duration = '1 Month';
            } elseif ($data_value["Plan_Duration"] == 180) {
                $plan_duration = '6 Months';
            } elseif ($data_value["Plan_Duration"] == 360) {
                $plan_duration = '1 Year';
            }

            $package_data = array();
            $package_data[] = $data_value["Plan_Name"];
            $package_data[] = $data_value["Plan_Type"];
            $package_data[] = $data_value["No_User"];
            $package_data[] = $plan_duration;
            $package_data[] = date($this->localization["Date_Format"], strtotime($data_value["Start_Dates"])); 
            $package_data[] = date($this->localization["Date_Format"], strtotime($data_value["End_Date"])); 
            $package_data[] = '$' . $data_value["Plan_Amount"];
            $package_data[] = $data_value["Storage"];
            $package_data[] = $plan_status ;


            $data[] = $package_data;
            $serial_id++;
        }


        $package_list_result_output = array(

            "draw"  => intval($_POST["draw"]),
            "recordsTotal" => intval($total_package_data),
            "recordsFiltered" => intval($total_package_filter),
            "data" => $data,
        );

        echo json_encode($package_list_result_output);
    }

 
    public function StorageAnalysis(){
        $company_detail = $this->_query->get('company', array('Subscriber_ID', '=', Classes_Session::get('Loggedin_Session')));
        $company_detail = $company_detail->first();

        $total_size = 0;
        $file_datas = Classes_Upload::get(Classes_Session::get('Loggedin_Session'));

        foreach ($file_datas["Default_Files"] as $key => $file_data) {
            $total_size += filesize($file_datas["Default_Path"] . "/" . $file_data);

            $new_path = $file_datas["Default_Path"] . "/" . $file_data;
           
                if (is_dir($new_path)) {
                        $folder_name = strrpos($new_path, '/') + 1; //Just to make sure we dont include / in the result
                    $folder_name_array = substr($new_path, $folder_name);
                    $new_path = Classes_Upload::get(Classes_Session::get('Loggedin_Session').'/'. $folder_name_array);

                    foreach ($new_path["Default_Files"] as $key => $new_file_data) {
                        $total_size += filesize($new_path["Default_Path"] . "/" . $new_file_data);
                    }
                }
           
        }
        
        $storage = array_map('Classes_Converter::FileSize', array($company_detail["Storage"])); //Convert to Byte
        $temp_free = Classes_Converter::file_size($storage[0] - $total_size); //In MB OR GB 

        $free_storage = number_format(preg_match('(Bytes|Byte|KB)', $temp_free) === 1 ? '0.' . $temp_free : $temp_free, 3);


        $storage_f = preg_replace('/[A-Z]+/', '', preg_replace('/\s+/', '', Classes_Converter::file_size($storage[0]))); //Convert into MB OR GB and Removing Space and Characters
        $free_storage = preg_replace('/[A-Z]+/', '', preg_replace('/\s+/', '', $free_storage)); //Removing Space And Characters

        /* Checking if the number given is in byte and KB if yes add 0. to the number to make is low for the chart else used the real MB */
        $used_space = number_format(preg_match('(Bytes|Byte|KB)', Classes_Converter::file_size($total_size)) === 1 ? '0.' . Classes_Converter::file_size($total_size) : Classes_Converter::file_size($total_size), 3);
        
        Classes_Session::put("Free_Storage", $temp_free);
        echo json_encode(array('Storage' => $storage_f, 'Free_Space' => $free_storage, 'Used_Space' => $used_space));

    }


    public function FolderFileView($folder_name){
        $folder_files = Classes_Upload::get(Classes_Session::get('Loggedin_Session') . '/' . $folder_name);
        $folder_file_list = '';

        foreach ($folder_files["Files"] as $key => $file_data) {

            $file_extension= explode(".", $file_data);
            $file_extension =  end($file_extension);

            if($file_extension == 'png' || $file_extension ==  'jpg' || $file_extension ==  'jpeg' || $file_extension ==  'gif'){
              $__fileview = '<img style="width: 100px; height:100px;" src="' . $this->web_data["Web_Url"] . 'Folders/Company_Folders/' . Classes_Session::get('Loggedin_Session') . '/' . $folder_name . '/' . $file_data . '">';  
            } elseif ($file_extension == 'csv') {
                $__fileview = '<i style="font-size:100px" class="la la-file-excel-o"></i>';
            } elseif ($file_extension == 'pdf') {
                $__fileview = '<i style="font-size:100px" class="la la-file-pdf-o"></i>';
            } elseif ($file_extension == 'doc' || 'docs') {
                $__fileview = '<i style="font-size:100px" class="la la-file-word-o"></i>';
            } elseif ($file_extension == 'txt' ) {
                $__fileview = '<i style="font-size:100px" class="la la-file-text-o"></i>';
            } elseif ($file_extension == 'ppt' || $file_extension == 'pptx') {
                $__fileview = '<i style="font-size:100px" class="la la-file-powerpoint-o"></i>';
            } elseif ($file_extension == 'zip' || $file_extension == 'rar') {
                $__fileview = '<i style="font-size:100px" class="la la-file-zip-o"></i>';
            }

            $folder_file_list .= '
            <div class="col-md-3 ">
                <div class="card card-file">
                    <div class="dropdown-file">
                        <a href="" class="dropdown-link" data-toggle="dropdown"><i class="la la-ellipsis-v"></i></a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href='.$this->web_data['Web_Url'].'download?file_name='.$file_data .' class="dropdown-item">Download</a>
                            <a href="#" id="'.$file_data. '" class="dropdown-item delete_image">Delete</a>
                        </div>
                    </div>
                                                            
                    <div class="card-file-thumb">
                        '.$__fileview.'
                    </div>
                    <div class="card-body">
                        <h6>'.$file_data.'</h6>
                        <span>' . Classes_Converter::file_size(filesize($folder_files["Path"] . "/" . $file_data)) . '</span>
                    </div>
                    <div class="card-footer">
                        <span class="d-none d-sm-inline">Last Modified: </span>' . Classes_Converter::TimeConvert(date("Y-m-d H:i:s", filemtime($folder_files["Path"] . "/" . $file_data))) . '
                    </div>
                </div>
            </div>';
        }
        return $folder_file_list;
    }
}
