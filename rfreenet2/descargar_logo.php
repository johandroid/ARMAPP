<?php
session_start();
include 'inc/datos_db.inc';

$id_cliente = $_GET['id_cliente'];

$link = mysql_connect($db_host, $db_user, $db_pass);

mysql_select_db($db_name_clientes, $link);

$query = sprintf("SELECT cliente_logo FROM clientes_datos WHERE cliente_id='".$id_cliente."'");
//echo $query;
$result = mysql_query($query,$link);
header("Content-type: image/jpeg");
if(!$result)
{
	if($_GET['inicio'] == 'si')
	{
		if($_SERVER["SERVER_NAME"]==$url_hanna)
		{
			$fh = file_get_contents('images/hanna_logo.jpg');
		}
		else
		{
			$fh = file_get_contents('images/logo.jpg');
		}
		
	}
	else 
	{
		$fh = file_get_contents('images/sin_imagen.jpg');
	}
	//echo "ERROR de conexion con la Base de Datos";
	
	echo $fh;
}
else
{
	if($row = mysql_fetch_array($result))
	{        
		if(strlen($row['cliente_logo']) > 0)
		{
			//echo 'pipo';
    	    echo $row['cliente_logo'];
		}
		else
		{
			//echo "ERROR de conexion con la Base de Datos";
			if($_GET['inicio'] == 'si')
			{
				if($_SERVER["SERVER_NAME"]==$url_hanna)
				{
					$fh = file_get_contents('images/hanna_logo.jpg');
				}
				else
				{
					$fh = file_get_contents('images/logo.jpg');
				}
			}
			else 
			{
				$fh = file_get_contents('images/sin_imagen.jpg');
			}
			echo $fh;
		}
	}
	else
	{
		//echo "ERROR de conexion con la Base de Datos";
		$fh = file_get_contents('images/sin_imagen.jpg');
		echo $fh;
	}
	mysql_free_result($result);
}
mysql_close($link);
?>