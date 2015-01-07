<?php session_start();
include 'inc/idiomas.inc';
include 'inc/key_google_maps.inc';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>RFreeNET Map</title>
	<link rel="stylesheet" href="css/plantilla_css.css" type="text/css"/>
	<link rel="STYLESHEET" type="text/css" href="codebase/dhtmlxtabbar.css"/>
	<link rel="STYLESHEET" type="text/css" href="css/smoothness/jquery-ui-1.10.1.custom.min.css"/>
	<?php
        echo '<script src="http://maps.googleapis.com/maps/api/js?libraries=weather&key='.$key_google_maps.'&sensor=false&amp;hl='.$_SESSION['opcion_idioma'].'" type="text/javascript"></script>';
    ?>
	<script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.10.1.custom.min.js"></script>
	<script type="text/javascript" src="js/jquery.dualListBox-1.3.min_kta.js"></script>				
	<script  src="codebase/dhtmlxcommon.js"></script>
	<script  src="codebase/dhtmlxtabbar.js"></script>
	<script type="text/javascript" src="js/funciones_mapas.js?time=<?php echo(filemtime("js/funciones_mapas.js"));?>"> </script>
	<script type="text/javascript" src="js/funciones_principal.js?time=<?php echo(filemtime("js/funciones_principal.js"));?>"></script>
	<script type="text/javascript" src="js/dhtmlxcontainer.js"></script>	
	<script type="text/javascript" src="js/funciones_ajax.js?time=<?php echo(filemtime("js/funciones_ajax.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_aux.js?time=<?php echo(filemtime("js/funciones_aux.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_check.js?time=<?php echo(filemtime("js/funciones_check.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_gw.js?time=<?php echo(filemtime("js/funciones_gw.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_medidas.js?time=<?php echo(filemtime("js/funciones_medidas.js"));?>"></script>	
	<script type="text/JavaScript">
	var map;
	var marcadores_nodos = new Array(1000);
	var estados_nodos = new Array(1000);
	var onoff_nodos = new Array(1000);
	var marcadores_utcs = new Array(200);
	var marcadores_gateways = new Array(200);
	var estados_gateways = new Array(200);
	var onoff_gateways = new Array(200);
	var onoff_utcs = new Array(200);
	var estados_utcs = new Array(200);
	var infowindow = new google.maps.InfoWindow();

	function load()
	{
		if (top.document.getElementById("comboInstalaciones").length > 0)
		{
			var mapOptions = {
				disableDoubleClickZoom: true,
				streetViewControl: false,
			    zoom: 8,
			    center: new google.maps.LatLng(41.633, 0.8),
			    mapTypeId: google.maps.MapTypeId.SATELLITE
		  	}
  			map = new google.maps.Map(document.getElementById("mapdiv"), mapOptions);
  			var weatherLayer = new google.maps.weather.WeatherLayer();
			weatherLayer.setMap(map);
			weatherLayer.setOptions({'temperatureUnits': google.maps.weather.TemperatureUnit.CELCIUS});
			weatherLayer.setOptions({'windSpeedUnits': google.maps.weather.WindSpeedUnit.KILOMETERS_PER_HOUR});
			var cloudLayer = new google.maps.weather.CloudLayer();
			cloudLayer.setMap(map);
			recargar_nodos_mapa(top.document.getElementById("db_cliente").value, top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value);
			tiempo=setTimeout('actualizador_mapa()',5000);
		}
	}
	function actualizador_mapa()
	{
		var i;
		var xml;
		var markers_gateways;
		var markers_nodos;
		var markers_utcs;
		var xmlHttpgrMap;
		if (top.document.getElementById("db_cliente") != null)
		{
			var database_cliente = top.document.getElementById("db_cliente").value;
			var instalacion_seleccionada = top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value;
			
			url = "maps_update_api.php?cliente_db=" + database_cliente + "&instalacion_id=" + instalacion_seleccionada;
			xmlHttpgrMap= GetXmlHttpObject();
			xmlHttpgrMap.open("GET",url,true);
			xmlHttpgrMap.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
			xmlHttpgrMap.onreadystatechange=function()
			{
				if (xmlHttpgrMap.readyState==4)
				{
					var xml=parsear_xml(xmlHttpgrMap.responseText);
					markers_gateways = xml.documentElement.getElementsByTagName("gateway");
					markers_nodos = xml.documentElement.getElementsByTagName("nodo");
					markers_utcs = xml.documentElement.getElementsByTagName("utc");
					for (i = 0; i < markers_gateways.length; i++)
					{
						if ((onoff_gateways[i] != markers_gateways[i].getAttribute("onoff")) || (estados_gateways[i] != markers_gateways[i].getAttribute("estado")))
						{
							estados_gateways[i] = markers_gateways[i].getAttribute("estado");
							onoff_gateways[i] = markers_gateways[i].getAttribute("onoff");
							cambiar_estado_gw_mapa(markers_gateways[i].getAttribute("id"), onoff_gateways[i], estados_gateways[i], markers_gateways[i].getAttribute("tipo"));
						}
					}				
					for (i = 0; i < markers_nodos.length; i++)
					{
						if ((onoff_nodos[i] != markers_nodos[i].getAttribute("onoff")) || (estados_nodos[i] != markers_nodos[i].getAttribute("estado")))
						{	
							estados_nodos[i] = markers_nodos[i].getAttribute("estado");
							onoff_nodos[i] = markers_nodos[i].getAttribute("onoff");
							cambiar_estado_nodo_mapa(markers_nodos[i].getAttribute("mac"), onoff_nodos[i], estados_nodos[i]);
						}
					}
					for (i = 0; i < markers_utcs.length; i++)
					{
						if ((onoff_utcs[i] != markers_utcs[i].getAttribute("onoff")) || (estados_utcs[i] != markers_utcs[i].getAttribute("estado")))
						{
							estados_utcs[i] = markers_utcs[i].getAttribute("estado");
							onoff_utcs[i] = markers_utcs[i].getAttribute("onoff");
							cambiar_estado_utc_mapa(markers_utcs[i].getAttribute("id"), onoff_utcs[i], estados_utcs[i]);
						}
					}
				}
			}
			xmlHttpgrMap.send(null);
		}		
		tiempo=setTimeout('actualizador_mapa()', 5000);
	}

	function recargar_nodos_mapa(db_cliente, instalacion)
	{
		var xmlHttpgrMap;
		var sPrincipal;
		//map.clearOverlays();
		vBorrar_Marcadores();
		
		url = "maps_api.php?cliente_db=" + db_cliente + "&instalacion_id=" + instalacion;
		xmlHttpgrMap= GetXmlHttpObject();
		xmlHttpgrMap.open("GET",url,true);
		xmlHttpgrMap.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		xmlHttpgrMap.onreadystatechange=function()
		{
			if (xmlHttpgrMap.readyState==4)
			{
				var xml=parsear_xml(xmlHttpgrMap.responseText);
				var markers_gateways = xml.documentElement.getElementsByTagName("gateway");
				var markers_nodos = xml.documentElement.getElementsByTagName("nodo");
				var markers_utcs = xml.documentElement.getElementsByTagName("utc");
				var i;
				var point = null;
				var bounds = new google.maps.LatLngBounds();
				for (i = 0; i < markers_gateways.length; i++)
				{
					var point = new google.maps.LatLng(parseFloat(markers_gateways[i].getAttribute("lat")),parseFloat(markers_gateways[i].getAttribute("lng")));
					bounds.extend(point);
					
					estados_gateways[i] = markers_gateways[i].getAttribute("estado");
					onoff_gateways[i] = markers_gateways[i].getAttribute("onoff");
					marcadores_gateways[i] = createGW(map, point, 0, markers_gateways[i].getAttribute("id"), markers_gateways[i].getAttribute("tipo"), markers_gateways[i].getAttribute("nombre"), onoff_gateways[i], estados_gateways[i]);
				}
				for (i = 0; i < markers_nodos.length; i++)
				{
					var point = new google.maps.LatLng(parseFloat(markers_nodos[i].getAttribute("lat")),parseFloat(markers_nodos[i].getAttribute("lng")));
					bounds.extend(point);
	
					estados_nodos[i] = markers_nodos[i].getAttribute("estado");
					onoff_nodos[i] = markers_nodos[i].getAttribute("onoff");
					marcadores_nodos[i] = createNode(map, point, 0, markers_nodos[i].getAttribute("gw"), markers_nodos[i].getAttribute("mac"), markers_nodos[i].getAttribute("ip"), markers_nodos[i].getAttribute("nombre"), onoff_nodos[i], estados_nodos[i]);
				}
				for (i = 0; i < markers_utcs.length; i++)
				{
					var point = new google.maps.LatLng(parseFloat(markers_utcs[i].getAttribute("lat")),parseFloat(markers_utcs[i].getAttribute("lng")));
					bounds.extend(point);
	
					estados_utcs[i] = markers_utcs[i].getAttribute("estado");
					onoff_utcs[i] = markers_utcs[i].getAttribute("onoff");
					marcadores_utcs[i] = createUTC(map, point, 0, markers_utcs[i].getAttribute("gw_id"), markers_utcs[i].getAttribute("id"), markers_utcs[i].getAttribute("direccion"), markers_utcs[i].getAttribute("nombre"), onoff_utcs[i], estados_utcs[i]);
				}
				if (point)
				{
					map.setCenter(bounds.getCenter());
					map.fitBounds(bounds);
				}
			}
		}
		xmlHttpgrMap.send(null);
	}

	function cambiar_estado_gw_mapa(sus_cambio, nodo_onoff, nuevo_estado, tipo)
	{
		var i;
		var cadena_compara;
		i=0;
		while (i < top.document.getElementById("comboGateways").length)
		{
			cadena_compara = top.document.getElementById("comboGateways").options[i].id;
			if (cadena_compara==sus_cambio)
			{
				break;
			}
			else
			{
				i++;
			}
		}
		if ((i < top.document.getElementById("comboGateways").length) && (marcadores_gateways[i]))
		{
			asignar_icono_gw(marcadores_gateways[i], nodo_onoff, nuevo_estado, tipo);			
		}
	}

	function cambiar_estado_nodo_mapa(mac_nodo_cambio, nodo_onoff, nuevo_estado)
	{
		var i;
		var cadena_compara;
		i=0;
		while (i < top.document.getElementById("comboNodos").length)
		{	
			cadena_compara = top.document.getElementById("comboNodos").options[i].id;
			if (cadena_compara==mac_nodo_cambio)
			{
				break;
			}
			else
			{
				i++;
			}
		}
		if ((i < top.document.getElementById("comboNodos").length) && (marcadores_nodos[i]))
		{	
			asignar_icono_nodo(marcadores_nodos[i], nodo_onoff, nuevo_estado);			
		}
	}
	
	function cambiar_estado_utc_mapa(mac_nodo_cambio, nodo_onoff, nuevo_estado)
	{
		var i;
		var cadena_compara;
		i=0;
		while (i < top.document.getElementById("comboUTCs").length)
		{
			cadena_compara = top.document.getElementById("comboUTCs").options[i].id;
			if (cadena_compara==mac_nodo_cambio)
			{
				break;
			}
			else
			{
				i++;
			}
		}
		if ((i < top.document.getElementById("comboUTCs").length) && (marcadores_utcs[i]))
		{
			asignar_icono_utc(marcadores_utcs[i], nodo_onoff, nuevo_estado);
		}
	}

	function centrar_nodo(indice_nodo)
	{
		map.panTo(marcadores_nodos[indice_nodo].getPosition());
	}

	function centrar_gateway(indice_nodo)
	{
		map.panTo(marcadores_gateways[indice_nodo].getPosition());
	}
	
	function centrar_utc(indice_nodo)
	{
		map.panTo(marcadores_utcs[indice_nodo].getPosition());
	}
	</script>	
</head>

<body onload="load()">
	<div id="mapdiv" style="height: 445px; width: 97%;" class="MapBox" align="center" valign="center" style="margin: 0 0 0 0;" background="#515151"></div>
	<table border="0" width="100%">
		<tr>
			<td width="15%" style="font-size:11px">
					<img src="images/leyenda/verde.png" width="14" height="14" border="0" style="vertical-align:middle"/>&nbsp;&nbsp; ON
			</td>
			<td width="15%" style="font-size:11px">
					<img src="images/leyenda/rojo.png" width="14" height="14" border="0" style="vertical-align:middle"/>&nbsp;&nbsp; OFF
			</td>
			<td width="23%" style="font-size:11px">
					<img src="images/leyenda/naranja.png" width="14" height="14" border="0" style="vertical-align:middle"/>&nbsp;&nbsp; <?php echo $idiomas[$_SESSION['opcion_idioma']]['event_umbral']?>
			</td>
			<td width="23%" style="font-size:11px">
					<img src="images/leyenda/amarillo.png" width="14" height="14" border="0" style="vertical-align:middle"/>&nbsp;&nbsp; <?php echo $idiomas[$_SESSION['opcion_idioma']]['event_gradiente']?>
			</td>
			<td width="23%" style="font-size:11px">
					<img src="images/leyenda/alerta.png" width="14" height="14" border="0" style="vertical-align:middle"/>&nbsp;&nbsp; <?php echo $idiomas[$_SESSION['opcion_idioma']]['event_fallo_alim']?>
			</td>
		</tr>
	</table>
	<noscript><?php echo $idiomas[$_SESSION['opcion_idioma']]['disclaimer_js']?></noscript>
</body>

</html>