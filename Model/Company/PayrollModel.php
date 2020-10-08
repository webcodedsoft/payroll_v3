<?php

class Model_Company_PayrollModel{

    public function __construct()
    {
        $this->_query = Classes_Db::getInstance();
        $this->data_manager = new Controller_Company_Default_Datamanagement();
        $this->payment_proof_mail = new Controller_Mail_PaymentProofMail();
        $this->localization = $this->data_manager->LocalizationData()->first();
        $this->is_login = $this->data_manager->isLogin()->first();
    }



    public function LoadEmployeeEarning($payment_type){
        $earning_input_content ='';

        $employee_data_g = $this->_query->query('SELECT * FROM employee WHERE Subscriber_ID = ? AND Payment_Type = ? AND Status = ?', array(Classes_Session::get('Loggedin_Session'), $payment_type, 'Active'));
        $employee_data_count = $employee_data_g->count();
        $employee_data_values = $employee_data_g->results();

        //var_dump($employee_data_values);

        if($employee_data_count > 0){

        foreach ($employee_data_values as $key => $employee_data_value) {

        $employee_link = '<a class="info" style="font-size: 15px" href="' . $this->web_data["Web_Url"] . 'view-employee?employee_id=' . $employee_data_value["Employee_ID"] . '"><b>' . $employee_data_value["First_Name"] . ' ' . $employee_data_value["Last_Name"] . '</b> </a>';

        $earning_input_content.= '
            <tr>
                <input type="hidden" class="form-control employee_id" name="employee_id" id="employee_id" value="'.$employee_data_value["Employee_ID"].'">
                <td>' . $employee_link . '</td>
                <td><input type="text" class="form-control bonus number_only" name="bonus" id="bonus" placeholder="0"></td>
                <td><input type="text" class="form-control comission number_only" name="comission" id="comission" placeholder="0"></td>
                <td><input type="text" class="form-control allowance number_only" name="allowance" id="allowance" placeholder="0"></td>
                <td><input type="text" class="form-control otherearning number_only" name="otherearning" id="otherearning" placeholder="0"></td>
                <td><input type="text" class="form-control extra1 number_only" name="extra1" id="extra1" placeholder="0"></td>
                <td><input type="text" class="form-control extra2 number_only" name="extra2" id="extra2" placeholder="0"></td>
                <td><input type="text" class="form-control ordinary number_only" name="ordinary" id="ordinary" placeholder="0"></td>
            </tr>';
            }

        } else {
            $earning_input_content.= '<td colspan="10"><center> No Data Available</center></td>';
        }
        echo json_encode(array($earning_input_content));

    }

