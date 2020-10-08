<?php

class Model_Company_SettingsModel
{
    public function __construct()
    {
        $this->_query = Classes_Db::getInstance();

        $this->data = new Controller_Company_Default_Datamanagement();
        $this->module_access_result =  $this->data->ModuleData()->results();
    }

    public function RolePermission($modules_access, $role_name, $module_permission_create, $module_permission_read, $module_permission_delete, $module_permission_lock, $module_permission_unlock)
    {
        $role_data = $this->_query->query("SELECT * FROM role_permission WHERE Subscriber_ID = ? AND Role_Name = ?", array(Classes_Session::get('Loggedin_Session'), $role_name));
        $role_datas = $role_data->count();
        $role_data = $role_data->first();

        //var_dump($role_data["ID"]);

        $module_access_value_array = array();
        foreach ($this->module_access_result as $key => $module_access_result_value) {
            $module_access_value_array[] = $module_access_result_value["Module_Name"];
        }

        $module_access_value = implode(",", $module_access_value_array);
        if ($role_datas > 0) {
            $role_update_query = $this->_query->update(
                'role_permission',
                array('ID' => $role_data["ID"]),
                array(
                    'Role_Name' => $role_name,
                    'Modules' => $module_access_value,
                    'Creates' => $module_permission_create,
                    'ReadP' => $module_permission_read,
                    'Deletes' => $module_permission_delete,
                    'Locks' => $module_permission_lock,
                    'Unlocks' => $module_permission_unlock,
                    'Status' => $modules_access
                )
            );

            echo json_encode(array("Permission Successfully Update"));
        } else {
            $role_query = $this->_query->insert('role_permission', array(
                'Subscriber_ID' => Classes_Session::get('Loggedin_Session'),
                'Role_Name' => $role_name,
                'Modules' => $module_access_value,
                'Creates' => $module_permission_create,
                'ReadP' => $module_permission_read,
                'Deletes' => $module_permission_delete,
                'Locks' => $module_permission_lock,
                'Unlocks' => $module_permission_unlock,
                'Status' => $modules_access
            ));

            echo json_encode(array("Permission Successfully Set"));
        }
    }


    public function AddRole($role_name)
    {

        $role_data = $this->_query->query("SELECT * FROM role_permission WHERE Subscriber_ID = ? AND Role_Name = ?", array(Classes_Session::get('Loggedin_Session'), $role_name));
        $role_data = $role_data->count();

        if ($role_data == 0) {
            $module_access_value_array = array();
            foreach ($this->module_access_result as $key => $module_access_result_value) {
                $module_access_value_array[] = $module_access_result_value["Module_Name"];
            }
            $module_access_value = implode(",", $module_access_value_array);
            $login_query = $this->_query->insert('role_permission', array(
                'Subscriber_ID' => Classes_Session::get('Loggedin_Session'),
                'Role_Name' => $role_name,
                'Modules' => $module_access_value,
                'Creates' => 'true,true,true,true,true,true,true,true,true,true,true',
                'ReadP' => 'true,true,true,true,true,true,true,true,true,true,true',
                'Deletes' => 'true,true,true,true,true,true,true,true,true,true,true',
                'Locks' => 'true,true,true,true,true,true,true,true,true,true,true',
                'Unlocks' => 'true,true,true,true,true,true,true,true,true,true,true',
                'Status' => 'Active,Active,Active,Active,Active,Active,Active,Active,Active,Active,Active',
            ));

            echo json_encode(array("Role Successfully Created"));
        } else {
            echo json_encode(array("Role Already Exist"));
        }
    }


