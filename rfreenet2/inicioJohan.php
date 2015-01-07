<?	session_start();
$nombre=$_POST['usuario'];
$password=$_POST['pass'];
include 'inc/datos_db.inc';
include 'inc/funciones_indice.inc';
include 'inc/idiomas.inc';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<?php
if($_SERVER["SERVER_NAME"]==$url_hanna)
{
    echo "<title>WATER WEB MANAGER 2.0</title>\n";
}
else
{
    echo "<title>GREEN WEB MANAGER 3.0</title>\n";
}
?>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"/>
<?php
if($_SERVER["SERVER_NAME"]==$url_hanna)
{
    echo "<link href='images/favicon_hanna.ico' type='image/x-icon' rel='shortcut icon'/>\n";
}
else
{
    echo "<link href='images/favicon.ico' type='image/x-icon' rel='shortcut icon'/>\n";
}
?>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"/>
<link rel="stylesheet" href="css/plantilla_css.css" type="text/css"/>
<link rel="stylesheet" href="js/datepicker/datepicker.css" type="text/css"/>
<link rel="stylesheet" href="js/timepicker/timepicker.css" type="text/css"/>
<link rel="stylesheet" href="css/protoplasm.css" type="text/css"/>
<link rel="STYLESHEET" type="text/css" href="codebase/dhtmlxtabbar.css"/>
<script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
<script type="text/javascript" src="js/protoplasm2.js"></script>
<script type="text/javascript" src="js/datepicker/datepicker.js"></script>
<script type="text/javascript" src="js/timepicker/timepicker.js"></script>
<script type="text/javascript" src="js/funciones_principal.js?time=<?php echo(filemtime("js/funciones_principal.js"));?>"></script>
<script type="text/javascript" src="js/funciones_ajax.js?time=<?php echo(filemtime("js/funciones_ajax.js"));?>"></script>
<script type="text/javascript" src="js/funciones_aux.js?time=<?php echo(filemtime("js/funciones_aux.js"));?>"></script>
<script type="text/javascript" src="js/funciones_datos.js?time=<?php echo(filemtime("js/funciones_datos.js"));?>"></script>
<script type="text/javascript" src="js/funciones_submenu.js?time=<?php echo(filemtime("js/funciones_submenu.js"));?>"></script>
<script type="text/javascript" src="js/funciones_informes.js?time=<?php echo(filemtime("js/funciones_informes.js"));?>"></script>
<script  src="codebase/dhtmlxcommon.js"></script>
<script  src="codebase/dhtmlxtabbar.js"></script>
<script type="text/javascript" src="js/dhtmlxcontainer.js"></script>
<?php
if ($_SESSION['perfil']==0)
{
    ?>
    <script type="text/javascript" src="js/funciones_principal_admin.js"></script>
    <script type="text/javascript" src="js/funciones_submenu_admin.js"></script>
<?php
}
?>
<script type="text/javascript">
var A_TCALLANG;
var opcion_elegida;
<?php
if ($_SESSION['perfil']==0)
{
?>
var timerestado;
function tarea_periodica()
{
    //alert('Tiempo');
    var xmlTimed;
    var sPrincipalNode;
    var sMonitor;
    var sProceso;
    var sMonitorR;
    var sProcesoR;
    var sMonitorX;
    var sProcesoX;
    xmlTimed= GetXmlHttpObject();
    var url = "carga_estado_procesos.php";
    xmlTimed.onreadystatechange=function()
    {
        if (xmlTimed.readyState==4)
        {
            var doc=xmlTimed.responseText;
            var xmlrespuesta = parsear_xml(doc);
            if (xmlrespuesta != null)
            {
                sMonitor=xmlrespuesta.childNodes[0].getElementsByTagName("monitor");
                sProceso=xmlrespuesta.childNodes[0].getElementsByTagName("demonio");
                sMonitorR=xmlrespuesta.childNodes[0].getElementsByTagName("monitorR");
                sProcesoR=xmlrespuesta.childNodes[0].getElementsByTagName("demonioR");
                sMonitorX=xmlrespuesta.childNodes[0].getElementsByTagName("monitorX");
                sProcesoX=xmlrespuesta.childNodes[0].getElementsByTagName("demonioX");

                if (sMonitor[0].childNodes[0])
                {
                    if(sMonitor[0].childNodes[0].nodeValue == 1)
                    {
                        document.getElementById("estado_monitor").src='images/ok.png';
                    }
                    else
                    {
                        document.getElementById("estado_monitor").src='images/off.png';
                    }
                }
                else
                {
                    document.getElementById("estado_monitor").src='images/off.png';
                }
                if (sProceso[0].childNodes[0])
                {
                    if(sProceso[0].childNodes[0].nodeValue == 1)
                    {
                        document.getElementById("estado_proceso").src='images/ok.png';
                    }
                    else
                    {
                        document.getElementById("estado_proceso").src='images/off.png';
                    }
                }
                else
                {
                    document.getElementById("estado_proceso").src='images/off.png';
                }

                if (sMonitorR[0].childNodes[0])
                {
                    if(sMonitorR[0].childNodes[0].nodeValue == 1)
                    {
                        document.getElementById("estado_monitor_rutinas").src='images/ok.png';
                    }
                    else
                    {
                        document.getElementById("estado_monitor_rutinas").src='images/off.png';
                    }
                }
                else
                {
                    document.getElementById("estado_monitor_rutinas").src='images/off.png';
                }
                if (sProcesoR[0].childNodes[0])
                {
                    if(sProcesoR[0].childNodes[0].nodeValue == 1)
                    {
                        document.getElementById("estado_proceso_rutinas").src='images/ok.png';
                    }
                    else
                    {
                        document.getElementById("estado_proceso_rutinas").src='images/off.png';
                    }
                }
                else
                {
                    document.getElementById("estado_proceso_rutinas").src='images/off.png';
                }

                if (sMonitorX[0].childNodes[0])
                {
                    if(sMonitorX[0].childNodes[0].nodeValue == 1)
                    {
                        document.getElementById("estado_monitor_xml").src='images/ok.png';
                    }
                    else
                    {
                        document.getElementById("estado_monitor_xml").src='images/off.png';
                    }
                }
                else
                {
                    document.getElementById("estado_monitor_xml").src='images/off.png';
                }
                if (sProcesoX[0].childNodes[0])
                {
                    if(sProcesoX[0].childNodes[0].nodeValue == 1)
                    {
                        document.getElementById("estado_proceso_xml").src='images/ok.png';
                    }
                    else
                    {
                        document.getElementById("estado_proceso_xml").src='images/off.png';
                    }
                }
                else
                {
                    document.getElementById("estado_proceso_xml").src='images/off.png';
                }
            }
            timerestado=setTimeout("tarea_periodica()",5000);
        }
    }
    xmlTimed.open("GET",url,true);
    xmlTimed.send(null);
}
<?php
}
?>
function empieza()
{
    opcion_elegida = 0;
    <?php
    if ($_SESSION['perfil']>0)
    {
    ?>
    OnBotonMapa(iObtener_Modo_Offline());
    <?php
    }
    else
    {
    ?>
    OnBotonClientes();
    tarea_periodica();
    <?php
    }
    ?>
}

