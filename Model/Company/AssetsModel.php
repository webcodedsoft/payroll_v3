<?php


class Model_Company_AssetsModel
{
    public function __construct()
    {
        $this->_query = Classes_Db::getInstance();
        $this->data_manager = new Controller_Company_Default_Datamanagement();
        $this->localization = $this->data_manager->LocalizationData()->first();
        $this->is_login = $this->data_manager->isLogin()->first();

    }


    public function AddAsset($asset_id, $asset_name, $purchase_date, $purchase_from, $manufacturer, $model, $serial_number, $supplier, $condition, $warranty, $amount, $description, $status)
    {
        $asset_gen_id = Classes_Generators::AlphaNumeric(5);
        $asset_gen_id = strtoupper($asset_gen_id);

        $asset_data_g = $this->_query->query('SELECT * FROM assets WHERE Subscriber_ID = ? AND ID = ?', array(Classes_Session::get('Loggedin_Session'), $asset_id));
        $asset_data = $asset_data_g->count();
        $user_data_value = $asset_data_g->first();

        if ($asset_data > 0) {

            $asset_query = $this->_query->query('UPDATE assets SET Asset_Name = "' . $asset_name . '", Purchase_Date ="' . $purchase_date . '", Purchase_From ="' . $purchase_from . '", Manufacturer ="' . $manufacturer . '", Model ="' . $model . '", Serial_Number ="' . $serial_number . '", Supplier ="'. $supplier. '", Conditions="'. $condition. '", Warranty="'. $warranty. '", Amount="'. $amount. '", Description="'. $description.'", Status="'.$status. '", Modified_Date="' . date('Y-m-d') . '", Modified_by="' . $this->is_login["Username"] . '"  WHERE ID = "' . $asset_id . '" AND Subscriber_ID ="' . Classes_Session::get("Loggedin_Session") . '"');
            echo json_encode(array("Asset Successfully Update", "Update" => "Refresh"));

        } else {
 
            $asset_query = $this->_query->insert('assets', array(
                'Subscriber_ID' => Classes_Session::get('Loggedin_Session'),
                'Asset_ID' => $asset_gen_id,
                'Asset_Name' => $asset_name,
                'Purchase_Date' => $purchase_date,
                'Purchase_From' => $purchase_from,
                'Manufacturer' => $manufacturer,
                'Model' => $model,
                'Serial_Number' => $serial_number,
                'Supplier' => $supplier,
                'Conditions' => $condition,
                'Warranty' => $warranty,
                'Amount' => $amount,
                'Description' => $description,
                'Created_Date' => date("Y-m-d"),
                'Created_By' => $this->is_login["Username"],
                'Status' => $status
            ));
            echo json_encode(array("Asset Successfully Created"));


        }
    }


