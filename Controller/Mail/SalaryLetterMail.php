<?php
require '../../public/mailer/vendor/autoload.php';
require '../../public/dompdf/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use Dompdf\Dompdf;
use Dompdf\Options;



class Controller_Mail_SalaryLetterMail
{
    public function __construct()
    {
        $this->__mail = new PHPMailer(true);
        $this->__options = new Options();
        $this->__options->set('defaultFont', 'Courier');

        $this->__dompdf = new Dompdf($this->__options);

        $this->mail_file =  new Controller_Mail_MailFiles();

        $this->_query = Classes_Db::getInstance();
        $this->data_manager = new Controller_Company_Default_Datamanagement();
        $this->company_data =  $this->data_manager->CompanyDataByID()->first();
        $this->mail_config = $this->data_manager->CompanyEmailData()->first();

        $this->__css = Classes_Css::getCss();
    }



      public function SalaryLetterMail($earning_id){
        $employee_data_values = $this->data_manager->EmployeesDataByID($earning_id)->first();


        $employee_email = $employee_data_values['Email'];
        $first_name = $employee_data_values["First_Name"];
        $last_name = $employee_data_values["Last_Name"];
        $employee_id = $employee_data_values['Employee_ID'];
        $employee_input_id = $employee_data_values["Emp_ID"];


        // $this->__mail->SMTPDebug = 0;                                 // Enable verbose debug output
        // $this->__mail->isSMTP();                                      // Set mailer to use SMTP
        // $this->__mail->Host = $this->mail_config["Email_Host"];                           // Specify main and backup SMTP servers
        // $this->__mail->SMTPAuth = $this->mail_config["Domain"];                               // Enable SMTP authentication
        // $this->__mail->SMTPKeepAlive = true; // SMTP connection will not close after each email sent, reduces SMTP overhead

        // $this->__mail->Username = $this->mail_config["Email"];                 // SMTP username
        // $this->__mail->Password = $this->mail_config["Email_Password"];                           // SMTP password
        // $this->__mail->SMTPSecure = $this->mail_config["Security"];                            // Enable TLS encryption, `ssl` also accepted
        // $this->__mail->Port = $this->mail_config["Port"];                         // SMTP password
        // $this->__mail->WordWrap = 50;
        // $this->__mail->IsHTML(true);

        // $company_header = preg_replace("/[^A-Za-z0-9]/", "", $this->company_data["Company_Header"]);

        // $this->__mail->setFrom('noreply@' . strtolower($this->company_data["Company_Website"]) . '.com', $company_header);

        // $this->__mail->Subject = "Invoice for ". $this->project_data["Project_Name"]." ";
        // $this->__mail->addAddress($employee_email, $first_name.' '.$last_name);


        $payment_proof_html_file = $this->mail_file->SalaryLetterHTML($earning_id);

        $html_code = $this->__css;
        $html_code .= $payment_proof_html_file;
        $this->__dompdf->load_html($html_code);
        $this->__dompdf->setPaper('A4', 'portrait');
        $this->__dompdf->set_option('isHtml5ParserEnabled', true);
        $this->__dompdf->render();

        $url_path = Classes_Session::get("Loggedin_Session") . "/Salary_Letter/";

        if (Classes_Folder::create($url_path)) {
            $url_path = "../../Folders/Company_Folders/" . Classes_Session::get("Loggedin_Session") . "/Salary_Letter/" . $first_name . '_' . date("Y_m_d") . ".pdf";
        } else {
            $url_path = "../../Folders/Company_Folders/" . Classes_Session::get("Loggedin_Session") . "/Salary_Letter/" . $first_name . '_' . date("Y_m_d") . ".pdf";
        }




        $file = $this->__dompdf->output();
        file_put_contents($url_path, $file);
        echo json_encode("Email Successfully Sent");

            //$this->__mail->addAttachment($url_path);

            // $this->__mail->msgHTML("Hello Hi");

            // if ($this->__mail->send()) {
            //     $this->__mail->clearAddresses();
            //     $this->__mail->clearAttachments();
            //      echo json_encode("Sent");
            // }
            // else {
            //     echo json_encode($this->__mail->ErrorInfo);
            // }

    }


    public function SalaryLetterDownload($earning_id)
    {
 
        $employee_data_values = $this->data_manager->EmployeesDataByID($earning_id)->first();

        $first_name = $employee_data_values["First_Name"];

        $_html_file = $this->mail_file->SalaryLetterHTML($earning_id);
        $__html_code = $this->__css;
        $__html_code .= $_html_file;
        $this->__dompdf->load_html($__html_code);
        $this->__dompdf->setPaper('A4', 'portrait');
        $this->__dompdf->set_option('isHtml5ParserEnabled', true);
        $this->__dompdf->render();
        $url_path = "../../Folders/General/".$first_name.".pdf";
        ini_set('memory_limit', '128M');

        $__file = $this->__dompdf->output();
        if (file_put_contents($url_path, $__file) || !file_put_contents($url_path, $__file)) {
            echo json_encode("Successful");
            $this->__dompdf->stream($url_path);
            unlink($url_path);
        }
    }




}
