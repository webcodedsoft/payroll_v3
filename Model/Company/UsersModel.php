<?php

class Model_Company_UsersModel
{
    public function __construct()
    {
        $this->_query = Classes_Db::getInstance();
        $data = new Controller_Company_Default_Datamanagement();
        $this->localization = $data->LocalizationData()->first();
    }


    public function AddUser($user_id, $first_name, $last_names, $username, $email, $password, $phone_number, $access_permission)
    {
        $user_gen_id = Classes_Generators::AlphaNumeric(8);
        $user_gen_id = strtoupper($user_gen_id);

        $user_data_g = $this->_query->query('SELECT * FROM users WHERE Subscriber_ID = ? AND ID = ?', array(Classes_Session::get('Loggedin_Session'), $user_id));
        $user_data = $user_data_g->count();
        $user_data_value = $user_data_g->first();

        if ($user_data > 0) {

            $user_query_user = $this->_query->query('UPDATE users SET First_Name = "' . $first_name . '", Last_Name ="' . $last_names . '", Username ="' . $username . '", Email ="' . $email . '", Phone_Number ="' . $phone_number . '", Role ="' . $access_permission . '" WHERE ID = "' . $user_id . '" AND Subscriber_ID ="' . Classes_Session::get("Loggedin_Session") . '"');
            $user_query_login = $this->_query->query('UPDATE logindetail SET Username = "' . $username . '",  Email ="' . $email . '" WHERE Login_ID = "' . $user_data_value["User_ID"] . '" AND Subscriber_ID ="' . Classes_Session::get("Loggedin_Session") . '"'); 

        } else {

            $user_query = $this->_query->insert('users', array(
                'Subscriber_ID' => Classes_Session::get('Loggedin_Session'),
                'User_ID' => $user_gen_id,
                'First_Name' => $first_name,
                'Last_Name' => $last_names,
                'Username' => $username,
                'Email' => $email,
                'Phone_Number' => $phone_number,
                'Role' => $access_permission,
                'Created_Date' => date("Y-m-d"),
                'Status' => 'Active'
            ));


            $password = password_hash($password, PASSWORD_DEFAULT);

            $login_query = $this->_query->insert('logindetail', array(
                'Subscriber_ID' => Classes_Session::get('Loggedin_Session'),
                'Login_ID' => $user_gen_id,
                'Username' => $username,
                'Email' => $email,
                'Password' => $password,
                'Role' => $access_permission,
                'Status' => 'Active',
            ));

        }
    }


