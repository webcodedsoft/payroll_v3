<?php

class Model_Company_ConfigurationModel
{
    public function __construct()
    {
        $this->_query_config = Classes_Db::getInstance();
        $this->data_manager = new Controller_Company_Default_Datamanagement();
        $this->localization = $this->data_manager->LocalizationData()->first();

        $this->is_login = $this->data_manager->isLogin()->first();
    }

    public function AddBranch($branch_id, $branch_name, $branch_address, $branch_email, $telephone1, $telephone2, $status){
        
        $branch_gen_id = Classes_Generators::AlphaNumeric(6);
        $branch_gen_id = strtoupper($branch_gen_id);

        $branch_data_g = $this->_query_config->query('SELECT * FROM branch WHERE Subscriber_ID = ? AND ID = ?', array(Classes_Session::get('Loggedin_Session'), $branch_id));
        $branch_data = $branch_data_g->count();
        $branch_data_value = $branch_data_g->first();

        if ($branch_data > 0) {

            $branch_query = $this->_query_config->query('UPDATE branch SET Branch_Name = "' . $branch_name . '", Branch_Address ="' . $branch_address . '", Branch_Phone1 ="' . $telephone1 . '", Branch_Phone2 ="' . $telephone2 . '", Branch_Email ="' . $branch_email . '", Status ="' . $status . '", Modified_Date="' . date('Y-m-d') . '", Modified_by="' . $this->is_login["Username"] . '" WHERE ID = "' . $branch_id . '" AND Subscriber_ID ="' . Classes_Session::get("Loggedin_Session") . '"');
            echo json_encode(array("Branch Successfully Update"));
        } else {

            $branch_query = $this->_query_config->insert('branch', array(
                'Subscriber_ID' => Classes_Session::get('Loggedin_Session'),
                'Branch_ID' => $branch_gen_id,
                'Branch_Name' => $branch_name,
                'Branch_Address' => $branch_address,
                'Branch_Phone1' => $telephone1,
                'Branch_Phone2' => $telephone2,
                'Branch_Email' => $branch_email,
                'Status' => $status,
                'Created_Date' => date("Y-m-d"),
            ));
            echo json_encode(array("Branch Successfully Created"));
        }
    }


    public function LoadBranch(){
        $data = array();
        $serial_id = 0;

        $search_value = $_POST["search"]["value"];
       
        $column_order = array('Branch_Name', 'Branch_Address', 'Branch_Phone1', 'Branch_Phone2', 'Branch_Email', 'Status');
        if($_POST['order']){
          $order_by = $column_order[$_POST['order'][0]['column']].' '.$_POST['order']['0']['dir'];
        }
        

        $query = $this->_query_config->query("SELECT * FROM branch WHERE Subscriber_ID = ?", array(Classes_Session::get("Loggedin_Session")));
        $total_branch_filter = $query->count();

        if ($_POST['length'] != -1) {
            $limit = " " . $_POST['start'] . ", " . $_POST['length'] . " ";
        }

        if (!empty($_POST["search"]["value"])) {
            $sql_branch = "SELECT * FROM branch WHERE Subscriber_ID = ? AND (Branch_Name LIKE ? OR Branch_Address LIKE ? OR Branch_Phone1 LIKE ? OR Branch_Phone2 LIKE ? OR Branch_Email LIKE ? OR Status LIKE ?) ORDER BY $order_by LIMIT $limit";
            $data_value = array(Classes_Session::get("Loggedin_Session"), '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%');
            $query_result_c = $this->_query_config->query($sql_branch, $data_value);
        } else {
            $sql_branch = "SELECT * FROM branch WHERE Subscriber_ID = ? ORDER BY $order_by LIMIT $limit";
            $query_result_c = $this->_query_config->query($sql_branch, array(Classes_Session::get("Loggedin_Session")));
        }




        $total_branch_data = $query_result_c->count();

        if($total_branch_data > 0){
            $fetching_results = $query_result_c->results();
            $serial_id = 1;
            foreach ($fetching_results as $key => $data_value) {


                $action_buttons = '<span class="dropdown">
                                <button id="user_actions" type="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" class="btn btn-info dropdown-toggle"><i class="la la-cog"></i></button>
                                <span aria-labelledby="btnSearchDrop2" class="dropdown-menu mt-1 dropdown-menu-right">
                                    <a href="#" id="' . $data_value["ID"] . '" class="dropdown-item edit_branch"><i class="la la-edit"></i> Edit </a>
                                    <a href="#" id="' . $data_value["ID"] . '" class="dropdown-item delete_branch"><i class="la la-trash-o"></i> Delete</a>

                                </span>
                                </span>';

                $access_permission = '<span class="badge badge-default badge-primary">' . $data_value["Role"] . '</span>';

                if ($data_value["Status"] == 'Active') {
                    $branch_status = '<span class="badge badge-default badge-success">' . $data_value["Status"] . '</span>';
                } elseif ($data_value["Status"] == 'Disabled') {
                    $branch_status = '<span class="badge badge-default badge-danger">' . $data_value["Status"] . '</span>';
                }

                $branch_data = array();
                $branch_data[] = $data_value["Branch_Name"];
                $branch_data[] = $data_value["Branch_Address"];
                $branch_data[] = $data_value["Branch_Phone1"];
                $branch_data[] = $data_value["Branch_Phone2"];
                $branch_data[] = $data_value["Branch_Email"];
                $branch_data[] = date($this->localization["Date_Format"], strtotime($data_value["Created_Date"]));
                $branch_data[] = $data_value["Created_By"];
                $branch_data[] = $data_value["Modified_Date"] == '0000-00-00' ? 'Not Yet Edited' : date($this->localization["Date_Format"], strtotime($data_value["Modified_Date"]));
                $branch_data[] = $data_value["Modified_By"] == '' ? 'Not Yet Edited' : $data_value["Modified_By"];
                $branch_data[] = $branch_status;
                $branch_data[] = $action_buttons;

                $data[] = $branch_data;
                $serial_id++;
            }
        }

        $branch_list_result_output = array(

            "draw"  => intval($_POST["draw"]),
            "recordsTotal" => intval($total_branch_data),
            "recordsFiltered" => intval($total_branch_filter),
            "data" => $data,
        );

        echo json_encode($branch_list_result_output);
    }

    public function DeleteBranch($branch_id){
        $branch_query = $this->_query_config->query('DELETE FROM branch WHERE ID = "' . $branch_id . '" AND Subscriber_ID ="' . Classes_Session::get("Loggedin_Session") . '"');
    }

    public function AddDepartment($department_id, $department_name, $department_desc, $department_status){

        $department_gen_id = Classes_Generators::AlphaNumeric(6);
        $department_gen_id = strtoupper($department_gen_id);

        $department_data_g = $this->_query_config->query('SELECT * FROM department WHERE Subscriber_ID = ? AND ID = ?', array(Classes_Session::get('Loggedin_Session'), $department_id));
        $department_data = $department_data_g->count();
        $department_data_value = $department_data_g->first();

        if ($department_data > 0) {

            $department_query = $this->_query_config->query('UPDATE department SET Department_Name = "' . $department_name . '", Department_Desc ="' . $department_desc . '", Status ="' . $department_status . '", Modified_Date="' . date('Y-m-d') . '", Modified_by="' . $this->is_login["Username"] . '" WHERE ID = "' . $department_id . '" AND Subscriber_ID ="' . Classes_Session::get("Loggedin_Session") . '"');
            echo json_encode(array("Department Successfully Update"));
        } else {

            $department_query = $this->_query_config->insert('department', array(
                'Subscriber_ID' => Classes_Session::get('Loggedin_Session'),
                'Department_ID' => $department_gen_id,
                'Department_Name' => $department_name,
                'Department_Desc' => $department_desc,
                'Status' => $department_status,
                'Created_Date' => date("Y-m-d"),
            ));
            echo json_encode(array("Department Successfully Created"));
        }
    }


