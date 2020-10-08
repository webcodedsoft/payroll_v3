<?php
require '../../public/mailer/vendor/autoload.php';
require '../../public/dompdf/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use Dompdf\Dompdf;
use Dompdf\Options;

class Controller_Mail_AccountsMail
{
    public function __construct()
    {
        $this->__mail = new PHPMailer(true);
        $this->__options = new Options();
        $this->__options->set('defaultFont', 'Courier');
        
        $this->__dompdf = new Dompdf($this->__options);

        $this->invoice_file =  new Controller_Mail_MailFiles();

        $this->_query = Classes_Db::getInstance();
        $this->data = new Controller_Company_Default_Datamanagement();
        $this->company_data =  $this->data->CompanyDataByID()->first();
        $this->mail_config = $this->data->CompanyEmailData()->first();
        
        $this->__css = Classes_Css::getCss();
    }

    public function InvoiceMail($invoice_id){

        $this->invoice_data = $this->data->InvoiceData($invoice_id)->first();
        $this->client_data = $this->data->ClientDataByID($this->invoice_data["Client_ID"])->first();
        $this->project_data = $this->data->ProjectData($this->invoice_data["Project_ID"])->first();

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
        // $this->__mail->addAddress($this->invoice_data["Client_Email"], $this->client_data["Company_Name"]);
        



        $invoice_html_file = $this->invoice_file->InvoiceFile($invoice_id);

        $html_code = $this->__css;
        $html_code .= $invoice_html_file;
        $this->__dompdf->load_html($html_code);
        $this->__dompdf->setPaper('A4', 'portrait');
        $this->__dompdf->set_option('isHtml5ParserEnabled', true);
        $this->__dompdf->render();

        $url_path = Classes_Session::get("Loggedin_Session") . "/Projects/";

        if (Classes_Folder::create($url_path)) {
            $url_path = "../../Folders/Company_Folders/" . Classes_Session::get("Loggedin_Session") . "/Projects/" . $this->project_data["Project_Name"] . '_' . date("Y_m_d") . ".pdf";
        } else {
            $url_path = "../../Folders/Company_Folders/" . Classes_Session::get("Loggedin_Session") . "/Projects/" . $this->project_data["Project_Name"] . '_' . date("Y_m_d") . ".pdf";
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


    public function InvoiceDownload($invoice_id){

        $this->invoice_data = $this->data->InvoiceData($invoice_id)->first();
        $this->project_data = $this->data->ProjectData($this->invoice_data["Project_ID"])->first();

        $invoice_html_file = $this->invoice_file->InvoiceFile($invoice_id);
        $html_code = $this->__css;
        $html_code .= $invoice_html_file;
        $this->__dompdf->load_html($html_code);
        $this->__dompdf->setPaper('A4', 'portrait');
        $this->__dompdf->set_option('isHtml5ParserEnabled', true);
        $this->__dompdf->render();
        $url_path = "../../Folders/General/". $this->project_data["Project_Name"] . ".pdf";
        ini_set('memory_limit', '128M');
        

        $file = $this->__dompdf->output();
        if(file_put_contents($url_path, $file)){
            echo json_encode("Successful");
            $this->__dompdf->stream($url_path);
            unlink($url_path);
        }

        
    }
}
