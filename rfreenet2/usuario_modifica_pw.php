<?
session_start();
include 'inc/datos_db.inc';
include 'inc/idiomas.inc';
$link = mysql_connect($db_host, $db_user, $db_pass);
$usuario_id = $_GET["usuario_id"];
$usuario_nombre = $_GET["usuario_nombre"];
$usuario_pw = $_GET["usuario_pw"];
$usuario_perfil = $_GET["usuario_perfil"];

mysql_select_db($db_name_clientes, $link);

$query = sprintf("UPDATE clientes_usuarios SET usuario_password=MD5('%s') where usuario_id='%s'", $usuario_pw, $_SESSION['id_usuario']);
//echo $query;
$result = mysql_query($query,$link);
if ($result)
{
	echo $idiomas[$_SESSION['opcion_idioma']]['login_text6'];
}
else
{
	echo $idiomas[$_SESSION['opcion_idioma']]['error_login2'];
}
mysql_close($link);
?>