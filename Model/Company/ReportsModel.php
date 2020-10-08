<?php

class Model_Company_ReportsModel{

    public function __construct()
    {
        $this->_query = Classes_Db::getInstance();
        $this->data_manager = new Controller_Company_Default_Datamanagement();
        $this->payment_proof_mail = new Controller_Mail_PaymentProofMail();
        $this->leave_report_mail = new Controller_Mail_LeaveReportMail();
        $this->salary_letter_mail = new Controller_Mail_SalaryLetterMail();
        $this->journal_mail = new Controller_Mail_JournalReportMail();
        $this->localization = $this->data_manager->LocalizationData()->first();
        $this->is_login = $this->data_manager->isLogin()->first();
        $this->web_data = $this->data_manager->WebData()->first();
        $this->theme_data = $this->data_manager->ThemeData()->first();
        $this->company_data =  $this->data_manager->CompanyDataByID()->first();
    }



    public function LoadDateRangeByEmployee($employee_id_payment_proof)
    {
        $query_results =  $this->data_manager->EarningDateData($employee_id_payment_proof)->results();
        var_dump($query_results);
        foreach ($query_results as $key => $query_result) {
            if (!empty($query_result["Dates"] && !empty($query_result["End_Date"])))
                echo "<option value=" . $query_result["Dates"] . ">" . $query_result["Dates"] . " - " . $query_result["End_Date"] . "</option>";
        }
    }


    public function LoadPaymentProof($employee_id_payment_proof, $earning_date_range_payment_proof){

        $employee_payment_proof_record_view='';


        $employee_data_values = $this->data_manager->EmployeesDataByID($employee_id_payment_proof)->first();
        $currency_results = $this->data_manager->CurrencyDataByID($employee_data_values["Currency"])->first();
        $marital_results = $this->data_manager->MaritalDataByID($employee_data_values["Marital"])->first();
        $family_tax_results = $this->data_manager->FamilyTaxDataByID($employee_data_values["Kids"])->first();
        $social_results = $this->data_manager->SocialSecurityDataByID($employee_data_values["Social_Security"])->first();
        $association_tax_results = $this->data_manager->AssociationDataByID($employee_data_values["Association"])->first();


        $first_name = $employee_data_values["First_Name"];
        $last_name = $employee_data_values["Last_Name"];

        $employee_input_id = $employee_data_values["Emp_ID"];
        $payment_type = $employee_data_values["Payment_Type"];
        $marital_amount = $marital_results['Married_Amount'];
        $kid_amount = $family_tax_results['Kid_Amount'];
        $salary = $employee_data_values['Salary'];
        $address = $employee_data_values['Address'];
        $account_number = $employee_data_values['Account_Number'];

        $currency_type = $currency_results["Currency_Type"];
        $currency_symbol = $currency_results["Currency_Symbol"];
        $currency_code = $currency_results["Currency_Code"];

        $format_view='';

        $earning_result = $this->_query->query("SELECT * FROM earning WHERE Employee_ID = ? AND Dates = ? ORDER BY ID DESC LIMIT 1", array($employee_id_payment_proof, $earning_date_range_payment_proof))->first();
        $end_date = $earning_result["End_Date"];
        $earning_id = $earning_result["ID"];

        $payment_type_view = $payment_type == 30 ? "Monthly" : $payment_type == 15 ? "Semi-Monthly" : "Weekly";


        $employee_payment_proof_record_view.= '
            <div class="printableArea">
                <section class="card">
                    <div id="invoice-template" class="card-body">
                        <!-- Invoice Company Details -->
                        <div id="invoice-company-details" class="row">
                            <div class="col-md-6 col-sm-12 text-center text-md-left">
                                <div class="media">
                                    <img style="width: 120px; height: 100px" src="'.$this->web_data["Web_Url"].'Folders/Company_Folders/'.Classes_Session::get('Loggedin_Session').'/Logo/'.$this->theme_data["Logo"]. '" alt="" class="" />
                                    <div class="media-body">
                                        <ul class="ml-2 px-0 list-unstyled">
                                            <li class="text-bold-800">'.$this->company_data["Company_Name"]. '</li>
                                            <li>'.wordwrap($this->company_data["Company_Address"], 35, "<br/>", false). '</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 text-center text-md-right">
                                <h2><em>Employee ID:</em> <b>' . $employee_input_id . '</b></h2>
                            </div>

                        </div>
                        <!--/ Invoice Company Details -->
                        <!-- Invoice Customer Details -->
                        <div id="invoice-customer-details" class="row pt-2">
                            <div class="col-sm-12 text-center text-md-left">
                                <p class="text-bold-800">Employee Name: '. $first_name.' '.$last_name. '</p>
                                <p class="text-bold-800">Employee ID: ' . $employee_input_id . '</p>
                                <p class="text-bold-800">Designation: ' . wordwrap($address, 35, "<br/>", false) . '</p>
                            </div>
                        </div>
                        <!--/ Invoice Customer Details -->
                        <!-- Invoice Items Details -->

                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                <div id="invoice-items-details" class="pt-2">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <h4><b>Payment Type: ' . $payment_type_view . '</b></h4>
                                        </div>

                                        <div class="col-md-4">
                                            <h4><b>' . $currency_type . ' (' . $currency_symbol . ' - ' . $currency_code . ')</b></h4>
                                        </div>
                    
                                        <div class="col-md-4">
                                            <h4><b>Date: ' . date($this->localization["Date_Format"], strtotime($earning_date_range_payment_proof))  . ' - ' . date($this->localization["Date_Format"], strtotime($end_date)) . '</b></h4>
                                        </div>

                                        <div class="table-responsive col-sm-12">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Earnings</th>
                                                        <th>Quantity</th>
                                                        <th>Amount</th>
                                                        <th>Deductions</th>
                                                        <th>Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>';
                                                
                                                $exchange_rate = $earning_result["Exchange_Rate"];
                                                $bonus = $earning_result["Bonus"];
                                                $comission = $earning_result["Comission"];
                                                $allowance = $earning_result["Allowance"];
                                                $otherearning = $earning_result["Other_Earning"];
                                                $extra1 = $earning_result["Extra_Hour1"];
                                                $extra2 = $earning_result["Extra_Hour2"];
                                                $ordinary = $earning_result["Ordinary"];
                                                $payment_type = $earning_result["Payment_Type"];
                                                $gross_salary = $earning_result["Gross_Salary"];

                                                $loan = $earning_result["Loan"];
                                                $assessment = $earning_result["Assessment"];
                                                $other_deduction = $earning_result["Other_Deduction"];
                                                $tax = $earning_result["Tax"];
                                                $total_deduction = $earning_result["Total_Deduction"];

                                                $net_pay = $earning_result["Net_Pay"];
                                                $basic_salary = $earning_result["Basic_Salary"];

                                                /*Checking the employee payment type*/
                                                $ordinary = abs($ordinary);

                                                /*Calculating extra hours*/
                                                $extra_hour_cal = Classes_Calculator::ExtraHourCal($payment_type, $extra1, $extra2, $exchange_rate, $salary, $basic_salary, $ordinary);
                                                $extra1_total = $extra_hour_cal["Total_Extra_Hour1"];
                                                $extra2_total = $extra_hour_cal["Total_Extra_Hour2"];
                                                $total_ordinary = $extra_hour_cal["Total_Ordinary"];
                                                /*Ending of calculating extra hours*/

                                                //Deduction
                                                $social_rate = $social_results['Rate'];
                                                $association_rate = $association_tax_results['Association_Rate'];

                                                $total_social_security = $gross_salary * $social_rate / 100;
                                                $total_association = $gross_salary * $association_rate / 100;


                                                    $employee_payment_proof_record_view.= '
                                                        <tr>
                                                            <td>Basic Salary</td>
                                                            <td>-----</td>
                                                            <td class="text-right">' . $currency_symbol . ' ' . number_format($basic_salary, 2) . '</td>
                                                            <td>Social Security ' . $social_rate . '%</td>
                                                            <td class="text-right">' . $currency_symbol . ' ' . number_format($total_social_security, 2) . '</td>
                                                            </tr>

                                                            <tr>
                                                            <td>Extra Hours 1.5</td>
                                                            <td>' . $extra1 . '</td>
                                                            <td class="text-right">' . $currency_symbol . ' ' . number_format($extra1_total, 2) . '</td>
                                                            <td>Salary Tax</td>
                                                            <td class="text-right">' . $currency_symbol . ' ' . number_format($tax, 2) . '</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Extra Hours 2.0</td>
                                                            <td>' . $extra2 . '</td>
                                                            <td class="text-right">' . $currency_symbol . ' ' . number_format($extra2_total, 2) . '</td>
                                                            <td>Loan</td>
                                                            <td class="text-right">' . $currency_symbol . ' ' . number_format($loan, 2) . '</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Bonus</td>
                                                            <td>-----</td>
                                                            <td class="text-right">' . $currency_symbol . ' ' . number_format($bonus, 2) . '</td>
                                                            <td>Assessment</td>
                                                            <td class="text-right">' . $currency_symbol . ' ' . number_format($assessment, 2) . '</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Comission</td>
                                                            <td>-----</td>
                                                            <td class="text-right">' . $currency_symbol . ' ' . number_format($comission, 2) . '</td>
                                                            <td>Association ' . $association_rate . '%</td>
                                                            <td class="text-right">' . $currency_symbol . ' ' . number_format($total_association, 2) . '</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Ordinary Days</td>
                                                            <td>' . $ordinary . '</td>
                                                            <td class="text-right">' . $currency_symbol . ' ' . number_format($total_ordinary, 2) . '</td>
                                                            <td>Others</td>
                                                            <td class="text-right">' . $currency_symbol . ' ' . number_format($other_deduction, 2) . '</td>
                                                        </tr>

                                                        <tr>
                                                            <td>Allowance</td>
                                                            <td>-----</td>
                                                            <td class="text-right">' . $currency_symbol . ' ' . number_format($allowance, 2) . '</td>
                                                            <td>-----</td>
                                                            <td class="text-right">-----</td>
                                                        </tr>

                                                        <tr>
                                                            <td>Other Earning</td>
                                                            <td>-----</td>
                                                            <td class="text-right">' . $currency_symbol . ' ' . number_format($otherearning, 2) . '</td>
                                                            <td>-----</td>
                                                            <td class="text-right">-----</td>
                                                        </tr>

                                                        <tr>
                                                            <td>Gross Salary</td>
                                                            <td>-----</td>
                                                            <td class="text-right">' . $currency_symbol . ' ' . number_format($gross_salary, 2) . '</td>
                                                            <td>Total Deduction</td>
                                                            <td class="text-right">' . $currency_symbol . ' ' . number_format($total_deduction, 2) . '</td>
                                                        </tr>

                                                        <tr>
                                                            <td colspan="4"><h3><b>NET Salary</b></h3></td>
                                                            <td class="text-right"><h3><b>' . $currency_symbol . ' ' . number_format($net_pay, 2) . '</b></h3></td>
                                                        </tr>

                                                </tbody>
                                                    <tfoot>
                                                        <tr>
                                                        <th>Earnings</th>
                                                        <th>Quantity</th>
                                                        <th>Amount</th>
                                                        <th>Deductions</th>
                                                        <th>Amount</th>
                                                        </tr>
                                                    </tfoot>
                                            </table>
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Account Number: ' . $account_number . ' </th>
                                                            <!-- <th>Name of Bank:</th> -->
                                                            
                                                        </tr>
                                                    </thead>
                                                </table>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

         <center>
            <div class="row">
                <div class="col-md-4 col-sm-12 text-center">
                    <button type="button" class="btn btn-danger btn-lg my-1" id="print"><i class="la la-print"></i> Print</button>
                </div>

                <div class="col-md-4 col-sm-12 text-center">
                    <button type="button" class="btn btn-success btn-lg my-1 payment_proof_pdf_btn" id="'. $earning_id.'"><i class="la la-download"></i> Download PDF</button>
                </div>

                <div class="col-md-4 col-sm-12 text-center">
                    <button type="button" class="btn btn-info btn-lg my-1 payment_proof_email_btn" id="'. $earning_id.'"><i class="la la-paper-plane-o"></i> Send to Mail</button>
                </div>

            </div>

        </center>

        ';


        echo json_encode(array($employee_payment_proof_record_view));

    }


