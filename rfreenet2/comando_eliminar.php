<?php
	session_start();

	include 'inc/datos_db.inc';
	
	$comando_id=$_GET['comando_id'];
	
	$link = mysql_connect($db_host, $db_user, $db_pass);
	mysql_select_db($_GET['cliente_db'], $link);
	
		// Finalmente, cuando ya está actualizada la red en el gateway sin el nodo, lo eliminamos de DB
		$query = sprintf("DELETE FROM cliente_comandos WHERE comandos_id='%s'",$comando_id);
		//echo $query.'<br>';
		$result = mysql_query($query,$link);
		if(!$result)
		{
			echo "ERROR ";
			echo $query.'<br>';
		}


?>
