<?php
	ini_set('memory_limit','200M');
	include 'inc/datos_db.inc';
	include 'inc/funciones_medidas.inc';
	include 'inc/funciones_db.inc';
	
	$cliente_db = $_GET["cliente_db"];
	$gw_id=$_GET['gw_id'];
	
	// Primero de todo obtenemos la version HW del GW, que se usara en conversiones
	$array_versiones = sObtener_Versiones_GW($gw_id, $cliente_db);
	$caGWVersionHW = $array_versiones[0];
	
	$link = mysql_connect($db_host, $db_user, $db_pass);	
	mysql_select_db($cliente_db, $link);
	
	$query = sprintf("SELECT * FROM cliente_params_gw WHERE gw_id='%s'",$gw_id);
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
			echo "<Gateway>";
			echo "<parametro><nombre>KEY</nombre><valor>".$row['gw_KEY']."</valor></parametro>";
			echo "<parametro><nombre>DHP</nombre><valor>".$row['gw_DHP']."</valor></parametro>";
			echo "<parametro><nombre>IPP</nombre><valor>".$row['gw_IPP']."</valor></parametro>";
			echo "<parametro><nombre>MSK</nombre><valor>".$row['gw_MSK']."</valor></parametro>";
			echo "<parametro><nombre>PDE</nombre><valor>".$row['gw_PDE']."</valor></parametro>";
			echo "<parametro><nombre>TPP</nombre><valor>".$row['gw_TPP']."</valor></parametro>";
			echo "<parametro><nombre>ITC</nombre><valor>".$row['gw_ITC']."</valor></parametro>";
			echo "<parametro><nombre>ITP</nombre><valor>".$row['gw_ITP']."</valor></parametro>";
			echo "<parametro><nombre>HPS</nombre><valor>".$row['gw_HPS']."</valor></parametro>";
			echo "<parametro><nombre>TCH</nombre><valor>".$row['gw_TCH']."</valor></parametro>";
			echo "<parametro><nombre>IPX</nombre><valor>".$row['gw_IPX']."</valor></parametro>";
			echo "<parametro><nombre>IPY</nombre><valor>".$row['gw_IPY']."</valor></parametro>";
			echo "<parametro><nombre>PRX</nombre><valor>".$row['gw_PRX']."</valor></parametro>";
			echo "<parametro><nombre>PRY</nombre><valor>".$row['gw_PRY']."</valor></parametro>";
			echo "<parametro><nombre>PGT</nombre><valor>".$row['gw_PGT']."</valor></parametro>";
			echo "<parametro><nombre>PGU</nombre><valor>".$row['gw_PGU']."</valor></parametro>";
			echo "<parametro><nombre>GSH</nombre><valor>".$row['gw_GSH']."</valor></parametro>";
			echo "<parametro><nombre>GSX</nombre><valor>".$row['gw_GSX']."</valor></parametro>";
			echo "<parametro><nombre>GSY</nombre><valor>".$row['gw_GSY']."</valor></parametro>";
			echo "<parametro><nombre>GPH</nombre><valor>".$row['gw_GPH']."</valor></parametro>";
			echo "<parametro><nombre>IPZ</nombre><valor>".$row['gw_IPZ']."</valor></parametro>";
			echo "<parametro><nombre>IPW</nombre><valor>".$row['gw_IPW']."</valor></parametro>";
			echo "<parametro><nombre>MTP</nombre><valor>".$row['gw_MTP']."</valor></parametro>";
			echo "<parametro><nombre>HMR</nombre><valor>".$row['gw_reposicion']."</valor></parametro>";
			
			for ($iI=1; $iI<10; $iI++)
			{
				echo "<parametro><nombre>TS".$iI."</nombre><valor>".$row["gw_TS".$iI]."</valor></parametro>";
				echo "<parametro><nombre>T".$iI."M</nombre><valor>".$row["gw_T".$iI."M"]."</valor></parametro>";
				echo "<parametro><nombre>T".$iI."S</nombre><valor>".$row["gw_T".$iI."S"]."</valor></parametro>";
				if((intval($row["gw_TS".$iI]) >= 3 && intval($row["gw_TS".$iI]) <= 6) || (intval($row["gw_TS".$iI]) >= 17 && intval($row["gw_TS".$iI]) <= 20)){ //AMB Las entradas digitales no convierten los umbrales, la función no sirve pq se convierten para otro fin 
					echo "<parametro><nombre>P".$iI."X</nombre><valor>".$row["gw_P".$iI."X"]."</valor></parametro>";
					echo "<parametro><nombre>P".$iI."N</nombre><valor>".$row["gw_P".$iI."N"]."</valor></parametro>";
				}
				else {
					echo "<parametro><nombre>P".$iI."X</nombre><valor>".sConvertir_Datos_GW(intval($row["gw_P".$iI."X"]), $row["gw_TS".$iI], 1, $row["gw_id"], $iI-1, 0, $caGWVersionHW)."</valor></parametro>";
					echo "<parametro><nombre>P".$iI."N</nombre><valor>".sConvertir_Datos_GW(intval($row["gw_P".$iI."N"]), $row["gw_TS".$iI], 1, $row["gw_id"], $iI-1, 0, $caGWVersionHW)."</valor></parametro>";			
				}
				
				if ($iI<4)
				{
					echo "<parametro><nombre>S".$iI."X</nombre><valor>".$row["gw_S".$iI."X"]."</valor></parametro>";
					echo "<parametro><nombre>S".$iI."N</nombre><valor>".$row["gw_S".$iI."N"]."</valor></parametro>";	
				}
				echo "<parametro><nombre>M".$iI."X</nombre><valor>".$row["gw_A".$iI."MAX"]."</valor></parametro>";
				echo "<parametro><nombre>M".$iI."N</nombre><valor>".$row["gw_A".$iI."MIN"]."</valor></parametro>";
				echo "<parametro><nombre>U".$iI."D</nombre><valor>".$row["gw_A".$iI."UND"]."</valor></parametro>";				
				echo "<parametro><nombre>EH".$iI."</nombre><valor>".$row["gw_EMAIL_enable".$iI]."</valor></parametro>";
				echo "<parametro><nombre>SH".$iI."</nombre><valor>".$row["gw_SMS_enable".$iI]."</valor></parametro>";
				echo "<parametro><nombre>SN".$iI."</nombre><valor>".$row["gw_SN".$iI]."</valor></parametro>";
			}
			echo "<parametro><nombre>NGW</nombre><valor>".$row['gw_nombre']."</valor></parametro>";
			echo "<parametro><nombre>VHW</nombre><valor>".$row['gw_versionHW']."</valor></parametro>";
			echo "<parametro><nombre>VSW</nombre><valor>".$row['gw_versionSW']."</valor></parametro>";
			echo "</Gateway>";
		}
		else
		{
			echo "ERROR";
		}
	}
	
	mysql_free_result($result);
	mysql_close($link);			
?>
