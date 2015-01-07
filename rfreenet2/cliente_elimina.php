<?
session_start();
include 'inc/idiomas.inc';
include 'inc/datos_db.inc';
$link = mysql_connect($db_host, $db_user, $db_pass);
$del_cliente_id = $_GET['cliente_id'];

mysql_select_db($db_name_clientes, $link);

$query = sprintf("SELECT cliente_db FROM clientes_datos WHERE cliente_id='%s'", $del_cliente_id);
//echo '<br>'.$query.'<br>';
$iResultado=0;
$result = mysql_query($query,$link);
if ($result)
{
	if($row = mysql_fetch_array($result))
	{
		$cliente_db_inst=$row[0];
		mysql_free_result($result);
		
		// antes de borrarla, hacemos un backup
		$cadena_fyh= date('dmY');
		$comando_dump=sprintf("mysqldump -h%s -u%s -p%s %s > %s/%s_%s.sql", $db_host, $db_user, $db_pass, $cliente_db_inst, $carpeta_backup, $cliente_db_inst, $cadena_fyh);
		system($comando_dump);
					
		mysql_select_db($cliente_db_inst, $link);		
		$query = sprintf("DROP DATABASE %s", $cliente_db_inst);
		//echo '<br>'.$query.'<br>';
		$result = mysql_query($query,$link);
		if (!$result)
		{
			echo $idiomas[$_SESSION['opcion_idioma']]['general173'];
			$iResultado++;
		}
	}
	else
	{
		$iResultado++;
		echo $idiomas[$_SESSION['opcion_idioma']]['error_acceso_db'];
	}
}

mysql_select_db($db_name_clientes, $link);

$query = sprintf("DELETE FROM clientes_datos where cliente_id='%s'", $del_cliente_id);
//echo '<br>'.$query.'<br>';
$result = mysql_query($query,$link);
if (!$result)

{
	echo $idiomas[$_SESSION['opcion_idioma']]['general168'];
	$iResultado++;
}

$query = sprintf("DELETE FROM clientes_suscriptores where cliente_id='%s'", $del_cliente_id);
//echo '<br>'.$query.'<br>';
$result = mysql_query($query,$link);
if (!$result)
{
	echo $idiomas[$_SESSION['opcion_idioma']]['general169'];
	$iResultado++;
}

$query = sprintf("DELETE FROM clientes_usuarios where cliente_id='%s'", $del_cliente_id);
//echo '<br>'.$query.'<br>';
$result = mysql_query($query,$link);
if (!$result)
{
	echo $idiomas[$_SESSION['opcion_idioma']]['general170'];
	$iResultado++;
}
if ($iResultado > 0)
{
	echo $idiomas[$_SESSION['opcion_idioma']]['general171'];
}
else
{
	echo $idiomas[$_SESSION['opcion_idioma']]['general172'];
}
mysql_close($link);
?>