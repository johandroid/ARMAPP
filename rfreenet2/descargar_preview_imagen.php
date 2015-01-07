<?php

include 'inc/datos_db.inc';
$link = mysql_connect($db_host, $db_user, $db_pass);

$gw_id = $_GET["gw_id"];
$cliente_db = $_GET["cliente_db"];
 

mysql_select_db($cliente_db, $link);

$query = sprintf("SELECT gw_imagen FROM cliente_gateways WHERE gw_id='%s';", $gw_id);
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
		if(strlen($row['gw_imagen']) > 0)
		{
			//echo 'pipo';
    	    echo $row['gw_imagen'];
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