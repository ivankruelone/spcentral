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
$pdf->SetMargins(7, 25, 6); 
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER); 
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER); 

//set auto page breaks 
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM); 

//set image scale factor 
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);  

$pdf->SetFont('helvetica', '', 6	);

$pdf->AddPage();

$totReq=0;
$totSur=0;



foreach($query->result() as $row)
{
    

$tabla = "<table cellpadding=\"1\">
    <tbody>
        <tr>
            <td style=\"width: 6%;\">".$row->fecha."</td>
            <td style=\"width: 9%;\">".$row->folioreceta."</td>
            <td style=\"width: 7%;\">".$row->cvepaciente."</td>
            <td style=\"width: 13%;\">". (trim($row->apaterno . ' ' . $row->amaterno. ' ' . $row->nombre)). "</td>
            <td style=\"width: 7%; text-align: left; \">".$row->cvemedico."</td>
            <td style=\"width: 15%;\">".($row->nombremedico)."</td>
            <td style=\"width: 7%; text-align: left; \">".$row->cvearticulo."</td>
            <td style=\"width: 19%;\">".$row->susa. ' '.$row->descripcion. ' ' . $row->pres."</td>
            <td style=\"width: 6%; text-align: right; \">0</td>
            <td style=\"width: 6%; text-align: right; \">".$row->canreq."</td>
            <td style=\"width: 6%; text-align: right; \">".$row->cansur."</td>
        </tr>
    </tbody>
    </table>";
    
    $totReq=$totReq+$row->canreq;
    $totSur=$totSur+$row->cansur;

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
            <td colspan=\"9\" style=\"text-align: right; width: 89%; \">TOTAL</td>
            <td style=\"text-align: right; width: 6%; \"><b>".number_format($totReq,0)."</b></td>
            <td style=\"text-align: right; width: 6%; \"><b>".number_format($totSur,0)."</b></td>
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
$pdf->Output('reporteRecetas.pdf', 'D');

//============================================================+
// END OF FILE                                                 
//============================================================+