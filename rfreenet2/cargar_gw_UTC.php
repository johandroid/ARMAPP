<?php
	ini_set('memory_limit','200M');
	include 'inc/datos_db.inc';
	include 'inc/funciones_db.inc';
	
	$cliente_db = $_GET["cliente_db"];
	$utc_id=$_GET['utc_id'];
	
	$link = mysql_connect($db_host, $db_user, $db_pass);	
	
	mysql_select_db($cliente_db, $link);
	
	$query = sprintf("SELECT gw_id FROM cliente_analizadores WHERE analizador_id='%s'",$utc_id);
	//echo $query;
	$result = mysql_query($query,$link);
	if(!$result)
	{
		echo "ERROR 2";
	}
	else
	{
		if($row = mysql_fetch_array($result))
		{
			
			echo $row['gw_id'];
		}
		else
		{
			echo "ERROR 3";
		}
	}
	mysql_free_result($result);
	mysql_close($link);			
?>
