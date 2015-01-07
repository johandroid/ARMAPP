<?php

include 'inc/datos_db.inc';
$link = mysql_connect($db_host, $db_user, $db_pass);
require_once('FirePHPCore/FirePHP.class.php'); 

ob_start();
$mifirePHP = FirePHP::getInstance(true); 

$imagen_id = $_GET["imagen_id"];
$tabla = $_GET["tabla"];
$cliente_db = $_GET["cliente_db"];
$instalacion_id = $_GET["instalacion_id"];

mysql_select_db($cliente_db, $link);

$query = sprintf("SELECT imagen_archivo FROM %s WHERE imagen_id='%s'", $tabla, $imagen_id);
//echo $query;
$mifirePHP -> log($query);
$result = mysql_query($query,$link);
header("Content-type: image/jpeg");
if(!$result)
{
	$fh = file_get_contents('images/sin_imagen.jpg');
	echo $fh;
}
else
{
    if($row = mysql_fetch_array($result))
	{
		if(strlen($row['imagen_archivo']) > 0)
		{
    	    echo $row['imagen_archivo'];
		}
		else
		{
			$fh = file_get_contents('images/sin_imagen.jpg');
			echo $fh;
		}
	}
	else
	{
		$fh = file_get_contents('images/sin_imagen.jpg');
		echo $fh;
	}
	mysql_free_result($result);	
}
mysql_close($link);
?>