var calInicial;
var calFinal;

function seleccionar_gw(id_gw)
{
	var i;
	if (document.getElementById("comboGateways"))
	{
		for (i = 0; i < document.getElementById("comboGateways").length; i++)
		{
			if (document.getElementById("comboGateways").options[i].id.toString() == id_gw.toString())
			{
				document.getElementById("comboGateways").selectedIndex = i;
				if (document.getElementById("comboNodos"))
				{
					document.getElementById("comboNodos").selectedIndex = -1;
				}
				if (document.getElementById("comboUTCs"))
				{
					document.getElementById("comboUTCs").selectedIndex = -1;
				}
				break;
			}
		}
	}
}
function seleccionar_nodo(nodo_mac)
{
	var i;
	if (document.getElementById("comboNodos"))
	{
		for (i = 0; i < document.getElementById("comboNodos").length; i++)
		{
			if (document.getElementById("comboNodos").options[i].id.toString() == nodo_mac.toString())
			{
				document.getElementById("comboNodos").selectedIndex = i;
				if (document.getElementById("comboGateways"))
				{
					document.getElementById("comboGateways").selectedIndex = -1;
				}
				if (document.getElementById("comboUTCs"))
				{
					document.getElementById("comboUTCs").selectedIndex = -1;
				}
				break;
			}
		}
	}
}
function seleccionar_utc(id_disp)
{
	var i;
	if (document.getElementById("comboUTCs"))
	{
		for (i = 0; i < document.getElementById("comboUTCs").length; i++)
		{
			if (document.getElementById("comboUTCs").options[i].id.toString() == id_disp.toString())
			{
				document.getElementById("comboUTCs").selectedIndex = i;
				if (document.getElementById("comboNodos"))
				{
					document.getElementById("comboNodos").selectedIndex = -1;
				}
				if (document.getElementById("comboGateways"))
				{
					document.getElementById("comboGateways").selectedIndex = -1;
				}
				break;
			}
		}
	}
}
function OnChangeNodo()
{
	if (document.getElementById("comboGateways"))
	{
		document.getElementById("comboGateways").selectedIndex=-1;
	}
	if (document.getElementById("comboUTCs"))
	{
		document.getElementById("comboUTCs").selectedIndex=-1;
	}
	switch (opcion_elegida)
	{
		case 1:
		case 7:
			if ((document.getElementById("comboNodos").selectedIndex!=-1)
				&& (document.getElementById("iframe_mapa"))
				&& (document.getElementById("iframe_mapa").contentWindow)
				&& (document.getElementById("iframe_mapa").contentWindow.centrar_nodo)
			)
			{
				document.getElementById("iframe_mapa").contentWindow.centrar_nodo(document.getElementById("comboNodos").selectedIndex);
			}
			break;
		case 2:
			break;
			
		default:
			break;
	}
	return;
}
function OnChangeGateway()
{
	if (document.getElementById("comboNodos"))
	{
		document.getElementById("comboNodos").selectedIndex = -1;
	}
	if (document.getElementById("comboUTCs"))
	{
		document.getElementById("comboUTCs").selectedIndex=-1;
	}
	switch (opcion_elegida)
	{
		case 1:
		case 7:
			if ((document.getElementById("comboGateways").selectedIndex != -1)
				&& (document.getElementById("iframe_mapa"))
				&& (document.getElementById("iframe_mapa").contentWindow)
				&& (document.getElementById("iframe_mapa").contentWindow.centrar_gateway)
			)
			{
				document.getElementById("iframe_mapa").contentWindow.centrar_gateway(document.getElementById("comboGateways").selectedIndex);
			}
			break;
	
		case 2:
			break;
			
		default:
			break;
	}
	return;
}

function OnChangeUTC()
{
	if (document.getElementById("comboNodos"))
	{
		document.getElementById("comboNodos").selectedIndex = -1;
	}
	if (document.getElementById("comboGateways"))
	{
		document.getElementById("comboGateways").selectedIndex=-1;
	}
	switch (opcion_elegida)
	{
		case 1:
		case 7:
			if ((document.getElementById("comboUTCs").selectedIndex != -1)
				&& (document.getElementById("iframe_mapa"))
				&& (document.getElementById("iframe_mapa").contentWindow)
				&& (document.getElementById("iframe_mapa").contentWindow.centrar_utc)
			)
			{
				document.getElementById("iframe_mapa").contentWindow.centrar_utc(document.getElementById("comboUTCs").selectedIndex);
			}
			break;
	
		case 2:
			break;
			
		default:
			break;
	}
	return;
}

