<?php
	session_start();
	include 'inc/idiomas.inc';
	include 'inc/datos_db.inc';
	include 'inc/funciones_db.inc';
	include 'inc/comunica.inc';
	
	$sInstalacionActual=$_GET['instalacion_id'];
	$sGatewayDEL=$_GET['gw_id'];
	$sMACDEL=$_GET['nodo_mac'];
	$sIPDEL=$_GET['nodo_ip'];
	$offline=$_GET['offline'];
	
	$sComando=sprintf("K%sD1101%s%s",$sGatewayDEL,$sIPDEL,$sMACDEL);
	//$sComando=sprintf("K%sD%s%s",$sGatewayDEL,$sIPDEL,$sMACDEL);
	//echo $sComando.'<br>';
	
	$link = mysql_connect($db_host, $db_user, $db_pass);
	mysql_select_db($_SESSION['cliente_db'], $link);
	
	if ($offline == 0)
	{
		$sTramaLeida=conectar($sComando);
		//echo $sTramaLeida."<br>";
	}
	else
	{
		$query = sprintf("INSERT INTO cliente_comandos (gw_id,nodo_ip,comandos_trama,comandos_fecha) VALUES ('%s','%s','%s',NOW());",  $sGatewayDEL, $sIPDEL, $sComando);
		//echo $query;
		mysql_query($query,$link) or die(mysql_error());
		$sTramaLeida[0] = 'K';
	}
	
	if ($sTramaLeida[0] != 'K')
	{
		//echo "alert('Trama incorrecta');";
		echo "ERROR ";
		return;
	}
	else
	{
		// Finalmente, cuando ya está actualizada la red en el gateway sin el nodo, lo eliminamos de DB
		$query = sprintf("DELETE FROM %s WHERE gw_id='%s' AND nodo_mac='%s'",$tabla_name_nodos,$sGatewayDEL,$sMACDEL);
		//echo $query.'<br>';
		$result = mysql_query($query,$link);
		if(!$result)
		{
			echo "ERROR2 ";
		}
		
		$query = sprintf("DELETE FROM %s WHERE gw_id='%s' AND nodo_mac='%s'",$tabla_name_params_nodos,$sGatewayDEL,$sMACDEL);
		//echo $query.'<br>';
		$result = mysql_query($query,$link);
		if(!$result)
		{
			echo "ERROR3 ";
		}
	}

	echo $idiomas[$_SESSION['opcion_idioma']]['general218'].' '.$sMACDEL.' '.$idiomas[$_SESSION['opcion_idioma']]['general216'];
	mysql_close($link);

?>
