<?php

class Model_Company_EmployeeModel{

    public function __construct()
    {
        $this->_query = Classes_Db::getInstance();

        $this->data_manager = new Controller_Company_Default_Datamanagement();
        $this->module_access_result = $this->data_manager->ModuleData()->results();
        $this->localization = $this->data_manager->LocalizationData()->first();
        $this->is_login = $this->data_manager->isLogin()->first();
        $this->web_data = $this->data_manager->WebData()->first();
    }


    public function getCountryState($country_id){
       $country_data =  $this->_query->get('states', array('country_id', '=', $country_id))->results();
           foreach ($country_data as $key => $country_data_value) {
            if(!empty($country_data_value["name"]))
            echo "<option value=". $country_data_value["name"].">". $country_data_value["name"]."</option>";
           }       
    }


    public function createCompany($employee_id, $employee_image, $employee_employee_id, $employee_fullname, $employee_lastname, 
    $employee_date_of_birth, $employee_gender, $employee_phone_number, $employee_branch, $employee_department, $employee_position, 
    $employee_hiring_date, $employee_address, $employee_license, $employee_marital_status, $employee_country, $employee_state, 
    $employee_religion, $employee_no_of_children, $emergency_primary_name, $emergency_primary_relationship, $emergency_primary_contact, 
    $emergency_secondary_name, $emergency_secondary_relationship, $emergency_secondary_contact, $employee_bank_name, $employee_account_number, 
    $employee_social_security_per, $employee_association_per, $employee_annual_vacation_day, $employee_payment_type, $employee_currency_type, 
    $employee_monthly_salary, $employee_email_address, $employee_password){

        $employee_image = $employee_image == NULL ? '' : $employee_image;
        
        $employee_gen_id = Classes_Generators::AlphaNumeric(12);
        $employee_gen_id = strtoupper($employee_gen_id);

        $employee_data_g = $this->_query->query('SELECT * FROM employee WHERE Subscriber_ID = ? AND ID = ?', array(Classes_Session::get('Loggedin_Session'), $employee_id));
        $employee_data = $employee_data_g->count();
        $user_data_value = $employee_data_g->first();

        //Tax Determination
        $tax_determination = $this->_query->query('SELECT * FROM salary_tax_settings WHERE Status = ? AND Subscriber_ID = ? AND "'.$employee_monthly_salary.'" BETWEEN Salary_From AND Salary_To', array('Active', Classes_Session::get('Loggedin_Session')))->first();
        $actual_tax_id = $tax_determination["ID"];
        //$actual_tax_id = $actual_tax_id == NULL || $actual_tax_id < 1 ? '0' : $actual_tax_id;

        $employee_password = password_hash($employee_password, PASSWORD_DEFAULT);

        if ($employee_data > 0) {

            $employee_query = $this->_query->query('UPDATE employee SET First_Name = "'.$employee_fullname.'", Last_Name ="'.$employee_lastname.'", Gender ="'.$employee_gender.'", DOB="'.$employee_date_of_birth.'", Phone_Number="'. $employee_phone_number.'", Nationality ="' . $employee_country . '", City ="' . $employee_state . '", Address ="' . $employee_address . '", Religion="'.$employee_religion.'", License ="' . $employee_license . '", Marital="' . $employee_marital_status . '", Kids="' . $employee_no_of_children . '", Emergency_Primary_Name="'.$emergency_primary_name. '", Emergency_Primary_Relationship="'.$emergency_primary_relationship. '", Emergency_Primary_Contact="'.$emergency_primary_contact. '", Emergency_Secondary_Name="'.$emergency_secondary_name. '", Emergency_Secondary_Relationship="'.$emergency_secondary_relationship. '", Emergency_Secondary_Contact="'.$emergency_secondary_contact.'", HireDate="' . $employee_hiring_date . '", Payment_Type="' . $employee_payment_type . '",  Social_Security="'.$employee_social_security_per. '", Association="'.$employee_association_per. '", Tax_ID="'. $actual_tax_id. '", Salary="'.$employee_monthly_salary. '", Currency="'.$employee_currency_type. '", Branch="'. $employee_branch.'", Department="'.$employee_department. '", Position="'.$employee_position. '", Email="'.$employee_email_address. '", Image="'.$employee_image.'", Vacation="'.$employee_annual_vacation_day. '", Bank_Name="'.$employee_bank_name.'", Account_Number="'.$employee_account_number.'", Modified_Date="' . date('Y-m-d') . '", Modified_by="' . $this->is_login["Username"] . '"  WHERE ID = "' . $employee_id . '" AND Subscriber_ID ="' . Classes_Session::get("Loggedin_Session") . '"');
            echo json_encode(array("Employee Successfully Update", "Action" => "Update"));
        } else {

            $employee_query = $this->_query->insert('employee', array(
                'Subscriber_ID' => Classes_Session::get('Loggedin_Session'),
                'Employee_ID' => $employee_gen_id,
                'Emp_ID' => $employee_employee_id,
                'First_Name' => $employee_fullname,
                'Last_Name' => $employee_lastname,
                'Gender' => $employee_gender,
                'DOB' => $employee_date_of_birth,
                'Phone_Number' => $employee_phone_number,
                'Nationality' => $employee_country,
                'City' => $employee_state,
                'Address' => $employee_address,
                'Religion' => $employee_religion,
                'License' => $employee_license,
                'Marital' => $employee_marital_status,
                'Kids' => $employee_no_of_children,
                'Emergency_Primary_Name' => $emergency_primary_name,
                'Emergency_Primary_Relationship' => $emergency_primary_relationship,
                'Emergency_Primary_Contact' => $emergency_primary_contact,
                'Emergency_Secondary_Name' => $emergency_secondary_name,
                'Emergency_Secondary_Relationship' => $emergency_secondary_relationship,
                'Emergency_Secondary_Contact' => $emergency_secondary_contact,
                'HireDate' => $employee_hiring_date,
                'Payment_Type' => $employee_payment_type,
                'Social_Security' => $employee_social_security_per,
                'Association' => $employee_association_per,
                'Tax_ID' => $actual_tax_id,
                'Salary' => $employee_monthly_salary,
                'Currency' => $employee_currency_type,
                'Branch' => $employee_branch,
                'Department' => $employee_department,
                'Position' => $employee_position,
                'Email' => $employee_email_address,
                'Image' => $employee_image,
                'Vacation' => $employee_annual_vacation_day,
                'Bank_Name' => $employee_bank_name,
                'Account_Number' => $employee_account_number,
                'Created_Date' => date("Y-m-d"),
                'Created_By' => $this->is_login["Username"],
                'Status' => 'Active'
            ));


            $login_query = $this->_query->insert('logindetail', array(
                'Subscriber_ID' => Classes_Session::get('Loggedin_Session'),
                'Login_ID' => $employee_gen_id,
                'Username' => $employee_employee_id,
                'Email' => $employee_email_address,
                'Password' => $employee_password,
                'Role' => 'Staff',
                'Status' => 'Active',
            ));

            echo json_encode(array("Employee Successfully Created"));
        }


    }



