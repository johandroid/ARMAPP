<?session_start();
include 'inc/idiomas.inc';
include 'inc/funciones_db.inc';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<title>RFreeNET Data</title>
	<link rel="stylesheet" href="css/plantilla_css.css" type="text/css"/>
	<script type="text/javascript" src="js/funciones_ajax.js?time=<?php echo(filemtime("js/funciones_ajax.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_aux.js?time=<?php echo(filemtime("js/funciones_aux.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_principal.js?time=<?php echo(filemtime("js/funciones_principal.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_tooltip.js?time=<?php echo(filemtime("js/funciones_tooltip.js"));?>"></script>
	<script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>	
</head>

<body>
	<div id="div_vista_general" align="center">
		<span><?php echo $idiomas[$_SESSION['opcion_idioma']]['general19'].' '.sObtener_Nombre_Instalación($_GET['objeto_id'], $_SESSION['cliente_db'])?></span>
	</div>	
	<div id="div_vista_general" style="overflow:visible;" >
		<span>&nbsp;&nbsp;<?php echo $idiomas[$_SESSION['opcion_idioma']]['general11']?></span>
		<div id="contenedor_sensores" class='xstooltip' style="position: absolute;"></div>
	</div>						
	<div id="carga_vista_gw" style="height:120px;overflow-y: scroll">
		<? include "carga_vista_general_gw.html.php"; ?>
	</div>
		<div id="div_vista_general" style="overflow:visible;" >
		<span>&nbsp;&nbsp;<?php echo $idiomas[$_SESSION['opcion_idioma']]['general12']?></span>
	</div>	
	<div id="carga_vista_utc" style="height:120px;overflow-y: scroll">		
		<? include "carga_vista_general_nodo.html.php"; ?>
	</div>	
	</div>
	<div id="div_vista_general" style="overflow:visible;" >
		<span>&nbsp;&nbsp;<?php echo $idiomas[$_SESSION['opcion_idioma']]['general254']?></span>
	</div>	
	<div id="carga_vista_utc" style="height:120px;overflow-y: scroll">		
		<? include "carga_vista_general_utc.html.php"; ?>
	</div>	
</body>
</html>