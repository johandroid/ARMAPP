<?
include 'inc/datos_db.inc';
$link = mysql_connect($db_host, $db_user, $db_pass);
$instalacion_id = $_GET["instalacion_id"];
$cliente_db = $_GET["cliente_db"];
$gw_id = $_GET["gw_id"];

mysql_select_db($cliente_db, $link);


$query_tipo = sprintf("SELECT gw_tipo FROM %s WHERE gw_id='%s' and instalacion_id='%s' ", $tabla_name_gateways, $gw_id, $instalacion_id);

$result_tipo = mysql_query($query_tipo,$link); 

if($result_tipo)
{
	$row = mysql_fetch_array($result_tipo);
	
	if($row["gw_tipo"] == $tipo_gw)
	{
		$query = sprintf("SELECT gw_TS1, gw_TS2, gw_TS3, gw_TS4, gw_TS5, gw_TS6, gw_TS7, gw_TS8, gw_TS9, gw_A1UND, gw_A2UND, gw_A3UND, gw_A4UND, gw_A5UND, gw_A6UND, gw_A7UND, gw_A8UND, gw_A9UND
                     FROM %s WHERE instalacion_id='%s' AND gw_id='%s' 
                    
                    AND ((gw_TS1=7 OR gw_TS2=7 OR gw_TS3=7 OR gw_TS4=7 OR gw_TS5=7 OR gw_TS6=7 OR gw_TS7=7 OR gw_TS8=7 OR gw_TS9=7) 
                     OR (((gw_TS1=2 OR (gw_TS1>=21 AND gw_TS1<=26)) AND gw_A1UND=10) OR ((gw_TS2=2 OR (gw_TS2>=21 AND gw_TS2<=26))  AND gw_A2UND=10) 
                       OR ((gw_TS3=2 OR (gw_TS3>=21 AND gw_TS3<=26)) AND gw_A3UND=10) OR ((gw_TS4=2 OR (gw_TS4>=21 AND gw_TS4<=26))  AND gw_A4UND=10) 
                       OR ((gw_TS5=2 OR (gw_TS5>=21 AND gw_TS5<=26)) AND gw_A5UND=10) OR ((gw_TS6=2 OR (gw_TS6>=21 AND gw_TS6<=26))  AND gw_A6UND=10) 
                       OR ((gw_TS7=2 OR (gw_TS7>=21 AND gw_TS7<=26)) AND gw_A7UND=10) OR ((gw_TS8=2 OR (gw_TS8>=21 AND gw_TS8<=26))  AND gw_A8UND=10) 
                       OR ((gw_TS9=2 OR (gw_TS9>=21 AND gw_TS9<=26)) AND gw_A9UND=10)))
                    
                    AND ((gw_TS1=11 OR gw_TS2=11 OR gw_TS3=11 OR gw_TS4=11 OR gw_TS5=11 OR gw_TS6=11 OR gw_TS7=11 OR gw_TS8=11 OR gw_TS9=11) 
                     OR (((gw_TS1=2 OR (gw_TS1>=21 AND gw_TS1<=26)) AND gw_A1UND=7) OR ((gw_TS2=2 OR (gw_TS2>=21 AND gw_TS2<=26))  AND gw_A2UND=7) 
                       OR ((gw_TS3=2 OR (gw_TS3>=21 AND gw_TS3<=26))  AND gw_A3UND=7) OR ((gw_TS4=2 OR (gw_TS4>=21 AND gw_TS4<=26))  AND gw_A4UND=7) 
                       OR ((gw_TS5=2 OR (gw_TS5>=21 AND gw_TS5<=26))  AND gw_A5UND=7) OR ((gw_TS6=2 OR (gw_TS6>=21 AND gw_TS6<=26))  AND gw_A6UND=7) 
                       OR ((gw_TS7=2 OR (gw_TS7>=21 AND gw_TS7<=26))  AND gw_A7UND=7) OR ((gw_TS8=2 OR (gw_TS8>=21 AND gw_TS8<=26))  AND gw_A8UND=7) 
                       OR ((gw_TS9=2 OR (gw_TS9>=21 AND gw_TS9<=26))  AND gw_A9UND=7)))
                    
                    AND (gw_TS1=12 OR gw_TS2=12 OR gw_TS3=12 OR gw_TS4=12 OR gw_TS5=12 OR gw_TS6=12 OR gw_TS7=12 OR gw_TS8=12 OR gw_TS9=12) 
                    
                    AND (gw_TS1=9 OR gw_TS2=9 OR gw_TS3=9 OR gw_TS4=9 OR gw_TS5=9 OR gw_TS6=9 OR gw_TS7=9 OR gw_TS8=9 OR gw_TS9=9) 
                    
                    AND (gw_TS1=8 OR gw_TS2=8 OR gw_TS3=8 OR gw_TS4=8 OR gw_TS5=8 OR gw_TS6=8 OR gw_TS7=8 OR gw_TS8=8 OR gw_TS9=8)"
                    , $tabla_name_params_gateways, $instalacion_id, $gw_id);
	}
	else if($row["gw_tipo"] == $tipo_gw_low)
	{
		//GW LOW POWER
		$query = sprintf("SELECT gw_A0K, gw_A1K, gw_A2K, gw_A3K, gw_A4K, gw_A5K, gw_A6K, 
                     gw_D0K, gw_D1K, gw_DCK, gw_DDK, gw_DEK, gw_DFK,
                     gw_A0UND, gw_A1UND, gw_A2UND 
                     FROM %s WHERE instalacion_id='%s' AND gw_id='%s'  
                    
                     AND (gw_A3K=30 OR gw_A4K=30 OR gw_A5K=30 OR gw_A6K=30   
                         OR ((gw_A0K=35 OR gw_A0K=36) AND gw_A0UND=10) 
                         OR ((gw_A1K=35 OR gw_A1K=36) AND gw_A1UND=10) 
                         OR ((gw_A2K=35 OR gw_A2K=36) AND gw_A2UND=10)) 
                    
                     AND (gw_A3K=31 OR gw_A4K=31 OR gw_A5K=31 OR gw_A6K=31   
                         OR ((gw_A0K=35 OR gw_A0K=36) AND gw_A0UND=7) 
                         OR ((gw_A1K=35 OR gw_A1K=36) AND gw_A1UND=7) 
                         OR ((gw_A2K=35 OR gw_A2K=36) AND gw_A2UND=7)) 
                    
                    AND (gw_A3K=32 OR gw_A4K=32 OR gw_A5K=32 OR gw_A6K=32)   
                    
                    AND (gw_D0K=8  OR gw_D1K=8 OR gw_DCK=8 OR gw_DDK=8 OR gw_DEK=8 OR gw_DFK=8)   
                    
                    AND (gw_D0K=34  OR gw_D1K=34 OR gw_DCK=34 OR gw_DDK=34 OR gw_DEK=34 OR gw_DFK=34)"
                    , $tabla_name_params_gateways_low, $instalacion_id, $gw_id);
				
	}
	//echo $query;
	$result = mysql_query($query,$link);
	
	if(!$result)
	{
		echo "NO";
	}
	else
	{
		if(mysql_num_rows($result)>0)
		{
			echo "SI";
		}
		else 
		{
			echo "NO";
		}
	}
	
}
mysql_free_result($result);
mysql_free_result($result_tipo);
mysql_close($link);
?>