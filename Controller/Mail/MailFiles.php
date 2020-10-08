<?php

class Controller_Mail_MailFiles
{
    public function __construct()
    {
        $this->_query = Classes_Db::getInstance();
        $this->data_manager = new Controller_Company_Default_Datamanagement();
        $this->company_data_f = $this->data_manager->CompanyDataByID()->first();
        $this->web_data = $this->data_manager->WebData()->first();
        $this->theme_data = $this->data_manager->ThemeData()->first();
        $this->localization_data = $this->data_manager->LocalizationData()->first();
    }



    public function InvoiceFile($invoice_id){

        $invoicedata = $this->data_manager->InvoiceData($invoice_id)->first();

        $invoice_item_data = $this->data_manager->InvoiceItemData($invoice_id)->results();
        $client_datas_by_id = $this->data_manager->ClientDataByID($invoicedata["Client_ID"])->first();
    

        $output = '';

            $output.= '
                <div class="content-body" style="background-color:white">
                    <section class="card">
                        <div id="invoice-template" class="card-body">
                            <!-- Invoice Company Details -->
                            
                            <div class="row">
                                <div class="col-md-6 col-sm-7 col-xl-8 ">
                                    <div class="media">
                                        <img style="width: 120px; height: 100px" src="../../Folders/Company_Folders/' . Classes_Session::get("Loggedin_Session") . '/Logo/' . $this->theme_data["Logo"] . '" alt="" class="" />
                                        <div class="media-body">
                                            <ul class="ml-6 px-0 list-unstyled" style="margin-left: 10rem">
                                                <li class="text-bold-800">' . $this->company_data_f["Company_Name"] . '</li>
                                                <li>' . wordwrap($this->company_data_f["Company_Address"], 35, "<br/>", false) . '</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 text-right">
                                    <h2>INVOICE</h2>
                                    <p class="text-bold-700">#INV-' . $invoicedata["Invoice_ID"] . '</p>
                                </div>
                            </div>

                                
                            <div class="row " style="padding-top:5px">
                                <div class="col-sm-12 text-left">
                                    <p class="text-muted">Invoice To</p>
                                </div>
                                <div class="col-md-6 col-sm-12 text-left">
                                    <ul class="px-0 list-unstyled"><br /><br />
                                        <li class="text-bold-800">'.$client_datas_by_id["Contact_Person"].'</li>
                                        <li>'. wordwrap($invoicedata["Client_Address"], 35, "<br/>", false).'</li>
                                    </ul>
                                </div>
                                <div class="col-md-6 col-sm-12 text-right">
                                    <p>
                                        <span class="text-muted">Invoice Date :</span> '. date($this->localization_data["Date_Format"], strtotime($invoicedata["Invoice_Date"])).'</p>

                                    <span class="text-muted">Due Date :</span>'.date($this->localization_data["Date_Format"], strtotime($invoicedata["Invoice_Due_Date"])). '</p>
                                </div>
                            </div>

                            <!--/ Invoice Customer Details -->
                            <!-- Invoice Items Details -->
                            <div id="invoice-items-details" >
                                <div class="row">
                                    <div class="table-responsive col-sm-12">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Item</th>
                                                    <th>Description</th>
                                                    <th class="text-left">Cost</th>
                                                    <th class="text-left">Qty</th>
                                                    <th class="text-left">Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                                                
                                                $iterate = 0;
                                                $total_amount = 0;
                                                foreach ($invoice_item_data as $key => $invoice_item_data_value) {
                                                    $iterate++;
                                                    $total_amount += $invoice_item_data_value["Amount"];
                                            
                                                $output.='
                                                    <tr>
                                                        <th scope="row">'.$iterate.'</th>
                                                        <td>'.$invoice_item_data_value["Item_Name"].'</td>
                                                        <td>'.$invoice_item_data_value["Description"].'</td>
                                                        <td class="text-left">'. $this->localization_data["Currency_Symbol"].''.number_format($invoice_item_data_value["Cost"], 2).'</td>
                                                        <td class="text-left">'.$invoice_item_data_value["Quantity"]. '</td>
                                                        <td class="text-left">' . $this->localization_data["Currency_Symbol"] . ''.number_format($invoice_item_data_value["Amount"], 2).'</td>
                                                    </tr>';
                                                
                                                }
                                        
                                            $output .= '
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5 col-sm-4 text-right">
                                        <br /><br />
                                        <p class="lead">Total due</p>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tbody>';

                                                    $discount = $invoicedata["Invoice_Discount"];
                                                    $discount_per = $discount / 100;
                                                    $total_discount = $total_amount * $discount_per;
                                                    if (!empty($invoicedata["Invoice_Discount"])) {
                                                    $output.='<tr>
                                                            <td>Discount ('.$invoicedata["Invoice_Discount"]. '%)</td>
                                                            <td class="text-right">' . $this->localization_data["Currency_Symbol"] . ''.number_format($total_discount, 2).'</td>
                                                        </tr>';
                                                    }

                                                $output .= '<tr>
                                                        <td class="text-bold-800">Total</td>
                                                        <td class="text-bold-800 text-right">' . $this->localization_data["Currency_Symbol"] . ''.number_format($invoicedata["Total"], 2).'</td>
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
                                    <br /><br /><br />
                                        <h6>Other Description</h6>
                                        <p>'.$invoicedata["Other_Description"]. '</p>
                                    </div>
                                </div>
                            </div>
                            <!--/ Invoice Footer -->
                        </div>
                    </section>
                </div>';
      
        return $output;
    }
           





