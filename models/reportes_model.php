<?php
class Reportes_model extends CI_Model {

    /**
     * Catalogos_model::__construct()
     * 
     * @return
     */
    function __construct()
    {
        parent::__construct();
    }
    
    function recetas_periodo_detalle($fecha1, $fecha2, $idprograma, $tiporequerimiento)
    {
        
        $this->db->select("descsucursal, programa, requerimiento, folioreceta, apaterno, amaterno, nombre, canreq, cvepaciente, cveservicio, cvearticulo, susa, descripcion, pres, cansur, nombremedico, cvemedico, fecha, fechaexp", false);
        $this->db->from('receta r');
        $this->db->join('receta_detalle d', 'r.consecutivo = d.consecutivo');
        $this->db->join('sucursales s', 'r.clvsucursal=s.clvsucursal');
        $this->db->join('articulos a', 'a.id = d.id');
        $this->db->join('programa p', 'r.idprograma = p.idprograma');
        $this->db->join('temporal_requerimiento q', 'r.tiporequerimiento = q.tiporequerimiento');
        $this->db->where('fecha >=', $fecha1);
        $this->db->where('fecha <=', $fecha2);
        $this->db->where('r.clvsucursal', $this->session->userdata('clvsucursal'));
        
        if($idprograma == 1000)
        {
        
            
        }else{
            $this->db->where('r.idprograma', $idprograma);            
        }
        
        if($tiporequerimiento == 1000)
        {
            
        }else{
            $this->db->where('r.tiporequerimiento', $tiporequerimiento);
        }
        
        $this->db->order_by('r.fecha, r.folioreceta * 1');
        
        $query = $this->db->get();
        
        return $query;
        
    }
    
    function recetas_periodo_detalle_anterior($fecha1, $fecha2, $clvsucursal)
    {
        
        $this->db->select("descsucursal, folioreceta, apaterno, amaterno, nombre, cvepaciente, cveservicio, r.cvearticulo, r.descripcion, costounitario, a.iva, presentacion, cantidadsurtida, nombremedico, cvemedico, fecha, fechaexp", false);
        $this->db->from('receta r');
        $this->db->join('sucursales s', 'r.cvecentrosalud=s.clvsucursal', 'LEFT');
        $this->db->join('articulos a', 'a.cvearticulo=r.cvearticulo', 'LEFT');
        $this->db->where('fecha >=', $fecha1);
        $this->db->where('fecha <=', $fecha2);
        $this->db->where('cvecentrosalud', $clvsucursal);
        $this->db->where('r.status', 't');
        $query = $this->db->get();
        
        return $query;
        
    }

    function getSucursalesCombo()
    {
        $query = $this->db->get('sucursales');
        
        $a = array();
        
        foreach($query->result() as $row)
        {
            $a[$row->clvsucursal] = $row->descsucursal;
        }
        
        return $a;
    }

    function getProgramasCombo()
    {
        $query = $this->db->get('programa');
        
        $a = array('1000' => 'TODOS');
        
        foreach($query->result() as $row)
        {
            $a[$row->idprograma] = $row->programa;
        }
        
        return $a;
    }

    function getRequerimientoCombo()
    {
        $query = $this->db->get('temporal_requerimiento');
        
        $a = array('1000' => 'TODOS');
        
        foreach($query->result() as $row)
        {
            $a[$row->tiporequerimiento] = $row->requerimiento;
        }
        
        return $a;
    }

    function  getReporteRecetasCabeza($fecha1, $fecha2, $idprograma, $tiporequerimiento, $programas, $requerimientos)
    {
        
        $tabla = '<table>
            <tr>
                <td style="text-align: center; " colspan="9" ><b>'.COMPANIA.'</b></td>
            </tr>
            <tr>
                <td style="width: 7%;">UNIDAD: </td>
                <td style="width: 7%;"><b>'.$this->session->userdata('clvsucursal').'</b></td>
                <td style="width: 7%;">SUCURSAL: </td>
                <td style="width: 50%;"><b>'.$this->session->userdata('sucursal').'</b></td>
                <td style="width: 8%;">GENERADO: </td>
                <td style="width: 21%;"><b>'.date('d/m/Y H:i:s').'</b></td>
            </tr>
            <tr>
                <td style="width: 12%;">REQUERIMIENTO: </td>
                <td style="width: 10%;"><b>'.$requerimientos[$tiporequerimiento].'</b></td>
                <td style="width: 10%;">PROGRAMA: </td>
                <td style="width: 39%;"><b>'.$programas[$idprograma].'</b></td>
                <td style="width: 8%;">PERIODO: </td>
                <td style="width: 21%;"><b>DEL '.$fecha1.' AL '.$fecha2.'</b></td>
            </tr>
        </table>
        ';
        
        $tabla .= "
        <br />";
        
        $tabla .= "
        <table>
            <thead>
                <tr>
                    <th style=\"width: 6%;\"><b>Fecha</b></th>
                    <th style=\"width: 9%;\"><b>Folio</b></th>
                    <th style=\"width: 7%;\"><b>Cve. Pac.</b></th>
                    <th style=\"width: 13%;\"><b>Paciente</b></th>
                    <th style=\"width: 7%;\"><b>Cve. Medico</b></th>
                    <th style=\"width: 15%; text-align: left; \"><b>Medico</b></th>
                    <th style=\"width: 7%; text-align: left; \"><b>Cve. Art.</b></th>
                    <th style=\"width: 19%; text-align: left; \"><b>Descripcion</b></th>
                    <th style=\"width: 6%; text-align: right; \"><b>P. unitario</b></th>
                    <th style=\"width: 6%; text-align: right; \"><b>Cant. sol.</b></th>
                    <th style=\"width: 6%; text-align: right; \"><b>Cant. sur.</b></th>
                </tr>
            </thead>
            </table>";
        return $tabla;
    }
    
    function getReporteConsumoCabeza($fecha1, $fecha2)
    {
        $tabla = '<table>
            <tr>
                <td style="text-align: center; "><b>'.COMPANIA.'</b></td>
                <td style="text-align: center; "><b>'.$this->session->userdata('clvsucursal').' - '.$this->session->userdata('sucursal').'</b></td>
            </tr>
            <tr>
                <td style="text-align: center; "><b>REPORTE DE CONSUMO, PERIODO: '.$fecha1.' AL '.$fecha2.'</b></td>
                <td style="text-align: center; ">FECHA DE GENERACION: <b>'.date('d/m/Y H:i:s').'</b></td>
            </tr>
        </table>
        ';
        
        $tabla .= "
        <br />";
        
        $tabla .= "
        <table>
            <thead>
                <tr>
                    <th style=\"width: 10%;\"><b>Clave</b></th>
                    <th style=\"width: 20%;\"><b>Sustancia Activa</b></th>
                    <th style=\"width: 30%;\"><b>Descripcion</b></th>
                    <th style=\"width: 20%;\"><b>Presentacion</b></th>
                    <th style=\"width: 10%; text-align: right; \"><b>Requeridas</b></th>
                    <th style=\"width: 10%; text-align: right; \"><b>Surtidas</b></th>
                </tr>
            </thead>
            </table>";
        return $tabla;
    }
    
    function getReporteNegadoCabeza($fecha1, $fecha2)
    {
        $tabla = '<table>
            <tr>
                <td style="text-align: center; "><b>'.COMPANIA.'</b></td>
                <td style="text-align: center; "><b>'.$this->session->userdata('clvsucursal').' - '.$this->session->userdata('sucursal').'</b></td>
            </tr>
            <tr>
                <td style="text-align: center; "><b>REPORTE DE NEGADOS, PERIODO: '.$fecha1.' AL '.$fecha2.'</b></td>
                <td style="text-align: center; ">FECHA DE GENERACION: <b>'.date('d/m/Y H:i:s').'</b></td>
            </tr>
        </table>
        ';
        
        $tabla .= "
        <br />";
        
        $tabla .= "
        <table>
            <thead>
                <tr>
                    <th style=\"width: 10%;\"><b>Clave</b></th>
                    <th style=\"width: 20%;\"><b>Sustancia Activa</b></th>
                    <th style=\"width: 40%;\"><b>Descripcion</b></th>
                    <th style=\"width: 20%;\"><b>Presentacion</b></th>
                    <th style=\"width: 10%; text-align: right; \"><b>Negados</b></th>
                </tr>
            </thead>
            </table>";
        return $tabla;
    }

    function getConsumo($fecha1, $fecha2)
    {
        $sql = "SELECT cvearticulo, susa, descripcion, pres, sum(canreq) as canreq, sum(cansur) as cansur
FROM receta_detalle d
join receta r using(consecutivo)
join articulos a using(id)
where fecha between ? and ?
group by id
order by tipoprod asc, cvearticulo * 1 asc;";

        $query = $this->db->query($sql, array($fecha1, $fecha2));
        
        return $query;
    }

    function getNegado($fecha1, $fecha2)
    {
        $sql = "SELECT cvearticulo, susa, descripcion, pres, sum(canreq - cansur) as negado
FROM receta_detalle d
join receta r using(consecutivo)
join articulos a using(id)
where fecha between ? and ?
group by id
having negado > 0
order by tipoprod asc, cvearticulo * 1 asc
;";

        $query = $this->db->query($sql, array($fecha1, $fecha2));
        
        return $query;
    }
    
    function getFechaDiaAnterior()
    {
        $sql = "select date(now() - interval 1 day) as dia;";
        $query = $this->db->query($sql);
        $row = $query->row();
        
        return $row->dia;
    }
    
    function inventarioMensual()
    {
        $sql = "insert into inventario_historico (SELECT *, extract(year from now()) as anio, extract(month from now()) as mes FROM inventario i where cantidad <> 0);";
        $this->db->query($sql);
    }
    
    function getFechaMesAnterior()
    {
        $sql = "select date(now() - interval 1 day) as dia;";
        $query = $this->db->query($sql);
        $row = $query->row();
        
        $ultimo_dia = $row->dia;
        
        $primer_dia = substr($ultimo_dia, 0, 8) . '01';
        
        $data = new stdClass();
        $data->primer_dia = $primer_dia;
        $data->ultimo_dia = $ultimo_dia;
        
        return $data;
    }

    function getCorreos($segment)
    {
        $this->db->where('segment', $segment);
        $query = $this->db->get('correo');
        
        $row = $query->row();
        
        return $row->correo;
    }
    
