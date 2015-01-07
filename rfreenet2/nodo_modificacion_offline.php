<?php
	ini_set('memory_limit','200M');
	session_start();
	include 'inc/idiomas.inc';
	include 'inc/datos_db.inc';
	include 'inc/funciones_db.inc';
	
	$comando=$_GET['comando'];
	$indicetrama=$_GET['indicetrama'];
	$sInstalacionActual=$_GET['instalacion_id'];
	$db_client=$_GET['cliente_db'];
	$gw_id = $_GET["gw_id"];
	$nodo_ip = $_GET["nodo_ip"];
	
	// Ahora debemos parsear la trama y montar tramas de modificacion de como mucho 48 chars
	$xml_lectura='';
	$sFin=0;
	$NumTrama=0;

	$sParametro = strtok($comando,";");
	$sPrincipio = $sParametro;
	$sParametro = strtok(";");
	//echo $sPrincipio.'<br>';
	
	$link = mysql_connect($db_host, $db_user, $db_pass);
	mysql_select_db($db_client, $link);
	while (($sFin==0) && ($xml_lectura==''))
	{
		$IndiceTramaActual = intval($indicetrama) + $NumTrama;
		$trama_actual=$sPrincipio."IDT".str_pad(substr(($IndiceTramaActual)."",-4,4),4,'0',STR_PAD_LEFT).";";
		while ((strlen($trama_actual)+strlen($sParametro)) < 48)
		{			
			if (strlen($sParametro)>0)
			{
				//echo $Parametro.'<br>';
				$trama_actual.=$sParametro;
				//echo $trama_actual.'<br>';
				$sParametro = strtok(";");
			}
			else
			{
				//echo 'YATA '.$NumTrama.'<br>';				
				break;
			}
		}
		$NumTrama++;
		//echo 'Longitud send='.(strlen($trama_actual)).'<br>';
		//echo $NumTrama.'- '.$trama_actual.'<br>';
		
		// Almacenamos trama de modificacion		
		$query = sprintf("INSERT INTO cliente_comandos (gw_id,nodo_ip,comandos_trama,comandos_fecha) VALUES ('%s','%s','%s',NOW());",  $gw_id, $nodo_ip, $trama_actual);
		//echo $query;
		$result = mysql_query($query,$link);
		if(!$result)
		{
			$xml_lectura = "ERROR";
			$sFin=1;
			//echo "ERROR ".mysql_error($link);
		}
		else if (strlen($sParametro)==0)
		{
			//echo 'Fin en '.$NumTrama.'<br>';
			$xml_lectura="OK";
			$sFin=1;
		}
	}
	mysql_close($link);
	echo $xml_lectura;	
?>
