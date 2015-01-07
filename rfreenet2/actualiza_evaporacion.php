<?php
	session_start();

	include 'inc/datos_db.inc';
	
	$instalacion_id = $_POST['instalacion_id'];
	
	$link = mysql_connect($db_host, $db_user, $db_pass);
	mysql_select_db($_POST['cliente_db'], $link);
	
	$query = "SELECT gw_id
			FROM cliente_gateways 		  			  
		   WHERE cliente_gateways.instalacion_id='".$instalacion_id."' ORDER BY gw_id ASC";		   

	$result = mysql_query($query,$link) or die('ERROR:'.mysql_error()."<br>".$query);	
	
	$itotal = mysql_num_rows($result);
	
	for($iI = 0; $iI < $itotal; $iI++)
	{
		//echo $_GET["gw_id".$iI];		
		//echo mysql_num_rows($result);
		//echo $_POST["etcero".$iI];
		
		if($_POST["etcero".$iI] == 'on')
		{
			$etcero = 1;
		}
		else 
		{
			$etcero = 0;
		}
		
		$query = sprintf("UPDATE cliente_gateways set  gw_etpotencial =".$etcero." WHERE gw_id='".$_POST["gw_id".$iI]."' and instalacion_id='".$instalacion_id."'");
		//echo $query;
		$result_et = mysql_query($query,$link);
		
		if(!$result_et)
		{
			echo "ERROR EN LA ACTUALIZACION DEL GW ".$_POST["gw_id".$iI]." ".$query;
		}
	
		if ($query != "")
		{			
			mysql_free_result($result);
			mysql_free_result($result_et);
		}			
	}	

	mysql_close($link);

?>