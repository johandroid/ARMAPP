function vActualizarUsuarios(cliente_ident)
{	
	rellenar_div_principal(50,"&cliente_id="+cliente_ident);
}

function OnSubmenuListUsers()
{
	if (document.getElementById("comboClientes").length > 0)
	{
		document.getElementById("comboClientes").selectedIndex=0;
	}
	vActualizarUsuarios(this.options[this.selectedIndex].id);
}

function OnSubmenuAddUser()
{
	rellenar_div_principal(54,"");
	rellenar_div_submenu(99,"");
}

function cargar_clientes(opcion_entrada)
{
	var xmlHttpDispos;
	xmlHttpDispos= GetXmlHttpObject();
	var url = "carga_clientes_user.php?opcion_entrada="+opcion_entrada;
	xmlHttpDispos.onreadystatechange=function()
	{
		if (xmlHttpDispos.readyState==4)
		{
			var doc=xmlHttpDispos.responseText;
			var xmlrespuesta = parsear_xml(doc);
			var vvx=xmlrespuesta.getElementsByTagName("cliente");
			document.getElementById("comboClientes").length=0;
			for(i=0;i<vvx.length;i++)
			{
				if (xmlrespuesta.getElementsByTagName("cliente")[i].attributes[1].nodeValue.length == 0)
				{
					insertarOptionCombo("comboClientes",xmlrespuesta.getElementsByTagName("cliente")[i].attributes[0].nodeValue, iObtener_Cadena_AJAX('general1')+' '+xmlrespuesta.getElementsByTagName("cliente")[i].attributes[0].nodeValue);
				}
				else
				{
					insertarOptionCombo("comboClientes",xmlrespuesta.getElementsByTagName("cliente")[i].attributes[0].nodeValue, xmlrespuesta.getElementsByTagName("cliente")[i].attributes[1].nodeValue);
				}
			}
			if (document.getElementById("comboClientes").length > 0)
			{
				document.getElementById("comboClientes").selectedIndex=0;
				switch (opcion_entrada)
				{
					case 50:
						vActualizarUsuarios(document.getElementById("comboClientes").options[document.getElementById("comboClientes").selectedIndex].id);
						break;
					case 51:
						vActualizarInstalaciones(document.getElementById("comboClientes").options[document.getElementById("comboClientes").selectedIndex].id);
						break;
					case 52:
						vActualizarClientes(document.getElementById("comboClientes").options[document.getElementById("comboClientes").selectedIndex].id);
						break;
					default:
						break;
				}
			}
		}
	}
	xmlHttpDispos.open("GET",url,true);
	xmlHttpDispos.send(null);
}

function vActualizarClientes(cliente_ident)
{	
	rellenar_div_principal(52,"&id_cliente="+cliente_ident);
}

function OnSubmenuAddCliente()
{
	rellenar_div_principal(59,"");
	rellenar_div_submenu(99,"");
}
function OnClickConfigLogo(id_cliente)
{
	var xmlHttp;
	xmlHttp= GetXmlHttpObject();
	var url = "rellenar_div_principal.php?menu=86&id_cliente="+id_cliente;
	xmlHttp.onreadystatechange=function()
	{			
		if (xmlHttp.readyState==4)
		{			
			var doc=xmlHttp.responseText;
			parent.document.getElementById("iframe_mapa").src = doc;
		}
	}
	xmlHttp.open("GET",url,false);
	xmlHttp.send(null);
}
function OnSubmenuListClientes()
{
	if (document.getElementById("comboClientes").length > 0)
	{
		document.getElementById("comboClientes").selectedIndex=0;
	}
	vActualizarClientes(this.options[this.selectedIndex].id);
}

