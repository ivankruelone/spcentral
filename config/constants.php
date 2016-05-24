<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


define('COMPANIA', 'FARMACIAS EL FENIX DEL CENTRO S. A. DE C. V.');
define('APLICACION', 'SEGURO POPULAR CENTRAL');
define('OFFICE', 'FRONT-OFFICE');
define('SLOGAN', '...');
define('SERVICIO', '9.98'); 
define('SUCURSAL', 90002);
define('IVA', 0.16);
define('RECETA_PEDIDO', 1);
define('USER_FACTURACION', 'almcontrol');
define('PASS_FACTURACION', 'almcontrol');
define('PATENTE', 0);

define('ROJO', '#FF7F50');
define('NARANJA', '#DAA520');
define('VERDE', '#98FB98');


define('TASKS', 'off');
define('NOTIFICATIONS', 'off');
define('MESSAGES', 'off');



/* End of file constants.php */
/* Location: ./application/config/constants.php */