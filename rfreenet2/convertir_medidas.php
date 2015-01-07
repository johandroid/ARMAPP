<?php
session_start();
include 'inc/idiomas.inc';
include 'inc/funciones_sensores.inc';
include 'inc/funciones_medidas.inc';
include 'inc/datos_db.inc';
include 'inc/funciones_db.inc';

$_SESSION['opcion_idioma'] = 'en';
$_SESSION['cliente_db']=$_POST['dbname'];
$tipo_dispositivo=$_POST['tipodisp'];
$tipo_medida=$_POST['tipomedida'];
$valor_medida=$_POST['valormedida'];
$tipo_dato=$_POST['tipodato'];
$num_sensor=$_POST['numsensor'];
$nodo_mac=$_POST['nodomac'];
$db_name=$_POST['dbname'];
$gw_id=$_POST['gwid'];

switch($tipo_dato)
{
	case "Gradient":
		$tipo = 'G';
		break;
		
	case "Data":
	case "Threshold":
	default:
		$tipo = 'D';
		break;
}


if($tipo_dispositivo==0)
{
	// Primero de todo obtenemos la version HW del GW, que se usara en conversiones
	$array_versiones = sObtener_Versiones_GW($gw_id, $_SESSION['cliente_db']);
	$caGWVersionHW = $array_versiones[0];
		
	//echo $tipo_sensor." GW\r\n";
	if($tipo_medida=='BAT')
	{
		$magnitud = $tipo_medida;
	}
	else 
	{
		if(($tipo_medida == '35') || ($tipo_medida == '36') || ($tipo_medida == '2'))
		{
			if(iObtenerTipoGW($gw_id, $db_name) == 0)
			{
				$tabla_params_gw = $tabla_name_params_gateways;		
			}
			else 
			{
				$tabla_params_gw = $tabla_name_params_gateways_low;
				$num_sensor--;
			}
			
			$link = mysql_connect($db_host, $db_user, $db_pass);
			
			mysql_select_db($db_name, $link);
						
			
			$query = sprintf("SELECT gw_A%sUND as unidad, magnitud FROM %s INNER JOIN ".$db_name_general.".rfreenet_uds_sensor_generico ON (gw_A%sUND = cod_unidad) WHERE gw_id='%s' ", $num_sensor, $tabla_params_gw, $num_sensor, $gw_id);
			//echo $query;
			$result = mysql_query($query,$link);
			if(!$result)
			{
				echo "ERROR ".mysql_error($link);
			}
			else
			{
				if($row = mysql_fetch_array($result))
				{
					/*
					if ($tipo_medida == '2')
					{
						$tipo_medida = $_POST['tipomedida'].pad_izquierda($row["unidad"],2,'0');
					}
					else
					{
						$tipo_medida = $_POST['tipomedida'].$row["unidad"];
					}
					*/
					$magnitud = sObtener_Cadena_Magnitud_Sensor_GW($tipo_medida);
					if ($sMagnitud == "GENERICO")
					{
						$sMagnitud = $row[magnitud];
					}
				}
			}
			mysql_free_result($result);
			mysql_close($mysql);
		}
		else
		{
			$num_sensor--;
			$magnitud = sObtener_Cadena_Magnitud_Sensor_GW($tipo_medida);
		}			
	}
	$valor = sConvertir_Datos_GW(hexdec($valor_medida), $_POST['tipomedida'], 1, $gw_id, $num_sensor, 1, $caGWVersionHW);
}
elseif($tipo_dispositivo==1)
{
	//echo $tipo_sensor." Nodo\r\n";
	if(($tipo_medida=='BAT') || ($tipo_medida=='COB'))
	{
		$magnitud = $tipo_medida;
		$valor = sConvertir_Datos_Nodo(hexdec($valor_medida), $tipo_medida, 1,$tipo,1,1, 1, 1, 1, 1);
	}
	else 
	{
		if(((substr($tipo_medida, 0, 1) == '4' || 
		   substr($tipo_medida, 0, 1) == 'D' ||
		   substr($tipo_medida, 0, 1) == 'd' ||
		   substr($tipo_medida, 0, 1) == 'C' ||
		   substr($tipo_medida, 0, 1) == 'c')) &&
		   substr($tipo_medida, 2, 1) == '0')
		{		
			//echo "hi";
			$link = mysql_connect($db_host, $db_user, $db_pass);	
			
			mysql_select_db($db_name, $link);
					
			$query = sprintf("SELECT nodo_A%sUND as unidad, magnitud FROM %s INNER JOIN ".$db_name_general.".rfreenet_uds_sensor_generico ON (nodo_A%sUND = cod_unidad) WHERE nodo_mac='%s' AND  gw_id='%s' ", $num_sensor, $tabla_name_params_nodos, $num_sensor,$nodo_mac, $gw_id);
			//echo $query;
			$result = mysql_query($query,$link);
			if(!$result)
			{
				echo "ERROR ".mysql_error($link);
			}
			else
			{
				if($row = mysql_fetch_array($result))
				{
					$magnitud = sObtener_Cadena_Magnitud_Sensor($tipo_medida, $row["unidad"]);
					if ($sMagnitud == "GENERICO")
					{
						$sMagnitud = $row[magnitud];
					}
				}
			}	
			mysql_free_result($result);
			mysql_close($mysql);
		}
		else
		{
				$magnitud = sObtener_Cadena_Magnitud_Sensor($tipo_medida, "0");	
		}		

		$query = sprintf("select nodo_aux_operacion%d AS operacion,nodo_aux_constante%d AS constante, nodo_ip FROM cliente_params_nodo WHERE nodo_mac='%s' AND gw_id='%s'", $num_sensor, $num_sensor,$nodo_mac, $gw_id);
		
		$link = mysql_connect($db_host, $db_user, $db_pass);
	
		mysql_select_db($db_name, $link);
		$result = mysql_query($query,$link);
		if(!$result)
		{
			mysql_close($link);
			return;
		}
		else
		{
			if(($row = mysql_fetch_array($result)))
			{
				$valor = sConvertir_Datos_Nodo(hexdec($valor_medida), $tipo_medida, 1,$tipo,1, $row['operacion'], $row['constante'],$gw_id,$row['nodo_ip'],$num_sensor);
			}
			else
			{
				mysql_free_result($result);
				mysql_close($link);
				return;
			}
			mysql_free_result($result);
		}
		
		mysql_close($link);
	}
}
elseif($tipo_dispositivo==2)
{
	//echo $tipo_sensor." UTC\r\n";
	$query = sprintf("select rfreenet_modbus_conversion.modbus_operacion,   rfreenet_modbus_conversion.modbus_operando  
							   from %s.rfreenet_modbus_conversion right join cliente_analizadores on 
							   	    (rfreenet_modbus_conversion.modbus_id=cliente_analizadores.analizador_tipo) WHERE analizador_id='%s'", 
							  $db_name_general, $nodo_mac);
  	$link = mysql_connect($db_host, $db_user, $db_pass);
	//echo $query;
	mysql_select_db($db_name, $link);
	$result = mysql_query($query,$link);
	if(!$result)
	{
		mysql_close($link);
		return;
	}
	else
	{
		if(($row = mysql_fetch_array($result)))
		{
			$valor = sConvertir_Datos_UTC(hexdec($valor_medida), substr($tipo_medida,1,2), 1, $row['modbus_operacion'],$row['modbus_operando'],1);
		}
		else
		{
			mysql_free_result($result);
			mysql_close($link);
			return;
		}
		mysql_free_result($result);
	}
	
	mysql_close($link);
	$magnitud = sObtener_Cadena_Magnitud_Sensor_UTC(substr($tipo_medida,1,2));
}
else 
{
	return;
}
//echo $magnitud."\r\n";
echo sObtener_Tipo_Sensor_Unidad($magnitud);

echo $valor."\r\n";
?>