<?php
	session_start();
	include 'inc/idiomas.inc';
	
	//print_r($_POST['sCadenaXML']);
	//echo '==>'.$_POST['sCadenaXML'];
	
	foreach ($_POST['sCadenaXML'] as $prog) 
	{ 
	    if ($_SESSION['opcion_idioma'] == "")
		{
			$array_salida[$prog] = $idiomas['es'][$prog];
			//echo $idiomas['es'][$prog];
		}
		else if($prog=="idioma")
		{
			$array_salida[$prog] = $_SESSION['opcion_idioma'];
			//echo $_SESSION['opcion_idioma'];
		}	
		else
		{
			$array_salida[$prog] = $idiomas[$_SESSION['opcion_idioma']][$prog];
			//echo $idiomas[$_SESSION['opcion_idioma']][$prog];
		}		 
	} 
	//print_r($array_salida);
	echo json_encode($array_salida);
?>