<?php

class Model_Company_TerminationModel
{

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
    

    public function Completetion($completion_employee_id, $employee_ending_date, $employee_firing_type){

        $loggined_session = Classes_Session::get('Loggedin_Session');
        $employee_completion_result='';
        $employee_rights_textbox='';

        $employee_data = $this->data_manager->EmployeesDataByID($completion_employee_id)->first();
        $earning_data = $this->data_manager->EmployeeEarningByID($completion_employee_id)->first();
        $department_results = $this->data_manager->DepartmentDataByID($employee_data["Department"])->first();
        $vacation_results = $this->data_manager->VacationDataByID($employee_data['Vacation'])->first();



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
        $select_date_query = $this->_query->query("SELECT * FROM earning WHERE Subscriber_ID = '$loggined_session' AND year(Dates) = year('$employee_ending_date') AND month(Dates) = month('$employee_ending_date') AND Employee_ID='$employee_id' ORDER BY ID DESC LIMIT 1");
        $select_date_query_count = $select_date_query->count();


        /*Count 6 Month Payroll of work ago*/
        if ($payment_type == 30) {
           $get_record_6_months = $this->_query->query("SELECT * FROM earning WHERE Subscriber_ID = ? AND Employee_ID = ? ORDER BY Dates DESC LIMIT 6", array(Classes_Session::get('Loggedin_Session'), $employee_id));
        } elseif ($payment_type == 15) {
            $get_record_6_months = $this->_query->query("SELECT * FROM earning WHERE Subscriber_ID = ? AND Employee_ID = ? ORDER BY Dates DESC LIMIT 12", array(Classes_Session::get('Loggedin_Session'), $employee_id));
        } elseif ($payment_type == 7) {
            $get_record_6_months = $this->_query->query("SELECT * FROM earning WHERE Subscriber_ID = ? AND Employee_ID = ? ORDER BY Dates DESC LIMIT 24", array(Classes_Session::get('Loggedin_Session'), $employee_id));
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
            $get_record_12_months = $this->_query->query("SELECT * FROM earning WHERE Subscriber_ID='$loggined_session' AND Employee_ID = '$employee_id' AND DATE(Dates) BETWEEN CONCAT(YEAR(NOW())-1,'-12-00') AND NOW() ORDER BY Dates DESC LIMIT 12");
        } elseif ($payment_type == 15) {
            $get_record_12_months = $this->_query->query("SELECT * FROM earning WHERE Subscriber_ID='$loggined_session' AND Employee_ID = '$employee_id' AND DATE(Dates) BETWEEN CONCAT(YEAR(NOW())-1,'-12-00') AND NOW() ORDER BY Dates DESC LIMIT 24");
        } elseif ($payment_type == 7) {
            $get_record_12_months = $this->_query->query("SELECT * FROM earning WHERE Subscriber_ID='$loggined_session' AND Employee_ID = '$employee_id' AND DATE(Dates) BETWEEN CONCAT(YEAR(NOW())-1,'-12-00') AND NOW() ORDER BY Dates DESC LIMIT 52");
        }
        $get_record_12_month_count = $get_record_12_months->count(); //Counting the number of month in the database 
        $get_record_12_months_data_results = $get_record_12_months->results();

        $number_of_days_in_12_months = $get_record_12_month_count * 30; // Multiply the number of month by 30 to get the number of days



        $employee_completion_result .='
        
        <section class="card">
            <div id="invoice-template" class="card-body">
                <!-- Invoice Company Details -->
                <h2><b data-i18n="broking_completion">Broking Labor-Management Contract</b></h2>
                <br/><br/><br/>
                <div class="row">
                    <div class="col-md-4">
                        <div class=" text-left">
                            <h4 class="card-title"><h7 data-i18n="employee_id">Employee ID</h7>: <b>' . $employee_input_id . '</b></h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class=" text-center">
                            <h4 class="card-title"><h7 data-i18n="name_of_employee">Employee Name</h7>: <b>' . $first_name . ' ' . $last_name . '</b></h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class=" text-center">
                            <h4 class="card-title"><h7 data-i18n="department_name">Department</h7>: <b>' . $department . '</b></h4>
                        </div>
                    </div>
                </div>
                <br/>
          
                <div class="row">
                    <div class="col-md-4">
                        <div class=" text-left">
                            <h4 class="card-title"><h7 data-i18n="contract_date">Contracted Date</h7>: <b>' . $hire_date . '</b></h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class=" text-center">
                            <h4 class="card-title"><h7 data-i18n="ending_date">Ending Date</h7>: <b>' . $employee_ending_date . '</b></h4>
                        </div>
                    </div>
                </div>
                <!--/ Invoice Company Details -->
                <!-- Invoice Items Details -->
                <div id="invoice-items-details" class="pt-2">

                    <div class="row">
                        <div class="table-responsive col-sm-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th data-i18n="month">MONTH</th>
                                        <th data-i18n="gross_salary">GROSS SALARY</th>
                                        <th data-i18n="days_work">DAYS WORKED</th>
                                        <th data-i18n="daily_average">DAILY AVERAGE</th>
                                    </tr>
                                </thead>
                                <tbody>';
                                        foreach ($get_record_6_months_data_results as $key => $get_record_6_months_data_result) {

                                            //Count 6 Gross Salary records 
                                            $total_gross_salary_in_6_months += $get_record_6_months_data_result["Gross_Salary"];

                                            $gross_salary_6_months = $select_date_query_count > 0 ? $total_gross_salary_in_6_months : $current_date_month_gross_salary + $total_gross_salary_in_6_months;

                                            $total_working_day_in_6_months += $payment_type;

                                            $total_6_months_gross_salary = $gross_salary_6_months / $total_working_day_in_6_months;
   
                                        }
                                            $total_6_month_average += $total_6_months_gross_salary;
                                            /*Ending of six month salary*/


                                        foreach ($get_record_12_months_data_results as $key => $get_record_12_months_data_result) {
                                            $iteration++;

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
                                            $last_december_query = $this->_query->query("SELECT Dates, SUM(GrossSalary) AS Last_December FROM earning WHERE DATE(Dates) BETWEEN CONCAT(YEAR('$employee_ending_date')-1,'-12-00') AND NOW() AND Employee_ID = '$employee_id' AND Subscriber_ID='$loggined_session'  ");
                                            $last_december_date = $last_december_query->first();

                                            $last_december_date = $last_december_date["Dates"];

                                            $month_12_earning_date_month = substr($month_12_earning_date, 5, -3);
                                            $last_december_gross_salary = $last_december_date["Last_December"];


                                            $total_december_gross_salary = $select_date_query_count > 0 ? $last_december_gross_salary : $last_december_gross_salary + $current_date_month_gross_salary;


                                            $leave_data_query = $this->_query->query('SELECT * FROM employee_available_leave WHERE Subscriber_ID = ? AND Employee_ID = ?', array(Classes_Session::get("Loggedin_Session"), $employee_id));
                                            $avaliable_leave_data = $leave_data_query->first();
                                            $leave_data_count = $leave_data_query->count();
                                            $total_available_leave = $avaliable_leave_data["Total_Available_Leave"];


                                            $leave_day_asked_data = $this->_query->query('SELECT SUM(Days_Asked) AS Days_Asked FROM employee_leave WHERE Subscriber_ID = ? AND Employee_ID = ?', array(Classes_Session::get("Loggedin_Session"), $employee_id))->first();
                                            $days_asked = $leave_day_asked_data["Days_Asked"];

                                            $days_asked = $days_asked > 0 ? $days_asked : 0;


                                            //Calculate Vacation Day Difference
                                            $working_day_query = $this->_query->query("SELECT DATEDIFF(CURDATE(), '$hire_date') / 30 AS Working_Days FROM  employee WHERE Subscriber_ID = ? AND Employee_ID= ? ", array(Classes_Session::get("Loggedin_Session"), $employee_id))->first();
           
                                            $total_vacation = $vacation_day / 12;
                                            $working_day = $working_day_query["Working_Days"];
                                            $total_working_day = $working_day * $total_vacation;
                                            $total_final_working_day = $total_working_day - $days_asked;

                                            $aguinaldo = $total_december_gross_salary / 12;
                                            $total_vacations = abs($total_final_working_day);

                                            if ($get_record_6_month_count > 6) {
                                                $total_daily_average_12_months = $total_gross_salary_in_12_months / $total_working_day_in_12_months_final / $month_12_exchange_rate;
                                            } else {
                                                $total_daily_average_12_months = $total_6_month_average / $month_12_exchange_rate;
                                            }

                                            $total_vacation_day_cal = $total_working_day * $total_daily_average_12_months;

                                            $employee_completion_result .='
                                                <tr>
                                                    <td>' . $iteration . '</td>
                                                    <td>' . date($this->localization["Date_Format"], strtotime($month_12_earning_date)) . '</td>
                                                    <td>' . number_format($month_12_gross_salary / $month_12_exchange_rate, 2) . '</td>
                                                    <td>' . $payment_type . '</td>
                                                    <td>' . number_format($total_12_month_average / $month_12_exchange_rate, 2) . '</td>
                                                </tr>';

                                        }


                                        if ($employee_firing_type == 'Right') {

                                            $employee_rights_textbox .= '

                                            <div class="col-12 m-t-30">
                                                <!-- Card -->
                                                <div class="card text-center">
                                                    <div class="input-daterange input-group" id="date-range">

                                                        <label data-i18n="notice">NOTICE: </label>&nbsp;
                                                        <input type="hidden" class="form-control col-md-12" id="termination_employee_id" value="' . $employee_id . '">
                                                        <input type="hidden" class="form-control col-md-12" id="aguinaldo" value="' . $aguinaldo . '">
                                                        <input type="hidden" class="form-control col-md-12" id="total_6_month_average" value="' . $total_6_month_average . '">
                                                        <input type="hidden" class="form-control col-md-12" id="employee_firing_type" value="' . $employee_firing_type . '">
                                                        <input type="hidden" class="form-control col-md-12" id="employee_ending_date" value="' . $employee_ending_date . '">
                                                    
                                                        <select class="select2 form-control col-md-12" name="searchempids" required id="preaviso">
                                                            <option value="" selected disabled>Select Employee Preaviso</option>
                                                            <option value="7">7 Days</option>
                                                            <option value="15">15 Days</option>
                                                            <option value="30">30 Days</option>
                                                        </select> 

                                                        &nbsp;
                                                        <div class="input-daterange col-md-6 input-group" id="date-range">
                                                            <label data-i18n="unemployement">UNEMPLOYMENT: </label>&nbsp;

                                                            <select class="select2 form-control col-md-12" name="searchempids" required id="cesantia">
                                                                <option value="" selected disabled>Select Employee Cesantia</option>
                                                                <option value="7.0">3-6 Months (7 Days)</option>
                                                                <option value="14.0">6-12 Months (14 Days)</option>
                                                                <option value="20.5">1 year (20.5 Days)</option>
                                                                <option value="41.0">2 years (41.0 Days)</option>
                                                                <option value="61.5">3 years (61.5 Days)</option>
                                                                <option value="82.0">4 years (82.0 Days)</option>
                                                                <option value="102.5">5 years (102.5 Days)</option>
                                                                <option value="123.0">6 years (123.0 Days)</option>
                                                                <option value="143.5">7 years (143.5 Days)</option>
                                                                <option value="164.0">8 years (164.0 Days)</option>
                                                            </select> 
                                                        </div>
                                                        &nbsp;
                                                    </div>
                                                </div>
                                            </div>';
                                        }

                                        if ($select_date_query_count < 0) {
                                            $employee_completion_result .= '
                                            <tr>
                                                <td data-i18n="current_month">Current Month</td>
                                                <td>' . $employee_ending_date . '</td>
                                                <td>' . number_format($current_date_month_gross_salary / $month_12_exchange_rate, 2) . '</td>
                                                <td>' . $current_date_day . '</td>
                                                <td>' . number_format($total_12_month_average / $month_12_exchange_rate, 2) . '</td>
                                            </tr>';
                                        }
                            
                                        
                                            $employee_completion_result.= '
                                            <tr>
                                                <td></td>
                                                <td data-i18n="total_12_month">Total 12 Months</td>
                                                <td>'.number_format($gross_salary_6_months/ $month_12_exchange_rate,2).'</td>
                                                <td>'. $total_working_day_in_12_months_final.'</td>
                                                <td>'.number_format($total_daily_average_12_months,2).'</td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td data-i18n="total_6_month">Total 6 Months</td>
                                                <td>'.number_format($gross_salary_6_months/ $month_12_exchange_rate,2).'</td>
                                                <td>'. $total_working_day_in_6_months.'</td>
                                                <td>'.number_format($total_6_month_average/ $month_12_exchange_rate,2).' </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td data-i18n="last_december">Last December</td>
                                                <td>'.number_format($total_gross_salary_in_12_months/ $month_12_exchange_rate,2).'</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                    </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-4">
                            <div class=" text-left">
                            <h4 class="card-title">AGUINALDO = <b>'.number_format($total_gross_salary_in_12_months/ 12 / $month_12_exchange_rate,2).'</b></h4>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class=" text-center">
                            <h4 class="card-title"><h7 data-i18n="vacation_day">VACATIONS DAYS</h7> = <b>'.number_format($total_vacation_day_cal,2).'</b></h4>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class=" text-center">
                            <h4 class="card-title"><h7 data-i18n="available_day">Available Days</h7> = <b>'.$total_available_leave.'</b></h4>
                            </div>
                        </div>
                    </div>
                                            
                    <br/>
                                            
                    <div class="row">
                        <div class="col-md-4">
                            <div class=" text-left">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class=" text-center">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class=" text-center">
                            <h4 class="card-title"><h7 data-i18n="day_asked">Days Asked</h7> = <b>'. $days_asked.'</b> </h4>
                            </div>
                        </div>
                    </div>
                                                    
                    <!-- Invoice Footer -->
                    <br/><br/>
                    <div id="invoice-footer">
                        <div class="row">
                            '.$employee_rights_textbox. '
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group ">
                                    <label data-i18n="comment">Comments:</label>
                                    <textarea class="form-control" id="completion_comment" rows="5" width="50px"></textarea>
                                </div>  
                            </div>
                        </div>
                    </div>
                    <!--/ Invoice Footer -->
                </div>

                 <center>
                    <div class="col-md-5 col-sm-12 text-center">
                        <button type="button" id="completion_btn" class="btn btn-info btn-lg my-1" data-i18n="submit_btn"> Submit</button>
                    </div>
                </center>

            </div>
        </section>';
        echo ($employee_completion_result);




    }
}
