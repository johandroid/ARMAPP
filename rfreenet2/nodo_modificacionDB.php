<?php
	ini_set('memory_limit','200M');
	session_start();
	include 'inc/idiomas.inc';
	include 'inc/datos_db.inc';
	$sTramaLeida=$_POST['paramsNodo'];
	$db_client=$_POST['cliente_db'];
	//var_dump($_POST);
	//echo '->'.$sTramaLeida.'<-';
	$sAuxiliar= strtok($sTramaLeida,";");
	if ($sAuxiliar!==false)
	{
		if (strlen($sAuxiliar) > 3)
		{
			$sModificaParamsNodo = 0;
			$query=sprintf("UPDATE %s SET ",$tabla_name_params_nodos);
			$query_name=sprintf("UPDATE %s SET ",$tabla_name_nodos);
	
			$sMACNombre=substr($sAuxiliar,0,3);
			$sMACValor=substr($sAuxiliar,3);
			$sAuxiliar=strtok(";");
			$comaAux=0;
			$comaAux_name=0;
			while ($sAuxiliar!==false)
			{		
				$query_aux1='';
				$query_aux2='';	
				if (strlen($sAuxiliar) >= 3)
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
						case 'NNO':
							if ($comaAux_name == 1)
							{
								$query_name.=',';
								$comaAux_name=0;
							}
							$query_aux1=" nodo_nombre='".$sAuxiliarValor."' ";
							$query_aux2=" nodo_nombre='".$sAuxiliarValor."' ";
							$sModificaParamsNodo++;
							$comaAux_name=1;
							break;
							
						case 'SN1':
						case 'SN2':
						case 'SN3':
						case 'SN4':
						case 'SN5':
						case 'SN6':
							if ($comaAux_name == 1)
							{
								$query_name.=',';
								$comaAux_name=0;
							}
							$query_aux1=" nodo_NN".substr($sAuxiliarNombre,2,1)."='".$sAuxiliarValor."' ";
							$query_aux2=" nodo_nombre_s".substr($sAuxiliarNombre,2,1)."='".$sAuxiliarValor."' ";
							$sModificaParamsNodo++;
							$comaAux_name=1;
							break;
							
						case 'SEN':
							if ($comaAux_name == 1)
							{
								$query_name.=',';
								$comaAux_name=0;
							}
							//echo '[[SEN'.$sAuxiliarValor.']]';
							$query_aux1=" nodo_".$sAuxiliarNombre."='".$sAuxiliarValor."' ";
							$iAcum=intval($sAuxiliarValor);
							for ($iInd=0;$iInd<6;$iInd++)
							{
								$iParcial=intval($iAcum/(pow(2,(5-$iInd))));
								$iResto=$iAcum%(pow(2,(5-$iInd)));
								//echo '('.$iAcum.'/'.(pow(2,(5-$iInd))).')';
								//echo '_'.$iParcial.'_';
								//echo '<'.$iResto.'>';
								if ($comaAux_name == 1)
								{
									$query_aux2.=',';
									$comaAux_name=0;
								}								
								if ($iParcial==0)
								{					
									$query_aux2.=" nodo_habilitado_s".(6-$iInd)."='0' ";
								}
								else
								{
									$query_aux2.=" nodo_habilitado_s".(6-$iInd)."='1' ";
								}
								$comaAux_name=1;
								$iAcum=$iResto;
								$sModificaParamsNodo++;
							}
							break;
							
						case 'EH1':
						case 'EH2':
						case 'EH3':
						case 'EH4':
						case 'EH5':
						case 'EH6':
							$query_aux1=" nodo_EMAIL_enable".substr($sAuxiliarNombre,2,1)."='".$sAuxiliarValor."' ";
							break;
							
						case 'SH1':
						case 'SH2':
						case 'SH3':
						case 'SH4':
						case 'SH5':
						case 'SH6':
							$query_aux1=" nodo_SMS_enable".substr($sAuxiliarNombre,2,1)."='".$sAuxiliarValor."' ";
							break;
							
						case 'OP1':
						case 'OP2':
						case 'OP3':
						case 'OP4':
						case 'OP5':
						case 'OP6':
							$query_aux1=" nodo_aux_operacion".substr($sAuxiliarNombre,2,1)."='".$sAuxiliarValor."' ";
							break;
							
						case 'CO1':
						case 'CO2':
						case 'CO3':
						case 'CO4':
						case 'CO5':
						case 'CO6':
							$query_aux1=" nodo_aux_constante".substr($sAuxiliarNombre,2,1)."='".$sAuxiliarValor."' ";
							break;
						
						case 'HMR':
							$query_aux1=" nodo_reposicion='".$sAuxiliarValor."' ";
							break;

						case 'M1X':
						case 'M2X':
						case 'M3X':
						case 'M4X':
						case 'M5X':
						case 'M6X':
							$query_aux1=" nodo_A".substr($sAuxiliarNombre,1,1)."MAX='".$sAuxiliarValor."' ";
							break;
							
						case 'M1N':
						case 'M2N':
						case 'M3N':
						case 'M4N':
						case 'M5N':
						case 'M6N':
							$query_aux1=" nodo_A".substr($sAuxiliarNombre,1,1)."MIN='".$sAuxiliarValor."' ";
							break;

						case 'U1D':
						case 'U2D':
						case 'U3D':
						case 'U4D':
						case 'U5D':		
						case 'U6D':																																	
							$query_aux1=" nodo_A".substr($sAuxiliarNombre,1,1)."UND='".$sAuxiliarValor."' ";
							break;								
																					
						default:
							$query_aux1=" nodo_".$sAuxiliarNombre."='".$sAuxiliarValor."' ";
							$query_aux2='';
							break;				
					}
					$comaAux=1;
					$query.=$query_aux1;
					$query_name.=$query_aux2;
				}
				$sAuxiliar=strtok(";");
			}
			$query_tail=sprintf(" WHERE nodo_mac='%s'",$sMACValor);
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
				if ($sModificaParamsNodo > 0)
				{
					$result = mysql_query($query_name,$link);
				}
				else 
				{
					$result = 1;	
				}
				if ($result)
				{
					echo $idiomas[$_SESSION['opcion_idioma']]['general21']." $sMACValor ".$idiomas[$_SESSION['opcion_idioma']]['general236'];
				}
				else
				{
					echo $idiomas[$_SESSION['opcion_idioma']]['error_nodo19']." $sMACValor";
				}
			}
			else
			{
				echo $idiomas[$_SESSION['opcion_idioma']]['error_nodo19']." $sMACValor";
			}
			mysql_close($link);
		}
	}

?>
