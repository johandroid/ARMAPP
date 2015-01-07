function rellenar_instalacion_tras_recargar(doc)
{
	var sNombreCombo;
	var iAnyadir;	
	var xmlrespuesta = parsear_xml(doc);
	x=xmlrespuesta.getElementsByTagName("gateway");
	iAnyadir = 1;
	
	switch(opcion_elegida)
	{
		case 1:
			sNombreCombo = "comboGateways";
			document.getElementById(sNombreCombo).length=0;
			break;
		case 2:
		case 69:
		case 83:
		case 84:
		case 89:
		case 90:
			sNombreCombo = "Filtro_combo_GW";
			document.getElementById(sNombreCombo).length=0;
			insertarOptionCombo(sNombreCombo,"000", iObtener_Cadena_AJAX('general248'));
			break;		
		default:
			sNombreCombo = "";
			iAnyadir = 0;
			break;
	}
	if (iAnyadir == 1)
	{
		for(i=0;i<x.length;i++)
		{
			if (xmlrespuesta.getElementsByTagName("gateway")[i].attributes[1].nodeValue.length == 0)
			{
				insertarOptionCombo(sNombreCombo,xmlrespuesta.getElementsByTagName("gateway")[i].attributes[0].nodeValue, iObtener_Cadena_AJAX('general20')+' '+xmlrespuesta.getElementsByTagName("gateway")[i].attributes[0].nodeValue);
			}
			else
			{
				insertarOptionCombo(sNombreCombo,xmlrespuesta.getElementsByTagName("gateway")[i].attributes[0].nodeValue, xmlrespuesta.getElementsByTagName("gateway")[i].attributes[1].nodeValue);
			}
		}
	}
	x=xmlrespuesta.getElementsByTagName("nodo");
	iAnyadir = 1;
	switch(opcion_elegida)
	{
		case 1:
			sNombreCombo = "comboNodos";
			document.getElementById(sNombreCombo).length=0;
			break;
		case 2:
		case 69:
		case 89:
		case 90:
			sNombreCombo = "Filtro_combo_Nodo";
			document.getElementById(sNombreCombo).length=0;
			insertarOptionCombo(sNombreCombo,"000", iObtener_Cadena_AJAX('general249'));
			break;
		default:
			sNombreCombo = "";
			iAnyadir = 0;
			break;
	}
	if (iAnyadir == 1)
	{
		for(i=0;i<x.length;i++)
		{
			if (xmlrespuesta.getElementsByTagName("nodo")[i].attributes[1].nodeValue.length == 0)
			{
				insertarOptionCombo(sNombreCombo,xmlrespuesta.getElementsByTagName("nodo")[i].attributes[2].nodeValue, iObtener_Cadena_AJAX('general21')+' '+xmlrespuesta.getElementsByTagName("nodo")[i].attributes[2].nodeValue);
			}
			else
			{
				insertarOptionCombo(sNombreCombo,xmlrespuesta.getElementsByTagName("nodo")[i].attributes[2].nodeValue, xmlrespuesta.getElementsByTagName("nodo")[i].attributes[1].nodeValue);
			}
		}
	}
	x=xmlrespuesta.getElementsByTagName("utc");
	iAnyadir = 1;
	switch(opcion_elegida)
	{
		case 1:
			sNombreCombo = "comboUTCs";
			document.getElementById(sNombreCombo).length=0;
			break;
		case 2:
		case 69:
		case 89:
		case 90:
			sNombreCombo = "Filtro_combo_UTC";
			document.getElementById(sNombreCombo).length=0;
			insertarOptionCombo(sNombreCombo,"000", iObtener_Cadena_AJAX('general258'));
			break;
		default:
			sNombreCombo = "";
			iAnyadir = 0;
			break;
	}
	if (iAnyadir == 1)
	{
		for(i=0;i<x.length;i++)
		{
			if (xmlrespuesta.getElementsByTagName("utc")[i].attributes[1].nodeValue.length == 0)
			{
				insertarOptionCombo(sNombreCombo,xmlrespuesta.getElementsByTagName("utc")[i].attributes[0].nodeValue, iObtener_Cadena_AJAX('general255')+' '+xmlrespuesta.getElementsByTagName("utc")[i].attributes[2].nodeValue);
			}
			else
			{
				insertarOptionCombo(sNombreCombo,xmlrespuesta.getElementsByTagName("utc")[i].attributes[0].nodeValue, xmlrespuesta.getElementsByTagName("utc")[i].attributes[1].nodeValue);
			}
		}
	}
}