function vEnviar_Comando(sComando)
{
    xmlHttp= GetXmlHttpObject();
    var url = "enviar_comando.php?comando="+sComando;
    xmlHttp.onreadystatechange=function()
    {
        if (xmlHttp.readyState==4)
        {
            var doc1=xmlHttp.responseText;
            if (doc1 == "OK")
            {
                switch (sComando.substr(0,1))
                {
                    case "R":
                        alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['main_command_reset'];?>");
                        break;
                    case "A":
                        alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['main_command_forzado'];?>");
                        break;
                    case "I":
                        alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['main_command_imagen'];?>");
                        break;
                    default:
                        alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['main_command_generico'];?>");
                        break;
                }
            }
            else
            {
                alert(doc1);
            }
        }
    }
    xmlHttp.open("GET",url,true);
    xmlHttp.send(null);
}

function vActualizar_Sesion()
{
    var xmlHttpSesion;
    var url="actualizar_sesion.php";
    xmlHttpSesion= GetXmlHttpObject();
    xmlHttpSesion.open("GET",url,false);
    xmlHttpSesion.send(null);

    setTimeout(vActualizar_Sesion,60000);
}
function vEnviar_Comando_Offline(sComando, gw_id, nodo_ip, db_cliente, instalacion)
{
    xmlHttp= GetXmlHttpObject();
    var url = "enviar_comando_offline.php?gw_id="+gw_id+"&nodo_ip="+nodo_ip+"&comando="+sComando+"&cliente_db="+db_cliente+"&instalacion_id=" + instalacion;
    xmlHttp.onreadystatechange=function()
    {
        if (xmlHttp.readyState==4)
        {
            var doc1=xmlHttp.responseText;
            if (doc1 == "OK")
            {
                switch (sComando.substr(0,1))
                {
                    case "R":
                        alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['main_command_reset'];?>");
                        break;
                    case "A":
                        alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['main_command_forzado'];?>");
                        break;
                    case "I":
                        alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['main_command_imagen'];?>");
                        break;
                    default:
                        alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['main_command_generico'];?>");
                        break;
                }
            }
            else
            {
                alert(doc1);
            }
        }
    }
    xmlHttp.open("GET",url,true);
    xmlHttp.send(null);
}
</script>
</head>
<body style="margin-left:0;margin-top:0;" onload="empieza()" class="Fondo_Web">