    public function MailPaymentProof($earning_id)
    {
        $earning_id_array[] = $earning_id;
        $this->payment_proof_mail->PaymentProofMail($earning_id_array);
    }


    public function DownloadPaymentProof($earning_id)
    {
        $response = $this->payment_proof_mail->PaymentProofDownload($earning_id);
    }



    public function LoadPayrollWorksheet($worksheet_payment_type = '', $worksheet_payment_date = '', $worksheet_payment_department)
    {

        $loggined_session = Classes_Session::get("Loggedin_Session");
        $worksheet_query ="";
        $data = array();
        $serial_id = 0;

        $worksheet_query = "SELECT * FROM earning ";

        if (!empty($worksheet_payment_department)) {

            $worksheet_query .= " JOIN employee ON earning.Employee_ID = employee.Employee_ID  WHERE employee.Department='$worksheet_payment_department' AND earning.Status='Active' AND earning.Subscriber_ID='$loggined_session'";
        }

        if (empty($worksheet_payment_department)) {
            $worksheet_query .= " WHERE earning.Status='Active' ";
        }

        if (!empty($worksheet_payment_type) && !empty($worksheet_payment_date)) {

            $worksheet_query .= " AND earning.Dates='$worksheet_payment_date' AND earning.Payment_Type='$worksheet_payment_type' ";
        } elseif (!empty($worksheet_payment_date)) {

            $worksheet_query .= " AND earning.Dates='$worksheet_payment_date' ";
        } elseif (!empty($worksheet_payment_type)) {

            $worksheet_query .= " AND earning.Payment_Type='$worksheet_payment_type' ";
        }
        //$worksheet_query .= " AND earning.Subscriber_ID='$loggined_session' ";


        //echo $worksheet_query;



         $search_value = $_POST["search"]["value"];

        $column_order = array('Emp_ID', 'Basic_Salary', 'Extra_Hour1', 'Extra_Hour2', 'Ordinary', 'Bonus', 'Comission', 'Allowance', 'Other_Earning', 'Gross_Salary', 'Tax', 'Loan', 'Assessment', 'Other_Deduction', 'Total_Deduction', 'Net_Pay', 'Dates', 'Status');
        if ($_POST['order']) {
            $order_by = $column_order[$_POST['order'][0]['column']] . ' ' . $_POST['order']['0']['dir'];
        } else {
            $order_by = " ID DESC";
        }

        $query = $this->_query->query("SELECT * FROM earning WHERE Subscriber_ID = ? ORDER BY ID DESC", array(Classes_Session::get("Loggedin_Session")));
        $total_worksheet_earning_data = $query->count();

        if ($_POST['length'] != -1) {
            $limit = " " . $_POST['start'] . ", " . $_POST['length'] . " ";
        }

        if (!empty($_POST["search"]["value"])) {
            $__worksheet_query = "SELECT * FROM earning JOIN employee ON earning.Employee_ID = employee.Employee_ID WHERE earning.Subscriber_ID = ? AND (earning.Emp_ID LIKE ? OR earning.Basic_Salary LIKE ? OR earning.Extra_Hour1 LIKE ? OR earning.Extra_Hour2 LIKE ? earning.Ordinary LIKE ? OR earning.Bonus LIKE ? OR earning.Comission LIKE ? OR earning.Allowance LIKE ? OR earning.Other_Earning LIKE ? OR earning.Gross_Salary LIKE ? OR earning.Tax LIKE ? OR earning.Loan LIKE ? OR earning.Assessment LIKE ? OR earning.Other_Deduction LIKE ? OR earning.Total_Deduction LIKE ? OR earning.Net_Pay LIKE ? OR earning.Dates LIKE ? OR earning.Status LIKE ?) ORDER BY $order_by LIMIT $limit";
            $data_value = array(Classes_Session::get("Loggedin_Session"), '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%');
            $query_result_c = $this->_query->query($__worksheet_query, $data_value);
        } else {
            $worksheet_query .= " AND earning.Subscriber_ID='$loggined_session' ORDER BY $order_by LIMIT $limit";

            $query_result_c = $this->_query->query($worksheet_query);
        }


        $total_worksheet_earning_filter = $query_result_c->count();

        //var_dump($query_result_c);

        if ($total_worksheet_earning_filter > 0) {
            $fetching_results = $query_result_c->results();
            $serial_id = 1;

            //var_dump($fetching_results);

            foreach ($fetching_results as $key => $data_value) {

                $table_cal_result =  Classes_PayrollTable::TableCalculator($data_value);

                $marital_amount = $table_cal_result['Married_Amount'];
                $kid_amount = $table_cal_result['Kid_Amount'];

                $exchange_rate = $table_cal_result["Exchange_Rate"];
                $bonus = $table_cal_result["Bonus"];
                $comission = $table_cal_result["Comission"];
                $allowance = $table_cal_result["Allowance"];
                $otherearning = $table_cal_result["Other_Earning"];
                $extra1 = $table_cal_result["Extra_Hour1"];
                $extra2 = $table_cal_result["Extra_Hour2"];
                $ordinary = $table_cal_result["Ordinary"];
                $payment_type = $table_cal_result["Payment_Type"];
                $salary = $table_cal_result["Salary"];
                $gross_salary = $table_cal_result["Gross_Salary"];

                $loan = $table_cal_result["Loan"];
                $assessment = $table_cal_result["Assessment"];
                $other_deduction = $table_cal_result["Other_Deduction"];
                $tax = $table_cal_result["Tax"];
                $total_deduction = $table_cal_result["Total_Deduction"];

                $net_pay = $table_cal_result["Net_Pay"];



                /*Calculating Currency Exchange Rate With Earnings*/
                $exchange_rate_bonus = $table_cal_result["Exchange_Rate_Bonus"];
                $exchange_rate_comission = $table_cal_result["Exchange_Rate_Comission"];
                $exchange_rate_allowance = $table_cal_result["Exchange_Rate_Allowance"];
                $exchange_rate_otherearning = $table_cal_result["Exchange_Rate_Other_Earning"];
                $exchange_rate_extra1 = $table_cal_result["Exchange_Rate_Extra_Hour1"];
                $exchange_rate_extra2 = $table_cal_result["Exchange_Rate_Extra_Hour2"];
                $exchange_rate_ordinary = $table_cal_result["Exchange_Rate_Ordinary"];
                /*Ending of Currency Exchange Rate With Earnings Calculation*/

                $history_earning_status = $table_cal_result["Status"];

                $basic_salary = $table_cal_result["Basic_Salary"];


                /*Calculating extra hours*/
                $extra1_total = $table_cal_result["Total_Extra_Hour1"];
                $extra2_total = $table_cal_result["Total_Extra_Hour2"];
                $total_ordinary = $table_cal_result["Total_Ordinary"];
                /*Ending of calculating extra hours*/

                $total_social_security = $table_cal_result["Total_SOS"];
                $total_association = $table_cal_result["Total_ASO"];


                $social_rate = $table_cal_result["SOS"];
                $association_rate = $table_cal_result["ASO"];

                $employee_link = '<a class="info" style="font-size: 15px" href="' . $this->web_data["Web_Url"] . 'view-employee?employee_id=' . $table_cal_result["Employee_ID"] . '"><b>' . $table_cal_result["First_Name"] . ' ' . $table_cal_result["Last_Name"] . '</b> </a>';

                $worksheet_earning_data = array();
                $worksheet_earning_data[] = $data_value["Emp_ID"];
                $worksheet_earning_data[] = $employee_link;
                $worksheet_earning_data[] = $table_cal_result["Department_Name"];
                $worksheet_earning_data[] = number_format($basic_salary, 2);
                $worksheet_earning_data[] = number_format($extra1_total, 2).' ('. $extra1.')';
                $worksheet_earning_data[] = number_format($extra2_total, 2) . ' (' . $extra2 . ')';
                $worksheet_earning_data[] = number_format($total_ordinary, 2) . ' (' . $ordinary . ')';
                $worksheet_earning_data[] = number_format($exchange_rate_bonus, 2);
                $worksheet_earning_data[] = number_format($exchange_rate_comission, 2);
                $worksheet_earning_data[] = number_format($exchange_rate_allowance, 2);
                $worksheet_earning_data[] = number_format($exchange_rate_otherearning, 2);
                $worksheet_earning_data[] = number_format($gross_salary, 2);
                $worksheet_earning_data[] = number_format($total_social_security, 2);
                $worksheet_earning_data[] = number_format($total_association, 2);
                $worksheet_earning_data[] = number_format($tax, 2);
                $worksheet_earning_data[] = number_format($loan, 2);
                $worksheet_earning_data[] = number_format($assessment, 2);
                $worksheet_earning_data[] = number_format($other_deduction, 2);
                $worksheet_earning_data[] = number_format($total_deduction, 2);
                $worksheet_earning_data[] = number_format($net_pay, 2);
                $worksheet_earning_data[] = date($this->localization["Date_Format"], strtotime($table_cal_result["Dates"]));
                $data[] = $worksheet_earning_data;
            }
        }

        $worksheet_payroll_list_result_output = array(

            "draw"  => intval($_POST["draw"]),
            "recordsTotal" => intval($total_worksheet_earning_data),
            "recordsFiltered" => intval($total_worksheet_earning_filter),
            "data" => $data,
        );

        echo json_encode($worksheet_payroll_list_result_output);
    }



