<?php

include 'inc/datos_db.inc';
$link = mysql_connect($db_host, $db_user, $db_pass);

$disp_id = $_GET["disp_id"];
$cliente_db = $_GET["cliente_db"];

require_once('FirePHPCore/FirePHP.class.php'); 

ob_start();

$mifirePHP = FirePHP::getInstance(true);	

mysql_select_db($cliente_db, $link);
$query = sprintf("UPDATE cliente_analizadores SET analizador_show_image = 1, analizador_imagen=(SELECT cliente_imagen_gw_aux FROM cliente_aux WHERE gw_id='%s' AND nodo_mac='000000000000') WHERE analizador_id='%s'", $disp_id,$disp_id);
$mifirePHP -> log($query);
$result = mysql_query($query,$link);
if ($result)
{
	$query = sprintf("DELETE FROM cliente_aux WHERE gw_id='%s' AND nodo_mac='000000000000';", $disp_id);
	//echo $query;
	$result = mysql_query($query,$link);
	if (!$result)
	{
		echo "ERROR";	
	}		
}
else
{
	echo "ERROR";
}        	
mysql_close($link);
?>