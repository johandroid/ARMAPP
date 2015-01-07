<?php
	session_start();
	ini_set('memory_limit','200M');
	include 'inc/comunica.inc';
	include 'inc/datos_db.inc';
	include 'inc/funciones_medidas.inc';
	include 'inc/funciones_db.inc';
	
	$gw_id=$_GET['gw_id'];
	$direccion=$_GET['direccion'];
	$offline=$_GET['offline'];
		
	if ($offline == 0)
	{
		$respuesta = "<utcs><utc ";
	}
	else
	{
		$link = mysql_connect($db_host, $db_user, $db_pass);
		mysql_select_db($_SESSION['cliente_db'], $link);
	}
	
	//Lectura Alarma Alta ON/ Alarma Baja ON/ Delta (0,1,9) Set8U
	$sComando=sprintf("m%sD%02s:%02s030100000A",$gw_id,strtoupper($direccion),strtoupper($direccion));
	if ($offline == 0)
	{
		$sTramaLeida=conectar_reintentos($sComando,2);
		//echo $sTramaLeida."<br>";
		if ($sTramaLeida[0] != 'm' || $sTramaLeida[24] != '0' || $sTramaLeida[25] != '3')
		{
			//echo "alert('Trama incorrecta');";
			echo "ERROR ";
			return;
		}
		//echo substr($sTramaLeida,28,2)."<br>";
		//echo substr($sTramaLeida,30,2)."<br>";
		$alarma_alta_habilitado = hexdec(substr($sTramaLeida,28,2));
		$alarma_baja_habilitado = hexdec(substr($sTramaLeida,30,2));
		$delta = substr($sTramaLeida,46,2);
		$respuesta .= " alarma_alta_habilitado='".$alarma_alta_habilitado."' alarma_baja_habilitado='".$alarma_baja_habilitado."' delta='".$delta."'";
	}
	else 
	{
		$query = sprintf("INSERT INTO cliente_comandos (gw_id,nodo_ip,comandos_trama,comandos_fecha) VALUES ('%s','%s','%s',NOW());",  $gw_id, $direccion, $sComando);
		//echo $query;
		mysql_query($query,$link) or die(mysql_error());
	}	
	
	//Lectura Punto Bajo ON/ Tiempo Maximo ON (102,108) Set8U	
	$sComando=sprintf("m%sD%02s:%02s0301660007",$gw_id,strtoupper($direccion),strtoupper($direccion));
	if ($offline == 0)
	{
		sleep(2);
		$sTramaLeida=conectar_reintentos($sComando,2);
		//echo $sTramaLeida."<br>";
		if ($sTramaLeida[0] != 'm' || $sTramaLeida[24] != '0' || $sTramaLeida[25] != '3')
		{
			//echo "alert('Trama incorrecta');";
			echo "ERROR ";
			return;
		}
		//echo substr($sTramaLeida,28,2)."<br>";
		//echo substr($sTramaLeida,40,2)."<br>";
		$punto_bajo_habilitado = hexdec(substr($sTramaLeida,28,2));
		$tiempo_maximo_habilitado = hexdec(substr($sTramaLeida,40,2));
		$respuesta .= " punto_bajo_habilitado='".$punto_bajo_habilitado."' tiempo_maximo_habilitado='".$tiempo_maximo_habilitado."'";
	}
	else 
	{
		$query = sprintf("INSERT INTO cliente_comandos (gw_id,nodo_ip,comandos_trama,comandos_fecha) VALUES ('%s','%s','%s',NOW());",  $gw_id, $direccion, $sComando);
		//echo $query;
		mysql_query($query,$link) or die(mysql_error());
	}
	
	//Lectura Alarma Alta/ Alarma Baja (0,1) Set16	
	$sComando=sprintf("m%sD%02s:%02s0306000002",$gw_id,strtoupper($direccion),strtoupper($direccion));
	if ($offline == 0)
	{
		sleep(2);
		$sTramaLeida=conectar_reintentos($sComando,2);
		//echo $sTramaLeida."<br>";
		if ($sTramaLeida[0] != 'm' || $sTramaLeida[24] != '0' || $sTramaLeida[25] != '3')
		{
			//echo "alert('Trama incorrecta');";
			echo "ERROR ";
			return;
		}
		//echo substr($sTramaLeida,28,4)."<br>";
		//echo substr($sTramaLeida,32,4)."<br>";
		$alarma_alta = hexdec(substr($sTramaLeida,28,4));
		$alarma_baja = hexdec(substr($sTramaLeida,32,4));
		$respuesta .= " alarma_alta='".$alarma_alta."' alarma_baja='".$alarma_baja."'";
	}
	else 
	{
		$query = sprintf("INSERT INTO cliente_comandos (gw_id,nodo_ip,comandos_trama,comandos_fecha) VALUES ('%s','%s','%s',NOW());",  $gw_id, $direccion, $sComando);
		//echo $query;
		mysql_query($query,$link) or die(mysql_error());
	}
	
	//Lectura SetPoint/ Punto Bajo (16,25) Set16	
	$sComando=sprintf("m%sD%02s:%02s030610000A",$gw_id,strtoupper($direccion),strtoupper($direccion));
	if ($offline == 0)
	{
		sleep(2);
		$sTramaLeida=conectar_reintentos($sComando,2);
		//echo $sTramaLeida."<br>";
		if ($sTramaLeida[0] != 'm' || $sTramaLeida[24] != '0' || $sTramaLeida[25] != '3')
		{
			//echo "alert('Trama incorrecta');";
			echo "ERROR ";
			return;
		}
		//echo substr($sTramaLeida,28,4)."<br>";
		//echo substr($sTramaLeida,64,4)."<br>";
		$setpoint = hexdec(substr($sTramaLeida,28,4));
		$punto_bajo = hexdec(substr($sTramaLeida,64,4));
		$respuesta .= " setpoint='".$setpoint."' punto_bajo='".$punto_bajo."'";
		
	}
	else 
	{
		$query = sprintf("INSERT INTO cliente_comandos (gw_id,nodo_ip,comandos_trama,comandos_fecha) VALUES ('%s','%s','%s',NOW());",  $gw_id, $direccion, $sComando);
		//echo $query;
		mysql_query($query,$link) or die(mysql_error());
	}

	//Lectura Tiempo Medida (3) Set16U	
	$sComando=sprintf("m%sD%02s:%02s0304030001",$gw_id,strtoupper($direccion),strtoupper($direccion));
	if ($offline == 0)
	{
		sleep(2);
		$sTramaLeida=conectar_reintentos($sComando,2);
		//echo $sTramaLeida."<br>";
		if ($sTramaLeida[0] != 'm' || $sTramaLeida[24] != '0' || $sTramaLeida[25] != '3')
		{
			//echo "alert('Trama incorrecta');";
			echo "ERROR ";
			return;
		}
		//echo substr($sTramaLeida,28,4)."<br>";
		$tiempo_medida = hexdec(substr($sTramaLeida,28,4));
		$respuesta .= " tiempo_medida='".$tiempo_medida."'";
	}
	else 
	{
		$query = sprintf("INSERT INTO cliente_comandos (gw_id,nodo_ip,comandos_trama,comandos_fecha) VALUES ('%s','%s','%s',NOW());",  $gw_id, $direccion, $sComando);
		//echo $query;
		mysql_query($query,$link) or die(mysql_error());
	}
	
	//Lectura Tiempo Maximo (18) Set16U	
	$sComando=sprintf("m%sD%02s:%02s0304120001",$gw_id,strtoupper($direccion),strtoupper($direccion));
	if ($offline == 0)
	{
		sleep(2);
		$sTramaLeida=conectar_reintentos($sComando,2);
		//echo $sTramaLeida."<br>";
		if ($sTramaLeida[0] != 'm' || $sTramaLeida[24] != '0' || $sTramaLeida[25] != '3')
		{
			//echo "alert('Trama incorrecta');";
			echo "ERROR ";
			return;
		}
		//echo substr($sTramaLeida,28,4)."<br>";
		$tiempo_maximo = hexdec(substr($sTramaLeida,28,4));
		$respuesta .= " tiempo_maximo='".$tiempo_maximo."'";
		$respuesta .= "></utc></utcs>";
	}
	else 
	{
		$query = sprintf("INSERT INTO cliente_comandos (gw_id,nodo_ip,comandos_trama,comandos_fecha) VALUES ('%s','%s','%s',NOW());",  $gw_id, $direccion, $sComando);
		//echo $query;
		mysql_query($query,$link) or die(mysql_error());
		$respuesta = "OK";
		mysql_close($link);
	}
	echo $respuesta;
?>