    public function AddEmployeeEarning($employee_id_s, $bonus_s, $comission_s, $allowance_s, $otherearning_s, $extra1_s, $extra2_s, $ordinary_s, $payment_date_s, $exchange_rate_s){
        
        foreach ($employee_id_s as $key => $value) {
            $employee_id = $employee_id_s[$key];
            $bonus = $bonus_s[$key];
            $comission = $comission_s[$key];
            $allowance = $allowance_s[$key];
            $otherearning = $otherearning_s[$key];
            $extra1 = $extra1_s[$key];
            $extra2 = $extra2_s[$key];
            $ordinary = $ordinary_s[$key];

            $bonus = empty($bonus) ? '0' : $bonus;
            $comission = empty($comission) ? '0' : $comission;
            $allowance = empty($allowance) ? '0' : $allowance;
            $otherearning = empty($otherearning) ? '0' : $otherearning;
            $extra1 = empty($extra1) ? '0' : $extra1;
            $extra2 = empty($extra2) ? '0' : $extra2;
            $ordinary = empty($ordinary) ? '0' : $ordinary;
            

            $employee_data_values = $this->data_manager->EmployeesDataByID($employee_id)->first();
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

            //Deduction
            $social_rate = $social_results['Rate'];
            $association_rate = $association_tax_results['Association_Rate'];
            

            /*Getting the last payroll entry end date */
            $employee_earning_data = $this->_query->query('SELECT * FROM earning WHERE Subscriber_ID = ? AND Employee_ID = ? AND Status = ? ORDER BY ID DESC LIMIT 0,1', array(Classes_Session::get('Loggedin_Session'), $employee_id, 'Active'));
            $earning_query_result = $employee_earning_data->first();
            $last_end_date = $earning_query_result["End_Date"];
            
             $earning_end_date = $this->data_manager->EmployeeEarningByID($employee_id, 'Active')->first();
             $end_date = $earning_end_date["End_Date"];

            $exchange_rate = $currency_results["Currency_Type"] == 'Foreign Currency' ? $exchange_rate_s : '1';

           

            /*Calculating Currency Exchange Rate With Earnings*/
            $exchange_rate_bonus = $bonus * $exchange_rate;
            $exchange_rate_comission = $comission * $exchange_rate;
            $exchange_rate_allowance = $allowance * $exchange_rate;
            $exchange_rate_otherearning = $otherearning * $exchange_rate;
            $exchange_rate_extra1 = $extra1 * $exchange_rate;
            $exchange_rate_extra2 = $extra2 * $exchange_rate;
            $exchange_rate_ordinary = $ordinary * $exchange_rate;
            /*Ending of Currency Exchange Rate With Earnings Calculation*/


            /*Determined Employee Payment Type AND Basic Salary Calculation including next_payment_date*/
            $basicsalary_cal = Classes_Calculator::BasicSalaryCal($payment_type, $salary, $exchange_rate, $payment_date_s);
            $half_basicsalary = $basicsalary_cal["Half_Basic_Salary"];
            $basicsalary = $basicsalary_cal["Basic_Salary"];
            $next_payment_day = $basicsalary_cal["Next_Payment_Date"];
            $number_of_weeks = $basicsalary_cal["Number_of_Weeks"];

            /*Ending of checking the employee payment type*/

            /*Calculating extra hours*/
            $extra_hour_cal = Classes_Calculator::ExtraHourCal($payment_type, $extra1, $extra2, $exchange_rate, $salary, $half_basicsalary, $ordinary);
            $extra1_total = $extra_hour_cal["Total_Extra_Hour1"];
            $extra2_total = $extra_hour_cal["Total_Extra_Hour2"];
            $total_ordinary = $extra_hour_cal["Total_Ordinary"];
            /*Ending of calculating extra hours*/


            /*Calculating Gross Salary*/
            if ($ordinary < 0){
                $gross_salary= $exchange_rate_bonus  + $exchange_rate_comission +  $exchange_rate_allowance + $exchange_rate_otherearning + $extra1_total + $extra2_total + $basicsalary - $total_ordinary;
            } else {
                $gross_salary= $exchange_rate_bonus + $exchange_rate_comission +  $exchange_rate_allowance + $exchange_rate_otherearning + $extra1_total + $extra2_total + $basicsalary + $total_ordinary;   
            }
            /*Ending of calculating Gross Salary*/



            /*Checking the next payment date*/
            $next_payment_date = date('Y-m-d', strtotime($payment_date_s . ' +' . $next_payment_day . 'day')); //Next Payment using current payment date
            $upper_next_payment_date = date('Y-m-d', strtotime($next_payment_date . ' +' . $next_payment_day . 'day')); //Using next payment date to get upper next payment date
            $next_payroll_compute_date = date("d F, Y", strtotime($next_payment_date));
            /*End of checking next payment date*/


            /* Payroll Calculation for determine employee grosssalary, family tax, kids tax, salary tax etc */
            $gross_salary_cal = Classes_Calculator::GrossSalaryCal($payment_type, $gross_salary, $payment_date_s, $employee_id, $basicsalary, $next_payment_date, $upper_next_payment_date);
            $total_gross_salary = $gross_salary_cal["Total_Gross_Salary"];
            /*The abovev curl brace indicate the end of week gross salary calculation*/


            /*We are using total gross salary to determine employee tax */
            //Tax Determination
            $tax_determination = $this->_query->query('SELECT * FROM salary_tax_settings WHERE Status = ? AND Subscriber_ID = ? AND "' . $total_gross_salary . '" BETWEEN Salary_From AND Salary_To', array('Active', Classes_Session::get('Loggedin_Session')))->first();
            $actual_tax_id = $tax_determination["ID"];
            $actual_tax_rate = $tax_determination["Tax_Rate"];
            $tax_salary_from = $tax_determination["Salary_From"];

            $total_social_security = $gross_salary * $social_rate / 100;
            $total_association = $gross_salary * $association_rate / 100;



            if ($actual_tax_rate == 0) {

                $deduction = $total_social_security + $total_association;
                $netpay = $total_gross_salary - $deduction;
                $total_gross_salary = $gross_salary; //Change Total Salary Value Here


                /*Creating Employee Payroll for new employee */
                if (empty($last_end_date)) {
                    //First Time
                    $earning_query = $this->_query->insert('earning', array(
                        'Subscriber_ID' => Classes_Session::get('Loggedin_Session'), 'Employee_ID' => $employee_id, 'Emp_ID' => $employee_input_id,
                        'Bonus' => $bonus, 'Comission' => $comission, 'Allowance' => $allowance, 'Other_Earning' => $otherearning, 'Extra_Hour1' => $extra1,
                        'Extra_Hour2' => $extra2, 'Ordinary' => $ordinary, 'Exchange_Rate' => $exchange_rate, 'Net_Pay' => $netpay,
                        'Gross_Salary' => $total_gross_salary, 'Tax' => '', 'Basic_Salary' => $half_basicsalary, 'Payment_Type' => $payment_type,
                        'Dates' => $payment_date_s, 'End_Date' => $next_payment_date, 'Created_Date' => date("Y-m-d"), 'Created_By' => $this->is_login["Username"],
                        'Status' => 'Active'
                    ));
                    echo json_encode(array("Payroll Successfully Created"));

                } elseif ($end_date >= $payment_date_s) {

                    echo json_encode(array("You cannot add employee earning this time come back after ". $next_payroll_compute_date." "));

                } else {

                    //Insert when date is not the same.
                    $earning_query = $this->_query->insert('earning', array(
                        'Subscriber_ID' => Classes_Session::get('Loggedin_Session'), 'Employee_ID' => $employee_id, 'Emp_ID' => $employee_input_id,
                        'Bonus' => $bonus, 'Comission' => $comission, 'Allowance' => $allowance, 'Other_Earning' => $otherearning, 'Extra_Hour1' => $extra1,
                        'Extra_Hour2' => $extra2, 'Ordinary' => $ordinary, 'Exchange_Rate' => $exchange_rate, 'Net_Pay' => $netpay,
                        'Gross_Salary' => $total_gross_salary, 'Tax' => '', 'Basic_Salary' => $half_basicsalary, 'Payment_Type' => $payment_type,
                        'Dates' => $payment_date_s, 'End_Date' => $next_payment_date, 'Created_Date' => date("Y-m-d"), 'Created_By' => $this->is_login["Username"],
                        'Status' => 'Active'
                    ));
                    echo json_encode(array("Payroll Successfully Created"));

                }
            } else {


                /*Determine Employee Salary Tax base on employee gross salary */
                $tax_calculator = Classes_Calculator::TaxCalculator($total_gross_salary, $marital_amount, $kid_amount);
                $total_tax_calculation = $tax_calculator["Total_Tax_Calculator"];
                $total_family_cal = $tax_calculator["Total_Family_Tax"];


                /*Netpayment Calculator*/
                $net_payment_cal = Classes_Calculator::NetPaymentCal($payment_type, $total_tax_calculation, $total_social_security, $total_association, $total_gross_salary, $gross_salary, $payment_date_s, $employee_id, $next_payment_date, $upper_next_payment_date);
                $tax_calculation = $net_payment_cal["Tax_Calculation"];
                $deduction = $net_payment_cal["Deduction"];
                $netpay = $net_payment_cal["Netpay"];



                if (empty($last_end_date)) {
                    //First Time
                    $earning_query = $this->_query->insert('earning', array(
                        'Subscriber_ID' => Classes_Session::get('Loggedin_Session'), 'Employee_ID' => $employee_id, 'Emp_ID' => $employee_input_id,
                        'Bonus' => $bonus, 'Comission' => $comission, 'Allowance' => $allowance, 'Other_Earning' => $otherearning, 'Extra_Hour1' => $extra1,
                        'Extra_Hour2' => $extra2, 'Ordinary' => $ordinary, 'Exchange_Rate' => $exchange_rate, 'Net_Pay' => $netpay,
                        'Gross_Salary' => $total_gross_salary, 'Tax' => $tax_calculation, 'Basic_Salary' => $half_basicsalary, 'Payment_Type' => $payment_type,
                        'Dates' => $payment_date_s, 'End_Date' => $next_payment_date, 'Created_Date' => date("Y-m-d"), 'Created_By' => $this->is_login["Username"],
                        'Status' => 'Active'
                    ));
                    echo json_encode(array("Payroll Successfully Created"));
                } elseif ($end_date >= $payment_date_s) {

                    echo json_encode(array("You cannot add employee earning this time come back after " . $next_payroll_compute_date . " "));
                } else {

                    $earning_query = $this->_query->insert('earning', array(
                        'Subscriber_ID' => Classes_Session::get('Loggedin_Session'), 'Employee_ID' => $employee_id, 'Emp_ID' => $employee_input_id,
                        'Bonus' => $bonus, 'Comission' => $comission, 'Allowance' => $allowance, 'Other_Earning' => $otherearning, 'Extra_Hour1' => $extra1,
                        'Extra_Hour2' => $extra2, 'Ordinary' => $ordinary, 'Exchange_Rate' => $exchange_rate, 'Net_Pay' => $netpay,
                        'Gross_Salary' => $total_gross_salary, 'Tax' => $tax_calculation, 'Basic_Salary' => $half_basicsalary, 'Payment_Type' => $payment_type,
                        'Dates' => $payment_date_s, 'End_Date' => $next_payment_date, 'Created_Date' => date("Y-m-d"), 'Created_By' => $this->is_login["Username"],
                        'Status' => 'Active'
                    ));
                    echo json_encode(array("Payroll Successfully Created"));
                  
                }
                
            }

        }

    }


    public function LoadDateRangeByPaymentType($payment_type){
        $query_results =  $this->_query->query("SELECT DISTINCT Dates, End_Date FROM earning WHERE Subscriber_ID = ? AND Payment_Type = ? AND Status = ? ORDER BY ID DESC", array(Classes_Session::get("Loggedin_Session"), $payment_type, 'Active'))->results();
        foreach ($query_results as $key => $query_result) {
            if (!empty($query_result["Dates"] && !empty($query_result["End_Date"])))
                echo "<option value=" . $query_result["Dates"] . ">" . $query_result["Dates"] . " - ". $query_result["End_Date"]."</option>";
        } 
    }


