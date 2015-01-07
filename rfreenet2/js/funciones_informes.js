
function OnFechaInicialInformes()
{
	if (document.getElementById("Img_FechaInicial").name=="OFF_Init")
	{
		document.getElementById("Img_FechaInicial").name="ON_Init";
		calInicial.f_hide();
	}
	else
	{
		document.getElementById("Img_FechaInicial").name="OFF_Init";
		calInicial.f_show();
	}
}
function OnFechaFinalInformes()
{
	if (document.getElementById("Img_FechaFinal").name=="OFF_Fin")
	{
		document.getElementById("Img_FechaFinal").name="ON_Fin";
		calFinal.f_hide();
	}
	else
	{
		document.getElementById("Img_FechaFinal").name="OFF_Fin";
		calFinal.f_show();
	}
}
function Rellenar_Tipo_Informes()
{
	document.getElementById("Filtro_combo_Informe").length = 0;
	insertarOptionCombo("Filtro_combo_Informe","G", iObtener_Cadena_AJAX("report_type_graf"));
	insertarOptionCombo("Filtro_combo_Informe","D", iObtener_Cadena_AJAX("report_type_dyn"));
	insertarOptionCombo("Filtro_combo_Informe","C", iObtener_Cadena_AJAX("report_type_csv"));
}