function Rellenar_Base_Sensores()
{
	top.document.getElementById("Filtro_combo_NodeSensor").length = 0;
	insertarOptionCombo("Filtro_combo_NodeSensor","Sensor0", iObtener_Cadena_AJAX("general111"));
}
function Rellenar_Base_UTCSensores()
{
	top.document.getElementById("Filtro_combo_UTCSensor").length = 0;
	insertarOptionCombo("Filtro_combo_UTCSensor","Sensor0", iObtener_Cadena_AJAX("general111"));
}
function Rellenar_Base_GWSensores()
{
	top.document.getElementById("Filtro_combo_GWSensor").length = 0;
	insertarOptionCombo("Filtro_combo_GWSensor","0", iObtener_Cadena_AJAX("general111"));
}

function Rellenar_Sensores_Filtro(iTodosEnable)
{
	var sUrlSensor;
	var xmlHttpgrReadSensor;
	var sCadenaGWAux;
	
	if (top.document.getElementById("Filtro_combo_Nodo").options.length > 0)
	{
		Rellenar_Base_Sensores();
		sUrlSensor = "nodo_lecturaDB_sensores.php?nodo_mac="+top.document.getElementById("Filtro_combo_Nodo").options[top.document.getElementById("Filtro_combo_Nodo").selectedIndex].id+"&cliente_db="+top.document.getElementById('db_cliente').value+"&iTodosEnable="+iTodosEnable;
		xmlHttpgrReadSensor= GetXmlHttpObject();
		xmlHttpgrReadSensor.open("GET",sUrlSensor,false);
		xmlHttpgrReadSensor.send(null);
		if (xmlHttpgrReadSensor.responseText=='ERROR')
		{
			alert(xmlHttpgrReadNode.responseText);
		}
		else
		{
			select_innerHTML(top.document.getElementById('Filtro_combo_NodeSensor'), xmlHttpgrReadSensor.responseText);
		}
	}
}

function Rellenar_SensoresGW_Filtro(iTodosEnable)
{
	var sUrlSensor;
	var xmlHttpgrReadSensor;
	
	if (top.document.getElementById("Filtro_combo_GW").options.length > 0)
	{
		Rellenar_Base_GWSensores();
		sUrlSensor = "gw_lecturaDB_sensores.php?gw_id="+top.document.getElementById("Filtro_combo_GW").options[top.document.getElementById("Filtro_combo_GW").selectedIndex].id+"&cliente_db="+top.document.getElementById('db_cliente').value+"&iTodosEnable="+iTodosEnable;
		xmlHttpgrReadSensor= GetXmlHttpObject();
		xmlHttpgrReadSensor.open("GET",sUrlSensor,false);
		xmlHttpgrReadSensor.send(null);
		if (xmlHttpgrReadSensor.responseText=='ERROR')
		{
			alert(xmlHttpgrReadNode.responseText);
		}
		else
		{
			//top.document.getElementById('Filtro_combo_GWSensor').innerHTML=xmlHttpgrReadSensor.responseText;
			select_innerHTML(top.document.getElementById('Filtro_combo_GWSensor'), xmlHttpgrReadSensor.responseText);
		}		
	}
}

function Rellenar_Sensores_UTC_Filtro(iTodosEnable)
{
	var sUrlSensor;
	var xmlHttpgrReadSensor;
	var sCadenaUTCAux;
	
	if (top.document.getElementById("Filtro_combo_UTC").options.length > 0)
	{
		Rellenar_Base_UTCSensores();
		sUrlSensor = "utc_lectura_sensores.php?disp_id="+top.document.getElementById("Filtro_combo_UTC").options[top.document.getElementById("Filtro_combo_UTC").selectedIndex].id+"&cliente_db="+top.document.getElementById('db_cliente').value+"&iTodosEnable="+iTodosEnable;
		xmlHttpgrReadSensor= GetXmlHttpObject();
		xmlHttpgrReadSensor.open("GET",sUrlSensor,false);
		xmlHttpgrReadSensor.send(null);
		if (xmlHttpgrReadSensor.responseText=='ERROR')
		{
			alert(xmlHttpgrReadNode.responseText);
		}
		else
		{
			select_innerHTML(top.document.getElementById('Filtro_combo_UTCSensor'), xmlHttpgrReadSensor.responseText);
		}
	}
}

