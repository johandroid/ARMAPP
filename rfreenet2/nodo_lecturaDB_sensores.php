<?php
	session_start();
	ini_set('memory_limit','200M');
	include 'inc/idiomas.inc';	
	include 'inc/datos_db.inc';
	include 'inc/funciones_aux.inc';
	$link = mysql_connect($db_host, $db_user, $db_pass);
	$cliente_db = $_GET["cliente_db"];
	$nodo_mac=$_GET['nodo_mac'];
	$iTodos=$_GET['iTodosEnable'];
	
	mysql_select_db($cliente_db, $link);
	
	if ($iTodos == 0)
	{
		echo "<option id='X'>".$idiomas[$_SESSION['opcion_idioma']]['general111']."</option>";
	}
	
	$query = sprintf("SELECT nodo_mac,nodo_SEN,nodo_NN1,nodo_NN2,nodo_NN3,nodo_NN4,nodo_NN5,nodo_NN6 FROM %s",$tabla_name_params_nodos);
	if ($nodo_mac!='000')
	{
		$query .= " WHERE ";

		if ($nodo_mac!='000')
		{
			$query .= sprintf(" nodo_mac='%s'",$nodo_mac);
		}
	
		echo $query;
		$result = mysql_query($query,$link);
		if(!$result)
		{
			echo "ERROR";
		}
		else
		{
			
			if($row = mysql_fetch_array($result))
			{
				$iAcum=intval($row['nodo_SEN']);
				//echo "_".$iAcum."_";
				for ($iInd=0;$iInd<6;$iInd++)
				{
					$iNumSensATemporal=dechex(5-$iInd);
					$iParcial=intval($iAcum/(pow(2,(5-$iInd))));
					$iResto=$iAcum%(pow(2,(5-$iInd)));
					//echo '('.$iAcum.'/'.(pow(2,(5-$iInd))).')';
					//echo '_'.$iParcial.'_';
					//echo '<'.$iResto.'>';
					$NumSensTemp = sConvertirCharSensor(5-$iInd+1);
								
					if ($iParcial!=0)
					{
						if ($row['nodo_NN'.$NumSensTemp] != '')
						{
							$saVectorSensores[5-$iInd] = "<option id='".$NumSensTemp."'>".$row['nodo_NN'.$NumSensTemp]."</option>";
						}
						else
						{
							$saVectorSensores[5-$iInd] = "<option id='".$NumSensTemp."'>".$idiomas[$_SESSION['opcion_idioma']]['general102']." ".(5-$iInd+1)."</option>";
						}
					}
					else
					{
						$saVectorSensores[5-$iInd] = '';
					}
					$iAcum=$iResto;
				}
				
				for ($iInd=0;$iInd<6;$iInd++)
				{
					echo $saVectorSensores[$iInd];
				}
			}
		}
		mysql_free_result($result);
	}
	mysql_close($link);
?>
