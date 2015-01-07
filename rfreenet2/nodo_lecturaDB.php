<?php
	ini_set('memory_limit','200M');

	include 'inc/datos_db.inc';
	include 'inc/funciones_medidas.inc';
	include 'inc/funciones_db.inc';	
	
	$cliente_db = $_GET["cliente_db"];
	$gw_id=$_GET['gw_id'];
	$nodo_mac=$_GET['nodo_mac'];
	
	$link = mysql_connect($db_host, $db_user, $db_pass);
	
	mysql_select_db($db_name_clientes, $link);
	$query = sprintf("SELECT gw_id, gw_tipo FROM %s WHERE gw_id='%s'",$tabla_name_suscriptores,$gw_id);
	//echo $query;
	$result = mysql_query($query,$link);
	if(!$result)
	{
		echo "ERROR 1 ".mysql_error($link);
	}
	else
	{
		if($row = mysql_fetch_array($result))
		{
			switch ($row['gw_tipo'])
			{
				case $tipo_gw_low:
					$query = sprintf("SELECT * FROM cliente_params_gw_low INNER JOIN (cliente_gateways INNER JOIN cliente_params_nodo ON (cliente_gateways.gw_id = cliente_params_nodo.gw_id)) ON (cliente_params_gw_low.gw_id = cliente_params_nodo.gw_id) WHERE cliente_params_nodo.gw_id='%s' AND nodo_mac='%s'",$gw_id,$nodo_mac);
					break;
									
				case $tipo_gw:
				default:
					$query = sprintf("SELECT * FROM cliente_params_gw INNER JOIN (cliente_gateways INNER JOIN cliente_params_nodo ON (cliente_gateways.gw_id = cliente_params_nodo.gw_id)) ON (cliente_params_gw.gw_id = cliente_params_nodo.gw_id) WHERE cliente_params_nodo.gw_id='%s' AND nodo_mac='%s'",$gw_id,$nodo_mac);
					break;
			}
			//echo $query;
			mysql_free_result($result);				
			mysql_select_db($cliente_db, $link);	
			$result = mysql_query($query,$link);
			if(!$result)
			{
				echo "ERROR 2 ".mysql_error($link);
			}
			else
			{
				if($row = mysql_fetch_array($result))
				{
					echo "<Nodo>";	
					echo "<parametro><nombre>TNO</nombre><valor>".$row['nodo_TNO']."</valor></parametro>";
					echo "<parametro><nombre>TPR</nombre><valor>".$row['nodo_TPR']."</valor></parametro>";
					echo "<parametro><nombre>TTW</nombre><valor>".$row['nodo_TTW']."</valor></parametro>";
					echo "<parametro><nombre>RET</nombre><valor>".$row['nodo_RET']."</valor></parametro>";
					echo "<parametro><nombre>RS1</nombre><valor>".$row['nodo_RS1']."</valor></parametro>";
					echo "<parametro><nombre>TRX</nombre><valor>".$row['nodo_TRX']."</valor></parametro>";
					echo "<parametro><nombre>TQW</nombre><valor>".$row['nodo_TQW']."</valor></parametro>";
					echo "<parametro><nombre>IPH</nombre><valor>".$row['nodo_IPH']."</valor></parametro>";
					echo "<parametro><nombre>IPL</nombre><valor>".$row['nodo_IPL']."</valor></parametro>";
					echo "<parametro><nombre>CTX</nombre><valor>".$row['nodo_CTX']."</valor></parametro>";
					echo "<parametro><nombre>CAK</nombre><valor>".$row['nodo_CAK']."</valor></parametro>";
					echo "<parametro><nombre>SEN</nombre><valor>".$row['nodo_SEN']."</valor></parametro>";
					echo "<parametro><nombre>HMR</nombre><valor>".$row['nodo_reposicion']."</valor></parametro>";
		
					for ($iI=1; $iI<7; $iI++)
					{
						echo "<parametro><nombre>SN".$iI."</nombre><valor>".$row["nodo_NN".$iI]."</valor></parametro>";
						echo "<parametro><nombre>TM".$iI."</nombre><valor>".$row["nodo_TM".$iI]."</valor></parametro>";
						echo "<parametro><nombre>TE".$iI."</nombre><valor>".$row["nodo_TE".$iI]."</valor></parametro>";
						echo "<parametro><nombre>TG".$iI."</nombre><valor>".$row["nodo_TG".$iI]."</valor></parametro>";
						echo "<parametro><nombre>TS".$iI."</nombre><valor>".$row["nodo_TS".$iI]."</valor></parametro>";
						echo "<parametro><nombre>UM".$iI."</nombre><valor>".sConvertir_Datos_Nodo(intval($row["nodo_UM".$iI]),$row["nodo_TS".$iI],1,'D',0,intval($row["nodo_aux_operacion".$iI]),intval($row["nodo_aux_constante".$iI]),$row["gw_id"],$row["nodo_ip"],$iI)."</valor></parametro>";
						echo "<parametro><nombre>UN".$iI."</nombre><valor>".sConvertir_Datos_Nodo(intval($row["nodo_UN".$iI]),$row["nodo_TS".$iI],1,'D',0,intval($row["nodo_aux_operacion".$iI]),intval($row["nodo_aux_constante".$iI]),$row["gw_id"],$row["nodo_ip"],$iI)."</valor></parametro>";
						echo "<parametro><nombre>GM".$iI."</nombre><valor>".sConvertir_Datos_Nodo(intval($row["nodo_GM".$iI]),$row["nodo_TS".$iI],1,'G',0,intval($row["nodo_aux_operacion".$iI]),intval($row["nodo_aux_constante".$iI]),$row["gw_id"],$row["nodo_ip"],$iI)."</valor></parametro>";
						
						echo "<parametro><nombre>M".$iI."X</nombre><valor>".$row["nodo_A".$iI."MAX"]."</valor></parametro>";				
						echo "<parametro><nombre>M".$iI."N</nombre><valor>".$row["nodo_A".$iI."MIN"]."</valor></parametro>";
						echo "<parametro><nombre>U".$iI."D</nombre><valor>".$row["nodo_A".$iI."UND"]."</valor></parametro>";
						echo "<parametro><nombre>EH".$iI."</nombre><valor>".$row["nodo_EMAIL_enable".$iI]."</valor></parametro>";
						echo "<parametro><nombre>SH".$iI."</nombre><valor>".$row["nodo_SMS_enable".$iI]."</valor></parametro>";
						
						echo "<parametro><nombre>OP".$iI."</nombre><valor>".$row["nodo_aux_operacion".$iI]."</valor></parametro>";
						echo "<parametro><nombre>CO".$iI."</nombre><valor>".$row["nodo_aux_constante".$iI]."</valor></parametro>";
					}
					echo "<parametro><nombre>NNO</nombre><valor>".$row['nodo_nombre']."</valor></parametro>";
					echo "<parametro><nombre>GTI</nombre><valor>".$row['gw_tipo']."</valor></parametro>";
					echo "<parametro><nombre>GHW</nombre><valor>".$row['gw_versionHW']."</valor></parametro>";
					echo "<parametro><nombre>GSW</nombre><valor>".$row['gw_versionSW']."</valor></parametro>";
					echo "</Nodo>";
				}
				else
				{
					echo "ERROR 3 ".mysql_error($link);
				}
			}			
		}
		else
		{
			echo "ERROR 4 ".mysql_error($link);
		}
	}
	mysql_free_result($result);
	mysql_close($link);
?>
