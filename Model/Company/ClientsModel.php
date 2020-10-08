<?php


class Model_Company_ClientsModel
{
    public function __construct()
    {
        $this->_query = Classes_Db::getInstance();
        $this->data_manager = new Controller_Company_Default_Datamanagement();
        $this->localization = $this->data_manager->LocalizationData()->first();
        $this->is_login = $this->data_manager->isLogin()->first();
    }


    public function AddClient($client_id, $company_name, $contact_person, $address, $email, $phone_number, $status)
    {
        $client_gen_id = Classes_Generators::AlphaNumeric(15);
        $client_gen_id = strtoupper($client_gen_id);

        $client_data_g = $this->_query->query('SELECT * FROM clients WHERE Subscriber_ID = ? AND ID = ?', array(Classes_Session::get('Loggedin_Session'), $client_id));
        $client_data = $client_data_g->count();
        $client_data_value = $client_data_g->first();

        if ($client_data > 0) {

            $client_query = $this->_query->query('UPDATE clients SET Company_Name = "' . $company_name . '", Contact_Person ="' . $contact_person . '", Address ="' . $address . '", Email ="' . $email . '", Phone_Number ="' . $phone_number . '", Status ="' . $status . '", Modified_Date="' . date('Y-m-d') . '", Modified_by="' . $this->is_login["Username"] . '" WHERE ID = "' . $client_id . '" AND Subscriber_ID ="' . Classes_Session::get("Loggedin_Session") . '"');
            echo json_encode(array("Client Successfully Update", "Update" => "Refresh"));
        } else {

            $client_query = $this->_query->insert('clients', array(
                'Subscriber_ID' => Classes_Session::get('Loggedin_Session'),
                'Client_ID' => $client_gen_id,
                'Company_Name' => $company_name,
                'Contact_Person' => $contact_person,
                'Address' => $address,
                'Email' => $email,
                'Phone_Number' => $phone_number,
                'Created_Date' => date("Y-m-d"),
                'Created_By' => $this->is_login["Username"],
                'Status' => $status
            ));
            echo json_encode(array("Client Successfully Created"));
        }
    }


    public function LoadClients()
    {
        $data = array();
        $serial_id = 0;

        $search_value = $_POST["search"]["value"];

        $column_order = array('Company_Name', 'Contact_Person', 'Address', 'Email', 'Phone_Number', 'Status');
        if ($_POST['order']) {
            $order_by = $column_order[$_POST['order'][0]['column']] . ' ' . $_POST['order']['0']['dir'];
        }

        $query = $this->_query->query("SELECT * FROM clients WHERE Subscriber_ID = ?", array(Classes_Session::get("Loggedin_Session")));
        $total_client_filter = $query->count();

        if ($_POST['length'] != -1) {
            $limit = " " . $_POST['start'] . ", " . $_POST['length'] . " ";
        }

        if (!empty($_POST["search"]["value"])) {
            $sql_client = "SELECT * FROM clients WHERE Subscriber_ID = ? AND (Company_Name LIKE ? OR Contact_Person LIKE ? OR Address LIKE ? OR Email LIKE ? OR Phone_Number LIKE ? OR Status LIKE ?) ORDER BY $order_by LIMIT $limit";
            $data_value = array(Classes_Session::get("Loggedin_Session"), '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%');
            $query_result_c = $this->_query->query($sql_client, $data_value);
        } else {
            $sql_client = "SELECT * FROM clients WHERE Subscriber_ID = ? ORDER BY $order_by LIMIT $limit";
            $query_result_c = $this->_query->query($sql_client, array(Classes_Session::get("Loggedin_Session")));
        }


        $total_client_data = $query_result_c->count();


        $fetching_results = $query_result_c->results();
        $serial_id = 1;
        foreach ($fetching_results as $key => $data_value) {


            $action_buttons = '<span class="dropdown">
                              <button id="client_actions" type="button" data-toggle="dropdown" aria-haspopup="true"
                              aria-expanded="false" class="btn btn-info dropdown-toggle"><i class="la la-cog"></i></button>
                              <span aria-labelledby="btnSearchDrop2" class="dropdown-menu mt-1 dropdown-menu-right">
                                <a href="#" id="' . $data_value["ID"] . '" class="dropdown-item edit_client"><i class="la la-edit"></i> Edit </a>
                                <a href="#" id="' . $data_value["Client_ID"] . '" class="dropdown-item delete_client"><i class="la la-trash-o"></i> Delete</a>

                              </span>
                            </span>';


            if ($data_value["Status"] == 'Active') {
                $client_status = '<span class="badge badge-default badge-success">' . $data_value["Status"] . '</span>';
            } elseif ($data_value["Status"] == 'Disabled') {
                $client_status = '<span class="badge badge-default badge-danger">' . $data_value["Status"] . '</span>';
            }

            $client_data = array();
            $client_data[] = $data_value["Company_Name"];
            $client_data[] = $data_value["Contact_Person"];
            $client_data[] = $data_value["Address"];
            $client_data[] = $data_value["Email"];
            $client_data[] = $data_value["Phone_Number"];
            $client_data[] = date($this->localization["Date_Format"], strtotime($data_value["Created_Date"]));
            $client_data[] = $data_value["Created_By"];
            $client_data[] = $data_value["Modified_Date"] == '0000-00-00' ? 'Not Yet Edited' : date($this->localization["Date_Format"], strtotime($data_value["Modified_Date"]));
            $client_data[] = $data_value["Modified_By"] == '' ? 'Not Yet Edited' : $data_value["Modified_By"];
            $client_data[] = $client_status;
            $client_data[] = $action_buttons;

            $data[] = $client_data;
            $serial_id++;
        }


        $client_list_result_output = array(

            "draw"  => intval($_POST["draw"]),
            "recordsTotal" => intval($total_client_data),
            "recordsFiltered" => intval($total_client_filter),
            "data" => $data,
        );

        echo json_encode($client_list_result_output);
    }


    public function DeleteClients($client_id)
    {
        $client_query_user = $this->_query->query('DELETE FROM clients WHERE Client_ID = "' . $client_id . '" AND Subscriber_ID ="' . Classes_Session::get("Loggedin_Session") . '"');
    }
}
