<?  session_start();
	include 'inc/idiomas.inc';
	include 'inc/datos_db.inc';
	include 'inc/funciones_indice.inc';
	$nombre=$_POST['usuario'];
	$password=$_POST['pass'];
	$_SESSION['autentificado_rf2'] = 0;
include 'inc/datos_db.inc';
if ($_POST["logout"])
{
	session_unset(); //liberamos las variables
	session_destroy(); //nos cargamos la sesion por si acaso
}
if ($_POST["movil"])
{
	$link = mysql_connect($db_host, $db_user, $db_pass);
	mysql_select_db($db_name_clientes, $link);
	$query = "SELECT * from clientes_usuarios where usuario_nombre='".$_POST['usuario']."'";
	$result = mysql_query($query,$link);
	$usuario = null;
	$pass = null;
	if ($result)
	{
		if($row=mysql_fetch_array($result))
		{
			$pass= $row['usuario_password'];
			$usuario = $row['usuario_nombre'];
			if($pass == md5($_POST['pass']))
			{
	 			$_SESSION['autentificado_rf2']= 1;				
				$_SESSION['usuario']= $_POST['usuario'];
				$_SESSION['id_usuario']= $row['usuario_id'];
				$_SESSION['perfil']= $row['usuario_perfil'];
				$_SESSION['id_cliente']= $row['cliente_id'];
				$_SESSION['opcion_idioma']=$_POST['idioma_sesion'];
				if (hexdec($_SESSION['id_cliente']) > 0)
				{
					// Y extraemos el resto de info importante del cliente
					$query = "SELECT * from clientes_datos where cliente_id='".$_SESSION['id_cliente']."'";
					$result = mysql_query($query,$link);
					if($row=mysql_fetch_array($result))
					{
						$_SESSION['cliente_db']=$row['cliente_db'];
					}
				}
                //Bien y correcto
                $resultadoSession=array('sesion'=>'bienUseryPassword');
			}
			else
			{
                //Intentalo de nuevo
                $resultadoSession=array('sesion'=>'mal');
                $_SESSION['autentificado_rf2']= 0;
                @session_destroy();
			}
		}
		else
		{
            @session_destroy();
		}
		mysql_free_result($result);
	}
    else
    {
        $resultadoSession=array('sesion'=>'mal');
        $_SESSION['autentificado_rf2']= 0;
        @session_destroy();
    }
    echo json_encode($resultadoSession);
	mysql_close($link);
}
?>