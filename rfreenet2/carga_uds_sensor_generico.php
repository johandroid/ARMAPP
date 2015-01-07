<?php
	session_start();
	ini_set('memory_limit','200M');
	include 'inc/idiomas.inc';	
	include 'inc/datos_db.inc';
	include 'inc/funciones_aux.inc';
	$link = mysql_connect($db_host, $db_user, $db_pass);
	
	$tipo = $_GET["tipo"];

	mysql_select_db($db_name_general, $link);
	
	$query = sprintf("SELECT cod_unidad,nombre,tipo FROM %s WHERE tipo = 0 OR tipo = %s ORDER BY cod_unidad",$tabla_uds_sensores_genericos, $tipo);

	$result = mysql_query($query,$link);
	if(!$result)
	{
		echo "ERROR";
	}
	else
	{
		while($row = mysql_fetch_array($result))
		{
			
			echo "<option id='".$row['cod_unidad']."' value='".$row['cod_unidad']."' >".$row['nombre']."</option>";
		}
	}
	mysql_free_result($result);
	
	mysql_close($link);
?>
