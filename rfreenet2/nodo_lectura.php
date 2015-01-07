<?php
	ini_set('memory_limit','200M');

	include 'inc/comunica.inc';
	include 'inc/datos_db.inc';
	include 'inc/funciones_medidas.inc';
	$comando=$_GET['comando'];

	// Enviamos trama de lectura de parametros
	$sTramaLeida=conectar($comando);
	$SuscriptorTrama=substr($comando,1,4);
	$IPTrama=substr($comando,6,3);
	//echo $sTramaLeida."<br>";
	//echo $SuscriptorTrama."<br>";
	//echo $IPTrama."<br>";

	if (($sTramaLeida[0] == 'L') && ($sTramaLeida[5] == 'D'))
	{
		//Una vez con la trama leida, la parseamos en xml
		$xml_lectura="<Nodo>";	
		$sAuxiliar= strtok($sTramaLeida,";");
		if ($sAuxiliar!==false)
		{			
			$sAuxiliar=strtok(";");
			if ($sAuxiliar==false)
			{
				$FinTrama=1;
			}
		}
		else
		{
			$FinTrama=1;	
		}
		$FinTrama=0;
		$vectorValoresMAX=array('1','2','3','4','5','6');
		$vectorValoresMIN=array('1','2','3','4','5','6');
		$vectorValoresGRAD=array('1','2','3','4','5','6');
		$link = mysql_connect($db_host, $db_user, $db_pass);
		mysql_select_db($db_client, $link);
		
		while ($FinTrama===0)
		{
			$sAuxiliarNombre=$sAuxiliar;
			$sAuxiliar=strtok(";");
			$sAuxiliarValor=$sAuxiliar;
			if ($sAuxiliar===false)
			{
				//echo "Valor mal<br>";
				$FinTrama=1;
				continue;
			}
			$sAuxiliar=strtok(";");			
			if ($sAuxiliar===false)
			{
				//echo "Valor mal 2<br>";
				$FinTrama=1;
			}
			
			if ((substr($sAuxiliarNombre,0,1) == 'U') && (substr($sAuxiliarNombre,1,1) == 'N'))
			{
				$vectorValoresMIN[substr($sAuxiliarNombre,2,1)]=$sAuxiliarValor;
			}
			else if ((substr($sAuxiliarNombre,0,1) == 'U') && (substr($sAuxiliarNombre,1,1) == 'M'))
			{
				$vectorValoresMAX[substr($sAuxiliarNombre,2,1)]=$sAuxiliarValor;				
			}
			else if ((substr($sAuxiliarNombre,0,1) == 'G') && (substr($sAuxiliarNombre,1,1) == 'M'))
			{
				$vectorValoresGRAD[substr($sAuxiliarNombre,2,1)]=$sAuxiliarValor;
			}
			else if ((substr($sAuxiliarNombre,0,1) == 'T') && (substr($sAuxiliarNombre,1,1) == 'S'))
			{
				$NumSensor=substr($sAuxiliarNombre,2,1);
				if((substr($sAuxiliarValor,0,1)=='C') || (substr($sAuxiliarValor,0,1)=='c'))
				{
					$query = sprintf("SELECT nodo_aux_operacion%u as constante,nodo_aux_constante%u as operacion from cliente_params_nodo where gw_id='%s' AND nodo_ip='%s'",$NumSensor,$NumSensor,$SuscriptorTrama,$IPTrama);
					$result = mysql_query($query,$link);
					if ($result)
					{
						$constante = $row['constante'];
						$operacion = $row['operacion'];
						mysql_free_result($result);
					}
					else
					{
						$constante = 1;
						$operacion = 0;
					}
					
				}
				else
				{
					$constante = 1;
					$operacion = 0;
				}
				$xml_lectura.="<parametro><nombre>$sAuxiliarNombre</nombre><valor>$sAuxiliarValor</valor></parametro>";
				$xml_lectura.="<parametro><nombre>UM".$NumSensor."</nombre><valor>".sConvertir_Datos_Nodo(intval($vectorValoresMAX[$NumSensor]),$sAuxiliarValor,1,'D',0,$constante,$operacion,$SuscriptorTrama,$IPTrama,$NumSensor)."</valor></parametro>";
				$xml_lectura.="<parametro><nombre>UN".$NumSensor."</nombre><valor>".sConvertir_Datos_Nodo(intval($vectorValoresMIN[$NumSensor]),$sAuxiliarValor,1,'D',0,$constante,$operacion,$SuscriptorTrama,$IPTrama,$NumSensor)."</valor></parametro>";
				$xml_lectura.="<parametro><nombre>GM".$NumSensor."</nombre><valor>".sConvertir_Datos_Nodo(intval($vectorValoresGRAD[$NumSensor]),$sAuxiliarValor,1,'G',0,$constante,$operacion,$SuscriptorTrama,$IPTrama,$NumSensor)."</valor></parametro>";
			}
			else
			{
				$xml_lectura.="<parametro><nombre>$sAuxiliarNombre</nombre><valor>$sAuxiliarValor</valor></parametro>";
			}
		}
		//sleep(5);
		// Enviamos trama de lectura de nombre
		$sTramaNombre=conectar('P'.$SuscriptorTrama.'N'.$IPTrama);
		//echo $sTramaNombre;
		if ($sTramaNombre[0] == 'P')
		{
			//echo $sTramaNombre.'<br>';
			$sAuxiliar=substr($sTramaNombre,9);
			$iIndiceAux = 0;
			$sAuxiliarValor='';
			while ($sAuxiliar[$iIndiceAux] !== ';')
			{
				$sAuxiliarValor .= $sAuxiliar[$iIndiceAux];
				$iIndiceAux++;
			}
			//echo '<br>Nombre Nodo:_'.$sAuxiliarValor.'_<br>';
			$xml_lectura.="<parametro><nombre>NNO</nombre><valor>$sAuxiliarValor</valor></parametro>";			
			//$sAuxiliar= strtok($sTramaNombre,";");
			$saVectorExplode=explode(";",$sTramaNombre);
			//echo '<br>0:_'.$saVectorExplode[0].'_<br>';
			
			for ($iIndiceSensor = 1; $iIndiceSensor<7;$iIndiceSensor++)
			{
				//echo '<br>'.$iIndiceSensor.':_'.$saVectorExplode[$iIndiceSensor].'_<br>';
				$sAuxiliar = $saVectorExplode[$iIndiceSensor];
				
				if ($iIndiceSensor == 1)
				{
					if (strlen($sAuxiliar)>7)
					{
						//$xml_lectura.="<parametro><nombre>TS$iIndiceSensor</nombre><valor>$sAuxiliar[4]$sAuxiliar[5]$sAuxiliar[6]</valor></parametro>";
						$sAuxiliarValor=substr($sAuxiliar,7);
						$xml_lectura.="<parametro><nombre>SN$iIndiceSensor</nombre><valor>$sAuxiliarValor</valor></parametro>";
					}
				}
				else
				{
					if (strlen($sAuxiliar)>3)
					{
						//$xml_lectura.="<parametro><nombre>TS$iIndiceSensor</nombre><valor>$sAuxiliar[0]$sAuxiliar[1]$sAuxiliar[2]</valor></parametro>";
						$sAuxiliarValor=substr($sAuxiliar,3);
						$xml_lectura.="<parametro><nombre>SN$iIndiceSensor</nombre><valor>$sAuxiliarValor</valor></parametro>";
					}
				}
			}
		}
		$xml_lectura.="</Nodo>";
	}
	else
	{
		//echo "alert('Trama incorrecta');";
		$xml_lectura = $sTramaLeida;
	}
	mysql_close($link);
	unset($vectorValoresMAX);
	unset($vectorValoresMIN);
	unset($vectorValoresGRAD);
	echo $xml_lectura;
?>
