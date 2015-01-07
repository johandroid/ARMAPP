<?php
	session_start();
	ini_set('memory_limit','200M');

	include 'inc/datos_db.inc';
	include 'inc/funciones_db.inc';
	
	$sInstalacionActual=$_GET['instalacion_id'];
	$gw_id=$_GET['gw_id'];
	$db_client=$_GET['cliente_db'];
	
	
	require_once('FirePHPCore/FirePHP.class.php'); 
	
	ob_start();
	$mifirePHP = FirePHP::getInstance(true); 	
	
	$mifirePHP->log('INICIO');
	
	$link = mysql_connect($db_host, $db_user, $db_pass);
	
	// en primer lugar lo insertamos en la tabla de suscriptores general
	mysql_select_db($db_client, $link);
	
	$query = sprintf("SELECT cliente_nodos.nodo_ip,cliente_nodos.nodo_mac from cliente_nodos where cliente_nodos.gw_id='%s';",$gw_id);

	$result = mysql_query($query,$link);
	if ($result)
	{
		while($row=mysql_fetch_array($result))
		{
			$mifirePHP->log('ENTRA');
			
			
			$trama = sprintf("i%.4sD000%s%s",$gw_id,$row[0],$row[1]);
			//echo "ERROR9 ";
			//echo $trama."<br>";
			$query2 = sprintf("INSERT INTO cliente_comandos (gw_id,nodo_ip,comandos_trama,comandos_fecha) VALUES ('%s','%s','%s',NOW());",$gw_id,$row[1],$trama);
			
			mysql_query($query2,$link);
		}
		//echo "Usuario $usuario_nombre actualizado correctamente";
	}
	else
	{
		echo "ERROR ";
		//echo $query."<br>";
	}
	echo "OK";
	mysql_close($link);

	
	
?>
