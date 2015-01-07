<?
include 'inc/datos_db.inc';

$cliente_db = $_GET["cliente_db"];

$OpcionesSalida = "";
$primera_vuelta = 0;

$mysql = mysql_connect($db_host, $db_user, $db_pass);
if(!$mysql)
{
	//echo 'ERROR: No puedo conectar con la base de datos';
	return $OpcionesSalida;
}

//seleccionar la base de datos
$selected = mysql_select_db($cliente_db,$mysql);
if(!$selected)
{
	//echo 'ERROR: No puedo seleccionar la base de datos';
	mysql_close($mysql);
	return $OpcionesSalida;
}

//Consultar la base de datos
$query = "Select * from cliente_instalaciones;";
$result = mysql_query($query,$mysql);
if(!$result)
{
	//echo 'ERROR: Error al consultar la base de datos';
	mysql_close($mysql);
	return $OpcionesSalida;
}
else
{
	while($row = mysql_fetch_array($result))
	{
		if ($primera_vuelta = 0)
		{
			$OpcionesSalida = $OpcionesSalida . sprintf("<option selected='true' value=\"%s\">%s</option>", $row[0], $row[1]);
			$primera_vuelta = 1;
		}
		else
		{
			$OpcionesSalida = $OpcionesSalida . sprintf("<option value=\"%s\">%s</option>", $row[0], $row[1]);
		}
	}

	mysql_free_result($result);
	mysql_close($mysql);
	echo $OpcionesSalida;
}
?>