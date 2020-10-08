<?php


class Model_Company_AccountsModel
{
    public function __construct()
    {
        $this->_query = Classes_Db::getInstance();
        $this->account_mail = new Controller_Mail_AccountsMail;
        $this->data_manager = new Controller_Company_Default_Datamanagement();

        $this->localization = $this->data_manager->LocalizationData()->first();
        $this->is_login = $this->data_manager->isLogin()->first();
    }


    public function CreateInvoice($invoice_id, $client_id, $client_project, $client_email, $client_address, $invoice_date, $invoice_due_date, $other_desc, $invoice_discount, $final_total, $item_id, $item_name, $description, $cost, $quantity, $amount, $save_type){

        if (empty($invoice_id)) {
        $invoice_gen_id = Classes_Generators::AlphaNumeric(9);
        $invoice_gen_id = strtoupper($invoice_gen_id);
        } else {
            $invoice_gen_id = $invoice_id;
        }


            foreach ($item_name as $key => $value) {
                $item_names = $item_name[$key];
                $descriptions = $description[$key];
                $costs = $cost[$key];
                $quantitys = $quantity[$key];
                $amounts = $amount[$key];
                $item_ids = $item_id[$key];

                $data_item_name = $this->data->InvoiceItemDataByName($item_names)->first();
                
            
                if(empty($item_ids) && $data_item_name["Item_Name"] != $item_names){
                
                    $invoice_item_query = $this->_query->insert('invoice_items', array(
                    'Subscriber_ID' => Classes_Session::get('Loggedin_Session'),
                    'Invoice_ID' => $invoice_gen_id,
                    'Item_Name' => $item_names,
                    'Description' => $descriptions,
                    'Cost' => $costs,
                    'Quantity' => $quantitys,
                    'Amount' => $amounts,
                    'Created_Date' => date("Y-m-d"),
                    'Created_By' => $this->is_login["Username"],
                    'Status' => 'Active'
                    ));

                } else {
                    
                    //var_dump($item_names);
                $invoice_item_query = $this->_query->query('UPDATE invoice_items SET Item_Name = "' . $item_names . '", Description ="' . $descriptions . '", Cost ="' . $costs . '", Quantity ="' . $quantitys . '", Amount ="' . $amounts . '", Modified_Date="' . date('Y-m-d') . '", Modified_by="' . $this->is_login["Username"] . '"  WHERE ID = "' . $item_ids . '" AND Subscriber_ID ="' . Classes_Session::get("Loggedin_Session") . '"');

                }
                

            }


        if (empty($invoice_id)) {

            $invoice_query = $this->_query->insert('invoice', array(
                'Subscriber_ID' => Classes_Session::get('Loggedin_Session'),
                'Invoice_ID' => $invoice_gen_id,
                'Client_ID' => $client_id,
                'Project_ID' => $client_project,
                'Client_Email' => $client_email,
                'Client_Address' => $client_address,
                'Invoice_Date' => $invoice_date,
                'Invoice_Due_Date' => $invoice_due_date,
                'Other_Description' => $other_desc,
                'Invoice_Discount' => $invoice_discount,
                'Total' => $final_total,
                'Created_Date' => date("Y-m-d"),
                'Created_By' => $this->is_login["Username"],
                'Status' => 'Active'
            ));
        
                if (!$invoice_query) {
                    echo json_encode(array("Invoice Successfully Created", "Invoide_ID" => $invoice_gen_id));
                }

            } else {
             $invoice_item_query = $this->_query->query('UPDATE invoice SET Client_ID = "' . $client_id . '", Project_ID ="' . $client_project . '", Client_Email ="' . $client_email . '", Client_Address ="' . $client_address . '", Invoice_Date ="' . $invoice_date . '", Invoice_Due_Date ="'.$invoice_due_date. '", Other_Description="'.$other_desc. '", Invoice_Discount="'.$invoice_discount. '", Total="'.$final_total. '", Modified_Date="' . date('Y-m-d') . '", Modified_by="' . $this->is_login["Username"] . '"  WHERE Invoice_ID = "' . $invoice_id . '" AND Subscriber_ID ="' . Classes_Session::get("Loggedin_Session") . '"');
                echo json_encode(array("Invoice Successfully Updated", "Invoide_ID" => ''));
            }
        

    }