    public function LoadDepartment()
    {
        $data = array();
        $serial_id = 0;

        $search_value = $_POST["search"]["value"];

        $column_order = array('Department_Name', 'Department_Desc', 'Status');
        if ($_POST['order']) {
            $order_by = $column_order[$_POST['order'][0]['column']] . ' ' . $_POST['order']['0']['dir'];
        }


        $query = $this->_query_config->query("SELECT * FROM department WHERE Subscriber_ID = ?", array(Classes_Session::get("Loggedin_Session")));
        $total_department_filter = $query->count();

        if ($_POST['length'] != -1) {
            $limit = " " . $_POST['start'] . ", " . $_POST['length'] . " ";
        }

        if (!empty($_POST["search"]["value"])) {
            $sql_department = "SELECT * FROM department WHERE Subscriber_ID = ? AND (Department_Name LIKE ? OR Department_Desc LIKE ? OR Status LIKE ? ) ORDER BY $order_by LIMIT $limit";
            $data_value = array(Classes_Session::get("Loggedin_Session"), '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%');
            $query_result_c = $this->_query_config->query($sql_department, $data_value);
        } else {
            $sql_department = "SELECT * FROM department WHERE Subscriber_ID = ? ORDER BY $order_by LIMIT $limit";
            $query_result_c = $this->_query_config->query($sql_department, array(Classes_Session::get("Loggedin_Session")));
        }

        $total_department_data = $query_result_c->count();


        if($total_department_data > 0){
            $fetching__depart_results = $query_result_c->results();
            $serial_id = 1;
            foreach ($fetching__depart_results as $key => $data_value) {


                $action_buttons = '<span class="dropdown">
                                <button id="user_actions" type="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" class="btn btn-info dropdown-toggle"><i class="la la-cog"></i></button>
                                <span aria-labelledby="btnSearchDrop2" class="dropdown-menu mt-1 dropdown-menu-right">
                                    <a href="#" id="' . $data_value["ID"] . '" class="dropdown-item edit_department"><i class="la la-edit"></i> Edit </a>
                                    <a href="#" id="' . $data_value["ID"] . '" class="dropdown-item delete_department"><i class="la la-trash-o"></i> Delete</a>

                                </span>
                                </span>';

                $access_permission = '<span class="badge badge-default badge-primary">' . $data_value["Role"] . '</span>';

                if ($data_value["Status"] == 'Active') {
                    $department_status = '<span class="badge badge-default badge-success">' . $data_value["Status"] . '</span>';
                } elseif ($data_value["Status"] == 'Disabled') {
                    $department_status = '<span class="badge badge-default badge-danger">' . $data_value["Status"] . '</span>';
                }

                $department_data = array();
                $department_data[] = $data_value["Department_Name"];
                $department_data[] = $data_value["Department_Desc"];
                $department_data[] = date($this->localization["Date_Format"], strtotime($data_value["Created_Date"]));
                $department_data[] = $data_value["Created_By"];
                $department_data[] = $data_value["Modified_Date"] == '0000-00-00' ? 'Not Yet Edited' : date($this->localization["Date_Format"], strtotime($data_value["Modified_Date"]));
                $department_data[] = $data_value["Modified_By"] == '' ? 'Not Yet Edited' : $data_value["Modified_By"];
                $department_data[] = $department_status;
                $department_data[] = $action_buttons;

                $data[] = $department_data;
                $serial_id++;
            }
        }

        $department_list_result_output = array(

            "draw"  => intval($_POST["draw"]),
            "recordsTotal" => intval($total_department_data),
            "recordsFiltered" => intval($total_department_filter),
            "data" => $data,
        );

        echo json_encode($department_list_result_output);
    }

    public function DeleteDepartment($department_id)
    {
        $department_query = $this->_query_config->query('DELETE FROM department WHERE ID = "' . $department_id . '" AND Subscriber_ID ="' . Classes_Session::get("Loggedin_Session") . '"');
    }


    public function UpdateJournal($accounting_code){
        $account_code = '';
        $this->_query_config->update('journal_report', array('Subscriber_ID' => Classes_Session::get("Loggedin_Session")), array('Accounting_Code' => $accounting_code, 'Modified_Date' => date("Y-m-d"), 'Modified_By' => $this->is_login["Username"]));
    }


    public function LoadJournal(){

        $data = array();
        $serial_id = 0;

        $search_value = $_POST["search"]["value"];

        $column_order = array('Accounting_Code', 'Accounting_Name');
        if ($_POST['order']) {
            $order_by = $column_order[$_POST['order'][0]['column']] . ' ' . $_POST['order']['0']['dir'];
        }


        $query = $this->_query_config->query("SELECT * FROM journal_report WHERE Subscriber_ID = ?", array(Classes_Session::get("Loggedin_Session")));
        $total_journal_filter = $query->count();

        if ($_POST['length'] != -1) {
            $limit = " " . $_POST['start'] . ", " . $_POST['length'] . " ";
        }

        if (!empty($_POST["search"]["value"])) {
            $sql_journal = "SELECT * FROM journal_report WHERE Subscriber_ID = ? AND (Accounting_Code LIKE ? OR Accounting_Name LIKE ? ) ORDER BY $order_by LIMIT $limit";
            $data_value = array(Classes_Session::get("Loggedin_Session"), '%' . $search_value . '%', '%' . $search_value . '%');
            $query_result_c = $this->_query_config->query($sql_journal, $data_value);
        } else {
            $sql_journal = "SELECT * FROM journal_report WHERE Subscriber_ID = ? ORDER BY $order_by LIMIT $limit";
            $query_result_c = $this->_query_config->query($sql_journal, array(Classes_Session::get("Loggedin_Session")));
        }

        $total_journal_data = $query_result_c->count();

        if($total_journal_data > 0){
            $fetching__journal_results = $query_result_c->first();

            $created_date = $fetching__journal_results["Created_Date"];
            $created_by = $fetching__journal_results["Created_By"];
            $modified_date = $fetching__journal_results["Modified_Date"];
            $modified_by = $fetching__journal_results["Modified_By"];
            $accounting_codes = $fetching__journal_results["Accounting_Code"];
            $accounting_name = $fetching__journal_results["Accounting_Name"];

            $accounting_codes = explode(",", $accounting_codes);
            $accounting_name = explode(",", $accounting_name);
            $serial_id = 1;
            foreach ($accounting_codes as $key => $accounting_code) {

                $journal_data = array();
                $journal_data[] = $serial_id;
                $journal_data[] = $accounting_code;
                $journal_data[] = $accounting_name[$key];
                $journal_data[] = $created_date;
                $journal_data[] = $created_by;
                $journal_data[] = $modified_date == '0000-00-00' ? 'Not Yet Edited' : date($this->localization["Date_Format"], strtotime($modified_date));
                $journal_data[] = $modified_by == '' ? 'Not Yet Edited' : $modified_by;

                $data[] = $journal_data;
                $serial_id++;
            }
            
            // $serial_id = 1;
            // foreach ($fetching__journal_results as $key => $data_value) {
            //     $access_permission = '<span class="badge badge-default badge-primary">' . $data_value["Role"] . '</span>';

            //     $journal_data = array();
            //     $journal_data[] = $serial_id;
            //     $journal_data[] = $data_value["Accounting_Code"];
            //     $journal_data[] = $data_value["Accounting_Name"];
            //     $journal_data[] = $data_value["Created_Date"];
            //     $journal_data[] = $data_value["Created_By"];
            //     $journal_data[] = $data_value["Modified_Date"] == '0000-00-00' ? 'Not Yet Edited' : date($this->localization["Date_Format"], strtotime($data_value["Modified_Date"]));
            //     $journal_data[] = $data_value["Modified_By"] == '' ? 'Not Yet Edited' : $data_value["Modified_By"];

            //     $data[] = $journal_data;
            //     $serial_id++;
            // }
        }
        $journal_list_result_output = array(
            "draw"  => intval($_POST["draw"]),
            "recordsTotal" => intval($total_journal_data),
            "recordsFiltered" => intval($total_journal_filter),
            "data" => $data,
        );

        echo json_encode($journal_list_result_output);
    }


