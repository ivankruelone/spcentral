<?php
global $cabezota;

$cabezota=$cabeza;

require_once('tcpdf/config/tcpdf_config.php');
require_once('tcpdf/tcpdf.php');

	if($query2->num_rows() > 0)
    {
        $row2 = $query2->row();
        
        $domicilio = $row2->domicilio;
    }else{
        $domicilio = null;
    }

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




foreach($query->result() as $row)
{
    
//entrada, salida, cvearticulo, susa, descripcion, pres, piezas, lote, nombremedico, cvemedico, folioreceta
$tabla = "<table cellpadding=\"1\">
    <tbody>
        <tr>
            <td style=\"width: 5%;\">".$row->entrada."</td>
            <td style=\"width: 5%;\">".$row->salida."</td>
            <td style=\"width: 15%;\">".$row->susa."</td>
            <td style=\"width: 19%;\">".$row->descripcion."</td>
            <td style=\"width: 15%;\">".$row->pres."</td>
            <td style=\"width: 5%; text-align: right\">".$row->piezas."</td>
            <td style=\"width: 10%;\">".$row->nombremedico."</td>
            <td style=\"width: 5%;\">".$row->cvemedico."</td>
            <td style=\"width: 18%;\">".$domicilio."</td>
            <td style=\"width: 5%;\">".$row->folioreceta."</td>
        </tr>
    </tbody>
    </table>";
    

//echo $tabla;

$tbl= <<<EOD
$tabla
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

}       





// -----------------------------------------------------------------------------

// -----------------------------------------------------------------------------
// -----------------------------------------------------------------------------



//Close and output PDF document
$pdf->Output('reporteAntibioticos_'.$lote.'_'.date('ymdHis').'.pdf', 'D');

//============================================================+
// END OF FILE                                                 
//============================================================+