function Rellenar_Eventos_Filtro(iTodos)
{
	top.document.getElementById("Filtro_combo_Evento").length = 0;
	if (iTodos == 0)
	{
		insertarTopOptionCombo("Filtro_combo_Evento","Evento1", iObtener_Cadena_AJAX("event_todos"));
	}
	insertarTopOptionCombo("Filtro_combo_Evento","Evento1", iObtener_Cadena_AJAX("event_datos"));
	insertarTopOptionCombo("Filtro_combo_Evento","Evento2", iObtener_Cadena_AJAX("event_cobertura"));
	insertarTopOptionCombo("Filtro_combo_Evento","Evento3", iObtener_Cadena_AJAX("event_alimentacion"));
	insertarTopOptionCombo("Filtro_combo_Evento","Evento4", iObtener_Cadena_AJAX("event_cob_gprs"));
	insertarTopOptionCombo("Filtro_combo_Evento","Evento5", iObtener_Cadena_AJAX("event_umbral"));
	insertarTopOptionCombo("Filtro_combo_Evento","Evento6", iObtener_Cadena_AJAX("event_gradiente"));
	if (iTodos == 0)
	{
		insertarTopOptionCombo("Filtro_combo_Evento","Evento7", iObtener_Cadena_AJAX("event_imagen"));	
		insertarTopOptionCombo("Filtro_combo_Evento","Evento8", iObtener_Cadena_AJAX("event_maximo"));
		insertarTopOptionCombo("Filtro_combo_Evento","Evento9", iObtener_Cadena_AJAX("event_minimo"));
		insertarTopOptionCombo("Filtro_combo_Evento","Evento10", iObtener_Cadena_AJAX("event_promedio"));
		insertarTopOptionCombo("Filtro_combo_Evento","Evento11", iObtener_Cadena_AJAX("event_acumulado"));
		insertarTopOptionCombo("Filtro_combo_Evento","Evento12", iObtener_Cadena_AJAX("sensor_type92"));
	}	
}