    public function LoadEarningData($earning_date, $payment_type){
        $earning_update_content = '';

        $earning_data_g = $this->_query->query('SELECT * FROM earning WHERE Subscriber_ID = ? AND Dates = ? AND Payment_Type = ? AND Status = ?', array(Classes_Session::get('Loggedin_Session'), $earning_date, $payment_type, 'Active'));
        $earning_data_count = $earning_data_g->count();
        $earning_data_values = $earning_data_g->results();


        if ($earning_data_count > 0) {

            foreach ($earning_data_values as $key => $earning_data_value) {

                $employee_data_value = $this->data_manager->EmployeesDataByID($earning_data_value["Employee_ID"])->first();
                $employee_link = '<a class="info" style="font-size: 15px" href="' . $this->web_data["Web_Url"] . 'view-employee?employee_id=' . $employee_data_value["Employee_ID"] . '"><b>' . $employee_data_value["First_Name"] . ' ' . $employee_data_value["Last_Name"] . '</b> </a>';

                $earning_update_content .= '
            <tr>
                <input type="hidden" class="form-control employee_id_update" name="employee_id" id="employee_id_update" value="' . $employee_data_value["Employee_ID"] . '">
                <td>' . $employee_link . '</td>
                <td><input type="text" class="form-control bonus_update number_only" name="bonus" value="'. $earning_data_value["Bonus"]. '" id="bonus_update" placeholder="0"></td>
                <td><input type="text" class="form-control comission_update number_only" name="comission" value="'. $earning_data_value["Comission"]. '" id="comission_update" placeholder="0"></td>
                <td><input type="text" class="form-control allowance_update number_only" name="allowance" value="'. $earning_data_value["Allowance"]. '" id="allowance_update" placeholder="0"></td>
                <td><input type="text" class="form-control otherearning_update number_only" name="otherearning" value="'. $earning_data_value["Other_Earning"]. '" id="otherearning_update" placeholder="0"></td>
                <td><input type="text" class="form-control extra1_update number_only" name="extra1" value="'. $earning_data_value["Extra_Hour1"]. '" id="extra1_update" placeholder="0"></td>
                <td><input type="text" class="form-control extra2_update number_only" name="extra2" value="'. $earning_data_value["Extra_Hour2"]. '" id="extra2_update" placeholder="0"></td>
                <td><input type="text" class="form-control ordinary_update number_only" name="ordinary" value="'. $earning_data_value["Ordinary"]. '" id="ordinary_update" placeholder="0"></td>
            </tr>';
            }
        } else {
            $earning_update_content .= '<td colspan="10"><center> No Data Available</center></td>';
        }
        echo json_encode(array($earning_update_content, $earning_data_value["Exchange_Rate"] == '1' ? '' : $earning_data_value["Exchange_Rate"]));

    }