    public function AddSalaryTax($salary_id, $salary_from, $salary_to, $tax_rate, $salary_status){
        $salary_gen_id = Classes_Generators::AlphaNumeric(6);
        $salary_gen_id = strtoupper($salary_gen_id);

        $salary_data_g = $this->_query_config->query('SELECT * FROM salary_tax_settings WHERE Subscriber_ID = ? AND ID = ?', array(Classes_Session::get('Loggedin_Session'), $salary_id));
        $salary_data = $salary_data_g->count();
        $salary_data_value = $salary_data_g->first();

        if ($salary_data > 0) {

            $salary_query = $this->_query_config->query('UPDATE salary_tax_settings SET Salary_From = "' . $salary_from . '", Salary_To ="' . $salary_to . '", Tax_Rate ="' . $tax_rate . '", Status="'.$salary_status.'", Modified_Date="'.date('Y-m-d').'", Modified_by="'.$this->is_login["Username"].'" WHERE ID = "' . $salary_id . '" AND Subscriber_ID ="' . Classes_Session::get("Loggedin_Session") . '"');
            echo json_encode(array("Salary & Tax Successfully Update"));
        } else {

            $salary_query = $this->_query_config->insert('salary_tax_settings', array(
                'Subscriber_ID' => Classes_Session::get('Loggedin_Session'),
                'Salary_ID' => $salary_gen_id,
                'Salary_From' => $salary_from,
                'Salary_To' => $salary_to,
                'Tax_Rate' => $tax_rate,
                'Status' => $salary_status,                
                'Created_Date' => date("Y-m-d"),
                'Created_By' => $this->is_login["Username"],
            ));
            echo json_encode(array("Salary & Tax Successfully Created"));
        }
    }


    public function LoadSalaryTax(){
        $data = array();
        $serial_id = 0;

        $search_value = $_POST["search"]["value"];

        $column_order = array('Salary_From', 'Salary_To', 'Tax_Rate', 'Created_Date', 'Created_By', 'Modified_Date', 'Modified_By', 'Status');
        if ($_POST['order']) {
            $order_by = $column_order[$_POST['order'][0]['column']] . ' ' . $_POST['order']['0']['dir'];
        }


        $query = $this->_query_config->query("SELECT * FROM salary_tax_settings WHERE Subscriber_ID = ?", array(Classes_Session::get("Loggedin_Session")));
        $total_salary_filter = $query->count();

        if ($_POST['length'] != -1) {
            $limit = " " . $_POST['start'] . ", " . $_POST['length'] . " ";
        }

        if (!empty($_POST["search"]["value"])) {
            $sql_salary = "SELECT * FROM salary_tax_settings WHERE Subscriber_ID = ? AND (Salary_From LIKE ? OR Salary_To LIKE ? OR Tax_Rate LIKE ? OR Status LIKE ? OR Created_Date LIKE ? OR Created_By LIKE ? OR Modified_Date LIKE ? OR Modified_By LIKE ?) ORDER BY $order_by LIMIT $limit";
            $data_value = array(Classes_Session::get("Loggedin_Session"), '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%');
            $query_result_c = $this->_query_config->query($sql_salary, $data_value);
        } else {
            $sql_salary = "SELECT * FROM salary_tax_settings WHERE Subscriber_ID = ? ORDER BY $order_by LIMIT $limit";
            $query_result_c = $this->_query_config->query($sql_salary, array(Classes_Session::get("Loggedin_Session")));
        }

        $total_salary_data = $query_result_c->count();


        if($total_salary_data > 0){
            $fetching__salary_results = $query_result_c->results();

            $serial_id = 1;
            foreach ($fetching__salary_results as $key => $data_value) {

                $action_buttons = '<span class="dropdown">
                                <button id="user_actions" type="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" class="btn btn-info dropdown-toggle"><i class="la la-cog"></i></button>
                                <span aria-labelledby="btnSearchDrop2" class="dropdown-menu mt-1 dropdown-menu-right">
                                    <a href="#" id="' . $data_value["ID"] . '" class="dropdown-item edit_salary"><i class="la la-edit"></i> Edit </a>
                                    <a href="#" id="' . $data_value["ID"] . '" class="dropdown-item delete_salary"><i class="la la-trash-o"></i> Delete</a>

                                </span>
                                </span>';

                $access_permission = '<span class="badge badge-default badge-primary">' . $data_value["Role"] . '</span>';

                if ($data_value["Status"] == 'Active') {
                    $salary_status = '<span class="badge badge-default badge-success">' . $data_value["Status"] . '</span>';
                } elseif ($data_value["Status"] == 'Disabled') {
                    $salary_status = '<span class="badge badge-default badge-danger">' . $data_value["Status"] . '</span>';
                }

                $salary_data = array();
                $salary_data[] = $data_value["Salary_From"];
                $salary_data[] = $data_value["Salary_To"];
                $salary_data[] = $data_value["Tax_Rate"].'%';
                $salary_data[] = date($this->localization["Date_Format"], strtotime($data_value["Created_Date"]));
                $salary_data[] = $data_value["Created_By"];
                $salary_data[] = $data_value["Modified_Date"] == '0000-00-00' ? 'Not Yet Edited' : date($this->localization["Date_Format"], strtotime($data_value["Modified_Date"]));
                $salary_data[] = $data_value["Modified_By"] == '' ? 'Not Yet Edited' : $data_value["Modified_By"];
                $salary_data[] = $salary_status;
                $salary_data[] = $action_buttons;
                $data[] = $salary_data;
                $serial_id++;
            }
        }

        $salary_list_result_output = array(
            "draw"  => intval($_POST["draw"]),
            "recordsTotal" => intval($total_salary_data),
            "recordsFiltered" => intval($total_salary_filter),
            "data" => $data,
        );

        echo json_encode($salary_list_result_output);
    }


    public function DeleteSalaryTax($salary_id){
        $salary_query = $this->_query_config->query('DELETE FROM salary_tax_settings WHERE ID = "' . $salary_id . '" AND Subscriber_ID ="' . Classes_Session::get("Loggedin_Session") . '"');
    }


    public function AddSocialSecurity($sos_id, $sos_code, $sos_rate, $sos_status){

        $sos_gen_id = Classes_Generators::AlphaNumeric(6);
        $sos_gen_id = strtoupper($sos_gen_id);

        $sos_data_g = $this->_query_config->query('SELECT * FROM social_security WHERE Subscriber_ID = ? AND ID = ?', array(Classes_Session::get('Loggedin_Session'), $sos_id));
        $sos_data = $sos_data_g->count();
        $department_data_value = $sos_data_g->first();

        if ($sos_data > 0) {

            $department_query = $this->_query_config->query('UPDATE social_security SET Sos_Code = "' . $sos_code . '", Rate ="' . $sos_rate . '", Status ="' . $sos_status . '", Modified_By="'. $this->is_login["Username"].'", Modified_Date="'.date("Y-m-d").'" WHERE ID = "' . $sos_id . '" AND Subscriber_ID ="' . Classes_Session::get("Loggedin_Session") . '"');
            echo json_encode(array("Social Security Successfully Update"));
        } else {

            $department_query = $this->_query_config->insert('social_security', array(
                'Subscriber_ID' => Classes_Session::get('Loggedin_Session'),
                'SOS_ID' => $sos_gen_id,
                'Sos_Code' => $sos_code,
                'Rate' => $sos_rate,
                'Created_Date' => date("Y-m-d"),
                'Created_By' => $this->is_login["Username"],
                'Status' => $sos_status,

            ));
            echo json_encode(array("Social Security Successfully Created"));
        }

    }


