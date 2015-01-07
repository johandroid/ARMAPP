<?
session_start();
include 'inc/idiomas.inc';
include 'inc/datos_db.inc';
$link = mysql_connect($db_host, $db_user, $db_pass);
$instalacion_id = $_GET["instalacion_id"];
$instalacion_nombre = $_GET["instalacion_nombre"];
$instalacion_zona_horaria = $_GET["instalacion_zona_horaria"];
$inst_cliente_id = $_GET['cliente_id'];
$cambio_nombre = $_GET['cambio_nombre'];

mysql_select_db($db_name_clientes, $link);

$query = sprintf("SELECT cliente_db FROM clientes_datos WHERE cliente_id='%s'", $inst_cliente_id);
//echo '<br>'.$query.'<br>';
$result = mysql_query($query,$link);
if ($result)
{
	if($row = mysql_fetch_array($result))
	{
		$cliente_db_inst=$row['cliente_db'];
		mysql_select_db($cliente_db_inst, $link);
		mysql_free_result($result);
		if($cambio_nombre!=0)
		{
			$query = sprintf("SELECT * FROM cliente_instalaciones WHERE instalacion_nombre='%s'", $instalacion_nombre);
			//echo $query.'<br>';
			$result = mysql_query($query,$link);
			if (!$result)
			{
				echo $idiomas[$_SESSION['opcion_idioma']]['error_acceso_db'].".";
				return;
			}
			else
			{
				if($row = mysql_fetch_array($result))
				{
					echo $idiomas[$_SESSION['opcion_idioma']]['error_instala3'].".";
					mysql_close($link);
					return;
				}
			}
		}
			/*else
			{*/
				mysql_free_result($result);
				$query = sprintf("UPDATE cliente_instalaciones SET instalacion_nombre='%s',instalacion_zona_horaria='%s' where instalacion_id='%s'", $instalacion_nombre, $instalacion_zona_horaria, $instalacion_id);
				//echo '<br>'.$query.'<br>';
				$result = mysql_query($query,$link);
				if ($result)
				{
					echo $idiomas[$_SESSION['opcion_idioma']]['general22']." ".$idiomas[$_SESSION['opcion_idioma']]['general229']." ".$idiomas[$_SESSION['opcion_idioma']]['general7']." ".$instalacion_nombre;
				}
				else
				{
					echo $idiomas[$_SESSION['opcion_idioma']]['instala_text4']." '".$instalacion_nombre."'";
				}
			//}
		//}
	}
	else
	{
		echo $idiomas[$_SESSION['opcion_idioma']]['instala_text4']." '".$instalacion_nombre."'";
	}
}
mysql_close($link);
?>