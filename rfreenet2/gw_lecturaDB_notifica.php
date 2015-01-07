<?php
	ini_set('memory_limit','200M');
	include 'inc/datos_db.inc';
	include 'inc/funciones_medidas.inc';
	
	$cliente_db = $_GET["cliente_db"];
	$gw_id=$_GET['gw_id'];
	
	$link = mysql_connect($db_host, $db_user, $db_pass);	
	mysql_select_db($cliente_db, $link);
	
	$query = sprintf("SELECT 
					gw_A1MAX, gw_A2MAX, gw_A3MAX, gw_A4MAX, gw_A5MAX, gw_A6MAX, gw_A7MAX, gw_A8MAX, gw_A9MAX,
					gw_A1MIN, gw_A2MIN, gw_A3MIN, gw_A4MIN, gw_A5MIN, gw_A6MIN, gw_A7MIN, gw_A8MIN, gw_A9MIN,
					gw_A1UND, gw_A2UND, gw_A3UND, gw_A4UND, gw_A5UND, gw_A6UND, gw_A7UND, gw_A8UND, gw_A9UND,
					gw_SN1, gw_SN2, gw_SN3, gw_SN4, gw_SN5, gw_SN6, gw_SN7, gw_SN8, gw_SN9, gw_reposicion,
					gw_EMAIL_enable1,gw_EMAIL_enable2,gw_EMAIL_enable3,gw_EMAIL_enable4,gw_EMAIL_enable5,gw_EMAIL_enable6,gw_EMAIL_enable7,gw_EMAIL_enable8,gw_EMAIL_enable9,gw_SMS_enable1,gw_SMS_enable2,gw_SMS_enable3,gw_SMS_enable4,gw_SMS_enable5,gw_SMS_enable6,gw_SMS_enable7,gw_SMS_enable8,gw_SMS_enable9 FROM cliente_params_gw WHERE gw_id='%s'",$gw_id);
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
			echo "<Gateway>";
			echo "<parametro><nombre>HMR</nombre><valor>".$row["gw_reposicion"]."</valor></parametro>";			
			for ($iI=1; $iI<10; $iI++)
			{
				echo "<parametro><nombre>M".$iI."X</nombre><valor>".$row["gw_A".$iI."MAX"]."</valor></parametro>";
				echo "<parametro><nombre>M".$iI."N</nombre><valor>".$row["gw_A".$iI."MIN"]."</valor></parametro>";
				echo "<parametro><nombre>U".$iI."D</nombre><valor>".$row["gw_A".$iI."UND"]."</valor></parametro>";
				echo "<parametro><nombre>EH".$iI."</nombre><valor>".$row["gw_EMAIL_enable".$iI]."</valor></parametro>";
				echo "<parametro><nombre>SH".$iI."</nombre><valor>".$row["gw_SMS_enable".$iI]."</valor></parametro>";
				echo "<parametro><nombre>SN".$iI."</nombre><valor>".$row["gw_SN".$iI]."</valor></parametro>";
			}
			echo "</Gateway>";
		}
		else
		{
			echo "ERROR";
		}
	}
	
	mysql_free_result($result);
	mysql_close($link);			
?>