    public function LoadSocialSecurity()
    {
        
        $data = array();
        $serial_id = 0;

        $search_value = $_POST["search"]["value"];

        $column_order = array('Sos_Code', 'Rate', 'Created_Date', 'Created_By', 'Modified_Date', 'Modified_By', 'Status');
        if ($_POST['order']) {
            $order_by = $column_order[$_POST['order'][0]['column']] . ' ' . $_POST['order']['0']['dir'];
        }


        $query = $this->_query_config->query("SELECT * FROM social_security WHERE Subscriber_ID = ?", array(Classes_Session::get("Loggedin_Session")));
        $total_sos_filter = $query->count();

        if ($_POST['length'] != -1) {
            $limit = " " . $_POST['start'] . ", " . $_POST['length'] . " ";
        }

        if (!empty($_POST["search"]["value"])) {
            $sql_sos = "SELECT * FROM social_security WHERE Subscriber_ID = ? AND (Sos_Code LIKE ? OR Rate LIKE ? OR Status LIKE ? OR Created_Date LIKE ? OR Created_By LIKE ? OR Modified_Date LIKE ? OR Modified_By LIKE ?) ORDER BY $order_by LIMIT $limit";
            $data_value = array(Classes_Session::get("Loggedin_Session"), '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%');
            $query_result_c = $this->_query_config->query($sql_sos, $data_value);
        } else {
            $sql_sos = "SELECT * FROM social_security WHERE Subscriber_ID = ? ORDER BY $order_by LIMIT $limit";
            $query_result_c = $this->_query_config->query($sql_sos, array(Classes_Session::get("Loggedin_Session")));
        }

        $total_sos_data = $query_result_c->count();
        
       

        if($total_sos_data > 0){

            $fetching__sos_results = $query_result_c->results();

            $serial_id = 1;
            foreach ($fetching__sos_results as $key => $data_value) {

                $action_buttons = '<span class="dropdown">
                                <button id="user_actions" type="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" class="btn btn-info dropdown-toggle"><i class="la la-cog"></i></button>
                                <span aria-labelledby="btnSearchDrop2" class="dropdown-menu mt-1 dropdown-menu-right">
                                    <a href="#" id="' . $data_value["ID"] . '" class="dropdown-item edit_social"><i class="la la-edit"></i> Edit </a>
                                    <a href="#" id="' . $data_value["ID"] . '" class="dropdown-item delete_social"><i class="la la-trash-o"></i> Delete</a>

                                </span>
                                </span>';

                $access_permission = '<span class="badge badge-default badge-primary">' . $data_value["Role"] . '</span>';

                if ($data_value["Status"] == 'Active') {
                    $sos_status = '<span class="badge badge-default badge-success">' . $data_value["Status"] . '</span>';
                } elseif ($data_value["Status"] == 'Disabled') {
                    $sos_status = '<span class="badge badge-default badge-danger">' . $data_value["Status"] . '</span>';
                }

                $sos_data = array();
                $sos_data[] = $data_value["Sos_Code"];
                $sos_data[] = $data_value["Rate"] . '%';
                $sos_data[] = date($this->localization["Date_Format"], strtotime($data_value["Created_Date"]));
                $sos_data[] = $data_value["Created_By"];
                $sos_data[] = $data_value["Modified_Date"] == '0000-00-00' ? 'Not Yet Edited' : date($this->localization["Date_Format"], strtotime($data_value["Modified_Date"]));
                $sos_data[] = $data_value["Modified_By"] == '' ? 'Not Yet Edited' : $data_value["Modified_By"];
                $sos_data[] = $sos_status;
                $sos_data[] = $action_buttons;
                $data[] = $sos_data;
                $serial_id++;
            }
        }

        $sos_list_result_output = array(
            "draw"  => intval($_POST["draw"]),
            "recordsTotal" => intval($total_sos_data),
            "recordsFiltered" => intval($total_sos_filter),
            "data" => $data,
        );

        echo json_encode($sos_list_result_output);
    }
    

    public function DeleteSocialSecurity($sos_id)
    {
        $salary_query = $this->_query_config->query('DELETE FROM social_security WHERE ID = "' . $sos_id . '" AND Subscriber_ID ="' . Classes_Session::get("Loggedin_Session") . '"');
    }


    public function AddAssociation($association_id, $association_code, $association_rate, $association_status)
    {

        $association_gen_id = Classes_Generators::AlphaNumeric(6);
        $association_gen_id = strtoupper($association_gen_id);

        $association_data_g = $this->_query_config->query('SELECT * FROM association WHERE Subscriber_ID = ? AND ID = ?', array(Classes_Session::get('Loggedin_Session'), $association_id));
        $association_data = $association_data_g->count();
        $association_data_value = $association_data_g->first();

        if ($association_data > 0) {

            $association_query = $this->_query_config->query('UPDATE association SET Association_Code = "' . $association_code . '", Association_Rate ="' . $association_rate . '", Status ="' . $association_status . '", Modified_By="' . $this->is_login["Username"] . '", Modified_Date="' . date("Y-m-d") . '" WHERE ID = "' . $association_id . '" AND Subscriber_ID ="' . Classes_Session::get("Loggedin_Session") . '"');
            echo json_encode(array("Association Successfully Update"));
        } else {

            $association_query = $this->_query_config->insert('association', array(
                'Subscriber_ID' => Classes_Session::get('Loggedin_Session'),
                'Association_ID' => $association_gen_id,
                'Association_Code' => $association_code,
                'Association_Rate' => $association_rate,
                'Created_Date' => date("Y-m-d"),
                'Created_By' => $this->is_login["Username"],
                'Status' => $association_status,

            ));
            echo json_encode(array("Association Successfully Created"));
        }
    }


    public function LoadAssociation()
    {

        $data = array();
        $serial_id = 0;

        $search_value = $_POST["search"]["value"];

        $column_order = array('Association_Code', 'Association_Rate', 'Created_Date', 'Created_By', 'Modified_Date', 'Modified_By', 'Status');
        if ($_POST['order']) {
            $order_by = $column_order[$_POST['order'][0]['column']] . ' ' . $_POST['order']['0']['dir'];
        }


        $query = $this->_query_config->query("SELECT * FROM association WHERE Subscriber_ID = ?", array(Classes_Session::get("Loggedin_Session")));
        $total_association_filter = $query->count();

        if ($_POST['length'] != -1) {
            $limit = " " . $_POST['start'] . ", " . $_POST['length'] . " ";
        }

        if (!empty($_POST["search"]["value"])) {
            $sql_association = "SELECT * FROM association WHERE Subscriber_ID = ? AND (Association_Code LIKE ? OR Association_Rate LIKE ? OR Status LIKE ? OR Created_Date LIKE ? OR Created_By LIKE ? OR Modified_Date LIKE ? OR Modified_By LIKE ?) ORDER BY $order_by LIMIT $limit";
            $data_value = array(Classes_Session::get("Loggedin_Session"), '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%');
            $query_result_c = $this->_query_config->query($sql_association, $data_value);
        } else {
            $sql_association = "SELECT * FROM association WHERE Subscriber_ID = ? ORDER BY $order_by LIMIT $limit";
            $query_result_c = $this->_query_config->query($sql_association, array(Classes_Session::get("Loggedin_Session")));
        }

        $total_association_data = $query_result_c->count();

        if ($total_association_data > 0) {

            $fetching__sos_results = $query_result_c->results();

            $serial_id = 1;
            foreach ($fetching__sos_results as $key => $data_value) {

                $action_buttons = '<span class="dropdown">
                                <button id="user_actions" type="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" class="btn btn-info dropdown-toggle"><i class="la la-cog"></i></button>
                                <span aria-labelledby="btnSearchDrop2" class="dropdown-menu mt-1 dropdown-menu-right">
                                    <a href="#" id="' . $data_value["ID"] . '" class="dropdown-item edit_association"><i class="la la-edit"></i> Edit </a>
                                    <a href="#" id="' . $data_value["ID"] . '" class="dropdown-item delete_association"><i class="la la-trash-o"></i> Delete</a>
                                </span>
                                </span>';

                $access_permission = '<span class="badge badge-default badge-primary">' . $data_value["Role"] . '</span>';

                if ($data_value["Status"] == 'Active') {
                    $association_status = '<span class="badge badge-default badge-success">' . $data_value["Status"] . '</span>';
                } elseif ($data_value["Status"] == 'Disabled') {
                    $association_status = '<span class="badge badge-default badge-danger">' . $data_value["Status"] . '</span>';
                }

                $association_data = array();
                $association_data[] = $data_value["Association_Code"];
                $association_data[] = $data_value["Association_Rate"] . '%';
                $association_data[] = date($this->localization["Date_Format"], strtotime($data_value["Created_Date"]));
                $association_data[] = $data_value["Created_By"];
                $association_data[] = $data_value["Modified_Date"] == '0000-00-00' ? 'Not Yet Edited' : date($this->localization["Date_Format"], strtotime($data_value["Modified_Date"]));
                $association_data[] = $data_value["Modified_By"] == '' ? 'Not Yet Edited' : $data_value["Modified_By"];
                $association_data[] = $association_status;
                $association_data[] = $action_buttons;
                $data[] = $association_data;
                $serial_id++;
            }
        }

        $association_list_result_output = array(
            "draw"  => intval($_POST["draw"]),
            "recordsTotal" => intval($total_association_data),
            "recordsFiltered" => intval($total_association_filter),
            "data" => $data,
        );

        echo json_encode($association_list_result_output);
    }