    public function PaymentProofHTML($single_manage_payroll_select_id){
        $employee_payment_proof_record_view = '';

        $earning_result = $this->_query->query("SELECT * FROM earning WHERE ID = ? ORDER BY ID DESC", array($single_manage_payroll_select_id))->first();


        $employee_data_values = $this->data_manager->EmployeesDataByID($earning_result["Employee_ID"])->first();
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

        $format_view = '';

        $start_date = $earning_result["Dates"];
        $end_date = $earning_result["End_Date"];
        $earning_id = $earning_result["ID"];

        $payment_type_view = $payment_type == 30 ? "Monthly" : $payment_type == 15 ? "Semi-Monthly" : "Weekly";


        $employee_payment_proof_record_view .= '
            <div class="printableArea" style="background-color:white">
                <section class="card" style="background-color:white">
                    <div id="invoice-template" class="card-body">
                        <!-- Invoice Company Details -->

                            <div class="row" style="padding-bottom:1px">
                                <div class="col-md-6 col-sm-7 col-xl-8 ">
                                    <div class="media">
                                        <img style="width: 120px; height: 100px" src="../../Folders/Company_Folders/' . Classes_Session::get("Loggedin_Session") . '/Logo/' . $this->theme_data["Logo"] . '" alt="" class="" />
                                        <div class="media-body">
                                            <ul class="ml-6 px-0 list-unstyled" style="margin-left: 10rem">
                                                <li class="text-bold-800">' . $this->company_data_f["Company_Name"] . '</li>
                                                <li>' . wordwrap($this->company_data_f["Company_Address"], 35, "<br/>", false) . '</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 text-right">
                                    <h2>Employee ID</h2>
                                    <p class="text-bold-700">' . $employee_input_id . '</p>
                                </div>
                            </div>

                        <!--/ Invoice Company Details -->
                        <!-- Invoice Customer Details -->
                        <div class="row " style="padding-top:1px">
                                <div class="col-sm-12 text-left">
                                    <p class="text-bold-800">Employee Name: ' . $first_name . ' ' . $last_name . '</p>
                                <p class="text-bold-800">Employee ID: ' . $employee_input_id . '</p>
                                <p class="text-bold-800">Designation: ' . wordwrap($address, 35, "<br/>", false) . '</p>
                                </div>
                                <div class="col-md-6 col-sm-12 text-right">
                                    
                                </div>
                            </div>

                        <!--/ Invoice Customer Details -->
                        <!-- Invoice Items Details -->

                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">

                                        <div class="col-md-4">
                                            <p><b>Payment Type: ' . $payment_type_view . '</b></p>
                                        </div>

                                        <div class="col-md-4">
                                            <p><b>' . $currency_type . ' ( ' . $currency_code . ' )</b></p>
                                        </div>
                    
                                        <div class="col-md-4">
                                            <p><b>Date: ' . date($this->localization_data["Date_Format"], strtotime($start_date))  . ' - ' . date($this->localization_data["Date_Format"], strtotime($end_date)) . '</b></p>
                                        </div>
                                <div id="invoice-items-details" class="pt-2">
                                    <div class="row">
                                       
                                        <div class="table-responsive col-sm-12" style="padding-top: 10px">
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


                                                        $employee_payment_proof_record_view .= '
                                                        <tr>
                                                            <td>Basic Salary</td>
                                                            <td>-----</td>
                                                            <td class="text-right">' . $currency_code . ' ' . number_format($basic_salary, 2) . '</td>
                                                            <td>Social Security ' . $social_rate . '%</td>
                                                            <td class="text-right">' . $currency_code . ' ' . number_format($total_social_security, 2) . '</td>
                                                            </tr>

                                                            <tr>
                                                            <td>Extra Hours 1.5</td>
                                                            <td>' . $extra1 . '</td>
                                                            <td class="text-right">' . $currency_code . ' ' . number_format($extra1_total, 2) . '</td>
                                                            <td>Salary Tax</td>
                                                            <td class="text-right">' . $currency_code . ' ' . number_format($tax, 2) . '</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Extra Hours 2.0</td>
                                                            <td>' . $extra2 . '</td>
                                                            <td class="text-right">' . $currency_code . ' ' . number_format($extra2_total, 2) . '</td>
                                                            <td>Loan</td>
                                                            <td class="text-right">' . $currency_code . ' ' . number_format($loan, 2) . '</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Bonus</td>
                                                            <td>-----</td>
                                                            <td class="text-right">' . $currency_code . ' ' . number_format($bonus, 2) . '</td>
                                                            <td>Assessment</td>
                                                            <td class="text-right">' . $currency_code . ' ' . number_format($assessment, 2) . '</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Comission</td>
                                                            <td>-----</td>
                                                            <td class="text-right">' . $currency_code . ' ' . number_format($comission, 2) . '</td>
                                                            <td>Association ' . $association_rate . '%</td>
                                                            <td class="text-right">' . $currency_code . ' ' . number_format($total_association, 2) . '</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Ordinary Days</td>
                                                            <td>' . $ordinary . '</td>
                                                            <td class="text-right">' . $currency_code . ' ' . number_format($total_ordinary, 2) . '</td>
                                                            <td>Others</td>
                                                            <td class="text-right">' . $currency_code . ' ' . number_format($other_deduction, 2) . '</td>
                                                        </tr>

                                                        <tr>
                                                            <td>Allowance</td>
                                                            <td>-----</td>
                                                            <td class="text-right">' . $currency_code . ' ' . number_format($allowance, 2) . '</td>
                                                            <td>-----</td>
                                                            <td class="text-right">-----</td>
                                                        </tr>

                                                        <tr>
                                                            <td>Other Earning</td>
                                                            <td>-----</td>
                                                            <td class="text-right">' . $currency_code . ' ' . number_format($otherearning, 2) . '</td>
                                                            <td>-----</td>
                                                            <td class="text-right">-----</td>
                                                        </tr>

                                                        <tr>
                                                            <td>Gross Salary</td>
                                                            <td>-----</td>
                                                            <td class="text-right">' . $currency_code . ' ' . number_format($gross_salary, 2) . '</td>
                                                            <td>Total Deduction</td>
                                                            <td class="text-right">' . $currency_code . ' ' . number_format($total_deduction, 2) . '</td>
                                                        </tr>

                                                        <tr>
                                                            <td colspan="4"><h3><b>NET Salary</b></h3></td>
                                                            <td class="text-right"><h3><b>' . $currency_code . ' ' . number_format($net_pay, 2) . '</b></h3></td>
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
            </div>';

        return $employee_payment_proof_record_view;
    }