    public function getEmployeeGridView(){

        $sql_employee = "SELECT * FROM employee WHERE Subscriber_ID = ? ORDER BY ID DESC LIMIT 20";
        $query_result_c = $this->_query->query($sql_employee, array(Classes_Session::get('Loggedin_Session')));

        $total_employee_data = $query_result_c->count();

        if ($total_employee_data > 0) {
            $fetching_results = $query_result_c->results();

            $employee_grid_view = '';

            foreach ($fetching_results as $key => $data_value) {
                $full_name = $data_value["First_Name"] . ' ' . $data_value["Last_Name"];
                $position = $data_value["Position"]; $images = $data_value["Image"];

                $full_name_trim = strlen($full_name) > 20 ? substr($full_name, 0, 15) . '...' : $full_name;

                if ($data_value["Status"] == 'Active') {
                    $employee_status = '<span class="badge badge-default badge-success">' . $data_value["Status"] . ' Employee</span>';
                } elseif ($data_value["Status"] == 'Complete') {
                    $employee_status = '<span class="badge badge-default badge-danger">' . $data_value["Status"] . ' Employee</span>';
                }
                $employee_link = '<a class="info" style="font-size: 15px" href="' . $this->web_data["Web_Url"] . 'view-employee?employee_id=' . $data_value["Employee_ID"] . '"><b>' . $full_name_trim . '</b> </a>';


                $employee_image = empty($images) ? $this->web_data["Web_Url"]. 'Folders/brand/no_image.png' : $this->web_data["Web_Url"]. 'Folders/Company_Folders/'. Classes_Session::get('Loggedin_Session').'/Employee_Image/'. $images;
                $employee_grid_view.= '
                    <div class="col-xl-3 col-md-6 col-12">
                        <div class="card box-shadow-1">

                            <div class="float-right text-right ">
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements"><br>
                                    <ul class="list-inline mb-0">
                                        <div class="dropdown dropdown-action profile-action">
                                            <a href="#" class="action-icon dropdown-toggles" data-toggle="dropdown" aria-expanded="false"><i class="la la-ellipsis-v"></i></a>
                                            <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(24px, 32px, 0px);">
                                                <a class="dropdown-item edit_employee" href="'. $this->web_data["Web_Url"].'edit-employee?employee_id='.$data_value["Employee_ID"].'"><i class="la la-pencil m-r-5"></i> Edit</a>
                                                <a class="dropdown-item delete_employee" href="#" data-toggle="modal" id="' . $data_value["ID"] . '"><i class="la la-trash-o m-r-5"></i> Delete</a>
                                            </div>
                                        </div>
                                    </ul>
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="card-body">
                                    <img src="'. $employee_image.'" class="rounded-circle  height-100" alt="Employee Image">
                                </div>
                                '. $employee_status.'
                                <div class="card-body">
                                    <h4 class="card-title" title="'. $full_name.'">'. $employee_link.'</h4>
                                    <h6 class="card-subtitle text-muted">'. $position.'</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                ';

            }
        }

        echo json_encode($employee_grid_view);
    }