    function getExcel($es = 0, $fecha1, $fecha2, $cvearticulo = null)
    {
        set_time_limit(0);
        ini_set("memory_limit","-1");
        $this->load->library('excel');
        $cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_gzip;
        if (!PHPExcel_Settings::setCacheStorageMethod($cacheMethod)) {
        	die($cacheMethod . " caching method is not available" . EOL);
        }


        $sql = "SELECT areaID, area FROM inventario i
left join articulos a using(id)
left join ubicacion u using(ubicacion)
where cantidad <> 0
group by areaID;";
            
        $query = $this->db->query($sql);
        
        $hoja = 0;
        
        foreach($query->result() as $row)
        {
            $this->excel->createSheet($hoja);
            $this->excel->setActiveSheetIndex($hoja);
            $this->excel->getActiveSheet()->getTabColor()->setRGB('FFFF00');
            
            $this->excel->getActiveSheet()->setTitle($row->area);
            
            $this->excel->getActiveSheet()->mergeCells('A1:N1');
            $this->excel->getActiveSheet()->mergeCells('A2:K2');
            
            $this->excel->getActiveSheet()->mergeCells('L2:N2');

            $this->excel->getActiveSheet()->setCellValue('A1', COMPANIA);
            $this->excel->getActiveSheet()->setCellValue('A2', APLICACION);
            $this->excel->getActiveSheet()->setCellValue('L2', date('d/M/Y H:i:s'));
            
            if($cvearticulo == null)
            {
                $sql2 = "SELECT *, DATEDIFF(caducidad, now()) as dias FROM inventario i
    left join articulos a using(id)
    left join ubicacion u using(ubicacion)
    where cantidad <> 0 and areaID = ?
    order by cvearticulo * 1;";
    
                $query2 = $this->db->query($sql2, $row->areaID);
            }else{
                $sql2 = "SELECT *, DATEDIFF(caducidad, now()) as dias FROM inventario i
    left join articulos a using(id)
    left join ubicacion u using(ubicacion)
    where cantidad <> 0 and areaID = ? and cvearticulo = ?
    order by cvearticulo * 1;";
    
    
                $query2 = $this->db->query($sql2, array($row->areaID, (string)$cvearticulo));
            }

            $num = 3;
            
            $data_empieza = $num + 1;
            
            $this->excel->getActiveSheet()->setCellValue('A'.$num, '#');
            $this->excel->getActiveSheet()->setCellValue('B'.$num, 'CLAVE');
            $this->excel->getActiveSheet()->setCellValue('C'.$num, 'EAN');
            $this->excel->getActiveSheet()->setCellValue('D'.$num, 'NOMBRE COMERCIAL');
            $this->excel->getActiveSheet()->setCellValue('E'.$num, 'SUSTANCIA ACTIVA');
            $this->excel->getActiveSheet()->setCellValue('F'.$num, 'DESCRIPCION');
            $this->excel->getActiveSheet()->setCellValue('G'.$num, 'PRESENTACION');
            $this->excel->getActiveSheet()->setCellValue('H'.$num, 'CANTIDAD');
            $this->excel->getActiveSheet()->setCellValue('I'.$num, 'LOTE');
            $this->excel->getActiveSheet()->setCellValue('J'.$num, 'CADUCIDAD');
            $this->excel->getActiveSheet()->setCellValue('K'.$num, 'LABORATORIO / FABRICANTE');
            $this->excel->getActiveSheet()->setCellValue('L'.$num, 'COSTO');
            $this->excel->getActiveSheet()->setCellValue('M'.$num, 'AREA');
            $this->excel->getActiveSheet()->setCellValue('N'.$num, 'PASILLO');
            $this->excel->getActiveSheet()->setCellValue('O'.$num, 'IMPORTE');
            
            $i = 1;
            
            if($query2->num_rows() > 0)
            {
                
            foreach($query2->result()  as $row2)
            {
                $num++;
                
                $this->excel->getActiveSheet()->setCellValue('A'.$num, $i);
                $this->excel->getActiveSheet()->setCellValue('B'.$num, $row2->cvearticulo);
                $this->excel->getActiveSheet()->setCellValue('C'.$num, $row2->ean);
                $this->excel->getActiveSheet()->setCellValue('D'.$num, $row2->comercial);
                $this->excel->getActiveSheet()->setCellValue('E'.$num, $row2->susa);
                $this->excel->getActiveSheet()->setCellValue('F'.$num, $row2->descripcion);
                $this->excel->getActiveSheet()->setCellValue('G'.$num, $row2->pres);
                $this->excel->getActiveSheet()->setCellValue('H'.$num, $row2->cantidad);
                $this->excel->getActiveSheet()->setCellValue('I'.$num, $row2->lote);
                $this->excel->getActiveSheet()->setCellValue('J'.$num, $row2->caducidad);
                $this->excel->getActiveSheet()->setCellValue('K'.$num, $row2->marca);
                $this->excel->getActiveSheet()->setCellValue('L'.$num, $row2->costo);
                $this->excel->getActiveSheet()->setCellValue('M'.$num, $row2->area);
                $this->excel->getActiveSheet()->setCellValue('N'.$num, $row2->pasillo);
                $this->excel->getActiveSheet()->setCellValue('O'.$num, '=H'.$num.'*L'.$num);
                
                if($row2->dias <= 0)
                {
                    $this->excel->getActiveSheet()->getStyle('A' . $num . ':N' . $num)->getFill()->applyFromArray(array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array(
                             'rgb' => 'FFA07A'
                        )
                    ));
                }elseif($row2->dias > 0 && $row2->dias <= 90){
                    $this->excel->getActiveSheet()->getStyle('A' . $num . ':N' . $num)->getFill()->applyFromArray(array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array(
                             'rgb' => 'B0E0E6'
                        )
                    ));
                }
                
                $i++;
                
            }
            
            $data_termina = $num;
            
            $this->excel->getActiveSheet()->setCellValue('H'.($data_termina + 1), '=sum(H'.$data_empieza.':H'.$data_termina.')');
            $this->excel->getActiveSheet()->setCellValue('O'.($data_termina + 1), '=sum(O'.$data_empieza.':O'.$data_termina.')');
            
            
            $this->excel->getActiveSheet()->getStyle('H'.$data_empieza.':H'.($data_termina + 1))->getNumberFormat()->setFormatCode('#,##0');
            $this->excel->getActiveSheet()->getStyle('L'.$data_empieza.':L'.$data_termina)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            $this->excel->getActiveSheet()->getStyle('O'.$data_empieza.':O'.($data_termina + 1))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            $this->excel->getActiveSheet()->getStyle('C'.$data_empieza.':C'.$data_termina)->getNumberFormat()->setFormatCode('0');
            $this->excel->getActiveSheet()->getStyle('B'.$data_empieza.':B'.$data_termina)->getNumberFormat()->setFormatCode('0');
            
            $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
            $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
            $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
            $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
            $this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
            $this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
            $this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
            $this->excel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
            $this->excel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
            
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
            
            $this->excel->getActiveSheet()->getStyle('E'.$data_empieza.':G'.$data_termina)->getAlignment()->setWrapText(true);
            
            $styleArray = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('argb' => 'FFFF0000'),
                    ),
                ),
            );
            
            $this->excel->getActiveSheet()->getStyle('A'.($data_empieza - 1).':O'.($data_termina + 1))->applyFromArray($styleArray);
            
            $this->excel->getActiveSheet()->freezePaneByColumnAndRow(0, $data_empieza);
            $this->excel->getActiveSheet()->setAutoFilter('A'.($data_empieza - 1).':O'.($data_termina + 1));
            
            
            }
            $hoja++;
        }
        
