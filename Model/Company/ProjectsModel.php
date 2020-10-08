<?php
class Model_Company_ProjectsModel
{
    public function __construct()
    {
        $this->_query = Classes_Db::getInstance();

        $this->data_manager = new Controller_Company_Default_Datamanagement();
        $this->localization = $this->data_manager->LocalizationData()->first();

        $this->web_data = $this->data_manager->WebData()->first();
        $this->is_login = $this->data_manager->isLogin()->first();
    }



    public function CreateProject($project_id, $upload_reponse_new, $project_name, $project_client, $project_start_date, $project_end_date, $project_rate, $project_rate_type, $project_priority, $project_leader, $project_status, $project_description){
        $project_gen_id = Classes_Generators::AlphaNumeric(12);
        $project_gen_id = strtoupper($project_gen_id);

        $project_data_g = $this->_query->query('SELECT * FROM projects WHERE Subscriber_ID = ? AND Project_ID = ?', array(Classes_Session::get('Loggedin_Session'), $project_id));
        $project_data = $project_data_g->count();
        $project_data_value = $project_data_g->first();

        if ($project_data > 0) {

            $project_file = $project_data_value["Project_File"];

            $upload_reponse_new = $upload_reponse_new != false && $upload_reponse_new != '' ? $upload_reponse_new : $project_file;


            $project_query = $this->_query->query('UPDATE projects SET Project_Name = "' . $project_name . '", Client_ID ="' . $project_client . '", Start_Date ="' . $project_start_date . '", End_Date ="' . $project_end_date . '", Rate ="' . $project_rate. '", Rate_Type ="' . $project_rate_type . '", Priority = "'.$project_priority. '", Leader ="'.$project_leader. '", Status = "'.$project_status.'", Description="'.$project_description. '", Project_File="'.$upload_reponse_new. '", Modified_Date="' . date('Y-m-d') . '", Modified_by="' . $this->is_login["Username"] . '"   WHERE Project_ID = "' . $project_id . '" AND Subscriber_ID ="' . Classes_Session::get("Loggedin_Session") . '"');
            echo json_encode(array("Project Successfully Update", "Update" => "Refresh"));
        } else {

            $project_query = $this->_query->insert('projects', array(
                'Subscriber_ID' => Classes_Session::get('Loggedin_Session'),
                'Project_ID' => $project_gen_id,
                'Project_Name' => $project_name,
                'Client_ID' => $project_client,
                'Start_Date' => $project_start_date,
                'End_Date' => $project_end_date,
                'Rate' => $project_rate,
                'Rate_Type' => $project_rate_type,
                'Priority' => $project_priority,
                'Leader' => $project_leader,
                'Description' => $project_description,
                'Project_File' => $upload_reponse_new,
                'Created_Date' => date("Y-m-d"),
                'Created_By' => $this->is_login["Username"],
                'Status' => $project_status,
            ));
            echo json_encode(array("Project Successfully Created"));
        }

        //var_dump($project_name);
    }


