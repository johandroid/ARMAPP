<?php
	ini_set('memory_limit','200M');

	include 'inc/comunica.inc';
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
				$xml_lectura.="<parametro><nombre>$sAuxiliarNombre</nombre><valor>$sAuxiliarValor</valor></parametro>";
				$xml_lectura.="<parametro><nombre>UM".$NumSensor."</nombre><valor>".sConvertir_Datos_Nodo(intval($vectorValoresMAX[$NumSensor]),$sAuxiliarValor,1,'D',0,$SuscriptorTrama,$IPTrama,$NumSensor)."</valor></parametro>";
				$xml_lectura.="<parametro><nombre>UN".$NumSensor."</nombre><valor>".sConvertir_Datos_Nodo(intval($vectorValoresMIN[$NumSensor]),$sAuxiliarValor,1,'D',0,$SuscriptorTrama,$IPTrama,$NumSensor)."</valor></parametro>";
				$xml_lectura.="<parametro><nombre>GM".$NumSensor."</nombre><valor>".sConvertir_Datos_Nodo(intval($vectorValoresGRAD[$NumSensor]),$sAuxiliarValor,1,'G',0,$SuscriptorTrama,$IPTrama,$NumSensor)."</valor></parametro>";
			}
			else
			{
				$xml_lectura.="<parametro><nombre>$sAuxiliarNombre</nombre><valor>$sAuxiliarValor</valor></parametro>";
			}
		}
		$xml_lectura.="</Nodo>";
	}
	else
	{
		//echo "alert('Trama incorrecta');";
		$xml_lectura = $sTramaLeida;
	}
		
	unset($vectorValoresMAX);
	unset($vectorValoresMIN);
	unset($vectorValoresGRAD);
	echo $xml_lectura;
?>