function  OnFilterGW()
{
	if (document.getElementById("Ver_GW_Check").checked == true)
	{
		document.getElementById("Filtro_combo_GW").disabled = false;
		document.getElementById("Filtro_GWSensor_Check").disabled = false;
		document.getElementById("Filtro_combo_Evento").disabled = false;
		document.getElementById("Filtro_Fecha_Check").disabled = false;
	}
	else
	{
		document.getElementById("Filtro_combo_GW").disabled = true;
		document.getElementById("Filtro_GWSensor_Check").disabled = true;
		document.getElementById("Filtro_combo_GWSensor").disabled = true;
		document.getElementById("Filtro_combo_GW").selectedIndex = 0;
		document.getElementById("Filtro_combo_GWSensor").selectedIndex = 0;
		document.getElementById("Filtro_GWSensor_Check").checked = false;
		if ((document.getElementById("Ver_Nodo_Check").checked == false)  && (document.getElementById("Ver_UTC_Check").checked == false))
		{
			document.getElementById("Filtro_combo_Evento").disabled = true;
			document.getElementById("Filtro_combo_Evento").selectedIndex = 0;
			document.getElementById("Filtro_Fecha_Check").checked = false;
			document.getElementById("Filtro_Fecha_Check").disabled = true;
			OnFilterFecha();
		}
	}
}
function  OnFilterNodo()
{
	if (document.getElementById("Ver_Nodo_Check").checked == true)
	{
		document.getElementById("Filtro_combo_Nodo").disabled = false;
		document.getElementById("Filtro_NodeSensor_Check").disabled = false;
		document.getElementById("Filtro_combo_Evento").disabled = false;
		document.getElementById("Filtro_Fecha_Check").disabled = false;
	}
	else
	{
		document.getElementById("Filtro_combo_Nodo").disabled = true;
		document.getElementById("Filtro_NodeSensor_Check").disabled = true;
		document.getElementById("Filtro_combo_NodeSensor").disabled = true;
		document.getElementById("Filtro_combo_Nodo").selectedIndex = 0;
		document.getElementById("Filtro_combo_NodeSensor").selectedIndex = 0;
		document.getElementById("Filtro_NodeSensor_Check").checked = false;

		if ((document.getElementById("Ver_GW_Check").checked == false) && (document.getElementById("Ver_UTC_Check").checked == false))
		{
			document.getElementById("Filtro_combo_Evento").disabled = true;
			document.getElementById("Filtro_combo_Evento").selectedIndex = 0;
			document.getElementById("Filtro_Fecha_Check").checked = false;
			document.getElementById("Filtro_Fecha_Check").disabled = true;
			OnFilterFecha();
		}
	}
}
function OnFilterNodeSensor()
{
	if (document.getElementById("Filtro_NodeSensor_Check").checked == true)
	{
		document.getElementById("Filtro_combo_NodeSensor").disabled = false;
	}
	else
	{
		document.getElementById("Filtro_combo_NodeSensor").disabled = true;
		document.getElementById("Filtro_combo_NodeSensor").selectedIndex = 0;
	}
}
function onFilterNodeSelect(iTodosEnable)
{
	Rellenar_Sensores_Filtro(iTodosEnable);
}
function OnFilterGWSensor()
{
	if (document.getElementById("Filtro_GWSensor_Check").checked == true)
	{
		document.getElementById("Filtro_combo_GWSensor").disabled = false;
	}
	else
	{
		document.getElementById("Filtro_combo_GWSensor").disabled = true;
		document.getElementById("Filtro_combo_GWSensor").selectedIndex = 0;
	}
}
function onFilterGWSelect(iTodosEnable)
{
	Rellenar_SensoresGW_Filtro(iTodosEnable);
}

function OnFilterUTCSensor()
{
	if (document.getElementById("Filtro_UTCSensor_Check").checked == true)
	{
		document.getElementById("Filtro_combo_UTCSensor").disabled = false;
	}
	else
	{
		document.getElementById("Filtro_combo_UTCSensor").disabled = true;
		document.getElementById("Filtro_combo_UTCSensor").selectedIndex = 0;
	}
}

function  OnFilterUTC()
{
	if (document.getElementById("Ver_UTC_Check").checked == true)
	{
		document.getElementById("Filtro_combo_UTC").disabled = false;
		document.getElementById("Filtro_UTCSensor_Check").disabled = false;
		document.getElementById("Filtro_combo_Evento").disabled = false;
		document.getElementById("Filtro_Fecha_Check").disabled = false;
	}
	else
	{
		document.getElementById("Filtro_combo_UTC").disabled = true;
		document.getElementById("Filtro_UTCSensor_Check").disabled = true;
		document.getElementById("Filtro_combo_UTCSensor").disabled = true;
		document.getElementById("Filtro_combo_UTC").selectedIndex = 0;
		document.getElementById("Filtro_combo_UTCSensor").selectedIndex = 0;
		document.getElementById("Filtro_UTCSensor_Check").checked = false;

		if ((document.getElementById("Ver_GW_Check").checked == false)  && (document.getElementById("Ver_Nodo_Check").checked == false))
		{
			document.getElementById("Filtro_combo_Evento").disabled = true;
			document.getElementById("Filtro_combo_Evento").selectedIndex = 0;
			document.getElementById("Filtro_Fecha_Check").checked = false;
			document.getElementById("Filtro_Fecha_Check").disabled = true;
			OnFilterFecha();
		}
	}
}

