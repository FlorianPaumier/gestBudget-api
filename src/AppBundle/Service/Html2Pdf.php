<?php
/**
 * Created by PhpStorm.
 * User: florianpaumier
 * Date: 03/10/2018
 * Time: 13:54
 */

namespace AppBundle\Service;


use FontLib\Table\Type\name;
use Twig\Environment;

class Html2Pdf
{
    private $pdf;

    private $orientation = "P";

    private $format = "A4";

    private $lang = "fr";

    private $unit = "mm";

    private $unicode = true;

    private $margin = array(
        "top" => 10,
        "left" => 15,
        "bottom" => 10,
        "right" => 15);

    private $diskcache = false;

    private $encoding = "UTF-8";

    /**
     * @param null $orientation
     * @param null $format
     * @param null $lang
     * @param null $unicode
     * @param null $margin
     * @param null $encoding
     * Create a new instance of HTML2PDF
     */
    public function create($subject,$orientation = null, $format = null, $unit = null, $unicode = null, $diskcache = null, $encoding = null){
        $this->pdf =  new  \TCPDF(
            $orientation ? $orientation : $this->orientation,
            $unit ? $unit : $this->unit,
            $format ? $format : $this->format,
            $unicode ? $unicode : $this->unicode,
            $encoding ? $encoding : $this->encoding,
            $diskcache ? $diskcache : $this->diskcache
        );


        // set margins
        $this->pdf->SetMargins($this->margin["top"],$this->margin["left"],$this->margin["bottom"],$this->margin["right"]);
        $this->pdf->setFooterData(array(0,64,0), array(0,64,128));
        $this->pdf->SetSubject($subject);
        $this->pdf->SetTitle("DEVIS");
        $this->pdf->SetCreator('Bertrand Guislain');
        $this->pdf->setHeaderData("","","DEVIS",null);
        $this->pdf->setHeaderFont(PDF_FONT_NAME_MAIN);
        $this->pdf->setFooterFont(PDF_FONT_NAME_DATA);
        $this->pdf->setPrintFooter(false);
        $this->pdf->setPrintHeader(false);
    }


    public function generatePdf($data){
        // create new PDF document
        $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
        $pdf->SetCreator('Bertrand Guislain');
        $pdf->SetAuthor('Bertrand Guislain');
        $pdf->SetTitle('TCPDF Example 001');
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data

        $pdf->SetHeaderData(file_get_contents(dirname(__DIR__).'/Resources/public/img/logo_ocl_blue.png'), PDF_HEADER_LOGO_WIDTH, 'Facture 001', "", array(0,64,255), array(0,64,128));
        $pdf->setFooterData(array(0,64,0), array(0,64,128));
        $pdf->setPrintHeader(false);
// set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


// ---------------------------------------------------------

// set default font subsetting mode
        $pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
        $pdf->SetFont('dejavusans', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
        $pdf->AddPage();

        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetLineWidth(0.3);
// set text shadow effect
        $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
        $pdf->setHtmlLinksStyle();
// Set some content to print
        $html = $data;

// Print text using writeHTMLCell()
        $pdf->writeHTML($html, 0, 1, 0, true, true);

        //create file name
        $now = new \DateTime();
        $path = dirname(__DIR__, 3)."/web/uploads/paiement/facture/";
        $filePath = $path.'Facture-'.$now->format('d-m-Y').'.pdf';
// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
        $pdf->Output($filePath, 'F');

        return $filePath;
//============================================================+
// END OF FILE
//============================================================+
    }

    public function generateProfilePdf($data){
        // create new PDF document
        $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
        $pdf->SetCreator('Bertrand Guislain');
        $pdf->SetAuthor('Bertrand Guislain');
        $pdf->SetTitle('TCPDF Example 001');
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data

        $pdf->SetHeaderData(file_get_contents(dirname(__DIR__).'/Resources/public/img/logo_ocl_blue.png'), PDF_HEADER_LOGO_WIDTH, 'Facture 001', "", array(0,64,255), array(0,64,128));
        $pdf->setFooterData(array(0,64,0), array(0,64,128));
        $pdf->setPrintHeader(false);
// set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


// ---------------------------------------------------------

// set default font subsetting mode
        $pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
        $pdf->SetFont('dejavusans', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
        $pdf->AddPage();

        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetLineWidth(0.3);
// set text shadow effect
        $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
        $pdf->setHtmlLinksStyle();
// Set some content to print
        $html = $data;

// Print text using writeHTMLCell()
        $pdf->writeHTML($html, 0, 1, 0, true, true);

        //create file name
        $now = new \DateTime();
        $path = dirname(__DIR__, 3)."/web/uploads/profil_pdf/";
        $filePath = $path.'Profil-'.$now->format('d-m-Y').'.pdf';
// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
        $pdf->Output($filePath, 'F');

        return $filePath;
//============================================================+
// END OF FILE
//============================================================+
    }

    public function generateInvoiceMilesPdf($data){

        // create new PDF document
        $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
        $pdf->SetCreator('Bertrand Guislain');
        $pdf->SetAuthor('Bertrand Guislain');
        $pdf->SetTitle('Commande de miles');

// set default header data

        $pdf->SetHeaderData(file_get_contents(dirname(__DIR__).'/Resources/public/img/logo_ocl_blue.png'), PDF_HEADER_LOGO_WIDTH, 'Facture', "", array(0,64,255), array(0,64,128));
        $pdf->setFooterData(array(0,64,0), array(0,64,128));
        $pdf->setPrintHeader(false);
// set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


// ---------------------------------------------------------

// set default font subsetting mode
        $pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
        $pdf->SetFont('dejavusans', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
        $pdf->AddPage();

        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetLineWidth(0.3);
// set text shadow effect
        $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
        $pdf->setHtmlLinksStyle();
// Set some content to print
        $html = $data;

// Print text using writeHTMLCell()
        $pdf->writeHTML($html, 0, 1, 0, true, true);

        //create file name
        $now = new \DateTime();
        $path = dirname(__DIR__, 3)."/web/uploads/paiement/facture/";
        $filePath = $path.'Facture-'.$now->format('d-m-Y').'.pdf';
// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
        $pdf->Output($filePath, 'F');

        return $filePath;
//============================================================+
// END OF FILE
//============================================================+
    }

    public function generateInvoicePubPdf($data){

        // create new PDF document
        $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
        $pdf->SetCreator('Bertrand Guislain');
        $pdf->SetAuthor('Bertrand Guislain');
        $pdf->SetTitle('Commande de publicité');

// set default header data

        $pdf->SetHeaderData(file_get_contents(dirname(__DIR__).'/Resources/public/img/logo_ocl_blue.png'), PDF_HEADER_LOGO_WIDTH, 'Facture', "", array(0,64,255), array(0,64,128));
        $pdf->setFooterData(array(0,64,0), array(0,64,128));
        $pdf->setPrintHeader(false);
// set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


// ---------------------------------------------------------

// set default font subsetting mode
        $pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
        $pdf->SetFont('dejavusans', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
        $pdf->AddPage();

        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetLineWidth(0.3);
// set text shadow effect
        $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
        $pdf->setHtmlLinksStyle();
// Set some content to print
        $html = $data;

// Print text using writeHTMLCell()
        $pdf->writeHTML($html, 0, 1, 0, true, true);

        //create file name
        $now = new \DateTime();
        $path = dirname(__DIR__, 3)."/web/uploads/paiement/facture/";
        $filePath = $path.'Facture-'.$now->format('d-m-Y').'.pdf';
// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
        $pdf->Output($filePath, 'F');

        return $filePath;
//============================================================+
// END OF FILE
//============================================================+
    }
}