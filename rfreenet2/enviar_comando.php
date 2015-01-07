<?php
	ini_set('memory_limit','200M');
	session_start();
	include 'inc/idiomas.inc';
	include 'inc/comunica.inc';
	$comando=$_GET['comando'];

	// Enviamos trama de lectura de parametros
	$sTramaLeida=conectar_noresponse($comando);
	if ($sTramaLeida == "OK")
	{
		sleep(5);
		if (substr($comando,0,1) == "A")
		{
			$comando2="E".substr($comando,1);
		
			// Enviamos trama de lectura de parametros
			$sTramaLeida2=conectar_noresponse($comando2);
			if ($sTramaLeida2 == "OK")
			{
				echo "OK";
			}
			else
			{
				echo $idiomas[$_SESSION['opcion_idioma']]['error_server7'];
			}
		}
		else
		{
			echo "OK";
		}
	}
	else
	{
		echo $idiomas[$_SESSION['opcion_idioma']]['error_server7'];
	}
?>
