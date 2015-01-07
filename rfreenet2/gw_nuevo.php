<?php
	session_start();
	ini_set('memory_limit','200M');

	include 'inc/datos_db.inc';
	include 'inc/funciones_db.inc';
	include 'inc/funciones_indice.inc';
	
	$sInstalacionActual=$_POST['instalacion_id'];
	$sTramaParams=$_POST['paramsGW'];
	$db_client=$_POST['cliente_db'];
	
	// Marcamos latitud y longitud segun el sistema este en modo offline o no
	if (iObtenerModoOffline() == 0)
	{
		$latitud_gw_aux = 0;
		$longitud_gw_aux = 0;
	}
	else
	{
		$latitud_gw_aux = 1;
		$longitud_gw_aux = 1;
	}
	
	$SuscriptorNuevo=sObtener_Nuevo_Suscriptor();
	if ($SuscriptorNuevo == 'ERROR')
	{
		echo $SuscriptorNuevo; 
	}
	//else
	//{
	//	echo 'Nuevo SUS='.$SuscriptorNuevo.'<br>';
	//}
	
	$link = mysql_connect($db_host, $db_user, $db_pass);
	
	// en primer lugar lo insertamos en la tabla de suscriptores general
	mysql_select_db($db_name_clientes, $link);
	
	$query = sprintf("INSERT INTO %s VALUES('','%s','%s','%s',".$tipo_gw.")",$tabla_name_suscriptores,$SuscriptorNuevo,$_SESSION['id_cliente'],$sInstalacionActual);
	//echo $query;
	$result = mysql_query($query,$link);
	if(!$result)
	{
		echo "ERROR1 ".mysql_error($link);
	}
	else
	{
		//echo $SuscriptorNuevo." insertado en Suscriptores";
		 
		// despues lo insertamos en la tabla de gateways del cliente
		mysql_select_db($_SESSION['cliente_db'], $link);
				
		$query = sprintf("INSERT INTO %s (`gw_id`,`instalacion_id`,`gw_nombre`,`gw_onoff`,`gw_estado`,`gw_latitud`,`gw_longitud`, `gw_tipo`) VALUES('%s','%s','%s','0','01','%s','%s', %d)",$tabla_name_gateways,$SuscriptorNuevo,$sInstalacionActual,'Gateway '+$SuscriptorNuevo, $latitud_gw_aux, $longitud_gw_aux, $tipo_gw);
		$result = mysql_query($query,$link);
		if(!$result)
		{
			echo "ERROR2 ".mysql_error($link);
			mysql_select_db($db_name_clientes, $link);
			$query = sprintf("DELETE FROM %s WHERE gw_id='%s' AND instalacion_id='%s'",$tabla_name_suscriptores,$SuscriptorNuevo,$sInstalacionActual);
			//echo $query;
			$result = mysql_query($query,$link);
			if(!$result)
			{
				echo "ERROR3 ";
			}
		}
		else
		{
			// y lo insertamos en la tabla de params de gateway del cliente
			$query = sprintf("INSERT INTO %s (`gw_id`,`instalacion_id`,`gw_nombre`) VALUES('%s','%s','%s')",$tabla_name_params_gateways,$SuscriptorNuevo,$sInstalacionActual,'Gateway '+$SuscriptorNuevo);
			//echo $query;
			$result = mysql_query($query,$link);
			if(!$result)
			{
				echo "ERROR4 ";
				$query = sprintf("DELETE FROM %s WHERE gw_id='%s' AND instalacion_id='%s'",$tabla_name_gateways,$SuscriptorNuevo,$sInstalacionActual);
				//echo $query;
				$result = mysql_query($query,$link);
				if(!$result)
				{
					echo "ERROR5 ";
				}
				mysql_select_db($db_name_clientes, $link);
				$query = sprintf("DELETE FROM %s WHERE gw_id='%s' AND instalacion_id='%s'",$tabla_name_suscriptores,$SuscriptorNuevo,$sInstalacionActual);
				//echo $query;
				$result = mysql_query($query,$link);
				if(!$result)
				{
					echo "ERROR6 ";
				}
			}
			else
			{
				$saVectorExplode=explode(";",$sTramaParams);
				
				$query = sprintf("UPDATE %s SET ",$tabla_name_params_gateways);
				$query_name = sprintf("UPDATE %s SET ",$tabla_name_gateways);
				$alguno = 0;
				$alguno_nombre = 0;
				for ($iIndice = 0; $iIndice < count($saVectorExplode);$iIndice++)
				{
					//echo '<br>'.$iIndice.':_'.$saVectorExplode[$iIndice].'_<br>';
					
					$sAuxiliar = $saVectorExplode[$iIndice];
					if (strlen($sAuxiliar)>= 3)
					{
						$sAuxiliarNombre=substr($sAuxiliar,0,3);
						$sAuxiliarValor=substr($sAuxiliar,3);
						$query_aux='';
						
						//echo $sAuxiliarNombre." = ".$sAuxiliarValor."<br>";
						if ($alguno === 1)
						{
							$query.=",";
							$alguno = 0;
						}
						if ($alguno_nombre === 1)
						{
							$query_name.=",";
							$alguno_nombre = 0;
						}
						
						switch ($sAuxiliarNombre)
						{
							case 'NGW':
								$query_aux="gw_nombre='".$sAuxiliarValor."'";
								$query_name.="gw_nombre='".$sAuxiliarValor."'";
								$alguno = 1;
								$alguno_nombre = 1;
								break;
								
							case 'EH1':
							case 'EH2':
							case 'EH3':
							case 'EH4':
							case 'EH5':
							case 'EH6':
							case 'EH7':
							case 'EH8':
							case 'EH9':
								$alguno = 1;
								$query_aux=" gw_EMAIL_enable".substr($sAuxiliarNombre,2,1)."='".$sAuxiliarValor."' ";
								break;
								
							case 'SH1':
							case 'SH2':
							case 'SH3':
							case 'SH4':
							case 'SH5':
							case 'SH6':
							case 'SH7':
							case 'SH8':
							case 'SH9':
								$alguno = 1;
								$query_aux=" gw_SMS_enable".substr($sAuxiliarNombre,2,1)."='".$sAuxiliarValor."' ";
								break;
							case 'M1X':
							case 'M2X':
							case 'M3X':
							case 'M4X':
							case 'M5X':	
							case 'M6X':
							case 'M7X':
							case 'M8X':
							case 'M9X':																										
								$alguno = 1;							
								$query_aux=" gw_A".substr($sAuxiliarNombre,1,1)."MAX='".$sAuxiliarValor."' ";
								break;
							case 'M1N':
							case 'M2N':
							case 'M3N':
							case 'M4N':
							case 'M5N':
							case 'M6N':
							case 'M7N':
							case 'M8N':
							case 'M9N':																																
								$alguno = 1;
								$query_aux=" gw_A".substr($sAuxiliarNombre,1,1)."MIN='".$sAuxiliarValor."' ";
								break;
							case 'U1D':
							case 'U2D':
							case 'U3D':
							case 'U4D':
							case 'U5D':	
							case 'U6D':
							case 'U7D':
							case 'U8D':
							case 'U9D':																											
								$alguno = 1;									
								$query_aux=" gw_A".substr($sAuxiliarNombre,1,1)."UND='".$sAuxiliarValor."' ";
								break;	
							case 'HMR':
								$alguno = 1;
								$query_aux=" gw_reposicion='".$sAuxiliarValor."' ";
								break;	
							case 'SN1':
							case 'SN2':
							case 'SN3':
							case 'SN4':
							case 'SN5':
							case 'SN6':
							case 'SN7':
							case 'SN8':
							case 'SN9':																															
								$query_name.=" gw_nombre_s".substr($sAuxiliarNombre,2,1)."='".$sAuxiliarValor."' ";
								$query_aux=" gw_SN".substr($sAuxiliarNombre,2,1)."='$sAuxiliarValor' ";
								$alguno_nombre = 1;
								$alguno = 1;
								break;	
							case 'VHW':
								$alguno = 1;
								$query_aux=" gw_versionHW='".$sAuxiliarValor."' ";
								break;
							case 'VSW':
								$alguno = 1;
								$query_aux=" gw_versionSW='".$sAuxiliarValor."' ";
								break;
							default:
								$query_aux=" gw_".$sAuxiliarNombre."='".$sAuxiliarValor."'";
								$alguno = 1;
								break;
						}
						$query.=$query_aux;						
					}
				}
				$query .= " WHERE gw_id='".$SuscriptorNuevo."' AND instalacion_id='".$sInstalacionActual."'";
				$query_name .= " WHERE gw_id='".$SuscriptorNuevo."' AND instalacion_id='".$sInstalacionActual."'";
				//echo $query.'----------';
				//echo $query_name.'----------';
				
				mysql_select_db($db_client, $link);
				$result = mysql_query($query,$link);
				if(!$result)
				{
					echo "ERROR7 ";
				}
				else
				{
					$result = mysql_query($query_name,$link);
					if(!$result)
					{
						echo "ERROR8 ";
					}
					else
					{
						echo $SuscriptorNuevo;
					}
				}
			}
		}
	}
	mysql_close($link);

?>
