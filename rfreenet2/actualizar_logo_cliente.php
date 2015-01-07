<?php
session_start();
include 'inc/datos_db.inc';
$link = mysql_connect($db_host, $db_user, $db_pass);
$cliente_id = $_GET["id_cliente"];

require_once('FirePHPCore/FirePHP.class.php'); 

ob_start();

$mifirePHP = FirePHP::getInstance(true);


mysql_select_db($db_name_clientes, $link);
$query = sprintf("UPDATE clientes_datos SET cliente_logo=cliente_logo_aux WHERE cliente_id='".$cliente_id."';");
$mifirePHP -> log($query);
$result = mysql_query($query,$link);
if (!$result)
{	
	echo "ERROR ".mysql_error($link);
}        	
mysql_close($link);
?>