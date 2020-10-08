<?php

class Classes_PayrollTable
{

    private static $__query, $data_manager;
    public function __construct()
    {
        self::$__query = Classes_Db::getInstance();
    }

    public static function TableCalculator($data_value){

        self::$data_manager = new Controller_Company_Default_Datamanagement();

        $__employee_data = self::$data_manager->EmployeesDataByID($data_value["Employee_ID"])->first();
        $department_results = self::$data_manager->DepartmentDataByID($__employee_data["Department"])->first();
        $currency_results = self::$data_manager->CurrencyDataByID($__employee_data["Currency"])->first();

        $social_results = self::$data_manager->SocialSecurityDataByID($__employee_data["Social_Security"])->first();
        $association_tax_results = self::$data_manager->AssociationDataByID($__employee_data["Association"])->first();

        $marital_results = self::$data_manager->MaritalDataByID($data_value["Marital"])->first();
        $family_tax_results = self::$data_manager->FamilyTaxDataByID($data_value["Kids"])->first();


        $marital_amount = $marital_results['Married_Amount'];
        $kid_amount = $family_tax_results['Kid_Amount'];


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
            $history_earning_status = '<span class="badge badge-default badge-success">' . $data_value["Status"] . '</span>';
        } elseif ($data_value["Status"] == 'Locked') {
            $history_earning_status = '<span class="badge badge-default badge-danger">' . $data_value["Status"] . '</span>';
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

        $emp_id = $__employee_data["Emp_ID"];
        $employee_id = $__employee_data["Employee_ID"];
        $first_name = $__employee_data["First_Name"];
        $last_name = $__employee_data["Last_Name"];



        return array(
            "Emp_ID" => $emp_id,
            "Employee_ID" => $employee_id,
            "Exchange_Rate" => $exchange_rate, 
            "Bonus" => $bonus, 
            "Comission" => $comission, 
            "Allowance" => $allowance, 
            "Other_Earning" => $otherearning,
            "Extra_Hour1" => $extra1,
            "Extra_Hour2" => $extra2,
            "Ordinary" => $ordinary,
            "Payment_Type" => $payment_type,
            "Salary" => $salary,
            "Gross_Salary" => $gross_salary,
            "Loan" => $loan,
            "Assessment" => $assessment,
            "Other_Deduction" => $other_deduction,
            "Tax" => $tax,
            "Total_Deduction" => $total_deduction,
            "Net_Pay" => $net_pay,
            "Exchange_Rate_Bonus" => $exchange_rate_bonus,
            "Exchange_Rate_Comission" => $exchange_rate_comission,
            "Exchange_Rate_Allowance" => $exchange_rate_allowance,
            "Exchange_Rate_Other_Earning" => $exchange_rate_otherearning,
            "Exchange_Rate_Extra_Hour1" => $exchange_rate_extra1,
            "Exchange_Rate_Extra_Hour2" => $exchange_rate_extra2,
            "Exchange_Rate_Ordinary" => $exchange_rate_ordinary,
            "Status" => $history_earning_status,
            "Basic_Salary" => $basic_salary,
            "Total_Extra_Hour1" => $extra1_total,
            "Total_Extra_Hour2" => $extra2_total,
            "Total_Ordinary" => $total_ordinary,
            "SOS" => $social_rate,
            "ASO" => $association_rate,
            "Total_SOS" => $total_social_security,
            "Total_ASO" => $total_association,
            "Currency_Symbol" => $currency_results["Currency_Symbol"],
            "Currency_Name" => $currency_results["Currency_Name"],
            "Dates" => $data_value["Dates"],
            "End_Date" => $data_value["End_Date"],
            "First_Name" => $first_name,
            "Last_Name" => $last_name,
            "Married_Amount" => $marital_amount,
            "Kid_Amount" => $kid_amount,
            "Department_Name" => $department_results["Department_Name"]


            );
    }