    public function LoadPayrollWorksheetSummary($summary_worksheet_employee_id = '', $worksheet_summary_payment_date = '')
    {

        $loggined_session = Classes_Session::get("Loggedin_Session");
        $worksheet_query = "";
        $data = array();
        $serial_id = 0;

        $worksheet_summary_payment_date_in = '0000-' . $worksheet_summary_payment_date . '-00';


        $worksheet_query = "SELECT * FROM earning WHERE Status='Active' AND Subscriber_ID = '$loggined_session'";

        if (!empty($summary_worksheet_employee_id) && !empty($worksheet_summary_payment_date)) {

            $worksheet_query .= " AND month(Dates) = month('$worksheet_summary_payment_date_in') AND Employee_ID='$summary_worksheet_employee_id'  ";
        } elseif (!empty($worksheet_summary_payment_date)) {

            $worksheet_query .= " AND month(Dates) = month('$worksheet_summary_payment_date_in') ";
        } elseif (!empty($summary_worksheet_employee_id)) {

            $worksheet_query .= " AND Employee_ID='$summary_worksheet_employee_id' ";
        }


        $search_value = $_POST["search"]["value"];

        $column_order = array('Emp_ID', 'Basic_Salary', 'Extra_Hour1', 'Extra_Hour2', 'Ordinary', 'Bonus', 'Comission', 'Allowance', 'Other_Earning', 'Gross_Salary', 'Tax', 'Loan', 'Assessment', 'Other_Deduction', 'Total_Deduction', 'Net_Pay', 'Dates', 'Status');
        if ($_POST['order']) {
            $order_by = $column_order[$_POST['order'][0]['column']] . ' ' . $_POST['order']['0']['dir'];
        } else {
            $order_by = " ID DESC";
        }

        $query = $this->_query->query("SELECT * FROM earning WHERE Subscriber_ID = ? ORDER BY ID DESC", array(Classes_Session::get("Loggedin_Session")));
        $total_worksheet_earning_data = $query->count();

        if ($_POST['length'] != -1) {
            $limit = " " . $_POST['start'] . ", " . $_POST['length'] . " ";
        }

        if (!empty($_POST["search"]["value"])) {
            $__worksheet_query = "SELECT * FROM earning WHERE Subscriber_ID = ? AND (Emp_ID LIKE ? OR Basic_Salary LIKE ? OR Extra_Hour1 LIKE ? OR Extra_Hour2 LIKE ? Ordinary LIKE ? OR Bonus LIKE ? OR Comission LIKE ? OR Allowance LIKE ? OR Other_Earning LIKE ? OR Gross_Salary LIKE ? OR Tax LIKE ? OR Loan LIKE ? OR Assessment LIKE ? OR Other_Deduction LIKE ? OR Total_Deduction LIKE ? OR Net_Pay LIKE ? OR Dates LIKE ? OR Status LIKE ?) ORDER BY $order_by LIMIT $limit";
            $data_value = array(Classes_Session::get("Loggedin_Session"), '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%');
            $query_result_c = $this->_query->query($__worksheet_query, $data_value);
        } else {
            $worksheet_query .= " AND Subscriber_ID='$loggined_session' ORDER BY $order_by LIMIT $limit";

            $query_result_c = $this->_query->query($worksheet_query);
        }


        $total_worksheet_earning_filter = $query_result_c->count();


        if ($total_worksheet_earning_filter > 0) {
            $fetching_results = $query_result_c->results();
            $serial_id = 1;

            //var_dump($fetching_results);

            foreach ($fetching_results as $key => $data_value) {

                $table_cal_result =  Classes_PayrollTable::TableCalculator($data_value);

                $marital_amount = $table_cal_result['Married_Amount'];
                $kid_amount = $table_cal_result['Kid_Amount'];

                $exchange_rate = $table_cal_result["Exchange_Rate"];
                $bonus = $table_cal_result["Bonus"];
                $comission = $table_cal_result["Comission"];
                $allowance = $table_cal_result["Allowance"];
                $otherearning = $table_cal_result["Other_Earning"];
                $extra1 = $table_cal_result["Extra_Hour1"];
                $extra2 = $table_cal_result["Extra_Hour2"];
                $ordinary = $table_cal_result["Ordinary"];
                $payment_type = $table_cal_result["Payment_Type"];
                $salary = $table_cal_result["Salary"];
                $gross_salary = $table_cal_result["Gross_Salary"];

                $loan = $table_cal_result["Loan"];
                $assessment = $table_cal_result["Assessment"];
                $other_deduction = $table_cal_result["Other_Deduction"];
                $tax = $table_cal_result["Tax"];
                $total_deduction = $table_cal_result["Total_Deduction"];

                $net_pay = $table_cal_result["Net_Pay"];



                /*Calculating Currency Exchange Rate With Earnings*/
                $exchange_rate_bonus = $table_cal_result["Exchange_Rate_Bonus"];
                $exchange_rate_comission = $table_cal_result["Exchange_Rate_Comission"];
                $exchange_rate_allowance = $table_cal_result["Exchange_Rate_Allowance"];
                $exchange_rate_otherearning = $table_cal_result["Exchange_Rate_Other_Earning"];
                $exchange_rate_extra1 = $table_cal_result["Exchange_Rate_Extra_Hour1"];
                $exchange_rate_extra2 = $table_cal_result["Exchange_Rate_Extra_Hour2"];
                $exchange_rate_ordinary = $table_cal_result["Exchange_Rate_Ordinary"];
                /*Ending of Currency Exchange Rate With Earnings Calculation*/

                $history_earning_status = $table_cal_result["Status"];

                $basic_salary = $table_cal_result["Basic_Salary"];


                /*Calculating extra hours*/
                $extra1_total = $table_cal_result["Total_Extra_Hour1"];
                $extra2_total = $table_cal_result["Total_Extra_Hour2"];
                $total_ordinary = $table_cal_result["Total_Ordinary"];
                /*Ending of calculating extra hours*/

                $total_social_security = $table_cal_result["Total_SOS"];
                $total_association = $table_cal_result["Total_ASO"];


                $social_rate = $table_cal_result["SOS"];
                $association_rate = $table_cal_result["ASO"];

                $employee_link = '<a class="info" style="font-size: 15px" href="' . $this->web_data["Web_Url"] . 'view-employee?employee_id=' . $table_cal_result["Employee_ID"] . '"><b>' . $table_cal_result["First_Name"] . ' ' . $table_cal_result["Last_Name"] . '</b> </a>';


                $worksheet_earning_data = array();
                $worksheet_earning_data[] = $data_value["Emp_ID"];
                $worksheet_earning_data[] = $employee_link;
                $worksheet_earning_data[] = $table_cal_result["Department_Name"];
                $worksheet_earning_data[] = number_format($basic_salary, 2);
                $worksheet_earning_data[] = number_format($extra1_total, 2) . ' (' . $extra1 . ')';
                $worksheet_earning_data[] = number_format($extra2_total, 2) . ' (' . $extra2 . ')';
                $worksheet_earning_data[] = number_format($total_ordinary, 2) . ' (' . $ordinary . ')';
                $worksheet_earning_data[] = number_format($exchange_rate_bonus, 2);
                $worksheet_earning_data[] = number_format($exchange_rate_comission, 2);
                $worksheet_earning_data[] = number_format($exchange_rate_allowance, 2);
                $worksheet_earning_data[] = number_format($exchange_rate_otherearning, 2);
                $worksheet_earning_data[] = number_format($gross_salary, 2);
                $worksheet_earning_data[] = number_format($total_social_security, 2);
                $worksheet_earning_data[] = number_format($total_association, 2);
                $worksheet_earning_data[] = number_format($tax, 2);
                $worksheet_earning_data[] = number_format($loan, 2);
                $worksheet_earning_data[] = number_format($assessment, 2);
                $worksheet_earning_data[] = number_format($other_deduction, 2);
                $worksheet_earning_data[] = number_format($total_deduction, 2);
                $worksheet_earning_data[] = number_format($net_pay, 2);
                $worksheet_earning_data[] = date($this->localization["Date_Format"], strtotime($table_cal_result["Dates"]));
                $data[] = $worksheet_earning_data;
            }
        }

        $worksheet_payroll_list_result_output = array(

            "draw"  => intval($_POST["draw"]),
            "recordsTotal" => intval($total_worksheet_earning_data),
            "recordsFiltered" => intval($total_worksheet_earning_filter),
            "data" => $data,
        );

        echo json_encode($worksheet_payroll_list_result_output);
    }