<form name="formDatos">
<table width="1020px" height="616px" align="center" border="1" cellpadding="0" cellspacing="0" id="Tabla_01" class="Fondo_Tabla" margin="0px">
<tr>
    <!--<td width="225">
        <img src="images/logo.jpg" width"=222px" height="138px" alt=""/></td>-->
    <td>
        <?php
        if ($_SESSION['autentificado_rf2']!= 1 || $_SESSION['perfil'] == 0)
        {
            if($_SERVER["SERVER_NAME"]==$url_hanna)
            {
                ?>
                <img src="images/hanna_logo.jpg" width="222px" height="138px" alt=""/>
            <?php
            }
            else
            {
                ?>
                <img src="images/logo.jpg" width="222px" height="138px" alt=""/>
            <?
            }
        }
        else
        {
            ?>
            <img id="logo_personalizado" src="descargar_logo.php?id_cliente=<?=$_SESSION["id_cliente"]?>&inicio=si" width="222px" height="138px" alt=""/>
        <?
        }
        ?>
    </td>
    <td>
        <?php
        if($_SERVER["SERVER_NAME"]==$url_hanna)
        {
            ?>
            <img src="images/hanna_banner.jpg" width="790" height="138" alt="Green Web Manager 2.0"/>
        <?php
        }
        else
        {
            ?>
            <img src="images/banner.jpg" width="790" height="138" alt="Green Web Manager 2.0"/>
        <?php
        }
        ?>
    </td>