    public function LoadCreatedInvoice(){
  
        $data = array();
        $serial_id = 0;

        $search_value = $_POST["search"]["value"];


        $column_order = array('Invoice_Date', 'Invoice_Due_Date', 'Created_Date', 'Total', 'Status');
        if ($_POST['order']) {
            $order_by = $column_order[$_POST['order'][0]['column']] . ' ' . $_POST['order']['0']['dir'];
        }


        $query = $this->_query->query("SELECT * FROM invoice WHERE Subscriber_ID = ?", array(Classes_Session::get("Loggedin_Session")));
        $total_invoice_filter = $query->count();

        if ($_POST['length'] != -1) {
            $limit = " " . $_POST['start'] . ", " . $_POST['length'] . " ";
        }

        if (!empty($_POST["search"]["value"])) {
            $sql_invoice = "SELECT * FROM invoice WHERE Subscriber_ID = ? AND (Invoice_Date LIKE ? OR Invoice_Due_Date LIKE ? OR Created_Date LIKE ? OR Total LIKE ? OR Status LIKE ?) ORDER BY $order_by LIMIT $limit";
            $data_value = array(Classes_Session::get("Loggedin_Session"), '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%');
            $query_result_c = $this->_query->query($sql_invoice, $data_value);
            //$sql_package = "SELECT * FROM package_plan ORDER BY $orders $key LIMIT $limit";
        } else {
            $sql_invoice = "SELECT * FROM invoice WHERE Subscriber_ID = ? ORDER BY ID DESC LIMIT $limit";
            $query_result_c = $this->_query->query($sql_invoice, array(Classes_Session::get("Loggedin_Session")));
        }



        $total_invoice_data = $query_result_c->count();


        $fetching_results = $query_result_c->results();
        $serial_id = 1;
        
        foreach ($fetching_results as $key => $data_value) {

            $client_datas_by_id = $this->data_manager->ClientDataByID($data_value["Client_ID"])->first();
            

            $action_buttons = '<span class="dropdown">
                              <button id="invoice_actions" type="button" data-toggle="dropdown" aria-haspopup="true"
                              aria-expanded="false" class="btn btn-info dropdown-toggle"><i class="la la-cog"></i></button>
                              <span aria-labelledby="btnSearchDrop2" class="dropdown-menu mt-1 dropdown-menu-right">
                                <a href="edit-invoice?invoice_id=' . $data_value["Invoice_ID"] . '" class="dropdown-item"><i class="la la-edit"></i> Edit </a>
                                <a href="#" id="' . $data_value["Invoice_ID"] . '" class="dropdown-item delete_invoice"><i class="la la-trash-o"></i> Delete</a>

                              </span>
                            </span>';

            //$access_permission = '<span class="badge badge-default badge-primary">' . $data_value["Role"] . '</span>';

            if ($data_value["Status"] == 'Accepted') {
                $invoice_status = '<span class="badge badge-default badge-success">' . $data_value["Status"] . '</span>';
            } elseif ($data_value["Status"] == 'Sent') {
                $invoice_status = '<span class="badge badge-default badge-info">' . $data_value["Status"] . '</span>';
            } elseif ($data_value["Status"] == 'Expire') {
                $invoice_status = '<span class="badge badge-default badge-warning">' . $data_value["Status"] . '</span>';
            } elseif ($data_value["Status"] == 'Decline') {
                $invoice_status = '<span class="badge badge-default badge-danger">' . $data_value["Status"] . '</span>';
            } elseif ($data_value["Status"] == 'Active') {
                $invoice_status = '<span class="badge badge-default badge-secondary">' . $data_value["Status"] . '</span>';
            }

            $invoice_view = '<a href="view-invoice?invoice_id='. $data_value["Invoice_ID"].'" class="text-bold-600">#INV-'. $data_value["Invoice_ID"].'</a>';
            $invoice_data = array();
            $invoice_data[] = $invoice_view;
            $invoice_data[] = $client_datas_by_id["Company_Name"];
            $invoice_data[] = date($this->localization["Date_Format"], strtotime($data_value["Invoice_Date"]));
            $invoice_data[] = date($this->localization["Date_Format"], strtotime($data_value["Invoice_Due_Date"]));
            //$invoice_data[] = date($this->localization["Date_Format"], strtotime($data_value["Created_Date"]));
            $invoice_data[] = $this->localization["Currency_Symbol"] . number_format($data_value["Total"], 2);
            $invoice_data[] = date($this->localization["Date_Format"], strtotime($data_value["Created_Date"]));
            $invoice_data[] = $data_value["Created_By"];
            $invoice_data[] = $data_value["Modified_Date"] == '0000-00-00' ? 'Not Yet Edited' : date($this->localization["Date_Format"], strtotime($data_value["Modified_Date"]));
            $invoice_data[] = $data_value["Modified_By"] == '' ? 'Not Yet Edited' : $data_value["Modified_By"];
            $invoice_data[] = $invoice_status;


            $invoice_data[] = $action_buttons;

            $data[] = $invoice_data;
            $serial_id++;
        }


        $invoice_list_result_output = array(

            "draw"  => intval($_POST["draw"]),
            "recordsTotal" => intval($total_invoice_data),
            "recordsFiltered" => intval($total_invoice_filter),
            "data" => $data,
        );

        echo json_encode($invoice_list_result_output);
    
    }