    public function LoadPayrollMonthlyReport($monthly_salary_report_date){
        $data = array();
        $serial_id = 0;
        $monthly_salary_report_date_in = '0000-' . $monthly_salary_report_date . '-00';

        //var_dump($monthly_salary_report_date_in);

        $loggined_session = Classes_Session::get("Loggedin_Session");

        $column_order = array('Emp_ID', 'First_Name', 'Gross_Salary', 'Dates');
        if ($_POST['order']) {
            $order_by = $column_order[$_POST['order'][0]['column']] . ' ' . $_POST['order']['0']['dir'];
        } else {
            $order_by = " ID DESC";
        }
        
        if (empty($monthly_salary_report_date)) {
            $monthly_report_query= "SELECT * FROM earning WHERE Subscriber_ID = '$loggined_session' AND Status='Active' ORDER BY $order_by, Dates ASC";
        }
        elseif (!empty($monthly_salary_report_date)) {
            $monthly_report_query="SELECT * FROM earning WHERE Subscriber_ID = '$loggined_session' AND month(Dates) = month('$monthly_salary_report_date_in') AND Status='Active' GROUP BY Emp_ID ";
        }

        $search_value = $_POST["search"]["value"];


        $query = $this->_query->query("SELECT * FROM earning WHERE Subscriber_ID = ? ORDER BY ID DESC", array(Classes_Session::get("Loggedin_Session")));
        $total_monthly_earning_data = $query->count();

        if ($_POST['length'] != -1) {
            $limit = " " . $_POST['start'] . ", " . $_POST['length'] . " ";
        }

        if (!empty($_POST["search"]["value"])) {
            $__monthly_query = "SELECT * FROM earning WHERE Subscriber_ID = ? AND (Emp_ID LIKE ? OR Basic_Salary LIKE ? OR Extra_Hour1 LIKE ? OR Extra_Hour2 LIKE ? Ordinary LIKE ? OR Bonus LIKE ? OR Comission LIKE ? OR Allowance LIKE ? OR Other_Earning LIKE ? OR Gross_Salary LIKE ? OR Tax LIKE ? OR Loan LIKE ? OR Assessment LIKE ? OR Other_Deduction LIKE ? OR Total_Deduction LIKE ? OR Net_Pay LIKE ? OR Dates LIKE ? OR Status LIKE ?) ORDER BY $order_by LIMIT $limit";
            $data_value = array(Classes_Session::get("Loggedin_Session"), '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%');
            $query_result_c = $this->_query->query($__monthly_query, $data_value);
        } else {

            $query_result_c = $this->_query->query($monthly_report_query);
        }

        $total_monthly_earning_filter = $query_result_c->count();

        if ($total_monthly_earning_filter > 0) {
            $fetching_results = $query_result_c->results();
            $serial_id = 1;

            //var_dump($fetching_results);

            foreach ($fetching_results as $key => $data_value) {

                $table_cal_result =  Classes_PayrollTable::TableCalculator($data_value);

                $marital_amount = $table_cal_result['Married_Amount'];
                $kid_amount = $table_cal_result['Kid_Amount'];

                $exchange_rate = $table_cal_result["Exchange_Rate"];
                $bonus = $table_cal_result["Bonus"];
                $comission = $table_cal_result["Comission"];
                $allowance = $table_cal_result["Allowance"];
                $otherearning = $table_cal_result["Other_Earning"];
                $extra1 = $table_cal_result["Extra_Hour1"];
                $extra2 = $table_cal_result["Extra_Hour2"];
                $ordinary = $table_cal_result["Ordinary"];
                $payment_type = $table_cal_result["Payment_Type"];
                $salary = $table_cal_result["Salary"];
                $gross_salary = $table_cal_result["Gross_Salary"];

                $loan = $table_cal_result["Loan"];
                $assessment = $table_cal_result["Assessment"];
                $other_deduction = $table_cal_result["Other_Deduction"];
                $tax = $table_cal_result["Tax"];
                $total_deduction = $table_cal_result["Total_Deduction"];

                $net_pay = $table_cal_result["Net_Pay"];



                /*Calculating Currency Exchange Rate With Earnings*/
                $exchange_rate_bonus = $table_cal_result["Exchange_Rate_Bonus"];
                $exchange_rate_comission = $table_cal_result["Exchange_Rate_Comission"];
                $exchange_rate_allowance = $table_cal_result["Exchange_Rate_Allowance"];
                $exchange_rate_otherearning = $table_cal_result["Exchange_Rate_Other_Earning"];
                $exchange_rate_extra1 = $table_cal_result["Exchange_Rate_Extra_Hour1"];
                $exchange_rate_extra2 = $table_cal_result["Exchange_Rate_Extra_Hour2"];
                $exchange_rate_ordinary = $table_cal_result["Exchange_Rate_Ordinary"];
                /*Ending of Currency Exchange Rate With Earnings Calculation*/

                $history_earning_status = $table_cal_result["Status"];

                $basic_salary = $table_cal_result["Basic_Salary"];


                /*Calculating extra hours*/
                $extra1_total = $table_cal_result["Total_Extra_Hour1"];
                $extra2_total = $table_cal_result["Total_Extra_Hour2"];
                $total_ordinary = $table_cal_result["Total_Ordinary"];
                /*Ending of calculating extra hours*/

                $total_social_security = $table_cal_result["Total_SOS"];
                $total_association = $table_cal_result["Total_ASO"];

                $social_rate = $table_cal_result["SOS"];
                $association_rate = $table_cal_result["ASO"];

                $employee_link = '<a class="info" style="font-size: 15px" href="' . $this->web_data["Web_Url"] . 'view-employee?employee_id=' . $table_cal_result["Employee_ID"] . '"><b>' . $table_cal_result["First_Name"] . ' ' . $table_cal_result["Last_Name"] . '</b> </a>';

                $monthly_earning_data = array();
                $monthly_earning_data[] = $data_value["Emp_ID"];
                $monthly_earning_data[] = $employee_link;
                $monthly_earning_data[] = $social_rate;
                $monthly_earning_data[] = $association_rate;
                $monthly_earning_data[] = $table_cal_result["Currency_Symbol"];
                $monthly_earning_data[] = number_format($gross_salary, 2);
                $monthly_earning_data[] = date($this->localization["Date_Format"], strtotime($table_cal_result["Dates"]));
                $data[] = $monthly_earning_data;
            }
        }

        $monthly_payroll_list_result_output = array(

            "draw"  => intval($_POST["draw"]),
            "recordsTotal" => intval($total_monthly_earning_data),
            "recordsFiltered" => intval($total_monthly_earning_filter),
            "data" => $data,
        );

        echo json_encode($monthly_payroll_list_result_output);
    }



    public function LoadPayrollRowReport($payment_date_from = '', $payment_date_to = '')
    {
        $loggined_session = Classes_Session::get("Loggedin_Session");
        $data = array();
        $serial_id = 0;

      
        if (!empty($payment_date_from) && !empty($payment_date_to)) {

            $row_report_query = " SELECT * FROM earning WHERE Subscriber_ID = '$loggined_session' AND Dates BETWEEN '$payment_date_from' AND '$payment_date_to' ";
        } else {

            $row_report_query = " SELECT * FROM earning WHERE Subscriber_ID = '$loggined_session' ";
        }


        $search_value = $_POST["search"]["value"];

        $column_order = array('Emp_ID', 'Basic_Salary', 'Extra_Hour1', 'Extra_Hour2', 'Ordinary', 'Bonus', 'Comission', 'Allowance', 'Other_Earning', 'Gross_Salary', 'Tax', 'Loan', 'Assessment', 'Other_Deduction', 'Total_Deduction', 'Net_Pay', 'Dates', 'Status');
        if ($_POST['order']) {
            $order_by = $column_order[$_POST['order'][0]['column']] . ' ' . $_POST['order']['0']['dir'];
        } else {
            $order_by = " ID DESC";
        }

        $query = $this->_query->query("SELECT * FROM earning WHERE Subscriber_ID = ? ORDER BY ID DESC", array(Classes_Session::get("Loggedin_Session")));
        $total_row_report_earning_data = $query->count();

        if ($_POST['length'] != -1) {
            $limit = " " . $_POST['start'] . ", " . $_POST['length'] . " ";
        }

        if (!empty($_POST["search"]["value"])) {
            $__row_report_query = "SELECT * FROM earning WHERE Subscriber_ID = ? AND (Emp_ID LIKE ? OR Basic_Salary LIKE ? OR Extra_Hour1 LIKE ? OR Extra_Hour2 LIKE ? Ordinary LIKE ? OR Bonus LIKE ? OR Comission LIKE ? OR Allowance LIKE ? OR Other_Earning LIKE ? OR Gross_Salary LIKE ? OR Tax LIKE ? OR Loan LIKE ? OR Assessment LIKE ? OR Other_Deduction LIKE ? OR Total_Deduction LIKE ? OR Net_Pay LIKE ? OR Dates LIKE ? OR Status LIKE ?) ORDER BY $order_by LIMIT $limit";
            $data_value = array(Classes_Session::get("Loggedin_Session"), '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%');
            $query_result_c = $this->_query->query($__row_report_query, $data_value);
        } else {
            $row_report_query .= " AND Status = 'Active' ORDER BY $order_by LIMIT $limit";

            $query_result_c = $this->_query->query($row_report_query);
        }

        $total_row_report_earning_filter = $query_result_c->count();


        if ($total_row_report_earning_filter > 0) {
            $fetching_results = $query_result_c->results();
            $serial_id = 1;

            //var_dump($fetching_results);

            foreach ($fetching_results as $key => $data_value) {

                $table_cal_result =  Classes_PayrollTable::TableCalculator($data_value);

                $marital_amount = $table_cal_result['Married_Amount'];
                $kid_amount = $table_cal_result['Kid_Amount'];

                $exchange_rate = $table_cal_result["Exchange_Rate"];
                $bonus = $table_cal_result["Bonus"];
                $comission = $table_cal_result["Comission"];
                $allowance = $table_cal_result["Allowance"];
                $otherearning = $table_cal_result["Other_Earning"];
                $extra1 = $table_cal_result["Extra_Hour1"];
                $extra2 = $table_cal_result["Extra_Hour2"];
                $ordinary = $table_cal_result["Ordinary"];
                $payment_type = $table_cal_result["Payment_Type"];
                $salary = $table_cal_result["Salary"];
                $gross_salary = $table_cal_result["Gross_Salary"];

                $loan = $table_cal_result["Loan"];
                $assessment = $table_cal_result["Assessment"];
                $other_deduction = $table_cal_result["Other_Deduction"];
                $tax = $table_cal_result["Tax"];
                $total_deduction = $table_cal_result["Total_Deduction"];

                $net_pay = $table_cal_result["Net_Pay"];



                /*Calculating Currency Exchange Rate With Earnings*/
                $exchange_rate_bonus = $table_cal_result["Exchange_Rate_Bonus"];
                $exchange_rate_comission = $table_cal_result["Exchange_Rate_Comission"];
                $exchange_rate_allowance = $table_cal_result["Exchange_Rate_Allowance"];
                $exchange_rate_otherearning = $table_cal_result["Exchange_Rate_Other_Earning"];
                $exchange_rate_extra1 = $table_cal_result["Exchange_Rate_Extra_Hour1"];
                $exchange_rate_extra2 = $table_cal_result["Exchange_Rate_Extra_Hour2"];
                $exchange_rate_ordinary = $table_cal_result["Exchange_Rate_Ordinary"];
                /*Ending of Currency Exchange Rate With Earnings Calculation*/

                $history_earning_status = $table_cal_result["Status"];

                $basic_salary = $table_cal_result["Basic_Salary"];


                /*Calculating extra hours*/
                $extra1_total = $table_cal_result["Total_Extra_Hour1"];
                $extra2_total = $table_cal_result["Total_Extra_Hour2"];
                $total_ordinary = $table_cal_result["Total_Ordinary"];
                /*Ending of calculating extra hours*/

                $total_social_security = $table_cal_result["Total_SOS"];
                $total_association = $table_cal_result["Total_ASO"];

                $employee_link = '<a class="info" style="font-size: 15px" href="' . $this->web_data["Web_Url"] . 'view-employee?employee_id=' . $table_cal_result["Employee_ID"] . '"><b>' . $table_cal_result["Emp_ID"] . ' </b> </a>';

                $row_report_earning_data = array();
                $row_report_earning_data[] = $employee_link;
                $row_report_earning_data[] = $table_cal_result["First_Name"];
                $row_report_earning_data[] = $table_cal_result["Last_Name"];
                $row_report_earning_data[] = $table_cal_result["Currency_Name"];
                $row_report_earning_data[] = number_format($exchange_rate_bonus, 2);
                $row_report_earning_data[] = number_format($exchange_rate_comission, 2);
                $row_report_earning_data[] = number_format($exchange_rate_allowance, 2);
                $row_report_earning_data[] = number_format($exchange_rate_otherearning, 2);
                $row_report_earning_data[] = number_format($extra1_total, 2) . ' (' . $extra1 . ')';
                $row_report_earning_data[] = number_format($extra2_total, 2) . ' (' . $extra2 . ')';
                $row_report_earning_data[] = number_format($total_ordinary, 2) . ' (' . $ordinary . ')';
                $row_report_earning_data[] = number_format($tax, 2);
                $row_report_earning_data[] = number_format($marital_amount, 2);
                $row_report_earning_data[] = number_format($kid_amount, 2);
                $row_report_earning_data[] = number_format($total_social_security, 2);
                $row_report_earning_data[] = number_format($total_association, 2);
                $row_report_earning_data[] = number_format($loan, 2);
                $row_report_earning_data[] = number_format($assessment, 2);
                $row_report_earning_data[] = number_format($other_deduction, 2);
                $row_report_earning_data[] = number_format($gross_salary, 2);
                $row_report_earning_data[] = number_format($net_pay, 2);
                $row_report_earning_data[] = date($this->localization["Date_Format"], strtotime($table_cal_result["Dates"]));
                $data[] = $row_report_earning_data;
            }
        }

        $row_report_payroll_list_result_output = array(
            "draw"  => intval($_POST["draw"]),
            "recordsTotal" => intval($total_row_report_earning_data),
            "recordsFiltered" => intval($total_row_report_earning_filter),
            "data" => $data,
        );

        echo json_encode($row_report_payroll_list_result_output);
    }


