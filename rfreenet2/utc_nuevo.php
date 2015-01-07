<?php
	session_start();
	ini_set('memory_limit','200M');
	include 'inc/datos_db.inc';
	include 'inc/funciones_db.inc';
	include 'inc/funciones_indice.inc';
	include 'inc/comunica.inc';
	include 'inc/idiomas.inc';
	
	$sInstalacionActual=$_POST['instalacion_id'];
	$nombre=$_POST['nombre'];
	$magnitudes=$_POST['magnitudes'];
	$magnitudesSMS=$_POST['magnitudesSMS'];
	$magnitudesEMAIL=$_POST['magnitudesEMAIL'];
	$gw_id=$_POST['gw_id'];
	$direccion=str_pad($_POST['direccion'], 2, '0', STR_PAD_LEFT);
	$tipo_utc=$_POST['tipo_utc'];
	$db_client=$_POST['cliente_db'];
	$reposicion=$_POST['HMR'];
	$offline=$_POST['offline'];
		
	$link = mysql_connect($db_host, $db_user, $db_pass);
	
	mysql_select_db($db_client, $link);

	$query = sprintf("SELECT analizador_id FROM %s WHERE gw_id='%s' AND analizador_direccion=LPAD('%s',2,'0');", $tabla_name_utcs, $gw_id, $direccion);
	//echo $query;
	$result = mysql_query($query,$link);
	if($result)
	{
		if(mysql_num_rows($result)>0)
		{
			echo "ERROR: ".$idiomas[$_SESSION['opcion_idioma']]['general305'];
			mysql_free_result($result);
			mysql_close($link);
			return;
		}
	}
	mysql_free_result($result);
	
	mysql_select_db($db_name_general, $link);
	$query = sprintf("SELECT modbus_direccion_inicio,modbus_num_registros,modbus_tipo FROM %s WHERE modbus_id='%s';", $tabla_name_modbus, $tipo_utc);
	$result = mysql_query($query,$link);
	if(!$result)
	{
		echo "ERROR";
	}
	else
	{
		if($row = mysql_fetch_array($result))
		{
			$modbus_tipo = $row['modbus_tipo'];
			$num_vueltas = ceil($row[1]/14);
			$resto = fmod($row[1],14);
			$inicio = hexdec($row[0]);
			
			mysql_free_result($result);
			
			mysql_select_db($db_client, $link);
			
			$vector_error ="";
			$vector_alarm ="";
			$vector_warning ="";
			if($modbus_tipo == '0')
			{
				$num_vueltas = ceil($row[1]/14);
				$resto = fmod($row[1],14);
				$inicio = hexdec($row[0]);
				for($i=0;$i<($num_vueltas);$i++)
				{
					//echo $i." vs ".($num_vueltas)."<br>";
					if($i==($num_vueltas-1))
					{
						$sComando=sprintf("c%sN%02s%04s%04s%02s",$gw_id,strtoupper($direccion),strtoupper(dechex($inicio)),strtoupper(dechex(2*$resto)),strtoupper(dechex(14*$i)));
					}
					else
					{
						$sComando=sprintf("c%sN%02s%04s%04s%02s",$gw_id,strtoupper($direccion),strtoupper(dechex($inicio)),strtoupper(dechex(28)),strtoupper(dechex(14*$i)));
					}
					$inicio += 28;
					//echo $sComando.'<br>';

					if ($offline == 0)
					{
						$sTramaLeida=conectar_reintentos($sComando,2);
						//echo $sTramaLeida."<br>";
						if ($sTramaLeida[0] != 'c')
						{
							//echo "alert('Trama incorrecta');";
							echo "ERROR ";
							return;
						}
					}
					else
					{
						$query = sprintf("INSERT INTO cliente_comandos (gw_id,nodo_ip,comandos_trama,comandos_fecha) VALUES ('%s','%s','%s',NOW());",  $gw_id, $direccion, $sComando);
						//echo $query;
						mysql_query($query,$link) or die(mysql_error());
					}
				}
			}
			else if($modbus_tipo == '1')
			{
				$sComando=sprintf("c%sN%02s160B0004F0",$gw_id,strtoupper($direccion));
				
				if ($offline == 0)
				{
					$sTramaLeida=conectar_reintentos($sComando,2);
					//echo $sTramaLeida."<br>";
					if ($sTramaLeida[0] != 'c')
					{
						//echo "alert('Trama incorrecta');";
						echo "ERROR ";
						return;
					}
				}
				else
				{
					$query = sprintf("INSERT INTO cliente_comandos (gw_id,nodo_ip,comandos_trama,comandos_fecha) VALUES ('%s','%s','%s',NOW());",  $gw_id, $direccion, $sComando);
					//echo $query;
					mysql_query($query,$link) or die(mysql_error());
				}
				
				$sComando=sprintf("c%sN%02s14060003F4",$gw_id,strtoupper($direccion));
				if ($offline == 0)
				{
					$sTramaLeida=conectar_reintentos($sComando,2);
					//echo $sTramaLeida."<br>";
					if ($sTramaLeida[0] != 'c')
					{
						//echo "alert('Trama incorrecta');";
						echo "ERROR ";
						return;
					}
				}
				else
				{
					$query = sprintf("INSERT INTO cliente_comandos (gw_id,nodo_ip,comandos_trama,comandos_fecha) VALUES ('%s','%s','%s',NOW());",  $gw_id, $direccion, $sComando);
					//echo $query;
					mysql_query($query,$link) or die(mysql_error());
				}
				
				$vector_error ="0000000";
				$vector_alarm ="00000000";
				$vector_warning ="0000000000000000";
			}
			mysql_free_result($result);
			mysql_close($link);
			// Marcamos latitud y longitud segun el sistema este en modo offline o no
			if (iObtenerModoOffline() == 0)
			{
				$latitud_utc_aux = 0;
				$longitud_utc_aux = 0;
			}
			else
			{
				$latitud_utc_aux = 1;
				$longitud_utc_aux = 1;
			}
			
			$link = mysql_connect($db_host, $db_user, $db_pass);


			mysql_select_db($db_client, $link);
			
			// lo insertamos en la tabla de gateways del cliente			
			$query = sprintf("INSERT INTO %s (gw_id,instalacion_id,analizador_nombre,analizador_direccion,analizador_tipo,analizador_vector_magnitudes,analizador_latitud,analizador_longitud,analizador_vector_errores,analizador_vector_alarmas,analizador_vector_warnings,analizador_vector_magnitudes_SMS,analizador_vector_magnitudes_EMAIL,analizador_reposicion) VALUES('%s','%s','%s',LPAD('%s',2,'0'),'%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')",$tabla_name_utcs,$gw_id,$sInstalacionActual,$nombre, strtoupper($direccion), $tipo_utc, $magnitudes, $latitud_utc_aux, $longitud_utc_aux, $vector_error, $vector_alarm, $vector_warning, $magnitudesSMS, $magnitudesEMAIL, $reposicion);
			//echo $query;
			$result = mysql_query($query,$link);
			if(!$result)
			{
				echo "ERROR ".$idiomas[$_SESSION['opcion_idioma']]['general305'];
			}
			echo mysql_insert_id($link);
		}
		else
		{
			echo "ERROR ";
		}
	}
	mysql_close($link);
?>