    public function ProjectListView(){
        $data = array();
        $serial_id = 0;

        $search_value = $_POST["search"]["value"];

        $column_order = array('Project_Name', 'Start_Date', 'End_Date', 'Rate', 'Rate_Type', 'Priority', 'Leader', 'Created_Date');
        if ($_POST['order']) {
            $order_by = $column_order[$_POST['order'][0]['column']] . ' ' . $_POST['order']['0']['dir'];
        }

        $query = $this->_query->query("SELECT * FROM projects WHERE Subscriber_ID = ?", array(Classes_Session::get('Loggedin_Session')));
        $total_project_filter = $query->count();

        if ($_POST['length'] != -1) {
            $limit = " " . $_POST['start'] . ", " . $_POST['length'] . " ";
        }

        if (!empty($_POST["search"]["value"])) {
            $sql_project = "SELECT * FROM projects WHERE Subscriber_ID = ? AND (Project_Name LIKE ? OR Start_Date LIKE ? OR End_Date LIKE ? OR Rate LIKE ? OR Rate_Type LIKE ? OR Priority LIKE ? OR Leader LIKE ? OR Created_Date LIKE ?) ORDER BY $order_by LIMIT $limit";
            $data_value = array(Classes_Session::get('Loggedin_Session'), '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%');
            $query_result_c = $this->_query->query($sql_project, $data_value);
        } else {
            $sql_project = "SELECT * FROM projects WHERE Subscriber_ID = ? ORDER BY $order_by LIMIT $limit";
            $query_result_c = $this->_query->query($sql_project, array(Classes_Session::get('Loggedin_Session')));
        }

        $total_project_data = $query_result_c->count();

        $fetching_results = $query_result_c->results();
        $serial_id = 1;
        foreach ($fetching_results as $key => $data_value) {

            $employee_query = $this->_query->query("SELECT * FROM employee WHERE Subscriber_ID = ? AND Employee_ID = ?", array(Classes_Session::get('Loggedin_Session'), $data_value["Leader"]));
            $employee_query_value = $employee_query->first();
            $full_name = $employee_query_value["First_Name"].' '. $employee_query_value["Last_Name"];

            $client_query = $this->_query->query("SELECT * FROM clients WHERE Subscriber_ID = ? AND Client_ID = ?", array(Classes_Session::get('Loggedin_Session'), $data_value["Client_ID"]));
            $client_query_value = $client_query->first();
            $client_company_name = $client_query_value["Company_Name"] ;


            $action_buttons = '<span class="dropdown">
                              <button id="project_actions" type="button" data-toggle="dropdown" aria-haspopup="true"
                              aria-expanded="false" class="btn btn-info dropdown-toggle"><i class="la la-cog"></i></button>
                              <span aria-labelledby="btnSearchDrop2" class="dropdown-menu mt-1 dropdown-menu-right">
                                <a href="#" id="'.$data_value["ID"].'" class="dropdown-item edit_project"><i class="la la-edit"></i> Edit </a>
                                <a href="#" id="'.$data_value["ID"].'" class="dropdown-item delete_project"><i class="la la-trash-o"></i> Delete</a>

                              </span>
                            </span>';


            if ($data_value["Status"] == 'Active') {
                $project_status = '<span class="badge badge-default badge-primary">' . $data_value["Status"] . '</span>';
            } elseif ($data_value["Status"] == 'Complete') {
                $project_status = '<span class="badge badge-default badge-success">' . $data_value["Status"] . '</span>';
            } elseif ($data_value["Status"] == 'Inactive') {
                $project_status = '<span class="badge badge-default badge-danger">' . $data_value["Status"] . '</span>';
            }

            if ($data_value["Priority"] == 'High') {
                $project_priority = '<span class="badge badge-default badge-danger">' . $data_value["Priority"] . '</span>';
            } elseif ($data_value["Priority"] == 'Medium') {
                $project_priority = '<span class="badge badge-default badge-warning">' . $data_value["Priority"] . '</span>';
            } elseif ($data_value["Priority"] == 'Low') {
                $project_priority = '<span class="badge badge-default badge-primary">' . $data_value["Priority"] . '</span>';
            }

            $project_view_link = '<a class="info" style="font-size: 15px" href="' . $this->web_data["Web_Url"] . 'overview?pro_id=' . $data_value["Project_ID"] . '">' . $data_value["Project_Name"] . ' </a> ';

            $project_data = array();
            $project_data[] = $project_view_link;
            $project_data[] = $client_company_name;
            $project_data[] = date($this->localization["Date_Format"], strtotime($data_value["Start_Date"]));
            $project_data[] = date($this->localization["Date_Format"], strtotime($data_value["End_Date"]));
            $project_data[] = $this->localization["Currency_Symbol"].$data_value["Rate"];
            $project_data[] = $data_value["Rate_Type"];
            $project_data[] = $project_priority;
            $project_data[] = $full_name;
            $project_data[] = date($this->localization["Date_Format"], strtotime($data_value["Created_Date"]));
            $project_data[] = $data_value["Created_By"];
            $project_data[] = $data_value["Modified_Date"] == '0000-00-00' ? 'Not Yet Edited' : date($this->localization["Date_Format"], strtotime($data_value["Modified_Date"]));
            $project_data[] = $data_value["Modified_By"] == '' ? 'Not Yet Edited' : $data_value["Modified_By"];
            $project_data[] = $project_status;
            $project_data[] = $action_buttons;

            $data[] = $project_data;
            $serial_id++;
        }

        
        $project_list_result_output = array(

            "draw"  => intval($_POST["draw"]),
            "recordsTotal" => intval($total_project_data),
            "recordsFiltered" => intval($total_project_filter),
            "data" => $data,
        );
        //echo json_encode(array('Project_Data' => $data));
        echo json_encode($project_list_result_output);
    }

