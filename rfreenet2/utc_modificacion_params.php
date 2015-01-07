<?php
	session_start();
	ini_set('memory_limit','200M');
	include 'inc/comunica.inc';
	include 'inc/datos_db.inc';
	include 'inc/funciones_medidas.inc';
	include 'inc/funciones_db.inc';
	include 'inc/idiomas.inc';
	
	$gw_id=$_GET['gw_id'];
	$direccion=$_GET['direccion'];
	$tiempo_medida=$_GET['tiempo_medida'];
	$setpoint=$_GET['setpoint'];
	$delta=$_GET['delta'];
	$lowpoint=$_GET['lowpoint'];
	$lowpoint_habilitado=$_GET['lowpoint_habilitado'];
	$max=$_GET['max'];
	$max_habilitado=$_GET['max_habilitado'];
	$alarma_alta_cloro=$_GET['alarma_alta_cloro'];
	$alarma_alta_cloro_habilitado=$_GET['alarma_alta_cloro_habilitado'];
	$alarma_baja_cloro=$_GET['alarma_baja_cloro'];
	$alarma_baja_cloro_habilitado=$_GET['alarma_baja_cloro_habilitado'];
	$password=$_GET['password'];
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
	
	$query_aux = "";
	$primero = 1;
	$sComandoPWD=sprintf("m%sD%02s:%02s101E00000101%04s",$gw_id,strtoupper($direccion),strtoupper($direccion),$password);
	
	if($alarma_alta_cloro_habilitado!="" && isset($_GET['alarma_alta_cloro_habilitado']))
	{
		//Modificacion Alarma Alta ON (0) Set8U
		$sComando=sprintf("m%sD%02s:%02s100100000101%02s",$gw_id,strtoupper($direccion),strtoupper($direccion),strtoupper(dechex($alarma_alta_cloro_habilitado)));		
		if ($offline == 0)
		{
			//Envio de pwd previo
			$sTramaLeida=conectar_reintentos($sComandoPWD,2);
			//echo $sTramaLeida."<br>";
			if ($sTramaLeida[0] != 'm'|| $sTramaLeida[30] != '1' || $sTramaLeida[31] != '0')
			{
				//echo "alert('Trama incorrecta');";
				echo "ERROR ";
				return;
			}
			sleep(2);			
			$sTramaLeida=conectar_reintentos($sComando,2);
			//echo $sTramaLeida."<br>";
			if ($sTramaLeida[0] != 'm' || $sTramaLeida[28] != '1' || $sTramaLeida[29] != '0')
			{
				//echo "alert('Trama incorrecta');";
				echo "ERROR ";
				if($sTramaLeida[30]=='0' && $sTramaLeida[31]=='4')
				{
					echo $idiomas[$_SESSION['opcion_idioma']]['error_password_login'];
				}
				return;
			}
		}
		else
		{
			$query = sprintf("INSERT INTO cliente_comandos (gw_id,nodo_ip,comandos_trama,comandos_fecha,comandos_trama_pw) VALUES ('%s','%s','%s',NOW(),'%s');",  $gw_id, $direccion, $sComando, $sComandoPWD);
			//echo $query;
			mysql_query($query,$link) or die(mysql_error());
		}
		if($primero != 1)
		{
			$query_aux .= ",";
		}
		$primero = 0;
		$query_aux .= " analizador_alarma_alta_cloro_habilitado='".$alarma_alta_cloro_habilitado."'";
	}
	if($alarma_baja_cloro_habilitado!="" && isset($_GET['alarma_baja_cloro_habilitado']))
	{
		//Modificacion Alarma Baja ON (1) Set8U
		$sComando=sprintf("m%sD%02s:%02s100101000101%02s",$gw_id,strtoupper($direccion),strtoupper($direccion),strtoupper(dechex($alarma_baja_cloro_habilitado)));
		if ($offline == 0)
		{
			sleep(2);
			//Envio de pwd previo
			$sTramaLeida=conectar_reintentos($sComandoPWD,2);
			//echo $sTramaLeida."<br>";
			if ($sTramaLeida[0] != 'm')
			{
				//echo "alert('Trama incorrecta');";
				echo "ERROR ";
				return;
			}
			sleep(2);			
			$sTramaLeida=conectar_reintentos($sComando,2);
			//echo $sTramaLeida."<br>";
			if ($sTramaLeida[0] != 'm'|| $sTramaLeida[28] != '1' || $sTramaLeida[29] != '0')
			{
				//echo "alert('Trama incorrecta');";
				echo "ERROR ";
				if($sTramaLeida[30]=='0' && $sTramaLeida[31]=='4')
				{
					echo $idiomas[$_SESSION['opcion_idioma']]['error_password_login'];
				}
				return;
			}
		}
		else
		{
			$query = sprintf("INSERT INTO cliente_comandos (gw_id,nodo_ip,comandos_trama,comandos_fecha,comandos_trama_pw) VALUES ('%s','%s','%s',NOW(),'%s');",  $gw_id, $direccion, $sComando, $sComandoPWD);
			//echo $query;
			mysql_query($query,$link) or die(mysql_error());
		}
		if($primero != 1)
		{
			$query_aux .= ",";
		}
		$primero = 0;
		$query_aux .= " analizador_alarma_baja_cloro_habilitado='".$alarma_baja_cloro_habilitado."'";
	}
	if($delta!="" && isset($_GET['delta']))
	{
		//Modificacion Delta (9) Set8U
		$sComando=sprintf("m%sD%02s:%02s100109000101%02s",$gw_id,strtoupper($direccion),strtoupper($direccion),strtoupper(dechex($delta)));
		if ($offline == 0)
		{
			sleep(2);
			//Envio de pwd previo
			$sTramaLeida=conectar_reintentos($sComandoPWD,2);
			//echo $sTramaLeida."<br>";
			if ($sTramaLeida[0] != 'm')
			{
				//echo "alert('Trama incorrecta');";
				echo "ERROR ";
				return;
			}
			sleep(2);			
			$sTramaLeida=conectar_reintentos($sComando,2);
			//echo $sTramaLeida."<br>";
			if ($sTramaLeida[0] != 'm'|| $sTramaLeida[28] != '1' || $sTramaLeida[29] != '0')
			{
				//echo "alert('Trama incorrecta');";
				echo "ERROR ";
				if($sTramaLeida[30]=='0' && $sTramaLeida[31]=='4')
				{
					echo $idiomas[$_SESSION['opcion_idioma']]['error_password_login'];
				}
				return;
			}
		}
		else
		{
			$query = sprintf("INSERT INTO cliente_comandos (gw_id,nodo_ip,comandos_trama,comandos_fecha,comandos_trama_pw) VALUES ('%s','%s','%s',NOW(),'%s');",  $gw_id, $direccion, $sComando, $sComandoPWD);
			//echo $query;
			mysql_query($query,$link) or die(mysql_error());
		}
		if($primero != 1)
		{
			$query_aux .= ",";
		}
		$primero = 0;
		$query_aux .= " analizador_delta='".$delta."'";
	}
	
	$respuesta .= " alarma_alta_habilitado='".$alarma_alta_cloro_habilitado."' alarma_baja_habilitado='".$alarma_baja_cloro_habilitado."' delta='".$delta."'";
	
	if($lowpoint_habilitado!="" && isset($_GET['lowpoint_habilitado']))
	{
		//Modificacion Punto Bajo ON (102) Set8U
		$sComando=sprintf("m%sD%02s:%02s100166000101%02s",$gw_id,strtoupper($direccion),strtoupper($direccion),strtoupper(dechex($lowpoint_habilitado)));
		if ($offline == 0)
		{
			sleep(2);
			//Envio de pwd previo
			$sTramaLeida=conectar_reintentos($sComandoPWD,2);
			//echo $sTramaLeida."<br>";
			if ($sTramaLeida[0] != 'm')
			{
				//echo "alert('Trama incorrecta');";
				echo "ERROR ";
				return;
			}
			sleep(2);			
			$sTramaLeida=conectar_reintentos($sComando,2);
			//echo $sTramaLeida."<br>";
			if ($sTramaLeida[0] != 'm'|| $sTramaLeida[28] != '1' || $sTramaLeida[29] != '0')
			{
				//echo "alert('Trama incorrecta');";
				echo "ERROR ";
				if($sTramaLeida[30]=='0' && $sTramaLeida[31]=='4')
				{
					echo $idiomas[$_SESSION['opcion_idioma']]['error_password_login'];
				}
				return;
			}
		}
		else
		{
			$query = sprintf("INSERT INTO cliente_comandos (gw_id,nodo_ip,comandos_trama,comandos_fecha,comandos_trama_pw) VALUES ('%s','%s','%s',NOW(),'%s');",  $gw_id, $direccion, $sComando, $sComandoPWD);
			//echo $query;
			mysql_query($query,$link) or die(mysql_error());
		}
		if($primero != 1)
		{
			$query_aux .= ",";
		}
		$primero = 0;
		$query_aux .= " analizador_lowpoint_habilitado='".$lowpoint_habilitado."'";
	}
	if($max_habilitado!="" && isset($_GET['max_habilitado']))
	{
		//Modificacion  Tiempo Maximo ON (108) Set8U
		$sComando=sprintf("m%sD%02s:%02s10016C000101%02s",$gw_id,strtoupper($direccion),strtoupper($direccion),strtoupper(dechex($max_habilitado)));
		if ($offline == 0)
		{
			sleep(2);
			//Envio de pwd previo
			$sTramaLeida=conectar_reintentos($sComandoPWD,2);
			//echo $sTramaLeida."<br>";
			if ($sTramaLeida[0] != 'm')
			{
				//echo "alert('Trama incorrecta');";
				echo "ERROR ";
				return;
			}
			sleep(2);
			$sTramaLeida=conectar_reintentos($sComando,2);
			//echo $sTramaLeida."<br>";
			if ($sTramaLeida[0] != 'm'|| $sTramaLeida[28] != '1' || $sTramaLeida[29] != '0')
			{
				//echo "alert('Trama incorrecta');";
				echo "ERROR ";
				if($sTramaLeida[30]=='0' && $sTramaLeida[31]=='4')
				{
					echo $idiomas[$_SESSION['opcion_idioma']]['error_password_login'];
				}
				return;
			}
		}
		else
		{
			$query = sprintf("INSERT INTO cliente_comandos (gw_id,nodo_ip,comandos_trama,comandos_fecha,comandos_trama_pw) VALUES ('%s','%s','%s',NOW(),'%s');",  $gw_id, $direccion, $sComando, $sComandoPWD);
			//echo $query;
			mysql_query($query,$link) or die(mysql_error());
		}
		if($primero != 1)
		{
			$query_aux .= ",";
		}
		$primero = 0;
		$query_aux .= " analizador_max_habilitado='".$max_habilitado."'";
	}
	$respuesta .= " punto_bajo_habilitado='".$lowpoint_habilitado."' tiempo_maximo_habilitado='".$max_habilitado."'";
	if($alarma_alta_cloro!="" && isset($_GET['alarma_alta_cloro']))
	{
		//Modificacion Alarma Alta (0) Set16
		$sComando=sprintf("m%sD%02s:%02s100600000102%04s",$gw_id,strtoupper($direccion),strtoupper($direccion),strtoupper(dechex($alarma_alta_cloro)));
		if ($offline == 0)
		{
			sleep(2);
			//Envio de pwd previo
			$sTramaLeida=conectar_reintentos($sComandoPWD,2);
			//echo $sTramaLeida."<br>";
			if ($sTramaLeida[0] != 'm')
			{
				//echo "alert('Trama incorrecta');";
				echo "ERROR ";
				return;
			}
			sleep(2);
			$sTramaLeida=conectar_reintentos($sComando,2);
			//echo $sTramaLeida."<br>";
			if ($sTramaLeida[0] != 'm'|| $sTramaLeida[30] != '1' || $sTramaLeida[31] != '0')
			{
				//echo "alert('Trama incorrecta');";
				echo "ERROR ";
				if($sTramaLeida[32]=='0' && $sTramaLeida[33]=='4')
				{
					echo $idiomas[$_SESSION['opcion_idioma']]['error_password_login'];
				}
				return;
			}
		}
		else
		{
			$query = sprintf("INSERT INTO cliente_comandos (gw_id,nodo_ip,comandos_trama,comandos_fecha,comandos_trama_pw) VALUES ('%s','%s','%s',NOW(),'%s');",  $gw_id, $direccion, $sComando, $sComandoPWD);
			//echo $query;
			mysql_query($query,$link) or die(mysql_error());
		}
		if($primero != 1)
		{
			$query_aux .= ",";
		}
		$primero = 0;
		$query_aux .= " analizador_alarma_alta_cloro='".$alarma_alta_cloro."'";
	}
	if($alarma_baja_cloro!="" && isset($_GET['alarma_baja_cloro']))
	{
		//Modificacion Alarma Baja (1) Set16
		$sComando=sprintf("m%sD%02s:%02s100601000102%04s",$gw_id,strtoupper($direccion),strtoupper($direccion),strtoupper(dechex($alarma_baja_cloro)));
		if ($offline == 0)
		{
			sleep(2);
			//Envio de pwd previo
			$sTramaLeida=conectar_reintentos($sComandoPWD,2);
			//echo $sTramaLeida."<br>";
			if ($sTramaLeida[0] != 'm')
			{
				//echo "alert('Trama incorrecta');";
				echo "ERROR ";
				return;
			}
			sleep(2);			
			$sTramaLeida=conectar_reintentos($sComando,2);
			//echo $sTramaLeida."<br>";
			if ($sTramaLeida[0] != 'm'|| $sTramaLeida[30] != '1' || $sTramaLeida[31] != '0')
			{
				//echo "alert('Trama incorrecta');";
				echo "ERROR ";
				if($sTramaLeida[32]=='0' && $sTramaLeida[33]=='4')
				{
					echo $idiomas[$_SESSION['opcion_idioma']]['error_password_login'];
				}
				return;
			}
		}
		else
		{
			$query = sprintf("INSERT INTO cliente_comandos (gw_id,nodo_ip,comandos_trama,comandos_fecha,comandos_trama_pw) VALUES ('%s','%s','%s',NOW(),'%s');",  $gw_id, $direccion, $sComando, $sComandoPWD);
			//echo $query;
			mysql_query($query,$link) or die(mysql_error());
		}
		if($primero != 1)
		{
			$query_aux .= ",";
		}
		$primero = 0;
		$query_aux .= " analizador_alarma_baja_cloro='".$alarma_baja_cloro."'";
	}
	$respuesta .= " alarma_alta='".$alarma_alta_cloro."' alarma_baja='".$alarma_baja_cloro."'";
	if($setpoint!="" && isset($_GET['setpoint']))
	{
		//Modificacion SetPoint (16) Set16
		$sComando=sprintf("m%sD%02s:%02s100610000102%04s",$gw_id,strtoupper($direccion),strtoupper($direccion),strtoupper(dechex($setpoint)));
		if ($offline == 0)
		{
			sleep(2);
			//Envio de pwd previo
			$sTramaLeida=conectar_reintentos($sComandoPWD,2);
			//echo $sTramaLeida."<br>";
			if ($sTramaLeida[0] != 'm')
			{
				//echo "alert('Trama incorrecta');";
				echo "ERROR ";
				return;
			}
			sleep(2);			
			$sTramaLeida=conectar_reintentos($sComando,2);
			//echo $sTramaLeida."<br>";
			if ($sTramaLeida[0] != 'm'|| $sTramaLeida[30] != '1' || $sTramaLeida[31] != '0')
			{
				//echo "alert('Trama incorrecta');";
				echo "ERROR ";
				if($sTramaLeida[32]=='0' && $sTramaLeida[33]=='4')
				{
					echo $idiomas[$_SESSION['opcion_idioma']]['error_password_login'];
				}
				return;
			}
		}
		else
		{
			$query = sprintf("INSERT INTO cliente_comandos (gw_id,nodo_ip,comandos_trama,comandos_fecha,comandos_trama_pw) VALUES ('%s','%s','%s',NOW(),'%s');",  $gw_id, $direccion, $sComando, $sComandoPWD);
			//echo $query;
			mysql_query($query,$link) or die(mysql_error());
		}
		if($primero != 1)
		{
			$query_aux .= ",";
		}
		$primero = 0;
		$query_aux .= " analizador_setpoint='".$setpoint."'";
	}
	if($lowpoint!="" && isset($_GET['lowpoint']))
	{
		//Modificacion Punto Bajo (25) Set16
		$sComando=sprintf("m%sD%02s:%02s100619000102%04s",$gw_id,strtoupper($direccion),strtoupper($direccion),strtoupper(dechex($lowpoint)));
		if ($offline == 0)
		{
			sleep(2);
			//Envio de pwd previo
			$sTramaLeida=conectar_reintentos($sComandoPWD,2);
			//echo $sTramaLeida."<br>";
			if ($sTramaLeida[0] != 'm')
			{
				//echo "alert('Trama incorrecta');";
				echo "ERROR ";
				return;
			}
			sleep(2);			
			$sTramaLeida=conectar_reintentos($sComando,2);
			//echo $sTramaLeida."<br>";
			if ($sTramaLeida[0] != 'm'|| $sTramaLeida[30] != '1' || $sTramaLeida[31] != '0')
			{
				//echo "alert('Trama incorrecta');";
				echo "ERROR ";
				if($sTramaLeida[32]=='0' && $sTramaLeida[33]=='4')
				{
					echo $idiomas[$_SESSION['opcion_idioma']]['error_password_login'];
				}
				return;
			}
		}
		else
		{
			$query = sprintf("INSERT INTO cliente_comandos (gw_id,nodo_ip,comandos_trama,comandos_fecha,comandos_trama_pw) VALUES ('%s','%s','%s',NOW(),'%s');",  $gw_id, $direccion, $sComando, $sComandoPWD);
			//echo $query;
			mysql_query($query,$link) or die(mysql_error());
		}
		if($primero != 1)
		{
			$query_aux .= ",";
		}
		$primero = 0;
		$query_aux .= " analizador_lowpoint='".$lowpoint."'";
	}
	$respuesta .= " setpoint='".$setpoint."' punto_bajo='".$lowpoint."'";
	if($tiempo_medida!="" && isset($_GET['tiempo_medida']))
	{
		//Modificacion Tiempo Medida (3) Set16U
		$sComando=sprintf("m%sD%02s:%02s100403000102%04s",$gw_id,strtoupper($direccion),strtoupper($direccion),strtoupper(dechex($tiempo_medida)));
		if ($offline == 0)
		{
			sleep(2);
			//Envio de pwd previo
			$sTramaLeida=conectar_reintentos($sComandoPWD,2);
			//echo $sTramaLeida."<br>";
			if ($sTramaLeida[0] != 'm')
			{
				//echo "alert('Trama incorrecta');";
				echo "ERROR ";
				return;
			}
			sleep(2);			
			$sTramaLeida=conectar_reintentos($sComando,2);
			//echo $sTramaLeida."<br>";
			if ($sTramaLeida[0] != 'm'|| $sTramaLeida[30] != '1' || $sTramaLeida[31] != '0')
			{
				//echo "alert('Trama incorrecta');";
				echo "ERROR ";
				if($sTramaLeida[32]=='0' && $sTramaLeida[33]=='4')
				{
					echo $idiomas[$_SESSION['opcion_idioma']]['error_password_login'];
				}
				return;
			}			
		}
		else
		{
			$query = sprintf("INSERT INTO cliente_comandos (gw_id,nodo_ip,comandos_trama,comandos_fecha,comandos_trama_pw) VALUES ('%s','%s','%s',NOW(),'%s');",  $gw_id, $direccion, $sComando, $sComandoPWD);
			//echo $query;
			mysql_query($query,$link) or die(mysql_error());
		}
		if($primero != 1)
		{
			$query_aux .= ",";
		}
		$primero = 0;
		$query_aux .= " analizador_tiempo_medida='".$tiempo_medida."'";
	}
	
	$respuesta .= " tiempo_medida='".$tiempo_medida."'";
	
	if($max!="" && isset($_GET['max']))
	{
		//Modificacion Tiempo Maximo (18) Set16U
		$sComando=sprintf("m%sD%02s:%02s100412000102%04s",$gw_id,strtoupper($direccion),strtoupper($direccion),strtoupper(dechex($max)));
		if ($offline == 0)
		{
			sleep(2);
			//Envio de pwd previo
			$sTramaLeida=conectar_reintentos($sComandoPWD,2);
			//echo $sTramaLeida."<br>";
			if ($sTramaLeida[0] != 'm')
			{
				//echo "alert('Trama incorrecta');";
				echo "ERROR ";
				return;
			}
			sleep(2);			
			$sTramaLeida=conectar_reintentos($sComando,2);
			//echo $sTramaLeida."<br>";
			if ($sTramaLeida[0] != 'm'|| $sTramaLeida[30] != '1' || $sTramaLeida[31] != '0')
			{
				//echo "alert('Trama incorrecta');";
				echo "ERROR ";
				if($sTramaLeida[32]=='0' && $sTramaLeida[33]=='4')
				{
					echo $idiomas[$_SESSION['opcion_idioma']]['error_password_login'];
				}
				return;
			}
		}
		else
		{
			$query = sprintf("INSERT INTO cliente_comandos (gw_id,nodo_ip,comandos_trama,comandos_fecha,comandos_trama_pw) VALUES ('%s','%s','%s',NOW(),'%s');",  $gw_id, $direccion, $sComando, $sComandoPWD);
			//echo $query;
			mysql_query($query,$link) or die(mysql_error());
		}
		if($primero != 1)
		{
			$query_aux .= ",";
		}
		$primero = 0;
		$query_aux .= " analizador_max='".$max."'";
	}
	
	$respuesta .= " tiempo_maximo='".$max."'";
	
	if ($offline == 0)
	{
		$respuesta .= "></utc></utcs>";
	}
	else 
	{
		$respuesta .= "OK";
	}
	
	if($primero != 1)
	{
		$query_aux .= ",";
	}
	$primero = 0;
	$query_aux .= " analizador_pwd='".$password."'";
	
	if($query_aux!="")
	{
		$link = mysql_connect($db_host, $db_user, $db_pass);
		mysql_select_db($_SESSION['cliente_db'], $link);
		$query = sprintf("UPDATE %s SET %s where analizador_direccion='%s' and gw_id='%s'", $tabla_name_utcs,$query_aux,$direccion,$gw_id);
		//echo $query;
		$result = mysql_query($query,$link);
		
		if(!$result)
		{
			echo "ERROR ".$query;
			mysql_close($link);
			return;
		}
		mysql_close($link);
	}
	echo $respuesta;

?>
