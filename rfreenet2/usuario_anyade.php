<?
session_start();
include 'inc/datos_db.inc';
include 'inc/idiomas.inc';
$link = mysql_connect($db_host, $db_user, $db_pass);
$cliente_id = $_GET["cliente_id"];
$usuario_nombre = $_GET["usuario_nombre"];
$usuario_pw = $_GET["usuario_pw"];
$usuario_perfil = $_GET["usuario_perfil"];
$usuario_email = $_GET["usuario_email"];

mysql_select_db($db_name_clientes, $link);

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
		echo "    ".$idiomas[$_SESSION['opcion_idioma']]['general161']." ".$usuario_nombre.".\r\n     ".$idiomas[$_SESSION['opcion_idioma']]['general162'].".";
	}
	else
	{
		$query = sprintf("INSERT INTO clientes_usuarios VALUES ('','%s','%s',MD5('%s'),'%s','%s')", $cliente_id, $usuario_nombre, $usuario_pw, $usuario_perfil, $usuario_email);
		//echo $query;
		$result = mysql_query($query,$link);
		if ($result)
		{
			echo $idiomas[$_SESSION['opcion_idioma']]['general32']." ".$usuario_nombre." ".$idiomas[$_SESSION['opcion_idioma']]['general232'];
		}
		else
		{
			echo $idiomas[$_SESSION['opcion_idioma']]['general167']." ".$usuario_nombre;
		}
	}
}

mysql_close($link);
?>