    public function DeleteAssociation($association_id)
    {
        $association_query = $this->_query_config->query('DELETE FROM association WHERE ID = "' . $association_id . '" AND Subscriber_ID ="' . Classes_Session::get("Loggedin_Session") . '"');
    }


    public function AddCurrency($currency_id, $country_name, $currency_name, $currency_code, $currency_symbol, $currency_type, $currency_status)
    {

        $currency_gen_id = Classes_Generators::AlphaNumeric(6);
        $currency_gen_id = strtoupper($currency_gen_id);

        $currency_data_g = $this->_query_config->query('SELECT * FROM currency WHERE Subscriber_ID = ? AND ID = ?', array(Classes_Session::get('Loggedin_Session'), $currency_id));
        $currency_data = $currency_data_g->count();
        $currency_data_value = $currency_data_g->first();

        if ($currency_data > 0) {

            $currency_query = $this->_query_config->query('UPDATE currency SET Country_Name = "' . $country_name . '", Currency_Name="'. $currency_name.'", Currency_Code ="' . $currency_code . '", Currency_Symbol="'. $currency_symbol.'", Currency_Type="'. $currency_type.'", Status ="' . $currency_status . '", Modified_By="' . $this->is_login["Username"] . '", Modified_Date="' . date("Y-m-d") . '" WHERE ID = "' . $currency_id . '" AND Subscriber_ID ="' . Classes_Session::get("Loggedin_Session") . '"');
            echo json_encode(array("Currency Successfully Update"));
        } else {

            $currency_query = $this->_query_config->insert('currency', array(
                'Subscriber_ID' => Classes_Session::get('Loggedin_Session'),
                'Currency_ID' => $currency_gen_id,
                'Country_Name' => $country_name,
                'Currency_Name' => $currency_name,
                'Currency_Code' => $currency_code,
                'Currency_Symbol' => $currency_symbol,
                'Currency_Type' => $currency_type,
                'Created_Date' => date("Y-m-d"),
                'Created_By' => $this->is_login["Username"],
                'Status' => $currency_status,

            ));
            echo json_encode(array("Currency Successfully Created"));
        }
    }


    public function LoadCurrency()
    {

        $data = array();
        $serial_id = 0;

        $search_value = $_POST["search"]["value"];

        $column_order = array('Country_Name', 'Currency_Name', 'Currency_Code', 'Currency_Symbol', 'Currency_Type', 'Created_Date', 'Created_By', 'Modified_Date', 'Modified_By', 'Status');
        if ($_POST['order']) {
            $order_by = $column_order[$_POST['order'][0]['column']] . ' ' . $_POST['order']['0']['dir'];
        }


        $query = $this->_query_config->query("SELECT * FROM currency WHERE Subscriber_ID = ?", array(Classes_Session::get("Loggedin_Session")));
        $total_currency_filter = $query->count();

        if ($_POST['length'] != -1) {
            $limit = " " . $_POST['start'] . ", " . $_POST['length'] . " ";
        }

        if (!empty($_POST["search"]["value"])) {
            $sql_currency = "SELECT * FROM currency WHERE Subscriber_ID = ? AND (Country_Name LIKE ? OR Currency_Name LIKE ? OR Currency_Code LIKE ? OR Currency_Symbol LIKE ? OR Currency_Type LIKE ? OR Status LIKE ? OR Created_Date LIKE ? OR Created_By LIKE ? OR Modified_Date LIKE ? OR Modified_By LIKE ?) ORDER BY $order_by LIMIT $limit";
            $data_value = array(Classes_Session::get("Loggedin_Session"), '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%');
            $query_result_c = $this->_query_config->query($sql_currency, $data_value);
        } else {
            $sql_currency = "SELECT * FROM currency WHERE Subscriber_ID = ? ORDER BY $order_by LIMIT $limit";
            $query_result_c = $this->_query_config->query($sql_currency, array(Classes_Session::get("Loggedin_Session")));
        }

        $total_currency_data = $query_result_c->count();

        if ($total_currency_data > 0) {

            $fetching__currency_results = $query_result_c->results();

            $serial_id = 1;
            foreach ($fetching__currency_results as $key => $data_value) {

                $action_buttons = '<span class="dropdown">
                                <button id="user_actions" type="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" class="btn btn-info dropdown-toggle"><i class="la la-cog"></i></button>
                                <span aria-labelledby="btnSearchDrop2" class="dropdown-menu mt-1 dropdown-menu-right">
                                    <a href="#" id="' . $data_value["ID"] . '" class="dropdown-item edit_currency"><i class="la la-edit"></i> Edit </a>
                                    <a href="#" id="' . $data_value["ID"] . '" class="dropdown-item delete_currency"><i class="la la-trash-o"></i> Delete</a>
                                </span>
                                </span>';

                $access_permission = '<span class="badge badge-default badge-primary">' . $data_value["Role"] . '</span>';

                if ($data_value["Status"] == 'Active') {
                    $currency_status = '<span class="badge badge-default badge-success">' . $data_value["Status"] . '</span>';
                } elseif ($data_value["Status"] == 'Disabled') {
                    $currency_status = '<span class="badge badge-default badge-danger">' . $data_value["Status"] . '</span>';
                }

                $currency_data = array();
                $currency_data[] = $data_value["Country_Name"];
                $currency_data[] = $data_value["Currency_Name"];
                $currency_data[] = $data_value["Currency_Code"];
                $currency_data[] = $data_value["Currency_Symbol"];
                $currency_data[] = $data_value["Currency_Type"];
                $currency_data[] = date($this->localization["Date_Format"], strtotime($data_value["Created_Date"]));
                $currency_data[] = $data_value["Created_By"];
                $currency_data[] = $data_value["Modified_Date"] == '0000-00-00' ? 'Not Yet Edited' : date($this->localization["Date_Format"], strtotime($data_value["Modified_Date"]));
                $currency_data[] = $data_value["Modified_By"] == '' ? 'Not Yet Edited' : $data_value["Modified_By"];
                $currency_data[] = $currency_status;
                $currency_data[] = $action_buttons;
                $data[] = $currency_data;
                $serial_id++;
            }
        }

        $currency_list_result_output = array(
            "draw"  => intval($_POST["draw"]),
            "recordsTotal" => intval($total_currency_data),
            "recordsFiltered" => intval($total_currency_filter),
            "data" => $data,
        );

        echo json_encode($currency_list_result_output);
    }


    public function DeleteCurrency($currency_id)
    {
        $currency_query = $this->_query_config->query('DELETE FROM currency WHERE ID = "' . $currency_id . '" AND Subscriber_ID ="' . Classes_Session::get("Loggedin_Session") . '"');
    }


