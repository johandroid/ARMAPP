var xmlHttp2;

function GetXmlHttpObject()
{
	var mixmlHttp=null;
	try
	{
		// Firefox, Opera 8.0+, Safari
		mixmlHttp=new XMLHttpRequest();
	}
	catch (e)
	{
		// Internet Explorer
		try
		{
			mixmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		}
			catch (e)
		{
			mixmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
	}
	return mixmlHttp;
}

function parsear_xml(txt)
{
	var xmlDoc;

	try //Internet Explorer
	{
		xmlDoc=new ActiveXObject("Microsoft.XMLDOM");
		xmlDoc.async="false";
		xmlDoc.loadXML(txt);
		return xmlDoc;
	}
	catch(e)
	{
		try // Firefox, Mozilla, Opera, etc.
		{
			parser=new DOMParser();
			xmlDoc=parser.parseFromString(txt,"text/xml");
			return xmlDoc;
		}
		catch(e)
		{
			alert(e.message);
			return;
		}
	}
}

function createGW(map, point, movable, sus, tipo, nombre, estadoOnoff, nuevoEstado)
{
	var iconoMarca;
	var tamanoIcono;
	var options;

	if (movable == 1)
	{
		arrastrable = true;
	}
	else
	{
		arrastrable = false;
	}
	options = { 
			position: point, 
			draggable: arrastrable, 
			bouncy: false, 
			title: this.title, 
			icon: new google.maps.MarkerImage(
			        obtener_ruta_icono_gw(estadoOnoff, nuevoEstado, tipo), // my 16x48 sprite with 3 circular icons
			        new google.maps.Size(40, 40), // desired size
			        new google.maps.Point(0, 0), // offset within the scaled sprite
			        new google.maps.Point(20, 20), // anchor point is half of the desired size
			        new google.maps.Size(40, 40) // scaled size of the entire sprit
			        ),
			map: map 
		};
	var marcador = new google.maps.Marker(options ); 
	anyadir_eventos_marcador(0,map,marcador,sus, tipo, 0,0,nombre);
	return marcador;
}

function createNode(map, point, movable, sus, macnodo, ipnodo, nombre, estadoOnoff, nuevoEstado)
{
	var iconoMarca;
	var tamanoIcono;
	var options;

	if (movable == 1)
	{
		arrastrable = true;
	}
	else
	{
		arrastrable = false;
	}
	options = { 
			position: point, 
			draggable: arrastrable, 
			bouncy: false, 
			title: this.title, 
			icon: new google.maps.MarkerImage(
			        obtener_ruta_icono_nodo(estadoOnoff, nuevoEstado), // my 16x48 sprite with 3 circular icons
			        new google.maps.Size(20, 20), // desired size
			        new google.maps.Point(0, 0), // offset within the scaled sprite
			        new google.maps.Point(10, 10), // anchor point is half of the desired size
			        new google.maps.Size(20, 20) // scaled size of the entire sprit
			        ), 
			map: map 
		};
	var marcador = new google.maps.Marker(options ); 
	anyadir_eventos_marcador(1,map,marcador,sus, 0, macnodo,ipnodo,nombre);
	return marcador;
}

function createUTC(map, point, movable, sus, dirutc, idutc, nombre, estadoOnoff, nuevoEstado)
{
	var iconoMarca;
	var tamanoIcono;
	var options;

	if (movable == 1)
	{
		arrastrable = true;
	}
	else
	{
		arrastrable = false;
	}
	options = { 
			position: point, 
			draggable: arrastrable, 
			bouncy: false, 
			title: this.title, 
			icon: new google.maps.MarkerImage(
			        obtener_ruta_icono_utc(estadoOnoff, nuevoEstado), // my 16x48 sprite with 3 circular icons
			        new google.maps.Size(20, 20), // desired size
			        new google.maps.Point(0, 0), // offset within the scaled sprite
			        new google.maps.Point(10, 10), // anchor point is half of the desired size
			        new google.maps.Size(20, 20) // scaled size of the entire sprit
			        ), 
			map: map 
		};
	var marcador = new google.maps.Marker(options ); 
	anyadir_eventos_marcador(2,map,marcador,sus, 0, dirutc,idutc,nombre);
	return marcador;
}

function vActualizar_Coordenadas_Nodo(sMAC,sLatitud,sLongitud)
{
	var xmlHttpGW= GetXmlHttpObject();
	var url = "actualizar_posicion_nodo.php?cliente_db="+top.document.getElementById('db_cliente').value+"&nodo_mac="+sMAC+"&lat="+sLatitud+"&lon="+sLongitud;
	xmlHttpGW.open("GET",url,false);
	xmlHttpGW.send(null);
	if (xmlHttpGW.responseText=='ERROR')
	{
		
		alert(iObtener_Cadena_AJAX("error_map1")+' '+iObtener_Cadena_AJAX("general21")+" "+sMAC);
	}
	else
	{
		alert(iObtener_Cadena_AJAX("success_map1")+' '+iObtener_Cadena_AJAX("general21")+" "+sMAC);
	}
	if (infowindow) infowindow.close();
}

function vActualizar_Coordenadas_GW(sGateway,sLatitud,sLongitud)
{
	var xmlHttpGW= GetXmlHttpObject();
	var url = "actualizar_posicion_gw.php?cliente_db="+top.document.getElementById('db_cliente').value+"&gw_id="+sGateway+"&lat="+sLatitud+"&lon="+sLongitud;
	xmlHttpGW.open("GET",url,false);
	xmlHttpGW.send(null);
	if (xmlHttpGW.responseText=='ERROR')
	{
		alert(iObtener_Cadena_AJAX("error_map1")+' '+iObtener_Cadena_AJAX("general20")+" "+sGateway);
	}
	else
	{
		alert(iObtener_Cadena_AJAX("success_map1")+' '+iObtener_Cadena_AJAX("general20")+" "+sGateway);
	}
	if (infowindow) infowindow.close();
}

function vActualizar_Coordenadas_UTC(sID,sLatitud,sLongitud,sIP)
{
	var xmlHttpUTC= GetXmlHttpObject();
	var url = "actualizar_posicion_utc.php?cliente_db="+top.document.getElementById('db_cliente').value+"&utc_id="+sID+"&lat="+sLatitud+"&lon="+sLongitud;
	xmlHttpUTC.open("GET",url,false);
	xmlHttpUTC.send(null);
	if (xmlHttpUTC.responseText=='ERROR')
	{
		
		alert(iObtener_Cadena_AJAX("error_map1")+' '+iObtener_Cadena_AJAX("general255")+" "+sIP);
	}
	else
	{
		alert(iObtener_Cadena_AJAX("success_map1")+' '+iObtener_Cadena_AJAX("general255")+" "+sIP);
	}
	if (infowindow) infowindow.close();
}

function vAbrir_Info_Window(mpMapa, mkMarcador, sContenido, iAnchoMax)
{
	if (infowindow) infowindow.close();
	infowindow.setOptions({maxWidth:iAnchoMax});
	infowindow.setContent(sContenido);
	infowindow.setPosition(mkMarcador.latLng);
	infowindow.open(mpMapa,mkMarcador);
}

function anyadir_eventos_marcador(gw_or_node, map_n, marcador_n, gw_n, gw_tipo, macnodo, ipnodo, nombre_n)
{
	var contenido_tooltip;
	var gEvt;	

	google.maps.event.addListener(marcador_n, "dragstart", function()
	{
		if (infowindow) infowindow.close();
	});

	google.maps.event.addListener(marcador_n, "dragend", function()
	{
		if (gw_or_node == 0)
		{
			var pPuntoNuevo = marcador_n.getPosition();
			var sContenidoTT = "<table><tr><td><span>"+iObtener_Cadena_AJAX("map_text1")+" "+iObtener_Cadena_AJAX("general20")+" "+gw_n+"</span></td></tr><tr><td><span>"+iObtener_Cadena_AJAX("map_text2")+"</span></td></tr><tr><td align='center'><input type='button' onclick='vActualizar_Coordenadas_GW(\""+gw_n+"\",\""+pPuntoNuevo.lat()+"\",\""+pPuntoNuevo.lng()+"\")' value='"+iObtener_Cadena_AJAX("general53")+"' /></td></tr></table>";
			vAbrir_Info_Window(map_n, marcador_n, sContenidoTT, 600);
		}
		else if (gw_or_node == 1)
		{
			var pPuntoNuevo = marcador_n.getPosition(); 
			var sContenidoTT = "<table><tr><td><span>"+iObtener_Cadena_AJAX("map_text1")+" "+iObtener_Cadena_AJAX("general21")+" "+macnodo+"</span></td></tr><tr><td><span>"+iObtener_Cadena_AJAX("map_text2")+"</span></td></tr><tr><td align='center'><input type='button' onclick='vActualizar_Coordenadas_Nodo(\""+macnodo+"\",\""+pPuntoNuevo.lat()+"\",\""+pPuntoNuevo.lng()+"\")' value='"+iObtener_Cadena_AJAX("general53")+"' /></td></tr></table>";
			vAbrir_Info_Window(map_n, marcador_n, sContenidoTT, 600);
		}
		else
		{
			var pPuntoNuevo = marcador_n.getPosition(); 
			var sContenidoTT = "<table><tr><td><span>"+iObtener_Cadena_AJAX("map_text1")+" "+iObtener_Cadena_AJAX("general255")+" "+ipnodo+"</span></td></tr><tr><td><span>"+iObtener_Cadena_AJAX("map_text2")+"</span></td></tr><tr><td align='center'><input type='button' onclick='vActualizar_Coordenadas_UTC(\""+macnodo+"\",\""+pPuntoNuevo.lat()+"\",\""+pPuntoNuevo.lng()+"\",\""+ipnodo+"\")' value='"+iObtener_Cadena_AJAX("general53")+"' /></td></tr></table>";
			vAbrir_Info_Window(map_n, marcador_n, sContenidoTT, 600);
		}
	});

	google.maps.event.addListener(marcador_n, "click", function()
	{
		if (gw_or_node == 0)
		{
			window.parent.seleccionar_gw(gw_n);
			
			if(gw_tipo != 1)
			{
				contenido_tooltip = rellenar_tooltip_gw(gw_n);
			}
			else
			{					
				contenido_tooltip = rellenar_tooltip_gw_low(gw_n);						
				google.maps.event.addListener(infowindow, 'domready', function() {
			      $("#tabs").tabs();
			    });
			}				
		}
		else if (gw_or_node == 1)
		{
			window.parent.seleccionar_nodo(macnodo);
			contenido_tooltip = rellenar_tooltip_nodo(gw_n,macnodo);
		}
		else
		{
			window.parent.seleccionar_utc(macnodo);
			contenido_tooltip = rellenar_tooltip_utc(macnodo);
		}
		vAbrir_Info_Window(map_n, marcador_n, contenido_tooltip, 800);
		google.maps.event.clearListeners(marcador_n, "mouseout");
	});

	google.maps.event.addListener(marcador_n, "dblclick", function()
	{
		if (gw_or_node == 0)
		{
			abrir_configuracion_gw(gw_n, gw_tipo);				
		}
		else if (gw_or_node == 1)
		{
			abrir_configuracion_nodo(gw_n,macnodo,ipnodo);
		}
		else
		{
			abrir_configuracion_utc(macnodo,ipnodo);
		}
	});

	google.maps.event.addListener(marcador_n, "mouseover", function()
	{
		if (gw_or_node == 0)
		{
			window.parent.seleccionar_gw(gw_n);
		}
		else if (gw_or_node == 1)
		{
			window.parent.seleccionar_nodo(macnodo);
		}
		else
		{
			window.parent.seleccionar_utc(macnodo);
		}
	/*
		gEvt = google.maps.event.addListener(marcador_n, "mouseout", function()
		{
			if (window.parent.opcion_elegida == 1)
			{
				if (infowindow)
				{
					infowindow.close(map_n);
				}
			}
		});
		*/
	});
}

function rellenar_tooltip_nodo(gw_id,nodo_mac)
{
	xmlHttp2= GetXmlHttpObject();
	var url = "carga_tooltip_nodo.php?instalacion_id=" + top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value + "&gw_id=" + gw_id + "&nodo_mac=" + nodo_mac + "&cliente_db=" + top.document.getElementById("db_cliente").value;
	xmlHttp2.open("GET",url,false);
	xmlHttp2.send(null);

	return xmlHttp2.responseText;
}

function rellenar_tooltip_gw(gw_id)
{
	xmlHttp2= GetXmlHttpObject();
	var url = "carga_tooltip_gw.php?instalacion_id=" + top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value + "&gw_id=" + gw_id + "&cliente_db=" + top.document.getElementById("db_cliente").value;
	xmlHttp2.open("GET",url,false);
	xmlHttp2.send(null);

	return xmlHttp2.responseText;
}

function rellenar_tooltip_utc(disp_id)
{
	xmlHttp2= GetXmlHttpObject();
	var url = "carga_tooltip_utc.php?instalacion_id=" + top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value + "&disp_id=" + disp_id + "&cliente_db=" + top.document.getElementById("db_cliente").value;
	xmlHttp2.open("GET",url,false);
	xmlHttp2.send(null);

	return xmlHttp2.responseText;
}
/*
function rellenar_tooltip_gw_pestanas(gw_id, num_pestana)
{
	xmlHttp2= GetXmlHttpObject();
	var url = "carga_tooltip_gw.php?instalacion_id=" + top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value + "&gw_id=" + gw_id + "&cliente_db=" + top.document.getElementById("db_cliente").value + "&num_pestana="+num_pestana;
	xmlHttp2.open("GET",url,false);
	xmlHttp2.send(null);
	
	return xmlHttp2.responseText;
}

function rellenar_tooltip_gw_todas_pestanas(gw_id)
{
	xmlHttp1= GetXmlHttpObject();
	var contenido_pestanas;
	var url = "carga_todas_pestanas_gw.php?instalacion_id=" + top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value + "&gw_id=" + gw_id + "&cliente_db=" + top.document.getElementById("db_cliente").value;
	xmlHttp1.open("GET",url, false);

	xmlHttp1.send(null);
	
	contenido_pestanas = eval("(" + xmlHttp1.responseText + ")");										
						
	return contenido_pestanas;				
}
*/
function rellenar_tooltip_gw_low(gw_id)
{
	xmlHttp1= GetXmlHttpObject();
	var url = "carga_tooltip_gw_low.php?instalacion_id=" + top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value + "&gw_id=" + gw_id + "&cliente_db=" + top.document.getElementById("db_cliente").value;
	xmlHttp1.open("GET",url, false);
	xmlHttp1.send(null);
	return xmlHttp1.responseText;				
}

function abrir_configuracion_nodo(gw_id, nodo_mac, nodo_ip)
{
	window.parent.OnConfiguracion(1, gw_id, nodo_mac, nodo_ip);
}

function abrir_configuracion_utc(disp_id,disp_ip)
{
	window.parent.OnConfiguracion(11, disp_id, disp_ip, 0);
}

function abrir_configuracion_gw(gw_id, gw_tipo)
{
	if(gw_tipo == 0)
	{
		window.parent.OnConfiguracion(0, gw_id, 0, 0);	
	}
	else if(gw_tipo == 1)
	{
		window.parent.OnConfiguracion(13, gw_id, 0, 0);	
	}
	else if(gw_tipo == 2)
	{
		window.parent.OnConfiguracion(14, gw_id, 0, 0);	
	}
}

function obtener_ruta_icono_gw(estadoOnoff, nuevoEstado, tipo)
{
	var sResultado;
	var sCarpeta = "";

	//AMB 02/04/2012 Elegimos carpeta de imágenes según tipo de GW
	if(tipo == 0)
	{
		carpeta = "Normal";
	}
	else if(tipo == 1)
	{
		carpeta = "LowPower";
	}
	else if(tipo == 2)
	{
		carpeta = "LowPowerTragsa";
	}
    //alert(estadoOnoff+" "+nuevoEstado+" "+tipo);
	if (estadoOnoff == '0')
	{
		sResultado = "images/GW_icons/"+carpeta+"/gw_rojo.png";
	}
	else if (nuevoEstado != null)
	{
		if (nuevoEstado.charAt(0) == '0')
		{
			switch (nuevoEstado.charAt(1))
			{
				case '1':
					sResultado ="images/GW_icons/"+carpeta+"/gw_verde.png";
					break;
				case '2':
					sResultado ="images/GW_icons/"+carpeta+"/gw_amarillo.png";
					break;
				case '3':
					sResultado ="images/GW_icons/"+carpeta+"/gw_naranja.png";
					break;
				default:
					sResultado ="images/GW_icons/"+carpeta+"/gw_azul.png";
					break;
			}
		}
		else
		{
			switch (nuevoEstado.charAt(1))
			{
				case '1':
					sResultado ="images/GW_icons/"+carpeta+"/gw_verde_alert.png";
					break;
				case '2':
					sResultado ="images/GW_icons/"+carpeta+"/gw_amarillo_alert.png";
					break;
				case '3':
					sResultado ="images/GW_icons/"+carpeta+"/gw_naranja_alert.png";
					break;
				default:
					sResultado ="images/GW_icons/"+carpeta+"/gw_azul_alert.png";
					break;
			}
		}
	}
	return sResultado;
}

function asignar_icono_gw(marcadorGw, estadoOnoff, nuevoEstado, tipo)
{
	var sRuta = new google.maps.MarkerImage(
			        obtener_ruta_icono_gw(estadoOnoff, nuevoEstado, tipo), // my 16x48 sprite with 3 circular icons
			        new google.maps.Size(40, 40), // desired size
			        new google.maps.Point(0, 0), // offset within the scaled sprite
			        new google.maps.Point(20, 20), // anchor point is half of the desired size
			        new google.maps.Size(40, 40) // scaled size of the entire sprit
			        );
	marcadorGw.setIcon(sRuta);
}

function obtener_ruta_icono_nodo(estadoOnoff, nuevoEstadoNodo)
{
	var sResultado;
	
	if (estadoOnoff == '0')
	{
		sResultado ="images/Node_icons/led_rojo.png";
	}
	else if (nuevoEstadoNodo != null)
	{
		if (nuevoEstadoNodo.charAt(0) == '0')
		{
			switch (nuevoEstadoNodo.charAt(1))
			{
				case '1':
					sResultado ="images/Node_icons/led_verde.png";
					break;
				case '2':
					sResultado ="images/Node_icons/led_amarillo.png";
					break;
				case '3':
					sResultado ="images/Node_icons/led_naranja.png";
					break;
				default:
					sResultado ="images/Node_icons/led_azul.png";
					break;
			}
		}
		else
		{
			switch (nuevoEstadoNodo.charAt(1))
			{
				case '1':
					sResultado ="images/Node_icons/led_verde_alert.png";
					break;
				case '2':
					sResultado ="images/Node_icons/led_amarillo_alert.png";
					break;
				case '3':
					sResultado ="images/Node_icons/led_naranja_alert.png";
					break;
				default:
					sResultado ="images/Node_icons/led_azul_alert.png";
					break;
			}
		}
	}
	//alert(sResultado);
	return sResultado;
}

function obtener_ruta_icono_utc(estadoOnoff, nuevoEstadoNodo)
{
	var sResultado;
	
	if (estadoOnoff == '0')
	{
		sResultado ="images/UTC_icons/led_rojo.png";
	}
	else if (nuevoEstadoNodo != null)
	{
		switch (nuevoEstadoNodo.charAt(1))
		{
			case '1':
				sResultado ="images/UTC_icons/led_verde.png";
				break;
			case '2':
				sResultado ="images/UTC_icons/led_amarillo.png";
				break;
			case '3':
				sResultado ="images/UTC_icons/led_naranja.png";
				break;
			default:
				sResultado ="images/UTC_icons/led_azul.png";
				break;
		}
	}
	
	return sResultado;
}

function asignar_icono_nodo(MarcadorNodo, estadoOnoff, nuevoEstadoNodo)
{
	var sRuta = new google.maps.MarkerImage(
			        obtener_ruta_icono_nodo(estadoOnoff, nuevoEstadoNodo), // my 16x48 sprite with 3 circular icons
			        new google.maps.Size(20, 20), // desired size
			        new google.maps.Point(0, 0), // offset within the scaled sprite
			        new google.maps.Point(10, 10), // anchor point is half of the desired size
			        new google.maps.Size(20, 20) // scaled size of the entire sprit
			        );
	MarcadorNodo.setIcon(sRuta);
}

function asignar_icono_utc(MarcadorUTC, estadoOnoff, nuevoEstadoNodo)
{
	var sRuta = new google.maps.MarkerImage(
			        obtener_ruta_icono_utc(estadoOnoff, nuevoEstadoNodo), // my 16x48 sprite with 3 circular icons
			        new google.maps.Size(20, 20), // desired size
			        new google.maps.Point(0, 0), // offset within the scaled sprite
			        new google.maps.Point(10, 10), // anchor point is half of the desired size
			        new google.maps.Size(20, 20) // scaled size of the entire sprit
			        );
	MarcadorUTC.setIcon(sRuta);
}

function vBorrar_Marcadores()
{
	var iContador;
	for (iContador = 0; iContador < marcadores_gateways.length;iContador++)
	{
		if (marcadores_gateways[iContador])
		{
			marcadores_gateways[iContador].setMap(null);
		} 
	}
	
	for (iContador = 0; iContador < marcadores_nodos.length;iContador++)
	{
		if (marcadores_nodos[iContador])
		{
			marcadores_nodos[iContador].setMap(null);
		} 
	}
	
	for (iContador = 0; iContador < marcadores_utcs.length;iContador++)
	{
		if (marcadores_utcs[iContador])
		{
			marcadores_utcs[iContador].setMap(null);
		} 
	}
}