    public function FetchingPermissions($role_name)
    {

        $predefined_module = array();
        $module_output = '';
        $permission_list = '';

        $company_module_access_result = $this->data->CompanyModuleData($role_name)->first();

        $module_names = explode(",", $company_module_access_result["Modules"]);
        $module_statuss = explode(",", $company_module_access_result["Status"]);


        $module_creates = explode(",", $company_module_access_result["Creates"]);
        $module_reads = explode(",", $company_module_access_result["ReadP"]);
        $module_deletes = explode(",", $company_module_access_result["Deletes"]);
        $module_locks = explode(",", $company_module_access_result["Locks"]);
        $module_unlocks = explode(",", $company_module_access_result["Unlocks"]);


        //Predefined Database Module
        foreach ($module_statuss as $key => $module_status) {
            $predefined_module_status[] = $module_status;
        }

        foreach ($module_names as $key => $module_name) {
            $module_status_checked = $predefined_module_status[$key] == 'Active' ? 'checked' : '';

            $module_output .= '<li class="list-group-item">
                    <label class="switch float-right-role"><input type="checkbox" value="' . $predefined_module_status[$key] . '" name="module_access" ' . $module_status_checked . '><span class="switch-button"></span> </label>
                    ' . $module_name . '
                </li>';
        }



        $module_permission_name = array();
        //Module Name
        foreach ($module_names as $module_key => $module_name) {
            $module_permission_name[] = $module_name;
        }
        //Read Permission
        foreach ($module_reads as $module_read) {
            $module_read_permission[] = $module_read;
        }
        //Delete Permission
        foreach ($module_deletes as $module_delete) {
            $module_delete_permission[] = $module_delete;
        }
        //Lock Permission
        foreach ($module_locks as $module_lock) {
            $module_lock_permission[] = $module_lock;
        }
        //Unlock Permission
        foreach ($module_unlocks as $module_unlock) {
            $module_unlock_permission[] = $module_unlock;
        }


        foreach ($module_creates as $key => $module_create) {

            $module_create_list = $module_create == 'true' ? 'checked' : '';
            $module_read_permission_list = $module_read_permission[$key] == 'true' ? 'checked' : '';
            $module_delete_permission_list = $module_delete_permission[$key] == 'true' ? 'checked' : '';
            $module_lock_permission_list = $module_lock_permission[$key] == 'true' ? 'checked' : '';
            $module_unlock_permission_list = $module_unlock_permission[$key] == 'true' ? 'checked' : '';

            
            $permission_list.=' 
            <tr>
                <td>'.$module_permission_name[$key].'</td>
                <td class="text-center">
                    <input type="checkbox" name="module_permission_create" value="true" '.$module_create_list.'>
                </td>
                <td class="text-center">
                    <input type="checkbox" name="module_permission_read" value="true" '.$module_read_permission_list.'>
                </td>
                <td class="text-center">
                    <input type="checkbox" name="module_permission_delete" value="true" '.$module_delete_permission_list.'>
                </td>
                <td class="text-center">
                    <input type="checkbox" name="module_permission_lock" value="true" '.$module_lock_permission_list.'>
                </td>
                <td class="text-center">
                    <input type="checkbox" name="module_permission_unlock" value="true" '.$module_unlock_permission_list.'>
                </td>
            </tr>';

        }

        $response[] = array("module_list" => $module_output, "permission_list" => $permission_list);
        echo json_encode($response);
    }


    public function DeleteRole($role_id){
       $query = $this->_query->delete('role_permission', array('ID', '=', $role_id));
       echo json_encode('Deleted');
    }

    
    public function EditRole($role_name, $role_id){

        $query = Classes_Db::getInstance()->update('role_permission',  array('ID' => $role_id), array(
                'Role_Name' => $role_name
            ));
        echo json_encode('Deleted');
    }


    public function CompanyUpdate($upload_reponse, $company_name, $company_email, $company_id, $company_phone_number, $company_website, $company_header_report, $authorize_signature_name, $authorize_signature_position, $company_address){
        $setup_query = $this->_query->update('company', array('Subscriber_ID' => Classes_Session::get('Loggedin_Session')), array(
            'Company_ID' => $company_id,
            'Company_Email' => $company_email,
            'Company_Name' => $company_name,
            'Company_Phone' => $company_phone_number,
            'Company_Header' => $company_header_report,
            'Company_Sign_Name' => $authorize_signature_name,
            'Company_Sign_Position' => $authorize_signature_position,
            'Company_Website' => $company_website,
            'Company_Address' => $company_address,
            'Company_Logo' => $upload_reponse,
        ));

    }


