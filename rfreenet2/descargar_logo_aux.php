<?php

session_start();
require_once('FirePHPCore/FirePHP.class.php'); 

ob_start();

$mifirePHP = FirePHP::getInstance(true);

include 'inc/datos_db.inc';

$id_cliente = $_GET['id_cliente'];

$link = mysql_connect($db_host, $db_user, $db_pass);

mysql_select_db($db_name_clientes, $link);

$query = sprintf("SELECT cliente_logo_aux FROM clientes_datos WHERE cliente_id='".$id_cliente."'");
$mifirePHP -> log($query);
//echo $query;
$result = mysql_query($query,$link);
header("Content-type: image/jpeg");
if(!$result)
{
	//echo "ERROR de conexion con la Base de Datos";
	$fh = file_get_contents('images/sin_imagen.jpg');
	echo $fh;
}
else
{
	if($row = mysql_fetch_array($result))
	{        
		if(strlen($row['cliente_logo_aux']) > 0)
		{
			//echo 'pipo';
    	    echo $row['cliente_logo_aux'];
		}
		else
		{
			//echo "ERROR de conexion con la Base de Datos bueno y que";
			$fh = file_get_contents('images/sin_imagen.jpg');
			echo $fh;
		}
	}
	else
	{
		//echo "ERROR de conexion con la Base de Datos pues bien";
		$fh = file_get_contents('images/sin_imagen.jpg');
		echo $fh;
	}
	mysql_free_result($result);
}
mysql_close($link);
?>