function OnSubmenuAdminConfigNotificaciones(iModoOfflineAux)
{
	var sCadenaINNER;
	
	document.getElementById('celda_submenuadmin_consumo').innerHTML = '';
	document.getElementById('submenu_consumo').innerHTML='+ '+iObtener_Cadena_AJAX('general2');
	if (iModoOfflineAux == 0)
	{
		if (document.getElementById('celda_submenuadmin_notificaciones').innerHTML == '')
		{
			sCadenaINNER = '<table width=100%">';
			sCadenaINNER += '<tr>	<td align="left">';
			sCadenaINNER += '		<a href="#" class="TextoMenuINV" id="submenu_ConfigSMS" onclick="OnSubmenuConfigSMS()">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- '+iObtener_Cadena_AJAX('general3')+'</a>';
			sCadenaINNER += '	</td></tr>';
			sCadenaINNER += '<tr>	<td align="center"></td></tr>';
			sCadenaINNER += '<tr>	<td align="left">';
			sCadenaINNER += '		<a href="#" class="TextoMenuINV" id="submenu_ConfigEMAIL" onclick="OnSubmenuConfigEMAIL()">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- '+iObtener_Cadena_AJAX('general4')+'</a>';
			sCadenaINNER += '	</td></tr>';
			sCadenaINNER += '<tr>	<td align="center"></td></tr>';
			sCadenaINNER += '<tr>	<td align="left">';
			sCadenaINNER += '		<a href="#" class="TextoMenuINV" id="submenu_ConfigEVENTOS" onclick="OnSubmenuConfigEVENTOS()">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- '+iObtener_Cadena_AJAX('general5')+'</a>';
			sCadenaINNER += '	</td></tr>';
			sCadenaINNER += '<tr>	<td align="center"></td></tr>';		
			sCadenaINNER += '</table>';
			
			document.getElementById('celda_submenuadmin_notificaciones').innerHTML=sCadenaINNER;
			document.getElementById('submenu_notificaciones').innerHTML='- '+iObtener_Cadena_AJAX('general6');	
		}
		else
		{
			document.getElementById('celda_submenuadmin_notificaciones').innerHTML = '';
			document.getElementById('submenu_notificaciones').innerHTML='+ '+iObtener_Cadena_AJAX('general6');
			rellenar_div_principal(53,"");
		}
	}
	else
	{
		rellenar_div_principal(80,"");
	}
	return;
}

