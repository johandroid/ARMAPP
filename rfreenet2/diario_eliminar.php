<?php
	session_start();

	include 'inc/datos_db.inc';
	
	$diario_id=$_GET['diario_id'];
	
	$link = mysql_connect($db_host, $db_user, $db_pass);
	mysql_select_db($_GET['cliente_db'], $link);
	
	$query = sprintf("DELETE FROM cliente_diario WHERE id='%s'",$diario_id);
	echo $query.'<br>';
	$result = mysql_query($query,$link);
	if(!$result)
	{
		echo "ERROR ";
		echo $query.'<br>';
	}


?>
