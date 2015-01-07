<?php
	ini_set('memory_limit','200M');
	session_start();
	include 'inc/idiomas.inc';
	include 'inc/datos_db.inc';
	include 'inc/funciones_aux.inc';
	include 'inc/funciones_sensores.inc';
	
	$cliente_db = $_GET["cliente_db"];
	$instalacion = $_GET["instalacion_id"];
	$gw_id = $_GET["gw_id"];

	$link = mysql_connect($db_host, $db_user, $db_pass);
	mysql_select_db($cliente_db, $link);

	$sNumDisp = 0;
	function vAnyadeDisp($id,$dispin,$salin,$estadoin)
	{
		global $stSalida;
		global $sNumDisp;
		$stSalida['dispositivo'][$sNumDisp] = $dispin;
		$stSalida['salida'][$sNumDisp] = $salin;
		$stSalida['estado'][$sNumDisp] = $estadoin;
		$stSalida['id'][$sNumDisp] = $id;
		$sNumDisp++;
		//echo $sNumDisp.' dispositivos<br/>';
	}
	
	$OpcionesSalida = '';
	
	//$query = sprintf("SELECT gw_nombre,gw_TS1,gw_TS2,gw_TS3,gw_TS4,gw_TS5,gw_TS6,gw_TS7,gw_TS8,gw_TS9,gw_SN1,gw_SN2,gw_SN3,gw_SN4,gw_SN5,gw_SN6,gw_SN7,gw_SN8,gw_SN9 FROM cliente_params_gw WHERE instalacion_id='%s' AND gw_id='%s';", $instalacion, $gw_id);
	$query = sprintf("SELECT cliente_params_gw.gw_nombre,gw_TS1,gw_TS2,gw_TS3,gw_TS4,gw_TS5,gw_TS6,gw_TS7,gw_TS8,gw_TS9,gw_SN1,gw_SN2,gw_SN3,gw_SN4,gw_SN5,gw_SN6,gw_SN7,gw_SN8,gw_SN9, gw_last_out1, gw_last_out2, gw_last_out3 FROM cliente_params_gw inner join cliente_gateways on cliente_params_gw.gw_id=cliente_gateways.gw_id WHERE cliente_params_gw.instalacion_id='%s' AND cliente_params_gw.gw_id='%s';", $instalacion, $gw_id);
	//echo $query.'<br/>';
	$result = mysql_query($query,$link);
	if(!$result)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_query_db'];?> 1"); </script><?
	}
	else
	{
		while($row = mysql_fetch_array($result))
		{
			if ($row['gw_nombre'] != '')
			{
				$etiqueta = $row['gw_nombre'];
			}
			else
			{
				$etiqueta = $idiomas[$_SESSION['opcion_idioma']]['general20']." ".$gw_id;
			}
			for ($iInd=1;$iInd<10;$iInd++)
			{
				$iValor = intval($row['gw_TS'.$iInd]);
				if (($iValor == 27) || ($iValor == 28) || ($iValor == 29))
				{
					$iNumSalida = $row['gw_TS'.$iInd]-26;
					if ($row['gw_SN'.$iInd] != '')
					{
						$etiquetaS = $row['gw_SN'.$iInd];
					}
					else
					{
						$etiquetaS = 'SEN'.$iInd.': '.sObtener_Cadena_Tipo_Sensor_GW($row['gw_TS'.$iInd]);
					}
					$ultimo_estado = intval($row['gw_last_out'.($iValor - 26)]);
					//echo 'Anyade '.$etiqueta.' '.$etiquetaS.'<br/>';
					vAnyadeDisp("000".$iNumSalida, $etiqueta, $etiquetaS, $ultimo_estado);
				}
			}
		}
	}

	//$query = sprintf("SELECT nodo_SEN, nodo_ip, nodo_mac ,nodo_nombre, nodo_TS1,nodo_TS2,nodo_TS3,nodo_TS4,nodo_TS5,nodo_TS6,nodo_NN1,nodo_NN2,nodo_NN3,nodo_NN4,nodo_NN5,nodo_NN6 FROM cliente_params_nodo WHERE nodo_RS1='62' AND instalacion_id='%s' AND gw_id='%s';", $instalacion, $gw_id, $nodo_ip);
	$query = sprintf("SELECT nodo_SEN, cliente_params_nodo.nodo_ip, cliente_params_nodo.nodo_mac, cliente_params_nodo.nodo_nombre, nodo_TS1, nodo_TS2, nodo_TS3, nodo_TS4, nodo_TS5, nodo_TS6, nodo_NN1, nodo_NN2, nodo_NN3, nodo_NN4, nodo_NN5, nodo_NN6, nodo_last_out1, nodo_last_out2, nodo_last_out3, nodo_last_out4 FROM cliente_params_nodo inner join cliente_nodos on cliente_params_nodo.nodo_mac=cliente_nodos.nodo_mac and cliente_params_nodo.gw_id=cliente_nodos.gw_id WHERE nodo_RS1='62' AND cliente_params_nodo.instalacion_id='%s' AND cliente_params_nodo.gw_id='%s';", $instalacion, $gw_id, $nodo_ip);
	//echo $query.'<br/>';
	$result = mysql_query($query,$link);
	if(!$result)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_query_db'];?> 2"); </script><?
	}
	else
	{
		while($row = mysql_fetch_array($result))
		{
			if ($row['nodo_nombre'] != '')
			{
				$etiqueta = $row['nodo_nombre'];
			}
			else
			{
				$etiqueta = $idiomas[$_SESSION['opcion_idioma']]['general21']." ".$row['nodo_mac'];
			}
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
					// Añadimos el puerto al que esta asociado la salida
					//$iNumSalida = substr(($row['nodo_TS'.(6-$iInd)]), 1, 1);
					// O añadimos el numero de sensor
					$iNumSalida = intval(6-$iInd);
					if ($row['nodo_NN'.(6-$iInd)] != '')
					{
						$etiquetaS = $row['nodo_NN'.(6-$iInd)];
					}
					else
					{
						$etiquetaS = 'SEN'.(6-$iInd).': '.sObtener_Cadena_Tipo_Sensor($row['nodo_TS'.(6-$iInd)]).' '.$iNumSalida;
					}
					//echo 'Anyade '.$etiqueta.' '.$etiquetaS.'<br/>';
					$iValor = intval(substr($row['nodo_TS'.(6-$iInd)], 1 ,1));
					$ultimo_estado = intval($row['nodo_last_out'.$iValor]);
					vAnyadeDisp($row['nodo_ip'].$iNumSalida, $etiqueta, $etiquetaS, $ultimo_estado);
				}
				$iAcum=$iResto;
			}
		}
	}
	mysql_free_result($result);
	mysql_close($link);
	//print_r($stSalida);
	
	$ancho_1 = '30%';
	$ancho_2 = '30%';
	$ancho_3 = '25%';
	$ancho_4 = '15%';
	
	$alto='25px';
	
	// Y sacamos la tabla con el listado generado
	echo "<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" width=\"99%\" id=\"tabula_tm\">";
	echo "<tr>";
	echo "<td align=\"center\" width=\"$ancho_1\" class=\"RFNETBold\">".$idiomas[$_SESSION['opcion_idioma']]['param39']."</td>";
	echo "<td align=\"center\" width=\"$ancho_2\" class=\"RFNETBold\">".$idiomas[$_SESSION['opcion_idioma']]['general24']."</td>";
	echo "<td align=\"center\" width=\"$ancho_3\" class=\"RFNETBold\">".$idiomas[$_SESSION['opcion_idioma']]['general23']."</td>";
	echo "<td align=\"center\" width=\"$ancho_4\" class=\"RFNETBold\">".$idiomas[$_SESSION['opcion_idioma']]['general54']."</td>";
	echo "</tr>";
	for ($iCuenta = 0; $iCuenta < $sNumDisp; $iCuenta++)
	{
		if ((($iCuenta)%2) == 0)
		{
			echo "<tr class=\"tipo_fila_2\" height=\"$alto\">";
		}
		else
		{
			 echo "<tr class=\"tipo_fila_1\" height=\"$alto\">";
		}
		echo "<td align=\"center\" width=\"$ancho_1\" class=\"RFNETtextborder\">".$stSalida['dispositivo'][$iCuenta]."</td>";
		echo "<td align=\"center\" width=\"$ancho_2\" class=\"RFNETtextborder\">".$stSalida['salida'][$iCuenta]."</td>";
		echo "<td align=\"center\" width=\"$ancho_3\" class=\"RFNETtextborder\">";
		echo "	<select name='S".$stSalida['id'][$iCuenta]."' id='S".$stSalida['id'][$iCuenta]."' style='width:75px;text-align:center' class='texto_valores'>";
		if ($stSalida['estado'][$iCuenta] == 0)
		{
			echo "		<option id='0' selected='selected'>OFF</option>";
			echo "		<option id='1'>ON</option>";
		}
		else
		{
			echo "		<option id='0'>OFF</option>";
			echo "		<option id='1' selected='selected'>ON</option>";
		}
		echo "</select>";
		echo "</td>";
		echo "<td align=\"center\" width=\"$ancho_4\" class=\"RFNETtextborder\">";
		echo "	<input type='checkbox' name='".$stSalida['id'][$iCuenta]."' id='".$stSalida['id'][$iCuenta]."' value='".$stSalida['id'][$iCuenta]."'/>";
		echo "</td>";
		echo "</tr>";
	}
?>
