<?php
	ini_set('memory_limit','200M');
	session_start();
	include 'inc/idiomas.inc';
	include 'inc/datos_db.inc';
	include 'inc/funciones_aux.inc';
	include 'inc/funciones_sensores.inc';
	
	$cliente_db = $_GET["cliente_db"];
	$instalacion = $_GET["instalacion_id"];
	$sCadenaDispositivo = $_GET["sdevice"];
	$sSensorIN = $_GET["sSensorIN"];
	
	// Extraemos los valores de gw_id y nodo_ip, para ver de que tabla debemos leer
	$gw_id = substr($sCadenaDispositivo, 0, 4);
	$nodo_ip = substr($sCadenaDispositivo, 4, 3);
	
	$link = mysql_connect($db_host, $db_user, $db_pass);
	mysql_select_db($cliente_db, $link);

	$OpcionesSalida = '';
	
	// Si es un GW el seleccionado
	if ($nodo_ip == '000')
	{
		//$query = sprintf("SELECT gw_TS1,gw_TS2,gw_TS3,gw_TS4,gw_TS5,gw_TS6,gw_TS7,gw_TS8,gw_TS9 FROM cliente_params_gw where instalacion_id='%s' AND gw_id='%s';", $instalacion, $gw_id);
		$query = sprintf("SELECT gw_TS%s FROM cliente_params_gw where instalacion_id='%s' AND gw_id='%s';", $sSensorIN, $instalacion, $gw_id);
		$result = mysql_query($query,$link);
		if(!$result)
		{
			?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_query_db'];?> 1"); </script><?
		}
		else
		{
			while($row = mysql_fetch_array($result))
			{
				$iValor = intval($row['gw_TS'.$sSensorIN]);
				if (($iValor > 0) && ($iValor != 27) && ($iValor != 28) && ($iValor != 29))
				{
					$etiqueta = 'S'.$sSensorIN.' '.$idiomas[$_SESSION['opcion_idioma']]['general146'];
					$OpcionesSalida = $OpcionesSalida."<option value=\"".(599+$sSensorIN)."\">".$etiqueta."</option>";
					$etiqueta = 'S'.$sSensorIN.' '.$idiomas[$_SESSION['opcion_idioma']]['param51'];
					$OpcionesSalida = $OpcionesSalida."<option value=\"".(624+$sSensorIN)."\">".$etiqueta."</option>";
					$etiqueta = 'S'.$sSensorIN.' '.$idiomas[$_SESSION['opcion_idioma']]['param53'];
					$OpcionesSalida = $OpcionesSalida."<option value=\"".(649+$sSensorIN)."\">".$etiqueta."</option>";
				}
			}
		}
	}
	// Si es un nodo
	else
	{
		//$query = sprintf("Select nodo_SEN,nodo_TS1,nodo_TS2,nodo_TS3,nodo_TS4,nodo_TS5,nodo_TS6 from cliente_params_nodo where instalacion_id='%s' AND gw_id='%s' AND nodo_ip='%s';", $instalacion, $gw_id, $nodo_ip);
		$query = sprintf("Select nodo_SEN,nodo_TS%s from cliente_params_nodo where instalacion_id='%s' AND gw_id='%s' AND nodo_ip='%s';", $sSensorIN, $instalacion, $gw_id, $nodo_ip);
		$result = mysql_query($query,$link);
		if(!$result)
		{
			?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_query_db'];?> 2"); </script><?
		}
		else
		{
			while($row = mysql_fetch_array($result))
			{
				$iAcum=intval($row['nodo_SEN']);
				for ($iInd=0;$iInd<6;$iInd++)
				{
					$iNumSensorAux = 6-$iInd;
					$iParcial=intval($iAcum/(pow(2,$iNumSensorAux-1)));
					$iResto=$iAcum%(pow(2,$iNumSensorAux-1));
					// Si esta habilitado y no es salida digital, vale como entrada
					if (($iParcial==1) && (substr($row['nodo_TS'.$iNumSensorAux], 0 ,1) != '5') && ($iNumSensorAux == $sSensorIN))
					{
						$etiqueta = 'S'.$iNumSensorAux.' '.$idiomas[$_SESSION['opcion_idioma']]['general146'];
						//$OpcionesSalida = $OpcionesSalida."<option value=\"".$gw_id.$nodo_ip.(499+$iNumSensorAux)."\">".$etiqueta."</option>";
						$OpcionesSalida = $OpcionesSalida."<option value=\"".(499+$iNumSensorAux)."\">".$etiqueta."</option>";
						$etiqueta = 'S'.$iNumSensorAux.' '.$idiomas[$_SESSION['opcion_idioma']]['param96'];
						//$OpcionesSalida = $OpcionesSalida."<option value=\"".$gw_id.$nodo_ip.(505+$iNumSensorAux)."\">".$etiqueta."</option>";
						$OpcionesSalida = $OpcionesSalida."<option value=\"".(505+$iNumSensorAux)."\">".$etiqueta."</option>";
						//$etiqueta = 'S'.$iNumSensorAux.' '.$idiomas[$_SESSION['opcion_idioma']]['event_gradiente'];
						//$OpcionesSalida = $OpcionesSalida."<option value=\"".$gw_id.$nodo_ip.(511+$iNumSensorAux)."\">".$etiqueta."</option>";
						//$OpcionesSalida = $OpcionesSalida."<option value=\"".(511+$iNumSensorAux)."\">".$etiqueta."</option>";
					}
					$iAcum=$iResto;
				}
			}
		}
	}
	mysql_free_result($result);
	mysql_close($link);
	echo $OpcionesSalida;
?>