    public function LoadProjectByClient($client_id){

        $client_project_query_result = $this->_query->query('SELECT * FROM projects WHERE Subscriber_ID = ? AND Client_ID = ?', array(Classes_Session::get("Loggedin_Session"), $client_id));
        $output_result_display = '';

        $fetching_results = $client_project_query_result->results();
        foreach ($fetching_results as $key => $fetching_result_value) {
            $output_result_display.= '<option value="' . $fetching_result_value["Project_ID"] . '">' . $fetching_result_value["Project_Name"] . '</option>';
        }

        $_query_result = $this->_query->query('SELECT * FROM clients WHERE Subscriber_ID = ? AND Client_ID = ?', array(Classes_Session::get("Loggedin_Session"), $client_id));
        $result = $_query_result->first(); 

        echo json_encode(array("Output_Result" => $output_result_display, "Client_Email" => $result["Email"], "Client_Address" => $result["Address"]));
       
        
    }


    public function MailInvoice($invoice_id){
        $this->account_mail->InvoiceMail($invoice_id);
    }


    public function DownloadInvoice($invoice_id)
    {
        $response = $this->account_mail->InvoiceDownload($invoice_id);
    }


    public function DeleteInvoice($invoice_id){
        $invoice_query_user = $this->_query->query('DELETE FROM invoice WHERE Invoice_ID = "' . $invoice_id . '" AND Subscriber_ID ="' . Classes_Session::get("Loggedin_Session") . '"');
        $invoice_item_query_user = $this->_query->query('DELETE FROM invoice_items WHERE Invoice_ID = "'.$invoice_id.'" AND Subscriber_ID ="'.Classes_Session::get("Loggedin_Session") . '"');

        echo json_encode("Deleted");
    }

    public function RemoveInvoiceItem($invoice_id)
    {
        $invoice_item_query_user = $this->_query->query('DELETE FROM invoice_items WHERE ID = "' . $invoice_id . '" AND Subscriber_ID ="' . Classes_Session::get("Loggedin_Session") . '"');
        echo json_encode("Delete_Row");
    }
    
}
