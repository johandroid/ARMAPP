<?php
session_start();
function sObtener_Nombre_Instalación($instalacion_id, $cliente_db)
{ 
	include 'inc/idiomas.inc';
	include 'inc/datos_db.inc';

	$sResultado = "";

	$mysql = mysql_connect($db_host, $db_user, $db_pass);
	if(!$mysql)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_acceso_db'];?>"); </script><?
		return 'ERROR 1';
	}

	//seleccionar la base de datos
	$selected = mysql_select_db($cliente_db,$mysql);
	if(!$selected)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_select_db'];?>"); </script><?
		mysql_close($mysql);
		return 'ERROR 2';
	}

	$query = "SELECT instalacion_nombre FROM cliente_instalaciones WHERE instalacion_id='$instalacion_id'";
	$result = mysql_query($query,$mysql);
	if(!$result)
	{
		mysql_close($mysql);
		return 'ERROR 3';
		//return $query;
	}
	else
	{		
		$result_array = mysql_fetch_array($result);
		
		$sResultado = $result_array[0];
		mysql_free_result($result);
		mysql_close($mysql);
	}
	return $sResultado;
}

function generarPassword($length = 12)
{
  // start with a blank password
  $password = "";

  // define possible characters
  $possible = "0123456789abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"; 
    
  // set up a counter
  $i = 0; 
    
  // add random characters to $password until $length is reached
  while ($i < $length) { 

    // pick a random character from the possible ones
    $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
        
    // we don't want this character if it's already in the password
    if (!strstr($password, $char)) { 
      $password .= $char;
      $i++;
    }

  }

  return $password;
}

// Busca el siguiente suscriptor libre en db para asignar a nuevo gateway
function sObtener_Nuevo_Suscriptor()
{
	include 'inc/idiomas.inc';
	include 'inc/datos_db.inc';

	$sResultado = "";

	$mysql = mysql_connect($db_host, $db_user, $db_pass);
	if(!$mysql)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_acceso_db'];?>"); </script><?
		return 'ERROR';
	}

	//seleccionar la base de datos
	$selected = mysql_select_db($db_name_clientes,$mysql);
	if(!$selected)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_select_db'];?>"); </script><?
		mysql_close($mysql);
		return 'ERROR';
	}

	$query = "SELECT gw_id FROM clientes_suscriptores order by (conv(gw_id,16,10)-0)";
	//echo $query.'<br>';
	$result = mysql_query($query,$mysql);
	if(!$result)
	{
		$sResultado="ERROR";
		//return $query;
	}
	else
	{	
		/**/
		$iSUSAux = 0001;
		$sSUSAux=sprintf("%04X", $iSUSAux);
		$result_array = mysql_fetch_array($result);	
	
		while ($sSUSAux < 'FFFF')
		{
			if ($result_array)
			{
				$sSUSLeido = $result_array[0];
				$iSUSLeido=hexdec($sSUSLeido);
				//echo 'Cotejando SUS '.$sSUSLeido.' con '.$sSUSAux.'<br>';
				
				if ($iSUSLeido == $iSUSAux)
				{
					//echo '   SUS '.$sSUSAux.' ocupado<br>';
					
					if ($sSUSAux == 'FFFF')
					{
						$sResultado="ERROR";
						break;		
					}
					else
					{
						$iSUSAux++;
						$sSUSAux=sprintf("%04X", $iSUSAux);
					}
				}
				else if ($iSUSAux < $iSUSLeido)
				{
					$sResultado = $sSUSAux;
					//echo '   SUS '.$sSUSAux.' ASIGNADO<br>'; 
					break;
				}
				else
				{
					$sResultado = $sSUSAux;
					$result_array = mysql_fetch_array($result);
					if ($result_array)
					{
						//echo '   SUS '.$sResultado.' SUPERIOR A CUENTA<br>';
					}
					else
					{
						//echo '   SUS '.$sResultado.' ASIGNADA POR SALTO<br>';
						break;
					}				
				}
			}
			else
			{
				//echo '   SUS '.$sResultado.' ASIGNADA POR SALTO<br>';
				$sResultado = $sSUSAux;
				break;
			}
		}
		
		if ($sSUSAux == 'FFFF')
		{
			$sResultado="ERROR";
		}
		
		mysql_free_result($result);
	}
	
	mysql_close($mysql);
	
	return $sResultado;
}

