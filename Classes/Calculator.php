<?php

class Classes_Calculator
{

    private static $__query;
    public function __construct()
    {
        self::$__query = Classes_Db::getInstance();
    }

    
    public static function ExtraHourCal($payment_type, $extra1, $extra2, $exchange_rate, $salary, $half_basicsalary, $ordinary){
        $exchange_rate_ordinary = $ordinary * $exchange_rate;
        $ordinary_with_exchange_rate_without_negative = abs($exchange_rate_ordinary); //Removing negative sign from ordinary days


        if ($payment_type == 30 || $payment_type == 15) {
            #1.5 
            $extra1_total = $salary / 30 / 8 * 1.5 * $extra1 * $exchange_rate;
            $extra2_total = $salary / 30 / 8 * 2.0 * $extra2 * $exchange_rate;

            $total_ordinary = $half_basicsalary / $payment_type * $ordinary_with_exchange_rate_without_negative;
        } elseif ($payment_type == 7) {

            $extra1_total = $half_basicsalary / 48 * 1.5 * $extra1;
            $extra2_total = $half_basicsalary / 48 * 2.0 * $extra2;

            $ordinary_without_negative = abs($ordinary);

            $total_ordinary = $half_basicsalary / 6 * $ordinary_without_negative;
        }

        return array("Total_Extra_Hour1" => $extra1_total, "Total_Extra_Hour2" => $extra2_total, "Total_Ordinary" => $total_ordinary);
    }


    public static function BasicSalaryCal($payment_type, $salary, $exchange_rate, $payment_date){
        self::$__query = Classes_Db::getInstance();

        $checking_february = substr($payment_date, 5, -3); //Catche input date month

        if ($payment_type == 15) {

            //Getting actual salary for employee with semi-monthly payment type
            $half_basicsalary = $salary / 2;
            $basicsalary = $half_basicsalary * $exchange_rate;
            $next_payment_day = $checking_february == '02' ? $next_payment_day = 13 : $next_payment_day = 14;

        } elseif ($payment_type == 7) {
            //Getting actual salary for employee with weekly payment type
            $year = date("Y");
            $getting_weeks_in_a_year = self::$__query->query("SELECT WEEKOFYEAR('$year-12-29 ') AS number_of_weeks")->first();

            $number_of_weeks = $getting_weeks_in_a_year["number_of_weeks"];

            $half_basicsalary = $salary * 12 * $exchange_rate / $number_of_weeks;
            $basicsalary = $half_basicsalary;
            $next_payment_day = 6;
        } elseif ($payment_type == 30) {

            $half_basicsalary = $salary;
            $basicsalary = $half_basicsalary * $exchange_rate;
            $next_payment_day = 29;
        }

        return array('Half_Basic_Salary' => $half_basicsalary,  "Basic_Salary" =>$basicsalary, "Next_Payment_Date" => $next_payment_day, "Number_of_Weeks" => $number_of_weeks);
    } 

