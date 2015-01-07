<?php
	ini_set('memory_limit','200M');

	include 'inc/datos_db.inc';
	include 'inc/funciones_medidas.inc';
	$link = mysql_connect($db_host, $db_user, $db_pass);
	$cliente_db = $_GET["cliente_db"];
	$gw_id=$_GET['gw_id'];
	$nodo_mac=$_GET['nodo_mac'];
	
	mysql_select_db($cliente_db, $link);
	
	$query = sprintf("SELECT nodo_EMAIL_enable1,nodo_EMAIL_enable2,nodo_EMAIL_enable3,nodo_EMAIL_enable4,nodo_EMAIL_enable5,nodo_EMAIL_enable6,
							 nodo_SMS_enable1,nodo_SMS_enable2,nodo_SMS_enable3,nodo_SMS_enable4,nodo_SMS_enable5,nodo_SMS_enable6,
							 nodo_aux_operacion1,nodo_aux_operacion2,nodo_aux_operacion3,nodo_aux_operacion4,nodo_aux_operacion5,nodo_aux_operacion6,
							 nodo_aux_constante1,nodo_aux_constante2,nodo_aux_constante3,nodo_aux_constante4,nodo_aux_constante5,nodo_aux_constante6,
							 nodo_A1MAX, nodo_A2MAX, nodo_A3MAX, nodo_A4MAX, nodo_A5MAX, nodo_A6MAX,
							 nodo_A1MIN, nodo_A2MIN, nodo_A3MIN, nodo_A4MIN, nodo_A5MIN, nodo_A6MIN,
							 nodo_A1UND, nodo_A2UND, nodo_A3UND, nodo_A4UND, nodo_A5UND, nodo_A6UND 
					    FROM cliente_params_nodo 
					   WHERE gw_id='%s' AND nodo_mac='%s'",$gw_id,$nodo_mac);
	//echo $query;
	$result = mysql_query($query,$link);
	if(!$result)
	{
		echo "ERROR";
	}
	else
	{
		if($row = mysql_fetch_array($result))
		{
			echo "<Nodo>";	
			for ($iI=1; $iI<7; $iI++)
			{
				echo "<parametro><nombre>EH".$iI."</nombre><valor>".$row["nodo_EMAIL_enable".$iI]."</valor></parametro>";
				echo "<parametro><nombre>SH".$iI."</nombre><valor>".$row["nodo_SMS_enable".$iI]."</valor></parametro>";
				echo "<parametro><nombre>OP".$iI."</nombre><valor>".$row["nodo_aux_operacion".$iI]."</valor></parametro>";
				echo "<parametro><nombre>CO".$iI."</nombre><valor>".$row["nodo_aux_constante".$iI]."</valor></parametro>";
				echo "<parametro><nombre>M".$iI."X</nombre><valor>".$row["nodo_A".$iI."MAX"]."</valor></parametro>";
				echo "<parametro><nombre>M".$iI."N</nombre><valor>".$row["nodo_A".$iI."MIN"]."</valor></parametro>";
				echo "<parametro><nombre>U".$iI."D</nombre><valor>".$row["nodo_A".$iI."UND"]."</valor></parametro>";				
			}
			echo "</Nodo>";
		}
		else
		{
			echo "ERROR";
		}
	}
	
	mysql_free_result($result);
	mysql_close($link);
?>
