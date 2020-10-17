<?php

class Controller_Company_Default_Datamanagement
{

    private static $_query, $login_in_session, $user_login_session;

    public function __construct()
    {
        self::$_query = Classes_Db::getInstance();

        self::$login_in_session = Classes_Session::get("Loggedin_Session");
        self::$user_login_session = Classes_Session::get("Login_ID");
        
    }


    public function WebData()
    {
        return self::$_query->get('web_config', array('ID', '=', '1'));
    }

    public function SubscriptionPackage($plan_type)
    {
        return self::$_query->get('package_plan', array('Plan_Type', '=', $plan_type));
    }

    public function PackageCount()
    {
        return self::$_query->query('SELECT * FROM package_plan');
    }


    public function CompanyDataByID()
    {
        return self::$_query->get('company', array('Subscriber_ID', '=', self::$login_in_session));
    }

    public function CompanyData($company_email)
    {
        return self::$_query->get('company', array('Company_Email', '=', $company_email));
    }

    public function CompanyEmailData()
    {
        return self::$_query->get('email_config', array('Subscriber_ID', '=', self::$login_in_session));
    }

    public function ModuleData()
    {
        return self::$_query->get('modules', array('Status', '=', 'Active'));
        //return self::$_query->get('modules', array('Company_Email', '=', $login_in_session));
    }

    public function CompanyModuleData($role)
    {
        return self::$_query->query('SELECT * FROM role_permission WHERE Subscriber_ID = ? AND Role_Name = ?', array(self::$login_in_session, $role));
        //return self::$_query->get('modules', array('Company_Email', '=', $login_in_session));
    }

    public function CompanyModuleDataByID()
    {
        return self::$_query->get('role_permission', array('Subscriber_ID', '=', self::$login_in_session));
    }


    public function CountryWithCurrency(){
        return self::$_query->query('SELECT * FROM country_currency ORDER BY country ASC');
    }

    public function CountryTimezone()
    {
        return self::$_query->query('SELECT * FROM country_timestamp');
    }

    public function LocalizationData()
    {
        return self::$_query->get('localization', array('Subscriber_ID', '=', self::$login_in_session));
    }

    public function ThemeData()
    {
        return self::$_query->get('theme', array('Subscriber_ID', '=', self::$login_in_session));
    }

    public function EmailData()
    {
        return self::$_query->get('email_config', array('Subscriber_ID', '=', self::$login_in_session));
    }

    public function RolePermissionData()
    {
        return self::$_query->get('role_permission', array('Subscriber_ID', '=', self::$login_in_session));
    }

    public function ClientData()
    {
        return self::$_query->query('SELECT * FROM clients WHERE Subscriber_ID = ? AND Status = ?', array(self::$login_in_session, 'Active'));
    }


    public function EmployeesData()
    {
        return self::$_query->query('SELECT * FROM employee WHERE Subscriber_ID = ? AND Status = ?', array(self::$login_in_session, 'Active'));
    }


    public function EmployeesDataByID($employee_id)
    {
        return self::$_query->query('SELECT * FROM employee WHERE Subscriber_ID = ? AND Employee_ID = ? AND Status = ?', array(self::$login_in_session, $employee_id, 'Active'));
    }


    public function ProjectData($project_id)
    {
        return self::$_query->query('SELECT * FROM projects WHERE Subscriber_ID = ? AND Project_ID = ?', array(self::$login_in_session, $project_id));
    }

    public function InvoiceData($invoice_id)
    {
        return self::$_query->query('SELECT * FROM invoice WHERE Subscriber_ID = ? AND Invoice_ID = ?', array(self::$login_in_session, $invoice_id));
    }

    public function InvoiceItemData($invoice_id)
    {
        return self::$_query->query('SELECT * FROM invoice_items WHERE Subscriber_ID = ? AND Invoice_ID = ?', array(self::$login_in_session, $invoice_id));
    }

    public function InvoiceItemDataByName($invoice_item_name)
    {
        return self::$_query->query('SELECT * FROM invoice_items WHERE Subscriber_ID = ? AND Item_Name = ?', array(self::$login_in_session, $invoice_item_name));
    }

    public function ClientDataByID($client_id)
    {
        return self::$_query->query('SELECT * FROM clients WHERE Subscriber_ID = ? AND Client_ID = ?', array(self::$login_in_session, $client_id));
    }


    public function JournalData()
    {
        return self::$_query->query('SELECT * FROM journal_report WHERE Subscriber_ID = ?', array(self::$login_in_session));
    }


    public function isLogin(){
        return self::$_query->query('SELECT * FROM users WHERE Subscriber_ID = ? AND User_ID = ?', array(self::$login_in_session, self::$user_login_session));
    }

    public function BranchData()
    {
        return self::$_query->query('SELECT * FROM branch WHERE Subscriber_ID = ? AND Status = ?', array(self::$login_in_session, 'Active'));
    }

    public function DepartmentData()
    {
        return self::$_query->query('SELECT * FROM department WHERE Subscriber_ID = ? AND Status = ?', array(self::$login_in_session, 'Active'));
    }

    public function MaritalStatusData()
    {
        return self::$_query->query('SELECT * FROM marital_status WHERE Subscriber_ID = ? AND Status = ?', array(self::$login_in_session, 'Active'));
    }

    public function CountriesListData()
    {
        return self::$_query->query('SELECT * FROM countries ');
    }

    public function SocialSecurityData()
    {
        return self::$_query->query('SELECT * FROM social_security WHERE Subscriber_ID = ? AND Status = ?', array(self::$login_in_session, 'Active'));
    }

