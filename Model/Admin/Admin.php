<?php

class Model_Admin_Admin 
{
    private $_query, $web_result;
    public function __construct()
    {
        $this->_query = Classes_Db::getInstance();
        //var_dump(Classes_Db::getInstance());
        //$web_data = new controller_admin_datamanagement();
        //$this->web_result = $web_data->CompanyData()->first();
    }

    public function CreateCompany($company_email, $comapany_id){

            $comp_gen_id = Classes_Generators::AlphaNumeric(8);
            $comp_gen_id = strtoupper($comp_gen_id);

            $create_result =  $this->_query->insert('company', array('Subscriber_ID' => $comp_gen_id, 'Company_Email' => $company_email, 'Company_ID' => $comapany_id, 'Created_By' => 'Owner', 'Status' => 'Active'));
            if ($create_result) {
                echo json_encode(array("Company Successfully Created"));
            }
    }

    public function LoadRegisterCompany(){
        $data = array();
        $serial_id = 0;
       
        $search_value = $_POST["search"]["value"];
        $orders = 'ID';
        $key = 'DESC';
        
          
        $query = $this->_query->query("SELECT * FROM company WHERE Status = ? ", array('Active'));
        $total_company_filter = $query->count();

        if ($_POST['length'] != -1) {
            $limit = " " . $_POST['start'] . ", " . $_POST['length'] . " ";
        }

        if (!empty($_POST["search"]["value"]) ) {
            $sql_registered_company = "SELECT * FROM company WHERE Status = ? AND Company_Email LIKE ? OR Company_ID LIKE ? ORDER BY $orders $key LIMIT $limit";
            $data_value = array('Active', '%' . $search_value . '%', '%' . $search_value . '%');
        } else {
            $sql_registered_company = "SELECT * FROM company WHERE Status = ? ORDER BY $orders $key LIMIT $limit";
            $data_value = array('Active');
        }

        
        
        $query_result_c = $this->_query->query($sql_registered_company, $data_value);
        $total_company_data = $query_result_c->count();
       
       
        $fetching_results = $query_result_c->results();
        $serial_id=1;
        foreach ($fetching_results as $key => $data_value) {

            $edit_button = "<button type='button' id='{$data_value["ID"]}' class='btn btn-info btn-glow edit_company box-shadow'>Edit</button>";
            $delete_button = "<button type='button' id='{$data_value["ID"]}' class='btn btn-danger btn-glow delete_company box-shadow'>Delete</button>";


            $company_data = array();
            $company_data[] = $serial_id;
            $company_data[] = $data_value["Company_Email"];
            $company_data[] = $data_value["Company_ID"];
            $company_data[] = $edit_button .' '. $delete_button;
            $data[] = $company_data;
            $serial_id++;
        }


        $company_list_result_output = array(

            "draw"  => intval($_POST["draw"]),
            "recordsTotal" => intval($total_company_data),
            "recordsFiltered" => intval($total_company_filter),
            "data" => $data,
        );

        echo json_encode($company_list_result_output);

    }

    public function Web_Config($web_contact, $web_url){
        return $this->_query->update('web_config', array('ID' => '1'), array('Web_Contact' => $web_contact, 'Web_Url' => $web_url));
       //var_dump($result->count());      
    }


    public function DeleteCompany($id)
    {
            $query = $this->_query->delete('company', array('Subscriber_ID', '=', $id));
            if ($query->count()) {
               echo json_encode("Deleted");
            }else{
                return false;
            }
    }


    public function UpdateCompany($company_email, $comapany_id, $id)
    {
        if (!empty($id)) {
            $query = $this->_query->update('company',  array('Subscriber_ID' => $id), array(
                'Company_Email' => $company_email,
                'Subscriber_ID' => $comapany_id
            ));
            if ($query) {
                echo json_encode(array("Company Successfully Updated"));
            }
        }
    }
 
    public function CreatePackage($plan_name, $plan_amount, $plan_type, $no_user, $plan_duration, $storage_space, $package_status)
    {
        $plan_id = Classes_Generators::Numeric(5);
        $create_package =  $this->_query->insert('package_plan', array(
            'Plan_ID' => $plan_id,
            'Plan_Name' => $plan_name, 
            'Plan_Amount' => $plan_amount,
            'Plan_Type' => $plan_type,
            'No_User' => $no_user,
            'Plan_Duration' => $plan_duration,
            'Storage_Space' => $storage_space,
            'Package_Status' => $package_status
        ));
        if ($create_package) {
            // return array('Company Successfully Created'); 
        }
    }