    public static function GrossSalaryCal($payment_type, $gross_salary, $payment_date, $employee_id, $basicsalary, $next_payment_date, $upper_next_payment_date){

        self::$__query = Classes_Db::getInstance();


        if ($payment_type == 30) {
            $total_gross_salary = $gross_salary;
        } elseif ($payment_type == 15) {

            // Here Looking for employee last payroll date to Determine weather to use grosssalary or basic salary for calculation for employee with semi-monthly payment type
            $earning_end_date = self::$__query->query('SELECT * FROM earning WHERE Subscriber_ID = ? AND Employee_ID = ? AND YEAR(Dates) = YEAR("' . $payment_date . '") AND MONTH(Dates) = MONTH("' . $payment_date . '") AND Status = ?', array(Classes_Session::get('Loggedin_Session'), $employee_id, 'Active'));
            $query_result = $earning_end_date->first();
            $query_count = $earning_end_date->count();

            $last_compute_date = $query_result["Dates"];
            $previous_grosssalary_from_db = $query_result["Gross_Salary"];
            $previous_tax_from_db = $query_result["Tax"];

            $last_compute_year_month = substr($last_compute_date, 0, -3); //Removing day from last compute date
            $payment_date_year_month = substr($payment_date, 0, -3); //Removing day from current payment date

            //Optimize Here
            if ($payment_date > $last_compute_date && $query_count > 0) {
                $total_gross_salary = $gross_salary + $previous_grosssalary_from_db;
            } else {
                $total_gross_salary = $gross_salary + $basicsalary;
            }
        } elseif ($payment_type == 7) {


            $employee_earning_data = self::$__query->query('SELECT * FROM earning WHERE Subscriber_ID = ? AND Employee_ID = ? AND Status = ? ORDER BY ID DESC LIMIT 0,1', array(Classes_Session::get('Loggedin_Session'), $employee_id, 'Active'));
            $earning_query_result = $employee_earning_data->first();

            $last_compute_end_date = $earning_query_result["End_Date"];
            $last_compute_date = $earning_query_result["Dates"];
            $previous_grosssalary_from_db = $earning_query_result["Gross_Salary"];
            $previous_tax_from_db = $earning_query_result["Tax"];

            $last_compute_end_date_year_month = substr($last_compute_end_date, 0, -3); //Removing day from last compute end date
            $last_compute_end_date_day = substr($last_compute_end_date, 8); //Removing year month from last compute end date 

            $last_compute_year_month = substr($last_compute_date, 0, -3); //Removing day from last compute date
            $last_compute_day = substr($last_compute_date, 8); //Removing year month from last compute date 

            $next_payment_date_year_month = substr($next_payment_date, 0, -3); //Removing day from next payment date
            $upper_next_payment_date_year_month = substr($upper_next_payment_date, 0, -3); //Removing day from upper next payment date

            $payment_date_day = substr($payment_date, 8);
            $payment_date_year_month = substr($payment_date, 0, -3);




            // Here Looking for employee last payroll date to Determine which grosssalary to use for calculation for employee with semi-monthly payment type
            if (empty($last_compute_date) && empty($last_compute_end_date)) { //Looking for if employee has earning salary before
                //It mean this is the new employee
                $total_gross_salary = $gross_salary; //If no salary use current grosssalary

            } elseif ($payment_date_day >= $last_compute_end_date_day) { //Here checking if current payment date is greater or equal to last compute end date
                //The above elseif means the employee has earning in the database

                if ($last_compute_year_month == $next_payment_date_year_month) { //Here checking for last compute month and current next payment date are equal 
                    /*The above if is checking if the last compute month and year are equal to the 
                        current next payment date, That means the payroll is still same month and year*/

                    if ($last_compute_year_month == $upper_next_payment_date_year_month) { //Here checking for last compute month and current upper next payment month & year are equal
                        /*The above is checking if the last compute month and year is still equal
                            to the current upper next payment month and year then use recent gross salary*/
                        $total_gross_salary = $gross_salary;
                    } else {
                        /*Else if last compute year and month is not equal with the current upper next payment month and year
                            that means the current month has end the we need to do the total gross salary of the current month and year
                            by fetching the current month and year gross salary from database and add the current gross salary with it */

                        $grosssalarys = 0;
                        $earning_query_result_gross_salary_data = self::$__query->query('SELECT * FROM earning WHERE YEAR(Dates) = YEAR("' . $upper_next_payment_date_year_month . '" - INTERVAL 1 MONTH) AND  MONTH(Dates) = MONTH("' . $upper_next_payment_date_year_month . '" - INTERVAL 1 MONTH) AND Subscriber_ID = ? AND Employee_ID = ? AND Status = ? ORDER BY ID DESC LIMIT 0,1', array(Classes_Session::get('Loggedin_Session'), $employee_id, 'Active'));
                        $earning_query_result_gross_salaries = $earning_query_result_gross_salary_data->results();

                        foreach ($earning_query_result_gross_salaries as $key => $earning_query_result_gross_salarie) {
                            $db_gross_salary = $earning_query_result_gross_salarie["Gross_Salary"];
                            $grosssalarys += $db_gross_salary;
                        }
                        $total_gross_salary = $grosssalarys + $gross_salary;
                    }
                } else {
                    /*Else if last compute year and month is not equal with the current next payment month and year
                            that means the current month has end then we need to do the total gross salary of last month gross salary 
                            by fetching the current month and year gross salary from database and add the current gross salary with it */

                    $grosssalarys = 0;
                    $earning_query_result_gross_salary_data = self::$__query->query('SELECT * FROM earning WHERE MONTH(Dates) = MONTH("' . $upper_next_payment_date_year_month . '" - INTERVAL 1 MONTH) AND Subscriber_ID = ? AND Employee_ID = ? AND Status = ? ORDER BY ID DESC LIMIT 0,1', array(Classes_Session::get('Loggedin_Session'), $employee_id, 'Active'));
                    $earning_query_result_gross_salaries = $earning_query_result_gross_salary_data->results();

                    foreach ($earning_query_result_gross_salaries as $key => $earning_query_result_gross_salarie) {
                        $db_gross_salary = $earning_query_result_gross_salarie["Gross_Salary"];
                        $grosssalarys += $db_gross_salary;
                    }
                    $total_gross_salary = $grosssalarys + $gross_salary;
                }
            } elseif ($payment_date_day <= $last_compute_end_date_day) {
                /*But if employee has earning the database but the current payment day is less than or equal to last compute end day
                    Then use current gross salary*/
                $total_gross_salary = $gross_salary;
            }
        }

        return array('Total_Gross_Salary' => $total_gross_salary );
    }


