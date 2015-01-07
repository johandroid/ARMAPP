<?
session_start();
include 'inc/idiomas.inc';
include 'inc/datos_db.inc';
include 'inc/funciones_db.inc';
$instalacion_nombre = $_GET["instalacion_nombre"];
$zona_horaria = $_GET['zona_horaria'];
$cliente_db_inst = $_GET['cliente_db'];

//echo '<br>'.$cliente_db_inst.'<br>';

$instalacion_id = sObtener_Nuevo_ID_Instalacion($cliente_db_inst);
//echo '<br>'.$instalacion_id.'<br>';
//echo '<br>'.substr($instalacion_id,0,5).'<br>';
if ($instalacion_id!='ERROR')
{
	//echo $instalacion_id;
	$link2 = mysql_connect($db_host, $db_user, $db_pass);
	mysql_select_db($cliente_db_inst, $link2);
	$query = sprintf("SELECT * FROM cliente_instalaciones WHERE instalacion_nombre='%s'", $instalacion_nombre);
	//echo $query.'<br>';
	$result = mysql_query($query,$link2);
	if (!$result)
	{
		echo $idiomas[$_SESSION['opcion_idioma']]['error_acceso_db'].".";
	}
	else
	{
		if($row = mysql_fetch_array($result))
		{
			echo $idiomas[$_SESSION['opcion_idioma']]['error_instala3'].".";
		}
		else
		{
			mysql_free_result($result);
			$query = sprintf("INSERT INTO cliente_instalaciones (`instalacion_id`,`instalacion_nombre`,`instalacion_zona_horaria`) VALUES ('%s','%s','%s')", $instalacion_id, $instalacion_nombre,$zona_horaria);
			//echo $query.'<br>';
			
			$result = mysql_query($query,$link2);
			if ($result)
			{
				echo $idiomas[$_SESSION['opcion_idioma']]['general7']." '$instalacion_nombre' ".$idiomas[$_SESSION['opcion_idioma']]['general227'];
			}
			else
			{
				echo $idiomas[$_SESSION['opcion_idioma']]['error_instala4']." '$instalacion_nombre'";
			}
		}
	}
}
else
{
	echo $idiomas[$_SESSION['opcion_idioma']]['error_instala5'].': '.$instalacion_id;
}
if ($link2)
{
	mysql_close($link2);
}
?>