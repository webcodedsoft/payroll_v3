<?php

class Model_Company_Defaultmodel
{
    public function __construct()
    {
        $this->_query = Classes_Db::getInstance();

        $this->data_manager = new Controller_Company_Default_Datamanagement();
        $this->module_access_result = $this->data_manager->ModuleData()->results();
        $this->is_login = $this->data_manager->isLogin()->first();

    }

    public function CompanySetup($company_id, $company_email, $upload_reponse, $plan_status, $company_name, $company_phone_number, $company_website, $company_header_report, $authorize_signature_name, $company_username, $authorize_signature_position, $company_password, $company_address){
        $plan_data = $this->_query->get('package_plan', array('Plan_Name', '=', 'Free'));
        $plan_data = $plan_data->first();

        $end_date = date('Y-m-d', strtotime(date("Y-m-d") . ' +' . $plan_data["Plan_Duration"] . 'day'));
        
        $user_gen_id = Classes_Generators::AlphaNumeric(8);
        $user_gen_id = strtoupper($user_gen_id);

              $setup_query = $this->_query->update('company', array('Company_Email' => Classes_Session::get('Setup_Session')), array(
                'Company_Name' => $company_name,
                'Company_Phone' => $company_phone_number,
                'Company_Header' => $company_header_report,
                'Company_Sign_Name' => $authorize_signature_name,
                'Company_Sign_Position' => $authorize_signature_position,
                'Company_Website' => $company_website,
                'Company_Address' => $company_address,
                'Company_Logo' => $upload_reponse,
                'Plan_Name' => $plan_data["Plan_Name"],
                'No_User' => $plan_data["No_User"],
                'Plan_Duration' => $plan_data["Plan_Duration"],
                'Start_Dates' => date("Y-m-d"),
                'End_Date' => $end_date,
                'Amount' => $plan_data["Plan_Amount"],
                'Modified_Date' => date("Y-m-d"),
                'Modified_By' => $this->is_login["Username"],
                'Storage' => $plan_data["Storage_Space"],
                'Plan_Status' => empty($plan_status) ? 'Active' : $plan_status,
            ));

        $company_password = password_hash($company_password, PASSWORD_DEFAULT);

            $login_query = $this->_query->insert('logindetail', array(
                'Subscriber_ID' => $company_id,
                'Login_ID' => $user_gen_id,
                'Username' => $company_username,
                'Email' => $company_email,
                'Password' => $company_password,
                'Role' => 'Administrator',
                'Status' => 'Active',
            ));

            $user_query = $this->_query->insert('users', array(
                'Subscriber_ID' => Classes_Session::get('Setup_Session'),
                'User_ID' => $user_gen_id,
                'First_Name' => '',
                'Last_Name' => '',
                'Username' => $company_username,
                'Email' => $company_email,
                'Phone_Number' => $company_phone_number,
                'Role' => 'Administrator',
                'Created_Date' => date("Y-m-d"),
                'Created_By' => $company_username,
                'Status' => 'Active'
            ));

        $module_access_value_array = array();
        foreach ($this->module_access_result as $key => $module_access_result_value) {
            $module_access_value_array[] = $module_access_result_value["Module_Name"];
        }
        $module_access_value = implode(",", $module_access_value_array);
        $login_query = $this->_query->insert('role_permission', array(
            'Subscriber_ID' => Classes_Session::get('Loggedin_Session'),
            'Role_Name' => 'Administrator',
            'Modules' => $module_access_value,
            'Creates' => 'true,true,true,true,true,true,true,true,true,true,true',
            'ReadP' => 'true,true,true,true,true,true,true,true,true,true,true',
            'Deletes' => 'true,true,true,true,true,true,true,true,true,true,true',
            'Locks' => 'true,true,true,true,true,true,true,true,true,true,true',
            'Unlocks' => 'true,true,true,true,true,true,true,true,true,true,true',
            'Status' => 'Active,Active,Active,Active,Active,Active,Active,Active,Active,Active,Active',
        ));
 
        $journal_query = $this->_query->insert('journal_report', array(
            'Subscriber_ID' => $company_id,
            'Accounting_Code' => '5006,5005,5001,5004,5003,5002,5000,2001,2002,2003,2004,2817,2818,2819,2820',
            'Accounting_Name' => 'Basic Salary,Bonus,Comission,Allowance,Other Earning,Extra 1.5, Extra 2.0,Ordinary Days,Loan,Assessment,Other Deduction,Association,Social Security,Tax Salary,Netpay',
            'Created_Date' => date("Y-m-d"),
            'Created_By' => $this->is_login["Username"]
        ));

        if ($login_query) {
            Classes_Session::delete('Setup_Session');
            Classes_Session::put('Loggedin_Session', $company_id);
        }
       
    }
}
