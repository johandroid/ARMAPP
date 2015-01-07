<?php
session_start();
include 'inc/datos_db.inc';
include 'inc/idiomas.inc';
include 'inc/funciones_sensores.inc';
include 'inc/funciones_db.inc';

$_SESSION['opcion_idioma'] = 'en';
$tipo_dispositivo=$_POST['tipodisp'];
$tipo_sensor=$_POST['tiposensor'];
$gw_id=$_POST['gwid'];
$nodo_mac=$_POST['nodomac'];
$num_sensor=$_POST['numsensor'];
$db_name=$_POST['dbname'];

if($tipo_dispositivo==0)
{
	if(($tipo_sensor == '35') || ($tipo_sensor == '36') || ($tipo_sensor == '2'))
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
		//echo "hi";
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
					$tipo_sensor = $_POST['tipomedida'].pad_izquierda($row["unidad"],2,'0');
				}
				else
				{
					$tipo_sensor = $_POST['tipomedida'].$row["unidad"];
				}
				*/
				$magnitud = sObtener_Cadena_Magnitud_Sensor_GW($tipo_sensor);
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
		$magnitud = sObtener_Cadena_Magnitud_Sensor_GW($tipo_sensor);
	}

	
	//echo $tipo_sensor." GW\r\n";
	$magnitud = sObtener_Cadena_Magnitud_Sensor_GW($tipo_sensor);
}
elseif($tipo_dispositivo==1)
{

	if(((substr($tipo_sensor, 0, 1) == '4' || 
	   substr($tipo_sensor, 0, 1) == 'D' ||
	   substr($tipo_sensor, 0, 1) == 'd' ||
	   substr($tipo_sensor, 0, 1) == 'C' ||
	   substr($tipo_sensor, 0, 1) == 'c')) &&
	   substr($tipo_sensor, 2, 1) == '0')
	{		
		//echo "hi";
		$link = mysql_connect($db_host, $db_user, $db_pass);	
		
		mysql_select_db($db_name, $link);
				
		$query = sprintf("SELECT nodo_A%sUND as unidad, magnitud FROM %s INNER JOIN ".$db_name_general.".rfreenet_uds_sensor_generico ON (nodo_A%sUND = cod_unidad) WHERE nodo_mac='%s' AND gw_id='%s' ", $num_sensor, $tabla_name_params_nodos, $num_sensor, $nodo_mac,  $gw_id);
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
				//$tipo_sensor = $_POST['tiposensor'].$row["unidad"];
				//echo $row["unidad"];
				$magnitud = sObtener_Cadena_Magnitud_Sensor($tipo_sensor, $row["unidad"]);
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
		$magnitud = sObtener_Cadena_Magnitud_Sensor($tipo_sensor, "0");	
	}	
	//echo $tipo_sensor." Nodo\r\n";
	
}
elseif($tipo_dispositivo==2)
{
	//echo $tipo_sensor." UTC\r\n";
	echo sObtener_Cadena_Tipo_Sensor_UTC(substr($tipo_sensor,(1),2),substr($tipo_sensor,3,1))."\r\n";
	$magnitud = sObtener_Cadena_Magnitud_Sensor_UTC(substr($tipo_sensor,1,2));
}
else 
{
	echo "ERROR";	
	return;
}
echo sObtener_Tipo_Sensor_Unidad($magnitud);

?>