function Rellenar_Eventos_Filtro_Informes()
{
	document.getElementById("Filtro_combo_Evento").length = 0;
	insertarOptionCombo("Filtro_combo_Evento","Evento1", iObtener_Cadena_AJAX("event_datos"));
	insertarOptionCombo("Filtro_combo_Evento","Evento2", iObtener_Cadena_AJAX("event_cobertura"));
	insertarOptionCombo("Filtro_combo_Evento","Evento3", iObtener_Cadena_AJAX("event_alimentacion"));
	insertarOptionCombo("Filtro_combo_Evento","Evento5", iObtener_Cadena_AJAX("event_umbral"));
	insertarOptionCombo("Filtro_combo_Evento","Evento6", iObtener_Cadena_AJAX("event_gradiente"));
}
function OnCambioEventoInformes()
{
	switch (document.getElementById('Filtro_combo_Evento').selectedIndex)
	{
		case 1:
			document.getElementById('td_filtrar_title').innerHTML = '<span class="RFNETtextINV">'+iObtener_Cadena_AJAX("report_text1")+':</span>';
			document.getElementById('td_informe_dispositivo').innerHTML = '&nbsp;&nbsp;<select id="Filtro_combo_Dispositivo" width="80px" height="100px" class="RFNETtextINV"></select>';
			cargar_nodos_value("Filtro_combo_Dispositivo",document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
			break;
		case 2:
			document.getElementById('td_filtrar_title').innerHTML = '<span class="RFNETtextINV">'+iObtener_Cadena_AJAX("report_text2")+':</span>';
			document.getElementById('td_informe_dispositivo').innerHTML = '&nbsp;&nbsp;<select id="Filtro_combo_Dispositivo" width="80px" height="100px" class="RFNETtextINV"></select>';
			cargar_lista_dispositivos("Filtro_combo_Dispositivo",document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
			break;
		case 3:
			document.getElementById('td_filtrar_title').innerHTML = '<span class="RFNETtextINV">'+iObtener_Cadena_AJAX("report_text2")+':</span>';
			document.getElementById('td_informe_dispositivo').innerHTML = '&nbsp;&nbsp;<select id="Filtro_combo_Dispositivo" width="80px" height="100px" class="RFNETtextINV"></select>';
			cargar_gateways_value("Filtro_combo_Dispositivo",document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
			break;
		default:
			document.getElementById('td_filtrar_title').innerHTML = '<span class="RFNETtextINV">'+iObtener_Cadena_AJAX("report_text3")+':</span>';
			document.getElementById('td_informe_dispositivo').innerHTML = '&nbsp;&nbsp;<select id="Filtro_combo_Dispositivo" width="80px" height="100px" class="RFNETtextINV"></select>';
			vRellenar_Controles_Informes();
			break; 
	}
}
function onTipoInforme()
{

	switch (document.getElementById('Filtro_combo_Informe').selectedIndex)
	{
		// Si es un CSV
		case 2:
			document.getElementById('td_titulo_fecha_inicial').innerHTML = '&nbsp;&nbsp;<span class="RFNETtextINV">- '+iObtener_Cadena_AJAX('report_text8')+'</span>&nbsp;&nbsp;&nbsp;';
			document.getElementById('td_fecha_inicial').innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;<input valign="top" align="center" type="text" class="datepicker" id="FechaInicial" style="text-align:center;width:140px">&nbsp;';
			document.getElementById('td_titulo_fecha_final').innerHTML = '&nbsp;&nbsp;<span class="RFNETtextINV">- '+iObtener_Cadena_AJAX('report_text9')+'</span>&nbsp;&nbsp;&nbsp;';
			document.getElementById('td_fecha_final').innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;<input valign="top" align="center" type="text" class="datepicker" id="FechaFinal" style="text-align:center;width:140px">&nbsp;';
		
			document.getElementById('td_evento').innerHTML = '&nbsp;&nbsp;<select id="Filtro_combo_Evento" width="80px" onchange="OnCambioEventoInformes()" class="RFNETtextINV" onchange="onFilterNodeSelect(0)"></select>';
			document.getElementById('td_info_title').innerHTML = '<span class="RFNETtextINV">'+iObtener_Cadena_AJAX("report_text4")+':</span>';
			document.getElementById('td_filtrar_title').innerHTML = '<span class="RFNETtextINV">'+iObtener_Cadena_AJAX("report_text3")+':</span>';
			document.getElementById('td_informe_dispositivo').innerHTML = '&nbsp;&nbsp;<select id="Filtro_combo_Dispositivo" width="80px" height="100px" style="width:200px" class="RFNETtextINV"></select>';			
			Rellenar_Eventos_Filtro(1);
			rellenar_div_principal(81,"");
			break;
			
		// Si es una grafica dinamica
		case 1:
			document.getElementById('td_titulo_fecha_inicial').innerHTML = '&nbsp;&nbsp;<span class="RFNETtextINV">- '+iObtener_Cadena_AJAX('report_text10')+'</span>&nbsp;&nbsp;&nbsp;';
			document.getElementById('td_fecha_inicial').innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;<input valign="top" align="center" type="text" id="tiempoGrafica" style="text-align:center;width:40px" maxlenght="2">&nbsp;<select id="selectTiempo" style="width:75px;text-align:center" class="texto_valores"><option id="0" >'+iObtener_Cadena_AJAX('general135')+'</option><option id="1" >'+iObtener_Cadena_AJAX('general134')+'</option><option id="2" >'+iObtener_Cadena_AJAX('general176')+'</option></select>';
			document.getElementById('td_titulo_fecha_final').innerHTML = '&nbsp;&nbsp;<span class="RFNETtextINV">- '+iObtener_Cadena_AJAX('report_text11')+'</span>&nbsp;&nbsp;&nbsp;';
			document.getElementById('td_fecha_final').innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;<input valign="top" align="center" type="text" id="tiempoIntervalo" style="text-align:center;width:40px" maxlenght="2">&nbsp;<select id="selectIntervalo" style="width:75px;text-align:center" class="texto_valores"><option id="0" >'+iObtener_Cadena_AJAX('general135')+'</option><option id="1" >'+iObtener_Cadena_AJAX('general134')+'</option><option id="2" >'+iObtener_Cadena_AJAX('general176')+'</option></select>';
		
		
			document.getElementById('td_info_title').innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="'+iObtener_Cadena_AJAX("report_text5")+'" id="bNewGraf" onclick="onTipoInforme();vRellenar_Controles_Informes();" style="text-align:center;width:120px" class="boton_fino_medio"/>';
			document.getElementById('td_filtrar_title').innerHTML = '';
			document.getElementById('td_informe_dispositivo').innerHTML = '';
			document.getElementById('td_evento').innerHTML = '';			
			rellenar_div_principal(82,"");
			break;

		// Si no, es una grafica
		default:
			document.getElementById('td_titulo_fecha_inicial').innerHTML = '&nbsp;&nbsp;<span class="RFNETtextINV">- '+iObtener_Cadena_AJAX('report_text8')+'</span>&nbsp;&nbsp;&nbsp;';
			document.getElementById('td_fecha_inicial').innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;<input valign="top" align="center" type="text" class="datepicker" id="FechaInicial" style="text-align:center;width:140px">&nbsp;';
			document.getElementById('td_titulo_fecha_final').innerHTML = '&nbsp;&nbsp;<span class="RFNETtextINV">- '+iObtener_Cadena_AJAX('report_text9')+'</span>&nbsp;&nbsp;&nbsp;';
			document.getElementById('td_fecha_final').innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;<input valign="top" align="center" type="text" class="datepicker" id="FechaFinal" style="text-align:center;width:140px">&nbsp;';
		
			document.getElementById('td_info_title').innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="'+iObtener_Cadena_AJAX("report_text5")+'" id="bNewGraf" onclick="onTipoInforme();vRellenar_Controles_Informes();" style="text-align:center;width:120px" class="boton_fino_medio"/>';
			document.getElementById('td_filtrar_title').innerHTML = '';
			document.getElementById('td_informe_dispositivo').innerHTML = '';
			document.getElementById('td_evento').innerHTML = '';
			rellenar_div_principal(82,"");
			break; 
	}
	var idioma=iObtener_Cadena_AJAX('idioma');
	Protoplasm.use('datepicker').transform('.datepicker', { locale: idioma+'_iso8601', timePicker: true, use24hrs: true , manual: false}); 
}

function vRellenar_Controles_Informes()
{
	switch (document.getElementById('Filtro_combo_Informe').selectedIndex)
	{
		// Si es un CSV
		case 2:
			Rellenar_Sensores_Instalacion("Filtro_combo_Dispositivo", 0, 0, "" , "", "");
			break;

		// Si no, es una grafica
		default:
			break; 
	}
}

function sObtener_Nombre_Magnitud(sAlias)
{
	//alert(sAlias);
	switch (sAlias)
	{
		case 'HUM':
			return iObtener_Cadena_AJAX("sensor_type1")+" (%)";
			break;
		case 'TEM':
			return iObtener_Cadena_AJAX("sensor_type2")+" (ºC)";
			break;
		case 'CON':
			return iObtener_Cadena_AJAX("sensor_type3")+" (dS/m)";
			break;
		case 'ANA':
			return iObtener_Cadena_AJAX("sensor_type4")+" (V)";
			break;
		case 'DIG':
			return iObtener_Cadena_AJAX("sensor_type5");
			break;
		case 'PLU':
			return iObtener_Cadena_AJAX("sensor_type6")+" (mm)";
			break;
		case 'ANE':
			return iObtener_Cadena_AJAX("sensor_type7")+" (km/h)";
			break;
		case 'VEL':
			return iObtener_Cadena_AJAX("sensor_type8")+" (º)";
			break;
		case 'PUL':
			return iObtener_Cadena_AJAX("sensor_type9");
			break;
		case '420':
			return "4-20mA (mA)";
			break;
		case '010':
			return "0..10V (V)";
			break;
		case 'DOU':
			return iObtener_Cadena_AJAX("sensor_type12");
			break;
		case 'FLU':
			return iObtener_Cadena_AJAX("sensor_type13")+" (m/s)";
			break;
		case 'ROT':
			return iObtener_Cadena_AJAX("sensor_type19");
			break;
		case 'SPH':
			return "pH";
			break;
		case 'OXI':
			return iObtener_Cadena_AJAX("sensor_type20")+" (%)";
			break;
		case 'NIV':
			return iObtener_Cadena_AJAX("sensor_type17");
			break;
		case 'PYR':
			return iObtener_Cadena_AJAX("sensor_type21")+" (W/m2)";
			break;
		case 'PRE':
			return iObtener_Cadena_AJAX("sensor_type22")+" (kPa)";
			break;
		case 'PRB':
			return iObtener_Cadena_AJAX("sensor_type22")+" (Ba)";
			break;
		case 'COR':
			return iObtener_Cadena_AJAX("sensor_type25")+" (mA)";
			break;
		case 'POT':
			return iObtener_Cadena_AJAX("sensor_type45")+" (W)";
			break;
		case 'FPO':
			return iObtener_Cadena_AJAX("sensor_type29")+" (FP)";
			break;
		case 'FRE':
			return iObtener_Cadena_AJAX("sensor_type31")+" (Hz)";
			break;	
		case 'ENE':
			return iObtener_Cadena_AJAX("sensor_type46")+" (Wh)";
			break;
		case 'THD':
			return iObtener_Cadena_AJAX("sensor_type47")+" (THD)";
			break;
		case 'OXD':
			return iObtener_Cadena_AJAX("sensor_type20")+" (mg/l)";
			break;
		case 'TUR':
			return iObtener_Cadena_AJAX("sensor_type23")+" (NTU)";
			break;
		case 'ORP':
			return "ORP (mV)";
			break;
		case 'AIR':
			return iObtener_Cadena_AJAX("sensor_type51")+" (mg/m3)";
			break;
		case 'AMR':
			return iObtener_Cadena_AJAX("sensor_type9");
			break;
			
		//AMB Genéricos
		case 'CAU':
			return iObtener_Cadena_AJAX("sensor_type87")+" (l/s)" ;
			break;	
		case 'MTS':
			return iObtener_Cadena_AJAX("sensor_type90")+" (m)" ;
			break;	
		case 'MMS':
			return iObtener_Cadena_AJAX("sensor_type89")+" (mm)" ;
			break;		
		case 'EVA':
			return iObtener_Cadena_AJAX("sensor_type88")+" (mm)" ;
			break;	
		case 'BAT':
			return iObtener_Cadena_AJAX("supply2")+" (V)";
			break;
		case 'COG':
			return iObtener_Cadena_AJAX("event_cob_gprs");
			break;							
		default:
			return iObtener_Cadena_AJAX("sensor_type14");
			break;
	}
}

function onGuardarPlantilla()
{
	var	xmlHttpDB;
	var sDatosOut;	
	var sSelect;
	var sTipo;	
	var sRadio;
	var sTitulo;
	var sGraf;	
	var url="guarda_informe_plantilla.php";
	//Si son graficas
	if(document.getElementById("Filtro_combo_Informe").selectedIndex<2)
	{
		var iResultado = document.getElementById("iframe_mapa").contentWindow.iComprobar_Magnitudes();
		if (iResultado == 0)
		{
			if(document.getElementById("Input_Nombre_Plantilla").value.length>0)
			{
				sDatosOut="?plantilla_nombre="+document.getElementById("Input_Nombre_Plantilla").value+"&instalacion_id="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value+"&tipo_informe="+document.getElementById("Filtro_combo_Informe").selectedIndex+"&usuario_nombre="+document.getElementById("user_name").value+"&cliente_db="+document.getElementById("db_cliente").value;
				for(i=1;i<5;i++)
				{
					sTitulo = "&g"+i+"_titulo="+document.getElementById("iframe_mapa").contentWindow.document.getElementById("titulo_g"+i).value;
					sSelect = document.getElementById("iframe_mapa").contentWindow.document.getElementById("box"+(2*i)+"View");
					sGraf = '';
					if (sSelect.length > 0)
					{
						for (var iI=0;iI<sSelect.length;iI++)
						{			
							sRadio = document.getElementById("iframe_mapa").contentWindow.document.getElementsByName("graph"+(i)+"s"+(iI+1));
							for (var iRadio = 0; iRadio < sRadio.length; iRadio++)
							{
								if (sRadio[iRadio].checked)
								{
									sTipo=sRadio[iRadio].value;
								}
							}
							sGraf += "&g"+i+"_sensor"+(iI+1)+"="+sSelect.options[iI].value+"&g"+i+"_tipo"+(iI+1)+"="+sTipo;
						}
					}
					sDatosOut += sTitulo+sGraf;
				}
				if(document.getElementById("Filtro_combo_Informe").selectedIndex==1)
				{
					sDatosOut += "&plantilla_intervalo="+document.getElementById("tiempoGrafica").value+"&plantilla_intervalo_unit="+document.getElementById("selectTiempo").selectedIndex;
					sDatosOut += "&plantilla_actualizacion="+document.getElementById("tiempoIntervalo").value+"&plantilla_actualizacion_unit="+document.getElementById("selectIntervalo").selectedIndex;
				}
				//alert(sDatosOut);
				url = url+sDatosOut;
				xmlHttpDB= GetXmlHttpObject();
				xmlHttpDB.open("GET",url,true);
				xmlHttpDB.onreadystatechange=function()
				{
					if (xmlHttpDB.readyState==4)
					{
						var data = xmlHttpDB.responseText;
						if(data.substr(0,5)=="ERROR")
						{
							alert(data);
						}
						else
						{
							cargar_plantillas("Plantillas_Lista",document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value,document.getElementById("user_name").value);
						}
					}
				}
				
				xmlHttpDB.send();
			}
			else
			{
				alert(iObtener_Cadena_AJAX('error_plantilla1'));
			}
		}
		else
		{
			alert(iObtener_Cadena_AJAX('general220')+' '+iResultado+' '+iObtener_Cadena_AJAX('error_graf10'));
		}
	}
	//Si son csvs
	else
	{
		sDatosOut="?plantilla_nombre="+document.getElementById("Input_Nombre_Plantilla").value+"&instalacion_id="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value+"&tipo_informe="+document.getElementById("Filtro_combo_Informe").selectedIndex+"&usuario_nombre="+document.getElementById("user_name").value+"&cliente_db="+document.getElementById("db_cliente").value;
		sDatosOut += "&g1_sensor1="+document.getElementById("Filtro_combo_Dispositivo").options[document.getElementById("Filtro_combo_Dispositivo").selectedIndex].value+"&g1_tipo1="+document.getElementById("Filtro_combo_Evento").selectedIndex;
		url = url+sDatosOut;
		xmlHttpDB= GetXmlHttpObject();
		xmlHttpDB.open("GET",url,true);
		xmlHttpDB.onreadystatechange=function()
		{
			if (xmlHttpDB.readyState==4)
			{
				var data = xmlHttpDB.responseText;
				if(data.substr(0,5)=="ERROR")
				{
					alert(data);
				}
				else
				{
					cargar_plantillas("Plantillas_Lista",document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value,document.getElementById("user_name").value);
				}
			}
		}
		
		xmlHttpDB.send();
	}
	
}

function OnChangePlantilla()
{
	var idPlantilla = document.getElementById("Plantillas_Lista").options[document.getElementById("Plantillas_Lista").selectedIndex].id;
	//alert(idPlantilla);
	var	xmlHttpDB;
	var url="carga_plantilla_datos.php?plantilla_id="+idPlantilla+"&instalacion_id="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value+"&cliente_db="+document.getElementById("db_cliente").value;
	//alert(url);
	xmlHttpDB= GetXmlHttpObject();
	xmlHttpDB.open("GET",url,false);
	xmlHttpDB.send();
		
	var data = xmlHttpDB.responseText;
	if(data.substr(0,4)=="ERROR")
	{
		alert(data);
	}
	else
	{
		var docPlantilla=xmlHttpDB.responseText;
		var xmlrespuestaPlantilla = parsear_xml(docPlantilla);
		var vvxPlantilla=xmlrespuestaPlantilla.getElementsByTagName("plantilla");
		var iIndice = 1;
		document.getElementById("Filtro_combo_Informe").selectedIndex=vvxPlantilla[0].attributes[iIndice++].nodeValue;
		onTipoInforme();
		
		document.getElementById("iframe_mapa").onload = function() {

			//alert("hi");
			if(document.getElementById('Filtro_combo_Informe').selectedIndex < 2)
			{
				//document.getElementById("iframe_mapa").contentWindow.document.getElementById("allto1").click();
			}
			else
			{
				vRellenar_Controles_Informes();	
			}
			
			if(document.getElementById('Filtro_combo_Informe').selectedIndex<2)
			{
				for(i=1;i<5;i++)
				{
					var sSelect= document.getElementById("iframe_mapa").contentWindow.document.getElementById("box"+(2*i)+"View");
					document.getElementById("iframe_mapa").contentWindow.document.getElementById("titulo_g"+i).value= vvxPlantilla[0].attributes[iIndice++].nodeValue;
					
					for (var iI=0;iI<4;iI++)
					{			
						sRadio = document.getElementById("iframe_mapa").contentWindow.document.getElementsByName("graph"+(i)+"s"+(iI+1));
						var sensor = vvxPlantilla[0].attributes[iIndice++].nodeValue;
						var tipo = vvxPlantilla[0].attributes[iIndice++].nodeValue;
						for (var iRadio = 0; iRadio < sRadio.length; iRadio++)
						{
							//alert(sRadio[iRadio].value+" vs "+tipo);
							if (sRadio[iRadio].value == tipo)
							{
								//alert("Sensor "+iI+" datos "+sRadio[iRadio].value+" vs "+tipo);
								sRadio[iRadio].checked = true;
							}
						}
						var sSelect = document.getElementById("iframe_mapa").contentWindow.document.getElementById("box"+(2*i-1)+"View");
						//alert(sSelect.length+" y es "+sensor);
						for(var iSelect = 0; iSelect< sSelect.length; iSelect++)
						{
							if(sSelect.options[iSelect].value==sensor)
							{
								//alert("Sensor "+iI+" value "+sSelect.options[iSelect].value+" vs "+sensor);
								sSelect.options[iSelect].selected = true;
								document.getElementById("iframe_mapa").contentWindow.document.getElementById("to"+(2*i)).click();
							}
						}
					}
				}
			}
			else
			{		
				//MPT Para saltarse el nombre de la grafica	
				iIndice++;
				var sensor = vvxPlantilla[0].attributes[iIndice++].nodeValue;
				var tipo = vvxPlantilla[0].attributes[iIndice++].nodeValue;
				
				//alert(sSelect.length+" y es "+sensor);
				document.getElementById("Filtro_combo_Evento").selectedIndex = tipo;
				OnCambioEventoInformes(); 
				var sSelect = document.getElementById("Filtro_combo_Dispositivo");
				for(var iSelect = 0; iSelect< sSelect.length; iSelect++)
				{
					if(sSelect.options[iSelect].value==sensor)
					{
						//alert("Sensor "+iI+" value "+sSelect.options[iSelect].value+" vs "+sensor);
						sSelect.options[iSelect].selected = true;
					}
				}
				
	
			}
			//alert(iIndice+" y tamaño "+vvxPlantilla[0].attributes.length);
			if(document.getElementById("Filtro_combo_Informe").selectedIndex == 1)
			{
				document.getElementById("tiempoGrafica").value = vvxPlantilla[0].attributes[iIndice++].nodeValue;
				document.getElementById("selectTiempo").selectedIndex = vvxPlantilla[0].attributes[iIndice++].nodeValue;
				document.getElementById("tiempoIntervalo").value = vvxPlantilla[0].attributes[iIndice++].nodeValue;
				document.getElementById("selectIntervalo").selectedIndex = vvxPlantilla[0].attributes[iIndice++].nodeValue;
			}
		}
	}
}

function onEliminarPlantilla()
{
	var	xmlHttpDB;
	var sDatosOut;	
	var sSelect;
	var sTipo;	
	var sRadio;
	var sTitulo;
	var sGraf;	
	var idPlantilla = document.getElementById("Plantillas_Lista").options[document.getElementById("Plantillas_Lista").selectedIndex].id;
	var url="elimina_informe_plantilla.php?plantilla_id="+idPlantilla+"&cliente_db="+document.getElementById("db_cliente").value;
	if (confirm(iObtener_Cadena_AJAX('plantilla8')+" \r\n"+iObtener_Cadena_AJAX('general0')))
	{
		xmlHttpDB= GetXmlHttpObject();
		xmlHttpDB.open("GET",url,true);
		xmlHttpDB.onreadystatechange=function()
		{
			if (xmlHttpDB.readyState==4)
			{
				alert(xmlHttpDB.responseText);
				cargar_plantillas("Plantillas_Lista",document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value,document.getElementById("user_name").value);
			}
		}
		
		xmlHttpDB.send();
	}
	
}
