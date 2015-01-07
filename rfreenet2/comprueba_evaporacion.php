<?php
	session_start();
	include 'inc/idiomas.inc';
	include 'inc/datos_db.inc';
	
	$instalacion_id = $_GET['instalacion_id'];
	$gw_id = $_GET['gw_id'];
	$diario_id=$_GET['diario_id'];
	$fecha = $_GET['fecha'];
	$operador = $_GET['operador'];
	$mensaje = $_GET['mensaje'];
	$link = mysql_connect($db_host, $db_user, $db_pass);
	mysql_select_db($_SESSION['cliente_db'], $link);
	
	if(strstr($_SERVER['HTTP_USER_AGENT'], 'Chrome'))
	{
		$operador = utf8_decode($operador);
		$mensaje = utf8_decode($mensaje);
	}

	 $query = sprintf("SELECT gw_TS1, gw_TS2, gw_TS3, gw_TS4, gw_TS5, gw_TS6, gw_TS7, gw_TS8, gw_TS9, gw_A1UND, gw_A2UND, gw_A3UND, gw_A4UND, gw_A5UND, gw_A6UND, gw_A7UND, gw_A8UND, gw_A9UND
                     FROM %s WHERE instalacion_id='%s' AND gw_id='%s' 
                    
                    AND ((gw_TS1=7 OR gw_TS2=7 OR gw_TS3=7 OR gw_TS4=7 OR gw_TS5=7 OR gw_TS6=7 OR gw_TS7=7 OR gw_TS8=7 OR gw_TS9=7) 
                     OR (((gw_TS1=2 OR (gw_TS1>=21 AND gw_TS1<=26)) AND gw_A1UND=10) OR ((gw_TS2=2 OR (gw_TS2>=21 AND gw_TS2<=26)) AND gw_A2UND=10) 
                       OR ((gw_TS3=2 OR (gw_TS3>=21 AND gw_TS3<=26)) AND gw_A3UND=10) OR ((gw_TS4=2 OR (gw_TS4>=21 AND gw_TS4<=26)) AND gw_A4UND=10) 
                       OR ((gw_TS5=2 OR (gw_TS5>=21 AND gw_TS5<=26)) AND gw_A5UND=10) OR ((gw_TS6=2 OR (gw_TS6>=21 AND gw_TS6<=26)) AND gw_A6UND=10) 
                       OR ((gw_TS7=2 OR (gw_TS7>=21 AND gw_TS7<=26)) AND gw_A7UND=10) OR ((gw_TS8=2 OR (gw_TS8>=21 AND gw_TS8<=26)) AND gw_A8UND=10) 
                       OR ((gw_TS9=2 OR (gw_TS9>=21 AND gw_TS9<=26)) AND gw_A9UND=10)))
                    
                    AND ((gw_TS1=11 OR gw_TS2=11 OR gw_TS3=11 OR gw_TS4=11 OR gw_TS5=11 OR gw_TS6=11 OR gw_TS7=11 OR gw_TS8=11 OR gw_TS9=11) 
                     OR (((gw_TS1=2 OR (gw_TS1>=21 AND gw_TS1<=26)) AND gw_A1UND=7) OR ((gw_TS2=2 OR (gw_TS2>=21 AND gw_TS2<=26)) AND gw_A2UND=7) 
                       OR ((gw_TS3=2 OR (gw_TS3>=21 AND gw_TS3<=26)) AND gw_A3UND=7) OR ((gw_TS4=2 OR (gw_TS4>=21 AND gw_TS4<=26)) AND gw_A4UND=7) 
                       OR ((gw_TS6=2 OR (gw_TS5>=21 AND gw_TS5<=26)) AND gw_A5UND=7) OR ((gw_TS6=2 OR (gw_TS6>=21 AND gw_TS6<=26)) AND gw_A6UND=7) 
                       OR ((gw_TS7=2 OR (gw_TS7>=21 AND gw_TS7<=26)) AND gw_A7UND=7) OR ((gw_TS7=2 OR (gw_TS8>=21 AND gw_TS8<=26)) AND gw_A8UND=7) 
                       OR ((gw_TS9=2 OR (gw_TS9>=21 AND gw_TS9<=26)) AND gw_A9UND=7)))
                    
                	AND (gw_TS1=10 OR gw_TS2=10 OR gw_TS3=10 OR gw_TS4=10 OR gw_TS5=10 OR gw_TS6=10 OR gw_TS7=10 OR gw_TS8=10 OR gw_TS9=10) 
                    
                	AND (gw_TS1=9 OR gw_TS2=9 OR gw_TS3=9 OR gw_TS4=9 OR gw_TS5=9 OR gw_TS6=9 OR gw_TS7=9 OR gw_TS8=9 OR gw_TS9=9) 
                    
                    AND (gw_TS1=8 OR gw_TS2=8 OR gw_TS3=8 OR gw_TS4=8 OR gw_TS5=8 OR gw_TS6=8 OR gw_TS7=8 OR gw_TS8=8 OR gw_TS9=8) 
                    
                    AND (gw_TS1=16 OR gw_TS2=16 OR gw_TS3=16 OR gw_TS4=16 OR gw_TS5=16 OR gw_TS6=16 OR gw_TS7=16 OR gw_TS8=16 OR gw_TS9=16) "
                    , $tabla_name_params_gateways, $instalacion_id, $gw_id);
	//echo $query.'<br>';
	$result = mysql_query($query,$link);
	if(!$result)
	{
		echo "ERROR ";
		echo $query.'<br>';
	}
	else if(mysql_num_rows($result) == 0)
	{
		echo $idiomas[$_SESSION['opcion_idioma']]['error_et11'];
	}


?>