function onFilterUTCSelect(iTodosEnable)
{
	Rellenar_Sensores_UTC_Filtro(iTodosEnable);
}
function OnFilterFecha()
{
	if (document.getElementById("Filtro_Fecha_Check").checked == true)
	{
		document.getElementById('FechaInicial').disabled = false;
		document.getElementById('FechaFinal').disabled = false;
	}
	else
	{
		document.getElementById('FechaInicial').disabled = true;
		document.getElementById('FechaFinal').disabled = true;
	}
}
function OnCambioEvento()
{
	switch (document.getElementById('Filtro_combo_Evento').selectedIndex)
	{
		case 12:
			document.getElementById('Ver_GW_Check').disabled=true;
			document.getElementById('Ver_Nodo_Check').disabled=true;
			document.getElementById('Ver_UTC_Check').disabled=true;
			document.getElementById("Ver_GW_Check").checked = true;
			document.getElementById("Ver_Nodo_Check").checked = false;
			document.getElementById("Ver_UTC_Check").checked = false;
			
			document.getElementById("Filtro_combo_Nodo").selectedIndex = 0;
			document.getElementById("Filtro_combo_UTC").selectedIndex = 0;
			document.getElementById("Filtro_combo_Nodo").disabled=true;
			document.getElementById("Filtro_combo_UTC").disabled=true;
			
			document.getElementById("Filtro_GWSensor_Check").checked = false;
			document.getElementById("Filtro_NodeSensor_Check").checked = false;
			document.getElementById('Filtro_UTCSensor_Check').checked = false;
			document.getElementById('Filtro_GWSensor_Check').disabled=true;
			document.getElementById('Filtro_combo_GWSensor').disabled=true;
			document.getElementById('Filtro_NodeSensor_Check').disabled=true;
			document.getElementById('Filtro_combo_NodeSensor').disabled=true;
			document.getElementById('Filtro_UTCSensor_Check').disabled=true;
			document.getElementById('Filtro_combo_UTCSensor').disabled=true;
			document.getElementById("Filtro_combo_GWSensor").selectedIndex = 0;
			document.getElementById("Filtro_combo_NodeSensor").selectedIndex = 0;
			document.getElementById("Filtro_combo_UTCSensor").selectedIndex = 0;
			break;
		case 2:
		case 3:
		case 4:
			document.getElementById('Filtro_GWSensor_Check').disabled=true;
			document.getElementById('Filtro_combo_GWSensor').disabled=true;
			document.getElementById('Filtro_NodeSensor_Check').disabled=true;
			document.getElementById('Filtro_combo_NodeSensor').disabled=true;
			document.getElementById('Filtro_UTCSensor_Check').disabled=true;
			document.getElementById("Filtro_combo_UTCSensor").disabled=true;
			document.getElementById("Filtro_combo_GWSensor").selectedIndex = 0;
			document.getElementById("Filtro_combo_NodeSensor").selectedIndex = 0;
			document.getElementById("Filtro_combo_UTCSensor").selectedIndex = 0;
			
			document.getElementById("Filtro_GWSensor_Check").checked = false;
			document.getElementById("Filtro_NodeSensor_Check").checked = false;
			document.getElementById('Filtro_UTCSensor_Check').checked = false;
			document.getElementById('Ver_Nodo_Check').disabled=false;
			document.getElementById('Ver_UTC_Check').disabled=false;
			document.getElementById('Ver_GW_Check').disabled=false;
			document.getElementById("Filtro_combo_Nodo").disabled=false;
			document.getElementById("Filtro_combo_UTC").disabled=false;
			break;
		default:
			document.getElementById('Filtro_GWSensor_Check').disabled=false;
			document.getElementById('Filtro_combo_GWSensor').disabled=false;
			document.getElementById('Filtro_NodeSensor_Check').disabled=false;
			document.getElementById('Filtro_combo_NodeSensor').disabled=false;
			document.getElementById("Filtro_combo_UTCSensor").disabled=false;
			document.getElementById('Filtro_UTCSensor_Check').disabled=false;
			document.getElementById('Ver_Nodo_Check').disabled=false;
			document.getElementById('Ver_UTC_Check').disabled=false;
			document.getElementById('Ver_GW_Check').disabled=false;
			document.getElementById("Filtro_combo_Nodo").disabled=false;
			document.getElementById("Filtro_combo_UTC").disabled=false;
			OnFilterGWSensor();
			OnFilterNodo();
			OnFilterNodeSensor();
			break; 
	}
}
function Rellenar_Sensores_Instalacion(sCadenaComboSensor, iRestoParams, iOtrosCombos, sCadenaCombo2, sCadenaCombo3, sCadenaCombo4)
{
	var sUrlSensor;
	var xmlHttpgrInstSensor;
	var oComboDestino;
	
	if (iRestoParams == 0)
	{
		oComboDestino = top.document.getElementById(sCadenaComboSensor);
	}
	else
	{
		oComboDestino = document.getElementById(sCadenaComboSensor);
	}
	sUrlSensor = "instalacion_lecturaDB_sensores.php?cliente_db="+top.document.getElementById('db_cliente').value+"&instalacion_id="+top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value+"&restoparams="+iRestoParams+"&grafica="+iOtrosCombos;
	oComboDestino.length = 0;
	xmlHttpgrInstSensor= GetXmlHttpObject();
	xmlHttpgrInstSensor.open("GET",sUrlSensor,false);
	xmlHttpgrInstSensor.send(null);
	
	if (xmlHttpgrInstSensor.responseText.substring(0,5)=='ERROR')
	{
		alert(xmlHttpgrInstSensor.responseText);
	}
	else
	{
		select_innerHTML(oComboDestino, xmlHttpgrInstSensor.responseText);
		if(iOtrosCombos == 1)
		{
			if (iRestoParams == 0)
			{
				oComboDestino = top.document.getElementById(sCadenaCombo2);
			}
			else
			{
				oComboDestino = document.getElementById(sCadenaCombo2);
			}
			oComboDestino.length = 0;
			select_innerHTML(oComboDestino, xmlHttpgrInstSensor.responseText);
			
			if (iRestoParams == 0)
			{
				oComboDestino = top.document.getElementById(sCadenaCombo3);
			}
			else
			{
				oComboDestino = document.getElementById(sCadenaCombo3);
			}
			oComboDestino.length = 0;
			select_innerHTML(oComboDestino, xmlHttpgrInstSensor.responseText);
			
			if (iRestoParams == 0)
			{
				oComboDestino = top.document.getElementById(sCadenaCombo4);
			}
			else
			{
				oComboDestino = document.getElementById(sCadenaCombo4);
			}
			oComboDestino.length = 0;
			select_innerHTML(oComboDestino, xmlHttpgrInstSensor.responseText);
		}
	}
}