    public function AddVacation($vacation_id, $vacation_name, $vacation_num_day, $vacation_status)
    {

        $vacation_gen_id = Classes_Generators::AlphaNumeric(6);
        $vacation_gen_id = strtoupper($vacation_gen_id);

        $vacation_data_g = $this->_query_config->query('SELECT * FROM vacation WHERE Subscriber_ID = ? AND ID = ?', array(Classes_Session::get('Loggedin_Session'), $vacation_id));
        $vacation_data = $vacation_data_g->count();
        $currency_data_value = $vacation_data_g->first();

        if ($vacation_data > 0) {

            $currency_query = $this->_query_config->query('UPDATE vacation SET Vacation_Name = "' . $vacation_name . '", Vacation_Day="' . $vacation_num_day . '", Status ="' . $vacation_status . '", Modified_By="' . $this->is_login["Username"] . '", Modified_Date="' . date("Y-m-d") . '" WHERE ID = "' . $vacation_id . '" AND Subscriber_ID ="' . Classes_Session::get("Loggedin_Session") . '"');
            echo json_encode(array("Vacation Successfully Update"));
        } else {

            $currency_query = $this->_query_config->insert('vacation', array(
                'Subscriber_ID' => Classes_Session::get('Loggedin_Session'),
                'Vacation_ID' => $vacation_gen_id,
                'Vacation_Name' => $vacation_name,
                'Vacation_Day' => $vacation_num_day,
                'Created_Date' => date("Y-m-d"),
                'Created_By' => $this->is_login["Username"],
                'Status' => $vacation_status,

            ));
            echo json_encode(array("Vacation Successfully Created"));
        }
    }


    public function LoadVacation()
    {

        $data = array();
        $serial_id = 0;

        $search_value = $_POST["search"]["value"];

        $column_order = array('Vacation_Name', 'Vacation_Day', 'Created_Date', 'Created_By', 'Modified_Date', 'Modified_By', 'Status');
        if ($_POST['order']) {
            $order_by = $column_order[$_POST['order'][0]['column']] . ' ' . $_POST['order']['0']['dir'];
        }


        $query = $this->_query_config->query("SELECT * FROM vacation WHERE Subscriber_ID = ?", array(Classes_Session::get("Loggedin_Session")));
        $total_vacation_filter = $query->count();

        if ($_POST['length'] != -1) {
            $limit = " " . $_POST['start'] . ", " . $_POST['length'] . " ";
        }

        if (!empty($_POST["search"]["value"])) {
            $sql_vacation = "SELECT * FROM vacation WHERE Subscriber_ID = ? AND (Vacation_Name LIKE ? OR Vacation_Day LIKE ? OR Status LIKE ? OR Created_Date LIKE ? OR Created_By LIKE ? OR Modified_Date LIKE ? OR Modified_By LIKE ?) ORDER BY $order_by LIMIT $limit";
            $data_value = array(Classes_Session::get("Loggedin_Session"), '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%');
            $query_result_c = $this->_query_config->query($sql_vacation, $data_value);
        } else {
            $sql_vacation = "SELECT * FROM vacation WHERE Subscriber_ID = ? ORDER BY $order_by LIMIT $limit";
            $query_result_c = $this->_query_config->query($sql_vacation, array(Classes_Session::get("Loggedin_Session")));
        }

        $total_vacation_data = $query_result_c->count();

        if ($total_vacation_data > 0) {

            $fetching__vacation_results = $query_result_c->results();

            $serial_id = 1;
            foreach ($fetching__vacation_results as $key => $data_value) {

                $action_buttons = '<span class="dropdown">
                                <button id="user_actions" type="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" class="btn btn-info dropdown-toggle"><i class="la la-cog"></i></button>
                                <span aria-labelledby="btnSearchDrop2" class="dropdown-menu mt-1 dropdown-menu-right">
                                    <a href="#" id="' . $data_value["ID"] . '" class="dropdown-item edit_vacation"><i class="la la-edit"></i> Edit </a>
                                    <a href="#" id="' . $data_value["ID"] . '" class="dropdown-item delete_vacation"><i class="la la-trash-o"></i> Delete</a>
                                </span>
                                </span>';

                $access_permission = '<span class="badge badge-default badge-primary">' . $data_value["Role"] . '</span>';

                if ($data_value["Status"] == 'Active') {
                    $vacation_status = '<span class="badge badge-default badge-success">' . $data_value["Status"] . '</span>';
                } elseif ($data_value["Status"] == 'Disabled') {
                    $vacation_status = '<span class="badge badge-default badge-danger">' . $data_value["Status"] . '</span>';
                }

                $vacation_data = array();
                $vacation_data[] = $data_value["Vacation_Name"];
                $vacation_data[] = $data_value["Vacation_Day"] > 1 ? $data_value["Vacation_Day"].' Days' : $data_value["Vacation_Day"].' Day';
                $vacation_data[] = date($this->localization["Date_Format"], strtotime($data_value["Created_Date"]));
                $vacation_data[] = $data_value["Created_By"];
                $vacation_data[] = $data_value["Modified_Date"] == '0000-00-00' ? 'Not Yet Edited' : date($this->localization["Date_Format"], strtotime($data_value["Modified_Date"]));
                $vacation_data[] = $data_value["Modified_By"] == '' ? 'Not Yet Edited' : $data_value["Modified_By"];
                $vacation_data[] = $vacation_status;
                $vacation_data[] = $action_buttons;
                $data[] = $vacation_data;
                $serial_id++;
            }
        }

        $vacation_list_result_output = array(
            "draw"  => intval($_POST["draw"]),
            "recordsTotal" => intval($total_vacation_data),
            "recordsFiltered" => intval($total_vacation_filter),
            "data" => $data,
        );

        echo json_encode($vacation_list_result_output);
    }


    public function DeleteVacation($vacation_id)
    {
        $vacation_query = $this->_query_config->query('DELETE FROM vacation WHERE ID = "' . $vacation_id . '" AND Subscriber_ID ="' . Classes_Session::get("Loggedin_Session") . '"');
    }



    public function AddFamilyTax($family_tax_id, $number_of_kids, $tax_amount, $family_tax_status)
    {
        
        $family_tax_gen_id = Classes_Generators::AlphaNumeric(6);
        $family_tax_gen_id = strtoupper($family_tax_gen_id);

        $family_tax_data_g = $this->_query_config->query('SELECT * FROM family_tax WHERE Subscriber_ID = ? AND ID = ?', array(Classes_Session::get('Loggedin_Session'), $family_tax_id));
        $family_tax_data = $family_tax_data_g->count();
        $family_tax_data_value = $family_tax_data_g->first();

        if ($family_tax_data > 0) {
            
            $family_tax_query = $this->_query_config->query('UPDATE family_tax SET Kids_Num = "' . $number_of_kids . '", Kid_Amount="' . $tax_amount . '", Status ="' . $family_tax_status . '", Modified_By="' . $this->is_login["Username"] . '", Modified_Date="' . date("Y-m-d") . '" WHERE ID = "' . $family_tax_id . '" AND Subscriber_ID ="' . Classes_Session::get("Loggedin_Session") . '"');
            echo json_encode(array("Family Tax Successfully Update"));
        } else {
            
            $family_tax_query = $this->_query_config->insert('family_tax', array(
                'Subscriber_ID' => Classes_Session::get('Loggedin_Session'),
                'Family_Tax_ID' => $family_tax_gen_id,
                'Kids_Num' => $number_of_kids,
                'Kid_Amount' => $tax_amount,
                'Created_Date' => date("Y-m-d"),
                'Created_By' => $this->is_login["Username"],
                'Status' => $family_tax_status,

            ));
            echo json_encode(array("Family Tax Successfully Created"));
        }
    }