</tr>
<tr>
    <td style="text-align:center">
        <img src="images/flags/spain.png" width="20" height="20" alt="Espa&#241;ol" onclick="vCambiarIdioma(1,'es');"/>
        <img src="images/flags/united_kingdom.png" width="20" height="20" alt="Franc&eacute;s" onclick="vCambiarIdioma(1,'en');"/>
        <img src="images/flags/france.png" width="20" height="20" alt="Franc&eacute;s" onclick="vCambiarIdioma(1,'fr');"/>
    </td>
    <td align="left" valign="top" style="font-family:Arial, Helvetica">
        <?php
        if ($_SESSION['perfil']>0)
        {
            ?>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#FFF; background-color:#999">
                <tr>
                    <ul id="nav">
                        <li><a href="#" id="boton_mapas" onclick="OnBotonMapa(iObtener_Modo_Offline())" style="width:70px;"><?php echo $idiomas[$_SESSION['opcion_idioma']]['main_boton_mapas'];?></a></li>
                        <li><a href="#" id="boton_datos" onclick="OnBotonDatos()" style="width:70px;"><?php echo $idiomas[$_SESSION['opcion_idioma']]['main_boton_medidas'];?></a></li>
                        <li><a href="#" id="boton_procesado" onclick="OnBotonProcesado()" style="width:100px;"><?php echo $idiomas[$_SESSION['opcion_idioma']]['main_boton_procesado'];?></a></li>
                        <li><a href="#" id="boton_informes" onclick="OnBotonInformes()" style="width:90px;"><?php echo $idiomas[$_SESSION['opcion_idioma']]['main_boton_informes'];?></a></li>
                        <li><a href="#" id="boton_notificacion" onclick="OnSelectEventos(99, 0);" style="width:90px;"><?php echo $idiomas[$_SESSION['opcion_idioma']]['main_boton_eventos'];?></a>
                        </li>
                        <li><a href="#" id="boton_gestion" onclick="OnBotonGestion()" style="width:90px;"><?php echo $idiomas[$_SESSION['opcion_idioma']]['main_boton_gestion'];?></a></li>
                        <li><a href="#" id="boton_soporte" onclick="OnBotonSoporte()" style="width:70px;"><?php echo $idiomas[$_SESSION['opcion_idioma']]['main_boton_soporte'];?></a></li>
                    </ul>
                </tr>
            </table>
        <?php
        }
        else
        {
            ?>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#FFF; background-color:#999">
                <tr>
                    <ul id="nav">
                        <li><a href="#" id="boton_clientes" onclick="OnBotonClientes()"><?php echo $idiomas[$_SESSION['opcion_idioma']]['main_boton_clientes'];?></a></li>
                        <li><a href="#" id="boton_usuarios" onclick="OnBotonUsuarios()"><?php echo $idiomas[$_SESSION['opcion_idioma']]['main_boton_usuarios'];?></a></li>
                        <li><a href="#" id="boton_configuracion" style="width:100px;" onclick="OnBotonConfigAdmin()"><?php echo $idiomas[$_SESSION['opcion_idioma']]['main_boton_gestion'];?></a></li>
                    </ul>
                </tr>
            </table>
        <?php
        }
        ?>
    </td>