//INVENTARIO TOTAL        
            $this->excel->createSheet($hoja);
            $this->excel->setActiveSheetIndex($hoja);
            $this->excel->getActiveSheet()->getTabColor()->setRGB('FFFF00');
            
            $this->excel->getActiveSheet()->setTitle('INVENTARIO TOTAL');
            
            $this->excel->getActiveSheet()->mergeCells('A1:N1');
            $this->excel->getActiveSheet()->mergeCells('A2:K2');
            
            $this->excel->getActiveSheet()->mergeCells('L2:N2');

            $this->excel->getActiveSheet()->setCellValue('A1', COMPANIA);
            $this->excel->getActiveSheet()->setCellValue('A2', APLICACION);
            $this->excel->getActiveSheet()->setCellValue('L2', date('d/M/Y H:i:s'));
            
            if($cvearticulo == null)
            {
                $sql2 = "SELECT *, DATEDIFF(caducidad, now()) as dias FROM inventario i
    left join articulos a using(id)
    left join ubicacion u using(ubicacion)
    where cantidad <> 0
    order by cvearticulo * 1;";
    
                $query2 = $this->db->query($sql2);
            }else{
                $sql2 = "SELECT *, DATEDIFF(caducidad, now()) as dias FROM inventario i
    left join articulos a using(id)
    left join ubicacion u using(ubicacion)
    where cantidad <> 0 and cvearticulo = ?
    order by cvearticulo * 1;";
    
                $query2 = $this->db->query($sql2, (string)$cvearticulo);
            }
            
            
            $num = 3;
            
            $data_empieza = $num + 1;
            
            $this->excel->getActiveSheet()->setCellValue('A'.$num, '#');
            $this->excel->getActiveSheet()->setCellValue('B'.$num, 'CLAVE');
            $this->excel->getActiveSheet()->setCellValue('C'.$num, 'EAN');
            $this->excel->getActiveSheet()->setCellValue('D'.$num, 'NOMBRE COMERCIAL');
            $this->excel->getActiveSheet()->setCellValue('E'.$num, 'SUSTANCIA ACTIVA');
            $this->excel->getActiveSheet()->setCellValue('F'.$num, 'DESCRIPCION');
            $this->excel->getActiveSheet()->setCellValue('G'.$num, 'PRESENTACION');
            $this->excel->getActiveSheet()->setCellValue('H'.$num, 'CANTIDAD');
            $this->excel->getActiveSheet()->setCellValue('I'.$num, 'LOTE');
            $this->excel->getActiveSheet()->setCellValue('J'.$num, 'CADUCIDAD');
            $this->excel->getActiveSheet()->setCellValue('K'.$num, 'LABORATORIO / FABRICANTE');
            $this->excel->getActiveSheet()->setCellValue('L'.$num, 'COSTO');
            $this->excel->getActiveSheet()->setCellValue('M'.$num, 'AREA');
            $this->excel->getActiveSheet()->setCellValue('N'.$num, 'PASILLO');
            $this->excel->getActiveSheet()->setCellValue('O'.$num, 'IMPORTE');
            
            $i = 1;
            
            if($query2->num_rows() > 0)
            {
                
            foreach($query2->result()  as $row2)
            {
                $num++;
                
                $this->excel->getActiveSheet()->setCellValue('A'.$num, $i);
                $this->excel->getActiveSheet()->setCellValue('B'.$num, $row2->cvearticulo);
                $this->excel->getActiveSheet()->setCellValue('C'.$num, $row2->ean);
                $this->excel->getActiveSheet()->setCellValue('D'.$num, $row2->comercial);
                $this->excel->getActiveSheet()->setCellValue('E'.$num, $row2->susa);
                $this->excel->getActiveSheet()->setCellValue('F'.$num, $row2->descripcion);
                $this->excel->getActiveSheet()->setCellValue('G'.$num, $row2->pres);
                $this->excel->getActiveSheet()->setCellValue('H'.$num, $row2->cantidad);
                $this->excel->getActiveSheet()->setCellValue('I'.$num, $row2->lote);
                $this->excel->getActiveSheet()->setCellValue('J'.$num, $row2->caducidad);
                $this->excel->getActiveSheet()->setCellValue('K'.$num, $row2->marca);
                $this->excel->getActiveSheet()->setCellValue('L'.$num, $row2->costo);
                $this->excel->getActiveSheet()->setCellValue('M'.$num, $row2->area);
                $this->excel->getActiveSheet()->setCellValue('N'.$num, $row2->pasillo);
                $this->excel->getActiveSheet()->setCellValue('O'.$num, '=H'.$num.'*L'.$num);
                

                if($row2->dias <= 0)
                {
                    $this->excel->getActiveSheet()->getStyle('A' . $num . ':N' . $num)->getFill()->applyFromArray(array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array(
                             'rgb' => 'FFA07A'
                        )
                    ));
                }elseif($row2->dias > 0 && $row2->dias <= 90){
                    $this->excel->getActiveSheet()->getStyle('A' . $num . ':N' . $num)->getFill()->applyFromArray(array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array(
                             'rgb' => 'B0E0E6'
                        )
                    ));
                }

                $i++;
                
            }
            
            $data_termina = $num;
            
            $this->excel->getActiveSheet()->setCellValue('H'.($data_termina + 1), '=sum(H'.$data_empieza.':H'.$data_termina.')');
            $this->excel->getActiveSheet()->setCellValue('O'.($data_termina + 1), '=sum(O'.$data_empieza.':O'.$data_termina.')');
            
            
            $this->excel->getActiveSheet()->getStyle('H'.$data_empieza.':H'.($data_termina + 1))->getNumberFormat()->setFormatCode('#,##0');
            $this->excel->getActiveSheet()->getStyle('L'.$data_empieza.':L'.$data_termina)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            $this->excel->getActiveSheet()->getStyle('O'.$data_empieza.':O'.($data_termina + 1))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            $this->excel->getActiveSheet()->getStyle('C'.$data_empieza.':C'.$data_termina)->getNumberFormat()->setFormatCode('0');
            $this->excel->getActiveSheet()->getStyle('B'.$data_empieza.':B'.$data_termina)->getNumberFormat()->setFormatCode('0');
            
            $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
            $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
            $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
            $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
            $this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
            $this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
            $this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
            $this->excel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
            $this->excel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
            
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
            
            $this->excel->getActiveSheet()->getStyle('E'.$data_empieza.':G'.$data_termina)->getAlignment()->setWrapText(true);
            
            $styleArray = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('argb' => 'FFFF0000'),
                    ),
                ),
            );
            
            $this->excel->getActiveSheet()->getStyle('A'.($data_empieza - 1).':O'.($data_termina + 1))->applyFromArray($styleArray);
            
            $this->excel->getActiveSheet()->freezePaneByColumnAndRow(0, $data_empieza);
            $this->excel->getActiveSheet()->setAutoFilter('A'.($data_empieza - 1).':O'.($data_termina + 1));
            
            }
            
            $hoja++;

