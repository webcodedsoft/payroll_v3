<?php
require '../../public/mailer/vendor/autoload.php';
require '../../public/dompdf/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use Dompdf\Dompdf;
use Dompdf\Options;


class Controller_Mail_JournalReportMail
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




    public function JournalReportDownload($journal_report_date)
    {

        $_html_file = $this->mail_file->JournalReportHTML($journal_report_date);
        $__html_code = $this->__css;
        $__html_code .= $_html_file;
        $this->__dompdf->load_html($__html_code);
        $this->__dompdf->setPaper('A4', 'portrait');
        $this->__dompdf->set_option('isHtml5ParserEnabled', true);
        $this->__dompdf->render();

        $url_path = Classes_Session::get("Loggedin_Session") . "/Journal_Report/";

        $journal_date = date("Y_F_d", strtotime($journal_report_date));
        $journal_name = $journal_date. "_Journal";

        if (Classes_Folder::create($url_path)) {
            $url_path = "../../Folders/Company_Folders/" . Classes_Session::get("Loggedin_Session") . "/Journal_Report/" . $journal_name. ".pdf";
        } else {
            $url_path = "../../Folders/Company_Folders/" . Classes_Session::get("Loggedin_Session") . "/Journal_Report/" . $journal_name.".pdf";
        }

        ini_set('memory_limit', '128M');

        $__file = $this->__dompdf->output();
        if (file_put_contents($url_path, $__file) || !file_put_contents($url_path, $__file)) {
            echo json_encode("Successful");
            $this->__dompdf->stream($url_path);
            //unlink($url_path);
        }
    }

}
