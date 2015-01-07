<?
include 'inc/datos_db.inc';
$operacion_poceso = $_GET["proceso"];

switch($operacion_poceso)
{
	case 'D':
		$comandoP='sudo '.$ruta_scripts.'reset_proceso.sh';
		break;
		
	case 'M':
		$comandoP='sudo '.$ruta_scripts.'reset_monitor.sh';
		break;

	case 'DR':
		$comandoP='sudo '.$ruta_scripts.'reset_proceso_rutinas.sh';
		break;
		
	case 'MR':
		$comandoP='sudo '.$ruta_scripts.'reset_monitor_rutinas.sh';
		break;		

	default:
		return;
		break;
}
system($comandoP, $salida);
echo "Comando ".$comandoP;
echo "Salida ".$salida;
?>