    public function LoadUsers(){
        $data = array();
        $serial_id = 0;

        $search_value = $_POST["search"]["value"];

        $column_order = array('First_Name', 'Last_Name', 'Username', 'Email', 'Phone_Number', 'Role');
        if ($_POST['order']) {
            $order_by = $column_order[$_POST['order'][0]['column']] . ' ' . $_POST['order']['0']['dir'];
        }

        $query = $this->_query->query("SELECT * FROM users WHERE Subscriber_ID = ?", array(Classes_Session::get('Loggedin_Session')));
        $total_users_filter = $query->count();

        if ($_POST['length'] != -1) {
            $limit = " " . $_POST['start'] . ", " . $_POST['length'] . " ";
        }

        if (!empty($_POST["search"]["value"])) {
            $sql_users = "SELECT * FROM users WHERE Subscriber_ID = ? AND (First_Name LIKE ? OR Last_Name LIKE ? OR Username LIKE ? OR Email LIKE ? OR Phone_Number LIKE ? OR Role LIKE ?) ORDER BY $order_by LIMIT $limit";
            $data_value = array('%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%');
            $query_result_c = $this->_query->query($sql_users, $data_value);
        } else {
            $sql_users = "SELECT * FROM users WHERE Subscriber_ID = ? ORDER BY $order_by LIMIT $limit";
            $query_result_c = $this->_query->query($sql_users, array(Classes_Session::get('Loggedin_Session')));
        }



        $total_users_data = $query_result_c->count();


        if($total_users_data > 0){
            $fetching_results = $query_result_c->results();
            $serial_id = 1;
            foreach ($fetching_results as $key => $data_value) {

                $user_status = $data_value["Status"] == 'Active' ? 'Block' : 'Unblock';

                $action_buttons = '<span class="dropdown">
                                <button id="user_actions" type="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" class="btn btn-info dropdown-toggle"><i class="la la-cog"></i></button>
                                <span aria-labelledby="btnSearchDrop2" class="dropdown-menu mt-1 dropdown-menu-right">
                                    <a href="#" id="'.$data_value["ID"]. '" class="dropdown-item edit_user"><i class="la la-edit"></i> Edit </a>
                                    <a href="#" id="'.$data_value["User_ID"] . '" class="dropdown-item block_user"><i class="la la-user-times"></i>'. $user_status.'</a>
                                    <div class="dropdown-divider"></div>
                                    <a href="#" id="' . $data_value["User_ID"] . '" class="dropdown-item delete_user"><i class="la la-trash-o"></i> Delete</a>

                                </span>
                                </span>';

                $access_permission = '<span class="badge badge-default badge-primary">' . $data_value["Role"] . '</span>';

                if ($data_value["Status"] == 'Active') {
                    $user_status = '<span class="badge badge-default badge-success">' . $data_value["Status"] . '</span>';
                } else {
                    $user_status = '<span class="badge badge-default badge-danger">' . $data_value["Status"] . '</span>';
                }

                $user_data = array();
                $user_data[] = $serial_id;
                $user_data[] = $data_value["First_Name"].' '. $data_value["Last_Name"];
                $user_data[] = $data_value["Username"];
                $user_data[] = $data_value["Email"];
                $user_data[] = $data_value["Phone_Number"];
                $user_data[] = $access_permission;
                $user_data[] = date($this->localization["Date_Format"], strtotime($data_value["Created_Date"]));
                $user_data[] = $data_value["Created_By"];
                $user_data[] = $data_value["Modified_Date"] == '0000-00-00' ? 'Not Yet Edited' : date($this->localization["Date_Format"], strtotime($data_value["Modified_Date"]));
                $user_data[] = $data_value["Modified_By"] == '' ? 'Not Yet Edited' : $data_value["Modified_By"];
                $user_data[] = $user_status;
                $user_data[] = $action_buttons;

                $data[] = $user_data;
                $serial_id++;
            }
        }
        $user_list_result_output = array(

            "draw"  => intval($_POST["draw"]),
            "recordsTotal" => intval($total_users_data),
            "recordsFiltered" => intval($total_users_filter),
            "data" => $data,
        );

        echo json_encode($user_list_result_output);
    }

    public function BlockUser($user_id){

        $user_data = $this->_query->query('SELECT * FROM users WHERE Subscriber_ID = ? AND User_ID = ?', array(Classes_Session::get('Loggedin_Session'), $user_id));
        $user_data = $user_data->first();
        $user_status = $user_data["Status"] == 'Active' ? 'Block' : 'Active';
         $user_query_user = $this->_query->query('UPDATE users SET Status = "'. $user_status.'" WHERE User_ID = "' . $user_id . '" AND Subscriber_ID ="' . Classes_Session::get("Loggedin_Session").'"' );
         $user_query_login = $this->_query->query('UPDATE logindetail SET Status = "' . $user_status . '" WHERE Login_ID = "' . $user_id . '" AND Subscriber_ID ="' . Classes_Session::get("Loggedin_Session") . '"'); 
    }

    public function DeleteUser($user_id){
        $user_query_user = $this->_query->query('DELETE FROM users WHERE User_ID = "'.$user_id.'" AND Subscriber_ID ="'.Classes_Session::get("Loggedin_Session").'"');
        $user_query_login = $this->_query->query('DELETE FROM logindetail WHERE Login_ID = "' . $user_id . '" AND Subscriber_ID ="' . Classes_Session::get("Loggedin_Session") . '"');
    }
}