    public static function TerminationCalculator($completion_employee_id, $employee_ending_date, $employee_firing_type){

        $loggined_session = Classes_Session::get('Loggedin_Session');
        self::$data_manager = new Controller_Company_Default_Datamanagement();


        $employee_data = self::$data_manager->EmployeesDataByID($completion_employee_id)->first();
        $earning_data = self::$data_manager->EmployeeEarningByID($completion_employee_id)->first();
        $department_results = self::$data_manager->DepartmentDataByID($employee_data["Department"])->first();
        $vacation_results = self::$data_manager->VacationDataByID($employee_data['Vacation'])->first();



        $employee_input_id = $employee_data['Emp_ID'];
        $employee_id = $employee_data['Employee_ID'];
        $first_name = $employee_data['First_Name'];
        $last_name = $employee_data['Last_Name'];
        $department = $department_results['Department_Name'];
        $hire_date = $employee_data['HireDate'];
        $vacation_day = $vacation_results['Vacation_Day'];

        $iteration = 0;
        $total_working_day_in_12_months = 0;
        $total_working_day_in_6_months = 0;
        $total_gross_salary_in_6_months = 0;
        $gross_salary_12_month = 0;
        $gross_salary_6_month = 0;
        $total_gross_salary_in_12_months = 0;
        $total_netpay_in_6_months = 0;
        $total_netpay_in_12_months = 0;
        $total_6_month_average = 0;
        $total_daily_average = 0;
        $month = 0;
        $current_month_amount = 0;
        $employee_earning_per_day = 0;

        $basic_salary = $earning_data['Basic_Salary'];
        $payment_type = $employee_data['Payment_Type'];

        if ($payment_type == 15) {
            $employee_earning_per_day = $basic_salary / 15;
        } elseif ($payment_type == 7) {
            $employee_earning_per_day = $basic_salary / 7;
        } elseif ($payment_type == 30) {
            $employee_earning_per_day = $basic_salary / 30;
        }

        /* Calculating Current Gross Salary */
        $current_date_day = substr($employee_ending_date, 8);
        $current_date_month_gross_salary = $employee_earning_per_day * $current_date_day;


        /*Here we are getting if select date ($employee_ending_date) year & month is in the database */
        $select_date_query = self::$__query->query("SELECT * FROM earning WHERE Subscriber_ID = '$loggined_session' AND year(Dates) = year('$employee_ending_date') AND month(Dates) = month('$employee_ending_date') AND Employee_ID='$employee_id' ORDER BY ID DESC LIMIT 1");
        $select_date_query_count = $select_date_query->count();


        /*Count 6 Month Payroll of work ago*/
        if ($payment_type == 30) {
            $get_record_6_months = self::$__query->query("SELECT * FROM earning WHERE Subscriber_ID = ? AND Employee_ID = ? ORDER BY Dates DESC LIMIT 6", array(Classes_Session::get('Loggedin_Session'), $employee_id));
        } elseif ($payment_type == 15) {
            $get_record_6_months = self::$__query->query("SELECT * FROM earning WHERE Subscriber_ID = ? AND Employee_ID = ? ORDER BY Dates DESC LIMIT 12", array(Classes_Session::get('Loggedin_Session'), $employee_id));
        } elseif ($payment_type == 7) {
            $get_record_6_months = self::$__query->query("SELECT * FROM earning WHERE Subscriber_ID = ? AND Employee_ID = ? ORDER BY Dates DESC LIMIT 24", array(Classes_Session::get('Loggedin_Session'), $employee_id));
        }
        $get_record_6_month_count = $get_record_6_months->count(); //Counting the number of month in the database 
        $get_record_6_months_data_results = $get_record_6_months->results();


        if ($payment_type == 30) {
            $get_record_6_month_count = $get_record_6_month_count;
        } elseif ($payment_type == 15) {
            $get_record_6_month_count = $get_record_6_month_count / 2;
        } elseif ($payment_type == 7) {
            $get_record_6_month_count = $get_record_6_month_count / 4;
        }



        /*Here we are calculating 12 Month Salary calculation */
        if ($payment_type == 30) {
            $get_record_12_months = self::$__query->query("SELECT * FROM earning WHERE Subscriber_ID='$loggined_session' AND Employee_ID = '$employee_id' AND DATE(Dates) BETWEEN CONCAT(YEAR(NOW())-1,'-12-00') AND NOW() ORDER BY Dates DESC LIMIT 12");
        } elseif ($payment_type == 15) {
            $get_record_12_months = self::$__query->query("SELECT * FROM earning WHERE Subscriber_ID='$loggined_session' AND Employee_ID = '$employee_id' AND DATE(Dates) BETWEEN CONCAT(YEAR(NOW())-1,'-12-00') AND NOW() ORDER BY Dates DESC LIMIT 24");
        } elseif ($payment_type == 7) {
            $get_record_12_months = self::$__query->query("SELECT * FROM earning WHERE Subscriber_ID='$loggined_session' AND Employee_ID = '$employee_id' AND DATE(Dates) BETWEEN CONCAT(YEAR(NOW())-1,'-12-00') AND NOW() ORDER BY Dates DESC LIMIT 52");
        }
        $get_record_12_month_count = $get_record_12_months->count(); //Counting the number of month in the database 
        $get_record_12_months_data_results = $get_record_12_months->results();

        $number_of_days_in_12_months = $get_record_12_month_count * 30; // Multiply the number of month by 30 to get the number of days



        foreach ($get_record_6_months_data_results as $key => $get_record_6_months_data_result) {

            //Count 6 Gross Salary records 
            $total_gross_salary_in_6_months += $get_record_6_months_data_result["Gross_Salary"];

            $gross_salary_6_months = $select_date_query_count > 0 ? $total_gross_salary_in_6_months : $current_date_month_gross_salary + $total_gross_salary_in_6_months;

            $total_working_day_in_6_months += $payment_type;

            $total_6_months_gross_salary = $gross_salary_6_months / $total_working_day_in_6_months;
        }
        $total_6_month_average += $total_6_months_gross_salary;
                                            /*Ending of six month salary*/





        return array();




    }