    public function UpdateEmployeeEarning($employee_id_s, $bonus_s, $comission_s, $allowance_s, $otherearning_s, $extra1_s, $extra2_s, $ordinary_s, $payment_date_s, $exchange_rate_s)
    {

        foreach ($employee_id_s as $key => $value) {
            $employee_id = $employee_id_s[$key];
            $bonus = $bonus_s[$key];
            $comission = $comission_s[$key];
            $allowance = $allowance_s[$key];
            $otherearning = $otherearning_s[$key];
            $extra1 = $extra1_s[$key];
            $extra2 = $extra2_s[$key];
            $ordinary = $ordinary_s[$key];

            $bonus = empty($bonus) ? '0' : $bonus;
            $comission = empty($comission) ? '0' : $comission;
            $allowance = empty($allowance) ? '0' : $allowance;
            $otherearning = empty($otherearning) ? '0' : $otherearning;
            $extra1 = empty($extra1) ? '0' : $extra1;
            $extra2 = empty($extra2) ? '0' : $extra2;
            $ordinary = empty($ordinary) ? '0' : $ordinary;


            $employee_data_values = $this->data_manager->EmployeesDataByID($employee_id)->first();
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

            //Deduction
            $social_rate = $social_results['Rate'];
            $association_rate = $association_tax_results['Association_Rate'];


            /*Getting the last payroll entry end date */
            $employee_earning_data = $this->_query->query('SELECT * FROM earning WHERE Subscriber_ID = ? AND Employee_ID = ? AND Status = ? ORDER BY ID DESC LIMIT 0,1', array(Classes_Session::get('Loggedin_Session'), $employee_id, 'Active'));
            $earning_query_result = $employee_earning_data->first();
            $last_end_date = $earning_query_result["End_Date"];

            $earning_end_date = $this->data_manager->EmployeeEarningByID($employee_id, 'Active')->first();
            $end_date = $earning_end_date["End_Date"];

            $exchange_rate = $currency_results["Currency_Type"] == 'Foreign Currency' ? $exchange_rate_s : '1';



            /*Calculating Currency Exchange Rate With Earnings*/
            $exchange_rate_bonus = $bonus * $exchange_rate;
            $exchange_rate_comission = $comission * $exchange_rate;
            $exchange_rate_allowance = $allowance * $exchange_rate;
            $exchange_rate_otherearning = $otherearning * $exchange_rate;
            $exchange_rate_extra1 = $extra1 * $exchange_rate;
            $exchange_rate_extra2 = $extra2 * $exchange_rate;
            $exchange_rate_ordinary = $ordinary * $exchange_rate;
            /*Ending of Currency Exchange Rate With Earnings Calculation*/


            /*Determined Employee Payment Type AND Basic Salary Calculation including next_payment_date*/
            $basicsalary_cal = Classes_Calculator::BasicSalaryCal($payment_type, $salary, $exchange_rate, $payment_date_s);
            $half_basicsalary = $basicsalary_cal["Half_Basic_Salary"];
            $basicsalary = $basicsalary_cal["Basic_Salary"];
            $next_payment_day = $basicsalary_cal["Next_Payment_Date"];
            $number_of_weeks = $basicsalary_cal["Number_of_Weeks"];

            /*Ending of checking the employee payment type*/

            /*Calculating extra hours*/
            $extra_hour_cal = Classes_Calculator::ExtraHourCal($payment_type, $extra1, $extra2, $exchange_rate, $salary, $half_basicsalary, $ordinary);
            $extra1_total = $extra_hour_cal["Total_Extra_Hour1"];
            $extra2_total = $extra_hour_cal["Total_Extra_Hour2"];
            $total_ordinary = $extra_hour_cal["Total_Ordinary"];
            /*Ending of calculating extra hours*/


            /*Calculating Gross Salary*/
            if ($ordinary < 0) {
                $gross_salary = $exchange_rate_bonus  + $exchange_rate_comission +  $exchange_rate_allowance + $exchange_rate_otherearning + $extra1_total + $extra2_total + $basicsalary - $total_ordinary;
            } else {
                $gross_salary = $exchange_rate_bonus + $exchange_rate_comission +  $exchange_rate_allowance + $exchange_rate_otherearning + $extra1_total + $extra2_total + $basicsalary + $total_ordinary;
            }
            /*Ending of calculating Gross Salary*/


            /*Checking the next payment date*/
            $next_payment_date = date('Y-m-d', strtotime($payment_date_s . ' +' . $next_payment_day . 'day')); //Next Payment using current payment date
            $upper_next_payment_date = date('Y-m-d', strtotime($next_payment_date . ' +' . $next_payment_day . 'day')); //Using next payment date to get upper next payment date
            $next_payroll_compute_date = date("d F, Y", strtotime($next_payment_date));
            /*End of checking next payment date*/



            /* Payroll Calculation for determine employee grosssalary, family tax, kids tax, salary tax etc */
            $gross_salary_cal = Classes_Calculator::GrossSalaryCal($payment_type, $gross_salary, $payment_date_s, $employee_id, $basicsalary, $next_payment_date, $upper_next_payment_date);
            $total_gross_salary = $gross_salary_cal["Total_Gross_Salary"];
            /*The abovev curl brace indicate the end of week gross salary calculation*/


            $tax_determination = $this->_query->query('SELECT * FROM salary_tax_settings WHERE Status = ? AND Subscriber_ID = ? AND "' . $total_gross_salary . '" BETWEEN Salary_From AND Salary_To', array('Active', Classes_Session::get('Loggedin_Session')))->first();
            $actual_tax_id = $tax_determination["ID"];
            $actual_tax_rate = $tax_determination["Tax_Rate"];
            $tax_salary_from = $tax_determination["Salary_From"];

            $total_social_security = $gross_salary * $social_rate / 100;
            $total_association = $gross_salary * $association_rate / 100;



            if ($actual_tax_rate == 0) {

                $deduction = $total_social_security + $total_association;
                $netpay = $total_gross_salary - $deduction;
                $total_gross_salary = $gross_salary; //Change Total Salary Value Here



                /*Updating Employee Payroll*/
                $earning_query = $this->_query->query('UPDATE earning SET Bonus = "' . $bonus . '", Comission = "' . $comission . '", Allowance = "' . $allowance . '", Other_Earning = "' . $otherearning . '",
                 Extra_Hour1 = "' . $extra1 . '", Extra_Hour2 = "' . $extra2 . '", Ordinary = "' . $ordinary . '", Exchange_Rate = "' . $exchange_rate . '", Net_Pay = "' . $netpay . '", Gross_Salary = "' . $total_gross_salary . '",
                  Tax = "0", Basic_Salary = "' . $half_basicsalary . '", Modified_Date = "' . date('Y-m-d') . '", Modified_By = "' . $this->is_login["Username"] . '" 
                 WHERE Subscriber_ID = "' . Classes_Session::get("Loggedin_Session") . '" AND Employee_ID = "' . $employee_id . '" ');
                echo json_encode(array("Payroll Successfully Update"));

            } else {

                /*Determine Employee Salary Tax base on employee gross salary */
                $tax_calculator = Classes_Calculator::TaxCalculator($total_gross_salary, $marital_amount, $kid_amount);
                $total_tax_calculation = $tax_calculator["Total_Tax_Calculator"];
                $total_family_cal = $tax_calculator["Total_Family_Tax"];



                /*Net Payment Calculator */
                $net_payment_cal = Classes_Calculator::NetPaymentCal($payment_type, $total_tax_calculation, $total_social_security, $total_association, $total_gross_salary, $gross_salary, $payment_date_s, $employee_id, $next_payment_date, $upper_next_payment_date);
                $tax_calculation = $net_payment_cal["Tax_Calculation"];
                $deduction = $net_payment_cal["Deduction"];
                $netpay = $net_payment_cal["Netpay"];



                /*Updating Employee Payroll*/
                $earning_query = $this->_query->query('UPDATE earning SET Bonus = "'.$bonus.'", Comission = "'.$comission.'", Allowance = "'.$allowance.'", Other_Earning = "'.$otherearning.'",
                 Extra_Hour1 = "'. $extra1.'", Extra_Hour2 = "'. $extra2.'", Ordinary = "'. $ordinary.'", Exchange_Rate = "'. $exchange_rate.'", Net_Pay = "'. $netpay.'", Gross_Salary = "'. $total_gross_salary.'",
                  Tax = "'. $tax_calculation.'", Basic_Salary = "'. $half_basicsalary.'", Modified_Date = "'. date('Y-m-d').'", Modified_By = "'.$this->is_login["Username"].'" 
                 WHERE Subscriber_ID = "'.Classes_Session::get("Loggedin_Session").'" AND Employee_ID = "'.$employee_id.'" ');
                echo json_encode(array("Payroll Successfully Update"));
            }
        }
    }

    public function LoadDateRangeByEmployee($employee_id)
    {
        $query_results =  $this->data_manager->EarningDateData($employee_id)->results();
        foreach ($query_results as $key => $query_result) {
            if (!empty($query_result["Dates"] && !empty($query_result["End_Date"])))
                echo "<option value=" . $query_result["Dates"] . ">" . $query_result["Dates"] . " - " . $query_result["End_Date"] . "</option>";
        }
    }


    public function LoadEmployeeDeduction($__payment_date, $__employee_id){
        $deduction_content = '';

        if(empty($__employee_id)){
            $earning_data_g = $this->_query->query('SELECT * FROM earning WHERE Subscriber_ID = ? AND Dates = ? AND Status = ?', array(Classes_Session::get('Loggedin_Session'), $__payment_date, 'Active'));
        } else {
            $earning_data_g = $this->_query->query('SELECT * FROM earning WHERE Subscriber_ID = ? AND Dates = ? AND Employee_ID = ? AND Status = ?', array(Classes_Session::get('Loggedin_Session'), $__payment_date, $__employee_id, 'Active'));
        }

        $earning_data_count = $earning_data_g->count();
        $earning_data_values = $earning_data_g->results();

        if ($earning_data_count > 0) {

            foreach ($earning_data_values as $key => $earning_data_value) {

                $employee_data_value = $this->data_manager->EmployeesDataByID($earning_data_value["Employee_ID"])->first();
                $employee_link = '<a class="info" style="font-size: 15px" href="' . $this->web_data["Web_Url"] . 'view-employee?employee_id=' . $employee_data_value["Employee_ID"] . '"><b>' . $employee_data_value["First_Name"] . ' ' . $employee_data_value["Last_Name"] . '</b> </a>';

                $deduction_content .= '
            <tr>
                <input type="hidden" class="form-control employee_id_deduct" name="employee_id" id="employee_id_deduct" value="' . $employee_data_value["Employee_ID"] . '">
                <td>' . $employee_link . '</td>
                <td><input type="text" class="form-control loan number_only" name="loan" value="' . $earning_data_value["Loan"] . '" id="loan" placeholder="0"></td>
                <td><input type="text" class="form-control assessment number_only" name="assessment" value="' . $earning_data_value["Assessment"] . '" id="assessment" placeholder="0"></td>
                <td><input type="text" class="form-control othersdeduction number_only" name="othersdeduction" value="' . $earning_data_value["Other_Deduction"] . '" id="othersdeduction" placeholder="0"></td>
            </tr>';
            }
        } else {
            $deduction_content .= '<td colspan="10"><center> No Data Available</center></td>';
        }

        echo json_encode(array($deduction_content));

    }


    public function ComputeDeduction($_employee_id_deduct, $_loan, $_assessment, $_othersdeduction, $_earning_date_range_payment){
        foreach ($_employee_id_deduct as $key => $value) {
            $employee_id = $_employee_id_deduct[$key];
            $loan = $_loan[$key];
            $assessment = $_assessment[$key];
            $othersdeduction = $_othersdeduction[$key];

            $loan = empty($loan) ? '0' : $loan;
            $assessment = empty($assessment) ? '0' : $assessment;
            $othersdeduction = empty($othersdeduction) ? '0' : $othersdeduction;


            $employee_data_values = $this->data_manager->EmployeesDataByID($employee_id)->first();
            $social_results = $this->data_manager->SocialSecurityDataByID($employee_data_values["Social_Security"])->first();
            $association_tax_results = $this->data_manager->AssociationDataByID($employee_data_values["Association"])->first();

            $earning_data = $this->data_manager->EarningDateData($employee_id, $_earning_date_range_payment)->first();
            $gross_salary = $earning_data["Gross_Salary"];
            $exchange_rate = $earning_data["Exchange_Rate"];
            $tax = $earning_data["Tax"];
            $emp_id = $employee_data_values['Emp_ID'];

            //Deduction
            $social_rate = $social_results['Rate'];
            $association_rate = $association_tax_results['Association_Rate'];

            $total_social_security = $gross_salary * $social_rate / 100;
            $total_association = $gross_salary * $association_rate / 100;


            $loan = abs($loan);

            $assessment = $assessment * $exchange_rate; $othersdeduction = $othersdeduction * $exchange_rate; $loan = $loan * $exchange_rate;
            $deduction = $assessment + $othersdeduction + $loan + $tax + $total_social_security + $total_association;
            
            $netpay = $gross_salary - $deduction;

            $earning_query = $this->_query->query('UPDATE earning SET Loan = "' . $loan . '", Assessment = "' . $assessment . '", Other_Deduction = "' . $othersdeduction . '", Total_Deduction = "'.$deduction.'", Net_Pay = "' . $netpay . '", Modified_Date = "' . date('Y-m-d') . '", Modified_By = "' . $this->is_login["Username"] . '" 
                 WHERE Subscriber_ID = "' . Classes_Session::get("Loggedin_Session") . '" AND Employee_ID = "' . $employee_id . '" ');
            echo json_encode(array("Payroll Deduction Successfully Update"));

        }
    }


    public function LoadEmployeeLeaveData($employee_leave_id){


        $days_askeds = 0; $employee_leave_table_output = '';
        $employee_data = $this->data_manager->EmployeesDataByID($employee_leave_id)->first();
        $emp_id = $employee_data['Emp_ID'];
        $employee_id = $employee_data['Employee_ID'];
        $first_name = $employee_data['First_Name'];
        $last_name = $employee_data['Last_Name'];
        $payment_type = $employee_data['Payment_Type'];
        $hire_date = $employee_data['HireDate'];
        $hire_date_year = substr($hire_date, 0, -6); //Removing day and month from hire_date


        $vacation_results = $this->data_manager->VacationDataByID($employee_data['Vacation'])->first();


        $leave_data_query = $this->_query->query('SELECT * FROM employee_available_leave WHERE Subscriber_ID = ? AND Employee_ID = ? AND Status = ?', array(Classes_Session::get("Loggedin_Session"), $employee_id, 'Active'));
        $avaliable_leave_data = $leave_data_query->first();
        $leave_data_count = $leave_data_query->count();
        
        $total_available_leave = $avaliable_leave_data["Total_Available_Leave"];
        $yearly_leave = $avaliable_leave_data["Years_Leaves"];
        $new_leave_years = explode(",", $avaliable_leave_data["New_Leave_Years"]);
        $yearly_leave = explode(",", $yearly_leave);

        $leave_day_asked_data = $this->_query->query('SELECT SUM(Days_Asked) AS Days_Asked FROM employee_leave WHERE Subscriber_ID = ? AND Employee_ID = ? AND Status = ?', array(Classes_Session::get("Loggedin_Session"), $employee_id, 'Active'))->first();
        $days_asked = $leave_day_asked_data["Days_Asked"];
        

        $reamining_available_day = $total_available_leave - $days_asked;
        $current_year = date("Y");

        $current_year_a[] = date("Y");
        //var_dump($adding_new_leave_year);


            if($leave_data_count > 0){
                $date_range_a = array(); $yearly_leave_a = array();
                /*Generate Year from employee hire date till current year */
                for ($date_range = $hire_date_year; $date_range <= $current_year; $date_range++) {
                    /*Here check if newly generated year is not in the employee new_leave_years in DB */
                    if (!in_array($date_range, $new_leave_years, true)) {
                        $date_range_a[] = $date_range; //Adding newly created year into array
                        $yearly_leave_a[] = $vacation_results["Vacation_Day"]; //Adding new vacation day into array
                    }
                }

                $adding_new_leave_year =  implode(",", array_unique(array_merge($new_leave_years, $date_range_a))); //Convert array newly created year into comma value
                $new_yearly_leave = implode(",", array_merge($yearly_leave, $yearly_leave_a)); //Convert Vacation Day back into comma value
            
               

                if (!in_array($current_year, $new_leave_years)) {
                    $new_total_available_leave = array_sum(array_merge($yearly_leave, $yearly_leave_a)) - $days_asked;

                    $leave_query = $this->_query->query('UPDATE employee_available_leave SET Total_Available_Leave = "' . $new_total_available_leave . '", New_Leave_Years = "' . $adding_new_leave_year . '", Years_Leaves = "' . $new_yearly_leave . '" WHERE Subscriber_ID = "' . Classes_Session::get("Loggedin_Session") . '" AND Employee_ID = "' . $employee_leave_id . '" ');
                } else {
                    $new_total_available_leave = array_sum($yearly_leave) - $days_asked;

                    $leave_query = $this->_query->query('UPDATE employee_available_leave SET Total_Available_Leave = "' . $new_total_available_leave . '" WHERE Subscriber_ID = "' . Classes_Session::get("Loggedin_Session") . '" AND Employee_ID = "' . $employee_leave_id . '" ');
                }
            } else {

                 $date_range_a = array(); $yearly_leave_a = array();
                /*Generate Year from employee hire date till current year */
                for ($date_range = $hire_date_year; $date_range <= $current_year; $date_range++) {
                    /*Here check if newly generated year is not in the employee new_leave_years in DB */
                    if (!in_array($date_range, $new_leave_years, true)) {
                        $date_range_a[] = $date_range; //Adding newly created year into array
                        $yearly_leave_a[] = $vacation_results["Vacation_Day"]; //Adding new vacation day into array
                    }
                }

                $adding_new_leave_year =  implode(",", array_unique(array_merge($current_year_a, $date_range_a))); //Convert array newly created year into comma value
                $new_yearly_leave = implode(",", $yearly_leave_a); //Convert Vacation Day back into comma value

                $new_total_available_leave = array_sum($yearly_leave_a) - $days_asked;

                $this->_query->insert('employee_available_leave', 
                array(
                    'Subscriber_ID' => Classes_Session::get('Loggedin_Session'), 
                    'Employee_ID' => $employee_leave_id, 
                    'Total_Available_Leave' => $new_total_available_leave,
                    'New_Leave_Years' => $adding_new_leave_year,
                    'Years_Leaves' => $new_yearly_leave,
                    'Status' => 'Active')
                );
            }

        $reamining_available_day = empty($new_total_available_leave) ? $reamining_available_day : $new_total_available_leave;

        $query_result_cs = $this->_query->query("SELECT * FROM leave_type WHERE Subscriber_ID = ? AND Status = ? ORDER BY ID DESC", array(Classes_Session::get("Loggedin_Session"), 'Active'))->results();
        $leave_type_output='';
        foreach ($query_result_cs as $key => $query_result_c) {
            $leave_type_output.='<option value='. $query_result_c["Leave_ID"]. '> ' . $query_result_c["Leave_Type"] . ' (' . $query_result_c["Number_of_Days"] . ')</option> ';
        }

        $employee_link = '<a class="info" style="font-size: 15px" href="' . $this->web_data["Web_Url"] . 'view-employee?employee_id=' . $employee_data["Employee_ID"] . '"><b>' . $employee_data["First_Name"] . ' ' . $employee_data["Last_Name"] . '</b> </a>';

        $employee_leave_table_output .= '

            <tr>

                          <td>' . $employee_link . '</td>
                          <td>' . $payment_type . '</td>
                          <td>' . $reamining_available_day . '</td>
                          <td>
                                <select class="select2 form-control" id="employee_leave_type" style="width: 100%;">
                                    <option disabled selected>Select Leave Type</option>
                                    '. $leave_type_output.'
                                </select>
                          </td>
                          <td><textarea class="form-control" row="1" style="height:50px" id="leave_reason"></textarea></td>
                          <td>
                        <div class="row">
                          <div class="col-6">
                            <input type="date" id="leave_from" class="form-control daterange" />
                          </div>

                          <div class="col-6">
                            <input type="date" id="leave_to" class="form-control daterange" />
                          </div>

                        </div>
                        <input type="hidden" class="form-control" name="emp_id" id="leave_employee_id" value="' . $employee_id . '">
                        <input type="hidden" class="form-control" name="leave_payment_type" id="leave_payment_type" value="' . $payment_type . '">
                        </td>
                        </tr>';

        echo json_encode(array($employee_leave_table_output));
    }


    public function AddEmployeeLeave($leave_employee_id, $employee_leave_type, $leave_reason, $leave_from, $leave_to, $leave_payment_type){
        $query_result_cs = $this->_query->query("SELECT * FROM leave_type WHERE Leave_ID = ? AND Subscriber_ID = ? AND Status = ? ORDER BY ID DESC", array($employee_leave_type, Classes_Session::get("Loggedin_Session"), 'Active'))->first();
        $number_of_days = $query_result_cs["Number_of_Days"];
        $leave_id = $query_result_cs["Leave_ID"];


        $day = date("Y-m-d");


        $leave_data_query = $this->_query->query('SELECT * FROM employee_available_leave WHERE Subscriber_ID = ? AND Employee_ID = ? AND Status = ?', array(Classes_Session::get("Loggedin_Session"), $leave_employee_id, 'Active'));
        $avaliable_leave_data = $leave_data_query->first();
        $leave_data_count = $leave_data_query->count();
        $total_available_leave = $avaliable_leave_data["Total_Available_Leave"];


        $reamining_available_day = $total_available_leave - $number_of_days;
        
        $employee_leave_data_query = $this->_query->query('SELECT SUM(Days_Asked) AS Days_Asked FROM employee_leave WHERE Subscriber_ID = ? AND Employee_ID = ? AND Status = ?', array(Classes_Session::get("Loggedin_Session"), $leave_employee_id, 'Active'))->first();
        $employee_used_days = $employee_leave_data_query["Days_Asked"];

        $enjoy_date = $leave_from.' - '. $leave_to;

        if ($number_of_days > $total_available_leave) {

            echo json_encode(array("Oops! Sorry you cannot ask " . $number_of_days . " days out of " . $total_available_leave . " you alreay used ". $employee_used_days." "));
        } else {

            $leave_query = $this->_query->query('UPDATE employee_available_leave SET Total_Available_Leave = "' . $reamining_available_day . '" WHERE Subscriber_ID = "' . Classes_Session::get("Loggedin_Session") . '" AND Employee_ID = "' . $leave_employee_id . '" ');


            $this->_query->insert('employee_leave',
                array(
                    'Subscriber_ID' => Classes_Session::get('Loggedin_Session'),
                    'Employee_ID' => $leave_employee_id,
                    'Leave_ID' => $leave_id,
                    'Leave_Reason' => $leave_reason,
                    'Payment_Type' => $leave_payment_type,
                    'Days_Asked' => $number_of_days,
                    'Enjoy_Date' => $enjoy_date,
                    'Created_By' => $this->is_login["Username"],
                    'Created_Date' => date("Y-m-d"),
                    'Status' => 'Active'
                )
            );

            echo json_encode(array("Employee Leave Successfully Added..."));

        }


    }


    public function LoadEmployeeLeaveTable(){
        $data = array();
        $serial_id = 0;

        $search_value = $_POST["search"]["value"];

        $column_order = array('Payment_Type', 'Days_Asked', 'Enjoy_Date', 'Created_Date', 'Created_By', 'Status');
        if ($_POST['order']) {
            $order_by = $column_order[$_POST['order'][0]['column']] . ' ' . $_POST['order']['0']['dir'];
        } else {
            $order_by = " ID DESC";
        }

        $query = $this->_query->query("SELECT * FROM employee_leave WHERE Subscriber_ID = ? ORDER BY ID DESC", array(Classes_Session::get("Loggedin_Session")));
        $total_leave_filter = $query->count();

        if ($_POST['length'] != -1) {
            $limit = " " . $_POST['start'] . ", " . $_POST['length'] . " ";
        }

        if (!empty($_POST["search"]["value"])) {
            $sql_leave = "SELECT * FROM employee_leave WHERE Subscriber_ID = ? AND (Payment_Type LIKE ? OR Days_Asked LIKE ? OR Enjoy_Date LIKE ? OR Created_Date LIKE ? OR Created_By LIKE ? OR Status LIKE ?) ORDER BY $order_by LIMIT $limit";
            $data_value = array(Classes_Session::get("Loggedin_Session"), '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%');
            $query_result_c = $this->_query->query($sql_leave, $data_value);
        } else {
            $sql_leave = "SELECT * FROM employee_leave WHERE Subscriber_ID = ? ORDER BY $order_by LIMIT $limit";
            $query_result_c = $this->_query->query($sql_leave, array(Classes_Session::get("Loggedin_Session")));
        }


        $total_leave_data = $query_result_c->count();


        if($total_leave_data > 0){
            $fetching_results = $query_result_c->results();
            $serial_id = 1;
            foreach ($fetching_results as $key => $data_value) {

                $employee_data = $this->data_manager->EmployeesDataByID($data_value["Employee_ID"])->first();

                $action_buttons = '<button type="button" id="' . $data_value["ID"] . '" class="btn btn-info delete_leave" > <i class="la la-trash-o"></i> Delete</button>';


                if ($data_value["Status"] == 'Active') {
                    $leave_status = '<span class="badge badge-default badge-success">' . $data_value["Status"] . '</span>';
                } elseif ($data_value["Status"] == 'Disabled') {
                    $leave_status = '<span class="badge badge-default badge-danger">' . $data_value["Status"] . '</span>';
                }


                $employee_link = '<a class="info" style="font-size: 15px" href="' . $this->web_data["Web_Url"] . 'view-employee?employee_id=' . $employee_data["Employee_ID"] . '"><b>' . $employee_data["First_Name"] . ' ' . $employee_data["Last_Name"] . '</b> </a>';

                $leave_data = array();
                $leave_data[] = $employee_link;
                $leave_data[] = $data_value["Payment_Type"] .' Days';
                $leave_data[] = $data_value["Days_Asked"] .' Days';
                $leave_data[] = $data_value["Enjoy_Date"];
                $leave_data[] = date($this->localization["Date_Format"], strtotime($data_value["Created_Date"]));
                $leave_data[] = $data_value["Created_By"];
                //$leave_data[] = $data_value["Modified_Date"] == '0000-00-00' ? 'Not Yet Edited' : date($this->localization["Date_Format"], strtotime($data_value["Modified_Date"]));
                //$leave_data[] = $data_value["Modified_By"] == '' ? 'Not Yet Edited' : $data_value["Modified_By"];
                $leave_data[] = $leave_status;
                $leave_data[] = $action_buttons;

                $data[] = $leave_data;
                $serial_id++;
            }
        }

        $leave_list_result_output = array(

            "draw"  => intval($_POST["draw"]),
            "recordsTotal" => intval($total_leave_data),
            "recordsFiltered" => intval($total_leave_filter),
            "data" => $data,
        );

        echo json_encode($leave_list_result_output);
    }


    public function DeleteEmployeeLeave($employee_leave_id)
    {
        $leave_data_query = $this->_query->query('SELECT * FROM employee_leave WHERE Subscriber_ID = ? AND ID = ? ', array(Classes_Session::get("Loggedin_Session"), $employee_leave_id));
        $avaliable_leave_data = $leave_data_query->first();
        $leave_data_count = $leave_data_query->count();

        $days_asked = $avaliable_leave_data["Days_Asked"];
        $employee_id_s = $avaliable_leave_data["Employee_ID"];

        $__leave_data_query = $this->_query->query('SELECT * FROM employee_available_leave WHERE Subscriber_ID = ? AND Employee_ID = ? AND Status = ?', array(Classes_Session::get("Loggedin_Session"), $employee_id_s, 'Active'));
        $__avaliable_leave_data = $__leave_data_query->first();
        $total_available_leave = $__avaliable_leave_data["Total_Available_Leave"];


        $total_available_leave = $total_available_leave + $days_asked;

        if ($leave_data_count > 0) {
            $leave_query = $this->_query->query('UPDATE employee_available_leave SET Total_Available_Leave = "' . $total_available_leave . '" WHERE Subscriber_ID = "' . Classes_Session::get("Loggedin_Session") . '" AND Employee_ID = "' . $employee_id_s . '" ');
            $leave_query_user = $this->_query->query('DELETE FROM employee_leave WHERE ID = "' . $employee_leave_id . '" AND Subscriber_ID ="' . Classes_Session::get("Loggedin_Session") . '"');

        }

    }


    public function AddPayrollItem($payroll_item_id, $payroll_item_name, $payroll_item_amount, $assigned_option, $assigned_employee_id, $payroll_item_date, $payroll_item_status, $saving_type){
        $payroll_item_id_gen = Classes_Generators::AlphaNumeric(5);
        $payroll_item_id_gen = strtoupper($payroll_item_id_gen);
       
        if ($assigned_option == 'All Employees') {
            //Select all employee
            $all_employee_id = array();
            $__employee_datas = $this->data_manager->EmployeesData()->results();
            foreach ($__employee_datas as $key => $__employee_data) {
                $all_employee_id[] = $__employee_data["Employee_ID"];
            }
            $__employee_ids = implode(",", $all_employee_id);
        } elseif ($assigned_option == 'Select Employee') {
            //Use Selected Employee ID
            $__employee_ids = $assigned_employee_id;
        } else {
            //Remove any employee ID
            $__employee_ids = '';
        }

        $saving_type = $saving_type == 'add_payroll_item' ? 'Add_Only' : 'Add_Assigned';
        
        $payroll_item_data_g = $this->_query->query('SELECT * FROM payroll_items WHERE Subscriber_ID = ? AND ID = ?', array(Classes_Session::get('Loggedin_Session'), $payroll_item_id));
        $payroll_item_count = $payroll_item_data_g->count();
        $payroll_item_data_value = $payroll_item_data_g->first();
        

        if ($payroll_item_count > 0) {
            $payroll_item_query = $this->_query->query('UPDATE payroll_items SET Payroll_Item_Name = "' . $payroll_item_name . '", Payroll_Item_Amount ="' . $payroll_item_amount . '", Payroll_Item_Assigned ="' . $assigned_option . '", Payroll_Item_Assigned_To ="' . $__employee_ids . '", Payroll_Item_Date ="' . $payroll_item_date . '", Status ="' . $payroll_item_status . '", Modified_Date="' . date('Y-m-d') . '", Modified_by="' . $this->is_login["Username"] . '" WHERE ID = "' . $payroll_item_id . '" AND Subscriber_ID ="' . Classes_Session::get("Loggedin_Session") . '"');
            echo json_encode(array("Payroll Item Successfully Update"));

        } else {

            $this->_query->insert('payroll_items', array(
                'Subscriber_ID' => Classes_Session::get('Loggedin_Session'),
                'Payroll_Item_ID' => $payroll_item_id_gen,
                'Payroll_Item_Name' => $payroll_item_name,
                'Payroll_Item_Amount' => $payroll_item_amount,
                'Payroll_Item_Assigned' => $assigned_option,
                'Payroll_Item_Assigned_To' => $__employee_ids,
                'Payroll_Item_Date' => $payroll_item_date,
                'Create_Type' => $saving_type,
                'Created_By' => $this->is_login["Username"],
                'Created_Date' => date("Y-m-d"),
                'Status' => $payroll_item_status
            )
        );

        echo json_encode(array("Payroll Item Successfully Added..."));
        }
    }


    public function LoadPayrollItem(){
        $data = array();
        $serial_id = 0;

        $search_value = $_POST["search"]["value"];

        $column_order = array('Payroll_Item_Name', 'Payroll_Item_Amount', 'Payroll_Item_Assigned', 'Payroll_Item_Date', 'Created_Type', 'Created_Date', 'Created_By', 'Status');
        if ($_POST['order']) {
            $order_by = $column_order[$_POST['order'][0]['column']] . ' ' . $_POST['order']['0']['dir'];
        } else {
            $order_by = " ID DESC";
        }

        $query = $this->_query->query("SELECT * FROM payroll_items WHERE Subscriber_ID = ? AND Delete_Type != ? ORDER BY ID DESC", array(Classes_Session::get("Loggedin_Session"), 'Just_Delete'));
        $total_payroll_item_filter = $query->count();

        if ($_POST['length'] != -1) {
            $limit = " " . $_POST['start'] . ", " . $_POST['length'] . " ";
        }

        if (!empty($_POST["search"]["value"])) {
            $sql_payroll_item = "SELECT * FROM payroll_items WHERE Subscriber_ID = ? AND Delete_Type != ? AND (Payroll_Item_Name LIKE ? OR Payroll_Item_Amount LIKE ? OR Payroll_Item_Assigned LIKE ? OR Payroll_Item_Date LIKE ? OR Created_Type LIKE ? OR Created_Date LIKE ? OR Created_By LIKE ? OR Status LIKE ?) ORDER BY $order_by LIMIT $limit";
            $data_value = array(Classes_Session::get("Loggedin_Session"), 'Just_Delete', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%');
            $query_result_c = $this->_query->query($sql_payroll_item, $data_value);
        } else {
            $sql_payroll_item = "SELECT * FROM payroll_items WHERE Subscriber_ID = ? AND Delete_Type != ? ORDER BY $order_by LIMIT $limit";
            $query_result_c = $this->_query->query($sql_payroll_item, array(Classes_Session::get("Loggedin_Session"), 'Just_Delete'));
        }


        $total_payroll_item_data = $query_result_c->count();


        if ($total_payroll_item_data > 0) {
            $fetching_results = $query_result_c->results();
            $serial_id = 1;
            foreach ($fetching_results as $key => $data_value) {

                if($data_value["Payroll_Item_Assigned"] != "Don't Assigned" && "All Employees"){
                    $__employee_data = $this->data_manager->EmployeesDataByID($data_value["Payroll_Item_Assigned_To"])->first();
                }


                $action_buttons = '<div class="btn-group " >
                        <button type="button" class="btn btn-info round  dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="la la-info"></i> Actions</button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item delete_payroll_item" data-id="' . $data_value["ID"] . '" id="just_delete" href="javascript:void(0)">Delete</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item delete_payroll_item" data-id="' . $data_value["ID"] . '" id="delete_unassigned" href="javascript:void(0)">Delete & Unassigned</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item edit_payroll_item" id="' . $data_value["ID"] . '" href="javascript:void(0)">Edit All</a>
                        </div>
                    </div>';


                if ($data_value["Status"] == 'Active') {
                    $payroll_item_status = '<span class="badge badge-default badge-success">' . $data_value["Status"] . '</span>';
                } elseif ($data_value["Status"] == 'Disabled') {
                    $payroll_item_status = '<span class="badge badge-default badge-danger">' . $data_value["Status"] . '</span>';
                }

                $payroll_item_data = array();
                $payroll_item_data[] = $data_value["Payroll_Item_Name"];
                $payroll_item_data[] = $this->localization["Currency_Symbol"].$data_value["Payroll_Item_Amount"];
                $payroll_item_data[] = $data_value["Payroll_Item_Assigned"].'<br/> <b>'. $__employee_data["First_Name"].'</b>';
                $payroll_item_data[] = $data_value["Payroll_Item_Date"];
                $payroll_item_data[] = $data_value["Create_Type"] == 'Add_Only' ? 'Add Only' : 'Add & Assigned';
                $payroll_item_data[] = date($this->localization["Date_Format"], strtotime($data_value["Created_Date"]));
                $payroll_item_data[] = $data_value["Created_By"];
                $payroll_item_data[] = $data_value["Modified_Date"] == '0000-00-00' ? 'Not Yet Edited' : date($this->localization["Date_Format"], strtotime($data_value["Modified_Date"]));
                $payroll_item_data[] = $data_value["Modified_By"] == '' ? 'Not Yet Edited' : $data_value["Modified_By"];
                $payroll_item_data[] = $payroll_item_status;
                $payroll_item_data[] = $action_buttons;

                $data[] = $payroll_item_data;
                $serial_id++;
            }
        }

        $payroll_item_list_result_output = array(

            "draw"  => intval($_POST["draw"]),
            "recordsTotal" => intval($total_payroll_item_data),
            "recordsFiltered" => intval($total_payroll_item_filter),
            "data" => $data,
        );

        echo json_encode($payroll_item_list_result_output);
    }


    public function DeletePayrollItem($methods_and_id){

        if($methods_and_id["Delete_Method"] == 'just_delete'){
            $payroll_item_query = $this->_query->query('UPDATE payroll_items SET Delete_Type = "Just_Delete" WHERE Subscriber_ID = "' . Classes_Session::get("Loggedin_Session") . '" AND ID = "' . $methods_and_id["Payroll_Item_ID"] . '" ');
            //echo json_encode(array("Payroll Item Successfully Deleted"));

        } else {
            $payroll_item_query = $this->_query->query('DELETE FROM payroll_items WHERE ID = "' . $methods_and_id["Payroll_Item_ID"] . '" AND Subscriber_ID ="' . Classes_Session::get("Loggedin_Session") . '"');
            //echo json_encode(array("Payroll_Item_Deleted"));
        }
    }



    public function LoadManagePayroll($employee_id = '', $payroll_date = '')
    {
        $data = array();
        $serial_id = 0;

        $search_value = $_POST["search"]["value"];

        $column_order = array('Basic_Salary', 'Gross_Salary', 'Other_Deduction', 'Net_Pay', 'Created_Date', 'Created_By', 'Status', 'Modified_Date', 'Modified_By', 'Status');
        if ($_POST['order']) {
            $order_by = $column_order[$_POST['order'][0]['column']] . ' ' . $_POST['order']['0']['dir'];
        } else {
            $order_by = " ID DESC";
        }

        $query = $this->_query->query("SELECT * FROM earning WHERE Subscriber_ID = ? ORDER BY ID DESC", array(Classes_Session::get("Loggedin_Session")));
        $total_manage_earning_filter = $query->count();

        if ($_POST['length'] != -1) {
            $limit = " " . $_POST['start'] . ", " . $_POST['length'] . " ";
        }

        if (!empty($_POST["search"]["value"])) {
            $sql_manage_earning = "SELECT * FROM earning WHERE Subscriber_ID = ? AND (Basic_Salary LIKE ? OR Gross_Salary LIKE ? OR Other_Deduction LIKE ? OR Net_Pay LIKE ? OR Created_Date LIKE ? OR Created_By LIKE ? OR Status LIKE ?) ORDER BY $order_by LIMIT $limit";
            $data_value = array(Classes_Session::get("Loggedin_Session"), '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%', '%' . $search_value . '%');
            $query_result_c = $this->_query->query($sql_manage_earning, $data_value);
        } else {
            $sql_manage_earning = "SELECT * FROM earning WHERE Subscriber_ID = ?  ORDER BY ID DESC LIMIT $limit";
            $query_result_c = $this->_query->query($sql_manage_earning, array(Classes_Session::get("Loggedin_Session")));
        }


        $total_manage_earning_data = $query_result_c->count();


        if ($total_manage_earning_data > 0) {
            $fetching_results = $query_result_c->results();
            $serial_id = 1;

            //var_dump($fetching_results);

            foreach ($fetching_results as $key => $data_value) {

                $__employee_data = $this->data_manager->EmployeesDataByID($data_value["Employee_ID"])->first();
                $department_results = $this->data_manager->DepartmentDataByID($__employee_data["Department"])->first();
                $currency_results = $this->data_manager->CurrencyDataByID($__employee_data["Currency"])->first();

                $social_results = $this->data_manager->SocialSecurityDataByID($__employee_data["Social_Security"])->first();
                $association_tax_results = $this->data_manager->AssociationDataByID($__employee_data["Association"])->first();


                $exchange_rate = $data_value["Exchange_Rate"];
                $bonus = $data_value["Bonus"]; 
                $comission = $data_value["Comission"];
                $allowance = $data_value["Allowance"]; 
                $otherearning = $data_value["Other_Earning"];
                $extra1 = $data_value["Extra_Hour1"]; 
                $extra2 = $data_value["Extra_Hour2"];
                $ordinary = $data_value["Ordinary"];
                $payment_type = $data_value["Payment_Type"];
                $salary = $__employee_data["Salary"];
                $gross_salary = $data_value["Gross_Salary"];

                $loan = $data_value["Loan"];
                $assessment = $data_value["Assessment"];
                $other_deduction = $data_value["Other_Deduction"];
                $tax = $data_value["Tax"];
                $total_deduction = $data_value["Total_Deduction"];

                $net_pay = $data_value["Net_Pay"];



                    /*Calculating Currency Exchange Rate With Earnings*/
                $exchange_rate_bonus = $bonus * $exchange_rate;
                $exchange_rate_comission = $comission * $exchange_rate;
                $exchange_rate_allowance = $allowance * $exchange_rate;
                $exchange_rate_otherearning = $otherearning * $exchange_rate;
                $exchange_rate_extra1 = $extra1 * $exchange_rate;
                $exchange_rate_extra2 = $extra2 * $exchange_rate;
                $exchange_rate_ordinary = $ordinary * $exchange_rate;
                /*Ending of Currency Exchange Rate With Earnings Calculation*/



                if ($data_value["Status"] == 'Active') {
                    $manage_earning_status = '<span class="badge badge-default badge-success">' . $data_value["Status"] . '</span>';
                } elseif ($data_value["Status"] == 'Locked') {
                    $manage_earning_status = '<span class="badge badge-default badge-danger">' . $data_value["Status"] . '</span>';
                }

                $basic_salary = $payment_type == 7 ? $data_value["Basic_Salary"] : $data_value["Basic_Salary"] * $exchange_rate;

                    

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

                $employee_link = '<a class="info" style="font-size: 15px" href="' . $this->web_data["Web_Url"] . 'view-employee?employee_id=' . $__employee_data["Employee_ID"] . '"><b>' . $__employee_data["First_Name"] . ' ' . $__employee_data["Last_Name"] . '</b> </a>';


                $checkbox = '<input type="checkbox" id="select_all_manage_payroll" for="employee_name" name="select_all_manage_payroll" class="single_manage_payroll_select" value="' . $data_value["ID"] . '">';

                $manage_earning_data = array();
                $manage_earning_data[] = '<label >'.$checkbox.' '. $employee_link.'</label>';
                $manage_earning_data[] = $department_results["Department_Name"];
                $manage_earning_data[] = $currency_results["Currency_Symbol"] . number_format($basic_salary, 2);
                $manage_earning_data[] = $currency_results["Currency_Symbol"] . number_format($gross_salary, 2);
                $manage_earning_data[] = $currency_results["Currency_Symbol"] . number_format($total_deduction, 2);
                $manage_earning_data[] = $currency_results["Currency_Symbol"] . number_format($net_pay, 2);
                $manage_earning_data[] = date($this->localization["Date_Format"], strtotime($data_value["Created_Date"]));
                $manage_earning_data[] = $data_value["Created_By"];
                $manage_earning_data[] = $data_value["Modified_Date"] == '0000-00-00' ? 'Not Yet Edited' : date($this->localization["Date_Format"], strtotime($data_value["Modified_Date"]));
                $manage_earning_data[] = $data_value["Modified_By"] == '' ? 'Not Yet Edited' : $data_value["Modified_By"];
                $manage_earning_data[] = $manage_earning_status;
                $data[] = $manage_earning_data;
                $serial_id++;
            }
        }

        $manage_earning_list_result_output = array(

            "draw"  => intval($_POST["draw"]),
            "recordsTotal" => intval($total_manage_earning_data),
            "recordsFiltered" => intval($total_manage_earning_filter),
            "data" => $data,
        );

        echo json_encode($manage_earning_list_result_output);
    }


    public function DeleteManagePayroll($single_manage_payroll_select_ids){
        foreach ($single_manage_payroll_select_ids as $key => $single_employee_payroll_id) {
            $manage_payroll_query = $this->_query->query('DELETE FROM earning WHERE ID = "' . $single_employee_payroll_id . '" AND Subscriber_ID ="' . Classes_Session::get("Loggedin_Session") . '"');
        }
        echo json_encode(array("Selected_Payroll_Deleted"));

    }


    public function LockUnlockManagePayroll($single_manage_payroll_select_ids){
        foreach ($single_manage_payroll_select_ids as $key => $single_employee_payroll_id) {

            $query_result_c = $this->_query->query("SELECT * FROM earning WHERE Subscriber_ID = ? AND ID = ? ", array(Classes_Session::get("Loggedin_Session"), $single_employee_payroll_id))->first();
            $payroll_status = $query_result_c["Status"];
            if($payroll_status == 'Active'){
                $manage_payroll_query = $this->_query->query('UPDATE earning SET Status = "Locked" WHERE Subscriber_ID = "' . Classes_Session::get("Loggedin_Session") . '" AND ID = "' . $single_employee_payroll_id . '" ');
            } else {
                $manage_payroll_query = $this->_query->query('UPDATE earning SET Status = "Active" WHERE Subscriber_ID = "' . Classes_Session::get("Loggedin_Session") . '" AND ID = "' . $single_employee_payroll_id . '" ');
            }

        }
        echo json_encode(array("Selected Payroll Status Successfully Changed"));

    }


    public function SendPaymentProof($single_manage_payroll_select_ids){
        $this->payment_proof_mail->PaymentProofMail($single_manage_payroll_select_ids);
    }












}