<?php											////////////////////// CONSTRUCCIÓN DE PARÁMETROS CON LOS DATOS RECOGIDOS DE LA BD PARA RELLENAR LA CONFIGURACIÓN DEL GW LOW ////////////
	ini_set('memory_limit','200M');
	include 'inc/datos_db.inc';
	include 'inc/funciones_medidas.inc';
	include 'inc/funciones_db.inc';
	
	$cliente_db = $_GET["cliente_db"];
	$gw_id=$_GET['gw_id'];
	
	$link = mysql_connect($db_host, $db_user, $db_pass);	
	mysql_select_db($cliente_db, $link);
	
	$query = sprintf("SELECT * FROM cliente_params_gw_low WHERE gw_id='%s'",$gw_id);
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
			echo "<parametro><nombre>CTA</nombre><valor>".$row['gw_CTA']."</valor></parametro>";
			echo "<parametro><nombre>CIS</nombre><valor>".$row['gw_CIS']."</valor></parametro>";
			echo "<parametro><nombre>CID</nombre><valor>".$row['gw_CID']."</valor></parametro>";
			echo "<parametro><nombre>CIP</nombre><valor>".$row['gw_CIP']."</valor></parametro>";
			echo "<parametro><nombre>CIT</nombre><valor>".$row['gw_CIT']."</valor></parametro>";
			
			for ($iI=0; $iI<23; $iI++)
			{
				if($iI<3)
				{
					echo "<parametro><nombre>M".$iI."X</nombre><valor>".$row["gw_A".$iI."MAX"]."</valor></parametro>";
					echo "<parametro><nombre>M".$iI."N</nombre><valor>".$row["gw_A".$iI."MIN"]."</valor></parametro>";
					echo "<parametro><nombre>U".$iI."D</nombre><valor>".$row["gw_A".$iI."UND"]."</valor></parametro>";
					
					echo "<parametro><nombre>D".$iI."B</nombre><valor>".$row["gw_D".$iI."B"]."</valor></parametro>";
				}
				if($iI<7)
				{					
					echo "<parametro><nombre>A".$iI."T</nombre><valor>".$row["gw_A".$iI."T"]."</valor></parametro>";
					echo "<parametro><nombre>A".$iI."P</nombre><valor>".$row["gw_A".$iI."P"]."</valor></parametro>";
					echo "<parametro><nombre>A".$iI."W</nombre><valor>".$row["gw_A".$iI."W"]."</valor></parametro>";
					echo "<parametro><nombre>A".$iI."M</nombre><valor>".$row["gw_A".$iI."M"]."</valor></parametro>";
					echo "<parametro><nombre>A".$iI."N</nombre><valor>".$row["gw_A".$iI."N"]."</valor></parametro>";
					echo "<parametro><nombre>A".$iI."U</nombre><valor>".sConvertir_Datos_GW(intval($row["gw_A".$iI."U"]), $row["gw_A".$iI."K"], 1, $row["gw_id"], $iI, 0, "12")."</valor></parametro>";
					echo "<parametro><nombre>A".$iI."L</nombre><valor>".sConvertir_Datos_GW(intval($row["gw_A".$iI."L"]), $row["gw_A".$iI."K"], 1, $row["gw_id"], $iI, 0, "12")."</valor></parametro>";
					echo "<parametro><nombre>A".$iI."K</nombre><valor>".$row["gw_A".$iI."K"]."</valor></parametro>";
					echo "<parametro><nombre>A".$iI."S</nombre><valor>".$row["gw_A".$iI."S"]."</valor></parametro>";
					echo "<parametro><nombre>A".$iI."V</nombre><valor>".$row["gw_A".$iI."V"]."</valor></parametro>";
					echo "<parametro><nombre>A".$iI."E</nombre><valor>".$row["gw_A".$iI."E"]."</valor></parametro>";
					echo "<parametro><nombre>A".$iI."A</nombre><valor>".$row["gw_A".$iI."A"]."</valor></parametro>";
					echo "<parametro><nombre>A".$iI."B</nombre><valor>".$row["gw_A".$iI."B"]."</valor></parametro>";								
				}
				
																				
				if ($iI<16)
				{
					echo "<parametro><nombre>D".strtoupper(dechex($iI))."U</nombre><valor>".sConvertir_Datos_GW(intval($row["gw_D".strtoupper(dechex($iI))."U"]), $row["gw_D".strtoupper(dechex($iI))."K"], 1, 0, $iI, 0, "12")."</valor></parametro>";
					echo "<parametro><nombre>D".strtoupper(dechex($iI))."C</nombre><valor>".$row["gw_D".strtoupper(dechex($iI))."C"]."</valor></parametro>";						
					echo "<parametro><nombre>D".strtoupper(dechex($iI))."E</nombre><valor>".$row["gw_D".strtoupper(dechex($iI))."E"]."</valor></parametro>";
					echo "<parametro><nombre>D".strtoupper(dechex($iI))."T</nombre><valor>".$row["gw_D".strtoupper(dechex($iI))."T"]."</valor></parametro>";
					echo "<parametro><nombre>D".strtoupper(dechex($iI))."K</nombre><valor>".$row["gw_D".strtoupper(dechex($iI))."K"]."</valor></parametro>";	
																			
				}
				echo "<parametro><nombre>EH".$iI."</nombre><valor>".$row["gw_EMAIL_enable".$iI]."</valor></parametro>";
				echo "<parametro><nombre>SH".$iI."</nombre><valor>".$row["gw_SMS_enable".$iI]."</valor></parametro>";
				echo "<parametro><nombre>SN".$iI."</nombre><valor>".$row["gw_SN".$iI]."</valor></parametro>";
			}

			echo "<parametro><nombre>NGW</nombre><valor>".$row['gw_nombre']."</valor></parametro>";
			echo "<parametro><nombre>HMR</nombre><valor>".$row['gw_reposicion']."</valor></parametro>";
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