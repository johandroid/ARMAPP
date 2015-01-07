<?php
	ini_set('memory_limit','200M');
	session_start();
	include 'inc/idiomas.inc';
	include 'inc/datos_db.inc';
	$sTramaLeida=$_POST['paramsGW'];
	$db_client=$_POST['cliente_db'];
	//require_once('FirePHPCore/FirePHP.class.php'); 

	//ob_start();
	//$mifirePHP = FirePHP::getInstance(true); 
	//var_dump($_POST);
	//echo '->'.$sTramaLeida.'<-';
	$sAuxiliar= strtok($sTramaLeida,";");
	if ($sAuxiliar!==false)
	{
		if (strlen($sAuxiliar) > 3)
		{
			$query=sprintf("UPDATE %s SET ",$tabla_name_params_gateways_low);
			$query_name=sprintf("UPDATE %s SET ",$tabla_name_gateways);
	
			$sSUSNombre=substr($sAuxiliar,0,3);
			$sSUSValor=substr($sAuxiliar,3);
			$sAuxiliar=strtok(";");
			$comaAux=0;
			$comaAux_name=0;
			while ($sAuxiliar!==false)
			{					
				$query_aux1='';
				$query_aux2='';	
				if (strlen($sAuxiliar) > 3)
				{
					$sAuxiliarNombre=substr($sAuxiliar,0,3);
					$sAuxiliarValor=substr($sAuxiliar,3);
					//echo $sAuxiliarValor;
					//echo "NOMBRE ".$sAuxiliarNombre;
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
							break;
						case 'A0K':							
						case 'A1K':
						case 'A2K':
						case 'A3K':
						case 'A4K':							
						case 'A5K':
						case 'A6K':
							// if ($comaAux_name == 1)
							// {
								// $query_name.=',';
								// $comaAux_name=0;
								// $mifirePHP -> log('coma');
							// }
							$query_aux1=" gw_".$sAuxiliarNombre."='".$sAuxiliarValor."' ";
							if (intval($sAuxiliarValor)==0)
							{	//$mifirePHP -> log("hola");
								//$mifirePHP -> log("tipo sensor ".(hexdec(substr($sAuxiliarNombre,1,1))+8));
								if($comaAux_name == 1)
									$query_name.=',';								
								$query_aux2=" gw_tipo_sensor".(substr($sAuxiliarNombre,1,1)+1)."='0' ";
								$comaAux_name=1;
							}
							break;							
						case 'D0K':
						case 'D1K':	
						case 'D2K':																													
						case 'D3K':
						case 'D4K':	
						case 'D5K':
						case 'D6K':
						case 'D7K':	
						case 'D8K':																													
						case 'D9K':
						case 'DAK':	
						case 'DBK':
						case 'DCK':	
						case 'DDK':																													
						case 'DEK':
						case 'DFK':
							// if ($comaAux_name == 1)
							// {
								// $query_name.=',';
								// $comaAux_name=0;
								// $mifirePHP -> log('coma');
							// }
							$query_aux1=" gw_".$sAuxiliarNombre."='".$sAuxiliarValor."' ";							
							if (intval($sAuxiliarValor)==0)
							{	//$mifirePHP -> log("hola");
								//$mifirePHP -> log("tipo sensor ".(hexdec(substr($sAuxiliarNombre,1,1))+8));
								if($comaAux_name == 1)
									$query_name.=',';
								$query_aux2=" gw_tipo_sensor".(hexdec(substr($sAuxiliarNombre,1,1))+8)."='0' ";
								$comaAux_name=1;
							}
							break;							
						//Email	
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
							$query_aux1=" gw_EMAIL_enable".$num_sensor."='".$sAuxiliarValor."' ";
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
							$query_aux1=" gw_SMS_enable".$num_sensor."='".$sAuxiliarValor."' ";
							break;
						case 'M0X':
						case 'M1X':
						case 'M2X':								
							$query_aux1=" gw_A".substr($sAuxiliarNombre,1,1)."MAX='".$sAuxiliarValor."' ";
							break;
						case 'M0N':
						case 'M1N':
						case 'M2N':
							$query_aux1=" gw_A".substr($sAuxiliarNombre,1,1)."MIN='".$sAuxiliarValor."' ";
							break;
						case 'U0D':
						case 'U1D':
						case 'U2D':											
							$query_aux1=" gw_A".substr($sAuxiliarNombre,1,1)."UND='".$sAuxiliarValor."' ";
							break;	
						case 'HMR':
							$query_aux1=" gw_reposicion='".$sAuxiliarValor."' ";
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
							if ($comaAux_name == 1)
							{
								$query_name.=',';
								$comaAux_name=0;
							}
							$query_aux2=" gw_nombre_s".($num_sensor+1)."='".$sAuxiliarValor."' ";
							$query_aux1=" gw_SN".$num_sensor."='".$sAuxiliarValor."' ";	
							$comaAux_name=1;
							break;
						default:
							$query_aux1=" gw_".$sAuxiliarNombre."='$sAuxiliarValor' ";
							$query_aux2='';
							break;				
					}
					$comaAux=1;
					$query.=$query_aux1;
					$query_name.=$query_aux2;
				}
				else if(substr($sAuxiliar,0,2) == 'SN')
				{
					$sAuxiliarNombre=substr($sAuxiliar,0,3);
					
					switch ($sAuxiliarNombre) {
						
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
					}				
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
					$query_aux2=" gw_nombre_s".($num_sensor+1)."='' ";
					$query_aux1=" gw_SN".$num_sensor."='' ";					
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
			// y ejecutamos las querys
			$link = mysql_connect($db_host, $db_user, $db_pass);
			mysql_select_db($db_client, $link);
			$result = mysql_query($query,$link);
			if ($result)
			{
				$result = mysql_query($query_name,$link);
				if ($result)
				{
					echo $idiomas[$_SESSION['opcion_idioma']]['general22'];
				}
				else
				{
					echo $idiomas[$_SESSION['opcion_idioma']]['error_gw33']." $sSUSValor ".mysql_error();
				}
			}
			else
			{
				echo $idiomas[$_SESSION['opcion_idioma']]['error_gw33']." $sSUSValor ".mysql_error();
			}
			mysql_close($link);
		}
	}

?>