//FIN INVENTARIO TOTAL
        if($es == 1)
        {
            $fecha1 = $fecha1 . ' 00:00:00';
            $fecha2 = $fecha2 . ' 23:59:59';
            
            if($cvearticulo == null)
            {
                $sql3 = "SELECT tipoMovimiento, tipoMovimientoDescripcion FROM movimiento m
    join movimiento_detalle d using(movimientoID)
    join articulos a using(id)
    join tipo_movimiento t using(tipoMovimiento)
    join subtipo_movimiento s using(tipoMovimiento, subtipoMovimiento)
    where statusMovimiento = 1
    and fechaCierre between ? and ?
    group by tipoMovimiento;";
                
                $query3 = $this->db->query($sql3, array($fecha1, $fecha2));
            }else{
                $sql3 = "SELECT tipoMovimiento, tipoMovimientoDescripcion FROM movimiento m
    join movimiento_detalle d using(movimientoID)
    join articulos a using(id)
    join tipo_movimiento t using(tipoMovimiento)
    join subtipo_movimiento s using(tipoMovimiento, subtipoMovimiento)
    where statusMovimiento = 1
    and fechaCierre between ? and ? and cvearticulo = ?
    group by tipoMovimiento;";
                
                $query3 = $this->db->query($sql3, array($fecha1, $fecha2, $cvearticulo));
            }
            
            
            
            foreach($query3->result() as $row3)
            {
                $this->excel->createSheet($hoja);
                $this->excel->setActiveSheetIndex($hoja);
                
                if($row3->tipoMovimiento == 1)
                {
                    $this->excel->getActiveSheet()->getTabColor()->setRGB('32CD32');
                }else{
                    $this->excel->getActiveSheet()->getTabColor()->setRGB('FF0000');
                }
                
                
                
                $this->excel->getActiveSheet()->setTitle($row3->tipoMovimientoDescripcion);
                
                if($cvearticulo == null)
                {
                    $sql4 = "SELECT movimientoID, orden, referencia, fecha, fechaCierre, clvsucursalReferencia, observaciones, nuevo_folio, piezas, costo, lote, caducidad, ean, marca, comercial, cvearticulo, susa, descripcion, pres, subtipoMovimientoDescripcion, rfc, razon, descsucursal, nombreusuario FROM movimiento m
    join movimiento_detalle d using(movimientoID)
    join articulos a using(id)
    join tipo_movimiento t using(tipoMovimiento)
    join subtipo_movimiento s using(tipoMovimiento, subtipoMovimiento)
    join proveedor p using(proveedorID)
    join sucursales u on m.clvsucursalReferencia = u.clvsucursal
    join usuarios o using(usuario)
    where statusMovimiento = 1 and tipoMovimiento = ?
    and fechaCierre between ? and ?
    order by fechaCierre, movimientoID, cvearticulo * 1;";
                    
                    $query4 = $this->db->query($sql4, array($row3->tipoMovimiento, $fecha1, $fecha2));
                }else{
                    $sql4 = "SELECT movimientoID, orden, referencia, fecha, fechaCierre, clvsucursalReferencia, observaciones, nuevo_folio, piezas, costo, lote, caducidad, ean, marca, comercial, cvearticulo, susa, descripcion, pres, subtipoMovimientoDescripcion, rfc, razon, descsucursal, nombreusuario FROM movimiento m
    join movimiento_detalle d using(movimientoID)
    join articulos a using(id)
    join tipo_movimiento t using(tipoMovimiento)
    join subtipo_movimiento s using(tipoMovimiento, subtipoMovimiento)
    join proveedor p using(proveedorID)
    join sucursales u on m.clvsucursalReferencia = u.clvsucursal
    join usuarios o using(usuario)
    where statusMovimiento = 1 and tipoMovimiento = ?
    and fechaCierre between ? and ? and cvearticulo = ?
    order by fechaCierre, movimientoID, cvearticulo * 1;";
                    
                    $query4 = $this->db->query($sql4, array($row3->tipoMovimiento, $fecha1, $fecha2, $cvearticulo));
                }
                
                
                $this->excel->getActiveSheet()->mergeCells('A1:K1');
                $this->excel->getActiveSheet()->mergeCells('A2:K2');
                
                $this->excel->getActiveSheet()->mergeCells('L2:N2');
    
                $this->excel->getActiveSheet()->setCellValue('A1', COMPANIA);
                $this->excel->getActiveSheet()->setCellValue('A2', APLICACION . ' DESDE ' . $fecha1 . ' HASTA ' . $fecha2);
                $this->excel->getActiveSheet()->setCellValue('L2', date('d/M/Y H:i:s'));


                $num = 3;
                
                $data_empieza = $num + 1;
                
                $this->excel->getActiveSheet()->setCellValue('A'.$num, '#');
                $this->excel->getActiveSheet()->setCellValue('B'.$num, 'ID MOVIMIENTO');
                $this->excel->getActiveSheet()->setCellValue('C'.$num, 'TIPO');
                $this->excel->getActiveSheet()->setCellValue('D'.$num, 'ORDEN');
                $this->excel->getActiveSheet()->setCellValue('E'.$num, 'REFERENCIA');
                $this->excel->getActiveSheet()->setCellValue('F'.$num, 'FECHA DOC.');
                $this->excel->getActiveSheet()->setCellValue('G'.$num, 'FECHA CIERRE');
                $this->excel->getActiveSheet()->setCellValue('H'.$num, 'CLAVE');
                $this->excel->getActiveSheet()->setCellValue('I'.$num, 'EAN');
                $this->excel->getActiveSheet()->setCellValue('J'.$num, 'COMERCIAL');
                $this->excel->getActiveSheet()->setCellValue('K'.$num, 'SUSTANCIA ACTIVA');
                $this->excel->getActiveSheet()->setCellValue('L'.$num, 'DESCRIPCION');
                $this->excel->getActiveSheet()->setCellValue('M'.$num, 'PRESENTACION');
                $this->excel->getActiveSheet()->setCellValue('N'.$num, 'CANTIDAD');
                $this->excel->getActiveSheet()->setCellValue('O'.$num, 'COSTO');
                $this->excel->getActiveSheet()->setCellValue('P'.$num, 'LOTE');
                $this->excel->getActiveSheet()->setCellValue('Q'.$num, 'CADUCIDAD');
                $this->excel->getActiveSheet()->setCellValue('R'.$num, 'MARCA');
                $this->excel->getActiveSheet()->setCellValue('S'.$num, 'RAZON SOCIAL');
                $this->excel->getActiveSheet()->setCellValue('T'.$num, 'SUCURSAL DESTINO');
                $this->excel->getActiveSheet()->setCellValue('U'.$num, 'USUARIO');
                $this->excel->getActiveSheet()->setCellValue('V'.$num, 'IMPORTE');
                
                $i = 1;

                foreach($query4->result()  as $row4)
                {
                    $num++;
                    
                    $this->excel->getActiveSheet()->setCellValue('A'.$num, $i);
                    $this->excel->getActiveSheet()->setCellValue('B'.$num, $row4->movimientoID);
                    $this->excel->getActiveSheet()->setCellValue('C'.$num, $row4->subtipoMovimientoDescripcion);
                    $this->excel->getActiveSheet()->setCellValue('D'.$num, $row4->orden);
                    $this->excel->getActiveSheet()->setCellValue('E'.$num, $row4->referencia);
                    $this->excel->getActiveSheet()->setCellValue('F'.$num, $row4->fecha);
                    $this->excel->getActiveSheet()->setCellValue('G'.$num, $row4->fechaCierre);
                    $this->excel->getActiveSheet()->setCellValue('H'.$num, $row4->cvearticulo);
                    $this->excel->getActiveSheet()->setCellValue('I'.$num, $row4->ean);
                    $this->excel->getActiveSheet()->setCellValue('J'.$num, $row4->comercial);
                    $this->excel->getActiveSheet()->setCellValue('K'.$num, $row4->susa);
                    $this->excel->getActiveSheet()->setCellValue('L'.$num, $row4->descripcion);
                    $this->excel->getActiveSheet()->setCellValue('M'.$num, $row4->pres);
                    $this->excel->getActiveSheet()->setCellValue('N'.$num, $row4->piezas);
                    $this->excel->getActiveSheet()->setCellValue('O'.$num, $row4->costo);
                    $this->excel->getActiveSheet()->setCellValue('P'.$num, $row4->lote);
                    $this->excel->getActiveSheet()->setCellValue('Q'.$num, $row4->caducidad);
                    $this->excel->getActiveSheet()->setCellValue('R'.$num, $row4->marca);
                    $this->excel->getActiveSheet()->setCellValue('S'.$num, $row4->razon);
                    $this->excel->getActiveSheet()->setCellValue('T'.$num, $row4->descsucursal);
                    $this->excel->getActiveSheet()->setCellValue('U'.$num, $row4->nombreusuario);
                    $this->excel->getActiveSheet()->setCellValue('V'.$num, '=N'.$num.'*O'.$num);
                    
                    $i++;
                    
                }
                
                $data_termina = $num;

                $this->excel->getActiveSheet()->setCellValue('N'.($data_termina + 1), '=sum(N'.$data_empieza.':N'.$data_termina.')');
                $this->excel->getActiveSheet()->setCellValue('V'.($data_termina + 1), '=sum(V'.$data_empieza.':V'.$data_termina.')');
                
                
                $this->excel->getActiveSheet()->getStyle('N'.$data_empieza.':N'.($data_termina + 1))->getNumberFormat()->setFormatCode('#,##0');
                $this->excel->getActiveSheet()->getStyle('O'.$data_empieza.':O'.$data_termina)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                $this->excel->getActiveSheet()->getStyle('V'.$data_empieza.':V'.($data_termina + 1))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                $this->excel->getActiveSheet()->getStyle('E'.$data_empieza.':E'.$data_termina)->getNumberFormat()->setFormatCode('0');
                $this->excel->getActiveSheet()->getStyle('H'.$data_empieza.':H'.$data_termina)->getNumberFormat()->setFormatCode('0');
                $this->excel->getActiveSheet()->getStyle('I'.$data_empieza.':I'.$data_termina)->getNumberFormat()->setFormatCode('0');
                
                $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
                
                $this->excel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);
                
                $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(30);
                $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(30);
                $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(30);
                
                $this->excel->getActiveSheet()->getStyle('K'.$data_empieza.':M'.$data_termina)->getAlignment()->setWrapText(true);
                
                $styleArray = array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('argb' => 'FFFF0000'),
                        ),
                    ),
                );
                
                $this->excel->getActiveSheet()->getStyle('A'.($data_empieza - 1).':V'.($data_termina + 1))->applyFromArray($styleArray);
                
                $this->excel->getActiveSheet()->freezePaneByColumnAndRow(0, $data_empieza);
                
                $this->excel->getActiveSheet()->setAutoFilter('A'.($data_empieza - 1).':V'.($data_termina + 1));
    
                $hoja++;
            }
            
        }
        
        if($cvearticulo == null)
        {
            $sql5 = "SELECT * FROM kardex k
    join articulos a using(id)
    join subtipo_movimiento s using(subtipoMovimiento)
    join usuarios u using(usuario)
    where subtipoMovimiento = 11 and fechaKardex between ? and ?;";
            
            $query5 = $this->db->query($sql5, array($fecha1, $fecha2));
        }else{
            $sql5 = "SELECT * FROM kardex k
    join articulos a using(id)
    join subtipo_movimiento s using(subtipoMovimiento)
    join usuarios u using(usuario)
    where subtipoMovimiento = 11 and fechaKardex between ? and ? and cvearticulo = ?;";
            
            $query5 = $this->db->query($sql5, array($fecha1, $fecha2, $cvearticulo));
        }
        
        
        if($query5->num_rows()  > 0)
        {
            $this->excel->createSheet($hoja);
            $this->excel->setActiveSheetIndex($hoja);
            $this->excel->getActiveSheet()->getTabColor()->setRGB('4682B4');
            $this->excel->getActiveSheet()->setTitle('AJUSTES');
            
            
                $this->excel->getActiveSheet()->mergeCells('A1:K1');
                $this->excel->getActiveSheet()->mergeCells('A2:K2');
                
                $this->excel->getActiveSheet()->mergeCells('L2:N2');
    
                $this->excel->getActiveSheet()->setCellValue('A1', COMPANIA);
                $this->excel->getActiveSheet()->setCellValue('A2', APLICACION . ' DESDE ' . $fecha1 . ' HASTA ' . $fecha2);
                $this->excel->getActiveSheet()->setCellValue('L2', date('d/M/Y H:i:s'));


                $num = 3;
                
                $data_empieza = $num + 1;
                
                $this->excel->getActiveSheet()->setCellValue('A'.$num, '#');
                $this->excel->getActiveSheet()->setCellValue('B'.$num, 'ID KARDEX');
                $this->excel->getActiveSheet()->setCellValue('C'.$num, 'TIPO');
                $this->excel->getActiveSheet()->setCellValue('D'.$num, 'FECHA AJUSTE');
                $this->excel->getActiveSheet()->setCellValue('E'.$num, 'CLAVE');
                $this->excel->getActiveSheet()->setCellValue('F'.$num, 'COMERCIAL');
                $this->excel->getActiveSheet()->setCellValue('G'.$num, 'SUSTANCIA ACTIVA');
                $this->excel->getActiveSheet()->setCellValue('H'.$num, 'DESCRIPCION');
                $this->excel->getActiveSheet()->setCellValue('I'.$num, 'PRESENTACION');
                $this->excel->getActiveSheet()->setCellValue('J'.$num, 'CANTIDAD ANTERIOR');
                $this->excel->getActiveSheet()->setCellValue('K'.$num, 'CANTIDAD NUEVA');
                $this->excel->getActiveSheet()->setCellValue('L'.$num, 'LOTE');
                $this->excel->getActiveSheet()->setCellValue('M'.$num, 'CADUCIDAD');
                $this->excel->getActiveSheet()->setCellValue('N'.$num, 'USUARIO');
                
                $i = 1;

                foreach($query5->result()  as $row5)
                {
                    $num++;
                    
                    $this->excel->getActiveSheet()->setCellValue('A'.$num, $i);
                    $this->excel->getActiveSheet()->setCellValue('B'.$num, $row5->kardexID);
                    $this->excel->getActiveSheet()->setCellValue('C'.$num, $row5->subtipoMovimientoDescripcion);
                    $this->excel->getActiveSheet()->setCellValue('D'.$num, $row5->fechaKardex);
                    $this->excel->getActiveSheet()->setCellValue('E'.$num, $row5->cvearticulo);
                    $this->excel->getActiveSheet()->setCellValue('F'.$num, $row5->comercial);
                    $this->excel->getActiveSheet()->setCellValue('G'.$num, $row5->susa);
                    $this->excel->getActiveSheet()->setCellValue('H'.$num, $row5->descripcion);
                    $this->excel->getActiveSheet()->setCellValue('I'.$num, $row5->pres);
                    $this->excel->getActiveSheet()->setCellValue('J'.$num, $row5->cantidadOld);
                    $this->excel->getActiveSheet()->setCellValue('K'.$num, $row5->cantidadNew);
                    $this->excel->getActiveSheet()->setCellValue('L'.$num, $row5->lote);
                    $this->excel->getActiveSheet()->setCellValue('M'.$num, $row5->caducidad);
                    $this->excel->getActiveSheet()->setCellValue('N'.$num, $row5->nombreusuario);
                    
                    $i++;
                    
                }
                
                $data_termina = $num;

                $this->excel->getActiveSheet()->setCellValue('J'.($data_termina + 1), '=sum(J'.$data_empieza.':J'.$data_termina.')');
                $this->excel->getActiveSheet()->setCellValue('K'.($data_termina + 1), '=sum(K'.$data_empieza.':K'.$data_termina.')');
                $this->excel->getActiveSheet()->getStyle('J'.$data_empieza.':J'.($data_termina + 1))->getNumberFormat()->setFormatCode('#,##0');
                $this->excel->getActiveSheet()->getStyle('K'.$data_empieza.':K'.($data_termina + 1))->getNumberFormat()->setFormatCode('#,##0');
                
                
                $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
                
                $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
                
                $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
                $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
                $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
                
                $this->excel->getActiveSheet()->getStyle('G'.$data_empieza.':I'.$data_termina)->getAlignment()->setWrapText(true);
                
                $styleArray = array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('argb' => 'FFFF0000'),
                        ),
                    ),
                );
                
                $this->excel->getActiveSheet()->getStyle('A'.($data_empieza - 1).':N'.($data_termina + 1))->applyFromArray($styleArray);
                
                $this->excel->getActiveSheet()->freezePaneByColumnAndRow(0, $data_empieza);
                
                $this->excel->getActiveSheet()->setAutoFilter('A'.($data_empieza - 1).':N'.($data_termina + 1));

            $hoja++;
        }
        
    }

    function getMovimiento($tipoMovimiento, $fecha1, $fecha2, $proveedorID = null, $clvsucursal = null)
    {
        set_time_limit(0);
        ini_set("memory_limit","-1");
        $this->load->library('excel');
        $cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_gzip;
        if (!PHPExcel_Settings::setCacheStorageMethod($cacheMethod)) {
        	die($cacheMethod . " caching method is not available" . EOL);
        }
        
        $hoja = 0;
        
            $fecha1 = $fecha1 . ' 00:00:00';
            $fecha2 = $fecha2 . ' 23:59:59';
            
            
                $this->excel->createSheet($hoja);
                $this->excel->setActiveSheetIndex($hoja);
                
                if($tipoMovimiento == 1)
                {
                    $this->excel->getActiveSheet()->getTabColor()->setRGB('32CD32');
                    $this->excel->getActiveSheet()->setTitle('ENTRADA');
                }else{
                    $this->excel->getActiveSheet()->getTabColor()->setRGB('FF0000');
                    $this->excel->getActiveSheet()->setTitle('SALIDA');
                }
                
                
                if($tipoMovimiento == 1)
                {
                    
                    if($proveedorID == null)
                    {
                        $sql4 = "SELECT movimientoID, orden, referencia, fecha, fechaCierre, clvsucursalReferencia, observaciones, nuevo_folio, piezas, costo, lote, caducidad, ean, marca, comercial, cvearticulo, susa, descripcion, pres, subtipoMovimientoDescripcion, rfc, razon, descsucursal, nombreusuario FROM movimiento m
        join movimiento_detalle d using(movimientoID)
        join articulos a using(id)
        join tipo_movimiento t using(tipoMovimiento)
        join subtipo_movimiento s using(tipoMovimiento, subtipoMovimiento)
        join proveedor p using(proveedorID)
        join sucursales u on m.clvsucursalReferencia = u.clvsucursal
        join usuarios o using(usuario)
        where statusMovimiento = 1 and tipoMovimiento = ?
        and fechaCierre between ? and ?
        order by fechaCierre, movimientoID, cvearticulo * 1;";
                        
                        $query4 = $this->db->query($sql4, array($tipoMovimiento, $fecha1, $fecha2));
                    }else{
                        $sql4 = "SELECT movimientoID, orden, referencia, fecha, fechaCierre, clvsucursalReferencia, observaciones, nuevo_folio, piezas, costo, lote, caducidad, ean, marca, comercial, cvearticulo, susa, descripcion, pres, subtipoMovimientoDescripcion, rfc, razon, descsucursal, nombreusuario FROM movimiento m
        join movimiento_detalle d using(movimientoID)
        join articulos a using(id)
        join tipo_movimiento t using(tipoMovimiento)
        join subtipo_movimiento s using(tipoMovimiento, subtipoMovimiento)
        join proveedor p using(proveedorID)
        join sucursales u on m.clvsucursalReferencia = u.clvsucursal
        join usuarios o using(usuario)
        where statusMovimiento = 1 and tipoMovimiento = ?
        and fechaCierre between ? and ? and proveedorID = ?
        order by fechaCierre, movimientoID, cvearticulo * 1;";
                        
                        $query4 = $this->db->query($sql4, array($tipoMovimiento, $fecha1, $fecha2, $proveedorID));
                    }

                }else{
                    
                    if($clvsucursal == null)
                    {
                        $sql4 = "SELECT movimientoID, orden, referencia, fecha, fechaCierre, clvsucursalReferencia, observaciones, nuevo_folio, piezas, costo, lote, caducidad, ean, marca, comercial, cvearticulo, susa, descripcion, pres, subtipoMovimientoDescripcion, rfc, razon, descsucursal, nombreusuario FROM movimiento m
        join movimiento_detalle d using(movimientoID)
        join articulos a using(id)
        join tipo_movimiento t using(tipoMovimiento)
        join subtipo_movimiento s using(tipoMovimiento, subtipoMovimiento)
        join proveedor p using(proveedorID)
        join sucursales u on m.clvsucursalReferencia = u.clvsucursal
        join usuarios o using(usuario)
        where statusMovimiento = 1 and tipoMovimiento = ?
        and fechaCierre between ? and ?
        order by fechaCierre, movimientoID, cvearticulo * 1;";
                        
                        $query4 = $this->db->query($sql4, array($tipoMovimiento, $fecha1, $fecha2));
                    }else{
                        $sql4 = "SELECT movimientoID, orden, referencia, fecha, fechaCierre, clvsucursalReferencia, observaciones, nuevo_folio, piezas, costo, lote, caducidad, ean, marca, comercial, cvearticulo, susa, descripcion, pres, subtipoMovimientoDescripcion, rfc, razon, descsucursal, nombreusuario FROM movimiento m
        join movimiento_detalle d using(movimientoID)
        join articulos a using(id)
        join tipo_movimiento t using(tipoMovimiento)
        join subtipo_movimiento s using(tipoMovimiento, subtipoMovimiento)
        join proveedor p using(proveedorID)
        join sucursales u on m.clvsucursalReferencia = u.clvsucursal
        join usuarios o using(usuario)
        where statusMovimiento = 1 and tipoMovimiento = ?
        and fechaCierre between ? and ? and u.clvsucursal = ?
        order by fechaCierre, movimientoID, cvearticulo * 1;";
                        
                        $query4 = $this->db->query($sql4, array($tipoMovimiento, $fecha1, $fecha2, $clvsucursal));
                    }

                }
                
                
                
                
                $this->excel->getActiveSheet()->mergeCells('A1:K1');
                $this->excel->getActiveSheet()->mergeCells('A2:K2');
                
                $this->excel->getActiveSheet()->mergeCells('L2:N2');
    
                $this->excel->getActiveSheet()->setCellValue('A1', COMPANIA);
                $this->excel->getActiveSheet()->setCellValue('A2', APLICACION . ' DESDE ' . $fecha1 . ' HASTA ' . $fecha2);
                $this->excel->getActiveSheet()->setCellValue('L2', date('d/M/Y H:i:s'));


                $num = 3;
                
                $data_empieza = $num + 1;
                
                $this->excel->getActiveSheet()->setCellValue('A'.$num, '#');
                $this->excel->getActiveSheet()->setCellValue('B'.$num, 'ID MOVIMIENTO');
                $this->excel->getActiveSheet()->setCellValue('C'.$num, 'TIPO');
                $this->excel->getActiveSheet()->setCellValue('D'.$num, 'ORDEN');
                $this->excel->getActiveSheet()->setCellValue('E'.$num, 'REFERENCIA');
                $this->excel->getActiveSheet()->setCellValue('F'.$num, 'FECHA DOC.');
                $this->excel->getActiveSheet()->setCellValue('G'.$num, 'FECHA CIERRE');
                $this->excel->getActiveSheet()->setCellValue('H'.$num, 'CLAVE');
                $this->excel->getActiveSheet()->setCellValue('I'.$num, 'EAN');
                $this->excel->getActiveSheet()->setCellValue('J'.$num, 'COMERCIAL');
                $this->excel->getActiveSheet()->setCellValue('K'.$num, 'SUSTANCIA ACTIVA');
                $this->excel->getActiveSheet()->setCellValue('L'.$num, 'DESCRIPCION');
                $this->excel->getActiveSheet()->setCellValue('M'.$num, 'PRESENTACION');
                $this->excel->getActiveSheet()->setCellValue('N'.$num, 'CANTIDAD');
                $this->excel->getActiveSheet()->setCellValue('O'.$num, 'COSTO');
                $this->excel->getActiveSheet()->setCellValue('P'.$num, 'LOTE');
                $this->excel->getActiveSheet()->setCellValue('Q'.$num, 'CADUCIDAD');
                $this->excel->getActiveSheet()->setCellValue('R'.$num, 'MARCA');
                $this->excel->getActiveSheet()->setCellValue('S'.$num, 'RAZON SOCIAL');
                $this->excel->getActiveSheet()->setCellValue('T'.$num, 'SUCURSAL DESTINO');
                $this->excel->getActiveSheet()->setCellValue('U'.$num, 'USUARIO');
                $this->excel->getActiveSheet()->setCellValue('V'.$num, 'IMPORTE');
                
                $i = 1;

                foreach($query4->result()  as $row4)
                {
                    $num++;
                    
                    $this->excel->getActiveSheet()->setCellValue('A'.$num, $i);
                    $this->excel->getActiveSheet()->setCellValue('B'.$num, $row4->movimientoID);
                    $this->excel->getActiveSheet()->setCellValue('C'.$num, $row4->subtipoMovimientoDescripcion);
                    $this->excel->getActiveSheet()->setCellValue('D'.$num, $row4->orden);
                    $this->excel->getActiveSheet()->setCellValue('E'.$num, $row4->referencia);
                    $this->excel->getActiveSheet()->setCellValue('F'.$num, $row4->fecha);
                    $this->excel->getActiveSheet()->setCellValue('G'.$num, $row4->fechaCierre);
                    $this->excel->getActiveSheet()->setCellValue('H'.$num, $row4->cvearticulo);
                    $this->excel->getActiveSheet()->setCellValue('I'.$num, $row4->ean);
                    $this->excel->getActiveSheet()->setCellValue('J'.$num, $row4->comercial);
                    $this->excel->getActiveSheet()->setCellValue('K'.$num, $row4->susa);
                    $this->excel->getActiveSheet()->setCellValue('L'.$num, $row4->descripcion);
                    $this->excel->getActiveSheet()->setCellValue('M'.$num, $row4->pres);
                    $this->excel->getActiveSheet()->setCellValue('N'.$num, $row4->piezas);
                    $this->excel->getActiveSheet()->setCellValue('O'.$num, $row4->costo);
                    $this->excel->getActiveSheet()->setCellValue('P'.$num, $row4->lote);
                    $this->excel->getActiveSheet()->setCellValue('Q'.$num, $row4->caducidad);
                    $this->excel->getActiveSheet()->setCellValue('R'.$num, $row4->marca);
                    $this->excel->getActiveSheet()->setCellValue('S'.$num, $row4->razon);
                    $this->excel->getActiveSheet()->setCellValue('T'.$num, $row4->descsucursal);
                    $this->excel->getActiveSheet()->setCellValue('U'.$num, $row4->nombreusuario);
                    $this->excel->getActiveSheet()->setCellValue('V'.$num, '=N'.$num.'*O'.$num);
                    
                    $i++;
                    
                }
                
                $data_termina = $num;

                $this->excel->getActiveSheet()->setCellValue('N'.($data_termina + 1), '=sum(N'.$data_empieza.':N'.$data_termina.')');
                $this->excel->getActiveSheet()->setCellValue('V'.($data_termina + 1), '=sum(V'.$data_empieza.':V'.$data_termina.')');
                
                
                $this->excel->getActiveSheet()->getStyle('N'.$data_empieza.':N'.($data_termina + 1))->getNumberFormat()->setFormatCode('#,##0');
                $this->excel->getActiveSheet()->getStyle('O'.$data_empieza.':O'.$data_termina)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                $this->excel->getActiveSheet()->getStyle('V'.$data_empieza.':V'.($data_termina + 1))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                $this->excel->getActiveSheet()->getStyle('E'.$data_empieza.':E'.$data_termina)->getNumberFormat()->setFormatCode('0');
                $this->excel->getActiveSheet()->getStyle('H'.$data_empieza.':H'.$data_termina)->getNumberFormat()->setFormatCode('0');
                $this->excel->getActiveSheet()->getStyle('I'.$data_empieza.':I'.$data_termina)->getNumberFormat()->setFormatCode('0');
                
                $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
                
                $this->excel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);
                
                $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(30);
                $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(30);
                $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(30);
                
                $this->excel->getActiveSheet()->getStyle('K'.$data_empieza.':M'.$data_termina)->getAlignment()->setWrapText(true);
                
                $styleArray = array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('argb' => 'FFFF0000'),
                        ),
                    ),
                );
                
                $this->excel->getActiveSheet()->getStyle('A'.($data_empieza - 1).':V'.($data_termina + 1))->applyFromArray($styleArray);
                
                $this->excel->getActiveSheet()->freezePaneByColumnAndRow(0, $data_empieza);
                
                $this->excel->getActiveSheet()->setAutoFilter('A'.($data_empieza - 1).':V'.($data_termina + 1));
    
                $hoja++;
        
    }

    function header($fecha1, $fecha2, $orden)
    {
        
        if($orden == 0)
        {
            $o = 'TODAS';
        }else{
            $o = $orden;
        }
        
        $logo = array(
                                  'src' => base_url().'assets/img/logo.png',
                                  'width' => '120'
                        );
                        
        
        
        $tabla = '<table cellpadding="1">
            <tr>
                <td rowspan="3" width="100px">'.img($logo).'</td>
                <td rowspan="3" width="450px" align="center"><font size="8">'.COMPANIA.'<br />REPORTE DE FACTURAS PARA CUENTAS POR PAGAR.<br />'.APLICACION.'</font></td>
                <td width="75px">Fecha inicial: </td>
                <td width="95px" align="right">'.$fecha1.'</td>
            </tr>
            <tr>
                <td width="75px">Fecha final: </td>
                <td width="95px" align="right">'.$fecha2.'</td>
            </tr>
            <tr>
                <td width="75px">Orden: </td>
                <td width="95px" align="right">'.$o.'</td>
            </tr>
        </table>';
        
        return $tabla;
    }
    
    function getFacturas($fecha1, $fecha2, $orden)
    {
        $fecha1 = $fecha1 . ' 00:00:00';
        $fecha2 = $fecha2 . ' 23:59:59';
        
        if($orden == 0)
        {
            $o = null;
        }else{
            $o = ' and m.orden = ' . $orden;
        }
        
        $sql = "SELECT referencia, razon, fecha, orden, nuevo_folio, observaciones, nombreusuario, movimientoID
                FROM movimiento m
                join proveedor o using(proveedorID)
                left join usuarios u using(usuario)
                where statusMovimiento = 1 and subtipoMovimiento = 1 and fechaCierre between ? and ? $o
                order by fechaCierre, referencia;";

        $query = $this->db->query($sql, array($fecha1, $fecha2));
        
        return $query;
    }
    
    function getFacturaDetalle($movimientoID)
    {
        $sql = "SELECT * FROM movimiento m
                join proveedor o using(proveedorID)
                join movimiento_detalle d using(movimientoID)
                join articulos a using(id)
                where movimientoID = ?
                order by fechaCierre, referencia;";
        $query = $this->db->query($sql, $movimientoID);
        return $query;
    }
    
    
   
   function getAreas()
    {
     $s = "SELECT * FROM area order by area";
     $q = $this->db->query($s);
     $area = array();
        $area[0] = "Selecciona un Area";
        foreach($q->result() as $row){
            $area[$row->areaID] = $row->area;
        }
        return $area;
    }
    
    function repes_detalle($fecha1, $fecha2, $area)
    {
     $s = "SELECT razon, cvearticulo, susa, d.lote, d.caducidad,i.costo, sum(case when m.tipoMovimiento = 1 then piezas else 0 end) as entradas, sum(case when m.tipoMovimiento = 2 then piezas else 0 end) as salidas, cantidad
           FROM movimiento m
           join movimiento_detalle d using(movimientoID)
           join articulos a using(id)
           join inventario i on a.id = i.id and d.id = i.id and d.lote = i.lote
           left join proveedor p using(proveedorID)
           join ubicacion u on i.ubicacion = u.ubicacion
           where m.subtipoMovimiento in(1, 3) and fechaCierre between ? and ? and areaID = ?
           group by d.id, d.lote
           order by tipoprod, cvearticulo * 1;"; 
       $q = $this->db->query($s,array($fecha1 . ' 00:00:00',$fecha2.' 23:59:59',$area));
       return $q; 
    }
    
    function getEs($fecha1, $fecha2,$area){
      
        set_time_limit(0);
        ini_set("memory_limit","-1");
        $this->load->library('excel');
        $cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_gzip;
        if (!PHPExcel_Settings::setCacheStorageMethod($cacheMethod)) {
        	die($cacheMethod . " caching method is not available" . EOL);
        }
        
        $hoja = 0;
        
            $fecha1 = $fecha1 . ' 00:00:00';
            $fecha2 = $fecha2 . ' 23:59:59';
            
            
                $this->excel->createSheet($hoja);
                $this->excel->setActiveSheetIndex($hoja);
                $this->excel->getActiveSheet()->getTabColor()->setRGB('32CD32');
                $this->excel->getActiveSheet()->setTitle('E-S');
            
      $sql4 = "SELECT razon, cvearticulo, susa, d.lote, d.caducidad,i.costo, sum(case when m.tipoMovimiento = 1 then piezas else 0 end) as entradas, sum(case when m.tipoMovimiento = 2 then piezas else 0 end) as salidas, cantidad
               FROM movimiento m
               join movimiento_detalle d using(movimientoID)
               join articulos a using(id)
               join inventario i on a.id = i.id and d.id = i.id and d.lote = i.lote
               left join proveedor p using(proveedorID)
               join ubicacion u on i.ubicacion = u.ubicacion
               where fechaCierre between ? and ? and areaID = ?
               group by d.id, d.lote
               order by tipoprod, cvearticulo * 1;";
                        
        $query4 = $this->db->query($sql4, array($fecha1 . ' 00:00:00',$fecha2.' 23:59:59',$area));
  
                $this->excel->getActiveSheet()->mergeCells('A1:K1');
                $this->excel->getActiveSheet()->mergeCells('A2:K2');
                $this->excel->getActiveSheet()->mergeCells('I2:J2');
    
                $this->excel->getActiveSheet()->setCellValue('A1', COMPANIA);
                $this->excel->getActiveSheet()->setCellValue('A2', APLICACION . ' DESDE ' . $fecha1 . ' HASTA ' . $fecha2);
                $this->excel->getActiveSheet()->setCellValue('J2', date('d/M/Y H:i:s'));


                $num = 3;
                
                $data_empieza = $num + 1;
                
                $this->excel->getActiveSheet()->setCellValue('A'.$num, '#');
                $this->excel->getActiveSheet()->setCellValue('B'.$num, 'PROVEEDOR');
                $this->excel->getActiveSheet()->setCellValue('C'.$num, 'CLAVE');
                $this->excel->getActiveSheet()->setCellValue('D'.$num, 'SUSTANCIA');
                $this->excel->getActiveSheet()->setCellValue('E'.$num, 'LOTE');
                $this->excel->getActiveSheet()->setCellValue('F'.$num, 'CADUCIDAD');
                $this->excel->getActiveSheet()->setCellValue('G'.$num, 'COSTO');
                $this->excel->getActiveSheet()->setCellValue('H'.$num, 'ENTRADA');
                $this->excel->getActiveSheet()->setCellValue('I'.$num, 'SALIDA');
                $this->excel->getActiveSheet()->setCellValue('J'.$num, 'RESTANTE');
                                
                $i = 1;
                foreach($query4->result()  as $row4)
                {
                    $num++;
                    $this->excel->getActiveSheet()->setCellValue('A'.$num, $i);
                    $this->excel->getActiveSheet()->setCellValue('B'.$num, $row4->razon);
                    $this->excel->getActiveSheet()->setCellValue('C'.$num, $row4->cvearticulo);
                    $this->excel->getActiveSheet()->setCellValue('D'.$num, $row4->susa);
                    $this->excel->getActiveSheet()->setCellValue('E'.$num, $row4->lote);
                    $this->excel->getActiveSheet()->setCellValue('F'.$num, $row4->caducidad);
                    $this->excel->getActiveSheet()->setCellValue('G'.$num, number_format($row4->costo,2));
                    $this->excel->getActiveSheet()->setCellValue('H'.$num, number_format($row4->entradas, 0));
                    $this->excel->getActiveSheet()->setCellValue('I'.$num, number_format($row4->salidas, 0));
                    $this->excel->getActiveSheet()->setCellValue('J'.$num, number_format($row4->cantidad, 0));
                    //$this->excel->getActiveSheet()->setCellValue('J'.$num, '=N'.$num.'*O'.$num);
                    
                    $i++;
                    
                }
                
                $data_termina = $num;
               
                $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
                
                $styleArray = array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('argb' => 'FFFF0000'),
                        ),
                    ),
                );
                
                $this->excel->getActiveSheet()->getStyle('A'.($data_empieza - 1).':J'.($data_termina + 1))->applyFromArray($styleArray);
                
                $this->excel->getActiveSheet()->freezePaneByColumnAndRow(0, $data_empieza);
                
                $this->excel->getActiveSheet()->setAutoFilter('A'.($data_empieza - 1).':J'.($data_termina + 1));
    
                $hoja++;  
    }
    
    function getMovimiento2($tipoMovimiento, $fecha1, $fecha2, $proveedorID = null){
        set_time_limit(0);
        ini_set("memory_limit","-1");
        $this->load->library('excel');
        $cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_gzip;
        if (!PHPExcel_Settings::setCacheStorageMethod($cacheMethod)) {
        	die($cacheMethod . " caching method is not available" . EOL);
        }
        
        $hoja = 0;
        
            $fecha1 = $fecha1 . ' 00:00:00';
            $fecha2 = $fecha2 . ' 23:59:59';
            
            
                $this->excel->createSheet($hoja);
                $this->excel->setActiveSheetIndex($hoja);
                
                if($tipoMovimiento == 1)
                {
                    $this->excel->getActiveSheet()->getTabColor()->setRGB('32CD32');
                    $this->excel->getActiveSheet()->setTitle('ENTRADA');
                }else{
                    
                }                
                
                if($tipoMovimiento == 1)
                {
                    
                    if($proveedorID == null)
                    {
                        $sql4 = "SELECT p.proveedorID,razon,referencia, cvearticulo,descripcion,piezas, costo, fecha, fechaCierre
                                 FROM movimiento m
                                 join movimiento_detalle d using(movimientoID)
                                 join articulos a using(id)
                                 join tipo_movimiento t using(tipoMovimiento)
                                 join subtipo_movimiento s using(tipoMovimiento, subtipoMovimiento)
                                 join proveedor p using(proveedorID)
                                 join sucursales u on m.clvsucursalReferencia = u.clvsucursal
                                 join usuarios o using(usuario)
                                 where statusMovimiento = 1 and tipoMovimiento = ?
                                 and fechaCierre between ? and ?
                                 order by fechaCierre, proveedorID, cvearticulo * 1;";
                        
                        $query4 = $this->db->query($sql4, array($tipoMovimiento, $fecha1, $fecha2));
                    }else{
                        $sql4 = "SELECT p.proveedorID,razon,referencia, cvearticulo,descripcion,piezas, costo, fecha, fechaCierre
                                FROM movimiento m
                                join movimiento_detalle d using(movimientoID)
                                join articulos a using(id)
                                join tipo_movimiento t using(tipoMovimiento)
                                join subtipo_movimiento s using(tipoMovimiento, subtipoMovimiento)
                                join proveedor p using(proveedorID)
                                join sucursales u on m.clvsucursalReferencia = u.clvsucursal
                                join usuarios o using(usuario)
                                where statusMovimiento = 1 and tipoMovimiento = ?
                                and fechaCierre between ? and ? and p.proveedorID = ?
                                order by fechaCierre, proveedorID, cvearticulo * 1;";
                        $query4 = $this->db->query($sql4, array($tipoMovimiento, $fecha1, $fecha2, $proveedorID));
                    }
                }else{
                    
                }
                
                $this->excel->getActiveSheet()->mergeCells('A1:J1');
                $this->excel->getActiveSheet()->mergeCells('A2:J2');
                $this->excel->getActiveSheet()->setCellValue('A1', COMPANIA);
                $this->excel->getActiveSheet()->setCellValue('A2', APLICACION . ' DESDE ' . $fecha1 . ' HASTA ' . $fecha2);
                $this->excel->getActiveSheet()->setCellValue('G2', date('d/M/Y H:i:s'));


                $num = 3;
                
                $data_empieza = $num + 1;
                
                $this->excel->getActiveSheet()->setCellValue('A'.$num, '#');
                $this->excel->getActiveSheet()->setCellValue('B'.$num, 'ID PROVEEDOR');
                $this->excel->getActiveSheet()->setCellValue('C'.$num, 'RAZON SOCIAL');
                $this->excel->getActiveSheet()->setCellValue('D'.$num, 'FACTURA');
                $this->excel->getActiveSheet()->setCellValue('E'.$num, 'CLAVE');
                $this->excel->getActiveSheet()->setCellValue('F'.$num, 'DESCRIPCION');
                $this->excel->getActiveSheet()->setCellValue('G'.$num, 'PIEZAS');
                $this->excel->getActiveSheet()->setCellValue('H'.$num, 'COSTO');
                $this->excel->getActiveSheet()->setCellValue('I'.$num, 'FECHA');
                $this->excel->getActiveSheet()->setCellValue('J'.$num, 'CIERRE');
                
                $i = 1;

                foreach($query4->result() as $row4)
                {
                    $num++;
                    
                    $this->excel->getActiveSheet()->setCellValue('A'.$num, $i);
                    $this->excel->getActiveSheet()->setCellValue('B'.$num, $row4->proveedorID);
                    $this->excel->getActiveSheet()->setCellValue('C'.$num, $row4->razon);
                    $this->excel->getActiveSheet()->setCellValue('D'.$num, $row4->referencia);
                    $this->excel->getActiveSheet()->setCellValue('E'.$num, $row4->cvearticulo);
                    $this->excel->getActiveSheet()->setCellValue('F'.$num, $row4->descripcion);
                    $this->excel->getActiveSheet()->setCellValue('G'.$num, $row4->piezas);
                    $this->excel->getActiveSheet()->setCellValue('H'.$num, $row4->costo);
                    $this->excel->getActiveSheet()->setCellValue('I'.$num, $row4->fecha);
                    $this->excel->getActiveSheet()->setCellValue('J'.$num, $row4->fechaCierre);
                    
                    $i++;
                    
                }
                
                $data_termina = $num;
                
                $this->excel->getActiveSheet()->getStyle('N'.$data_empieza.':N'.($data_termina + 1))->getNumberFormat()->setFormatCode('#,##0');
                $this->excel->getActiveSheet()->getStyle('O'.$data_empieza.':O'.$data_termina)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                $this->excel->getActiveSheet()->getStyle('V'.$data_empieza.':V'.($data_termina + 1))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                $this->excel->getActiveSheet()->getStyle('E'.$data_empieza.':E'.$data_termina)->getNumberFormat()->setFormatCode('0');
                $this->excel->getActiveSheet()->getStyle('H'.$data_empieza.':H'.$data_termina)->getNumberFormat()->setFormatCode('0');
                $this->excel->getActiveSheet()->getStyle('I'.$data_empieza.':I'.$data_termina)->getNumberFormat()->setFormatCode('0');
                
                $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
                
                $this->excel->getActiveSheet()->getStyle('F'.$data_empieza.':J'.$data_termina)->getAlignment()->setWrapText(true);
                
                $styleArray = array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('argb' => 'FFFF0000'),
                        ),
                    ),
                );
                
                $this->excel->getActiveSheet()->getStyle('A'.($data_empieza - 1).':J'.($data_termina + 1))->applyFromArray($styleArray);
                
                $this->excel->getActiveSheet()->freezePaneByColumnAndRow(0, $data_empieza);
                
                $this->excel->getActiveSheet()->setAutoFilter('A'.($data_empieza - 1).':J'.($data_termina + 1));
    
                $hoja++;
    }
    
    function getTipoMov(){
        $s = "SELECT * FROM tipo_movimiento";
        $q = $this->db->query($s);
        $a = array();
        $a[0]='Selecciona el tipo de Movimiento';
        foreach($q->result() as $row){
            $a[$row->tipoMovimiento] = $row->tipoMovimientoDescripcion;
        }
        return $a;
    }
    
    function getMovimiento3($tipoMovimiento,$fecha1, $fecha2){
      set_time_limit(0);
        ini_set("memory_limit","-1");
        $this->load->library('excel');
        $cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_gzip;
        if (!PHPExcel_Settings::setCacheStorageMethod($cacheMethod)) {
        	die($cacheMethod . " caching method is not available" . EOL);
        }
        
        $hoja = 0;
        
            $fecha1 = $fecha1 . ' 00:00:00';
            $fecha2 = $fecha2 . ' 23:59:59';
            
            
                $this->excel->createSheet($hoja);
                $this->excel->setActiveSheetIndex($hoja);
                
                if($tipoMovimiento == 1)
                {
                    $this->excel->getActiveSheet()->getTabColor()->setRGB('32CD32');
                    $this->excel->getActiveSheet()->setTitle('ENTRADA');
                }elseif($tipoMovimiento == 2){
                    $this->excel->getActiveSheet()->getTabColor()->setRGB('32CD32');
                    $this->excel->getActiveSheet()->setTitle('SALIDA');
                }
                    
                        $sql4 = "SELECT a.movimientoDetalle,b.tipoMovimiento,a.id,a.movimientoID,cvearticulo,susa,descripcion,pres,
                                sum(a.piezas) as piezas,
                                sum((a.piezas*a.costo)) as costotot
                                FROM movimiento_detalle a
                                join movimiento b using(movimientoID)
                                join articulos c using(id)
                                where tipoMovimiento = ?
                                and fechaCierre between ? and ?
                                group by a.movimientoID,cvearticulo*1
                                order by tipoprod,cvearticulo*1";
                        
                        $query4 = $this->db->query($sql4, array($tipoMovimiento, $fecha1, $fecha2));
                
                
                
                $this->excel->getActiveSheet()->mergeCells('A1:J1');
                $this->excel->getActiveSheet()->mergeCells('A2:J2');
    
                $this->excel->getActiveSheet()->setCellValue('A1', COMPANIA);
                $this->excel->getActiveSheet()->setCellValue('A2', APLICACION . ' DESDE ' . $fecha1 . ' HASTA ' . $fecha2);
                $this->excel->getActiveSheet()->setCellValue('G2', date('d/M/Y H:i:s'));


                $num = 4;
                
                $data_empieza = $num + 1;
                
                $this->excel->getActiveSheet()->setCellValue('A'.$num, '#');
                $this->excel->getActiveSheet()->setCellValue('B'.$num, 'ID');
                $this->excel->getActiveSheet()->setCellValue('C'.$num, 'CLAVE');
                $this->excel->getActiveSheet()->setCellValue('D'.$num, 'SUSTANCIA');
                $this->excel->getActiveSheet()->setCellValue('E'.$num, 'DESCRIPCION');
                $this->excel->getActiveSheet()->setCellValue('F'.$num, 'PRESENTACION');
                $this->excel->getActiveSheet()->setCellValue('G'.$num, 'PIEZAS');
                
                $i = 1;

                foreach($query4->result() as $row4)
                {
                    $num++;
                    
                    $this->excel->getActiveSheet()->setCellValue('A'.$num, $i);
                    $this->excel->getActiveSheet()->setCellValue('B'.$num, $row4->id);
                    $this->excel->getActiveSheet()->setCellValue('C'.$num, $row4->cvearticulo);
                    $this->excel->getActiveSheet()->setCellValue('D'.$num, $row4->susa);
                    $this->excel->getActiveSheet()->setCellValue('E'.$num, $row4->descripcion);
                    $this->excel->getActiveSheet()->setCellValue('F'.$num, $row4->pres);
                    $this->excel->getActiveSheet()->setCellValue('G'.$num, $row4->piezas);
                    
                    $i++;
                    
                }
                
                $data_termina = $num;
                
                $this->excel->getActiveSheet()->getStyle('N'.$data_empieza.':N'.($data_termina + 1))->getNumberFormat()->setFormatCode('#,##0');
                $this->excel->getActiveSheet()->getStyle('O'.$data_empieza.':O'.$data_termina)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                $this->excel->getActiveSheet()->getStyle('V'.$data_empieza.':V'.($data_termina + 1))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                $this->excel->getActiveSheet()->getStyle('E'.$data_empieza.':E'.$data_termina)->getNumberFormat()->setFormatCode('0');
                $this->excel->getActiveSheet()->getStyle('H'.$data_empieza.':H'.$data_termina)->getNumberFormat()->setFormatCode('0');
                $this->excel->getActiveSheet()->getStyle('I'.$data_empieza.':I'.$data_termina)->getNumberFormat()->setFormatCode('0');
                
                $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
                
                $this->excel->getActiveSheet()->getStyle('F'.$data_empieza.':G'.$data_termina)->getAlignment()->setWrapText(true);
                
                $styleArray = array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('argb' => 'FFFF0000'),
                        ),
                    ),
                );
                
                $this->excel->getActiveSheet()->getStyle('A'.($data_empieza - 1).':G'.($data_termina + 1))->applyFromArray($styleArray);
                
                $this->excel->getActiveSheet()->freezePaneByColumnAndRow(0, $data_empieza);
                
                $this->excel->getActiveSheet()->setAutoFilter('A'.($data_empieza - 1).':G'.($data_termina + 1));
    
                $hoja++;  
    }
    
    
    ////////////////////////////////////////////////////////////////////////////////////////////////
    
    function reportes_resumen_entradas($fecha1, $fecha2)
    {
        $sql = "SELECT (SELECT count(referencia) as folio FROM movimiento m where fechaCierre between '$fecha1' and '$fecha2'
                and tipoMovimiento = 1 and subtipoMovimiento in (1,3))as folios,
                count(distinct c.cvearticulo) as claves,sum(b.piezas) as piezas,count(distinct b.lote) as lotes,count(distinct d.razon) as proveedor
                FROM spcentral.movimiento a
                join spcentral.movimiento_detalle b on b.movimientoID = a.movimientoID
                join spcentral.articulos c on c.id = b.id
                join spcentral.proveedor d on d.proveedorID = a.proveedorID
                where a.fechaCierre between '$fecha1' and '$fecha2'
                and a.tipoMovimiento = 1 and a.subtipoMovimiento in (1,3)
                order by a.nuevo_folio;";

        $query = $this->db->query($sql, array($fecha1, $fecha2));
        
        return $query;
    }
    
    function reportes_resumen_entradas_detalle($fecha1, $fecha2)
    {
        $sql = "SELECT a.referencia,c.cvearticulo,b.piezas,c.susa,c.descripcion,c.pres,b.lote,d.razon FROM spcentral.movimiento a
            join spcentral.movimiento_detalle b on b.movimientoID = a.movimientoID
            join spcentral.articulos c on c.id = b.id
            join spcentral.proveedor d on d.proveedorID = a.proveedorID
            where a.fechaCierre between '$fecha1' and '$fecha2' and a.tipoMovimiento = 1 and a.subtipoMovimiento in (1,3) and subtipoMovimiento = 1
            order by a.nuevo_folio;";

        $query = $this->db->query($sql);
        
        return $query;
    }
    
    function entradas_por_clave($fecha1, $fecha2,$cvearticulo)
    {
        $sql = "SELECT count(distinct a.referencia) as facturas,c.cvearticulo,c.descripcion,count(distinct b.lote) as lotes,
                count(distinct b.caducidad) as caducidad,
                sum(b.piezas) as piezas,count(distinct d.razon) as proveedor
                FROM spcentral.movimiento a
                join spcentral.movimiento_detalle b on b.movimientoID = a.movimientoID
                join spcentral.articulos c on c.id = b.id
                join spcentral.proveedor d on d.proveedorID = a.proveedorID
                where a.fechaCierre between '$fecha1' and '$fecha2' and c.cvearticulo = '$cvearticulo'
                and a.tipoMovimiento = 1 and a.subtipoMovimiento in (1,3);";

        $query = $this->db->query($sql);
        
        return $query;
    }
        
    function entradas_por_clave_detalle($fecha1, $fecha2,$cvearticulo)
    {
        $sql = "SELECT a.referencia,c.cvearticulo,c.descripcion,b.lote,b.caducidad,b.piezas,d.razon FROM spcentral.movimiento a
                join spcentral.movimiento_detalle b on b.movimientoID = a.movimientoID
                join spcentral.articulos c on c.id = b.id
                join spcentral.proveedor d on d.proveedorID = a.proveedorID
                where a.fechaCierre between '$fecha1' and '$fecha2' and c.cvearticulo = '$cvearticulo'
                and a.tipoMovimiento = 1 and a.subtipoMovimiento in (1,3) and subtipoMovimiento = 1
                order by a.nuevo_folio;";

        $query = $this->db->query($sql);
        
        return $query;
    }
    
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////    
    function reportes_resumen_salidas($fecha1, $fecha2)
    {
        $sql = "SELECT (SELECT count(referencia) as folio FROM movimiento m where fechaCierre between '$fecha1' and '$fecha2'
                and tipoMovimiento = 2 and subtipoMovimiento in (4,5,6,7,8,9,13))as folios,
                count(distinct c.cvearticulo) as claves,sum(b.piezas) as piezas,count(distinct b.lote) as lotes,
                count(distinct a.clvsucursalReferencia) as sucdestino
                FROM spcentral.movimiento a
                join spcentral.movimiento_detalle b on b.movimientoID = a.movimientoID
                join spcentral.articulos c on c.id = b.id
                join spcentral.sucursales e on e.clvsucursal = a.clvsucursalReferencia
                where a.fechaCierre between '$fecha1' and '$fecha2'
                and a.tipoMovimiento = 2 and a.subtipoMovimiento in (4,5,6,7,8,9,13)
                order by a.referencia;";

        $query = $this->db->query($sql);
        
        return $query;
    }
    
    function reportes_resumen_salidas_detalle($fecha1, $fecha2)
    {
        $sql = "SELECT a.referencia,c.cvearticulo,b.piezas,c.susa,c.descripcion,c.pres,b.lote,a.clvsucursalReferencia,e.descsucursal
                FROM spcentral.movimiento a
                join spcentral.movimiento_detalle b on b.movimientoID = a.movimientoID
                join spcentral.articulos c on c.id = b.id
                join spcentral.proveedor d on d.proveedorID = a.proveedorID
                join spcentral.sucursales e on e.clvsucursal = a.clvsucursalReferencia
                where a.fechaCierre between '$fecha1' and '$fecha2' and tipoMovimiento = 2 
                and a.subtipoMovimiento in (4,5,6,7,8,9,13)
                order by a.referencia;";

        $query = $this->db->query($sql);
        
        return $query;
    }
    
    function salidas_por_clave($fecha1, $fecha2,$cvearticulo)
    {
        $sql = "SELECT count(distinct a.referencia) as facturas,c.cvearticulo,c.descripcion,count(distinct b.lote) as lotes,
                count(distinct b.caducidad) as caducidad,
                sum(b.piezas) as piezas,count(distinct a.clvsucursalReferencia) as Destino
                FROM spcentral.movimiento a
                join spcentral.movimiento_detalle b on b.movimientoID = a.movimientoID
                join spcentral.articulos c on c.id = b.id
                join spcentral.proveedor d on d.proveedorID = a.proveedorID
                join spcentral.sucursales e on e.clvsucursal = a.clvsucursalReferencia
                where a.fechaCierre between '$fecha1' and '$fecha2' and c.cvearticulo = '$cvearticulo'
                and a.tipoMovimiento = 1 and a.subtipoMovimiento in (1,3);";

        $query = $this->db->query($sql);
        
        return $query;
    }
        
    function salidas_por_clave_detalle($fecha1, $fecha2,$cvearticulo)
    {
        $sql = "SELECT a.referencia,c.cvearticulo,c.descripcion,b.lote,b.caducidad,b.piezas,a.clvsucursalReferencia,e.descsucursal
                FROM spcentral.movimiento a
                join spcentral.movimiento_detalle b on b.movimientoID = a.movimientoID
                join spcentral.articulos c on c.id = b.id
                join spcentral.proveedor d on d.proveedorID = a.proveedorID
                join spcentral.sucursales e on e.clvsucursal = a.clvsucursalReferencia
                where a.fechaCierre between '$fecha1' and '$fecha2' and c.cvearticulo = '$cvearticulo'
                and a.tipoMovimiento =  2 and a.subtipoMovimiento in (4,5,6,7,8,9,13)
                order by a.referencia;";

        $query = $this->db->query($sql);
        
        return $query;
    }

}