</tr>
<tr>
    <td style="align:left" valign="top">
        <?php
        if ($_SESSION['perfil']>0)
        {
            ?>
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#FFF; background-color:#999">
                        &nbsp;&nbsp;<strong><?php echo utf8_decode($idiomas[$_SESSION['opcion_idioma']]['title_instalaciones']);?></strong>
                    </td>
                </tr>
                <tr>
                    <td align="left" valign="baseline" style="font-family:Arial, Helvetica, sans-serif; text-align:center">
                        <select name="instalaciones" id="comboInstalaciones" onchange="OnChangeInstalacion(iObtener_Modo_Offline())" style="width:200px;margin:0px 0 5px 0;">
                            <?
                            echo RellenarListaInstalaciones($_SESSION['cliente_db'],$_SESSION['id_cliente']);
                            ?>
                        </select>
                    </td>
                </tr>
            </table>
        <?php
        }
        else
        {
            ?>
            <table width="100%" cellpadding="0" cellspacing="0" border="1">
                <tr>
                    <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#FFF; background-color:#999">
                        &nbsp;&nbsp;<strong><?php echo $idiomas[$_SESSION['opcion_idioma']]['title_administracion'];?></strong>
                    </td>
                </tr>
                <tr>
                    <td align="left" valign="baseline" style="font-family:Arial, Helvetica, sans-serif; text-align:center">
                        <table width="100%">
                            <tr>
                                <td align="left" valign="baseline" style="font-family:Arial, Helvetica, sans-serif; text-align:center" width="50%">
                                    <img id="estado_proceso" src="images/off.png" width="12" height="12"/>&nbsp;&nbsp;<?php echo $idiomas[$_SESSION['opcion_idioma']]['title_proceso'];?>
                                </td>
                                <td style="width:10%"></td>
                                <td align="left" valign="baseline" style="font-family:Arial, Helvetica, sans-serif; text-align:center" width="40%">
                                    <img id="estado_monitor" src="images/off.png" width="12" height="12"/>&nbsp;&nbsp;<?php echo $idiomas[$_SESSION['opcion_idioma']]['title_monitor'];?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="left" valign="baseline" style="font-family:Arial, Helvetica, sans-serif; text-align:center">
                        <table width="100%">
                            <tr>
                                <td align="left" valign="baseline" style="font-family:Arial, Helvetica, sans-serif; text-align:center" width="50%">
                                    <img id="estado_proceso_rutinas" src="images/off.png" width="12" height="12"/>&nbsp;&nbsp;<?php echo $idiomas[$_SESSION['opcion_idioma']]['title_rutinas'];?>
                                </td>
                                <td style="width:10%"></td>
                                <td align="left" valign="baseline" style="font-family:Arial, Helvetica, sans-serif; text-align:center" width="40%">
                                    <img id="estado_monitor_rutinas" src="images/off.png" width="12" height="12"/>&nbsp;&nbsp;<?php echo $idiomas[$_SESSION['opcion_idioma']]['title_monitor'];?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="left" valign="baseline" style="font-family:Arial, Helvetica, sans-serif; text-align:center">
                        <table width="100%">
                            <tr>
                                <td align="left" valign="baseline" style="font-family:Arial, Helvetica, sans-serif; text-align:center" width="50%">
                                    <img id="estado_proceso_xml" src="images/off.png" width="12" height="12"/>&nbsp;&nbsp;SOAP XML
                                </td>
                                <td style="width:10%"></td>
                                <td align="left" valign="baseline" style="font-family:Arial, Helvetica, sans-serif; text-align:center" width="40%">
                                    <img id="estado_monitor_xml" src="images/off.png" width="12" height="12"/>&nbsp;&nbsp;<?php echo $idiomas[$_SESSION['opcion_idioma']]['title_monitor'];?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        <?php
        }
        ?>
    </td>
    <td align="left" valign="top">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:10px;">
            <tr>
                <td style="height:26" id="navmap"></td>
                <td align="right" style="font-size:11px">
                    <?php echo utf8_decode($idiomas[$_SESSION['opcion_idioma']]['title_logueado']);?> <strong onclick="vPerfil()" style="color:#0000FF;text-decoration:underline;"><?php echo utf8_decode(Mostrar_Nivel_Privilegios($_SESSION['perfil']));?></strong><br/>
                    <a href="index_m.php?opcion_idioma=<?php echo $_SESSION['opcion_idioma'];?>"><?php echo $idiomas[$_SESSION['opcion_idioma']]['title_logoff'];?></a>&nbsp;&nbsp;
                </td>
            </tr>
        </table>
    </td>
</tr>
<tr height="505px">
    <td align="left" valign="top" id="celda_submenu">
    </td>
    <td align="center">
        <input type="hidden" value="<?echo $_SESSION['cliente_db']?>" id="db_cliente"/>
        <input type="hidden" value="<?echo $_SESSION['id_cliente']?>" id="id_cliente"/>
        <iframe id="iframe_mapa" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" width="780px" height="505px" style=" margin:0px 0px 0px 0px;" src="" valign="center" border="0" class="Fondo_Tabla"></iframe>
    </td>
</tr>
<tr height="14px">
    <td colspan="2"align="left" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#FFF; background-color:#999">&nbsp;  &copy;
        <?php
        if($_SERVER["SERVER_NAME"]==$url_hanna)
        {
            //echo utf8_decode($idiomas[$_SESSION['opcion_idioma']]['general00']);
        }
        else
        {
            echo utf8_decode($idiomas[$_SESSION['opcion_idioma']]['general00']);
        }
        ?>
    </td>
</tr>
</table>
</form>
<script type="text/javascript">
    <?php
         if ($_SESSION['autentificado_rf2']!= 1)
        {
            echo "window.location='index.php';";
        }
    ?>
    vActualizar_Sesion();
</script>
</body>
</html>