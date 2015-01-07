<?php
	include 'inc/datos_db.inc';
	include 'inc/funciones_medidas.inc';
	session_start();
	require_once('FirePHPCore/FirePHP.class.php'); 

	ob_start();
	$mifirePHP = FirePHP::getInstance(true);
 
	$gw_id=$_GET['gw_id'];
	$gw_send=$_GET['gw_send'];
	$gw_out=$_GET['gw_out'];
	//echo $gw_send." enviado y out a ".$gw_out;
	$xml_lectura="<Gateway>";	

	// Enviamos trama de modificacion
	//$sTramaLeida=conectar('O'.$gw_id.$i.6);
	
	$cliente_db = $_SESSION["cliente_db"];
	$link = mysql_connect($db_host, $db_user, $db_pass);
	//echo $cliente_db;
	mysql_select_db($cliente_db, $link);

	for($iI = 0; $iI < 4; $iI++)
	{	$mifirePHP -> log($iI);
		if(substr($gw_send, $iI, 1) == 1)
		{
			$mifirePHP -> log("aqui llega");
			$query = sprintf("INSERT INTO cliente_comandos (gw_id,nodo_ip,comandos_trama,comandos_fecha) VALUES ('%s','000','O%s".(string)($iI+1)."%s',NOW());",  $gw_id, $gw_id, substr($gw_out, $iI, 1));
			$mifirePHP -> log($query);
				
			mysql_query($query,$link) or die(mysql_error());
			
			$xml_lectura.="<parametro><nombre>OU".(string)($iI+1)."</nombre><valor>".substr($gw_out, $iI, 1)."</valor><valor2>".substr($gw_send, $iI, 1)."</valor2></parametro>";
			
		}	
	}
	
	//echo $query;

	$xml_lectura.="</Gateway>";
		
	echo $xml_lectura;
?>
