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
	
	$query = sprintf("INSERT INTO %s VALUES('','%s','%s','%s',".$tipo_gw_low.")",$tabla_name_suscriptores,$SuscriptorNuevo,$_SESSION['id_cliente'],$sInstalacionActual);
	//echo $query;
	$result = mysql_query($query,$link);
	if(!$result)
	{
		echo "ERROR1 ";
	}
	else
	{
		//echo $SuscriptorNuevo." insertado en Suscriptores";
		 
		// despues lo insertamos en la tabla de gateways del cliente
		mysql_select_db($_SESSION['cliente_db'], $link);
				
		$query = sprintf("INSERT INTO %s (`gw_id`,`instalacion_id`,`gw_nombre`,`gw_onoff`,`gw_estado`,`gw_latitud`,`gw_longitud`,`gw_tipo`) VALUES('%s','%s','%s','0','01','%s','%s',".$tipo_gw_low.")",$tabla_name_gateways,$SuscriptorNuevo,$sInstalacionActual,'Gateway '+$SuscriptorNuevo, $latitud_gw_aux, $longitud_gw_aux);
		//echo $query;
		$result = mysql_query($query,$link);
		if(!$result)
		{
			echo "ERROR2 ";
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
			$query = sprintf("INSERT INTO %s (`gw_id`,`instalacion_id`,`gw_nombre`) VALUES('%s','%s','%s')",$tabla_name_params_gateways_low,$SuscriptorNuevo,$sInstalacionActual,'Gateway '+$SuscriptorNuevo);
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
				
				$query = sprintf("UPDATE %s SET ",$tabla_name_params_gateways_low);
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
								
							case 'EH0':
							case 'EH1':
							case 'EH2':
							case 'EH3':
							case 'EH4':
							case 'EH5':
							case 'EH6':
							case 'EH7':
							case 'EH8':
							case 'EH9':
							case 'EHA':
							case 'EHB':
							case 'EHC':
							case 'EHD':
							case 'EHE':
							case 'EHF':
							case 'EHG':
							case 'EHH':
							case 'EHI':
							case 'EHJ':
							case 'EHK':
							case 'EHL':
							case 'EHM':
								$alguno = 1;
								switch (substr($sAuxiliarNombre,2,1)) 
								{
									case '0':
									case '1':
									case '2':
									case '3':
									case '4':
									case '5':
									case '6':
									case '7':
									case '8':
									case '9':
										$num_sensor = substr($sAuxiliarNombre,2,1);
										break;
									case 'A':
										$num_sensor = 10;
										break;
									case 'B':
										$num_sensor = 11;
										break;
									case 'C':
										$num_sensor = 12;
										break;
									case 'D':
										$num_sensor = 13;
										break;
									case 'E':
										$num_sensor = 14;
										break;
									case 'F':
										$num_sensor = 15;
										break;
									case 'G':
										$num_sensor = 16;
										break;
									case 'H':
										$num_sensor = 17;
										break;
									case 'I':
										$num_sensor = 18;
										break;
									case 'J':
										$num_sensor = 19;
										break;
									case 'K':
										$num_sensor = 20;
										break;
									case 'L':
										$num_sensor = 21;
										break;
									case 'M':
										$num_sensor = 22;
										break;
								}
								$query_aux=" gw_EMAIL_enable".$num_sensor."='".$sAuxiliarValor."' ";
								break;
								
							case 'SH0':
							case 'SH1':
							case 'SH2':
							case 'SH3':
							case 'SH4':
							case 'SH5':
							case 'SH6':
							case 'SH7':
							case 'SH8':
							case 'SH9':
							case 'SHA':
							case 'SHB':
							case 'SHC':
							case 'SHD':
							case 'SHE':
							case 'SHF':
							case 'SHG':
							case 'SHH':
							case 'SHI':
							case 'SHJ':
							case 'SHK':
							case 'SHL':
							case 'SHM':
								$alguno = 1;
								switch (substr($sAuxiliarNombre,2,1)) 
								{
									case '0':
									case '1':
									case '2':
									case '3':
									case '4':
									case '5':
									case '6':
									case '7':
									case '8':
									case '9':
										$num_sensor = substr($sAuxiliarNombre,2,1);
										break;
									case 'A':
										$num_sensor = 10;
										break;
									case 'B':
										$num_sensor = 11;
										break;
									case 'C':
										$num_sensor = 12;
										break;
									case 'D':
										$num_sensor = 13;
										break;
									case 'E':
										$num_sensor = 14;
										break;
									case 'F':
										$num_sensor = 15;
										break;
									case 'G':
										$num_sensor = 16;
										break;
									case 'H':
										$num_sensor = 17;
										break;
									case 'I':
										$num_sensor = 18;
										break;
									case 'J':
										$num_sensor = 19;
										break;
									case 'K':
										$num_sensor = 20;
										break;
									case 'L':
										$num_sensor = 21;
										break;
									case 'M':
										$num_sensor = 22;
										break;
								}
								$query_aux=" gw_SMS_enable".$num_sensor."='".$sAuxiliarValor."' ";
								break;
							case 'M0X':
							case 'M1X':
							case 'M2X':	
								$alguno = 1;							
								$query_aux=" gw_A".substr($sAuxiliarNombre,1,1)."MAX='".$sAuxiliarValor."' ";
								break;
							case 'M0N':
							case 'M1N':
							case 'M2N':
								$alguno = 1;
								$query_aux=" gw_A".substr($sAuxiliarNombre,1,1)."MIN='".$sAuxiliarValor."' ";
								break;
							case 'U0D':
							case 'U1D':
							case 'U2D':		
								$alguno = 1;									
								$query_aux=" gw_A".substr($sAuxiliarNombre,1,1)."UND='".$sAuxiliarValor."' ";
								break;
							case 'HMR':
								$query_aux=" gw_reposicion='".$sAuxiliarValor."' ";
								$alguno = 1;
								break;	
							case 'SN0':
							case 'SN1':
							case 'SN2':
							case 'SN3':
							case 'SN4':
							case 'SN5':
							case 'SN6':
							case 'SN7':
							case 'SN8':
							case 'SN9':
							case 'SNA':
							case 'SNB':
							case 'SNC':
							case 'SND':
							case 'SNE':
							case 'SNF':
							case 'SNG':
							case 'SNH':
							case 'SNI':
							case 'SNJ':
							case 'SNK':
							case 'SNL':
							case 'SNM':
								switch (substr($sAuxiliarNombre,2,1)) 
								{
									case '0':
									case '1':
									case '2':
									case '3':
									case '4':
									case '5':
									case '6':
									case '7':
									case '8':
									case '9':
										$num_sensor = substr($sAuxiliarNombre,2,1);
										break;
									case 'A':
										$num_sensor = 10;
										break;
									case 'B':
										$num_sensor = 11;
										break;
									case 'C':
										$num_sensor = 12;
										break;
									case 'D':
										$num_sensor = 13;
										break;
									case 'E':
										$num_sensor = 14;
										break;
									case 'F':
										$num_sensor = 15;
										break;
									case 'G':
										$num_sensor = 16;
										break;
									case 'H':
										$num_sensor = 17;
										break;
									case 'I':
										$num_sensor = 18;
										break;
									case 'J':
										$num_sensor = 19;
										break;
									case 'K':
										$num_sensor = 20;
										break;
									case 'L':
										$num_sensor = 21;
										break;
									case 'M':
										$num_sensor = 22;
										break;
								}
								$query_aux="gw_SN".$num_sensor."='".$sAuxiliarValor."'";
								$query_name.="gw_nombre_s".($num_sensor+1)."='".$sAuxiliarValor."'";
								$alguno = 1;
								$alguno_nombre = 1;	
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
								$query_aux="gw_".$sAuxiliarNombre."='".$sAuxiliarValor."'";
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
					echo "ERROR7 ".$query;
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