    public function LoadAguinaldoReport($employee_id_aguinaldo){

        $loggined_session = Classes_Session::get("Loggedin_Session");

        $employee_aguinaldo_display_result = '';
        $sn = 0;
        $netpay12 = 0;

        $employee_query = $this->data_manager->EmployeesDataByID($employee_id_aguinaldo)->first();
        $currency_results = $this->data_manager->CurrencyDataByID($employee_query["Currency"])->first();

        $first_name = $employee_query['First_Name'];
        $last_name = $employee_query['Last_Name'];
        $employee_id = $employee_query['Employee_ID'];
        $employee_input_id = $employee_query['Emp_ID'];
        $currency = $employee_query['Currency'];
        $payment_type = $employee_query['Payment_Type'];


        /*Here we are calculating 12 Month Salary calculation */
        if ($payment_type == 30) {
            $earning_aguinaldo_query = "SELECT * FROM earning WHERE Subscriber_ID = '$loggined_session' AND Employee_ID='$employee_id' AND DATE(Dates) BETWEEN CONCAT(YEAR(NOW())-1,'-12-00') AND NOW() AND Status='Active' ORDER BY Dates DESC LIMIT 12";
        } elseif ($payment_type == 15) {
            $earning_aguinaldo_query = "SELECT * FROM earning WHERE Subscriber_ID = '$loggined_session' AND Employee_ID='$employee_id' AND DATE(Dates) BETWEEN CONCAT(YEAR(NOW())-1,'-12-00') AND NOW() AND Status='Active' ORDER BY Dates DESC LIMIT 24";
        } elseif ($payment_type == 7) {
            $earning_aguinaldo_query = "SELECT * FROM earning WHERE Subscriber_ID = '$loggined_session' AND Employee_ID='$employee_id' AND DATE(Dates) BETWEEN CONCAT(YEAR(NOW())-1,'-12-00') AND NOW() AND Status='Active' ORDER BY Dates DESC LIMIT 52";
        }



        $employee_aguinaldo_display_result.= '
        <section class="card">
            <div id="invoice-template" class="card-body printableArea">
                <!-- Invoice Company Details -->
                <center><h2><b class="text-danger">' . strtoupper($this->company_data["Company_Name"]) . '</b></h2></center><br/>
                <center><h2><b class="text-success">' . $this->company_data["Company_ID"] . '</b></h2></center>
                
                <!--/ Invoice Company Details -->
                <div id="invoice-customer-details" class="row pt-2">
                    <div class="col-sm-12 text-center text-md-left">
                        <p class="text-muted" ><h2 data-i18n="proof_of_payment">Proof of Payment of the Aguinaldo</h2></p>
                    </div>
                    <div class="col-md-6 col-sm-12 text-center text-md-left">
                        <ul class="px-0 list-unstyled">
                        <li class="text-bold-800"><b data-i18n="employee_id">Employee ID</b>: <b>' . $employee_input_id . '</b></li>
                        <li><b data-i18n="name_of_employee">Full name</b> <b>: ' . $first_name . ' ' . $last_name . '</b></li>
                        </ul>
                    </div>
                </div>
                <!--/ Invoice Customer Details -->
                <!-- Invoice Items Details -->
                <div id="invoice-items-details" class="pt-2">
                    <div class="row">
                        <div class="table-responsive col-sm-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th data-i18n="date">Date</th>
                                        <th class="text-right" data-i18n="gross_salary">Gross Salary</th>
                                    </tr>
                                </thead>
                                <tbody>';

                                    $earning_aguinaldo_results = $this->_query->query($earning_aguinaldo_query)->results();
                                    $total_gross_salary_s = 0;
                                    foreach ($earning_aguinaldo_results as $key => $earning_aguinaldo_result) {
                                        # code...
                                
                                        $exchange_rate = $earning_aguinaldo_result["Exchange_Rate"];
                                        $earning_id = $earning_aguinaldo_result["ID"];

                                        $earning_last_one_query = $this->_query->query("SELECT * FROM earning  WHERE Subscriber_ID = '$loggined_session' AND Employee_ID='$employee_id' AND Status='Active' ORDER BY Dates DESC LIMIT 1")->first();

                                        $last_one_date = $earning_last_one_query["Dates"];
                                        $last_one_end_date = $earning_last_one_query["End_Date"];

                                        $earning_last_dec_query = $this->_query->query("SELECT * FROM earning  WHERE Subscriber_ID = '$loggined_session' AND  Employee_ID='$employee_id' AND Status='Active' AND MONTH(Dates) = '12' ORDER BY Dates ASC LIMIT 1 ")->first();
                                        $last_dec_date = $earning_last_dec_query["Dates"];


                                            $last_one_date_month = substr($last_one_date, 5, -3);
                                            $last_one_date_year = substr($last_one_date, 0, -6);
                                            $last_one_date_day = substr($last_one_date, 8);

                                            $last_dec_date_month = substr($last_dec_date, 5, -3);
                                            $last_dec_date_year = substr($last_dec_date, 0, -6);
                                            $last_dec_date_day = substr($last_dec_date, 8);

                                            $last_one_date_month_name = date('F', mktime(0, 0, 0, $last_one_date_month, 10)); 
                                            $last_dec_date_month_name = date('F', mktime(0, 0, 0, $last_dec_date_month, 10));



                                            $sn++; //Iteration Number

                                            $gross_salary = $earning_aguinaldo_result['Gross_Salary'];
                                            $total_gross_salary = $gross_salary / $exchange_rate;
                                            $earning_date = $earning_aguinaldo_result['Dates'];


                                            $earning_date_month = substr($earning_date, 5, -3);
                                            $total_gross_salary_s += $total_gross_salary;

                                            $total_avg_gross_salary = $total_gross_salary_s / 12;


                                            $earning_date_month_name = date("F", strtotime($earning_date));


                                        $employee_aguinaldo_display_result .=
                                                '<tr>
                                                    <th scope="row">' . $sn . '</th>
                                                    <td>' . $earning_date_month_name . '</td>
                                                    <td class="text-right">' . $currency_results["Currency_Symbol"] . ' ' . number_format($total_gross_salary, 2) . '</td>
                                                </tr>';

                                    }

                    $employee_aguinaldo_display_result .=
                                    '<tr>
                                        <td></td>
                                        <td><h4><b data-i18n="total_sum">Total Sum</h4></b></td>
                                        <td class="text-right"><h5><b>' . $currency_results["Currency_Symbol"] . ' ' . number_format($total_gross_salary_s, 2) . '</h5></b></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><h4><b data-i18n="bonus_to_pay">Bonus to Pay</h4></b></td>
                                        <td class="text-right"><h5><b>' . $currency_results["Currency_Symbol"].' '.number_format($total_avg_gross_salary, 2) . '</h5></b></td>
                                    </tr>       
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 text-center text-md-left">
                            <div class="row">
                                <div class="col-md-12">
                                    <br/><br/>
                                    <table class="table table-borderless table-sm">
                                        <tbody>
                                        <tr>
                                            <td><b data-i18n="from">From </b> ' . $last_dec_date_year . ' ' . $last_dec_date_month_name . ', ' . $last_dec_date_day . ' <b data-i18n="to">To:</b> ' . $last_one_date_year . ' ' . $last_one_date_month_name . ', ' . $last_one_date_day . ' </b></td>
                                        </tr>
                                        <tr>
                                            <td><br/><b data-i18n="receive_by">Received by</b>: ______________________________</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Invoice Footer -->
                <div id="invoice-footer"></div>
            </div>

            <center>
                <div class="row">
                    <div class="col-md-4 col-sm-12 text-center">
                        <button type="button" class="btn btn-danger btn-lg my-1" id="print"><i class="la la-print"></i> Print</button>
                    </div>
                    <div class="col-md-4 col-sm-12 text-center">
                        <button type="button" class="btn btn-success btn-lg my-1 payment_proof_pdf_btn" id="' . $earning_id . '"><i class="la la-download"></i> Download PDF</button>
                    </div>
                    <div class="col-md-4 col-sm-12 text-center">
                        <button type="button" class="btn btn-info btn-lg my-1 payment_proof_email_btn" id="' . $earning_id . '"><i class="la la-paper-plane-o"></i> Send to Mail</button>
                    </div>
                </div>
            </center>
        </section>';
        echo ($employee_aguinaldo_display_result);

        //echo json_encode($employee_aguinaldo_display_result);



    }


    public function LoadYearDateRangeByEmployee($employee_id_earning_history){
        $query_results =  $this->data_manager->EarningYearDate($employee_id_earning_history)->results();
        var_dump($query_results);
        foreach ($query_results as $key => $query_result) {
            if (!empty($query_result["Dates"]))
            $date_s = $query_result["Dates"];

              echo "<option value='$date_s-01'>January $date_s</option>
                    <option value='$date_s-02'>February $date_s</option>
                    <option value='$date_s-03'>March $date_s</option>
                    <option value='$date_s-04'>April $date_s</option>
                    <option value='$date_s-05'>May $date_s</option>
                    <option value='$date_s-06'>June $date_s</option>
                    <option value='$date_s-07'>July $date_s</option>
                    <option value='$date_s-08'>August $date_s</option>
                    <option value='$date_s-09'>September $date_s</option>
                    <option value='$date_s-10'>October $date_s</option>
                    <option value='$date_s-11'>November $date_s</option>
                    <option value='$date_s-12'>December $date_s</option>";  
        }
    }


