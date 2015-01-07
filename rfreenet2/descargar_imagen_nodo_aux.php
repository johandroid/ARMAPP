<?php

include 'inc/datos_db.inc';
$link = mysql_connect($db_host, $db_user, $db_pass);

$gw_id = $_GET["gw_id"];
$cliente_db = $_GET["cliente_db"];
$nodo_mac = $_GET["nodo_mac"];

mysql_select_db($cliente_db, $link);

$query = sprintf("SELECT cliente_imagen_nodo_aux FROM cliente_aux WHERE gw_id='%s' AND nodo_mac='%s';", $gw_id, $nodo_mac);
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
		if(strlen($row['cliente_imagen_nodo_aux']) > 0)
		{
			//echo 'pipo';
    	    echo $row['cliente_imagen_nodo_aux'];
		}
		else
		{
			//echo "ERROR de conexion con la Base de Datos";
			$fh = file_get_contents('images/sin_imagen.jpg');
			echo $fh;
		}
	}
	else
	{
		//echo "ERROR de conexion con la Base de Datos";
		$fh = file_get_contents('images/sin_imagen.jpg');
		echo $fh;
	}
	mysql_free_result($result);	
}
mysql_close($link);
?>