    public function LoadSubscriptionPackage($company_subscription_package_list_access){
        $data = array();
        $serial_id = 0;

        $search_value = $_POST["search"]["value"];
        $orders = 'ID';
        $key = 'DESC';


        $query = $this->_query->query("SELECT * FROM package_plan");
        $total_package_filter = $query->count();

        if ($_POST['length'] != -1) {
            $limit = " " . $_POST['start'] . ", " . $_POST['length'] . " ";
        }

        if (!empty($_POST["search"]["value"])) {
            $sql_package = "SELECT * FROM package_plan WHERE Plan_Name LIKE ? OR Plan_Amount LIKE ? OR Plan_Type LIKE ? OR Plan_Duration LIKE ? OR Storage_Space LIKE ? OR Created_Date LIKE ? ORDER BY $orders $key LIMIT $limit";
            $data_value = array('%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%');
            $query_result_c = $this->_query->query($sql_package, $data_value);
            //$sql_package = "SELECT * FROM package_plan ORDER BY $orders $key LIMIT $limit";
        } else {
            $sql_package = "SELECT * FROM package_plan ORDER BY $orders $key LIMIT $limit";
            $query_result_c = $this->_query->query($sql_package);
        }



       
        $total_package_data = $query_result_c->count();


        $fetching_results = $query_result_c->results();
        $serial_id = 1;
        foreach ($fetching_results as $key => $data_value) {

            $delete_button = "<button type='button' id='{$data_value["ID"]}' class='btn btn-danger btn-glow delete_package box-shadow'>Delete</button>";
            $upgrade_button = "<button type='button' id='{$data_value["ID"]}' class='btn btn-warning btn-glow upgrade_package_plan box-shadow'>Upgrade</button>";


            if($data_value["Plan_Duration"] == 30){
                $plan_duration = '1 Month';
            }elseif ($data_value["Plan_Duration"] == 180) {
                $plan_duration = '6 Months';
            }elseif ($data_value["Plan_Duration"] == 360) {
                $plan_duration = '1 Year';
            }

            $package_data = array();
            $package_data[] = $serial_id;
            $package_data[] = $data_value["Plan_Name"];
            $package_data[] = $data_value["Plan_Type"];
            $package_data[] = '$'.$data_value["Plan_Amount"];
            $package_data[] = $plan_duration;
            $package_data[] = $data_value["Storage_Space"];
            if($company_subscription_package_list_access != 'company_subscription_package_list_access'){
                $package_data[] = $data_value["Created_Date"];
                $package_data[] = $data_value["Modified_Date"] == '' ? 'Not Edit Yet' : $data_value["Modified_Date"];
                $package_data[] = $delete_button;
            }
            else {
                $package_data[] = $upgrade_button;
            }
            
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


    public function UpdatePackage($plan_name, $plan_amount, $plan_type, $no_user, $plan_duration, $storage_space, $package_status,$__package_id)
    {

        if (!empty($__package_id)) {
            $query = $this->_query->update('package_plan',  array('ID' => $__package_id), array(
            'Plan_Name' => $plan_name, 
            'Plan_Amount' => $plan_amount,
            'Plan_Type' => $plan_type,
            'No_User' => $no_user,
            'Plan_Duration' => $plan_duration,
            'Storage_Space' => $storage_space,
            'Package_Status' => $package_status,
            'Modified_Date' => date("Y-m-d H:i:s"),
            ));
            if ($query) {
                //echo json_encode(array("Package Successfully Updated"));
            }
        }
    }


    public function DeletePackage($id)
    {
        $query = $this->_query->delete('package_plan', array('ID', '=', $id));
        if ($query->count()) {
            echo json_encode("Deleted");
        } else {
            return false;
        }
    }


    public function CompleteRegisteredCompany(){
        $data = array();
        $serial_id = 0;

        $search_value = $_POST["search"]["value"];
        $orders = 'ID';
        $key = 'DESC';


        $query = $this->_query->query("SELECT * FROM company WHERE Plan_Name != ? ", array(''));
        $total_comp_filter = $query->count();

        if ($_POST['length'] != -1) {
            $limit = " " . $_POST['start'] . ", " . $_POST['length'] . " ";
        }


        

        if (!empty($_POST["search"]["value"])) {
            $sql_package = "SELECT * FROM company WHERE Plan_Name != ? AND Company_Name LIKE ? OR Plan_Name LIKE ? OR No_User LIKE ? OR Start_Dates LIKE ? OR End_Date LIKE ? OR Plan_Status LIKE ? ORDER BY $orders $key LIMIT $limit";
            $data_value = array('', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%');
            $query_result_c = $this->_query->query($sql_package, $data_value);
        } else {
            $sql_package = "SELECT * FROM company WHERE Plan_Name != ? ORDER BY $orders $key LIMIT $limit";
            $data_value = array('');

            $query_result_c = $this->_query->query($sql_package, $data_value);
        }

        $total_comp_data = $query_result_c->count();
        $fetching_results = $query_result_c->results();


        $serial_id = 1;
        $plan_duration='';
        foreach ($fetching_results as $key => $data_value) {

            $company_status = $data_value["Status"] == 'Active' ? 'checked' : '';
            $update_plan_button = "<button type='button' id='{$data_value["Subscriber_ID"]}'  class='btn btn-warning btn-glow change_plan box-shadow'>Change Plan</button>";
            
            $status_switch = "<label class='switch'><input type='checkbox' ".$company_status. " class='company_status' id='" . $data_value["Subscriber_ID"] . "' value='Active'><span class='switch-button'></span></label>";

            if ($data_value["Plan_Duration"] == 30) {
                $plan_duration = '1 Month';
            } elseif ($data_value["Plan_Duration"] == 180) {
                $plan_duration = '6 Months';
            } elseif ($data_value["Plan_Duration"] == 360) {
                $plan_duration = '1 Year';
            }
            if(!empty($data_value["Company_Logo"])){
                $company_logo = '<img style="width:40px; height:40px" class="rounded-circle img-border height-20" src="Folders/Company_Folders/' . $data_value["Subscriber_ID"] . '/Logo/' . $data_value["Company_Logo"] . '" alt="'. $data_value["Company_Name"].'">';
            } else {
                $company_logo = '<img style="width:40px; height:40px" class="rounded-circle img-border height-20" src="Folders/brand/no_logo.jpg" alt="'. $data_value["Company_Name"].'">';
            }

            
            if ($data_value["Plan_Status"] == 'Active') {
                $plan_status = '<div class="badge badge-success">Active</div>';
            } else {
                $plan_status = '<div class="badge badge-danger">Expired</div>';
            }


            $com__data = array();
            $com__data[] = $serial_id;
            $com__data[] = $company_logo.' '.$data_value["Company_Name"];
            $com__data[] = $data_value["Plan_Name"];
            $com__data[] = $data_value["No_User"].' Users';
            $com__data[] = $plan_duration;
            $com__data[] = date("d F Y", strtotime($data_value["Start_Dates"]));
            $com__data[] = date("d F Y", strtotime($data_value["End_Date"]));
            $com__data[] = '$'.$data_value["Amount"];
            //$com__data[] = date("d F Y", strtotime($data_value["Created_Date"])); 
            $com__data[] = $plan_status;
            $com__data[] = $update_plan_button;
            $com__data[] = $status_switch;
            $data[] = $com__data;
            $serial_id++;
        }


        $complete_comp_list_result_output = array(

            "draw"  => intval($_POST["draw"]),
            "recordsTotal" => intval($total_comp_data),
            "recordsFiltered" => intval($total_comp_filter),
            "data" => $data,
        );

        echo json_encode($complete_comp_list_result_output);
    }



    public function CompanyStatus($__id, $__company_status){
        if (!empty($__id)) {
            $query = $this->_query->update('company',  array('Subscriber_ID' => $__id), array(
                'Status' => $__company_status
            ));
            if ($query) {
            }
        }

        
    }


    public function SubscriptionUpgrade($__package_id, $__company_id){
        if (!empty($__package_id)) {

            $query = $this->_query->get('package_plan', array('ID', '=', $__package_id));
            $query_result = $query->first();
            $current_date = date("Y-m-d");

            $end_date = date('Y-m-d', strtotime($current_date .' +'. $query_result["Plan_Duration"] .'day'));

            $this->_query->insert('subscribed_companies', array(
                'Subscriber_ID' => $__company_id,
                'Plan_ID' => $query_result["Plan_ID"],
                'Plan_Name' => $query_result["Plan_Name"],
                'Plan_Amount' => $query_result["Plan_Amount"],
                'Plan_Type' => $query_result["Plan_Type"],
                'Plan_Duration' => $query_result["Plan_Duration"],
                'No_User' => $query_result["No_User"],
                'Storage' => $query_result["Storage_Space"],
                'Start_Dates' => $current_date,
                'End_Date' => $end_date,
                'Status' => 'Active'
            ));

            //echo $__company_id;

            $query__ = $this->_query->update('company',  array('Subscriber_ID' => $__company_id), array(
                'Plan_ID' => $query_result["Plan_ID"],
                'Plan_Name' => $query_result["Plan_Name"],
                'No_User' => $query_result["No_User"],
                'Plan_Duration' => $query_result["Plan_Duration"],
                'Start_Dates' => $current_date,
                'End_Date' => $end_date,
                'Amount' => $query_result["Plan_Amount"],
                'Storage' => $query_result["Storage_Space"],
                'Plan_Status' => "Active"
            ));
            return $query__;
            if ($query__) {
                
            }
        }
    }



    
  



}
