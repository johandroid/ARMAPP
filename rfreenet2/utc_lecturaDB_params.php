<?php
	session_start();
	ini_set('memory_limit','200M');
	include 'inc/comunica.inc';
	include 'inc/datos_db.inc';
	include 'inc/funciones_medidas.inc';
	include 'inc/funciones_db.inc';
	
	$gw_id=$_GET['gw_id'];
	$direccion=$_GET['direccion'];

	$link = mysql_connect($db_host, $db_user, $db_pass);
	mysql_select_db($_SESSION['cliente_db'], $link);
	
	$query = sprintf("SELECT analizador_alarma_alta_cloro_habilitado,analizador_alarma_baja_cloro_habilitado,analizador_delta,analizador_lowpoint_habilitado,analizador_max_habilitado,analizador_alarma_alta_cloro,analizador_alarma_baja_cloro,analizador_setpoint,analizador_lowpoint,analizador_tiempo_medida,analizador_max FROM cliente_analizadores WHERE gw_id='%s' AND analizador_direccion='%s';",  $gw_id, $direccion);
	
	//echo $query;
	$result = mysql_query($query,$link);
	if(!$result)
	{
		$respuesta = "ERROR ".mysql_error($link);
	}
	else
	{
		if($row = mysql_fetch_array($result))
		{
			$respuesta = "<utcs><utc ";
			$respuesta .= " alarma_alta_habilitado='".$row['analizador_alarma_alta_cloro_habilitado']."'";
			$respuesta .= " alarma_baja_habilitado='".$row['analizador_alarma_baja_cloro_habilitado']."'";
			$respuesta .= " delta='".$row['analizador_delta']."'";
			$respuesta .= " punto_bajo_habilitado='".$row['analizador_lowpoint_habilitado']."'";
			$respuesta .= " tiempo_maximo_habilitado='".$row['analizador_max_habilitado']."'";
			$respuesta .= " alarma_alta='".$row['analizador_alarma_alta_cloro']."'";
			$respuesta .= " alarma_baja='".$row['analizador_alarma_baja_cloro']."'";
			$respuesta .= " setpoint='".$row['analizador_setpoint']."'";
			$respuesta .= " punto_bajo='".$row['analizador_lowpoint']."'";
			$respuesta .= " tiempo_medida='".$row['analizador_tiempo_medida']."'";
			$respuesta .= " tiempo_maximo='".$row['analizador_max']."'";
			$respuesta .= "></utc></utcs>";
		}
		else
		{
			$respuesta = "ERROR ".mysql_error($link);
		}
	}
	
	mysql_free_result($result);
	mysql_close($link);
	echo $respuesta;
?>
