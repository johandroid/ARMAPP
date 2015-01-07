<?php session_start();
include 'inc/idiomas.inc';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>RFreeNET Map</title>
	<link rel="stylesheet" href="css/plantilla_css.css" type="text/css"/>
	<?php
	include 'inc/key_google_maps.inc';
        echo '<script src="http://maps.googleapis.com/maps/api/js?libraries=weather&key='.$key_google_maps.'&sensor=false&amp;hl='.$_SESSION['opcion_idioma'].'" type="text/javascript"></script>';
	?>	
	<script type="text/javascript" src="js/funciones_mapas.js?time=<?php echo(filemtime("js/funciones_mapas.js"));?>"> </script>
	<script type="text/javascript" src="js/funciones_aux.js?time=<?php echo(filemtime("js/funciones_aux.js"));?>"> </script>
	<script type="text/javascript" src="js/funciones_principal.js?time=<?php echo(filemtime("js/funciones_principal.js"));?>"></script>
	<script type="text/JavaScript">
	var sMACActual;
	var map;
	var ClickListener;
	var marcadores_nodos_nuevos = new Array(1000);
	var numero_marcadores_nuevos;
	var nuevo_punto;
	
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
			recargar_nodos_mapa(top.document.getElementById("db_cliente").value, top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value);
		}
		numero_marcadores_nuevos = 0;
	}

	function recargar_nodos_mapa(db_cliente, instalacion)
	{
		var xmlHttpgrMap;
		var sPrincipal;
		
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
					createGW(map, point, 0, markers_gateways[i].getAttribute("id"), markers_gateways[i].getAttribute("tipo"),  markers_gateways[i].getAttribute("nombre"), "0", "01");
				}
				for (i = 0; i < markers_nodos.length; i++)
				{
					var point = new google.maps.LatLng(parseFloat(markers_nodos[i].getAttribute("lat")),parseFloat(markers_nodos[i].getAttribute("lng")));
					bounds.extend(point);
					createNode(map, point, 0, markers_nodos[i].getAttribute("gw"), markers_nodos[i].getAttribute("mac"), markers_nodos[i].getAttribute("ip"), markers_nodos[i].getAttribute("nombre"), "0", "01");
				}
				for (i = 0; i < markers_utcs.length; i++)
				{
					var point = new google.maps.LatLng(parseFloat(markers_utcs[i].getAttribute("lat")),parseFloat(markers_utcs[i].getAttribute("lng")));
					bounds.extend(point);
					createUTC(map, point, 0, markers_utcs[i].getAttribute("gw"), markers_utcs[i].getAttribute("direccion"), markers_utcs[i].getAttribute("id"), markers_utcs[i].getAttribute("nombre"), "0", "01");
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

	function centrar_nodo(indice_nodo)
	{
		if (indice_nodo<numero_marcadores_nuevos)
		{
			map.panTo(marcadores_nodos_nuevos[indice_nodo].getPoint());
		}
	}

	function cargar_nuevos_nodos(instalacion)
	{
		var xmlHttpDispos;
		xmlHttpDispos= GetXmlHttpObject();
		var url = "carga_nuevos_nodos.php?instalacion_id=" + instalacion + "&cliente_db=" + top.document.getElementById("db_cliente").value;
		xmlHttpDispos.onreadystatechange=function()
		{
			if (xmlHttpDispos.readyState==4)
			{
				var doc=xmlHttpDispos.responseText;
				var xmlrespuesta = parsear_xml(doc);
				var vvx=xmlrespuesta.getElementsByTagName("nodo");
				document.getElementById("comboNodos").length=0;
				for(i=0;i<vvx.length;i++)
				{
					if (xmlrespuesta.getElementsByTagName("nodo")[i].attributes[1].nodeValue.length == 0)
					{
						insertarOptionComboValue("comboNodos",xmlrespuesta.getElementsByTagName("nodo")[i].attributes[2].nodeValue, xmlrespuesta.getElementsByTagName("nodo")[i].attributes[0].nodeValue, xmlrespuesta.getElementsByTagName("nodo")[i].attributes[3].nodeValue,'Nodo '+xmlrespuesta.getElementsByTagName("nodo")[i].attributes[2].nodeValue);
					}
					else
					{
						insertarOptionComboValue("comboNodos",xmlrespuesta.getElementsByTagName("nodo")[i].attributes[2].nodeValue, xmlrespuesta.getElementsByTagName("nodo")[i].attributes[0].nodeValue, xmlrespuesta.getElementsByTagName("nodo")[i].attributes[3].nodeValue, xmlrespuesta.getElementsByTagName("nodo")[i].attributes[1].nodeValue);
					}
				}
			}
		}
		xmlHttpDispos.open("GET",url,true);
		xmlHttpDispos.send(null);
	}

	function vSituandoNodo()
	{
		if (document.getElementById("comboNodos").length > 0)
		{
			document.getElementById('comboNodos').disabled=true;
			sMACActual=document.getElementById("comboNodos").options[document.getElementById("comboNodos").selectedIndex].id;
			
			google.maps.event.clearListeners(map,"click");
			
			ClickListener = google.maps.event.addListener(map,"click",function(event)
			{
				var newnode_mac;
				var newnode_sus;
				if(event.latLng) 
				{
					newnode_mac = document.getElementById("comboNodos").options[document.getElementById("comboNodos").selectedIndex].id;
					newnode_sus = document.getElementById("comboNodos").options[document.getElementById("comboNodos").selectedIndex].value.substring(3);
					marcadores_nodos_nuevos[numero_marcadores_nuevos] = createNewNode(map, event.latLng, newnode_sus, newnode_mac);
					var sCadenaInfo = "<table><tr><td><br/></td></tr><tr><td><span>"+iObtener_Cadena_AJAX('map_text1')+" "+iObtener_Cadena_AJAX('general21')+" "+newnode_mac+" "+iObtener_Cadena_AJAX('general247')+" "+newnode_sus+"</span></td></tr><tr><td><span>"+iObtener_Cadena_AJAX('map_text2')+"</span></td></tr><tr><td align='center'><input type='button' onclick='onMoveNewNodo(\""+newnode_mac+"\")' value='"+iObtener_Cadena_AJAX('general53')+"' /></td></tr></table>";
					vAbrir_Info_Window(map, marcadores_nodos_nuevos[numero_marcadores_nuevos], sCadenaInfo, 300);
				}
			});
		}
	}

	function onMoveNewNodo(sMACNodo)
	{
		var pNuevoPunto=marcadores_nodos_nuevos[numero_marcadores_nuevos].getPosition();
		document.getElementById('comboNodos').disabled=false;
		document.getElementById("comboNodos").selectedIndex = -1;
		sMACActual="";
		vActualizar_Coordenadas_Nodo(sMACNodo,pNuevoPunto.lat(),pNuevoPunto.lng());
		cargar_nuevos_nodos(top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value);
	}

	function createNewNode(map, point, sus, macnodo)
	{
		var iconoMarca;
		var tamanoIcono;
		var options;
		var sContenidoTT;

		options = { 
				position: point, 
				draggable: true, 
				bouncy: false, 
				title: this.title, 
				icon: new google.maps.MarkerImage(
				        obtener_ruta_icono_nodo("1", "01"), // my 16x48 sprite with 3 circular icons
				        new google.maps.Size(20, 20), // desired size
				        new google.maps.Point(0, 0), // offset within the scaled sprite
				        new google.maps.Point(10, 10), // anchor point is half of the desired size
				        new google.maps.Size(20, 20) // scaled size of the entire sprit
				        ), 
				map: map 
			};
		var marcador_n = new google.maps.Marker(options);
		google.maps.event.addListener(marcador_n, "dragstart", function()
		{
			if (infowindow) infowindow.close();
		});
	
		google.maps.event.addListener(marcador_n, "dragend", function()
		{
			sContenidoTT = "<table><tr><td><span>"+iObtener_Cadena_AJAX('map_text3')+" "+iObtener_Cadena_AJAX('general21')+" "+macnodo+" "+iObtener_Cadena_AJAX('general247')+" "+sus+"</span></td></tr><tr><td><span>"+iObtener_Cadena_AJAX('map_text2')+"</span></td></tr><tr><td align='center'><input type='button' onclick='onMoveNewNodo(\""+macnodo+"\")' value='"+iObtener_Cadena_AJAX('general53')+"' /></td></tr></table>";
			vAbrir_Info_Window(map, marcador_n, sContenidoTT, 600);
		});
	
		google.maps.event.addListener(marcador_n, "click", function()
		{
			window.parent.seleccionar_nodo(macnodo);
			sContenidoTT = "<span>"+iObtener_Cadena_AJAX('general21')+" "+macnodo+"</span>";
			vAbrir_Info_Window(map, marcador_n, sContenidoTT, 200);
			//GEvent.clearListeners(marcador_n, "mouseout");
			//google.maps.event.removeListener(map);
		});
		return marcador_n;
	}
	</script>	
</head>

<body onload="load()">
	<table border="1" width="100%" cellpadding="0" cellspacing="0" >
		<tr>
			<td rowspan="3" style="width:75%"  align="center">
				<div id="mapdiv" style="height: 435px; width: 95%;" class="MapBox" style=align:center;valign:center;background:#515151"></div>
				<noscript><?php echo $idiomas[$_SESSION['opcion_idioma']]['disclaimer_js']?></noscript>
			</td>
			<td style="width:25%" align="center">
				<span>
					<?php echo $idiomas[$_SESSION['opcion_idioma']]['map_text4']?>.
				</span>
				<br></br>
				<span>
					<?php echo $idiomas[$_SESSION['opcion_idioma']]['map_text6']?>.
				</span>
			</td>
		</tr>
		<tr>
			<td align="center">
				<select id="comboNodos" onclick="vSituandoNodo()" onchange="vSituandoNodo()" size="18" style="width:100%;height:140px;margin:0px 0 5px 0;"/>
			</td>
		</tr>
	</table>
<script>
	cargar_nuevos_nodos(top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value);	
</script>
</body>

</html>
