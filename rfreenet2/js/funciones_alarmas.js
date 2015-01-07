function Rellenar_Tabla_Alarmas(iNueva)
{
	var url;
	var url_datos;
	
	if (iNueva == 1)
	{
		url_datos = "carga_tabla_alarmas_nuevas.php";
	}
	else
	{
		url_datos = "carga_tabla_alarmas.php";
	}
	
	url_datos += "?instalacion_id="+top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value+"&cliente_db="+top.document.getElementById("db_cliente").value;

	if (top.document.getElementById("Ver_GW_Check").checked == true)
	{
		url="&ver_gw=1";
	}
	else
	{
		url="&ver_gw=0";
	}

	if (top.document.getElementById("Filtro_combo_GW").selectedIndex==0)
	{
		url+="&gw_id=0000";
	}
	else
	{
		url+="&gw_id="+top.document.getElementById("Filtro_combo_GW").options[top.document.getElementById("Filtro_combo_GW").selectedIndex].id;
	}

	if (top.document.getElementById("Filtro_GWSensor_Check").checked == true)
	{
		if (top.document.getElementById("Filtro_combo_GWSensor").selectedIndex!=-1)
		{
			url+="&GWSensor="+top.document.getElementById("Filtro_combo_GWSensor").options[top.document.getElementById("Filtro_combo_GWSensor").selectedIndex].id;	
		}
		else
		{
			url+="&GWSensor=F";	
		}
	}
	else
	{
		url+="&GWSensor=F";
	}

	if (top.document.getElementById("Ver_Nodo_Check").checked == true)
	{
		url+="&ver_nodo=1";
	}
	else
	{
		url+="&ver_nodo=0";
	}

	if ((top.document.getElementById("Filtro_combo_Nodo").selectedIndex==0) || (top.document.getElementById("Filtro_combo_Nodo").selectedIndex==-1))
	{
		url+="&nodo_ip=F";
	}
	else
	{
		url+="&nodo_ip="+top.document.getElementById("Filtro_combo_Nodo").options[top.document.getElementById("Filtro_combo_Nodo").selectedIndex].id;
	}

	if (top.document.getElementById("Filtro_NodeSensor_Check").checked == true)
	{
		if (top.document.getElementById("Filtro_combo_NodeSensor").selectedIndex!=-1)
		{
			url+="&NodeSensor="+top.document.getElementById("Filtro_combo_NodeSensor").options[top.document.getElementById("Filtro_combo_NodeSensor").selectedIndex].id;	
		}
		else
		{
			url+="&NodeSensor=F";	
		}
	}
	else
	{
		url+="&NodeSensor=F";
	}
	if (top.document.getElementById("Ver_UTC_Check").checked == true)
	{
		url+="&ver_utc=1";
	}
	else
	{
		url+="&ver_utc=0";
	}

	if (top.document.getElementById("Filtro_combo_UTC").selectedIndex==0)
	{
		url+="&utc_id=0000";
	}
	else
	{
		url+="&utc_id="+top.document.getElementById("Filtro_combo_UTC").options[top.document.getElementById("Filtro_combo_UTC").selectedIndex].id;
	}

	if (top.document.getElementById("Filtro_UTCSensor_Check").checked == true)
	{
		if (top.document.getElementById("Filtro_combo_UTCSensor").selectedIndex>0)
		{
			url+="&UTCSensor="+top.document.getElementById("Filtro_combo_UTCSensor").options[top.document.getElementById("Filtro_combo_UTCSensor").selectedIndex].id;	
		}
		else
		{
			url+="&UTCSensor=F";	
		}
	}
	else
	{
		url+="&UTCSensor=F";
	}

	if (top.document.getElementById("Filtro_Fecha_Check").checked == true)
	{
		if ((top.document.getElementById("FechaInicial").value == "") || (top.document.getElementById("FechaFinal").value == ""))
		{
			alert(iObtener_Cadena_AJAX('error_datos1'));
			return;
		}
		if (top.document.getElementById("FechaInicial").value >= top.document.getElementById("FechaFinal").value)
		{
			alert(iObtener_Cadena_AJAX('error_datos2'));
			return;
		}
		if (top.document.getElementById("FechaInicial").value != "")
		{
			url+="&fecha_begin="+top.document.getElementById('FechaInicial').value;
		}
		else
		{
			url+="&fecha_begin=0";
		}
		if (top.document.getElementById("FechaFinal").value != "")
		{
			url+="&fecha_end="+top.document.getElementById('FechaFinal').value;
		}
		else
		{
			url+="&fecha_end=0";
		}				
	}
	else
	{
		url+="&fecha_begin=0&fecha_end=0";
	}

	url+="&pagina="+Pagina_Actual;
	$('#imagen_espera_db').attr("class", 'mostrado');
	xmlHttp2= GetXmlHttpObject();
	urltotal = url_datos+url;
	xmlHttp2.open("GET",urltotal,false);
	xmlHttp2.send(null);
	Total_Paginas = parseFloat(xmlHttp2.responseText.substring(0,8));
	document.getElementById("tabla_datos").innerHTML = xmlHttp2.responseText.substring(8);
	$('#imagen_espera_db').attr("class", 'escondido');
}

function OnReponerAlarma(iIdAlarma,sTablaAl)
{
	var url;
	var xmlHttpAl;
	url = "alarma_reponer.php?idAl="+iIdAlarma+"&cliente_db="+top.document.getElementById('db_cliente').value+"&tabla="+sTablaAl;
	$('#imagen_esperaDB').attr("class", 'mostrado');
	xmlHttpAl= GetXmlHttpObject();	
	xmlHttpAl.open("GET",url,false);
	xmlHttpAl.send(null);
	$('#imagen_esperaDB').attr("class", 'escondido');
	alert(xmlHttpAl.responseText);
	vRellenar_Num_Paginas();
}