    public static function TaxCalculator($total_gross_salary, $marital_amount, $kid_amount)
    {
        self::$__query = Classes_Db::getInstance();

        $tax = 0;
        $totalans = 0;
        $total_tax_salary = 0;
        $total_actual_tax_rate = 0;

        $tax_determinations = self::$__query->query('SELECT * FROM salary_tax_settings WHERE Status = ? AND Subscriber_ID = ? AND "' . $total_gross_salary . '" BETWEEN Salary_From AND Salary_To', array('Active', Classes_Session::get('Loggedin_Session')))->results();

        //$tax_determinations = self::$__query->query('SELECT * FROM salary_tax_settings WHERE Status = ? AND Subscriber_ID = ? AND Salary_From <= ? AND Salary_To <= ?', array('Active', Classes_Session::get('Loggedin_Session'), $total_gross_salary, $total_gross_salary))->results();
       
        foreach ($tax_determinations as $key => $tax_determination) {
            $actual_tax_rate = $tax_determination["Tax_Rate"];
            $tax_salary_from = $tax_determination["Salary_From"];
            $tax_salary_to = $tax_determination["Salary_To"];

            $tax_salary = $tax_salary_to - $tax_salary_from;
            $total_tax_salary += $tax_salary; // Calculating previous Salary before employee Salary Range
            $total_actual_tax_rate += $actual_tax_rate; // Calculating previous Tax Rate Before Employee Salary Range

            $total_tax_per = $tax_salary * $actual_tax_rate / 100;
            $total_tax = $total_tax_per += $total_tax_per;
        }

        if ($total_gross_salary  >= $tax_salary_from) {

            $salary_first_step = $total_gross_salary - $tax_salary_from;
            $total_salary_with_tax_step = $salary_first_step * $actual_tax_rate / 100;
        }

        $total_family_cal = $marital_amount + $kid_amount; // Calculating Family Total Amount

        $tax_calculation = $total_tax + $total_salary_with_tax_step;

        /*Checking if total family amount is greater than total employee tax calculation  */
        if ($total_family_cal > $tax_calculation) {
            $total_tax_calculation = 0; //If greater family total amount is greater than total tax calculation set total tax calculation to 0
        } else {
            $total_tax_calculation = $tax_calculation - $total_family_cal; //Else deduct total family amount from tax calculation 
        }

        return array('Total_Tax_Calculator' => $total_tax_calculation, 'Total_Family_Tax' => $total_family_cal);
    }


