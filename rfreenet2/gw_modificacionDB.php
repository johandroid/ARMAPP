<?php
	ini_set('memory_limit','200M');
	session_start();
	include 'inc/idiomas.inc';
	include 'inc/datos_db.inc';
	$sTramaLeida=$_POST['paramsGW'];
	$db_client=$_POST['cliente_db'];
	$sAuxiliar= strtok($sTramaLeida,";");
	if ($sAuxiliar!==false)
	{
		if (strlen($sAuxiliar) > 3)
		{
			$query=sprintf("UPDATE %s SET ",$tabla_name_params_gateways);
			$query_name=sprintf("UPDATE %s SET ",$tabla_name_gateways);
			$sSUSNombre=substr($sAuxiliar,0,3);
			$sSUSValor=substr($sAuxiliar,3);
			$sAuxiliar=strtok(";");
			$comaAux=0;
			$comaAux_name=0;
			$NombreVacia = 0;
			while ($sAuxiliar!==false)
			{
				$query_aux1='';
				$query_aux2='';	
				if (strlen($sAuxiliar) > 3)
				{
					$sAuxiliarNombre=substr($sAuxiliar,0,3);
					$sAuxiliarValor=substr($sAuxiliar,3);		
					if ($comaAux == 1)
					{
						$query.=',';
						$comaAux=0;
					}
					switch ($sAuxiliarNombre)
					{
						case 'NGW':
							if ($comaAux_name == 1)
							{
								$query_name.=',';
								$comaAux_name=0;
							}
							$query_aux1=" gw_nombre='".$sAuxiliarValor."' ";
							$query_aux2=" gw_nombre='".$sAuxiliarValor."' ";
							$comaAux_name=1;
							$NombreVacia++;
							break;
							
						case 'TS1':
						case 'TS2':
						case 'TS3':
						case 'TS4':
						case 'TS5':
						case 'TS6':
						case 'TS7':
						case 'TS8':
						case 'TS9':
							if ($comaAux_name == 1)
							{
								$query_name.=',';
								$comaAux_name=0;
							}
							$query_aux1=" gw_".$sAuxiliarNombre."='".$sAuxiliarValor."' ";
							if (intval($sAuxiliarValor)==0)
							{
								$query_aux2=" gw_tipo_sensor".substr($sAuxiliarNombre,2,1)."='0' ";
								$comaAux_name=1;
								//$NombreVacia++;
							}
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
							$query_aux1=" gw_EMAIL_enable".substr($sAuxiliarNombre,2,1)."='".$sAuxiliarValor."' ";
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
							$query_aux1=" gw_SMS_enable".substr($sAuxiliarNombre,2,1)."='".$sAuxiliarValor."' ";
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
							$query_aux1=" gw_A".substr($sAuxiliarNombre,1,1)."MAX='".$sAuxiliarValor."' ";
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
							$query_aux1=" gw_A".substr($sAuxiliarNombre,1,1)."MIN='".$sAuxiliarValor."' ";
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
							$query_aux1=" gw_A".substr($sAuxiliarNombre,1,1)."UND='".$sAuxiliarValor."' ";
							break;	
						case 'HMR':
							$query_aux1=" gw_reposicion='".$sAuxiliarValor."' ";
							
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
							if ($comaAux_name == 1)
							{
								$query_name.=',';
								$comaAux_name=0;
							}																																	
							$query_aux2=" gw_nombre_s".substr($sAuxiliarNombre,2,1)."='".$sAuxiliarValor."' ";
							$query_aux1=" gw_SN".substr($sAuxiliarNombre,2,1)."='$sAuxiliarValor' ";
							$comaAux_name=1;
							break;						
						default:
							$query_aux1=" gw_".$sAuxiliarNombre."='$sAuxiliarValor' ";
							$comaAux=1;
							break;				
					}
					$comaAux=1;
					$query.=$query_aux1;
					$query_name.=$query_aux2;
				}
				else if(substr($sAuxiliar,0,2) == 'SN')
				{
					if ($comaAux == 1)
					{
						$query.=',';
						$comaAux=0;
					}
						
					if ($comaAux_name == 1)
					{
						$query_name.=',';
						$comaAux_name=0;
					}																																	
					$query_aux2=" gw_nombre_s".substr($sAuxiliar,2,1)."='' ";
					$query_aux1=" gw_SN".substr($sAuxiliar,2,1)."='' ";
					$comaAux_name=1;
					$comaAux=1;
					$query.=$query_aux1;
					$query_name.=$query_aux2;					
				} 
				$sAuxiliar=strtok(";");
			}
			$query_tail=sprintf(" WHERE gw_id='%s'",$sSUSValor);
			$query.=$query_tail;
			$query_name.=$query_tail;
			//echo $query;
			//echo $query_name;
			
			// y ejecutamos las querys
			$link = mysql_connect($db_host, $db_user, $db_pass);
			mysql_select_db($db_client, $link);
			$result = mysql_query($query,$link);
			if ($result)
			{
				//if ($NombreVacia > 0)
				//{
					$result = mysql_query($query_name,$link);
					if ($result)
					{
						echo $idiomas[$_SESSION['opcion_idioma']]['general22'];
					}
					else
					{
						echo $idiomas[$_SESSION['opcion_idioma']]['error_gw33']." $sSUSValor";
					}
				/*}
				else 
				{
					echo $idiomas[$_SESSION['opcion_idioma']]['general22'];
				}*/
			}
			else
			{
				echo $idiomas[$_SESSION['opcion_idioma']]['error_gw33']." $sSUSValor";
			}
			mysql_close($link);
		}
	}

?>