function recargar_instalacion(instalacion)
{
	var xmlHttpInst;	
	xmlHttpInst= GetXmlHttpObject();
	var url = "carga_instalacion.php?instalacion_id=" + instalacion + "&cliente_db=" + top.document.getElementById("db_cliente").value;
	xmlHttpInst.open("GET",url,false);
	xmlHttpInst.send(null);
	var doc=xmlHttpInst.responseText;	
	rellenar_instalacion_tras_recargar(doc);
}

function rellenar_div_principal(opcion_menu, otras_opciones)
{
	var xmlHttppp= GetXmlHttpObject();
	var url = "rellenar_div_principal.php?menu=" + opcion_menu + otras_opciones;
	xmlHttppp.open("GET",url,false);
	xmlHttppp.send(null);
	document.getElementById("iframe_mapa").src = xmlHttppp.responseText;	
}
function actualiza_div_submenu()
{
	if (xmlHttpbis.readyState==4)
	{
		var doc=xmlHttpbis.responseText;
		document.getElementById("celda_submenu").innerHTML = doc;
	}
}
function rellenar_div_submenu(opcion_menu, otras_opciones)
{
	xmlHttpbis= GetXmlHttpObject();
	var url = "rellenar_div_submenu.php?menu=" + opcion_menu + otras_opciones;
	//xmlHttpbis.onreadystatechange=actualiza_div_submenu;
	xmlHttpbis.open("GET",url,false);
	xmlHttpbis.send(null);
	actualiza_div_submenu();
}
var xmlhttpinstlist;
function actualiza_lista_instalaciones()
{
	if (xmlhttpinstlist.readyState==4)
	{
		var doc=xmlhttpinstlist.responseText;
		select_innerHTML(document.getElementById('comboInstalaciones'), doc);
	}
}
function rellenar_lista_instalaciones(db_cliente)
{
	xmlhttpinstlist= GetXmlHttpObject();
	var url = "carga_lista_instalaciones.php?cliente_db=" + db_cliente;
	xmlhttpinstlist.open("GET",url,false);
	xmlhttpinstlist.send(null);
	actualiza_lista_instalaciones();
}
function OnChangeInstalacion()
{
	switch (opcion_elegida)
	{
		case 1:
			if (iObtener_Modo_Offline() == 0)
			{
				rellenar_div_submenu(1,"");
				document.getElementById("comboNodos").selectedIndex=-1;
				document.getElementById("comboGateways").selectedIndex=-1;
				if (document.getElementById("comboInstalaciones").selectedIndex!=-1)
				{
					recargar_instalacion(document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
					document.getElementById("iframe_mapa").contentWindow.recargar_nodos_mapa(document.getElementById("db_cliente").value, document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
				}
			}
			else
			{
				rellenar_div_submenu(99,"");
			}			
			break;
		case 2:
			rellenar_div_submenu(2,"");
			if (document.getElementById("comboInstalaciones").selectedIndex != -1)
			{
				recargar_instalacion(document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
			}
			Rellenar_Sensores_Filtro(0);
			Rellenar_Eventos_Filtro(0);
			Rellenar_SensoresGW_Filtro(0);
			Rellenar_Sensores_UTC_Filtro(0);
			var idioma=iObtener_Cadena_AJAX('idioma');
			Protoplasm.use('datepicker').transform('.datepicker', { locale: idioma+'_iso8601', timePicker: true, use24hrs: true , manual: false}); 
			rellenar_div_principal(2,"&instalacion_id="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
			break;
		case 3:	
			Rellenar_Tipo_Informes();
			onTipoInforme();
			if (document.getElementById("comboInstalaciones").selectedIndex != -1)
			{
				recargar_instalacion(document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
			}			
			vRellenar_Controles_Informes();			
			rellenar_div_principal(82,"");
			cargar_plantillas("Plantillas_Lista",document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value,document.getElementById("user_name").value);
			break;
		case 7:
			rellenar_div_submenu(7,"");
			rellenar_div_principal(7,"&instalacion_id="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
			break;
		case 4:
		case 6:
		case 17:
		case 18:
			rellenar_div_submenu(7,"");
			rellenar_div_principal(7,"&instalacion_id="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
			break;
		case 67:
		case 68:
			rellenar_div_principal(opcion_elegida,"");
			break;
		case 69:
			rellenar_div_principal(opcion_elegida,"");
			if (document.getElementById("comboInstalaciones").selectedIndex != -1)
			{
				recargar_instalacion(document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
			}
			break;
		case 89:
		case 90:
			if (document.getElementById("comboInstalaciones").selectedIndex != -1)
			{
				recargar_instalacion(document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
				OnSelectEventos(document.getElementById("selEvento").selectedIndex, 1);
			}
			break;
			
		case 83:
			var idioma=iObtener_Cadena_AJAX('idioma');
			Protoplasm.use('datepicker').transform('.datepicker', { locale: idioma+'_iso8601', timePicker: true, use24hrs: true , manual: false}); 
			rellenar_div_principal(83,"&instalacion_id="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
			if (document.getElementById("comboInstalaciones").selectedIndex != -1)
			{
				recargar_instalacion(document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
			}
			break;
		case 84:
			var idioma=iObtener_Cadena_AJAX('idioma');
			Protoplasm.use('datepicker').transform('.datepicker', { locale: idioma+'_iso8601', timePicker: true, use24hrs: true , manual: false}); 
			rellenar_div_principal(88,"&instalacion_id="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
			if (document.getElementById("comboInstalaciones").selectedIndex != -1)
			{
				recargar_instalacion(document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
			}
			break;
		case 72:
		case 73:
			rellenar_div_submenu(7,"");
			rellenar_div_submenu(99,"");
			break;
		default:
			break;	
	}
}
function OnBotonMapa(iOffline)
{	
	if (opcion_elegida != 1)
	{
		opcion_elegida = 1;
		document.getElementById("comboInstalaciones").disabled="";
		if (iOffline == 0)
		{
			rellenar_div_principal(1,"");
			rellenar_div_submenu(1,"");
		}
		else
		{
			rellenar_div_principal(80,"");
			rellenar_div_submenu(99,"");
		}
		document.getElementById("boton_mapas").style.color="#990000";
		document.getElementById("boton_datos").style.color="#333";
		document.getElementById("boton_informes").style.color="#333";
		document.getElementById("boton_procesado").style.color="#333";
		document.getElementById("boton_soporte").style.color="#333";
		document.getElementById("boton_gestion").style.color="#333";
		document.getElementById("boton_notificacion").style.color="#333";
		if (document.getElementById("comboInstalaciones").selectedIndex != -1)
		{
			recargar_instalacion(document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
		}
		else
		{
			rellenar_div_principal(23,"");
		}		
	}
	return;
}
function OnBotonDatos()
{
	if (opcion_elegida != 2)
	{			
		opcion_elegida = 2;	
		document.getElementById("comboInstalaciones").disabled="";
		document.getElementById("boton_mapas").style.color="#333";
		document.getElementById("boton_datos").style.color="#990000";
		document.getElementById("boton_informes").style.color="#333";
		document.getElementById("boton_procesado").style.color="#333";
		document.getElementById("boton_gestion").style.color="#333";
		document.getElementById("boton_soporte").style.color="#333";
		document.getElementById("boton_notificacion").style.color="#333";
		
		rellenar_div_submenu(2,"");		
		//Protoplasm.load();
		var idioma=iObtener_Cadena_AJAX('idioma');
		Protoplasm.use('datepicker').transform('.datepicker', { locale: idioma+'_iso8601', timePicker: true, use24hrs: true , manual: false}); 
		if (document.getElementById("comboInstalaciones").selectedIndex!=-1)
		{
			recargar_instalacion(document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
			Rellenar_Sensores_Filtro(0);
			Rellenar_Eventos_Filtro(0);
			Rellenar_SensoresGW_Filtro(0);
			Rellenar_Sensores_UTC_Filtro(0);
			rellenar_div_principal(2,"&instalacion_id="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);			
		}
		else
		{
			rellenar_div_principal(23,"");
		}
	}
	return;
}
function OnBotonProcesado()
{
	if (opcion_elegida != 83)
	{
		opcion_elegida = 83;
		document.getElementById("comboInstalaciones").disabled="";
		
		if (document.getElementById("comboInstalaciones").selectedIndex!=-1)
		{
			rellenar_div_submenu(83,"");
			
			var idioma=iObtener_Cadena_AJAX('idioma');
			Protoplasm.use('datepicker').transform('.datepicker', { locale: idioma+'_iso8601', timePicker: true, use24hrs: true , manual: false}); 
			rellenar_div_principal(83,"&instalacion_id="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
			if (document.getElementById("comboInstalaciones").selectedIndex != -1)
			{
				recargar_instalacion(document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
			}
		}
		else
		{
			rellenar_div_principal(23,"");
			rellenar_div_submenu(99,"");
		}		
		document.getElementById("boton_mapas").style.color="#333";
		document.getElementById("boton_datos").style.color="#333";
		document.getElementById("boton_informes").style.color="#333";
		document.getElementById("boton_procesado").style.color="#990000";
		document.getElementById("boton_gestion").style.color="#333";
		document.getElementById("boton_soporte").style.color="#333";
		document.getElementById("boton_notificacion").style.color="#333";
	}
	return;
}
function OnDatosDatosGW(id_gw)
{
	var iCuenta;
	if (opcion_elegida != 2)
	{			
		opcion_elegida = 2;	
		document.getElementById("comboInstalaciones").disabled="";
		document.getElementById("boton_mapas").style.color="#333";
		document.getElementById("boton_datos").style.color="#990000";
		document.getElementById("boton_informes").style.color="#333";
		document.getElementById("boton_procesado").style.color="#333";
		document.getElementById("boton_gestion").style.color="#333";
		document.getElementById("boton_soporte").style.color="#333";
		document.getElementById("boton_notificacion").style.color="#333";	
		
		rellenar_div_submenu(2,"");
		
		var idioma=iObtener_Cadena_AJAX('idioma');
		Protoplasm.use('datepicker').transform('.datepicker', { locale: idioma+'_iso8601', timePicker: true, use24hrs: true , manual: false}); 
		if (document.getElementById("comboInstalaciones").selectedIndex != -1)
		{
			recargar_instalacion(document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
		}
		
		top.document.getElementById("Ver_GW_Check").checked = true;
		top.document.getElementById("Ver_UTC_Check").checked = false;
		top.document.getElementById("Ver_Nodo_Check").checked = false;
		for (iCuenta=0; iCuenta<top.document.getElementById("Filtro_combo_GW").length;iCuenta++)
		{
			if ((top.document.getElementById("Filtro_combo_GW").options[iCuenta].id) == id_gw)
			{
				top.document.getElementById("Filtro_combo_GW").selectedIndex = iCuenta;
				break;
			}
		}		
		Rellenar_Sensores_Filtro(0);
		Rellenar_Eventos_Filtro(0);
		Rellenar_SensoresGW_Filtro(0);
		Rellenar_Sensores_UTC_Filtro(0);
		rellenar_div_principal(2,"&instalacion_id="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value+"&gw_id="+id_gw);
	}
	return;
}
function OnDatosDatosNodo(id_gw, mac_nodo)
{
	var iCuenta;
	if (opcion_elegida != 2)
	{
		opcion_elegida = 2;
		document.getElementById("comboInstalaciones").disabled="";
		document.getElementById("boton_mapas").style.color="#333";
		document.getElementById("boton_datos").style.color="#990000";
		document.getElementById("boton_informes").style.color="#333";
		document.getElementById("boton_procesado").style.color="#333";
		document.getElementById("boton_gestion").style.color="#333";
		document.getElementById("boton_soporte").style.color="#333";
		document.getElementById("boton_notificacion").style.color="#333";
		
		rellenar_div_submenu(2,"");
		
		var idioma=iObtener_Cadena_AJAX('idioma');
		Protoplasm.use('datepicker').transform('.datepicker', { locale: idioma+'_iso8601', timePicker: true, use24hrs: true , manual: false}); 
		
		if (document.getElementById("comboInstalaciones").selectedIndex != -1)
		{
			recargar_instalacion(document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
		}
		top.document.getElementById("Ver_GW_Check").checked = false;
		top.document.getElementById("Ver_UTC_Check").checked = false;
		top.document.getElementById("Ver_Nodo_Check").checked = true;
		for (iCuenta=0; iCuenta<top.document.getElementById("Filtro_combo_Nodo").length;iCuenta++)
		{
			if ((top.document.getElementById("Filtro_combo_Nodo").options[iCuenta].id) == mac_nodo)
			{
				top.document.getElementById("Filtro_combo_Nodo").selectedIndex = iCuenta;
				break;
			}
		}		
		Rellenar_Sensores_Filtro(0);
		Rellenar_Eventos_Filtro(0);
		Rellenar_SensoresGW_Filtro(0);	
		Rellenar_Sensores_UTC_Filtro(0);
		rellenar_div_principal(2,"&instalacion_id="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value+"&gw_id="+id_gw+"&nodo_mac="+mac_nodo);		
	}
	return;
}

function OnDatosDatosUTC(id_disp)
{
	var iCuenta;
	if (opcion_elegida != 2)
	{
		opcion_elegida = 2;
		document.getElementById("comboInstalaciones").disabled="";
		document.getElementById("boton_mapas").style.color="#333";
		document.getElementById("boton_datos").style.color="#990000";
		document.getElementById("boton_informes").style.color="#333";
		document.getElementById("boton_procesado").style.color="#333";
		document.getElementById("boton_gestion").style.color="#333";
		document.getElementById("boton_soporte").style.color="#333";
		document.getElementById("boton_notificacion").style.color="#333";
		
		rellenar_div_submenu(2,"");
		
		var idioma=iObtener_Cadena_AJAX('idioma');
		Protoplasm.use('datepicker').transform('.datepicker', { locale: idioma+'_iso8601', timePicker: true, use24hrs: true , manual: false}); 
		if (document.getElementById("comboInstalaciones").selectedIndex != -1)
		{
			recargar_instalacion(document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
		}
		top.document.getElementById("Ver_GW_Check").checked = false;
		top.document.getElementById("Ver_Nodo_Check").checked = false;
		top.document.getElementById("Ver_UTC_Check").checked = true;
		for (iCuenta=0; iCuenta<top.document.getElementById("Filtro_combo_UTC").length;iCuenta++)
		{
			if ((top.document.getElementById("Filtro_combo_UTC").options[iCuenta].id) == id_disp)
			{
				top.document.getElementById("Filtro_combo_UTC").selectedIndex = iCuenta;
				break;
			}
		}		
		Rellenar_Sensores_Filtro(0);
		Rellenar_Eventos_Filtro(0);
		Rellenar_SensoresGW_Filtro(0);	
		Rellenar_Sensores_UTC_Filtro(0);
		rellenar_div_principal(2,"&instalacion_id="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value+"&nodo_mac="+id_disp);		
	}
	return;
}
function OnBotonInformes()
{
	if (opcion_elegida != 3)
	{
		opcion_elegida = 3;
		document.getElementById("comboInstalaciones").disabled="";
		
		
		
		if (document.getElementById("comboInstalaciones").selectedIndex!=-1)
		{
			rellenar_div_submenu(3,"");
			
			var idioma=iObtener_Cadena_AJAX('idioma');
			Protoplasm.use('datepicker').transform('.datepicker', { locale: idioma+'_iso8601', timePicker: true, use24hrs: true , manual: false}); 
			recargar_instalacion(document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);			
			rellenar_div_principal(82,"");
		}
		else
		{
			rellenar_div_principal(23,"");
			rellenar_div_submenu(99,"");
		}		
		
		document.getElementById("boton_mapas").style.color="#333";
		document.getElementById("boton_datos").style.color="#333";
		document.getElementById("boton_informes").style.color="#990000";
		document.getElementById("boton_procesado").style.color="#333";
		document.getElementById("boton_gestion").style.color="#333";
		document.getElementById("boton_soporte").style.color="#333";
		document.getElementById("boton_notificacion").style.color="#333";

		Rellenar_Tipo_Informes();
		onTipoInforme();
		cargar_plantillas("Plantillas_Lista",document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value,document.getElementById("user_name").value);
	}
	return;
}
function OnBotonGestion()
{
	if (opcion_elegida != 7)
	{
		opcion_elegida = 7;
		document.getElementById("comboInstalaciones").disabled="";
		if (document.getElementById("comboInstalaciones").selectedIndex!=-1)
		{
			rellenar_div_principal(7,"&instalacion_id="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);			
			recargar_instalacion(document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
		}
		else
		{
			rellenar_div_principal(23,"");
		}
		rellenar_div_submenu(7,"");
			
		document.getElementById("boton_mapas").style.color="#333";
		document.getElementById("boton_datos").style.color="#333";
		document.getElementById("boton_informes").style.color="#333";
		document.getElementById("boton_procesado").style.color="#333";
		document.getElementById("boton_gestion").style.color="#990000";
		document.getElementById("boton_soporte").style.color="#333";
		document.getElementById("boton_notificacion").style.color="#333";	
	}
	return;
}
function OnBotonSoporte()
{
	if (opcion_elegida != 8)
	{
		opcion_elegida = 8;
		document.getElementById("comboInstalaciones").disabled="";
		rellenar_div_principal(8,"");
		rellenar_div_submenu(8,"");
		document.getElementById("boton_mapas").style.color="#333";
		document.getElementById("boton_datos").style.color="#333";
		document.getElementById("boton_informes").style.color="#333";
		document.getElementById("boton_procesado").style.color="#333";
		document.getElementById("boton_gestion").style.color="#333";
		document.getElementById("boton_notificacion").style.color="#333";
		document.getElementById("boton_soporte").style.color="#990000";		
	}
	return;
}
function OnBotonAyuda()
{
	if (opcion_elegida != 9)
	{
		opcion_elegida = 9;
		document.getElementById("comboInstalaciones").disabled="";
		rellenar_div_principal(9,"");
		rellenar_div_submenu(9,"");
		document.getElementById("boton_mapas").style.color="#333";
		document.getElementById("boton_datos").style.color="#333";
		document.getElementById("boton_informes").style.color="#333";
		document.getElementById("boton_procesado").style.color="#333";
		document.getElementById("boton_gestion").style.color="#333";
		document.getElementById("boton_soporte").style.color="#333";
		document.getElementById("boton_notificacion").style.color="#333";
	}
	return;
}
function vPerfil()
{
	if (opcion_elegida != 16)
	{
		opcion_elegida = 16;
		rellenar_div_principal(16,"");
		rellenar_div_submenu(16,"");
		document.getElementById("boton_mapas").style.color="#333";
		document.getElementById("boton_datos").style.color="#333";
		document.getElementById("boton_informes").style.color="#333";
		document.getElementById("boton_procesado").style.color="#333";
		document.getElementById("boton_gestion").style.color="#333";
		document.getElementById("boton_soporte").style.color="#333";
		document.getElementById("boton_notificacion").style.color="#333";
	}
}
function OnEliminarNodo(gw_object,node_mac,node_ip)
{
	rellenar_div_principal(21,"&gw_id="+gw_object+"&objeto_id="+node_mac+"&objecto_ip="+node_ip);
}
function OnEliminarGateway(gw_object,node_mac,node_ip)
{
	rellenar_div_principal(22,"&objeto_id="+gw_object);
}

function OnEliminarUTC(id_object,ip_object,texto_opcion)
{
	rellenar_div_principal(27,"&objeto_id="+id_object+"&objeto_ip="+ip_object+"&objeto_texto="+texto_opcion);
}

function OnEliminarGatewayLow(gw_object,node_mac,node_ip)
{
	rellenar_div_principal(39,"&objeto_id="+gw_object);
}
function OnEliminarGatewayLowT(gw_object,node_mac,node_ip)
{
	rellenar_div_principal(34,"&objeto_id="+gw_object);
}
function OnConfiguracion(gw_or_node, gw_object, node_mac, node_ip)
{
	switch (gw_or_node)
	{
		case 1:
			opcion_elegida = 4;
			rellenar_div_principal(4, "&gw_id="+gw_object+"&objeto_id="+node_mac+"&objecto_ip="+node_ip+"&instalacion_id="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value+"&cliente_db=" + top.document.getElementById("db_cliente").value);
			rellenar_div_submenu(4,"");				
			break;
			
		case 2:
			opcion_elegida = 4;
			rellenar_div_principal(4, "&gw_id="+gw_object+"&objeto_id="+node_mac+"&objecto_ip="+node_ip+"&instalacion_id="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value+"&cliente_db=" + top.document.getElementById("db_cliente").value);				
			break;
			
		case 3:
			opcion_elegida = 6;
			rellenar_div_principal(6, "&objeto_id="+gw_object);				
			break;
			
		case 4:
			opcion_elegida = 17;
			rellenar_div_principal(17, "&objeto_id="+gw_object);				
			break;
			
		case 5:
			opcion_elegida = 18;
			rellenar_div_principal(18, "&gw_id="+gw_object+"&objeto_id="+node_mac+"&objecto_ip="+node_ip);				
			break;
			
		case 6:
			opcion_elegida = 31;
			rellenar_div_principal(31, "&objeto_id="+gw_object);	
			break;
		case 7:
			opcion_elegida = 33;
			rellenar_div_principal(33, "&objeto_id="+gw_object);				
			break;
			
		case 8:
			opcion_elegida = 36;
			rellenar_div_principal(36, "&objeto_id="+gw_object);
			break;
		case 9:
			opcion_elegida = 38;
			rellenar_div_principal(38, "&objeto_id="+gw_object);				
			break;
		case 10:
			opcion_elegida = 41;
			rellenar_div_principal(41, "&objeto_id="+gw_object);				
			break;		
		case 11:
			opcion_elegida = 26;
			rellenar_div_principal(26, "&objeto_id="+gw_object+"&objeto_ip="+node_mac);
			//rellenar_div_submenu(26,"");				
			break;
		case 12:
			opcion_elegida = 26;
			rellenar_div_principal(26, "&objeto_id="+gw_object+"&objeto_ip="+node_mac);
			//rellenar_div_submenu(26,"");				
			break;						
		case 13:
			opcion_elegida = 31;
			rellenar_div_principal(31, "&objeto_id="+gw_object+"&objeto_ip="+node_mac);
			rellenar_div_submenu(31,"");				
			break;
		case 14:
			opcion_elegida = 36;
			rellenar_div_principal(36, "&objeto_id="+gw_object+"&objeto_ip="+node_mac);
			rellenar_div_submenu(36,"");
			break;
		case 72:
			opcion_elegida = 72;
			rellenar_div_principal(72, "&instalacion_id="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value+"&cliente_db=" + top.document.getElementById("db_cliente").value + "&objeto_id="+gw_object);
			break;
		case 73:
			opcion_elegida = 73;
			rellenar_div_principal(73, "&instalacion_id="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value+"&cliente_db=" + top.document.getElementById("db_cliente").value + "&objeto_id="+gw_object);
			break;		
		case 0:
		default:			
			opcion_elegida = 6;
			rellenar_div_principal(6, "&objeto_id="+gw_object);
			rellenar_div_submenu(6,"");				
			break;
	}
	document.getElementById("boton_mapas").style.color="#333";
	document.getElementById("boton_datos").style.color="#333";
	document.getElementById("boton_informes").style.color="#333";
	document.getElementById("boton_procesado").style.color="#333";
	document.getElementById("boton_gestion").style.color="#333";
	document.getElementById("boton_soporte").style.color="#333";	
	document.getElementById("boton_notificacion").style.color="#333";
	return;
}

function OnSelectEventos(iEntEv,iForzar)
{
	var iPrimer;
	var opcion_temporal;
	var idioma=iObtener_Cadena_AJAX('idioma');
	
	if (iEntEv == 99)
	{
		iEntEv = 0;
		iPrimer = 1;
	}
	else
	{
		iPrimer = 0;
	}
	switch(iEntEv)
	{
		case 1:
			opcion_temporal = 90;
			break;
		case 2:
			opcion_temporal = 69;
			break;
		case 3:
			opcion_temporal = 71;
			break;
		default:
		case 0:
			opcion_temporal = 89;
			break;
	}
	
	if ((opcion_elegida != opcion_temporal) || (iForzar == 1))
	{
		opcion_elegida = opcion_temporal;				
		
		document.getElementById("comboInstalaciones").disabled="";
		document.getElementById("boton_mapas").style.color="#333";
		document.getElementById("boton_datos").style.color="#333";
		document.getElementById("boton_informes").style.color="#333";
		document.getElementById("boton_procesado").style.color="#333";
		document.getElementById("boton_gestion").style.color="#333";
		document.getElementById("boton_soporte").style.color="#333";
		document.getElementById("boton_notificacion").style.color="#990000";
		
		rellenar_div_submenu(opcion_temporal,"");
	
		if (document.getElementById("comboInstalaciones").selectedIndex!=-1)
		{
			switch(iEntEv)
			{
				case 2:
					recargar_instalacion(document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
					Rellenar_Eventos_Filtro();
					Protoplasm.use('datepicker').transform('.datepicker', { locale: idioma+'_iso8601', timePicker: true, use24hrs: true , manual: false});
					break;
				case 3:
					recargar_instalacion(document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);			
					Protoplasm.use('datepicker').transform('.datepicker', { locale: idioma+'_iso8601', timePicker: true, use24hrs: true , manual: false});
					break;
				default:
				case 1:
				case 0:
					recargar_instalacion(document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
					Protoplasm.use('datepicker').transform('.datepicker', { locale: idioma+'_iso8601', timePicker: true, use24hrs: true , manual: false});
					Rellenar_SensoresGW_Filtro(0);					
					Rellenar_Sensores_Filtro(0);	
					Rellenar_Sensores_UTC_Filtro(0);
					break;
			}
			
			if (iPrimer == 1)
			{
				document.getElementById("selEvento").selectedIndex = 0;
			}
			
			rellenar_div_principal(opcion_temporal,"");
		}
		else
		{
			rellenar_div_principal(23,"");
		}
	}
}

function OnBotonET()
{
	if (opcion_elegida != 84)
	{
		opcion_elegida = 84;
		document.getElementById("comboInstalaciones").disabled="";
		
		if (document.getElementById("comboInstalaciones").selectedIndex!=-1)
		{
			rellenar_div_submenu(84,"");
			
			var idioma=iObtener_Cadena_AJAX('idioma');
			Protoplasm.use('datepicker').transform('.datepicker', { locale: idioma+'_iso8601', timePicker: true, use24hrs: true , manual: false}); 
			rellenar_div_principal(88,"&instalacion_id="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
			if (document.getElementById("comboInstalaciones").selectedIndex != -1)
			{
				recargar_instalacion(document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
			}
		}
		else
		{
			rellenar_div_principal(23,"");
			rellenar_div_submenu(99,"");
		}		
		
		document.getElementById("boton_mapas").style.color="#333";
		document.getElementById("boton_datos").style.color="#333";
		document.getElementById("boton_informes").style.color="#333";
		document.getElementById("boton_procesado").style.color="#990000";
		document.getElementById("boton_gestion").style.color="#333";
		document.getElementById("boton_soporte").style.color="#333";
		document.getElementById("boton_notificacion").style.color="#333";
	}
}
function iObtener_Modo_Offline()
{
	var doc;
	var xmlHttpInst;
	xmlHttpInst= GetXmlHttpObject();
	var url = "modo_offline_obtener.php";
	xmlHttpInst.open("GET",url,false);
	xmlHttpInst.send(null);
	doc=xmlHttpInst.responseText;
	return doc;
}

function vRecargarFrames()
{
	window.location.reload();
}

function vCambiarIdioma(iBase, sIdioma)
{
	switch(iBase)
	{
		case 1:
			xmlHttp= GetXmlHttpObject();
			var url = "configurar_idioma.php?opcion_idioma=" + sIdioma;
			//xmlHttp.onreadystatechange=vRecargarFrames;
			xmlHttp.open("GET",url,false);
			xmlHttp.send(null);
			vRecargarFrames();
			break;
		case 0:
		default:			
			window.location='index.php?opcion_idioma='+sIdioma;
			break;
	}
}

function iObtener_Cadena_AJAX(sCadenaInput)
{
	var doc;
	var xmlHttpCadena;
	xmlHttpCadena= GetXmlHttpObject();
	var url = "obtener_cadena_AJAX.php?cadena_input="+sCadenaInput;
	xmlHttpCadena.open("GET",url,false);
	xmlHttpCadena.send(null);
	doc=xmlHttpCadena.responseText;
	return doc;
}

function xObtener_XML_AJAX(sCadenaXMLInput, funcion_callback, sCadenaHWAux, sCadenaSWAux)
{
	$.ajax({    
	 type: "POST",
	 url: 'obtener_XML_AJAX.php',
	 async: false,
	 data: "id=1"+sCadenaXMLInput,
	 success: function(t){
	 	funcion_callback(t, sCadenaHWAux, sCadenaSWAux);
	 	} 
	 });
}

function vSeleccionar_Idioma_Combo(sCombo, sIdioma)
{
	switch (sIdioma)
	{
		case "fr":
			document.getElementById(sCombo).selectedIndex=2;
			break;
		case "en":
			document.getElementById(sCombo).selectedIndex=1;
			break;
		case "es":
		default:
			document.getElementById(sCombo).selectedIndex=0;
			break;
		
	}
}

//Código pestañas
function OnCrearPestanyas(){
	tabbar = new dhtmlXTabBar("a_tabbar", "top");
	tabbar.setSkin('dark_blue');
	tabbar.setImagePath("codebase/imgs/");
	AnchoTabAux=document.getElementById('a_tabbar').offsetWidth/10;
	tabbar.addTab("a1", "Analógico", 90);
	tabbar.addTab("a2", "Digital", 85);
	tabbar.setContent("a1", "tab_analogico");
	tabbar.setContent("a2", "tab_digital");
	tabbar.setTabActive("a1");
}