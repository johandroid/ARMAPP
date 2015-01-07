<?php
	ini_set('memory_limit','200M');

	include 'inc/comunica.inc';
	include 'inc/funciones_medidas.inc';
	include 'inc/funciones_db.inc';
	$comando=$_GET['comando'];

	// Enviamos trama de lectura de parametros
	$sTramaLeida=conectar($comando);
	$SuscriptorTrama=substr($comando,1,4);
	//echo $sTramaLeida."<br>";
	//echo $SuscriptorTrama."<br>";

	if ($sTramaLeida[0] == 'L')
	{
		// Primero de todo obtenemos la version HW del GW, que se usara en conversiones
		$array_versiones = sObtener_Versiones_GW($SuscriptorTrama, $_SESSION['cliente_db']);
		$caGWVersionHW = $array_versiones[0];
	
		//Una vez con la trama leida, la parseamos en xml
		$xml_lectura="<Gateway>";	
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
		$vectorValoresMAX=array('1','2','3','4','5','6','7','8','9');
		$vectorValoresMIN=array('1','2','3','4','5','6','7','8','9');
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
			if ((substr($sAuxiliarNombre,0,1) == 'P') && (substr($sAuxiliarNombre,2,1) == 'N'))
			{
				$vectorValoresMIN[substr($sAuxiliarNombre,1,1)]=$sAuxiliarValor;
			}
			else if ((substr($sAuxiliarNombre,0,1) == 'P') && (substr($sAuxiliarNombre,2,1) == 'X') && (substr($sAuxiliarNombre,1,1) != 'R'))
			{
				$vectorValoresMAX[substr($sAuxiliarNombre,1,1)]=$sAuxiliarValor;
			}
			else if ((substr($sAuxiliarNombre,0,1) == 'T') && (substr($sAuxiliarNombre,1,1) == 'S'))
			{
				$NumSensor=substr($sAuxiliarNombre,2,1);
				$xml_lectura.="<parametro><nombre>$sAuxiliarNombre</nombre><valor>$sAuxiliarValor</valor></parametro>";
				if ($vectorValoresTE[$NumSensor] < 1)
				{
					$vectorValoresTE[$NumSensor] = 1;
				}
				if((intval($sAuxiliarValor) >= 3 && intval($sAuxiliarValor) <= 6) || (intval($sAuxiliarValor) >= 17 && intval($sAuxiliarValor) <= 20)){ //AMB Las entradas digitales no convierten los umbrales, la función no sirve pq se convierten para otro fin 
					$xml_lectura.="<parametro><nombre>P".$NumSensor."X</nombre><valor>".intval($vectorValoresMAX[$NumSensor])."</valor></parametro>";
					$xml_lectura.="<parametro><nombre>P".$NumSensor."N</nombre><valor>".intval($vectorValoresMIN[$NumSensor])."</valor></parametro>";
				}
				else {
					$xml_lectura.="<parametro><nombre>P".$NumSensor."X</nombre><valor>".sConvertir_Datos_GW(intval($vectorValoresMAX[$NumSensor]), $sAuxiliarValor, 1, $SuscriptorTrama, $NumSensor-1, 0, $caGWVersionHW)."</valor></parametro>";
					$xml_lectura.="<parametro><nombre>P".$NumSensor."N</nombre><valor>".sConvertir_Datos_GW(intval($vectorValoresMIN[$NumSensor]), $sAuxiliarValor, 1, $SuscriptorTrama, $NumSensor-1, 0, $caGWVersionHW)."</valor></parametro>";			
				}				
				
			}
			else
			{
				$xml_lectura.="<parametro><nombre>$sAuxiliarNombre</nombre><valor>$sAuxiliarValor</valor></parametro>";
			}
		}
		//sleep(2);
		// Enviamos trama de lectura de parametros
		$sTramaNombre=conectar('P'.$SuscriptorTrama);
		//echo '<br>'.$sTramaNombre.'<br>';
		if ($sTramaNombre[0] == 'P')
		{
			$sAuxiliarValor=substr($sTramaNombre,5);
			//echo '<br>'.$sAuxiliarValor.'<br>';
			$sAuxiliar='';
			$iContador=0;
			while(($iContador<strlen($sAuxiliarValor)) && ($sAuxiliarValor[$iContador]!=';'))
			{
				$sAuxiliar.=$sAuxiliarValor[$iContador];
				$iContador++;
			}
			if (($iContador>0)&&($iContador<strlen($sAuxiliarValor)))
			{
				$xml_lectura.="<parametro><nombre>NGW</nombre><valor>$sAuxiliar</valor></parametro>";
			}
			//$sAuxiliar= strtok($sAuxiliarValor,";");
			//echo '<br>Trama '.$iContador.': '.$sAuxiliar.'<br>';			
			
			
			$xml_lectura.="</Gateway>";
		}
		else
		{
			$xml_lectura = $sTramaNombre;	
		}
	}
	else
	{
		//echo "alert('Trama incorrecta');";
		$xml_lectura = $sTramaLeida;
	}
		
	unset($vectorValoresMAX);
	unset($vectorValoresMIN);

	echo $xml_lectura;
?>