    public function Localization($country, $date_format, $timezone, $language, $currency_code, $currency_symbol){
        $loc_data = $this->_query->get('localization', array('Subscriber_ID', '=', Classes_Session::get('Loggedin_Session')));
        $loc_data = $loc_data->count();

        if ($loc_data > 0) {
            $loc_query = $this->_query->update('localization', array('Subscriber_ID' => Classes_Session::get('Loggedin_Session')), array(
                'Country' => $country,
                'Date_Format' => $date_format,
                'Time_Zone' => $timezone,
                'Language' => $language,
                'Currency_Code' => $currency_code,
                'Currency_Symbol' => $currency_symbol,
            ));
        } else {

            $loc_query = $this->_query->insert('localization', array(
                'Subscriber_ID' => Classes_Session::get('Loggedin_Session'),
                'Country' => $country,
                'Date_Format' => $date_format,
                'Time_Zone' => $timezone,
                'Language' => $language,
                'Currency_Code' => $currency_code,
                'Currency_Symbol' => $currency_symbol,
                'Status' => 'Active'
            ));
        }
    }


    public function Theme($_logo, $_favicon, $_webname, $display_mode, $theme_orientation){
        $theme_data = $this->_query->get('theme', array('Subscriber_ID', '=', Classes_Session::get('Loggedin_Session')));
        $theme_data = $theme_data->count();

        if ($theme_data > 0) {
            $theme_query = $this->_query->update('theme', array('Subscriber_ID' => Classes_Session::get('Loggedin_Session')), array(
                'Website_Name' => $_webname,
                'Display_Mode' => $display_mode,
                'Theme_Orientation' => $theme_orientation,
                'Logo' => $_logo,
                'Favicon' => $_favicon,
            ));
        } else {

            $theme_query = $this->_query->insert('theme', array(
                'Subscriber_ID' => Classes_Session::get('Loggedin_Session'),
                'Website_Name' => $_webname,
                'Display_Mode' => $display_mode,
                'Theme_Orientation' => $theme_orientation,
                'Logo' => $_logo,
                'Favicon' => $_favicon,
                'Status' => 'Active'
            ));
        }
    }


    public function Email($host, $user_email, $password, $port, $security, $domain){
        $email_data = $this->_query->get('email_config', array('Subscriber_ID', '=', Classes_Session::get('Loggedin_Session')));
        $email_data = $email_data->count();

        if ($email_data > 0) {
            $email_query = $this->_query->update('email_config', array('Subscriber_ID' => Classes_Session::get('Loggedin_Session')), array(
                'Email_Host' => $host,
                'Email' => $user_email,
                'Email_Password' => $password,
                'Port' => $port,
                'Security' => $security,
                'Domain' => $domain,
            ));
        } else {

            $email_query = $this->_query->insert('email_config', array(
                'Subscriber_ID' => Classes_Session::get('Loggedin_Session'),
                'Email_Host' => $host,
                'Email' => $user_email,
                'Email_Password' => $password,
                'Port' => $port,
                'Security' => $security,
                'Domain' => $domain,
                'Status' => 'Active',
            ));
        }
    }



    public function ChangePassword($old_password, $new_password, $confirm_password){
        $password_data = $this->_query->query('SELECT * FROM logindetail WHERE Subscriber_ID = ? AND Login_ID = ?', array(Classes_Session::get('Loggedin_Session'), Classes_Session::get('Login_ID')));
        $password_data_count = $password_data->count();
        $password_data_value = $password_data->first();

        $new_password_has = password_hash($new_password, PASSWORD_DEFAULT);

        if (password_verify($old_password, $password_data_value['Password'])) {

            if($new_password == $confirm_password){
                $email_query = $this->_query->update('logindetail', array('Login_ID' => Classes_Session::get('Login_ID')), array(
                    'Password' => $new_password_has,
                ));
                echo json_encode(array("Settings Successfully Change"));
            } else {
                echo json_encode(array("Confirm Password Not Match"));
            }
            
        } else {
            echo json_encode(array("Invalid Old Password"));

        }

       
    }
}
