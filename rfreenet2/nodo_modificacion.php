<?php
	ini_set('memory_limit','200M');
	set_time_limit(180);
	session_start();
	include 'inc/idiomas.inc';
	include 'inc/comunica.inc';
	$comando=$_GET['comando'];
	
	sleep(5);
	
	// Ahora debemos parsear la trama y montar tramas de modificacion de como mucho 48 chars
	$xml_lectura='';
	$sFin=0;
	$NumTrama=0;

	$sParametro = strtok($comando,";");
	$sPrincipio = $sParametro;
	$sParametro = strtok(";");
	//echo $sPrincipio.'<br>';
	
	while (($sFin==0) && ($xml_lectura==''))
	{
		$trama_actual=$sPrincipio;
		//echo 'Longitud init='.(strlen($sSubcadena)+strlen($sPrincipio)).'<br>';
		while ((strlen($trama_actual)+strlen($sParametro)) < 48)
		{
			if (strlen($sParametro)>0)
			{
				//echo $Parametro.'<br>';
				$trama_actual.=$sParametro;
				//echo $trama_actual.'<br>';
				$sParametro = strtok(";");
			}
			else
			{
				//echo 'YATA '.$NumTrama.'<br>';				
				$NumTrama++;
				break;
			}
		}
		sleep(2);
		//echo 'Longitud send='.(strlen($trama_actual)).'<br>';
		//echo $NumTrama.'- '.$trama_actual.'<br>';
		// Enviamos trama de modificacion
		$sTramaLeida=conectar($trama_actual);
		//echo $sTramaLeida."<br>";
		if (($sTramaLeida == 'ERROR') || ($sTramaLeida == 'Timeout'))
		{
			$xml_lectura = $sTramaLeida;
		}
		else if ($sTramaLeida[0] != 'M')
		{
			//echo "alert('Trama incorrecta');";
			$xml_lectura = $sTramaLeida;
			$sFin=1;
		}
		else if (strlen($sParametro)==0)
		{
			//echo 'Fin en '.$NumTrama.'<br>';
			$xml_lectura=$idiomas[$_SESSION['opcion_idioma']]['general22'];
			$sFin=1;
		}
		else
		{
			//echo 'For next...<br>';
			sleep(10);			
		}
	}
	set_time_limit(60);
	echo $xml_lectura;
?>