    public function getEmployeeListView(){
        $data = array();
        $serial_id = 0;

        $search_value = $_POST["search"]["value"];

        $column_order = array('Emp_ID', 'First_Name', 'HireDate', 'ExitDate', 'Branch', 'Department', 'Currency', 'Salary', 'Created_Date', 'Status');
        if ($_POST['order']) {
            $order_by = $column_order[$_POST['order'][0]['column']] . ' ' . $_POST['order']['0']['dir'];
        }


        $query = $this->_query->query("SELECT * FROM employee WHERE Subscriber_ID = ?", array(Classes_Session::get("Loggedin_Session")));
        $total_employee_filter = $query->count();

        if ($_POST['length'] != -1) {
            $limit = " " . $_POST['start'] . ", " . $_POST['length'] . " ";
        }

        if (!empty($_POST["search"]["value"])) {
            $sql_employee = "SELECT * FROM employee WHERE Subscriber_ID = ? AND (Emp_ID LIKE ? OR First_Name LIKE ? OR HireDate LIKE ? OR ExitDate LIKE ? OR Branch LIKE ? OR Department LIKE ? OR Currency LIKE ? OR Salary LIKE ? OR Created_Date LIKE ? OR Status LIKE ?) ORDER BY $order_by LIMIT $limit";
            $data_value = array(Classes_Session::get("Loggedin_Session"), '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%');
            $query_result_c = $this->_query->query($sql_employee, $data_value);
        } else {
            $sql_employee = "SELECT * FROM employee WHERE Subscriber_ID = ? ORDER BY $order_by LIMIT $limit";
            $query_result_c = $this->_query->query($sql_employee, array(Classes_Session::get("Loggedin_Session")));
        }


        $total_employee_data = $query_result_c->count();


        $fetching_results = $query_result_c->results();
        $serial_id = 1;
        foreach ($fetching_results as $key => $data_value) {

            $department_results = $this->data_manager->DepartmentDataByID($data_value["Department"])->first();
            $branch_results = $this->data_manager->BranchDataByID($data_value["Branch"])->first();
            $currency_results = $this->data_manager->CurrencyDataByID($data_value["Currency"])->first();


            $action_buttons = '<span class="dropdown">
                              <button id="user_actions" type="button" data-toggle="dropdown" aria-haspopup="true"
                              aria-expanded="false" class="btn btn-info dropdown-toggle"><i class="la la-cog"></i></button>
                              <span aria-labelledby="btnSearchDrop2" class="dropdown-menu mt-1 dropdown-menu-right">
                                <a href="' .$this->web_data["Web_Url"] .'edit-employee?employee_id=' . $data_value["Employee_ID"] . '" class="dropdown-item "><i class="la la-edit"></i> Edit </a>
                                <a href="#" id="' . $data_value["ID"] . '" class="dropdown-item delete_employee"><i class="la la-trash-o"></i> Delete</a>

                              </span>
                            </span>';

            $access_permission = '<span class="badge badge-default badge-primary">' . $data_value["Role"] . '</span>';

            if ($data_value["Status"] == 'Active') {
                $employee_status = '<span class="badge badge-default badge-success">' . $data_value["Status"] . '</span>';
            } elseif ($data_value["Status"] == 'Inactive') {
                $employee_status = '<span class="badge badge-default badge-danger">' . $data_value["Status"] . '</span>';
            }

            $employee_image = empty($data_value["Image"]) ? $this->web_data["Web_Url"] . 'Folders/brand/no_image.png' : $this->web_data["Web_Url"] . 'Folders/Company_Folders/' . Classes_Session::get('Loggedin_Session') . '/Employee_Image/' . $data_value["Image"];
            $employee_image = '<span class="avatar avatar-online"> <img src="' . $employee_image . '" class="rounded-circle" style="width: 50px; height: 30px;" alt="Employee Image"></span>';

            $employee_link = '<a class="info" style="font-size: 15px" href="'. $this->web_data["Web_Url"].'view-employee?employee_id='.$data_value["Employee_ID"].'"><b>'. $data_value["First_Name"] . ' ' . $data_value["Last_Name"].'</b> </a>';
           
            $employee_data = array();
            $employee_data[] = $data_value["Employee_ID"] ;
            $employee_data[] = $employee_image.' '. $employee_link;
            $employee_data[] = date($this->localization["Date_Format"], strtotime($data_value["HireDate"]));
            $employee_data[] = empty($data_value["ExitDate"]) ? '' : date($this->localization["Date_Format"], strtotime($data_value["ExitDate"]));
            $employee_data[] = $branch_results["Branch_Name"];
            $employee_data[] = $department_results["Department_Name"];
            $employee_data[] = $data_value["Exit_Contract_Note"];
            $employee_data[] = $currency_results["Currency_Code"].' '. $currency_results["Currency_Symbol"];
            $employee_data[] = number_format($data_value["Salary"]);
            $employee_data[] = date($this->localization["Date_Format"], strtotime($data_value["Created_Date"]));
            // $employee_data[] = $data_value["Created_By"];
            // $employee_data[] = $data_value["Modified_Date"] == '0000-00-00' ? 'Not Yet Edited' : date($this->localization["Date_Format"], strtotime($data_value["Modified_Date"]));
            // $employee_data[] = $data_value["Modified_By"] == '' ? 'Not Yet Edited' : $data_value["Modified_By"];
            $employee_data[] = $employee_status;
            $employee_data[] = $action_buttons;

            $data[] = $employee_data;
            $serial_id++;
        }


        $employee_list_result_output = array(

            "draw"  => intval($_POST["draw"]),
            "recordsTotal" => intval($total_employee_data),
            "recordsFiltered" => intval($total_employee_filter),
            "data" => $data,
        );

        echo json_encode($employee_list_result_output);
    }

    public function deleteEmployee($employee_id){
        $employee_query_user = $this->_query->query('DELETE FROM employee WHERE ID = "' . $employee_id . '" AND Subscriber_ID ="' . Classes_Session::get("Loggedin_Session") . '"');

    }
}