    public function LoadEmployeePayrollHistory($employee_id_earning_history = '', $earning_date_range_payment_history = '')
    {

        $loggined_session = Classes_Session::get("Loggedin_Session");
        $data = array();
        $serial_id = 0;

        $__earning_date_range_payment_history = $earning_date_range_payment_history.'-00';

        $search_value = $_POST["search"]["value"];

        $column_order = array('Emp_ID', 'Bonus', 'Comission', 'Allowance', 'Other_Earning', 'Extra_Hour1', 'Extra_Hour2', 'Ordinary', 'Loan', 'Assessment', 'Gross_Salary', 'Other_Deduction', 'Basic_Salary', 'Net_Pay', 'Dates');
        if ($_POST['order']) {
            $order_by = $column_order[$_POST['order'][0]['column']] . ' ' . $_POST['order']['0']['dir'];
        } else {
            $order_by = " ID DESC";
        }

        if ($_POST['length'] != -1) {
            $limit = " " . $_POST['start'] . ", " . $_POST['length'] . " ";
        }



        if (!empty($employee_id_earning_history) && !empty($earning_date_range_payment_history)) {
            $history_query = "SELECT * FROM earning WHERE Subscriber_ID = '$loggined_session' AND month(Dates) = month('$__earning_date_range_payment_history') AND year(Dates) = year('$__earning_date_range_payment_history') AND Employee_ID='$employee_id_earning_history' AND Status='Active' ORDER BY $order_by LIMIT $limit";
        } elseif (!empty($earning_date_range_payment_history)) {
            $history_query = "SELECT * FROM earning WHERE Subscriber_ID = '$loggined_session' AND month(Dates) = month('$__earning_date_range_payment_history') AND year(Dates) = year('$__earning_date_range_payment_history') AND Status='Active' ORDER BY $order_by LIMIT $limit";
        } else {
            $history_query = "SELECT * FROM earning WHERE Subscriber_ID = '$loggined_session' AND Status='Active' ORDER BY $order_by LIMIT $limit";
        }


        $query = $this->_query->query("SELECT * FROM earning WHERE Subscriber_ID = ? ORDER BY ID DESC", array(Classes_Session::get("Loggedin_Session")));
        $total_history_earning_data = $query->count();
       

        if (!empty($_POST["search"]["value"])) {
            $__history_query = "SELECT * FROM earning WHERE Subscriber_ID = ? AND (Emp_ID LIKE ? OR Basic_Salary LIKE ? OR Extra_Hour1 LIKE ? OR Extra_Hour2 LIKE ? Ordinary LIKE ? OR Bonus LIKE ? OR Comission LIKE ? OR Allowance LIKE ? OR Other_Earning LIKE ? OR Gross_Salary LIKE ? OR Loan LIKE ? OR Assessment LIKE ? OR Other_Deduction LIKE ? OR Total_Deduction LIKE ? OR Net_Pay LIKE ? OR Dates LIKE ? OR Status LIKE ?) ORDER BY $order_by LIMIT $limit";
            $data_value = array(Classes_Session::get("Loggedin_Session"), '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%');
            $query_result_c = $this->_query->query($__history_query, $data_value);
        } else {
            //$history_query .= " AND Subscriber_ID='$loggined_session' ORDER BY $order_by LIMIT $limit";

            $query_result_c = $this->_query->query($history_query);
        }


        $total_history_earning_filter = $query_result_c->count();
        $fetching_results = $query_result_c->results();

        //var_dump($fetching_results);

        if ($total_history_earning_filter > 0) {
            $fetching_results = $query_result_c->results();
            $serial_id = 1;

            //var_dump($fetching_results);

            foreach ($fetching_results as $key => $data_value) {

                $table_cal_result =  Classes_PayrollTable::TableCalculator($data_value);

                $marital_amount = $table_cal_result['Married_Amount'];
                $kid_amount = $table_cal_result['Kid_Amount'];

                $exchange_rate = $table_cal_result["Exchange_Rate"];
                $bonus = $table_cal_result["Bonus"];
                $comission = $table_cal_result["Comission"];
                $allowance = $table_cal_result["Allowance"];
                $otherearning = $table_cal_result["Other_Earning"];
                $extra1 = $table_cal_result["Extra_Hour1"];
                $extra2 = $table_cal_result["Extra_Hour2"];
                $ordinary = $table_cal_result["Ordinary"];
                $payment_type = $table_cal_result["Payment_Type"];
                $salary = $table_cal_result["Salary"];
                $gross_salary = $table_cal_result["Gross_Salary"];

                $loan = $table_cal_result["Loan"];
                $assessment = $table_cal_result["Assessment"];
                $other_deduction = $table_cal_result["Other_Deduction"];
                $tax = $table_cal_result["Tax"];
                $total_deduction = $table_cal_result["Total_Deduction"];

                $net_pay = $table_cal_result["Net_Pay"];



                /*Calculating Currency Exchange Rate With Earnings*/
                $exchange_rate_bonus = $table_cal_result["Exchange_Rate_Bonus"];
                $exchange_rate_comission = $table_cal_result["Exchange_Rate_Comission"];
                $exchange_rate_allowance = $table_cal_result["Exchange_Rate_Allowance"];
                $exchange_rate_otherearning = $table_cal_result["Exchange_Rate_Other_Earning"];
                $exchange_rate_extra1 = $table_cal_result["Exchange_Rate_Extra_Hour1"];
                $exchange_rate_extra2 = $table_cal_result["Exchange_Rate_Extra_Hour2"];
                $exchange_rate_ordinary = $table_cal_result["Exchange_Rate_Ordinary"];
                /*Ending of Currency Exchange Rate With Earnings Calculation*/

                $history_earning_status = $table_cal_result["Status"];

                $basic_salary = $table_cal_result["Basic_Salary"];


                /*Calculating extra hours*/
                $extra1_total = $table_cal_result["Total_Extra_Hour1"];
                $extra2_total = $table_cal_result["Total_Extra_Hour2"];
                $total_ordinary = $table_cal_result["Total_Ordinary"];
                /*Ending of calculating extra hours*/

                $total_social_security = $table_cal_result["Total_SOS"];
                $total_association = $table_cal_result["Total_ASO"];


                $social_rate = $table_cal_result["SOS"];
                $association_rate = $table_cal_result["ASO"];


                $employee_link = '<a class="info" style="font-size: 15px" href="' . $this->web_data["Web_Url"] . 'view-employee?employee_id=' . $table_cal_result["Employee_ID"] . '"><b>' . $table_cal_result["First_Name"] . ' ' . $table_cal_result["Last_Name"] . '</b> </a>';
                //$employee_link= '';

                //var_dump($table_cal_result);

                $history_earning_data = array();
                $history_earning_data[] = $table_cal_result["Emp_ID"];
                $history_earning_data[] = $employee_link;
                $history_earning_data[] = number_format($exchange_rate_bonus, 2);
                $history_earning_data[] = number_format($exchange_rate_comission, 2);
                $history_earning_data[] = number_format($exchange_rate_allowance, 2);
                $history_earning_data[] = number_format($exchange_rate_otherearning, 2);
                $history_earning_data[] = number_format($extra1_total, 2) . ' (' . $extra1 . ')';
                $history_earning_data[] = number_format($extra2_total, 2) . ' (' . $extra2 . ')';
                $history_earning_data[] = number_format($total_ordinary, 2) . ' (' . $ordinary . ')';
                $history_earning_data[] = number_format($loan, 2);
                $history_earning_data[] = number_format($assessment, 2);
                $history_earning_data[] = number_format($other_deduction, 2);
                $history_earning_data[] = number_format($basic_salary, 2);
                $history_earning_data[] = number_format($gross_salary, 2);
                $history_earning_data[] = number_format($net_pay, 2);
                $history_earning_data[] = date($this->localization["Date_Format"], strtotime($table_cal_result["Dates"]));
                $data[] = $history_earning_data;
            }
        }

        $history_payroll_list_result_output = array(

            "draw"  => intval($_POST["draw"]),
            "recordsTotal" => intval($total_history_earning_data),
            "recordsFiltered" => intval($total_history_earning_filter),
            "data" => $data,
        );

        echo json_encode($history_payroll_list_result_output);
    }