    public function VacationData()
    {
        return self::$_query->query('SELECT * FROM vacation WHERE Subscriber_ID = ? AND Status = ?', array(self::$login_in_session, 'Active'));
    }

    public function AssociationData()
    {
        return self::$_query->query('SELECT * FROM association WHERE Subscriber_ID = ? AND Status = ?', array(self::$login_in_session, 'Active'));
    }

    public function CurrencyData()
    {
        return self::$_query->query('SELECT * FROM currency WHERE Subscriber_ID = ? AND Status = ?', array(self::$login_in_session, 'Active'));
    }

    public function FamilyTaxData()
    {
        return self::$_query->query('SELECT * FROM family_tax WHERE Subscriber_ID = ? AND Status = ?', array(self::$login_in_session, 'Active'));
    }

    public function DepartmentDataByID($department_id){
        return self::$_query->query("SELECT * FROM department WHERE Subscriber_ID = ? AND ID = ? AND Status = ?", array(self::$login_in_session, $department_id, 'Active'));
    }

    public function BranchDataByID($branch_id)
    {
        return self::$_query->query("SELECT * FROM branch WHERE Subscriber_ID = ? AND ID = ? AND Status = ?", array(self::$login_in_session, $branch_id, 'Active'));
    }

    public function MaritalDataByID($marital_id)
    {
        return self::$_query->query("SELECT * FROM marital_status WHERE Subscriber_ID = ? AND ID = ? AND Status = ?", array(self::$login_in_session, $marital_id, 'Active'));
    }

    public function FamilyTaxDataByID($tax_id)
    {
        return self::$_query->query("SELECT * FROM family_tax WHERE Subscriber_ID = ? AND ID = ? AND Status = ?", array(self::$login_in_session, $tax_id, 'Active'));
    }

    public function SocialSecurityDataByID($social_id)
    {
        return self::$_query->query("SELECT * FROM social_security WHERE Subscriber_ID = ? AND ID = ? AND Status = ?", array(self::$login_in_session, $social_id, 'Active'));
    }

    public function AssociationDataByID($association_id)
    {
        return self::$_query->query("SELECT * FROM association WHERE Subscriber_ID = ? AND ID = ? AND Status = ?", array(self::$login_in_session, $association_id, 'Active'));
    }

    public function VacationDataByID($vacation_id)
    {
        return self::$_query->query("SELECT * FROM vacation WHERE Subscriber_ID = ? AND ID = ? AND Status = ?", array(self::$login_in_session, $vacation_id, 'Active'));
    }

    public function SalaryTaxDataByID($salary_tax_id)
    {
        return self::$_query->query("SELECT * FROM salary_tax_settings WHERE Subscriber_ID = ? AND ID = ? AND Status = ?", array(self::$login_in_session, $salary_tax_id, 'Active'));
    }

    public function CurrencyDataByID($currency_id)
    {
        return self::$_query->query("SELECT * FROM currency WHERE Subscriber_ID = ? AND ID = ? AND Status = ?", array(self::$login_in_session, $currency_id, 'Active'));
    }

    public function projectDataByEmployee($employee_id)
    {
        return self::$_query->query("SELECT * FROM projects WHERE Subscriber_ID = ? AND Leader = ?", array(self::$login_in_session, $employee_id));
    }


    // Payroll
    public function EmployeeEarningByID($employee_id = '', $status = '')
    {
        if(empty($employee_id) && empty($status)){
            return self::$_query->query("SELECT * FROM earning WHERE Subscriber_ID = ? AND Employee_ID = ? AND Status = ?", array(self::$login_in_session, 'Locked'));
            
        } else {
            return self::$_query->query("SELECT * FROM earning WHERE Subscriber_ID = ? AND Employee_ID = ? AND Status = ?", array(self::$login_in_session, $employee_id, $status));
        }
    }

    public function EmployeesEarningData()
    {
        return self::$_query->query('SELECT DISTINCT Employee_ID FROM earning WHERE Subscriber_ID = ? AND Status = ?', array(self::$login_in_session, 'Active'));
    }

    public function EarningDateData($employee_id = '', $payment_date = '')
    {
        if(empty($employee_id) && empty($payment_date)){
            return self::$_query->query('SELECT DISTINCT DISTINCT Dates, End_Date FROM earning WHERE Subscriber_ID = ? AND Status = ? ORDER BY ID DESC', array(self::$login_in_session, 'Active'));
        } elseif (!empty($payment_date) && !empty($employee_id)) {
            return self::$_query->query('SELECT * FROM earning WHERE Subscriber_ID = ? AND Status = ? AND Employee_ID = ? AND Dates = ? ORDER BY ID DESC', array(self::$login_in_session, 'Active', $employee_id, $payment_date));
        } else {
            return self::$_query->query('SELECT DISTINCT DISTINCT Dates, End_Date FROM earning WHERE Subscriber_ID = ? AND Status = ? AND Employee_ID = ? ORDER BY ID DESC', array(self::$login_in_session, 'Active', $employee_id));
        }
        
    }

    public function EarningYearDate($employee_id = ''){
        if (!empty($employee_id)) {
            return self::$_query->query("SELECT DISTINCT year(Dates) AS Dates FROM earning WHERE Subscriber_ID = ? AND Status = ? AND Employee_ID = ? ORDER BY ID DESC", array(self::$login_in_session, 'Active', $employee_id));
        } else {
            return self::$_query->query("SELECT DISTINCT year(Dates) AS Dates FROM earning WHERE Subscriber_ID = ? AND Status = ? ORDER BY ID DESC", array(self::$login_in_session, 'Active'));
        }
        
    }

}