    public function LoadAssets(){
        $data = array();
        $serial_id = 0;

        $search_value = $_POST["search"]["value"];

        $column_order = array('Asset_Name', 'Purchase_Date', 'Purchase_From', 'Manufacturer', 'Model', 'Serial_Number', 'Supplier', 'Conditions', 'Warranty', 'Status');
        if ($_POST['order']) {
            $order_by = $column_order[$_POST['order'][0]['column']] . ' ' . $_POST['order']['0']['dir'];
        }


        $query = $this->_query->query("SELECT * FROM assets WHERE Subscriber_ID = ?", array(Classes_Session::get("Loggedin_Session")));
        $total_asset_filter = $query->count();

        if ($_POST['length'] != -1) {
            $limit = " " . $_POST['start'] . ", " . $_POST['length'] . " ";
        }

        if (!empty($_POST["search"]["value"])) {
            $sql_asset = "SELECT * FROM assets WHERE Subscriber_ID = ? AND (Asset_Name LIKE ? OR Purchase_Date LIKE ? OR Purchase_From LIKE ? OR Manufacturer LIKE ? OR Model LIKE ? OR Serial_Number LIKE ? OR Supplier LIKE ? OR Conditions LIKE ? OR Warranty LIKE ? OR Status LIKE ?) ORDER BY $order_by LIMIT $limit";
            $data_value = array(Classes_Session::get("Loggedin_Session"), '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%');
            $query_result_c = $this->_query->query($sql_asset, $data_value);
        } else {
            $sql_asset = "SELECT * FROM assets WHERE Subscriber_ID = ? ORDER BY $order_by LIMIT $limit";
            $query_result_c = $this->_query->query($sql_asset, array(Classes_Session::get("Loggedin_Session")));
        }




        $total_asset_data = $query_result_c->count();


        $fetching_results = $query_result_c->results();
        $serial_id = 1;
        foreach ($fetching_results as $key => $data_value) {


            $action_buttons = '<span class="dropdown">
                              <button id="user_actions" type="button" data-toggle="dropdown" aria-haspopup="true"
                              aria-expanded="false" class="btn btn-info dropdown-toggle"><i class="la la-cog"></i></button>
                              <span aria-labelledby="btnSearchDrop2" class="dropdown-menu mt-1 dropdown-menu-right">
                                <a href="#" id="'.$data_value["ID"]. '" class="dropdown-item edit_asset"><i class="la la-edit"></i> Edit </a>
                                <a href="#" id="' . $data_value["Asset_ID"] . '" class="dropdown-item delete_asset"><i class="la la-trash-o"></i> Delete</a>

                              </span>
                            </span>';

            $access_permission = '<span class="badge badge-default badge-primary">' . $data_value["Role"] . '</span>';

            if ($data_value["Status"] == 'Approve') {
                $asset_status = '<span class="badge badge-default badge-success">' . $data_value["Status"] . '</span>';
            } elseif ($data_value["Status"] == 'Pending') {
                $asset_status = '<span class="badge badge-default badge-info">' . $data_value["Status"] . '</span>';
            } elseif ($data_value["Status"] == 'Deployed') {
                $asset_status = '<span class="badge badge-default badge-primary">' . $data_value["Status"] . '</span>';
            } elseif ($data_value["Status"] == 'Damaged') {
                $asset_status = '<span class="badge badge-default badge-danger">' . $data_value["Status"] . '</span>';
            }

            $asset_data = array();
            $asset_data[] = $data_value["Asset_Name"];
            $asset_data[] = date($this->localization["Date_Format"], strtotime($data_value["Purchase_Date"])); 
            $asset_data[] = $data_value["Purchase_From"];
            $asset_data[] = $data_value["Manufacturer"];
            $asset_data[] = $data_value["Model"];
            $asset_data[] = $data_value["Serial_Number"];
            $asset_data[] = $data_value["Supplier"];
            $asset_data[] = $data_value["Conditions"];
            $asset_data[] = $data_value["Warranty"];
            $asset_data[] = $this->localization["Currency_Symbol"].$data_value["Amount"];
            $asset_data[] = date($this->localization["Date_Format"], strtotime($data_value["Created_Date"]));
            // $asset_data[] = $data_value["Created_By"];
            // $asset_data[] = $data_value["Modified_Date"] == '0000-00-00' ? 'Not Yet Edited' : date($this->localization["Date_Format"], strtotime($data_value["Modified_Date"]));
            // $asset_data[] = $data_value["Modified_By"] == '' ? 'Not Yet Edited' : $data_value["Modified_By"];
            $asset_data[] = $asset_status;
            $asset_data[] = $action_buttons;

            $data[] = $asset_data;
            $serial_id++;
        }


        $asset_list_result_output = array(

            "draw"  => intval($_POST["draw"]),
            "recordsTotal" => intval($total_asset_data),
            "recordsFiltered" => intval($total_asset_filter),
            "data" => $data,
        );

        echo json_encode($asset_list_result_output);
    }


    public function DeleteAssets($asset_id){
        $asset_query_user = $this->_query->query('DELETE FROM assets WHERE Asset_ID = "'. $asset_id.'" AND Subscriber_ID ="'.Classes_Session::get("Loggedin_Session").'"');
    }
}