    public function LoadLeaveReport($leave_report_employee_id)
    {

        $employee_vacation_report_display_result = '';
        $sn = 0;
        $netpay12 = 0;

        $employee_query = $this->data_manager->EmployeesDataByID($leave_report_employee_id)->first();
        $department_result = $this->data_manager->DepartmentDataByID($employee_query["Department"])->first();

        $first_name = $employee_query['First_Name'];
        $last_name = $employee_query['Last_Name'];
        $employee_id = $employee_query['Employee_ID'];
        $employee_input_id = $employee_query['Emp_ID'];
        $nationality = $employee_query['Nationality'];
        $currency = $employee_query['Currency'];
        $payment_type = $employee_query['Payment_Type'];


        $leave_data_query = $this->_query->query('SELECT * FROM employee_available_leave WHERE Subscriber_ID = ? AND Employee_ID = ? AND Status = ?', array(Classes_Session::get("Loggedin_Session"), $leave_report_employee_id, 'Active'));
        $avaliable_leave_data = $leave_data_query->first();
        $leave_data_count = $leave_data_query->count();
        $total_available_leave = $avaliable_leave_data["Total_Available_Leave"];


        $leave_day_asked_data = $this->_query->query('SELECT SUM(Days_Asked) AS Days_Asked FROM employee_leave WHERE Subscriber_ID = ? AND Employee_ID = ? AND Status = ?', array(Classes_Session::get("Loggedin_Session"), $leave_report_employee_id, 'Active'))->first();
        $days_asked = $leave_day_asked_data["Days_Asked"];

        $days_asked = $days_asked > 0 ? $days_asked : 0;
       
        $available = $total_available_leave - $days_asked;


        $leave_query_results = $this->_query->query('SELECT * FROM employee_leave WHERE Subscriber_ID = ? AND Employee_ID = ? AND Status = ? ORDER BY Created_Date DESC LIMIT 3', array(Classes_Session::get("Loggedin_Session"), $leave_report_employee_id, 'Active'))->results();


        $employee_vacation_report_display_result .= '
            <section class="card">
                <div id="invoice-template" class="card-body printableArea">
                    <!--  Company Details -->
                    <div id="invoice-customer-details" class="row pt-2">
                        <div class="col-md-6 col-sm-12 text-center text-md-left">
                            <ul class="px-0 list-unstyled" style="color: black">
                                <li class="text-bold-800"><b>' . $this->company_data["Company_Name"] . '</b></li>
                                <li><b>ACCION DE PERSONAL</b></li>
                                <li><b>DISFRUTE DE VACACIONS</b></li>
                            </ul>
                        </div>
                    </div>
                    <hr/>
                    <!--/ Employee Details -->
                    <div id="invoice-items-details" class="pt-2">
                        <div class="row">
                            <div class="table-responsive col-sm-12">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID:</th>
                                            <th>' . $employee_input_id . '</th>
                                            <th class="text-right">Full Name:</th>
                                            <th class="text-right">' . $first_name . ' ' . $last_name . '</th>
                                        </tr>
                                    </thead>
                                    <thead>
                                        <tr>
                                            <th>Nationality:</th>
                                            <th>' . $nationality . '</th>
                                            <th class="text-right">Department</th>
                                            <th class="text-right">' . $department_result["Department_Name"] . '</th>
                                        </tr>
                                    </thead>
                                    <tbody>';

                                    foreach ($leave_query_results as $key => $leave_query_result) {

                                        $day_asked = $leave_query_result["Days_Asked"];
                                        $created_date = $leave_query_result["Created_Date"];
                                        $enjoy_date = $leave_query_result["Enjoy_Date"];

                                        $day_asked = $day_asked > 1 ? $day_asked.' Days' : $day_asked.' Day';

                                        $enjoy_date_from_date = substr($enjoy_date, 0, -12);
                                        $enjoy_date_to_date = substr($enjoy_date, 12);

                                        $enjoy_date_from_date = date($this->localization["Date_Format"], strtotime($enjoy_date_from_date));
                                        $enjoy_date_to_date = date($this->localization["Date_Format"], strtotime($enjoy_date_to_date));

                                        $employee_vacation_report_display_result .= '
                                        <tr>
                                            <th scope="row">DAYS ASKED:</th>
                                            <td class="text-right">' . $day_asked . '</td>
                                            <td class="text-right" colspan="5"></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">FROM:</th>
                                            <td class="text-right">' . $enjoy_date_from_date . '</td>
                                            <td class="text-right">TO:</td>
                                            <td class="text-right">' . $enjoy_date_to_date . '</td>
                                        </tr>';
                                    }
                                    $employee_vacation_report_display_result .= '
                                    </tbody>
                                </table>
                            </div>
                        </div>
                                
                            <center>
                            <div class="row">
                                <div class="col-md-6"><b>Available Day: ' . $total_available_leave . '</b></div>
                                
                                <div class="col-md-6"><b>Day Asked: ' . $days_asked . '</b></div>
                            </div>
                            </center>

                            <div class="row">
                                <div class="col-md-7 col-sm-12 text-center text-md-left">
                                    <br/><br/><br/>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <table class="table table-borderless table-sm">
                                                <tbody>
                                                <tr>
                                                    <td>______________________________________</td>
                                                </tr>
                                                <tr>
                                                    <td>&emsp;&emsp;&emsp;Boss Signature</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5 col-sm-12">
                                    <br/><br/><br/>
                                    <div class="table-responsive">
                                        <table class="table table-borderless table-sm">
                                            <tbody>
                                            <tr>
                                                <td>______________________________________</td>
                                            </tr>
                                            <tr>
                                                <td>&emsp;&emsp;&emsp;Employee Signature</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>

                <div class="row col-md-12 col-sm-12 text-center">
                    <div class="col-md-4 col-sm-12 text-center">
                        <button type="button" class="btn btn-danger btn-lg my-1" id="print"><i class="la la-print"></i> Print</button>
                    </div>
                    <div class="col-md-4 col-sm-12 text-center">
                        <button type="button" class="btn btn-success btn-lg my-1 leave_report_pdf_btn" id="' . $leave_report_employee_id . '"><i class="la la-download"></i> Download PDF</button>
                    </div>
                    <div class="col-md-4 col-sm-12 text-center">
                        <button type="button" class="btn btn-info btn-lg my-1 leave_report_email_btn" id="' . $leave_report_employee_id . '"><i class="la la-paper-plane-o"></i> Send to Mail</button>
                    </div>
                </div>
            </section>';

        echo ($employee_vacation_report_display_result);
    }


    public function MailLeaveReport($earning_id)
    {
        $this->leave_report_mail->LeaveReportMail($earning_id);
    }


    public function DownloadLeaveReport($earning_id)
    {
        $response = $this->leave_report_mail->LeaveReportDownload($earning_id);
    }

    
    public function LoadSalaryLetter($salary_letter_employee_id)
    {

        $employee_salary_letter_display_result = '';
        $sn = 0;
        $netpay12 = 0;

        $employee_query = $this->data_manager->EmployeesDataByID($salary_letter_employee_id)->first();
        $department_result = $this->data_manager->DepartmentDataByID($employee_query["Department"])->first();


        $currency_results = $this->data_manager->CurrencyDataByID($employee_query["Currency"])->first();
        $marital_results = $this->data_manager->MaritalDataByID($employee_query["Marital"])->first();
        $family_tax_results = $this->data_manager->FamilyTaxDataByID($employee_query["Kids"])->first();
        $social_results = $this->data_manager->SocialSecurityDataByID($employee_query["Social_Security"])->first();
        $association_tax_results = $this->data_manager->AssociationDataByID($employee_query["Association"])->first();



        $first_name = $employee_query['First_Name'];
        $last_name = $employee_query['Last_Name'];
        $employee_id = $employee_query['Employee_ID'];
        $employee_input_id = $employee_query['Emp_ID'];
        $salary = $employee_query['Salary'];
        $currency_name = $currency_results['Currency_Name'];
        $currency_symbol = $currency_results['Currency_Symbol'];
        $position = $employee_query['Position'];
        $hire_date = $employee_query['HireDate'];
        $social_rate = $social_results['Rate'];
        $association_rate = $association_tax_results['Association'];

        $payment_type = $employee_query['Payment_Type'];
        $city = $employee_query['City'];
        $gender = $employee_query['Gender'];



        $total_social_security = $salary * $social_rate / 100;
        $total_association = $salary * $association_rate / 100;


        $gender = $gender == 'Female' ? 'La señora' : 'El señor';

        $addresss = wordwrap($this->company_data["Company_Address"], 45, "<br/>", false);


        $ded_sos_aso = $total_association + $total_social_security;
        $total = $salary - $ded_sos_aso;


        $current_date = Date("Y-m-d");

        $hire_date_month = substr($hire_date, 5, -3);
        $hire_date_year = substr($hire_date, 0, -6);
        $hire_date_day = substr($hire_date, 8);

        $hire_date_month_name = date('F', mktime(0,0,0, $hire_date_month, 10));


        $employee_salary_letter_display_result .= '
        <section class="card">
            <div id="invoice-template" class="card-body printableArea">
                <!-- Invoice Company Details -->
                <div id="invoice-company-details" class="row">
                    <div class="col-md-6 col-sm-12 text-center text-md-left">
                        <div class="media">
                            <img style="width: 120px; height: 100px" src="' . $this->web_data["Web_Url"] . 'Folders/Company_Folders/' . Classes_Session::get('Loggedin_Session') . '/Logo/' . $this->theme_data["Logo"] . '" alt="" class="" />
                            <div class="media-body">
                                <ul class="ml-2 px-0 list-unstyled">
                                    <li class="text-bold-800">' . $this->company_data["Company_Name"] . ',</li>
                                    <li class="text-bold-800">' . $this->company_data["Company_ID"] . ',</li>
                                    <li>' . $addresss . ',</li>
                                    <li>' . $this->company_data["Company_Phone"] . '.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Invoice Company Details -->
            
              <center><h2 data-i18n="constance_of_salary"> <b> CONSTANCE OF SALARY</b></h2> </center>

              <br/><br/><br/>
                <!-- Invoice Items Details -->
                <div id="invoice-items-details" class="pt-2">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 text-center text-md-left" style="line-height:1.8">
                            <h7 data-i18n="salary1">By this means, the company</h7> <b>' . $this->company_data["Company_Name"] . '</b>, <h7 data-i18n="salary2">legal note No.</h7> <b>' . $this->company_data["Company_ID"] . '</b>
                            <h7 data-i18n="salary3">it states that</h7> ' . $gender . ' <b>' . $first_name . ' ' . $last_name . '</b>, <h7 data-i18n="salary4">bearer of identity card No </h7> <b>' . $employee_input_id . '</b> 
                            <h7 data-i18n="salary5">receive a gross monthly income of </h7> <b>' . $currency_symbol . '' . number_format($salary, 2) . '</b> ' . $currency_name . ' <p> 
                            ' . $gender . ' <b>' . $last_name . '</b> <h7 data-i18n="is"> is </h7> <b>' . $position . '</b> <h7 data-i18n="salary6">from the</h7> <b> ' . $hire_date_day . ' <h7 data-i18n="of">of</h7> ' . $hire_date_month_name . ' <h7 data-i18n="of">of</h7> ' . $hire_date_year . '</b>,
                            <h7 data-i18n="salary7">and the following are the calculations of your income:</h7>
                        </div>

                        <div class="col-md-7 col-sm-12"></div>
                        <div class="col-md-5 col-sm-12"><br/><br/><br/>
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td data-i18n="gross_monthly_salary">Gross Monthly Salary:</td>
                                            <td class="text-right">' . $currency_symbol . '' . number_format($salary, 2) . '</td>
                                        </tr>
                                        <tr>
                                            <td>Menos: ' . $social_rate . '% C.C.S.S.: </td>
                                            <td class="text-right">' . $currency_symbol . '' . number_format($total_social_security, 2) . '</td>
                                        </tr>
                                        <tr>
                                            <td class="text-bold-800" data-i18n="net_monthly_income">Net Monthly Income</td>
                                            <td class="text-bold-800 text-right"> <b>' . $currency_symbol . '' . number_format($total, 2) . '</b></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Invoice Footer -->
                <div id="invoice-footer">
                    <div class="row">
                        <div class="col-md-7 col-sm-12">
                        <h7 data-i18n="given_in">Given in</h7> ' . $city . ', <h7 data-i18n="to_the"> to the</h7> ' . date("d") . ' <h7 data-i18n="day_of_month">days of the month</h7> ' . date("F") . ' of ' . date("Y") . ' </p>
                        </div>

                        

                        <div class="col-md-7 col-sm-12">
                        </div>
                        <div class="col-md-4 col-sm-12">
                        <br/><br/><br/>
                            <div class="text-center">
                                <p><b data-i18n="authorize_sign">Authorized Person</b></p>
                                <br/><br/><br/>

                                <b><hr/></b>
                                <h6><b>' . $this->company_data["Company_Sign_Name"] . '</b></h6>
                                <p class="text-muted"><b>' . $this->company_data["Company_Sign_Position"] . '</b></p>
                            </div>
                            </div>

                            <center><br/><br/><br/><b>' . strtoupper($this->company_data["Company_Website"]) . ', ' . strtoupper($this->company_data["Company_Address"]) . ', ' . strtoupper($this->company_data["Company_Phone"]) . '</b></center>
                        </div>
                    </div>
                    <!--/ Invoice Footer -->
                </div>
            </div>

             <div class="row col-md-12 col-sm-12 text-center">
                <div class="col-md-4 col-sm-12 text-center">
                    <button type="button" class="btn btn-danger btn-lg my-1" id="print"><i class="la la-print"></i> Print</button>
                </div>
                <div class="col-md-4 col-sm-12 text-center">
                    <button type="button" class="btn btn-success btn-lg my-1 salary_letter_pdf_btn" id="' . $salary_letter_employee_id . '"><i class="la la-download"></i> Download PDF</button>
                </div>
                <div class="col-md-4 col-sm-12 text-center">
                    <button type="button" class="btn btn-info btn-lg my-1 salary_letter_email_btn" id="' . $salary_letter_employee_id . '"><i class="la la-paper-plane-o"></i> Send to Mail</button>
                </div>
            </div>
        </section>
        ';

        echo ($employee_salary_letter_display_result);
    }


