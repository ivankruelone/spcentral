<?php
global $cabezota;

$cabezota=$cabeza;

require_once('tcpdf/config/tcpdf_config.php');
require_once('tcpdf/tcpdf.php');



// Extend the TCPDF class to create custom Header and Footer 
class MYPDF extends TCPDF { 
   	
    
    public function Header() { 

/////////////////////////////////////////////////////////////////
global $cabezota;

$this->SetFont('helvetica', '', 8	);
$tbl = <<<EOD
$cabezota
EOD;
$this->writeHTML($tbl, true, false, false, false, '');
    } 
     
    // Page footer 
    public function Footer() { 
        // Position at 1.5 cm from bottom 
        $this->SetY(-15); 
        // Set font 
        $this->SetFont('helvetica', 'I', 9); 
        // Page number 
        $this->Cell(0, 10, 'Pagina '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, 0, 'C'); 
    } 
} 

// create new PDF document 
$pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false); 

// set document information 
$pdf->SetCreator(PDF_CREATOR); 
$pdf->SetAuthor('Lidia Velazquez'); 
$pdf->SetTitle(''); 
$pdf->SetSubject('TCPDF Tutorial'); 
$pdf->SetKeywords('TCPDF, PDF, example, test, guide'); 

// set default header data 
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING); 

// set header and footer fonts 
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN)); 
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA)); 

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins 
$pdf->SetMargins(7, 20, 6); 
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER); 
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER); 

//set auto page breaks 
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM); 

//set image scale factor 
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);  

$pdf->SetFont('helvetica', '', 6	);

$pdf->AddPage();

$req = 0;
$sur = 0;


foreach($query->result() as $row)
{
    

$tabla = "<table cellpadding=\"1\">
    <tbody>
        <tr>
            <td style=\"width: 10%;\">".$row->cvearticulo."</td>
            <td style=\"width: 20%;\">".$row->susa."</td>
            <td style=\"width: 30%;\">".$row->descripcion."</td>
            <td style=\"width: 20%;\">".$row->pres."</td>
            <td style=\"width: 10%; text-align: right; \">".number_format($row->canreq, 0)."</td>
            <td style=\"width: 10%; text-align: right; \">".number_format($row->cansur, 0)."</td>
        </tr>
    </tbody>
    </table>";
    
    $req = $req + $row->canreq;
    $sur = $sur + $row->cansur;

//echo $tabla;

$tbl= <<<EOD
$tabla
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

}       

$tabla ="
<table>
</tfoot>
        <tr>
            <td colspan=\"4\" style=\"text-align: right; width: 80%; \">TOTAL</td>
            <td style=\"text-align: right; width: 10%; \"><b>".number_format($req,0)."</b></td>
            <td style=\"text-align: right; width: 10%; \"><b>".number_format($sur,0)."</b></td>
        </tr>
        </tfoot>
        </table>";

// set font

//echo $tabla;        
$tbl= <<<EOD
$tabla
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');




// -----------------------------------------------------------------------------

// -----------------------------------------------------------------------------
// -----------------------------------------------------------------------------



//Close and output PDF document
$pdf->Output('reporteConsumo_'.$fecha1.'_'.$fecha2.'_'.date('ymdHis').'.pdf', 'D');

//============================================================+
// END OF FILE                                                 
//============================================================+