    public function LeaveReportHTML($leave_report_employee_id){

        $employee_vacation_report_display_result = '';

        $employee_query = $this->data_manager->EmployeesDataByID($leave_report_employee_id)->first();
        $department_result = $this->data_manager->DepartmentDataByID($employee_query["Department"])->first();

        $first_name = $employee_query['First_Name'];
        $last_name = $employee_query['Last_Name'];
        $employee_id = $employee_query['Employee_ID'];
        $employee_input_id = $employee_query['Emp_ID'];
        $nationality = $employee_query['Nationality'];


        $leave_data_query = $this->_query->query('SELECT * FROM employee_available_leave WHERE Subscriber_ID = ? AND Employee_ID = ? AND Status = ?', array(Classes_Session::get("Loggedin_Session"), $leave_report_employee_id, 'Active'));
        $avaliable_leave_data = $leave_data_query->first();
        $leave_data_count = $leave_data_query->count();
        $total_available_leave = $avaliable_leave_data["Total_Available_Leave"];


        $leave_day_asked_data = $this->_query->query('SELECT SUM(Days_Asked) AS Days_Asked FROM employee_leave WHERE Subscriber_ID = ? AND Employee_ID = ? AND Status = ?', array(Classes_Session::get("Loggedin_Session"), $leave_report_employee_id, 'Active'))->first();
        $days_asked = $leave_day_asked_data["Days_Asked"];

        $days_asked = $days_asked > 0 ? $days_asked : 0;

        $available = $total_available_leave - $days_asked;


        $leave_query_results = $this->_query->query('SELECT * FROM employee_leave WHERE Subscriber_ID = ? AND Employee_ID = ? AND Status = ? ORDER BY Created_Date DESC LIMIT 3', array(Classes_Session::get("Loggedin_Session"), $leave_report_employee_id, 'Active'))->results();


        $employee_vacation_report_display_result .= '<b></b>
            <section class="card">
                <div id="invoice-template" class="card-body printableArea" style="background-color:white">
                    <!--  Company Details -->
                     <div class="row" style="padding-bottom:1px">
                        <div class="col-md-6 col-sm-7 col-xl-8 ">
                            <div class="media">
                                <img style="width: 120px; height: 100px" src="../../Folders/Company_Folders/' . Classes_Session::get("Loggedin_Session") . '/Logo/' . $this->theme_data["Logo"] . '" alt="" class="" />
                                <div class="media-body">
                                    <ul class="ml-6 px-0 list-unstyled" style="margin-left: 10rem">
                                        <li class="text-bold-800">' . $this->company_data_f["Company_Name"] . '</li>
                                        <li><b>ACCION DE PERSONAL</b></li>
                                        <li><b>DISFRUTE DE VACACIONS</b></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 text-right">
                            
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

                                            $day_asked = $day_asked > 1 ? $day_asked . ' Days' : $day_asked . ' Day';

                                            $enjoy_date_from_date = substr($enjoy_date, 0, -12);
                                            $enjoy_date_to_date = substr($enjoy_date, 12);

                                            $enjoy_date_from_date = date($this->localization_data["Date_Format"], strtotime($enjoy_date_from_date));
                                            $enjoy_date_to_date = date($this->localization_data["Date_Format"], strtotime($enjoy_date_to_date));

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
                                
                            <div class="row col-md-12">
                                <div class="col-md-6" text-left><b>Available Day: ' . $total_available_leave . '</b></div>
                                <div class="col-md-6 text-right"><b>Day Asked: ' . $days_asked . '</b></div>
                            </div>


                            <br/><br/><br/><br/>
                            <div class="row col-md-12">
                                <div class="col-md-6" text-left><b>____________________________</b>
                                <br/><b style="padding-left: 100px">Boss Signature</b>
                                </div>
                                <div class="col-md-6" style="margin-left: 400px"><b>____________________________</b>
                                <br/><b style="margin-left: 200px">Employee Signature</b></div>
                            </div>

                    </div>
                </div>
            </section>';

        return $employee_vacation_report_display_result;
    }