    public static function NetPaymentCal($payment_type, $tax_calculations, $total_social_security, $total_association, $total_gross_salary, $gross_salary, $payment_date_s, $employee_id, $next_payment_date, $upper_next_payment_date){
        self::$__query = Classes_Db::getInstance();

        if ($payment_type == 30) {

            $tax_calculation = $tax_calculations;
            $deduction = $total_social_security + $tax_calculation + $total_association;
            $netpay = $total_gross_salary - $deduction;

        } elseif ($payment_type == 15) {

            $total_gross_salary = $gross_salary; //Change Total Salary Value Here

            // Here Looking for employee last payroll date to Determine weather to use grosssalary or basic salary for calculation for employee with semi-monthly payment type
            $earning_end_date = self::$__query->query('SELECT * FROM earning WHERE Subscriber_ID = ? AND Employee_ID = ? AND YEAR(Dates) = YEAR("' . $payment_date_s . '") AND MONTH(Dates) = MONTH("' . $payment_date_s . '") AND Status = ?', array(Classes_Session::get('Loggedin_Session'), $employee_id, 'Active'));
            $query_result = $earning_end_date->first();
            $query_count = $earning_end_date->count();

            $last_compute_date = $query_result["Dates"];
            $previous_tax_from_db = $query_result["Tax"];

            $last_compute_year_month = substr($last_compute_date, 0, -3); //Removing day from last compute date
            $payment_date_year_month = substr($payment_date_s, 0, -3); //Removing day from current payment date

            //Optimize Here
            if ($payment_date_s > $last_compute_date && $query_count > 0) {
                $tax_calculation = $tax_calculations - $previous_tax_from_db;
                $deduction = $total_social_security + $tax_calculation + $total_association;
                $netpay = $total_gross_salary - $deduction;
            } else {
                $tax_calculation = $tax_calculations / 2;
                $deduction = $total_social_security + $tax_calculation + $total_association;
                $netpay = $total_gross_salary - $deduction;
            }
        } elseif ($payment_type == 7) {

            $employee_earning_data = self::$__query->query('SELECT * FROM earning WHERE Subscriber_ID = ? AND Employee_ID = ? AND Status = ? ORDER BY ID DESC LIMIT 0,1', array(Classes_Session::get('Loggedin_Session'), $employee_id, 'Active'));
            $earning_query_result = $employee_earning_data->first();

            $last_compute_end_date = $earning_query_result["End_Date"];
            $last_compute_date = $earning_query_result["Dates"];
            $previous_grosssalary_from_db = $earning_query_result["Gross_Salary"];
            $previous_tax_from_db = $earning_query_result["Tax"];

            $last_compute_end_date_year_month = substr($last_compute_end_date, 0, -3); //Removing day from last compute end date
            $last_compute_end_date_day = substr($last_compute_end_date, 8); //Removing year month from last compute end date 

            $last_compute_year_month = substr($last_compute_date, 0, -3); //Removing day from last compute date
            $last_compute_day = substr($last_compute_date, 8); //Removing year month from last compute date 

            $next_payment_date_year_month = substr($next_payment_date, 0, -3); //Removing day from next payment date
            $upper_next_payment_date_year_month = substr($upper_next_payment_date, 0, -3); //Removing day from upper next payment date

            $payment_date_day = substr($payment_date_s, 8);
            $payment_date_year_month = substr($payment_date_s, 0, -3);



            if (empty($last_compute_date) && empty($last_compute_end_date)) {
                //It mean this is the new employee so tax_calculation will be set to 0

                $tax_calculation = 0;
                $deduction =  $total_social_security + $total_association;
                $netpay = $total_gross_salary - $deduction;
            } elseif ($payment_date_day >= $last_compute_end_date_day) {
                //The above elseif means the employee has earning in the database


                if ($last_compute_year_month == $next_payment_date_year_month) {
                    /*The above if is checking if the last compute month and year are equal to the 
                            current next payment date, That means the payroll is still same month and year*/
                    if ($last_compute_year_month == $upper_next_payment_date_year_month) {
                        /*The above is checking if the last compute month and year is still equal
                                to the current upper next payment month and year then use recent gross salary*/
                        $tax_calculation = 0;
                        $deduction =  $total_social_security + $total_association;
                        $netpay = $total_gross_salary - $deduction;
                    } else {

                        /*Else if last compute year and month is not equal with the current upper next payment month and year
                                that means the current month has end the we need to do the total gross salary of the current month and year
                                by fetching the current month and year gross salary from database and add the current gross salary with it */

                        $deduction = $total_social_security + $tax_calculation + $total_association;
                        $netpay = $total_gross_salary - $deduction;

                        if ($gross_salary <= $total_gross_salary) {
                            $total_gross_salary = 0;
                            $total_gross_salary += $gross_salary;
                        } else {

                            $total_gross_salary = 0;
                            $total_gross_salary += $gross_salary;
                        }
                    }
                } else {

                    if ($next_payment_date_year_month != $last_compute_year_month) {

                        $tax_calculation = 0;
                        $deduction = $total_social_security + $tax_calculation + $total_association;
                        $netpay = $total_gross_salary - $deduction;
                    } else {

                        $deduction = $total_social_security + $tax_calculation + $total_association;
                        //$netpay = $grosssalary - $deduction; old calculation
                        $netpay = $total_gross_salary - $deduction;

                        if ($gross_salary <= $total_gross_salary) {
                            $total_gross_salary = 0;
                            $total_gross_salary += $gross_salary;
                        } else {

                            $total_gross_salary = 0;
                            $total_gross_salary += $gross_salary;
                        }
                    }
                }
            } elseif ($payment_date_day <= $last_compute_end_date_day) {

                $tax_calculation = 0;
                $deduction = $total_social_security + $total_association;
                $netpay = $total_gross_salary - $deduction;
            }
        }


        return array('Tax_Calculation' => $tax_calculation, "Deduction" => $deduction, "Netpay" => $netpay);
    }


    
}