    public static function Month12SalaryCal($get_record_12_months_data_result){

        $month_12_gross_salary = $get_record_12_months_data_result['Gross_Salary'];
        $month_12_earning_date = $get_record_12_months_data_result['Dates'];
        $month_12_exchange_rate = $get_record_12_months_data_result['Exchange_Rate'];

        if ($select_date_query_count > 0) {

            $total_working_day_in_12_months_final = $get_record_6_month_count > 6 ? $total_working_day_in_12_months : $total_working_day_in_6_months;
            $total_gross_salary_in_12_months = $gross_salary_12_month;
        } else {

            $total_working_day_in_12_months_final = $total_working_day_in_12_months + $current_date_day;
            $total_gross_salary_in_12_months = $current_date_month_gross_salary + $total_gross_salary_in_12_months;
        }

        $total_working_day_in_12_months += $payment_type;

        $total_gross_salary_in_12_months += $month_12_gross_salary;

        $total_12_month_average = $total_gross_salary_in_12_months / $total_working_day_in_12_months;
        $total_daily_average += $total_12_month_average;

        $total_daily_average_12_months = $total_gross_salary_in_12_months / $total_working_day_in_12_months_final;


        /*Here looking for last december in the database*/
        $last_december_query = self::$__query->query("SELECT Dates, SUM(GrossSalary) AS Last_December FROM earning WHERE DATE(Dates) BETWEEN CONCAT(YEAR('$employee_ending_date')-1,'-12-00') AND NOW() AND Employee_ID = '$employee_id' AND Subscriber_ID='$loggined_session'  ");
        $last_december_date = $last_december_query->first();

        $last_december_date = $last_december_date["Dates"];

        $month_12_earning_date_month = substr($month_12_earning_date, 5, -3);
        $last_december_gross_salary = $last_december_date["Last_December"];


        $total_december_gross_salary = $select_date_query_count > 0 ? $last_december_gross_salary : $last_december_gross_salary + $current_date_month_gross_salary;


        $leave_data_query = self::$__query->query('SELECT * FROM employee_available_leave WHERE Subscriber_ID = ? AND Employee_ID = ?', array(Classes_Session::get("Loggedin_Session"), $employee_id));
        $avaliable_leave_data = $leave_data_query->first();
        $leave_data_count = $leave_data_query->count();
        $total_available_leave = $avaliable_leave_data["Total_Available_Leave"];


        $leave_day_asked_data = self::$__query->query('SELECT SUM(Days_Asked) AS Days_Asked FROM employee_leave WHERE Subscriber_ID = ? AND Employee_ID = ?', array(Classes_Session::get("Loggedin_Session"), $employee_id))->first();
        $days_asked = $leave_day_asked_data["Days_Asked"];

        $days_asked = $days_asked > 0 ? $days_asked : 0;


        //Calculate Vacation Day Difference
        $working_day_query = self::$__query->query("SELECT DATEDIFF(CURDATE(), '$hire_date') / 30 AS Working_Days FROM  employee WHERE Subscriber_ID = ? AND Employee_ID= ? ", array(Classes_Session::get("Loggedin_Session"), $employee_id))->first();

        $total_vacation = $vacation_day / 12;
        $working_day = $working_day_query["Working_Days"];
        $total_working_day = $working_day * $total_vacation;
        $total_final_working_day = $total_working_day - $days_asked;

        $aguinaldo = $total_december_gross_salary / 12;
        $total_vacations = abs($total_final_working_day);

        
    }
}