// Busca el siguiente id de instalacion libre en db para asignar en un cliente
function sObtener_Nuevo_ID_Instalacion($sNombreDBCliente)
{
	include 'inc/idiomas.inc';
	include 'inc/datos_db.inc';

	$sResultado = "";

	$mysql = mysql_connect($db_host, $db_user, $db_pass);
	if(!$mysql)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_acceso_db'];?>"); </script><?
		return 'ERROR';
	}

	//seleccionar la base de datos
	$selected = mysql_select_db($sNombreDBCliente,$mysql);
	if(!$selected)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_select_db'];?>"); </script><?
		mysql_close($mysql);
		return 'ERROR';
	}

	$query = "SELECT instalacion_id FROM cliente_instalaciones order by (conv(instalacion_id,16,10)-0)";
	//echo $query.'<br>';
	$result = mysql_query($query,$mysql);
	if(!$result)
	{
		$sResultado="ERROR";
		//return $query;
	}
	else
	{	
		$iIDAux = 0001;
		$sIDAux=sprintf("%04X", $iIDAux);
		//echo '<br>Probando '. $sIDAux.'<br>';
		$result_array = mysql_fetch_array($result);	

		while ($sIDAux < 'FFFF')
		{
			//echo '1<br>';
			if ($result_array)
			{
				$sIDLeido = $result_array[0];
				$iIDLeido=hexdec($sIDLeido);
				//echo 'Cotejando ID '.$sIDLeido.' con '.$sIDAux.'<br>';
				
				if ($iIDLeido == $iIDAux)
				{
					//echo '   ID '.$sIDAux.' ocupado<br>';
					
					if ($sIDAux == 'FFFF')
					{
						$sResultado="ERROR";
						break;		
					}
					else
					{
						$iIDAux++;
						$sIDAux=sprintf("%04X", $iIDAux);
					}
				}
				else if ($iIDAux < $iIDLeido)
				{
					$sResultado = $sIDAux;
					//echo '   ID '.$sIDAux.' ASIGNADO<br>'; 
					break;
				}
				else
				{
					$sResultado = $sIDAux;
					$result_array = mysql_fetch_array($result);
					if ($result_array)
					{
						//echo '   ID '.$sResultado.' SUPERIOR A CUENTA<br>';
					}
					else
					{
						//echo '   ID '.$sResultado.' ASIGNADA POR SALTO<br>';
						break;
					}				
				}
			}
			else
			{
				//echo '   ID '.$sResultado.' ASIGNADA POR SALTO<br>';
				$sResultado = $sIDAux;
				break;
			}
			//echo '3<br>';
		}
		
		if ($sIDAux == 'FFFF')
		{
			$sResultado="ERROR";
		}
		
		mysql_free_result($result);
	}
	
	mysql_close($mysql);
	
	return $sResultado;
}

// Busca el siguiente id de instalacion libre en db para asignar en un cliente
function sObtener_Nuevo_ID_Cliente()
{ 
	include 'inc/idiomas.inc';
	include 'inc/datos_db.inc';

	$sResultado = "";

	$mysql = mysql_connect($db_host, $db_user, $db_pass);
	if(!$mysql)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_acceso_db'];?>"); </script><?
		return 'ERROR';
	}

	//seleccionar la base de datos
	$selected = mysql_select_db($db_name_clientes,$mysql);
	if(!$selected)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_select_db'];?>"); </script><?
		mysql_close($mysql);
		return 'ERROR';
	}

	$query = "SELECT cliente_id FROM clientes_datos order by (conv(cliente_id,16,10)-0)";
	//echo $query.'<br>';
	$result = mysql_query($query,$mysql);
	if(!$result)
	{
		$sResultado="ERROR";
		//return $query;
	}
	else
	{	
		/**/
		$iIDAux = 0001;
		$sIDAux=sprintf("%04X", $iIDAux);
		//echo '<br>Probando '. $sIDAux.'<br>';
		$result_array = mysql_fetch_array($result);	

		while ($sIDAux < 'FFFF')
		{
			//echo '1<br>';
			if ($result_array)
			{
				$sIDLeido = $result_array[0];
				$iIDLeido=hexdec($sIDLeido);
				//echo 'Cotejando ID '.$sIDLeido.' con '.$sIDAux.'<br>';
				
				if ($iIDLeido == $iIDAux)
				{
					//echo '   ID '.$sIDAux.' ocupado<br>';
					
					if ($sIDAux == 'FFFF')
					{
						$sResultado="ERROR";
						break;		
					}
					else
					{
						$iIDAux++;
						$sIDAux=sprintf("%04X", $iIDAux);
					}
				}
				else if ($iIDAux < $iIDLeido)
				{
					$sResultado = $sIDAux;
					//echo '   ID '.$sIDAux.' ASIGNADO<br>'; 
					break;
				}
				else
				{
					$sResultado = $sIDAux;
					$result_array = mysql_fetch_array($result);
					if ($result_array)
					{
						//echo '   ID '.$sResultado.' SUPERIOR A CUENTA<br>';
					}
					else
					{
						//echo '   ID '.$sResultado.' ASIGNADA POR SALTO<br>';
						break;
					}				
				}
			}
			else
			{
				$sResultado = $sIDAux;
				//echo '   ID '.$sResultado.' SUPERIOR A CUENTA<br>';
				//echo '2<br>';
				break;
			}
			//echo '3<br>';
		}
		
		if ($sIDAux == 'FFFF')
		{
			$sResultado="ERROR";
		}
		
		mysql_free_result($result);
	}
	
	mysql_close($mysql);
	
	return $sResultado;
}