function Rellenar_Todas_Uds_Sensor_GW()
{
	var sCadenaUDS = sObtener_Uds_Sensor_Generico(1);
	select_innerHTML(document.getElementById("U1D"), sCadenaUDS);
	select_innerHTML(document.getElementById("U2D"), sCadenaUDS);
	select_innerHTML(document.getElementById("U3D"), sCadenaUDS);
	select_innerHTML(document.getElementById("U4D"), sCadenaUDS);
	select_innerHTML(document.getElementById("U5D"), sCadenaUDS);
	select_innerHTML(document.getElementById("U6D"), sCadenaUDS);
	select_innerHTML(document.getElementById("U7D"), sCadenaUDS);
	select_innerHTML(document.getElementById("U8D"), sCadenaUDS);
	select_innerHTML(document.getElementById("U9D"), sCadenaUDS);
}

function Rellenar_Todas_Uds_Sensor_GWLOW()
{
	var sCadenaUDS = sObtener_Uds_Sensor_Generico(1);
	select_innerHTML(document.getElementById("U0D"), sCadenaUDS);
	select_innerHTML(document.getElementById("U1D"), sCadenaUDS);
	select_innerHTML(document.getElementById("U2D"), sCadenaUDS);
}

function sObtener_Uds_Sensor_Generico(tipo)
{
	var sUrlSensor;
	var xmlHttpgrReadSensor;
	var sCadenaGWAux;

	sUrlSensor = "carga_uds_sensor_generico.php?tipo="+tipo;
	xmlHttpgrReadSensor= GetXmlHttpObject();
	xmlHttpgrReadSensor.open("GET",sUrlSensor,false);
	xmlHttpgrReadSensor.send(null);
	if (xmlHttpgrReadSensor.responseText=='ERROR')
	{
		alert(xmlHttpgrReadNode.responseText);
	}	
	else
	{
		//select_innerHTML(document.getElementById(combo_entrada), xmlHttpgrReadSensor.responseText);
		return xmlHttpgrReadSensor.responseText;
	}
}

