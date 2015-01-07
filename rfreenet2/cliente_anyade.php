<?
session_start();
include 'inc/idiomas.inc';
include 'inc/datos_db.inc';
include 'inc/funciones_db.inc';
$cliente_id = $_GET["cliente_id"];
$cliente_nombre = $_GET["cliente_nombre"];
$cliente_direccion = $_GET["cliente_direccion"];
$cliente_localidad = $_GET["cliente_localidad"];
$cliente_provincia = $_GET["cliente_provincia"];
$cliente_telefono = $_GET["cliente_telefono"];
$cliente_contacto = $_GET["cliente_contacto"];
$cliente_email = $_GET["cliente_email"];
$cliente_web = $_GET["cliente_web"];

$usuario_nombre = $_GET["usuario_nombre"];
$usuario_pw = $_GET["usuario_pw"];
$usuario_perfil = $_GET["usuario_perfil"];
$usuario_email = $_GET["usuario_email"];

$cliente_email_comercial1 = $_GET["cliente_email_comercial1"];
$cliente_email1_on = $_GET["cliente_email1_on"];
$cliente_email1_idioma = $_GET["cliente_email1_idioma"];
$cliente_email2_on = $_GET["cliente_email2_on"];
$cliente_email_comercial2 = $_GET["cliente_email_comercial2"];
$cliente_email2_idioma = $_GET["cliente_email2_idioma"];
$cliente_evento_nodo_off = $_GET["cliente_evento_nodo_off"];
$cliente_evento_gw_off = $_GET["cliente_evento_gw_off"];
$cliente_evento_utc_off = $_GET["cliente_evento_utc_off"];
$cliente_evento_nodo_bat = $_GET["cliente_evento_nodo_bat"];
$cliente_evento_gw_bat = $_GET["cliente_evento_gw_bat"];
$cliente_evento_nodo_cob = $_GET["cliente_evento_nodo_cob"];

$cliente_id_nuevo = sObtener_Nuevo_ID_Cliente();

$link = mysql_connect($db_host, $db_user, $db_pass);
mysql_select_db($db_name_clientes, $link);

$query = sprintf("SELECT cliente_id FROM clientes_datos WHERE cliente_nombre='%s'", $cliente_nombre);
//echo $query;
$result = mysql_query($query,$link);
if (!$result)
{
	echo $idiomas[$_SESSION['opcion_idioma']]['error_acceso_db'];
}
else
{
	if($row = mysql_fetch_array($result))
	{
		echo "    ".$idiomas[$_SESSION['opcion_idioma']]['general165']." ".$cliente_nombre."\r\n     ".$idiomas[$_SESSION['opcion_idioma']]['general162'].".";
	}
	else
	{	
		mysql_free_result($result);
			
		$query = sprintf("SELECT usuario_id FROM clientes_usuarios WHERE usuario_nombre='%s'", $usuario_nombre);
		//echo $query;
		$result = mysql_query($query,$link);
		if (!$result)
		{
			echo $idiomas[$_SESSION['opcion_idioma']]['error_acceso_db'];
		}
		else
		{
			if($row = mysql_fetch_array($result))
			{
				echo "    ".$idiomas[$_SESSION['opcion_idioma']]['general161']." ".$usuario_nombre."\r\n     ".$idiomas[$_SESSION['opcion_idioma']]['general162'].".";
			}
			else
			{
				$query = sprintf("INSERT INTO clientes_usuarios VALUES ('','%s','%s',MD5('%s'),'%s','%s')", $cliente_id_nuevo, $usuario_nombre, $usuario_pw, $usuario_perfil, $usuario_email);
				//echo $query;
				$result = mysql_query($query,$link);
				if ($result)
				{
					//echo $cliente_id_nuevo.'<br>';
					if ($cliente_id_nuevo!='ERROR')
					{	
						$nueva_db="cliente_".$cliente_nombre;		
						$query2 = sprintf("INSERT INTO clientes_datos (`cliente_id`,`cliente_db`,`cliente_nombre`,`cliente_direccion`,`cliente_localidad`,`cliente_provincia`,`cliente_telefono`,`cliente_contacto`,`cliente_email`,`cliente_web`,`cliente_email_ventas1_on`,`cliente_email_ventas1`,`cliente_email_ventas1_idioma`,`cliente_email_ventas2_on`,`cliente_email_ventas2`,`cliente_email_ventas2_idioma`,`cliente_notificacion_gwoff`,`cliente_notificacion_utroff`,`cliente_notificacion_utcoff`,`cliente_notificacion_gwbat`,`cliente_notificacion_utrbat`,`cliente_notificacion_utrcob`) VALUES ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')", $cliente_id_nuevo, $nueva_db, $cliente_nombre, $cliente_direccion, $cliente_localidad,$cliente_provincia, $cliente_telefono,$cliente_contacto,$cliente_email,$cliente_web,$cliente_email1_on,$cliente_email_comercial1,$cliente_email1_idioma,$cliente_email2_on,$cliente_email_comercial2,$cliente_email2_idioma,$cliente_evento_gw_off,$cliente_evento_nodo_off,$cliente_evento_utc_off,$cliente_evento_gw_bat,$cliente_evento_nodo_bat,$cliente_evento_nodo_cob);
						//echo '<br>'.$query2.'<br>';
						$result2 = mysql_query($query2,$link) or die(mysql_error($link)."<br>");
						if ($result2)
						{
							$query3 = sprintf("CREATE DATABASE cliente_%s", $cliente_nombre);
							//echo '<br>'.$query3.'<br>';
							$result3 = mysql_query($query3,$link) or die(mysql_error($link)."<br>");
							if ($result3)
							{					
								mysql_select_db($nueva_db, $link);
								//echo '<br>'.$nueva_db.'<br>';
								// Y ahora volcamos la estructura completa
								$comando_dump=sprintf("mysql -h%s -u%s -p%s %s < %s", $db_host, $db_user, $db_pass,$nueva_db,$fichero_base_cliente);
								//echo '<br>'.$comando_dump.'<br>';
								
								system($comando_dump);
								echo $idiomas[$_SESSION['opcion_idioma']]['general1']." ".$cliente_nombre." ".$idiomas[$_SESSION['opcion_idioma']]['general163']." ".$usuario_nombre;
							}
							else
							{
								echo $idiomas[$_SESSION['opcion_idioma']]['general164']." ".$cliente_nombre;
							}
						}
						else
						{
							echo $idiomas[$_SESSION['opcion_idioma']]['general164']." ".$cliente_nombre;
						}
					}
					else
					{
						echo $idiomas[$_SESSION['opcion_idioma']]['general164']." ".$cliente_nombre;
					}		
				}
				else
				{
					echo $idiomas[$_SESSION['opcion_idioma']]['general165']." ".$usuario_nombre;
				}
			}
		}
	}
}
mysql_close($link);
?>