    public function MailSalaryLetter($earning_id)
    {
        $this->salary_letter_mail->SalaryLetterMail($earning_id);
    }


    public function DownloadSalaryLetter($earning_id)
    {
       $this->salary_letter_mail->SalaryLetterDownload($earning_id);
    }


    public function LoadJournalReport($journal_report_date){
        $payroll_journal_report_view ='';

        $journal_query = $this->_query->query("SELECT * FROM earning Where Subscriber_ID = ? AND Dates = ? AND Status = ?", array(Classes_Session::get("Loggedin_Session"), $journal_report_date, 'Active'));
        $journal_query_result = $journal_query->first();

        $end_date = $journal_query_result["End_Date"];

        $payroll_journal_report_view .= '
        <section id="file-export">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="printableArea">
                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard">
                                    <div class="row">
                                        <div class="col-md-4"></div>
                                        <div class="col-md-12 col-md-7">
                                            <center><h4><b>Journal Report For: ' . $journal_report_date . ' - ' . $end_date . '</b></h4></center>
                                        </div>
                                    </div>
                                    <br/><br/>
                                    <table class="table table-striped table-bordered file-export">
                                        <thead>
                                            <tr>
                                                <th>S/N</th>
                                                <th>Accounting Code</th>
                                                <th>Accounting Name</th>
                                                <th class="text-right">Debits</th>
                                                <th class="text-right">Credits</th>
                                            </tr>
                                        </thead>
                                        <tbody>';
                                        $journal_query_results = $journal_query->results();
                                         
                                        $gross_salary_final=0; $social_security_final=0; $total_association=0; $association_final=0; $basic_salary_final=0;
                                        $tax_final=0; $loan_final=0; $assessment_final=0; $other_deduction_final=0; $extra1_final=0;
                                        $extra2_final=0; $total_ordinary_final=0; $bonus_final=0; $comission_final=0; $allowance_final=0;
                                        $other_earning_final=0;

                                        $total_deduction_footer = 0; $netpay = 0; $deduction = 0; $gross_salary_final = 0; $total_earning = 0;
                                        foreach ($journal_query_results as $key => $journal_query_result) {

                                            $table_cal_result =  Classes_PayrollTable::TableCalculator($journal_query_result);

                                            $marital_amount = $table_cal_result['Married_Amount'];
                                            $kid_amount = $table_cal_result['Kid_Amount'];

                                            $exchange_rate = $table_cal_result["Exchange_Rate"];
                                            $bonus = $table_cal_result["Bonus"];
                                            $comission = $table_cal_result["Comission"];
                                            $allowance = $table_cal_result["Allowance"];
                                            $otherearning = $table_cal_result["Other_Earning"];
                                            $extra1 = $table_cal_result["Extra_Hour1"];
                                            $extra2 = $table_cal_result["Extra_Hour2"];
                                            $ordinary = $table_cal_result["Ordinary"];
                                            $payment_type = $table_cal_result["Payment_Type"];
                                            $salary = $table_cal_result["Salary"];
                                            $gross_salary = $table_cal_result["Gross_Salary"];

                                            $loan = $table_cal_result["Loan"];
                                            $assessment = $table_cal_result["Assessment"];
                                            $other_deduction = $table_cal_result["Other_Deduction"];
                                            $tax = $table_cal_result["Tax"];
                                            $total_deduction = $table_cal_result["Total_Deduction"];

                                            $net_pay = $table_cal_result["Net_Pay"];


                                            /*Calculating Currency Exchange Rate With Earnings*/
                                            $exchange_rate_bonus = $table_cal_result["Exchange_Rate_Bonus"];
                                            $exchange_rate_comission = $table_cal_result["Exchange_Rate_Comission"];
                                            $exchange_rate_allowance = $table_cal_result["Exchange_Rate_Allowance"];
                                            $exchange_rate_otherearning = $table_cal_result["Exchange_Rate_Other_Earning"];
                                            $exchange_rate_extra1 = $table_cal_result["Exchange_Rate_Extra_Hour1"];
                                            $exchange_rate_extra2 = $table_cal_result["Exchange_Rate_Extra_Hour2"];
                                            $exchange_rate_ordinary = $table_cal_result["Exchange_Rate_Ordinary"];
                                            /*Ending of Currency Exchange Rate With Earnings Calculation*/

                                            $history_earning_status = $table_cal_result["Status"];

                                            $basic_salary = $table_cal_result["Basic_Salary"];


                                            /*Calculating extra hours*/
                                            $extra1_total = $table_cal_result["Total_Extra_Hour1"];
                                            $extra2_total = $table_cal_result["Total_Extra_Hour2"];
                                            $total_ordinary = $table_cal_result["Total_Ordinary"];
                                            /*Ending of calculating extra hours*/

                                            $total_social_security = $table_cal_result["Total_SOS"];
                                            $total_association = $table_cal_result["Total_ASO"];


                                            $social_rate = $table_cal_result["SOS"];
                                            $association_rate = $table_cal_result["ASO"];


                                            $basic_salary_final+=$basic_salary; $loan_final+= $loan; $assessment_final+=$assessment;
                                            $other_deduction_final+=$other_deduction; $extra1_final+= $extra1_total; $extra2_final+= $extra2_total;
                                            $gross_salary_final+=$gross_salary; $social_security_final+= $total_social_security; $association_final+= $total_association; 
                                            $tax_final+=$tax; $total_ordinary_final+= $total_ordinary; $bonus_final+= $exchange_rate_bonus; 
                                            $comission_final+= $exchange_rate_comission; $allowance_final+= $exchange_rate_allowance;

                                            $exchange_rate_otherearning_with_out_neg = abs($exchange_rate_otherearning);

                                            $other_earning_final+= $exchange_rate_otherearning < 0 ? $exchange_rate_otherearning : $exchange_rate_otherearning_with_out_neg;
                                            
                                            $deduction = $loan_final + $assessment_final + $other_deduction_final + $social_security_final + $association_final + $tax_final;

                                            $netpay = $gross_salary_final - $deduction;
                                            
                                        }
                                        $total_deduction_footer = $deduction + $netpay;
                                        $total_earning = 0;
                                        $array_payroll_data = number_format($basic_salary_final, 2) . "=" . number_format($bonus_final, 2) . "=" . number_format($comission_final, 2) . "=" . number_format($allowance_final, 2) . "=" . number_format($other_earning_final, 2) . "=" . number_format($extra1_final, 2) . "=" . number_format($extra2_final, 2) . "=" . number_format($total_ordinary_final, 2) . "=" . number_format($loan_final, 2) . "=" . number_format($assessment_final, 2) . "=" . number_format($other_deduction_final, 2) . "=" . number_format($association_final, 2) . "=" . number_format($social_security_final, 2) . "=" . number_format($tax_final, 2) . "=" . number_format($netpay, 2);

                                        $credit=''; $debit=''; $total_debit=0; $total_credit=0;

                                        $journal_data = $this->data_manager->JournalData()->first();

                                        $accounting_codes = explode(",", $journal_data["Accounting_Code"]);
                                        $accounting_name = explode(",", $journal_data["Accounting_Name"]);
                                        $array_payroll_data = explode("=", $array_payroll_data);


                                        $itetation = 0;
                                        foreach ($accounting_codes as $key => $accounting_code) {
                                            $itetation++;
           
                                            $payroll_data_value = $array_payroll_data[$key];
            
                                            if(0 <= $itetation && $itetation <= 8){
                                                $debit = $array_payroll_data[$key];
                                                $total_debit+=$debit;
                
                                            } elseif ($itetation > 8) {
                                                $credit = $array_payroll_data[$key];
                                                $debit = '';
                                                $total_credit += $credit;
                                            }

                                            $payroll_journal_report_view .= '
                                                <tr>
                                                    <td>' . $itetation . '</td>
                                                    <td>' . $accounting_code . '</td>
                                                    <td>' . $accounting_name[$key] . '</td>
                                                    <td class="text-right">' . $debit . '</td>
                                                    <td class="text-right">' . $credit . '</td>
                                                </tr>';

                                        }


                $payroll_journal_report_view .= '
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>S/N</th>
                                                <th>Accounting Code</th>
                                                <th>Accounting Name</th>
                                                <th class="text-right">' . number_format($gross_salary_final, 2) .'</th>
                                                <th class="text-right">'. number_format($total_deduction_footer, 2). '</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <center>
                            <div class="row">
                                <div class="row col-md-12 col-sm-12 text-center">
                                    <div class="col-md-6 col-sm-12 text-center">
                                        <button type="button" class="btn btn-danger btn-lg my-1" id="print"><i class="la la-print"></i> Print</button>
                                    </div>
                                    <div class="col-md-6 col-sm-12 text-center">
                                        <button type="button" class="btn btn-success btn-lg my-1 journal_report_pdf_btn" id="' . $journal_report_date . '"><i class="la la-download"></i> Download PDF</button>
                                    </div>
                                </div>
                            </div>
                        </center>
                    </div>
                </div>
            </div>
        </section>';

        echo ($payroll_journal_report_view);

        //echo json_encode($employee_aguinaldo_display_result);
    }


    public function DownloadJournalReport($journal_report_date)
    {
        $this->journal_mail->JournalReportDownload($journal_report_date);
    }
}