function OnSubmenuAdminConsumo(iModoOfflineAux)
{
	var sCadenaINNER;
	var idioma=iObtener_Cadena_AJAX('idioma');
	Protoplasm.use('datepicker').transform('.datepicker', { locale: idioma+'_iso8601', timePicker: true, use24hrs: true , manual: false});
					
	document.getElementById('celda_submenuadmin_notificaciones').innerHTML = '';
	document.getElementById('submenu_notificaciones').innerHTML='+ '+iObtener_Cadena_AJAX('general6');
	if (iModoOfflineAux == 0)
	{
		if (document.getElementById('celda_submenuadmin_consumo').innerHTML == '')
		{
			sCadenaINNER = '<table width=100%">';
			sCadenaINNER += '<tr><td align="left">';
			sCadenaINNER += '		<text class="TextoMenuINV" id="submenu_ConsumoCliente">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- '+iObtener_Cadena_AJAX('general1')+'</a>';
			sCadenaINNER += '</td></tr>';
			sCadenaINNER += '<tr><td align="center"><select id="comboClientes" size="16" style="width:80%;height:70px;margin:0px 0 5px 0;" onchange="vCambio_Cliente()"/></td></tr>';
			sCadenaINNER += '<tr><td align="left">';
			sCadenaINNER += '		<text class="TextoMenuINV" id="submenu_ConsumoInst"">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- '+iObtener_Cadena_AJAX('general7')+'</a>';
			sCadenaINNER += '	</td></tr>';
			sCadenaINNER += '<tr><td align="center"><select id="comboInst" size="16" style="width:80%;height:70px;margin:0px 0 5px 0;" disabled="disabled" onchange="vActualizarConsumo()"/></td></tr>';
			sCadenaINNER += '<tr><td align="left">';
			sCadenaINNER += '		<text class="TextoMenuINV" id="submenu_ConsumoFecha"">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- '+iObtener_Cadena_AJAX('general8')+'</a>';
			sCadenaINNER += '</td></tr>';
			sCadenaINNER += '<tr><td align="center">&nbsp;&nbsp;&nbsp;&nbsp;<text class="TextoMenuINV" >Desde</a>&nbsp;&nbsp;<input valign="top" align="center" type="text" id="FechaInicial" class="datepicker" style="text-align:center;width:140px"></td></tr>';
			sCadenaINNER += '<tr><td align="center">&nbsp;&nbsp;&nbsp;&nbsp;<text class="TextoMenuINV" >Hasta</a>&nbsp;&nbsp;&nbsp;<input valign="top" align="center" type="text" id="FechaFinal" class="datepicker" style="text-align:center;width:140px"></td></tr>';
			sCadenaINNER += '<tr><td align="center"><br/></td></tr>';		
			sCadenaINNER += '<tr><td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" onclick="vActualizarConsumo()" value="'+iObtener_Cadena_AJAX('general51')+'" name="actualiza_consumo" id="actualiza_consumo" style="width:120px;text-align:center" class="boton_fino_largo"/></td></tr>';
			sCadenaINNER += '</table>';

			document.getElementById('celda_submenuadmin_consumo').innerHTML=sCadenaINNER;
			document.getElementById('submenu_consumo').innerHTML='- '+iObtener_Cadena_AJAX('general2');
			if ((document.getElementById('comboClientes').length > -1) && (document.getElementById('comboInst').length > -1))
			{
				document.getElementById('comboClientes').selectedIndex = 0;
				document.getElementById('comboInst').selectedIndex = 0;
			}
			cargar_clientes_admin();
			rellenar_div_principal(65,"");
			
			var idioma=iObtener_Cadena_AJAX('idioma');
			Protoplasm.use('datepicker').transform('.datepicker', { locale: idioma+'_iso8601', timePicker: true, use24hrs: true , manual: false});			
		}
		else
		{
			document.getElementById('celda_submenuadmin_consumo').innerHTML = '';
			document.getElementById('submenu_consumo').innerHTML='+ '+iObtener_Cadena_AJAX('general2');
			rellenar_div_principal(53,"");
		}
		
	}
	else
	{
		rellenar_div_principal(80,"");
	}
					
	return;
}

function OnSubmenuConfigSMS()
{
	rellenar_div_principal(61,"");
}

function OnSubmenuAdminConfigGeneral()
{
	rellenar_div_principal(53,"");
	document.getElementById('celda_submenuadmin_notificaciones').innerHTML = '';
	document.getElementById('submenu_notificaciones').innerHTML='+ '+iObtener_Cadena_AJAX('general6');
	document.getElementById('celda_submenuadmin_consumo').innerHTML = '';
	document.getElementById('submenu_consumo').innerHTML='+ '+iObtener_Cadena_AJAX('general2');
	
}

function OnSubmenuConfigEMAIL()
{
	rellenar_div_principal(62,"");
}

function OnSubmenuConfigEVENTOS()
{
	rellenar_div_principal(63,"");
}

function vActualizarConsumo()
{
	document.getElementById("iframe_mapa").contentWindow.vCargar_Params_Consumo_Admin();
	document.getElementById("iframe_mapa").contentWindow.vCargar_Tabla_Consumo_SMS();
	document.getElementById("iframe_mapa").contentWindow.vCargar_Tabla_Consumo_Email();
	document.getElementById("iframe_mapa").contentWindow.vCargar_SMS_Pendientes();
}