function Rellenar_Uds_Sensor_Generico(combo_entrada, tipo)
{
	var sUrlSensor;
	var xmlHttpgrReadSensor;
	var sCadenaGWAux;

	sUrlSensor = "carga_uds_sensor_generico.php?tipo="+tipo;
	xmlHttpgrReadSensor= GetXmlHttpObject();
	xmlHttpgrReadSensor.open("GET",sUrlSensor,false);
	xmlHttpgrReadSensor.send(null);
	if (xmlHttpgrReadSensor.responseText=='ERROR')
	{
		alert(xmlHttpgrReadNode.responseText);
	}	
	else
	{
		select_innerHTML(document.getElementById(combo_entrada), xmlHttpgrReadSensor.responseText);
	}
}

function Rellenar_CombosYN(combo_entrada)
{
	document.getElementById(combo_entrada).length = 0;
	insertarOptionCombo(combo_entrada,combo_entrada+"0",iObtener_Cadena_AJAX("general_no"));
	insertarOptionCombo(combo_entrada,combo_entrada+"1",iObtener_Cadena_AJAX("general_si"));
	document.getElementById(combo_entrada).selectedIndex = -1;
}

function sRellenar_CombosYN(sFill_Combos_YN)
{
	var sCadenaXML = '';
	sCadenaXML += "&sCadenaXML[]=" + "general_no";
	sCadenaXML += "&sCadenaXML[]=" + "general_si";
	//alert(sCadenaXML);
	xObtener_XML_AJAX(sCadenaXML, sFill_Combos_YN, "00", "0000");
}

function Rellenar_ComboYN(combo_entrada, sXMLentrada)
{
	var xEntrada = eval('(' + sXMLentrada + ')');
	document.getElementById(combo_entrada).length = 0;
	insertarOptionCombo(combo_entrada,combo_entrada+"0",xEntrada["general_no"]);
	insertarOptionCombo(combo_entrada,combo_entrada+"1",xEntrada["general_si"]);
	document.getElementById(combo_entrada).selectedIndex = -1;
}

function vRellenar_Combos_YN_GW(sXMLEntrada)
{
	Rellenar_ComboYN("HPS",sXMLEntrada);
	Rellenar_ComboYN("DHP",sXMLEntrada);
	Rellenar_ComboYN("TCH",sXMLEntrada);	
	Rellenar_ComboYN("GSH",sXMLEntrada);
	Rellenar_ComboYN("GPH",sXMLEntrada);
	Rellenar_ComboYN("MTP",sXMLEntrada);
	Rellenar_ComboYN("HMR",sXMLEntrada);
}

function vRellenar_Combos_YN_GWLOW(sXMLEntrada)
{
	Rellenar_ComboYN("GPH",sXMLEntrada);
	Rellenar_ComboYN("GSH",sXMLEntrada);
	Rellenar_ComboYN("USE",sXMLEntrada);	
}

function onDescargarCSV()
{
	var now = new Date();
	var url = "carga_informe_et_csv.php?instalacion_id="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value+"&cliente_db="+document.getElementById("db_cliente").value;
	url+="&"+now.getTime();
	url+="&fecha_begin="+document.getElementById('FechaInicial').value;
	url+="&fecha_end="+document.getElementById('FechaFinal').value;
	url+="&gw_id="+top.document.getElementById("Filtro_combo_GW").options[top.document.getElementById("Filtro_combo_GW").selectedIndex].id;
	window.open(url,'sDownload');	
}

function onDescargarPDF()
{
	var now = new Date();
	var url = "carga_informe_et_pdf.php?instalacion_id="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value+"&cliente_db="+document.getElementById("db_cliente").value;
	url+="&"+now.getTime();
	url+="&fecha_begin="+document.getElementById('FechaInicial').value;
	url+="&fecha_end="+document.getElementById('FechaFinal').value;
	url+="&gw_id="+top.document.getElementById("Filtro_combo_GW").options[top.document.getElementById("Filtro_combo_GW").selectedIndex].id;
	window.open(url,'sDownload');	
}