    public function SalaryLetterHTML($salary_letter_employee_id){

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
        $currency_code = $currency_results['Currency_Code'];
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


        $ded_sos_aso = $total_association + $total_social_security;
        $total = $salary - $ded_sos_aso;


        $current_date = Date("Y-m-d");

        $hire_date_month = substr($hire_date, 5, -3);
        $hire_date_year = substr($hire_date, 0, -6);
        $hire_date_day = substr($hire_date, 8);

        $hire_date_month_name = date('F', mktime(0,0,0, $hire_date_month, 10));


        $employee_salary_letter_display_result .= '
        <b></b>
        <section class="card">
            <div id="invoice-template" class="card-body printableArea" style="background-color: white">
                <!-- Invoice Company Details -->

                <div class="row" style="padding-bottom:1px">
                    <div class="col-md-6 col-sm-7 col-xl-8 ">
                        <div class="media">
                            <img style="width: 120px; height: 100px" src="../../Folders/Company_Folders/' . Classes_Session::get("Loggedin_Session") . '/Logo/' . $this->theme_data["Logo"] . '" alt="" class="" />
                            <div class="media-body">
                                <ul class="ml-6 px-0 list-unstyled" style="margin-left: 10rem">
                                    <li class="text-bold-800">' . $this->company_data_f["Company_Name"] . '</li>
                                    <li class="text-bold-800">' . $this->company_data_f["Company_ID"] . ',</li>
                                    <li>' . wordwrap($this->company_data_f["Company_Address"], 45, "<br/>", false) . '</li>
                                    <li>' . $this->company_data_f["Company_Phone"] . '.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                </div>

                <!--/ Invoice Company Details -->
            
              <center><h2 data-i18n="constance_of_salary"> <b> CONSTANCE OF SALARY</b></h2> </center>

              <br/><br/><br/>
                <!-- Invoice Items Details -->
                <div id="invoice-items-details" class="pt-1">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 text-center text-md-left" style="line-height:1.8">
                            <h7 data-i18n="salary1">By this means, the company</h7> <b>' . $this->company_data_f["Company_Name"] . '</b>, <h7 data-i18n="salary2">legal note No.</h7> <b>' . $this->company_data_f["Company_ID"] . '</b>
                            <h7 data-i18n="salary3">it states that</h7> ' . $gender . ' <b>' . $first_name . ' ' . $last_name . '</b>, <h7 data-i18n="salary4">bearer of identity card No </h7> <b>' . $employee_input_id . '</b> 
                            <h7 data-i18n="salary5">receive a gross monthly income of </h7> <b>' . $currency_code . '' . number_format($salary, 2) . '</b> ' . $currency_name . ' <p> 
                            ' . $gender . ' <b>' . $last_name . '</b> <h7 data-i18n="is"> is </h7> <b>' . $position . '</b> <h7 data-i18n="salary6">from the</h7> <b> ' . $hire_date_day . ' <h7 data-i18n="of">of</h7> ' . $hire_date_month_name . ' <h7 data-i18n="of">of</h7> ' . $hire_date_year . '</b>,
                            <h7 data-i18n="salary7">and the following are the calculations of your income:</h7>
                        </div>

                        <div class="col-md-7 col-sm-12"></div>
                        <div class="col-md-5 col-sm-7 text-right" style="margin-left: 250px">
                            <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td class="text-right" data-i18n="gross_monthly_salary">Gross Monthly Salary:</td>
                                            <td class="text-right">' . $currency_code . '' . number_format($salary, 2) . '</td>
                                        </tr>
                                        <tr>
                                            <td class="text-right">Menos: ' . $social_rate . '% C.C.S.S.: </td>
                                            <td class="text-right">' . $currency_code . '' . number_format($total_social_security, 2) . '</td>
                                        </tr>
                                        <tr>
                                            <td class="text-right" class="text-bold-800" data-i18n="net_monthly_income">Net Monthly Income</td>
                                            <td class="text-bold-800 text-right"> <b>' . $currency_code . '' . number_format($total, 2) . '</b></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>


                        
                         <div id="invoice-footer">
                         <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
                        <br/><br/><br/><br/><br/><br/><br/><br/><br/>
                        <div class="row">
                            <div class="col-md-7 col-sm-12">
                                <h7 data-i18n="given_in">Given in</h7> ' . $city . ', <h7 data-i18n="to_the"> to the</h7> ' . date("d") . ' <h7 data-i18n="day_of_month">days of the month</h7> ' . date("F") . ' of ' . date("Y") . ' </p>
                            </div>

                        <div class="col-md-7 col-sm-12">
                        </div>
                        <div class="col-md-5 col-sm-7 text-right" style="margin-left: 300px">
                        <br/><br/>
                            <div class="text-center">
                                <p><b data-i18n="authorize_sign">Authorized Person</b></p>
                                <br/><br/><br/>

                                <b><hr/></b>
                                <h6><b>' . $this->company_data_f["Company_Sign_Name"] . '</b></h6>
                                <p><b>' . $this->company_data_f["Company_Sign_Position"] . '</b></p>
                            </div>
                            </div>

                        </div>
                        <center><br/><br/><b>' . strtoupper($this->company_data_f["Company_Website"]) . ', ' . strtoupper($this->company_data_f["Company_Address"]) . ', ' . strtoupper($this->company_data_f["Company_Phone"]) . '</b></center>

                    </div>
                    <!--/ Invoice Footer -->
                </div>

                        
                    </div>
                </div>
                <!-- Invoice Footer -->
               
            </div>
        </section>
        ';

        return $employee_salary_letter_display_result;

    }