function sObtener_Nombre_Cliente($cliente_id_check)
{ 
	include 'inc/idiomas.inc';
	include 'inc/datos_db.inc';

	$sResultado = "";

	$mysql = mysql_connect($db_host, $db_user, $db_pass);
	if(!$mysql)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_acceso_db'];?>"); </script><?
		return 'ERROR 1';
	}

	//seleccionar la base de datos
	$selected = mysql_select_db($db_name_clientes,$mysql);
	if(!$selected)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_select_db'];?>"); </script><?
		mysql_close($mysql);
		return 'ERROR 2';
	}

	$query = "SELECT cliente_nombre FROM clientes_datos WHERE cliente_id='$cliente_id_check'";
	$result = mysql_query($query,$mysql);
	if(!$result)
	{
		mysql_close($mysql);
		return 'ERROR 3';
		//return $query;
	}
	else
	{		
		$result_array = mysql_fetch_array($result);
		
		$sResultado = $result_array[0];
		mysql_free_result($result);
		mysql_close($mysql);
	}
	return $sResultado;
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
 * AMB 21/03/2012
 * 
 * Nombre: iObtenerTipoGW
 * Descripción: Obtener tipo de GW 
 * 
 * Variables de entrada: Id del GW
 * 
 * Retorno: Tipo de Gw
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function iObtenerTipoGW($gw_id, $cliente_db)
{	
	include 'inc/datos_db.inc';
	$link_tipo = mysqli_connect($db_host, $db_user, $db_pass);
		
	mysqli_select_db($link_tipo, $cliente_db );
	
	$query_tipo = sprintf("SELECT gw_tipo FROM cliente_gateways where gw_id='%s';", $gw_id);

	$result_tipo = mysqli_query($link_tipo, $query_tipo);

	$row = mysqli_fetch_array($result_tipo);

	$gw_tipo = $row['gw_tipo'];	

	mysqli_free_result($result_tipo);
	mysqli_close($link_tipo);	
	
	return $gw_tipo;
}

function sObtener_Versiones_GW($gw_id, $cliente_db)
{
	include 'inc/idiomas.inc';
	include 'inc/datos_db.inc';

	$sResultado = "";

	$mysql = mysql_connect($db_host, $db_user, $db_pass);
	if(!$mysql)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_acceso_db'];?>"); </script><?
		return 'ERROR 1';
	}

	//seleccionar la base de datos
	$selected = mysql_select_db($cliente_db,$mysql);
	if(!$selected)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_select_db'];?>"); </script><?
		mysql_close($mysql);
		return 'ERROR 2';
	}

	$query = "SELECT gw_versionHW,gw_versionSW FROM cliente_params_gw WHERE gw_id='$gw_id'";
	$result = mysql_query($query,$mysql);
	if(!$result)
	{
		mysql_close($mysql);
		return 'ERROR 3';
		//return $query;
	}
	else
	{		
		$result_array = mysql_fetch_array($result);
		mysql_free_result($result);
		mysql_close($mysql);
		return array($result_array[0],$result_array[1]);
	}
	return $sResultado;
}

