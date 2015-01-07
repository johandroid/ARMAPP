<?php
	session_start();
	ini_set('memory_limit','200M');
	include 'inc/idiomas.inc';	
	include 'inc/datos_db.inc';
	include 'inc/funciones_sensores.inc';
	$link = mysql_connect($db_host, $db_user, $db_pass);
	$cliente_db = $_GET["cliente_db"];
	$disp_id=$_GET['disp_id'];
	$iTodos=$_GET['iTodosEnable'];
	
	mysql_select_db($cliente_db, $link);
	
	if ($iTodos == 0)
	{
		echo "<option id='X'>".$idiomas[$_SESSION['opcion_idioma']]['general111']."</option>";
	}
	
	$query = sprintf("SELECT analizador_id,analizador_vector_magnitudes,modbus_vector_magnitudes,analizador_tipo FROM %s INNER JOIN %s.%s ON %s.modbus_id=%s.analizador_tipo",$tabla_name_utcs, $db_name_general, $tabla_name_modbus, $tabla_name_modbus, $tabla_name_utcs);
	if ($disp_id!='000')
	{
		$query .= " WHERE ";

		$query .= sprintf(" analizador_id='%s'",$disp_id);
	
		//echo $query;
		$result = mysql_query($query,$link);
		if(!$result)
		{
			echo "ERROR";
		}
		else
		{
			if($row = mysql_fetch_array($result))
			{
				$iIndiceSelect = 0;
				$vMagnitudesGuardadas=$row['analizador_vector_magnitudes'];
				$vMagnitudes=$row['modbus_vector_magnitudes'];
				//echo "_".$vMagnitudesGuardadas."_";
				for ($iInd=0;$iInd<strlen($vMagnitudesGuardadas);$iInd++)
				{
					//echo $iInd."_".substr($vMagnitudesGuardadas,$iInd,1)."<br>";
					if(substr($vMagnitudesGuardadas,$iInd,1) == '1' && ($iInd<4 || ($iInd>=4 && $_SESSION['perfil']< 3) || ($iInd>=4 && $row['analizador_tipo']!=3)))
					{
						$nombreMagnitud = sObtener_Cadena_Tipo_Sensor_UTC(substr($row['modbus_vector_magnitudes'],($iInd*4+1),2),substr($row['modbus_vector_magnitudes'],($iInd*4+3),1));
						//echo $nombreMagnitud;
						/*if(substr($row['modbus_vector_magnitudes'],($iInd*4+3),1) != '0')
						{
							$nombreMagnitud .= " ".substr($row['modbus_vector_magnitudes'],($iInd*4+3),1);
						}
						*/
						$saVectorSensores[$iIndiceSelect] = "<option id='".$iInd."'>".$nombreMagnitud."</option>";
						$iIndiceSelect++;
					}
					
				}
				//echo count($saVectorSensores);
				for ($iInd=0;$iInd<count($saVectorSensores);$iInd++)
				{
					echo $saVectorSensores[$iInd];
				}
			}
		}
		mysql_free_result($result);
	}
	mysql_close($link);
?>