    public function JournalReportHTML($journal_report_date){
        $payroll_journal_report_view = '';

        $journal_query = $this->_query->query("SELECT * FROM earning Where Subscriber_ID = ? AND Dates = ? AND Status = ?", array(Classes_Session::get("Loggedin_Session"), $journal_report_date, 'Active'));
        $journal_query_result = $journal_query->first();

        $end_date = $journal_query_result["End_Date"];

        $payroll_journal_report_view .= '<b></b>
        <section id="file-export" style="background-color:white">
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

        $gross_salary_final = 0;
        $social_security_final = 0;
        $total_association = 0;
        $association_final = 0;
        $basic_salary_final = 0;
        $tax_final = 0;
        $loan_final = 0;
        $assessment_final = 0;
        $other_deduction_final = 0;
        $extra1_final = 0;
        $extra2_final = 0;
        $total_ordinary_final = 0;
        $bonus_final = 0;
        $comission_final = 0;
        $allowance_final = 0;
        $other_earning_final = 0;

        $total_deduction_footer = 0;
        $netpay = 0;
        $deduction = 0;
        $gross_salary_final = 0;
        $total_earning = 0;
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


            $basic_salary_final += $basic_salary;
            $loan_final += $loan;
            $assessment_final += $assessment;
            $other_deduction_final += $other_deduction;
            $extra1_final += $extra1_total;
            $extra2_final += $extra2_total;
            $gross_salary_final += $gross_salary;
            $social_security_final += $total_social_security;
            $association_final += $total_association;
            $tax_final += $tax;
            $total_ordinary_final += $total_ordinary;
            $bonus_final += $exchange_rate_bonus;
            $comission_final += $exchange_rate_comission;
            $allowance_final += $exchange_rate_allowance;

            $exchange_rate_otherearning_with_out_neg = abs($exchange_rate_otherearning);

            $other_earning_final += $exchange_rate_otherearning < 0 ? $exchange_rate_otherearning : $exchange_rate_otherearning_with_out_neg;

            $deduction = $loan_final + $assessment_final + $other_deduction_final + $social_security_final + $association_final + $tax_final;

            $netpay = $gross_salary_final - $deduction;
        }
        $total_deduction_footer = $deduction + $netpay;
        $total_earning = 0;
        $array_payroll_data = number_format($basic_salary_final, 2) . "=" . number_format($bonus_final, 2) . "=" . number_format($comission_final, 2) . "=" . number_format($allowance_final, 2) . "=" . number_format($other_earning_final, 2) . "=" . number_format($extra1_final, 2) . "=" . number_format($extra2_final, 2) . "=" . number_format($total_ordinary_final, 2) . "=" . number_format($loan_final, 2) . "=" . number_format($assessment_final, 2) . "=" . number_format($other_deduction_final, 2) . "=" . number_format($association_final, 2) . "=" . number_format($social_security_final, 2) . "=" . number_format($tax_final, 2) . "=" . number_format($netpay, 2);

        $credit = '';
        $debit = '';
        $total_debit = 0;
        $total_credit = 0;

        $journal_data = $this->data_manager->JournalData()->first();

        $accounting_codes = explode(",", $journal_data["Accounting_Code"]);
        $accounting_name = explode(",", $journal_data["Accounting_Name"]);
        $array_payroll_data = explode("=", $array_payroll_data);


        $itetation = 0;
        foreach ($accounting_codes as $key => $accounting_code) {
            $itetation++;

            $payroll_data_value = $array_payroll_data[$key];

            if (0 <= $itetation && $itetation <= 8) {
                $debit = $array_payroll_data[$key];
                $total_debit += $debit;
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
                                                <th class="text-right">' . number_format($gross_salary_final, 2) . '</th>
                                                <th class="text-right">' . number_format($total_deduction_footer, 2) . '</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>';

        return $payroll_journal_report_view;
    }
}
