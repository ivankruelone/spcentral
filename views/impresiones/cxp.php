<?php
require_once('tcpdf/config/lang/spa.php');
require_once('tcpdf/tcpdf.php');
global $header_alt;
$header_alt = $header;

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
    

	//Page header
	public function Header() {
	   
       global $header_alt;
        
        $this->SetFont('helvetica', 'B', 7);

$html = <<<EOF
$header_alt
EOF;

        // output the HTML content
        $this->writeHTML($html, true, false, true, false, '');
	}

	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-15);
		// Set font
		$this->SetFont('helvetica', 'I', 8);
		// Page number
		$this->Cell(0, 10, 'Pagina '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, "LETTER", true, 'UTF-8', false);

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(9, 25, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// ---------------------------------------------------------

// set font
$pdf->SetFont('times', '', 7);

$query = $this->reportes_model->getFacturas($fecha1, $fecha2, $orden);

$tabla = '
<style>
table {
  border-collapse: collapse;
  width: 100%;
}
th{
  border: 1px solid #ccc;
  font-weight: bolder;
}
td{
  border: 1px solid #ccc;
}


</style>
<h1 style="text-align: center; ">CONCENTRADO DE FACTURAS</h1>
<table>
            <thead>
                <tr>
                    <th style="width: 15%; ">FACTURA</th>
                    <th style="width: 31%; ">MAYORISTA O PROVEEDOR</th>
                    <th style="width: 8%; ">FECHA</th>
                    <th style="width: 6%; ">ORDEN</th>
                    <th style="width: 6%; ">CXP</th>
                    <th style="width: 20%; ">OBSERVACION</th>
                    <th style="width: 20%; ">USUARIO</th>
                </tr>
            </thead>
            <tbody>';

foreach($query->result() as $row)
{
    $tabla .= '
                <tr>
                    <td style="width: 15%; ">'.$row->referencia.'</td>
                    <td style="width: 31%; ">'.$row->razon.'</td>
                    <td style="width: 8%; ">'.$row->fecha.'</td>
                    <td style="width: 6%; ">'.$row->orden.'</td>
                    <td style="width: 6%; ">'.$row->nuevo_folio.'</td>
                    <td style="width: 20%; ">'.$row->observaciones.'</td>
                    <td style="width: 20%; ">'.$row->nombreusuario.'</td>
                </tr>';
    
}

$tabla .= '
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" style="text-align: right; ">Total de documentos</td>
                    <td style="text-align: center; ">'.$query->num_rows().'</td>
                </tr>
            </tfoot>
</table>
<p></p>
<p></p>
<p></p>
<p style="text-align: center">_______________________________________________________</p>
<p style="text-align: center">PERSONA QUE RECIBE EN CUENTAS POR PAGAR</p>
';
 

// add a page
$pdf->AddPage();

$html = <<<EOF
$tabla
EOF;

        // output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');



$query2 = $this->reportes_model->getFacturas($fecha1, $fecha2, $orden);

foreach($query2->result() as $row2)
{
    $pdf->AddPage();
    
    $tabla2 = '<h1>Factura: '.$row2->referencia.' - Razon Social: '.$row2->razon.'</h1>'
    .'<h2>Orden de compra: '.$row2->orden.' - Cuenta por Pagar: '.$row2->nuevo_folio.'</h2>'
    .'<h3>Usuario: '.$row2->nombreusuario.'</h3>';
    
    $query3 = $this->reportes_model->getFacturaDetalle($row2->movimientoID);

$tabla3 = '
<style>
table {
  border-collapse: collapse;
  width: 100%;
}
th{
  border: 1px solid #ccc;
  font-weight: bolder;
}
td{
  border: 1px solid #ccc;
}


</style>
<table>
            <thead>
                <tr>
                    <th style="width: 15%; ">CLAVE</th>
                    <th style="width: 58%; ">DESCRIPCION</th>
                    <th style="width: 8%; text-align: right;">CANTIDAD</th>
                    <th style="width: 10%; ">LOTE</th>
                    <th style="width: 9%; ">CADUCIDAD</th>
                </tr>
            </thead>
            <tbody>';

foreach($query3->result() as $row3)
{
    $tabla3 .= '
                <tr>
                    <td style="width: 15%; ">'.$row3->cvearticulo.'</td>
                    <td style="width: 58%; ">'.trim($row3->susa . ' ' .$row3->descripcion . ' ' . $row3->pres).'</td>
                    <td style="width: 8%; text-align: right;">'.$row3->piezas.'</td>
                    <td style="width: 10%; ">'.$row3->lote.'</td>
                    <td style="width: 9%; ">'.$row3->caducidad.'</td>
                </tr>';
    
}

$tabla3 .= '
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align: right; ">Total de renglones</td>
                    <td style="text-align: center; ">'.$query3->num_rows().'</td>
                </tr>
            </tfoot>
</table>
';

    
$html = <<<EOF
$tabla2$tabla3
EOF;

        // output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');
}

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('cxp_'.$fecha1.'_'.$fecha2.'.pdf', 'D');

//============================================================+
// END OF FILE                                                
//============================================================+
