<?php
	ini_set('memory_limit','200M');
	session_start();
	include 'inc/idiomas.inc';
	include 'inc/comunica.inc';
	$comando=$_GET['comando'];

	sleep(2);
	// Enviamos trama de lectura de parametros
	$sTramaLeida=conectar($comando);
	//$SuscriptorTrama=substr($comando,1,4);
	//echo $sTramaLeida."<br>";
	//echo $SuscriptorTrama."<br>";

	if ($sTramaLeida[0] == 'N')
	{
		$xml_lectura=$idiomas[$_SESSION['opcion_idioma']]['general22'];
	}
	else
	{
		//echo "alert('Trama incorrecta');";
		$xml_lectura = $sTramaLeida;
	}
		
	echo $xml_lectura;
?>