    public function ProjectGridView(){
    
        $sql_project = "SELECT * FROM projects WHERE Subscriber_ID = ? ORDER BY ID DESC LIMIT 20";
        $query_result_c = $this->_query->query($sql_project, array(Classes_Session::get('Loggedin_Session')));

        $total_project_data = $query_result_c->count();

        if($total_project_data > 0){
            $fetching_results = $query_result_c->results();

            $project_grid_view ='';

            foreach ($fetching_results as $key => $data_value) {

                $employee_query = $this->_query->query("SELECT * FROM employee WHERE Subscriber_ID = ? AND Employee_ID = ?", array(Classes_Session::get('Loggedin_Session'), $data_value["Leader"]));
                $employee_query_value = $employee_query->first();
                $full_name = $employee_query_value["First_Name"] . ' ' . $employee_query_value["Last_Name"];

                $client_query = $this->_query->query("SELECT * FROM clients WHERE Subscriber_ID = ? AND Client_ID = ?", array(Classes_Session::get('Loggedin_Session'), $data_value["Client_ID"]));
                $client_query_value = $client_query->first();
                $client_company_name = $client_query_value["Company_Name"];


                if ($data_value["Status"] == 'Active') {
                $project_status = '<span class="badge badge-default badge-primary">' . $data_value["Status"] . '</span>';
                } elseif ($data_value["Status"] == 'Complete') {
                    $project_status = '<span class="badge badge-default badge-success">' . $data_value["Status"] . '</span>';
                } elseif ($data_value["Status"] == 'Inactive') {
                    $project_status = '<span class="badge badge-default badge-danger">' . $data_value["Status"] . '</span>';
                }

                if ($data_value["Priority"] == 'High') {
                    $project_priority = '<span class="badge badge-default badge-danger">' . $data_value["Priority"] . '</span>';
                } elseif ($data_value["Priority"] == 'Medium') {
                    $project_priority = '<span class="badge badge-default badge-warning">' . $data_value["Priority"] . '</span>';
                } elseif ($data_value["Priority"] == 'Low') {
                    $project_priority = '<span class="badge badge-default badge-primary">' . $data_value["Priority"] . '</span>';
                }

                $project_description = strlen($data_value["Description"]) > 200 ? substr($data_value["Description"], 0, 200).'...' : $data_value["Description"];

                $project_view_link = '<a class="info" style="font-size: 15px" href="' . $this->web_data["Web_Url"] . 'overview?pro_id=' . $data_value["Project_ID"] . '">' . $data_value["Project_Name"] . ' </a> ';


                $project_grid_view.= '
                        <div class="col-lg-4 col-sm-6 col-md-4 col-xl-3">
                            <div class="card">
                                <div class="card-header" style="border-bottom: double; padding:1rem 1rem">
                                    <h4 class="card-title"><b>'. $project_view_link. '</b></h4>
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <div class="dropdown dropdown-action profile-action">
                                                <a href="#" class="action-icon dropdown-toggles" data-toggle="dropdown" aria-expanded="false"><i class="la la-ellipsis-v"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(24px, 32px, 0px);">
                                                    <a class="dropdown-item edit_project" href="#" data-toggle="modal" id="'.$data_value["ID"].'"><i class="la la-pencil m-r-5"></i> Edit</a>
                                                    <a class="dropdown-item delete_project" href="#" data-toggle="modal" id="'.$data_value["ID"].'"><i class="la la-trash-o m-r-5"></i> Delete</a>
                                                </div>
                                            </div>
                                        </ul>
                                    </div>

                                    <br/>
                                    <h6 class="block text-ellipsis m-b-15">
                                        <span class="text-xs">Status:</span> <span class="text-muted">' . $project_status . '</span> 
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<span class="text-xs">Priority:</span> <span class="text-muted">' . $project_priority . '</span>
									</h6>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                            '. $project_description.'
                                            <div class="pro-deadline m-b-15">
                                                <div class="sub-title">
                                                    <b>Deadline:</b>
                                                </div>
                                                <div class="text-muteds">
                                                    <b>' . date($this->localization["Date_Format"], strtotime($data_value["End_Date"])). '</b>
                                                </div>
                                            </div>

                                            <div class="project-members m-b-15"><br/>
                                                <div><b>Project Leader :</b></div>
                                                <ul class="team-members">
                                                        <b>' . $full_name . '</b>
                                                </ul>
                                            </div>


                                    </div>
                                </div>
                            </div>
                        </div>';
                //var_dump($fetching_results);
            }
            
        }
        echo json_encode($project_grid_view);
    }


    public function DeleteProject($project_id){
        $delete_project = $this->_query->query('DELETE FROM projects WHERE ID = "'.$project_id.'" AND Subscriber_ID ="'.Classes_Session::get("Loggedin_Session").'"');
        echo json_encode("Deleted");
    }
}