function iComprobar_Hab_Params_GW_Version($gw_id, $cliente_db)
{
	include 'inc/datos_db.inc';
	$array_versiones = sObtener_Versiones_GW($gw_id, $cliente_db);
	if (strpos($array_versiones, "ERROR") == FALSE)
	{
		if ($array_versiones[1] < $version_sw_utc)
		{
			$iResultadoMTP = 0;
		}
		else 
		{
			$iResultadoMTP = 1;
			if ($array_versiones[0] < $version_hw_utc)
			{
				$iResultadoITP = 0;
			}
			else
			{
				$iResultadoITP = 1;
			}
		}
	}
	else
	{
		$iResultadoITP = 0;
		$iResultadoMTP = 0;
	}
	return array($iResultadoITP,$iResultadoMTP);
}

function sObtener_Fecha($cliente_db, $instalacion_id, $fecha_unix,$zona_horaria)
{
	
	$timezone_server = date_default_timezone_get();
	date_default_timezone_set($zona_horaria);
	$fecha = strftime ("%Y-%m-%d %H:%M:%S",$fecha_unix);
	date_default_timezone_set($timezone_server);
	return $fecha;
	
}

function sObtener_Fecha_Desde_String($cliente_db, $instalacion_id, $fecha_string, $zona_horaria)
{
		
	$timezone_server = date_default_timezone_get();
	$fecha_formateada = date_create_from_format('Y-m-d H:i:s',$fecha_string,timezone_open($timezone_server));
	//echo date_format($fecha_formateada, 'Y-m-d H:i:sP');
	
	//echo $timezone_server;
	//echo $zona_horaria;
	date_timezone_set($fecha_formateada,timezone_open($zona_horaria));
	//echo date_format($fecha_formateada, 'Y-m-d H:i:s');
	return date_format($fecha_formateada, 'Y-m-d H:i:s');

}

function sObtener_Fecha_Inversa($cliente_db, $instalacion_id, $fecha_string,$zona_horaria)
{
	
	$fecha_formateada = date_create_from_format('Y-m-d H:i:s',$fecha_string,timezone_open($zona_horaria));
	$timezone_server = date_default_timezone_get();
	//echo $timezone_server;
	date_timezone_set($fecha_formateada,timezone_open($timezone_server));
	return date_format($fecha_formateada, 'Y-m-d H:i:s');
	
}

function sObtener_TimeStamp($cliente_db, $instalacion_id, $fecha_unix, $zona_horaria)
{
	$fecha = date_create();
	//Pasamos la fecha de el timezone del servidor al de la instalacion
	//echo $zona_horaria."<br>";
 	date_timestamp_set ($fecha, $fecha_unix);
	//echo date_format($fecha, 'U = Y-m-d H:i:s') . "<br>";
	$timezone_server = date_default_timezone_get();
	//date_default_timezone_set($result_array[0]);
	//$fecha = strftime ("%Y-%m-%d %H:%M:%S",$fecha_unix);
	date_timezone_set($fecha,timezone_open($zona_horaria));
	//echo date_format($fecha, 'U = Y-m-d H:i:s') . "<br>";
	//Ahora se pasara la fecha a la zona horaria GMT para las gráficas
	$fecha_formateada = date_create_from_format('Y-m-d H:i:s',date_format($fecha, 'Y-m-d H:i:s'),timezone_open('UTC'));
	//echo date_format($fecha_formateada, 'U = Y-m-d H:i:s') . "<br>";
	//echo date_timestamp_get($fecha_formateada);
	return date_timestamp_get($fecha_formateada);
	
}

function sObtener_TimeZone_Instalacion($cliente_db, $instalacion_id)
{
	include 'inc/idiomas.inc';
	include 'inc/datos_db.inc';


	$mysql_connect = mysql_connect($db_host, $db_user, $db_pass);
	if(!$mysql_connect)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_acceso_db'];?>"); </script><?
		return 'ERROR 1';
	}

	//seleccionar la base de datos
	$selected = mysql_select_db($cliente_db,$mysql_connect);
	if(!$selected)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_select_db'];?>"); </script><?
		mysql_close($mysql_connect);
		return 'ERROR 2';
	}

	$query = "SELECT instalacion_zona_horaria FROM cliente_instalaciones WHERE instalacion_id='$instalacion_id'";
	//echo $query."<br>";
	$resultado = mysql_query($query,$mysql_connect);
	if(!$resultado)
	{
		mysql_close($mysql_connect);
		return 'ERROR 3';
		//return $query;
	}
	else
	{		
		$result_array = mysql_fetch_array($resultado);
		//echo $result_array[0]."<br>";
		mysql_free_result($resultado);
		mysql_close($mysql_connect);
		//return $result_array[0]."<br>";
		return $result_array[0];
	}
	
}

?>