function cargar_clientes_admin()
{
	var xmlHttpDispos;
	xmlHttpDispos= GetXmlHttpObject();
	var url = "carga_clientes.php";
	xmlHttpDispos.onreadystatechange=function()
	{
		if (xmlHttpDispos.readyState==4)
		{
			var doc=xmlHttpDispos.responseText;
			var xmlrespuesta = parsear_xml(doc);
			var vvx=xmlrespuesta.getElementsByTagName("cliente");
			document.getElementById("comboClientes").length=0;
			for(i=0;i<vvx.length;i++)
			{
				if (xmlrespuesta.getElementsByTagName("cliente")[i].attributes[1].nodeValue.length == 0)
				{
					insertarOptionCombo("comboClientes",xmlrespuesta.getElementsByTagName("cliente")[i].attributes[0].nodeValue, iObtener_Cadena_AJAX('general1')+' '+xmlrespuesta.getElementsByTagName("cliente")[i].attributes[0].nodeValue);
				}
				else
				{
					insertarOptionCombo("comboClientes",xmlrespuesta.getElementsByTagName("cliente")[i].attributes[0].nodeValue, xmlrespuesta.getElementsByTagName("cliente")[i].attributes[1].nodeValue);
				}
			}
			if (document.getElementById("comboClientes").length > 0)
			{
				document.getElementById("comboClientes").selectedIndex=0;
			}
		}
	}
	xmlHttpDispos.open("GET",url,true);
	xmlHttpDispos.send(null);
}

function vCambio_Cliente()
{
	if (document.getElementById("comboClientes").selectedIndex > 0)
	{
		top.document.getElementById("comboInst").disabled="";
		top.document.getElementById("comboInst").length = 0;
		cargar_Instalaciones_admin(document.getElementById("comboClientes").options[document.getElementById("comboClientes").selectedIndex].id);
		top.document.getElementById("iframe_mapa").contentWindow.document.getElementById("recarga_saldo").disabled="";
		top.document.getElementById("iframe_mapa").contentWindow.document.getElementById("saldo_nuevo").disabled="";
		top.document.getElementById("iframe_mapa").contentWindow.document.getElementById("quita_saldo").disabled="";
		top.document.getElementById("iframe_mapa").contentWindow.document.getElementById("saldo_quitar").disabled="";
		top.document.getElementById("iframe_mapa").contentWindow.document.getElementById("Anular_Pendientes").disabled="";
	}
	else
	{
		top.document.getElementById("comboInst").disabled="disabled";
		top.document.getElementById("comboInst").length = 0;
		top.document.getElementById("iframe_mapa").contentWindow.document.getElementById("recarga_saldo").disabled="disabled";
		top.document.getElementById("iframe_mapa").contentWindow.document.getElementById("saldo_nuevo").disabled="disabled";
		top.document.getElementById("iframe_mapa").contentWindow.document.getElementById("quita_saldo").disabled="disabled";
		top.document.getElementById("iframe_mapa").contentWindow.document.getElementById("saldo_quitar").disabled="disabled";
		top.document.getElementById("iframe_mapa").contentWindow.document.getElementById("Anular_Pendientes").disabled="disabled";
	}
	//top.document.getElementById("iframe_mapa").contentWindow.vCargar_Params_Consumo_Admin();
	//top.document.getElementById("iframe_mapa").contentWindow.vCargar_SMS_Pendientes();
	vActualizarConsumo();
}

function cargar_Instalaciones_admin(id_cliente)
{
	var vvx;
	var xmlHttpParam;
	var sNombreCombo;
	xmlHttpParam= GetXmlHttpObject();
	var url = "carga_instalaciones_admin.php?cliente_id="+id_cliente;
	xmlHttpParam.onreadystatechange=function()
	{
		if (xmlHttpParam.readyState==4)
		{
			var doc=xmlHttpParam.responseText;
			var xmlrespuesta = parsear_xml(doc);
			vvx=xmlrespuesta.getElementsByTagName("instalacion");
			document.getElementById("comboInst").length = 0;
			for(i=0;i<vvx.length;i++)
			{
				insertarOptionComboValue("comboInst",xmlrespuesta.getElementsByTagName("instalacion")[i].attributes[0].nodeValue, xmlrespuesta.getElementsByTagName("instalacion")[i].attributes[2].nodeValue, '',xmlrespuesta.getElementsByTagName("instalacion")[i].attributes[1].nodeValue);
			}
		}
	}
	xmlHttpParam.open("GET",url,true);
	xmlHttpParam.send(null);
}

function vLimpiar_Fecha(iCampo)
{
	switch (iCampo)
	{
		case 1:
			document.getElementById("FechaFinal").value="";
			break;
			
		default:
			document.getElementById("FechaInicial").value="";
		break;
	}
}