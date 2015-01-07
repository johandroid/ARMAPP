<?php

include 'inc/datos_db.inc';


require_once('FirePHPCore/FirePHP.class.php'); 

ob_start();

$mifirePHP = FirePHP::getInstance(true);	

$link = mysql_connect($db_host, $db_user, $db_pass);

$disp_id = $_GET["disp_id"];
$cliente_db = $_GET["cliente_db"];
 
mysql_select_db($cliente_db, $link);

$query = sprintf("SELECT analizador_imagen FROM cliente_analizadores WHERE analizador_id='%s';", $disp_id);
$mifirePHP -> log($query);
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
		if(strlen($row['analizador_imagen']) > 0)
		{
			//echo 'pipo';
    	    echo $row['analizador_imagen'];
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