    public function LoadFamilyTax()
    {

        $data = array();
        $serial_id = 0;

        $search_value = $_POST["search"]["value"];

        $column_order = array('Kids_Num', 'Kid_Amount', 'Created_Date', 'Created_By', 'Modified_Date', 'Modified_By', 'Status');
        if ($_POST['order']) {
            $order_by = $column_order[$_POST['order'][0]['column']] . ' ' . $_POST['order']['0']['dir'];
        }


        $query = $this->_query_config->query("SELECT * FROM family_tax WHERE Subscriber_ID = ?", array(Classes_Session::get("Loggedin_Session")));
        $total_family_tax_filter = $query->count();

        if ($_POST['length'] != -1) {
            $limit = " " . $_POST['start'] . ", " . $_POST['length'] . " ";
        }

        if (!empty($_POST["search"]["value"])) {
            $sql_family_tax = "SELECT * FROM family_tax WHERE Subscriber_ID = ? AND (Kids_Num LIKE ? OR Kid_Amount LIKE ? OR Status LIKE ? OR Created_Date LIKE ? OR Created_By LIKE ? OR Modified_Date LIKE ? OR Modified_By LIKE ?) ORDER BY $order_by LIMIT $limit";
            $data_value = array(Classes_Session::get("Loggedin_Session"), '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%');
            $query_result_c = $this->_query_config->query($sql_family_tax, $data_value);
        } else {
            $sql_family_tax = "SELECT * FROM family_tax WHERE Subscriber_ID = ? ORDER BY $order_by LIMIT $limit";
            $query_result_c = $this->_query_config->query($sql_family_tax, array(Classes_Session::get("Loggedin_Session")));
        }

        $total_family_tax_data = $query_result_c->count();

        if ($total_family_tax_data > 0) {

            $fetching__family_tax_results = $query_result_c->results();

            $serial_id = 1;
            foreach ($fetching__family_tax_results as $key => $data_value) {

                $action_buttons = '<span class="dropdown">
                                <button id="user_actions" type="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" class="btn btn-info dropdown-toggle"><i class="la la-cog"></i></button>
                                <span aria-labelledby="btnSearchDrop2" class="dropdown-menu mt-1 dropdown-menu-right">
                                    <a href="#" id="' . $data_value["ID"] . '" class="dropdown-item edit_family_tax"><i class="la la-edit"></i> Edit </a>
                                    <a href="#" id="' . $data_value["ID"] . '" class="dropdown-item delete_family_tax"><i class="la la-trash-o"></i> Delete</a>
                                </span>
                                </span>';

                $access_permission = '<span class="badge badge-default badge-primary">' . $data_value["Role"] . '</span>';

                if ($data_value["Status"] == 'Active') {
                    $family_tax_status = '<span class="badge badge-default badge-success">' . $data_value["Status"] . '</span>';
                } elseif ($data_value["Status"] == 'Disabled') {
                    $family_tax_status = '<span class="badge badge-default badge-danger">' . $data_value["Status"] . '</span>';
                }

                $family_tax_data = array();
                $family_tax_data[] = $data_value["Kids_Num"] > 1 ? $data_value["Kids_Num"].' Kids' : $data_value["Kids_Num"].' Kid';
                $family_tax_data[] = $this->localization["Currency_Symbol"].$data_value["Kid_Amount"];
                $family_tax_data[] = date($this->localization["Date_Format"], strtotime($data_value["Created_Date"]));
                $family_tax_data[] = $data_value["Created_By"];
                $family_tax_data[] = $data_value["Modified_Date"] == '0000-00-00' ? 'Not Yet Edited' : date($this->localization["Date_Format"], strtotime($data_value["Modified_Date"]));
                $family_tax_data[] = $data_value["Modified_By"] == '' ? 'Not Yet Edited' : $data_value["Modified_By"];
                $family_tax_data[] = $family_tax_status;
                $family_tax_data[] = $action_buttons;
                $data[] = $family_tax_data;
                $serial_id++;
            }
        }

        $family_tax_list_result_output = array(
            "draw"  => intval($_POST["draw"]),
            "recordsTotal" => intval($total_family_tax_data),
            "recordsFiltered" => intval($total_family_tax_filter),
            "data" => $data,
        );

        echo json_encode($family_tax_list_result_output);
    }


    public function DeleteFamilyTax($family_tax_id)
    {
        $family_tax_query = $this->_query_config->query('DELETE FROM family_tax WHERE ID = "' . $family_tax_id . '" AND Subscriber_ID ="' . Classes_Session::get("Loggedin_Session") . '"');
    }



    public function AddMaritalStatus($marital_status_id, $status_name, $status_amount, $marital_status_status)
    {

        $marital_status_gen_id = Classes_Generators::AlphaNumeric(6);
        $marital_status_gen_id = strtoupper($marital_status_gen_id);

        $marital_status_data_g = $this->_query_config->query('SELECT * FROM marital_status WHERE Subscriber_ID = ? AND ID = ?', array(Classes_Session::get('Loggedin_Session'), $marital_status_id));
        $marital_status_data = $marital_status_data_g->count();
        $marital_status_data_value = $marital_status_data_g->first();

        if ($marital_status_data > 0) {

            $marital_status_query = $this->_query_config->query('UPDATE marital_status SET Married_Name = "' . $status_name . '", Married_Amount="' . $status_amount . '", Status ="' . $marital_status_status . '", Modified_By="' . $this->is_login["Username"] . '", Modified_Date="' . date("Y-m-d") . '" WHERE ID = "' . $marital_status_id . '" AND Subscriber_ID ="' . Classes_Session::get("Loggedin_Session") . '"');
            echo json_encode(array("Family Tax Successfully Update"));
        } else {

            $marital_status_query = $this->_query_config->insert('marital_status', array(
                'Subscriber_ID' => Classes_Session::get('Loggedin_Session'),
                'Marital_ID' => $marital_status_gen_id,
                'Married_Name' => $status_name,
                'Married_Amount' => $status_amount,
                'Created_Date' => date("Y-m-d"),
                'Created_By' => $this->is_login["Username"],
                'Status' => $marital_status_status,

            ));
            echo json_encode(array("Family Tax Successfully Created"));
        }
    }


    public function LoadMaritalStatus()
    {

        $data = array();
        $serial_id = 0;

        $search_value = $_POST["search"]["value"];

        $column_order = array('Married_Name', 'Married_Amount', 'Created_Date', 'Created_By', 'Modified_Date', 'Modified_By', 'Status');
        if ($_POST['order']) {
            $order_by = $column_order[$_POST['order'][0]['column']] . ' ' . $_POST['order']['0']['dir'];
        }


        $query = $this->_query_config->query("SELECT * FROM marital_status WHERE Subscriber_ID = ?", array(Classes_Session::get("Loggedin_Session")));
        $total_marital_status_filter = $query->count();

        if ($_POST['length'] != -1) {
            $limit = " " . $_POST['start'] . ", " . $_POST['length'] . " ";
        }

        if (!empty($_POST["search"]["value"])) {
            $sql_marital_status = "SELECT * FROM marital_status WHERE Subscriber_ID = ? AND (Married_Name LIKE ? OR Married_Amount LIKE ? OR Status LIKE ? OR Created_Date LIKE ? OR Created_By LIKE ? OR Modified_Date LIKE ? OR Modified_By LIKE ?) ORDER BY $order_by LIMIT $limit";
            $data_value = array(Classes_Session::get("Loggedin_Session"), '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%');
            $query_result_c = $this->_query_config->query($sql_marital_status, $data_value);
        } else {
            $sql_marital_status = "SELECT * FROM marital_status WHERE Subscriber_ID = ? ORDER BY $order_by LIMIT $limit";
            $query_result_c = $this->_query_config->query($sql_marital_status, array(Classes_Session::get("Loggedin_Session")));
        }

        $total_marital_status_data = $query_result_c->count();

        if ($total_marital_status_data > 0) {

            $fetching__marital_status_results = $query_result_c->results();

            $serial_id = 1;
            foreach ($fetching__marital_status_results as $key => $data_value) {

                $action_buttons = '<span class="dropdown">
                                <button id="user_actions" type="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" class="btn btn-info dropdown-toggle"><i class="la la-cog"></i></button>
                                <span aria-labelledby="btnSearchDrop2" class="dropdown-menu mt-1 dropdown-menu-right">
                                    <a href="#" id="' . $data_value["ID"] . '" class="dropdown-item edit_marital_status"><i class="la la-edit"></i> Edit </a>
                                    <a href="#" id="' . $data_value["ID"] . '" class="dropdown-item delete_marital_status"><i class="la la-trash-o"></i> Delete</a>
                                </span>
                                </span>';

                $access_permission = '<span class="badge badge-default badge-primary">' . $data_value["Role"] . '</span>';

                if ($data_value["Status"] == 'Active') {
                    $marital_status_status = '<span class="badge badge-default badge-success">' . $data_value["Status"] . '</span>';
                } elseif ($data_value["Status"] == 'Disabled') {
                    $marital_status_status = '<span class="badge badge-default badge-danger">' . $data_value["Status"] . '</span>';
                }

                $marital_status_data = array();
                $marital_status_data[] = $data_value["Married_Name"];
                $marital_status_data[] = $this->localization["Currency_Symbol"] . $data_value["Married_Amount"];
                $marital_status_data[] = date($this->localization["Date_Format"], strtotime($data_value["Created_Date"]));
                $marital_status_data[] = $data_value["Created_By"];
                $marital_status_data[] = $data_value["Modified_Date"] == '0000-00-00' ? 'Not Yet Edited' : date($this->localization["Date_Format"], strtotime($data_value["Modified_Date"]));
                $marital_status_data[] = $data_value["Modified_By"] == '' ? 'Not Yet Edited' : $data_value["Modified_By"];
                $marital_status_data[] = $marital_status_status;
                $marital_status_data[] = $action_buttons;
                $data[] = $marital_status_data;
                $serial_id++;
            }
        }

        $marital_status_list_result_output = array(
            "draw"  => intval($_POST["draw"]),
            "recordsTotal" => intval($total_marital_status_data),
            "recordsFiltered" => intval($total_marital_status_filter),
            "data" => $data,
        );

        echo json_encode($marital_status_list_result_output);
    }


