<?php
	session_start();
	ini_set('memory_limit','200M');

	include 'inc/datos_db.inc';
	include 'inc/funciones_db.inc';
	include 'inc/funciones_indice.inc';
	
	$sID=$_POST['id_disp'];
	$sInstalacionActual=$_POST['instalacion_id'];
	$nombre=$_POST['nombre'];
	$magnitudes=$_POST['magnitudes'];
	$magnitudesSMS=$_POST['magnitudesSMS'];
	$magnitudesEMAIL=$_POST['magnitudesEMAIL'];
	$gw_id=$_POST['gw_id'];
	$reposicion=$_POST['HMR'];
	$direccion=$_POST['direccion'];
	$tipo_utc=$_POST['tipo_utc'];
	$db_client=$_POST['cliente_db'];
	$offline=$_POST['offline'];
	
	
	$link = mysql_connect($db_host, $db_user, $db_pass);
	mysql_select_db($db_name_general, $link);
	$query = sprintf("SELECT modbus_direccion_inicio,modbus_num_registros FROM %s WHERE modbus_id='%s';", $tabla_name_modbus, $tipo_utc);
	$result = mysql_query($query,$link);
	if(!$result)
	{
		echo "ERROR";
		//echo $query;
	}
	else
	{
		if($row = mysql_fetch_array($result))
		{
			
			// lo insertamos en la tabla de gateways del cliente
			mysql_select_db($_SESSION['cliente_db'], $link);
					
			if($tipo_utc!='3')
			{
				$query = sprintf("UPDATE %s SET `gw_id`='%s', `analizador_nombre`='%s', `analizador_direccion`=LPAD('%s',2,'0'),`analizador_tipo`='%s', `analizador_vector_magnitudes`='%s', `analizador_vector_magnitudes_SMS`='%s', `analizador_vector_magnitudes_EMAIL`='%s',`analizador_reposicion`='%s' where analizador_id='%s'",$tabla_name_utcs,$gw_id,$nombre, $direccion, $tipo_utc, $magnitudes, $magnitudesSMS, $magnitudesEMAIL, $reposicion, $sID);
			}
			else 
			{
				$tiempo_medida=$_POST['tiempo_medida'];
				$setpoint=$_POST['setpoint'];
				$delta=$_POST['delta'];
				$lowpoint=$_POST['lowpoint'];
				$lowpoint_habilitado=$_POST['lowpoint_habilitado'];
				$max=$_POST['max'];
				$max_habilitado=$_POST['max_habilitado'];
				$alarma_alta_cloro=$_POST['alarma_alta_cloro'];
				$alarma_alta_cloro_habilitado=$_POST['alarma_alta_cloro_habilitado'];
				$alarma_baja_cloro=$_POST['alarma_baja_cloro'];
				$alarma_baja_cloro_habilitado=$_POST['alarma_baja_cloro_habilitado'];
				$password=$_POST['password'];
				$query = sprintf("UPDATE %s SET `gw_id`='%s', `analizador_nombre`='%s', `analizador_direccion`=LPAD('%s',2,'0'),`analizador_tipo`='%s', `analizador_vector_magnitudes`='%s', `analizador_vector_magnitudes_SMS`='%s', `analizador_vector_magnitudes_EMAIL`='%s',`analizador_reposicion`='%s',analizador_tiempo_medida='%s',analizador_setpoint='%s',analizador_delta='%s',analizador_lowpoint='%s',analizador_lowpoint_habilitado='%s',analizador_max='%s',analizador_max_habilitado='%s',analizador_alarma_alta_cloro='%s',analizador_alarma_alta_cloro_habilitado='%s',analizador_alarma_baja_cloro='%s',analizador_alarma_baja_cloro_habilitado='%s', analizador_pwd='%s' where analizador_id='%s'",$tabla_name_utcs,$gw_id,$nombre, $direccion, $tipo_utc, $magnitudes, $magnitudesSMS, $magnitudesEMAIL, $reposicion, $tiempo_medida,$setpoint,$delta,$lowpoint,$lowpoint_habilitado,$max,$max_habilitado,$alarma_alta_cloro,$alarma_alta_cloro_habilitado,$alarma_baja_cloro,$alarma_baja_cloro_habilitado,$password,$sID);
			}
			//echo $query;
			$result = mysql_query($query,$link);
			if(!$result)
			{
				echo "ERROR ";
				
			}
		}
		else
		{
			echo "ERROR ";
			return;
		}
	}
	
	mysql_close($link);

?>
