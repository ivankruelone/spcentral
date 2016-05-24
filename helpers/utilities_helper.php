<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * table_ok_cancel_element
 *
 * Lets you determine whether an array index is set and whether it has a value.
 * If the element is empty it returns FALSE (or whatever you specify as the default value.)
 *
 * @access	public
 * @param	integer
 * @param	string
 * @return	string	depends on what the array contains
 */
if (!function_exists('table_ok_cancel_element')) {
    function table_ok_cancel_element($value)
    {
        if ($value == 1) {
            return '<span class="green"><i class="icon-ok bigger-120"></i></span>';
        } else {
            return '<span class="red"><i class="icon-remove bigger-120"></i></span>';
        }
    }
}

if (!function_exists('dia_de_la_semana')) {
    function dia_de_la_semana($value)
    {
        $a = array(
            '1' => 'DOMINGO',
            '2' => 'LUNES',
            '3' => 'MARTES',
            '4' => 'MIERCOLES',
            '5' => 'JUEVES',
            '6' => 'VIERNES',
            '7' => 'SABADO'
        );
        
        return $a[$value];
    }
}

if ( ! function_exists('formato_caducidad'))
{
	function formato_caducidad($cad)
	{
	   if($cad == "0000-00-00" || $cad == "9999-12-31"){
	       return "SC";
	   }else{
    		$cad = explode('-', $cad);
            if(count($cad) == 3){
                
                if($cad[0]  > 0){
                    
                    $a = array(
                        '01' => 'ENE',
                        '02' => 'FEB',
                        '03' => 'MAR',
                        '04' => 'ABR',
                        '05' => 'MAY',
                        '06' => 'JUN',
                        '07' => 'JUL',
                        '08' => 'AGO',
                        '09' => 'SEP',
                        '10' => 'OCT',
                        '11' => 'NOV',
                        '12' => 'DIC',
                        '00' => 'ND'
                    );
                    
                    return $a[$cad[1]]."/".$cad[0];
                    
                }else{
                    return null;
                }
                
            }else{
                return null;
            }
        
        }
	}
}

if ( ! function_exists('barras'))
{
	function barras($texto)
	{
	   
       return '<img src="'.base_url().'/barcode.php?text='.strtoupper($texto).'" alt="'.strtoupper($texto).'" />';

	}
}

/* End of file utilities.php */
/* Location: ./application/helpers/utilities_helper.php */
