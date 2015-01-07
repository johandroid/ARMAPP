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
	
	// Extraemos los valores de gw_id y nodo_ip, para ver de que tabla debemos leer
	$gw_id = substr($sCadenaDispositivo, 0, 4);
	$nodo_ip = substr($sCadenaDispositivo, 4, 3);
	
	$link = mysql_connect($db_host, $db_user, $db_pass);
	mysql_select_db($cliente_db, $link);

	$OpcionesSalida = '';
	
	// Si es un GW el seleccionado
	if ($nodo_ip == '000')
	{
		$query = sprintf("SELECT gw_TS1,gw_TS2,gw_TS3,gw_TS4,gw_TS5,gw_TS6,gw_TS7,gw_TS8,gw_TS9,gw_SN1,gw_SN2,gw_SN3,gw_SN4,gw_SN5,gw_SN6,gw_SN7,gw_SN8,gw_SN9 FROM cliente_params_gw where instalacion_id='%s' AND gw_id='%s';", $instalacion, $gw_id);
		$result = mysql_query($query,$link);
		if(!$result)
		{
			?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_query_db'];?> 1"); </script><?
		}
		else
		{
			while($row = mysql_fetch_array($result))
			{
				for ($iInd=1;$iInd<10;$iInd++)
				{
					$iValor = intval($row['gw_TS'.$iInd]);
					if (($iValor == 27) || ($iValor == 28) || ($iValor == 29))
					{
						if ($row['gw_SN'.$iInd] != '')
						{
							$etiqueta = $row['gw_SN'.$iInd];
						}
						else
						{
							$etiqueta = 'S'.$iInd.': '.$sNombreSensor=sObtener_Cadena_Tipo_Sensor_GW($row['gw_TS'.$iInd]);
						}
						//$OpcionesSalida = $OpcionesSalida."<option value=\"".$gw_id."000".$iInd."\">".$etiqueta."</option>";
						$OpcionesSalida = $OpcionesSalida."<option value=\"".($iValor-26)."\">".$etiqueta."</option>";
					}
				}
			}
		}
	}
	// Si es un nodo
	else
	{
		$query = sprintf("Select nodo_SEN,nodo_TS1,nodo_TS2,nodo_TS3,nodo_TS4,nodo_TS5,nodo_TS6,nodo_NN1,nodo_NN2,nodo_NN3,nodo_NN4,nodo_NN5,nodo_NN6 from cliente_params_nodo where nodo_RS1='62' AND instalacion_id='%s' AND gw_id='%s' AND nodo_ip='%s';", $instalacion, $gw_id, $nodo_ip);
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
					//echo $nodo_ip.' '.(6-$iInd).' S='.$row['nodo_TS'.(6-$iInd)].'<br/>';
					$iParcial=intval($iAcum/(pow(2,(5-$iInd))));
					$iResto=$iAcum%(pow(2,(5-$iInd)));
					//echo ' -> '.$iAcum.' '.$iParcial.'<br/>';
					// Si esta habilitado y no es salida digital, vale como entrada
					if (($iParcial==1) && (substr($row['nodo_TS'.(6-$iInd)], 0 ,1) == '5'))
					{
						if ($row['nodo_NN'.(6-$iInd)] != '')
						{
							$etiqueta = $row['nodo_NN'.(6-$iInd)];
						}
						else
						{
							$etiqueta = 'S'.(6-$iInd).': '.sObtener_Cadena_Tipo_Sensor($row['nodo_TS'.(6-$iInd)]);
						}
						//echo $etiqueta.'<br/>';
						//$OpcionesSalida = $OpcionesSalida."<option value=\"".$gw_id.$nodo_ip.(6-$iInd)."\">".$etiqueta."</option>";
						$OpcionesSalida = $OpcionesSalida."<option value=\"".(6-$iInd)."\">".$etiqueta."</option>";
						//echo '__'.$OpcionesSalida.'__<br/>';
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