    public function DeleteMaritalStatus($marital_status_id)
    {
        $marital_status_query = $this->_query_config->query('DELETE FROM marital_status WHERE ID = "' . $marital_status_id . '" AND Subscriber_ID ="' . Classes_Session::get("Loggedin_Session") . '"');
    }


    public function AddLeaveType($leave_type, $leave_type_number_of_day, $leave_type_id, $leave_type_status){
        $leave_type_gen_id = Classes_Generators::AlphaNumeric(6);
        $leave_type_gen_id = strtoupper($leave_type_gen_id);

        $leave_type_data_g = $this->_query_config->query('SELECT * FROM leave_type WHERE Subscriber_ID = ? AND ID = ?', array(Classes_Session::get('Loggedin_Session'), $leave_type_id));
        $leave_type_data = $leave_type_data_g->count();
        $leave_type_data_value = $leave_type_data_g->first();

        if ($leave_type_data > 0) {

            $marital_status_query = $this->_query_config->query('UPDATE leave_type SET Leave_Type = "' . $leave_type . '", Number_of_Days="' . $leave_type_number_of_day . '", Status ="' . $leave_type_status . '", Modified_By="' . $this->is_login["Username"] . '", Modified_Date="' . date("Y-m-d") . '" WHERE ID = "' . $leave_type_id . '" AND Subscriber_ID ="' . Classes_Session::get("Loggedin_Session") . '"');
            echo json_encode(array("Leave Type Successfully Update"));
        } else {

            $marital_status_query = $this->_query_config->insert('leave_type', array(
                'Subscriber_ID' => Classes_Session::get('Loggedin_Session'),
                'Leave_ID' => $leave_type_gen_id,
                'Leave_Type' => $leave_type,
                'Number_of_Days' => $leave_type_number_of_day,
                'Created_Date' => date("Y-m-d"),
                'Created_By' => $this->is_login["Username"],
                'Status' => $leave_type_status,

            ));
            echo json_encode(array("Leave Type Successfully Created"));
        }
    }

    public function LoadLeaveType()
    {

        $data = array();
        $serial_id = 0;

        $search_value = $_POST["search"]["value"];

        $column_order = array('Leave_Type', 'Number_of_Days', 'Created_Date', 'Created_By', 'Modified_Date', 'Modified_By', 'Status');
        if ($_POST['order']) {
            $order_by = $column_order[$_POST['order'][0]['column']] . ' ' . $_POST['order']['0']['dir'];
        }


        $query = $this->_query_config->query("SELECT * FROM leave_type WHERE Subscriber_ID = ? AND Status = ?", array(Classes_Session::get("Loggedin_Session"), 'Active'));
        $total_leave_type_filter = $query->count();

        if ($_POST['length'] != -1) {
            $limit = " " . $_POST['start'] . ", " . $_POST['length'] . " ";
        }

        if (!empty($_POST["search"]["value"])) {
            $sql_leave_type = "SELECT * FROM leave_type WHERE Subscriber_ID = ? AND Status = ? AND (Leave_Type LIKE ? OR Number_of_Days LIKE ? OR Status LIKE ? OR Created_Date LIKE ? OR Created_By LIKE ? OR Modified_Date LIKE ? OR Modified_By LIKE ?) ORDER BY $order_by LIMIT $limit";
            $data_value = array(Classes_Session::get("Loggedin_Session"), 'Active', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%');
            $query_result_c = $this->_query_config->query($sql_leave_type, $data_value);
        } else {
            $sql_leave_type = "SELECT * FROM leave_type WHERE Subscriber_ID = ? AND Status = ? ORDER BY $order_by LIMIT $limit";
            $query_result_c = $this->_query_config->query($sql_leave_type, array(Classes_Session::get("Loggedin_Session"), 'Active'));
        }

        $total_leave_type_data = $query_result_c->count();

        if ($total_leave_type_data > 0) {

            $fetching__leave_type_results = $query_result_c->results();

            $serial_id = 1;
            foreach ($fetching__leave_type_results as $key => $data_value) {

                $action_buttons = '<span class="dropdown">
                                <button id="user_actions" type="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" class="btn btn-info dropdown-toggle"><i class="la la-cog"></i></button>
                                <span aria-labelledby="btnSearchDrop2" class="dropdown-menu mt-1 dropdown-menu-right">
                                    <a href="#" id="' . $data_value["ID"] . '" class="dropdown-item edit_leave_type"><i class="la la-edit"></i> Edit </a>
                                    <a href="#" id="' . $data_value["ID"] . '" class="dropdown-item delete_leave_type"><i class="la la-trash-o"></i> Delete</a>
                                </span>
                                </span>';

                $access_permission = '<span class="badge badge-default badge-primary">' . $data_value["Role"] . '</span>';

                if ($data_value["Status"] == 'Active') {
                    $leave_type_status = '<span class="badge badge-default badge-success">' . $data_value["Status"] . '</span>';
                } elseif ($data_value["Status"] == 'Disabled') {
                    $leave_type_status = '<span class="badge badge-default badge-danger">' . $data_value["Status"] . '</span>';
                }

                $leave_type_data = array();
                $leave_type_data[] = $data_value["Leave_Type"];
                $leave_type_data[] = $data_value["Number_of_Days"] > 1 ? $data_value["Number_of_Days"].' Days' : $data_value["Number_of_Days"].' Day';
                $leave_type_data[] = date($this->localization["Date_Format"], strtotime($data_value["Created_Date"]));
                $leave_type_data[] = $data_value["Created_By"];
                $leave_type_data[] = $data_value["Modified_Date"] == '0000-00-00' ? 'Not Yet Edited' : date($this->localization["Date_Format"], strtotime($data_value["Modified_Date"]));
                $leave_type_data[] = $data_value["Modified_By"] == '' ? 'Not Yet Edited' : $data_value["Modified_By"];
                $leave_type_data[] = $leave_type_status;
                $leave_type_data[] = $action_buttons;
                $data[] = $leave_type_data;
                $serial_id++;
            }
        }

        $leave_type_list_result_output = array(
            "draw"  => intval($_POST["draw"]),
            "recordsTotal" => intval($total_leave_type_data),
            "recordsFiltered" => intval($total_leave_type_filter),
            "data" => $data,
        );

        echo json_encode($leave_type_list_result_output);
    }


    public function DeleteLeaveType($leave_type_id)
    {
        $leave_type_id_query = $this->_query_config->query('DELETE FROM leave_type WHERE ID = "' . $leave_type_id . '" AND Subscriber_ID ="' . Classes_Session::get("Loggedin_Session") . '"');
    }

}
