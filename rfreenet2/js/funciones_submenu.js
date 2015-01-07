function OnSubmenuInstalaciones()
{	
	var sCadenaINNER;
	
	document.getElementById('celda_submenu_disp').innerHTML = '';
	document.getElementById('submenu_Dispositivos').innerHTML='+ '+iObtener_Cadena_AJAX('general9');
	document.getElementById('celda_submenu_notifica').innerHTML = '';
	document.getElementById('submenu_Notificaciones').innerHTML='+ '+iObtener_Cadena_AJAX('general6');
	document.getElementById('celda_submenu_vista').innerHTML = '';
	document.getElementById('submenu_vista').innerHTML='+ '+iObtener_Cadena_AJAX('general47');
	document.getElementById('celda_submenu_general').innerHTML = '';
	document.getElementById('submenu_general').innerHTML = "+ "+iObtener_Cadena_AJAX('general75');	
	document.getElementById('celda_submenu_et').innerHTML = '';
	document.getElementById('submenu_et').innerHTML = "+ "+iObtener_Cadena_AJAX('general250');
		
	if (document.getElementById('celda_submenu_inst').innerHTML == '')
	{
		sCadenaINNER = '<table width=100%"><tr><td align="left">';
		sCadenaINNER += '<a href="#" class="TextoMenuINV" id="submenu_addinst" onclick="OnSubmenuAddInst()">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- '+iObtener_Cadena_AJAX('general50')+' '+iObtener_Cadena_AJAX('general7')+'</a>';
		sCadenaINNER += '</td></tr><tr><td align="center"></td></tr></table>';
		document.getElementById('celda_submenu_inst').innerHTML=sCadenaINNER;
		document.getElementById('submenu_Instalaciones').innerHTML='- '+iObtener_Cadena_AJAX('general10');
		document.getElementById("comboInstalaciones").disabled="disabled";
		rellenar_div_principal(51,"");
	}
	else
	{
		document.getElementById('celda_submenu_inst').innerHTML = '';
		document.getElementById('submenu_Instalaciones').innerHTML='+ '+iObtener_Cadena_AJAX('general10');
		document.getElementById("comboInstalaciones").disabled="";
		if (document.getElementById("comboInstalaciones").length > 0)
		{
			document.getElementById("comboInstalaciones").selectedIndex=0;
			rellenar_div_principal(7,"&instalacion_id="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
		}
		else
		{
			rellenar_div_principal(23,"");
		}
	}
	return;
}

function OnSubmenuDispositivos()
{
	var sCadenaSubMenu;
	document.getElementById("comboInstalaciones").disabled="";
	document.getElementById('celda_submenu_inst').innerHTML = '';
	document.getElementById('submenu_Instalaciones').innerHTML='+ '+iObtener_Cadena_AJAX('general10');
	document.getElementById('celda_submenu_notifica').innerHTML = '';
	document.getElementById('submenu_Notificaciones').innerHTML='+ '+iObtener_Cadena_AJAX('general6');
	document.getElementById('celda_submenu_vista').innerHTML = '';
	document.getElementById('submenu_vista').innerHTML='+ '+iObtener_Cadena_AJAX('general47');
	document.getElementById('celda_submenu_general').innerHTML = '';
	document.getElementById('submenu_general').innerHTML = "+ "+iObtener_Cadena_AJAX('general75');	
	document.getElementById('celda_submenu_et').innerHTML = '';
	document.getElementById('submenu_et').innerHTML = "+ "+iObtener_Cadena_AJAX('general250');	
	if (document.getElementById('celda_submenu_disp').innerHTML == '')
	{
		sCadenaSubMenu = '<table border="0" width=100%">';
		sCadenaSubMenu += '<tr><td align="left">';
		sCadenaSubMenu += '		<a href="#" class="TextoMenuINV" onclick="OnClickConfigNodo()" id="celda_titulo_nodos">&nbsp;&nbsp;+ '+iObtener_Cadena_AJAX('general12')+'</a>';
		sCadenaSubMenu += '	</td></tr>';
		sCadenaSubMenu += '<tr>	<td align="center" id="celda_configura_nodos"></td></tr>';
		sCadenaSubMenu += '<tr>	<td align="left">';
		sCadenaSubMenu += '		<a href="#" class="TextoMenuINV" onclick="OnClickConfigUTC()" id="celda_titulo_utcs">&nbsp;&nbsp;+ '+iObtener_Cadena_AJAX('general254')+'</a>';
		sCadenaSubMenu += '	</td></tr>';
		sCadenaSubMenu += '<tr>	<td align="center" id="celda_configura_utcs"></td></tr>';			
		sCadenaSubMenu += '<tr>	<td align="left">';
		sCadenaSubMenu += '		<a href="#" class="TextoMenuINV" onclick="OnClickConfigGW()" id="celda_titulo_gateways">&nbsp;&nbsp;+ '+iObtener_Cadena_AJAX('general11')+'</a>';
		sCadenaSubMenu += '	</td></tr>';
		sCadenaSubMenu += '<tr>	<td align="center" id="celda_configura_gateways"></td></tr>';		
		sCadenaSubMenu += '<tr>	<td align="left">';
		sCadenaSubMenu += '		<a href="#" class="TextoMenuINV" onclick="OnClickConfigGWLow()" id="celda_titulo_gateways_low">&nbsp;&nbsp;+ '+iObtener_Cadena_AJAX('general290')+'</a>';
		sCadenaSubMenu += '	</td></tr>';	
		sCadenaSubMenu += '<tr>	<td align="center" id="celda_configura_gateways_low"></td></tr>';		
		sCadenaSubMenu += '<tr height="0">	<td align="left">';
		sCadenaSubMenu += '		<a href="#" class="TextoMenuINV" onclick="OnClickConfigTelemando()" id="celda_titulo_telemando">&nbsp;&nbsp;+ '+iObtener_Cadena_AJAX('general291')+'</a>';
		sCadenaSubMenu += '	</td></tr>';
		sCadenaSubMenu += '<tr>	<td align="center" id="celda_configura_telemando"></td></tr>';
		sCadenaSubMenu += '</table>';
		document.getElementById('celda_submenu_disp').innerHTML=sCadenaSubMenu;
		document.getElementById('submenu_Dispositivos').innerHTML='- '+iObtener_Cadena_AJAX('general9');
	}
	else
	{
		document.getElementById('celda_submenu_disp').innerHTML = '';
		document.getElementById('submenu_Dispositivos').innerHTML='+ '+iObtener_Cadena_AJAX('general9');
	}
	rellenar_div_principal(7,"&instalacion_id="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
	return;
}

function OnSubmenuNotificaciones()
{		
	var sCadenaSubMenu;
	
	document.getElementById("comboInstalaciones").disabled="";
	document.getElementById('celda_submenu_inst').innerHTML = '';
	document.getElementById('submenu_Instalaciones').innerHTML='+ '+iObtener_Cadena_AJAX('general10');
	document.getElementById('celda_submenu_disp').innerHTML = '';
	document.getElementById('submenu_Dispositivos').innerHTML='+ '+iObtener_Cadena_AJAX('general9');
	document.getElementById('celda_submenu_notifica').innerHTML = '';
	document.getElementById('submenu_Notificaciones').innerHTML='+ '+iObtener_Cadena_AJAX('general6');	
	document.getElementById('celda_submenu_vista').innerHTML = '';
	document.getElementById('submenu_vista').innerHTML='+ '+iObtener_Cadena_AJAX('general47');
	document.getElementById('celda_submenu_general').innerHTML = '';
	document.getElementById('submenu_general').innerHTML = "+ "+iObtener_Cadena_AJAX('general75');	
	document.getElementById('celda_submenu_et').innerHTML = '';
	document.getElementById('submenu_et').innerHTML = "+ "+iObtener_Cadena_AJAX('general250');	
	
	if (document.getElementById('celda_submenu_notifica').innerHTML == '')
	{
		sCadenaSubMenu = '<table border="0" width=100%">';
		sCadenaSubMenu += '<tr>	<td align="left">';
		sCadenaSubMenu += '		<a href="#" class="TextoMenuINV" onclick="OnClickConfigSMS()" id="celda_titulo_SMS">&nbsp;&nbsp;- '+iObtener_Cadena_AJAX('general3')+'</a>';
		sCadenaSubMenu += '	</td></tr>';
		sCadenaSubMenu += '<tr>	<td align="center" id="celda_configura_SMS"></td></tr>';
		sCadenaSubMenu += '<tr>	<td align="left">';
		sCadenaSubMenu += '		<a href="#" class="TextoMenuINV" onclick="OnClickConfigEMAIL()" id="celda_titulo_EMAIL">&nbsp;&nbsp;- '+iObtener_Cadena_AJAX('general4')+'</a>';
		sCadenaSubMenu += '	</td></tr>';
		sCadenaSubMenu += '<tr>	<td align="center" id="celda_configura_EMAIL"></td></tr>';
		sCadenaSubMenu += '</table>';
		document.getElementById('celda_submenu_notifica').innerHTML=sCadenaSubMenu;
		document.getElementById('submenu_Notificaciones').innerHTML='- '+iObtener_Cadena_AJAX('general6');
	}
	else
	{
		document.getElementById('celda_submenu_notifica').innerHTML = '';
		document.getElementById('submenu_Notificaciones').innerHTML='+ '+iObtener_Cadena_AJAX('general6');
	}
	rellenar_div_principal(66,"");
	return;
}
function OnSubmenuColaEnvios()
{
	document.getElementById("comboInstalaciones").disabled="";
	document.getElementById('celda_submenu_disp').innerHTML = '';
	document.getElementById('submenu_Dispositivos').innerHTML='+'+iObtener_Cadena_AJAX('general9');
	document.getElementById('celda_submenu_inst').innerHTML = '';
	document.getElementById('submenu_Instalaciones').innerHTML='+ '+iObtener_Cadena_AJAX('general10');
	document.getElementById('celda_submenu_notifica').innerHTML = '';
	document.getElementById('submenu_Notificaciones').innerHTML='+ '+iObtener_Cadena_AJAX('general6');	
	document.getElementById('celda_submenu_general').innerHTML = '';
	document.getElementById('submenu_general').innerHTML = "+ "+iObtener_Cadena_AJAX('general75');		
	document.getElementById('celda_submenu_vista').innerHTML = '';
	document.getElementById('submenu_vista').innerHTML='+ '+iObtener_Cadena_AJAX('general47');
	document.getElementById('celda_submenu_et').innerHTML = '';
	document.getElementById('submenu_et').innerHTML = "+ "+iObtener_Cadena_AJAX('general250');		
	rellenar_div_principal(70,"&instalacion_id="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
}
function OnSubmenuConfigGeneral(id_cliente)
{
	var sCadenaINNER;
	document.getElementById("comboInstalaciones").disabled="";
	document.getElementById('celda_submenu_disp').innerHTML = '';
	document.getElementById('submenu_Dispositivos').innerHTML='+ '+iObtener_Cadena_AJAX('general9');
	document.getElementById('celda_submenu_inst').innerHTML = '';
	document.getElementById('submenu_Instalaciones').innerHTML='+ '+iObtener_Cadena_AJAX('general10');
	document.getElementById('celda_submenu_notifica').innerHTML = '';
	document.getElementById('submenu_Notificaciones').innerHTML='+ '+iObtener_Cadena_AJAX('general6');	
	document.getElementById('celda_submenu_general').innerHTML = '';
	document.getElementById('submenu_general').innerHTML = "+ "+iObtener_Cadena_AJAX('general75');			
	document.getElementById('celda_submenu_vista').innerHTML = '';
	document.getElementById('submenu_vista').innerHTML='+ '+iObtener_Cadena_AJAX('general47');
	document.getElementById('celda_submenu_et').innerHTML = '';
	document.getElementById('submenu_et').innerHTML = "+ "+iObtener_Cadena_AJAX('general250');	
	
	if (document.getElementById('celda_submenu_general').innerHTML == "")
	{
		document.getElementById('submenu_general').innerHTML = "&nbsp;&nbsp;- "+iObtener_Cadena_AJAX('general75');
		sCadenaINNER = '<table width=100%">';
		sCadenaINNER += '<tr>	<td align="left">';
		sCadenaINNER += '		<a href="#" class="TextoMenuINV" onclick="OnClickConfigTiempos()" id="celda_titulo_config_tiempos">&nbsp;&nbsp;&nbsp;&nbsp;- '+iObtener_Cadena_AJAX('general100')+'</a>';
		sCadenaINNER += '	</td></tr>';
		sCadenaINNER += '<tr>	<td align="center" id="celda_config_tiempos"></td></tr>';
		sCadenaINNER += '<tr>	<td align="left">';
		sCadenaINNER += '		<a href="#" class="TextoMenuINV" onclick="OnClickConfigLogo(\''+ id_cliente +'\')" id="celda_titulo_config_logo">&nbsp;&nbsp;&nbsp;&nbsp;- '+iObtener_Cadena_AJAX('general298')+'</a>';
		sCadenaINNER += '	</td></tr>';
		sCadenaINNER += '<tr>	<td align="center" id="celda_config_logo"></td></tr>';
		sCadenaINNER += '</table>';
		document.getElementById('celda_submenu_general').innerHTML = sCadenaINNER;
	}
	else
	{
		document.getElementById('celda_submenu_general').innerHTML = '';
		document.getElementById('submenu_general').innerHTML = "+ "+iObtener_Cadena_AJAX('general75');
	}
	
	rellenar_div_principal(10,"");
}
function OnClickConfigTiempos()
{
	rellenar_div_principal(10,"");
}
function OnClickConfigLogo(id_cliente)
{
	rellenar_div_principal(85,"&id_cliente="+id_cliente);
}
function OnClickConfigETC()
{
	rellenar_div_principal(84,"");
}
function OnClickConfigEVAPO()
{
	rellenar_div_principal(87,"&instalacion_id="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
}
function OnSubmenuVistaGeneral()
{
	document.getElementById("comboInstalaciones").disabled="";
	document.getElementById('celda_submenu_disp').innerHTML = '';
	document.getElementById('submenu_Dispositivos').innerHTML='+ '+iObtener_Cadena_AJAX('general9');
	document.getElementById('celda_submenu_inst').innerHTML = '';	
	document.getElementById('submenu_Instalaciones').innerHTML='+ '+iObtener_Cadena_AJAX('general10');
	document.getElementById('celda_submenu_notifica').innerHTML = '';
	document.getElementById('submenu_Notificaciones').innerHTML='+ '+iObtener_Cadena_AJAX('general6');	
	document.getElementById('celda_submenu_general').innerHTML = '';
	document.getElementById('submenu_general').innerHTML = "+ "+iObtener_Cadena_AJAX('general75');
	document.getElementById('celda_submenu_et').innerHTML = '';
	document.getElementById('submenu_et').innerHTML = "+ "+iObtener_Cadena_AJAX('general250');	
	
	if (document.getElementById('celda_submenu_vista').innerHTML == "")
	{
		sCadenaSubMenu = '<table border="0" width=100%">';
		sCadenaSubMenu += '<tr>	<td align="left">';
		sCadenaSubMenu += '		<a href="#" class="TextoMenuINV" onclick="OnClickVistaConfig()" id="celda_titulo_vista_config">&nbsp;&nbsp;- '+iObtener_Cadena_AJAX('general259')+'</a>';
		sCadenaSubMenu += '	</td></tr>';
		sCadenaSubMenu += '<tr>	<td align="left">';
		sCadenaSubMenu += '		<a href="#" class="TextoMenuINV" onclick="OnClickVistaMedidas()" id="celda_titulo_vista_medidas">&nbsp;&nbsp;- '+iObtener_Cadena_AJAX('general260')+'</a>';
		sCadenaSubMenu += '	</td></tr>';
		sCadenaSubMenu += '</table>';
		document.getElementById('celda_submenu_vista').innerHTML=sCadenaSubMenu;
		document.getElementById('submenu_vista').innerHTML='- '+iObtener_Cadena_AJAX('general47');
	}
	else
	{
		document.getElementById('celda_submenu_vista').innerHTML = '';
		document.getElementById('submenu_vista').innerHTML='+ '+iObtener_Cadena_AJAX('general47');
	}
	rellenar_div_principal(7,"&instalacion_id="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
}

function OnClickVistaConfig()
{
	rellenar_div_principal(7,"&instalacion_id="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
}
function OnClickVistaMedidas()
{
	rellenar_div_principal(29,"&instalacion_id="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
}

function OnSubmenuConfigET()
{
	document.getElementById("comboInstalaciones").disabled="";
	document.getElementById('celda_submenu_disp').innerHTML = '';
	document.getElementById('submenu_Dispositivos').innerHTML='+ '+iObtener_Cadena_AJAX('general9');
	document.getElementById('celda_submenu_inst').innerHTML = '';
	document.getElementById('submenu_Instalaciones').innerHTML='+ '+iObtener_Cadena_AJAX('general10');
	document.getElementById('celda_submenu_notifica').innerHTML = '';
	document.getElementById('submenu_Notificaciones').innerHTML='+ '+iObtener_Cadena_AJAX('general6');	
	document.getElementById('celda_submenu_vista').innerHTML = '';
	document.getElementById('submenu_vista').innerHTML='+ '+iObtener_Cadena_AJAX('general47');
	document.getElementById('celda_submenu_general').innerHTML = '';
	document.getElementById('submenu_general').innerHTML = "+ "+iObtener_Cadena_AJAX('general75');	
	document.getElementById('celda_submenu_et').innerHTML = '';
	document.getElementById('submenu_et').innerHTML = "+ "+iObtener_Cadena_AJAX('general250');	
		
	if (document.getElementById('celda_submenu_et').innerHTML == "")
	{
		document.getElementById('submenu_et').innerHTML = "&nbsp;&nbsp;- "+iObtener_Cadena_AJAX('general250');
		sCadenaINNER = '<table width=100%">';
		sCadenaINNER += '<tr>	<td align="left">';
		sCadenaINNER += '		<a href="#" class="TextoMenuINV" onclick="OnClickConfigETC()" id="celda_titulo_config_etc">&nbsp;&nbsp;&nbsp;&nbsp;- '+iObtener_Cadena_AJAX('general312')+'</a>';
		sCadenaINNER += '	</td></tr>';
		sCadenaINNER += '<tr>	<td align="center" id="celda_config_etc"></td></tr>';
		sCadenaINNER += '<tr>	<td align="left">';
		sCadenaINNER += '		<a href="#" class="TextoMenuINV" onclick="OnClickConfigEVAPO(\''+ id_cliente +'\')" id="celda_titulo_config_evapo">&nbsp;&nbsp;&nbsp;&nbsp;- '+iObtener_Cadena_AJAX('general313')+'</a>';
		sCadenaINNER += '	</td></tr>';
		sCadenaINNER += '<tr>	<td align="center" id="celda_config_evapo"></td></tr>';
		sCadenaINNER += '</table>';
		document.getElementById('celda_submenu_et').innerHTML = sCadenaINNER;
	}
	else
	{
		document.getElementById('celda_submenu_et').innerHTML = '';
		document.getElementById('submenu_et').innerHTML = "+ "+iObtener_Cadena_AJAX('general250');
	}	
	
	rellenar_div_principal(84,"&instalacion_id="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
}

function OnSubmenuUsuarios()
{
	document.getElementById("comboInstalaciones").disabled="";
	document.getElementById('celda_submenu_disp').innerHTML = '';
	document.getElementById('submenu_Dispositivos').innerHTML='+ '+iObtener_Cadena_AJAX('general9');
	document.getElementById('celda_submenu_inst').innerHTML = '';
	document.getElementById('submenu_Instalaciones').innerHTML='+ '+iObtener_Cadena_AJAX('general10');
	document.getElementById('celda_submenu_notifica').innerHTML = '';
	document.getElementById('submenu_Notificaciones').innerHTML='+ '+iObtener_Cadena_AJAX('general6');	
	document.getElementById('celda_submenu_vista').innerHTML = '';
	document.getElementById('submenu_vista').innerHTML='+ '+iObtener_Cadena_AJAX('general47');
	document.getElementById('celda_submenu_general').innerHTML = '';
	document.getElementById('submenu_general').innerHTML = "+ "+iObtener_Cadena_AJAX('general75');	
	document.getElementById('celda_submenu_et').innerHTML = '';
	document.getElementById('submenu_et').innerHTML = "+ "+iObtener_Cadena_AJAX('general250');	
	rellenar_div_principal(14,"");
}

function OnClickConfigNodo()
{
	var sCadenaINNER;
	document.getElementById('celda_configura_gateways').innerHTML = "";
	document.getElementById('celda_titulo_gateways').innerHTML = "&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general11');
	document.getElementById('celda_configura_utcs').innerHTML = "";
	document.getElementById('celda_titulo_utcs').innerHTML = "&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general254');	
	document.getElementById('celda_configura_gateways_low').innerHTML = "";
	document.getElementById('celda_titulo_gateways_low').innerHTML = "&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general290');
	document.getElementById('celda_configura_telemando').innerHTML = "";
	document.getElementById('celda_titulo_telemando').innerHTML = "&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general291');
	sCadenaINNER = "";
	if (document.getElementById('celda_configura_nodos').innerHTML == "")
	{
		document.getElementById('celda_titulo_nodos').innerHTML = "&nbsp;&nbsp;- "+iObtener_Cadena_AJAX('general12');
		sCadenaINNER = '<table width=100%">';
		sCadenaINNER += '<tr>	<td align="left">';
		sCadenaINNER += '		<a href="#" class="TextoMenuINV" onclick="OnClickConfigGeneralNodos()" id="celda_titulo_general_nodos">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ '+iObtener_Cadena_AJAX('general14')+'</a>';
		sCadenaINNER += '	</td></tr>';
		sCadenaINNER += '<tr>	<td align="center" id="celda_config_general_nodos"></td></tr>';
		sCadenaINNER += '<tr>	<td align="left">';
		sCadenaINNER += '		<a href="#" class="TextoMenuINV" onclick="OnClickEliminarNodos()" id="celda_titulo_eliminar_nodos">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ '+iObtener_Cadena_AJAX('general56')+' '+iObtener_Cadena_AJAX('general21')+'</a>';
		sCadenaINNER += '	</td></tr>';
		sCadenaINNER += '<tr>	<td align="center" id="celda_eliminar_nodos"></td></tr>';
		sCadenaINNER += '<tr>	<td align="left">';
		sCadenaINNER += '		<a href="#" class="TextoMenuINV" onclick="OnClickSituarNuevosNodos()">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- '+iObtener_Cadena_AJAX('general16')+'</a>';
		sCadenaINNER += '	</td></tr>';
		sCadenaINNER += '<tr>	<td align="center"></td></tr>';
		sCadenaINNER += '<tr>	<td align="left">';
		sCadenaINNER += '		<a href="#" class="TextoMenuINV" onclick="OnClickSituarNodos()" id="celda_titulo_situar_nodos">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ '+iObtener_Cadena_AJAX('general17')+'</a>';
		sCadenaINNER += '	</td></tr>';
		sCadenaINNER += '<tr>	<td align="center" id="celda_config_situar_nodos"></td></tr>';
		sCadenaINNER += '<tr>	<td align="left">';
		sCadenaINNER += '		<a href="#" class="TextoMenuINV" onclick="OnClickActuarNodos()" id="celda_titulo_actuar_nodos">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ '+iObtener_Cadena_AJAX('general15')+'</a>';
		sCadenaINNER += '	</td></tr>';
		sCadenaINNER += '<tr>	<td align="center" id="celda_config_actuar_nodos"></td></tr>';
		sCadenaINNER += '</table>';
	}
	else
	{
		document.getElementById('celda_titulo_nodos').innerHTML = "&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general12');
	}
	document.getElementById('celda_configura_nodos').innerHTML = sCadenaINNER;
	rellenar_div_principal(7,"&instalacion_id="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
}

function OnClickConfigGW()
{
	var sCadenaINNER;
	document.getElementById('celda_configura_nodos').innerHTML = "";
	document.getElementById('celda_titulo_nodos').innerHTML = "&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general12');
	document.getElementById('celda_configura_utcs').innerHTML = "";
	document.getElementById('celda_titulo_utcs').innerHTML = "&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general254');
	document.getElementById('celda_configura_gateways_low').innerHTML = "";
	document.getElementById('celda_titulo_gateways_low').innerHTML = "&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general290');
	document.getElementById('celda_configura_telemando').innerHTML = "";
	document.getElementById('celda_titulo_telemando').innerHTML = "&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general291');
	sCadenaINNER = "";
	if (document.getElementById('celda_configura_gateways').innerHTML == "")
	{
		document.getElementById('celda_titulo_gateways').innerHTML = "&nbsp;&nbsp;- "+iObtener_Cadena_AJAX('general11');
		sCadenaINNER = '<table width=100%">';
		sCadenaINNER += '<tr>	<td align="left">';
		sCadenaINNER += '		<a href="#" class="TextoMenuINV" onclick="OnClickAnyadirGW()" id="celda_titulo_anyadir_gateways">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- '+iObtener_Cadena_AJAX('general52')+'</a>';
		sCadenaINNER += '	</td></tr>';
		sCadenaINNER += '<tr>	<td align="center" id="celda_anyadir_gateways"></td></tr>';
		sCadenaINNER += '<tr>	<td align="left">';
		sCadenaINNER += '		<a href="#" class="TextoMenuINV" onclick="OnClickConfigGeneralGW()" id="celda_titulo_general_gateways">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ '+iObtener_Cadena_AJAX('general14')+'</a>';
		sCadenaINNER += '	</td></tr>';
		sCadenaINNER += '<tr>	<td align="center" id="celda_config_general_gateways"></td></tr>';
		sCadenaINNER += '<tr>	<td align="left">';
		sCadenaINNER += '		<a href="#" class="TextoMenuINV" onclick="OnClickEliminarGW()" id="celda_titulo_eliminar_gateways">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ '+iObtener_Cadena_AJAX('general56')+' '+iObtener_Cadena_AJAX('general20')+'</a>';
		sCadenaINNER += '	</td></tr>';
		sCadenaINNER += '<tr>	<td align="center" id="celda_eliminar_gateways"></td></tr>';
		sCadenaINNER += '<tr>	<td align="left">';
		sCadenaINNER += '		<a href="#" class="TextoMenuINV" onclick="OnClickSituarGW()" id="celda_titulo_situar_gateways">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ '+iObtener_Cadena_AJAX('general17')+'</a>';
		sCadenaINNER += '	</td></tr>';
		sCadenaINNER += '<tr>	<td align="center" id="celda_config_situar_gateways"></td></tr>';
		sCadenaINNER += '<tr>	<td align="left">';
		sCadenaINNER += '		<a href="#" class="TextoMenuINV" onclick="OnClickActuaGW()" id="celda_titulo_actuar_gateways">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ '+iObtener_Cadena_AJAX('general15')+'</a>';
		sCadenaINNER += '	</td></tr>';
		sCadenaINNER += '<tr>	<td align="center" id="celda_config_actuar_gateways"></td></tr>';
		sCadenaINNER += '</table>';
	}
	else
	{
		document.getElementById('celda_titulo_gateways').innerHTML = "&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general11');
	}
	document.getElementById('celda_configura_gateways').innerHTML = sCadenaINNER;
	rellenar_div_principal(7,"&instalacion_id="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
}

function OnClickConfigUTC()
{
	var sCadenaINNER;
	document.getElementById('celda_configura_nodos').innerHTML = "";
	document.getElementById('celda_titulo_nodos').innerHTML = "&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general12');
	document.getElementById('celda_configura_gateways').innerHTML = "";
	document.getElementById('celda_titulo_gateways').innerHTML = "&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general11');
	document.getElementById('celda_configura_gateways_low').innerHTML = "";
	document.getElementById('celda_titulo_gateways_low').innerHTML = "&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general290');	
	sCadenaINNER = "";
	if (document.getElementById('celda_configura_utcs').innerHTML == "")
	{
		document.getElementById('celda_titulo_utcs').innerHTML = "&nbsp;&nbsp;- "+iObtener_Cadena_AJAX('general254');
		sCadenaINNER = '<table width=100%">';
		sCadenaINNER += '<tr>	<td align="left">';
		sCadenaINNER += '		<a href="#" class="TextoMenuINV" onclick="OnClickAnyadirUTC()" id="celda_titulo_anyadir_utcs">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- '+iObtener_Cadena_AJAX('general52')+'</a>';
		sCadenaINNER += '	</td></tr>';
		sCadenaINNER += '<tr>	<td align="center" id="celda_anyadir_utcs"></td></tr>';
		sCadenaINNER += '<tr>	<td align="left">';
		sCadenaINNER += '		<a href="#" class="TextoMenuINV" onclick="OnClickConfigGeneralUTC()" id="celda_titulo_general_utcs">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ '+iObtener_Cadena_AJAX('general14')+'</a>';
		sCadenaINNER += '	</td></tr>';
		sCadenaINNER += '<tr>	<td align="center" id="celda_config_general_utcs"></td></tr>';
		sCadenaINNER += '<tr>	<td align="left">';
		sCadenaINNER += '		<a href="#" class="TextoMenuINV" onclick="OnClickEliminarUTC()" id="celda_titulo_eliminar_utcs">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ '+iObtener_Cadena_AJAX('general56')+' '+iObtener_Cadena_AJAX('general254')+'</a>';
		sCadenaINNER += '	</td></tr>';
		sCadenaINNER += '<tr>	<td align="center" id="celda_eliminar_utcs"></td></tr>';
		sCadenaINNER += '<tr>	<td align="left">';
		sCadenaINNER += '		<a href="#" class="TextoMenuINV" onclick="OnClickSituarUTC()" id="celda_titulo_situar_utcs">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ '+iObtener_Cadena_AJAX('general17')+'</a>';
		sCadenaINNER += '	</td></tr>';
		sCadenaINNER += '<tr>	<td align="center" id="celda_config_situar_utcs"></td></tr>';
		sCadenaINNER += '</table>';
	}
	else
	{
		document.getElementById('celda_titulo_utcs').innerHTML = "&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general254');
	}
	document.getElementById('celda_configura_utcs').innerHTML = sCadenaINNER;
	rellenar_div_principal(7,"&instalacion_id="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
}

function OnClickConfigGWLow()
{
	var sCadenaINNER;
	document.getElementById('celda_configura_nodos').innerHTML = "";
	document.getElementById('celda_titulo_nodos').innerHTML = "&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general12');
	document.getElementById('celda_configura_utcs').innerHTML = "";
	document.getElementById('celda_titulo_utcs').innerHTML = "&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general254');	
	document.getElementById('celda_configura_gateways').innerHTML = "";
	document.getElementById('celda_titulo_gateways').innerHTML = "&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general11');
	document.getElementById('celda_configura_telemando').innerHTML = "";
	document.getElementById('celda_titulo_telemando').innerHTML = "&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general291');
	sCadenaINNER = "";
	if (document.getElementById('celda_configura_gateways_low').innerHTML == "")
	{
		document.getElementById('celda_titulo_gateways_low').innerHTML = "&nbsp;&nbsp;- "+iObtener_Cadena_AJAX('general290');
		sCadenaINNER = '<table width=100%">';
		sCadenaINNER += '<tr><td align="left">';
		sCadenaINNER += '<a href="#" class="TextoMenuINV" onclick="OnClickAnyadirGWLow()" id="celda_titulo_anyadir_gateways_low">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- '+iObtener_Cadena_AJAX('general52')+'</a>';
		sCadenaINNER += '</td></tr>';
		sCadenaINNER += '<tr><td align="center" id="celda_anyadir_gateways_low"></td></tr>';
		sCadenaINNER += '<tr><td align="left">';
		sCadenaINNER += '<a href="#" class="TextoMenuINV" onclick="OnClickConfigGeneralGWLow()" id="celda_titulo_general_gateways_low">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ '+iObtener_Cadena_AJAX('general14')+'</a>';
		sCadenaINNER += '</td></tr>';
		sCadenaINNER += '<tr><td align="center" id="celda_config_general_gateways_low"></td></tr>';
		sCadenaINNER += '<tr><td align="left">';
		sCadenaINNER += '<a href="#" class="TextoMenuINV" onclick="OnClickEliminarGWLow()" id="celda_titulo_eliminar_gateways_low">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ '+iObtener_Cadena_AJAX('general56')+' '+iObtener_Cadena_AJAX('general20')+'</a>';
		sCadenaINNER += '</td></tr>';
		sCadenaINNER += '<tr><td align="center" id="celda_eliminar_gateways_low"></td></tr>';
		sCadenaINNER += '<tr><td align="left">';
		sCadenaINNER += '<a href="#" class="TextoMenuINV" onclick="OnClickSituarGWLow()" id="celda_titulo_situar_gateways_low">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ '+iObtener_Cadena_AJAX('general17')+'</a>';
		sCadenaINNER += '</td></tr>';
		sCadenaINNER += '<tr><td align="center" id="celda_config_situar_gateways_low"></td></tr>';
		sCadenaINNER += '<tr><td align="left">';
		sCadenaINNER += '<a href="#" class="TextoMenuINV" onclick="OnClickActuaGWLow()" id="celda_titulo_actuar_gateways_low">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ '+iObtener_Cadena_AJAX('general15')+'</a>';
		sCadenaINNER += '</td></tr>';
		sCadenaINNER += '<tr><td align="center" id="celda_config_actuar_gateways_low"></td></tr>';
		sCadenaINNER += '</table>';
	}
	else
	{
		document.getElementById('celda_titulo_gateways_low').innerHTML = "&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general290');
	}
	document.getElementById('celda_configura_gateways_low').innerHTML = sCadenaINNER;
	rellenar_div_principal(7,"&instalacion_id="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
}

function OnClickConfigTelemando()
{
	var sCadenaINNER;
	document.getElementById('celda_configura_nodos').innerHTML = "";
	document.getElementById('celda_titulo_nodos').innerHTML = "&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general12');
	document.getElementById('celda_configura_utcs').innerHTML = "";
	document.getElementById('celda_titulo_utcs').innerHTML = "&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general254');	
	document.getElementById('celda_configura_gateways').innerHTML = "";
	document.getElementById('celda_titulo_gateways').innerHTML = "&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general11');
	document.getElementById('celda_configura_gateways_low').innerHTML = "";
	document.getElementById('celda_titulo_gateways_low').innerHTML = "&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general290');
	sCadenaINNER = "";
	if (document.getElementById('celda_configura_telemando').innerHTML == "")
	{
		document.getElementById('celda_titulo_telemando').innerHTML = "&nbsp;&nbsp;- "+iObtener_Cadena_AJAX('general291');
		sCadenaINNER = '<table width=100%">';
		sCadenaINNER += '<tr><td align="left">';
		sCadenaINNER += '<a href="#" class="TextoMenuINV" onclick="OnClickConfiguraTM()" id="celda_titulo_config_tm">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ '+iObtener_Cadena_AJAX('general14')+'</a>';
		sCadenaINNER += '</td></tr>';
		sCadenaINNER += '<tr><td align="center" id="celda_config_tm"></td></tr>';
		sCadenaINNER += '<tr><td align="left">';
		sCadenaINNER += '<a href="#" class="TextoMenuINV" onclick="OnClickActuaTM()" id="celda_titulo_actua_tm">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ '+iObtener_Cadena_AJAX('general15')+'</a>';
		sCadenaINNER += '</td></tr>';
		sCadenaINNER += '<tr><td align="center" id="celda_actua_tm"></td></tr>';
		sCadenaINNER += '</table>';
	}
	else
	{
		document.getElementById('celda_titulo_telemando').innerHTML = "&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general291');
	}
	document.getElementById('celda_configura_telemando').innerHTML = sCadenaINNER;
	rellenar_div_principal(99,"");
}

function OnClickConfiguraTM()
{
	document.getElementById('celda_titulo_actua_tm').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general15');
	document.getElementById('celda_actua_tm').innerHTML = "";
	if (document.getElementById('celda_config_tm').innerHTML == "")
	{
		document.getElementById('celda_titulo_config_tm').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- "+iObtener_Cadena_AJAX('general14');		
		document.getElementById('celda_config_tm').innerHTML = '<select id="comboGateways" onchange="OnConfiguracion(72, this.options[this.selectedIndex].id,this.options[this.selectedIndex].id,this.options[this.selectedIndex].id)" size="18" style="width:100%;height:50px;margin:0px 0 5px 0;"/>';
		cargar_gateways("comboGateways",document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
	}
	else
	{
		document.getElementById('celda_titulo_config_tm').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general14');
		document.getElementById('celda_config_tm').innerHTML = "";
	}
	rellenar_div_principal(99,"");
}

function OnClickActuaTM()
{
	document.getElementById('celda_titulo_config_tm').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general14');
	document.getElementById('celda_config_tm').innerHTML = "";
	if (document.getElementById('celda_actua_tm').innerHTML == "")
	{
		document.getElementById('celda_titulo_actua_tm').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- "+iObtener_Cadena_AJAX('general15');		
		document.getElementById('celda_actua_tm').innerHTML = '<select id="comboGateways" onchange="OnConfiguracion(73, this.options[this.selectedIndex].id,this.options[this.selectedIndex].id,this.options[this.selectedIndex].id)" size="18" style="width:100%;height:50px;margin:0px 0 5px 0;"/>';
		cargar_gateways("comboGateways",document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
	}
	else
	{
		document.getElementById('celda_titulo_actua_tm').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general15');
		document.getElementById('celda_actua_tm').innerHTML = "";
	}
	rellenar_div_principal(99,"");
}


function OnClickConfigGeneralNodos()
{
	document.getElementById('celda_titulo_situar_nodos').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general17');		
	document.getElementById('celda_config_situar_nodos').innerHTML = '';
	document.getElementById('celda_titulo_actuar_nodos').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general15');
	document.getElementById('celda_config_actuar_nodos').innerHTML = "";
	document.getElementById('celda_titulo_eliminar_nodos').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general56')+' '+iObtener_Cadena_AJAX('general21');
	document.getElementById('celda_eliminar_nodos').innerHTML = "";
	if (document.getElementById('celda_config_general_nodos').innerHTML == "")
	{
		document.getElementById('celda_titulo_general_nodos').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- "+iObtener_Cadena_AJAX('general14');		
		document.getElementById('celda_config_general_nodos').innerHTML = '<select id="comboNodos" onchange="OnConfiguracion(2, this.options[this.selectedIndex].value.substring(3),this.options[this.selectedIndex].id,this.options[this.selectedIndex].value.substring(0,3))" size="18" style="width:100%;height:50px;margin:0px 0 5px 0;"/>';
		cargar_nodos("comboNodos",document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
	}
	else
	{
		document.getElementById('celda_titulo_general_nodos').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general14');
		document.getElementById('celda_config_general_nodos').innerHTML = "";
	}
	rellenar_div_principal(7,"&instalacion_id="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
}

function OnClickEliminarNodos()
{
	document.getElementById('celda_titulo_situar_nodos').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general17');		
	document.getElementById('celda_config_situar_nodos').innerHTML = '';
	document.getElementById('celda_titulo_actuar_nodos').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general15');
	document.getElementById('celda_config_actuar_nodos').innerHTML = "";
	document.getElementById('celda_titulo_general_nodos').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general14');
	document.getElementById('celda_config_general_nodos').innerHTML = "";
	if (document.getElementById('celda_eliminar_nodos').innerHTML == "")
	{
		document.getElementById('celda_titulo_eliminar_nodos').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- "+iObtener_Cadena_AJAX('general56')+' '+iObtener_Cadena_AJAX('general21');		
		document.getElementById('celda_eliminar_nodos').innerHTML = '<select id="comboNodos" onchange="OnEliminarNodo(this.options[this.selectedIndex].value.substring(3),this.options[this.selectedIndex].id,this.options[this.selectedIndex].value.substring(0,3))" size="18" style="width:100%;height:50px;margin:0px 0 5px 0;"/>';
		cargar_nodos("comboNodos",document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
	}
	else
	{
		document.getElementById('celda_titulo_eliminar_nodos').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general56')+' '+iObtener_Cadena_AJAX('general21');
		document.getElementById('celda_eliminar_nodos').innerHTML = "";
		rellenar_div_principal(7,"&instalacion_id="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
	}
}

function OnClickSituarNodos()
{
	document.getElementById('celda_titulo_general_nodos').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general14');		
	document.getElementById('celda_config_general_nodos').innerHTML = '';
	document.getElementById('celda_titulo_actuar_nodos').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general15');
	document.getElementById('celda_config_actuar_nodos').innerHTML = "";
	document.getElementById('celda_titulo_eliminar_nodos').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general56')+' '+iObtener_Cadena_AJAX('general21');
	document.getElementById('celda_eliminar_nodos').innerHTML = "";
	if (document.getElementById('celda_config_situar_nodos').innerHTML == "")
	{
		document.getElementById('celda_titulo_situar_nodos').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- "+iObtener_Cadena_AJAX('general17');
		document.getElementById('celda_config_situar_nodos').innerHTML = '<select id="comboNodos" onchange="OnChangeNodo()" size="18" style="width:100%;height:50px;margin:0px 0 5px 0;"/>';
		cargar_nodos("comboNodos",document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
		rellenar_div_principal(12,"");
	}
	else
	{
		document.getElementById('celda_titulo_situar_nodos').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general17');
		document.getElementById('celda_config_situar_nodos').innerHTML = "";
		rellenar_div_principal(7,"&instalacion_id="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
	}
}

function OnClickActuarNodos()
{
	document.getElementById('celda_titulo_general_nodos').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general14');		
	document.getElementById('celda_config_general_nodos').innerHTML = '';
	document.getElementById('celda_titulo_situar_nodos').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general17');		
	document.getElementById('celda_config_situar_nodos').innerHTML = '';
	document.getElementById('celda_titulo_eliminar_nodos').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general56')+' '+iObtener_Cadena_AJAX('general21');
	document.getElementById('celda_eliminar_nodos').innerHTML = "";
	if (document.getElementById('celda_config_actuar_nodos').innerHTML == "")
	{
		document.getElementById('celda_titulo_actuar_nodos').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- "+iObtener_Cadena_AJAX('general15');
		document.getElementById('celda_config_actuar_nodos').innerHTML = '<select id="comboNodos" onchange="OnConfiguracion(5, this.options[this.selectedIndex].value.substring(3),this.options[this.selectedIndex].id,this.options[this.selectedIndex].value.substring(0,3))" size="18" style="width:100%;height:50px;margin:0px 0 5px 0;"/>';
		cargar_nodos("comboNodos",document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
	}
	else
	{
		document.getElementById('celda_titulo_actuar_nodos').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general15');
		document.getElementById('celda_config_actuar_nodos').innerHTML = "";
		rellenar_div_principal(7,"&instalacion_id="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
	}
}

function OnClickAnyadirGW()
{
	document.getElementById('celda_titulo_situar_gateways').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general17');		
	document.getElementById('celda_config_situar_gateways').innerHTML = '';
	document.getElementById('celda_titulo_actuar_gateways').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general15');
	document.getElementById('celda_config_actuar_gateways').innerHTML = "";
	document.getElementById('celda_titulo_general_gateways').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general14');
	document.getElementById('celda_config_general_gateways').innerHTML = "";
	document.getElementById('celda_titulo_eliminar_gateways').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general56')+' '+iObtener_Cadena_AJAX('general20');
	document.getElementById('celda_eliminar_gateways').innerHTML = "";
	rellenar_div_principal(19,"&instalacion_id="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
}

function OnClickConfigGeneralGW()
{
	document.getElementById('celda_titulo_situar_gateways').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general17');		
	document.getElementById('celda_config_situar_gateways').innerHTML = '';
	document.getElementById('celda_titulo_actuar_gateways').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general15');
	document.getElementById('celda_config_actuar_gateways').innerHTML = "";
	document.getElementById('celda_titulo_eliminar_gateways').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general56')+' '+iObtener_Cadena_AJAX('general20');
	document.getElementById('celda_eliminar_gateways').innerHTML = "";
	if (document.getElementById('celda_config_general_gateways').innerHTML == "")
	{
		document.getElementById('celda_titulo_general_gateways').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- "+iObtener_Cadena_AJAX('general14');
		document.getElementById('celda_config_general_gateways').innerHTML = '<select id="comboGateways" onchange="OnConfiguracion(3, this.options[this.selectedIndex].id,this.options[this.selectedIndex].id,this.options[this.selectedIndex].id)" size="18" style="width:100%;height:50px;margin:0px 0 5px 0;"/>';
		cargar_gateways("comboGateways",document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
	}
	else
	{
		document.getElementById('celda_titulo_general_gateways').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general14');
		document.getElementById('celda_config_general_gateways').innerHTML = "";
	}
	rellenar_div_principal(7,"&instalacion_id="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
}

function OnClickSituarGW()
{
	document.getElementById('celda_titulo_general_gateways').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general14');		
	document.getElementById('celda_config_general_gateways').innerHTML = '';
	document.getElementById('celda_titulo_actuar_gateways').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general15');
	document.getElementById('celda_config_actuar_gateways').innerHTML = "";
	document.getElementById('celda_titulo_eliminar_gateways').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general56')+' '+iObtener_Cadena_AJAX('general20');
	document.getElementById('celda_eliminar_gateways').innerHTML = "";
	if (document.getElementById('celda_config_situar_gateways').innerHTML == "")
	{
		document.getElementById('celda_titulo_situar_gateways').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- "+iObtener_Cadena_AJAX('general17');
		document.getElementById('celda_config_situar_gateways').innerHTML = '<select id="comboGateways" onchange="OnChangeGateway()" size="18" style="width:100%;height:50px;margin:0px 0 5px 0;"/>';
		cargar_gateways("comboGateways",document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
		rellenar_div_principal(11,"");
	}
	else
	{
		document.getElementById('celda_titulo_situar_gateways').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general17');
		document.getElementById('celda_config_situar_gateways').innerHTML = "";
		rellenar_div_principal(7,"&instalacion_id="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
	}
}

function OnClickEliminarGW()
{
	document.getElementById('celda_titulo_general_gateways').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general14');		
	document.getElementById('celda_config_general_gateways').innerHTML = '';
	document.getElementById('celda_titulo_actuar_gateways').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general15');
	document.getElementById('celda_config_actuar_gateways').innerHTML = "";
	document.getElementById('celda_titulo_situar_gateways').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general17');		
	document.getElementById('celda_config_situar_gateways').innerHTML = '';
	if (document.getElementById('celda_eliminar_gateways').innerHTML == "")
	{
		document.getElementById('celda_titulo_eliminar_gateways').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- "+iObtener_Cadena_AJAX('general56')+' '+iObtener_Cadena_AJAX('general20');
		document.getElementById('celda_eliminar_gateways').innerHTML = '<select id="comboGateways" onchange="OnEliminarGateway(this.options[this.selectedIndex].id,this.options[this.selectedIndex].id,this.options[this.selectedIndex].id)" size="18" style="width:100%;height:50px;margin:0px 0 5px 0;"/>';
		cargar_gateways("comboGateways",document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
	}
	else
	{
		document.getElementById('celda_titulo_eliminar_gateways').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general56')+' '+iObtener_Cadena_AJAX('general20');
		document.getElementById('celda_eliminar_gateways').innerHTML = "";
		rellenar_div_principal(7,"&instalacion_id="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
	}	
}

function OnClickActuaGW()
{
	document.getElementById('celda_titulo_situar_gateways').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general17');		
	document.getElementById('celda_config_situar_gateways').innerHTML = '';
	document.getElementById('celda_titulo_general_gateways').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general14');		
	document.getElementById('celda_config_general_gateways').innerHTML = '';
	document.getElementById('celda_titulo_eliminar_gateways').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general56')+' '+iObtener_Cadena_AJAX('general20');
	document.getElementById('celda_eliminar_gateways').innerHTML = "";
	if (document.getElementById('celda_config_actuar_gateways').innerHTML == "")
	{
		document.getElementById('celda_titulo_actuar_gateways').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- "+iObtener_Cadena_AJAX('general15');
		document.getElementById('celda_config_actuar_gateways').innerHTML = '<select id="comboGateways" onchange="OnConfiguracion(4, this.options[this.selectedIndex].id,this.options[this.selectedIndex].id,this.options[this.selectedIndex].id)" size="18" style="width:100%;height:50px;margin:0px 0 5px 0;"/>';
		cargar_gateways("comboGateways",document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
	}
	else
	{
		document.getElementById('celda_titulo_actuar_gateways').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general15');
		document.getElementById('celda_config_actuar_gateways').innerHTML = "";
	}
	rellenar_div_principal(7,"&instalacion_id="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
}

function OnClickAnyadirUTC()
{
	document.getElementById('celda_titulo_situar_utcs').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general17');		
	document.getElementById('celda_config_situar_utcs').innerHTML = '';
	document.getElementById('celda_titulo_general_utcs').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general14');
	document.getElementById('celda_config_general_utcs').innerHTML = "";
	document.getElementById('celda_titulo_eliminar_utcs').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general56')+' '+iObtener_Cadena_AJAX('general254');
	document.getElementById('celda_eliminar_utcs').innerHTML = "";
	rellenar_div_principal(24,"&instalacion_id="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
}

function OnClickConfigGeneralUTC()
{
	document.getElementById('celda_titulo_situar_utcs').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general17');		
	document.getElementById('celda_config_situar_utcs').innerHTML = '';
	document.getElementById('celda_titulo_eliminar_utcs').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general56')+' '+iObtener_Cadena_AJAX('general254');
	document.getElementById('celda_eliminar_utcs').innerHTML = "";
	if (document.getElementById('celda_config_general_utcs').innerHTML == "")
	{
		document.getElementById('celda_titulo_general_utcs').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- "+iObtener_Cadena_AJAX('general14');
		document.getElementById('celda_config_general_utcs').innerHTML = '<select id="comboUTCs" onchange="OnConfiguracion(11, this.options[this.selectedIndex].id,this.options[this.selectedIndex].value,this.options[this.selectedIndex].id)" size="18" style="width:100%;height:50px;margin:0px 0 5px 0;"/>';
		cargar_utcs("comboUTCs",document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
	}
	else
	{
		document.getElementById('celda_titulo_general_utcs').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general14');
		document.getElementById('celda_config_general_utcs').innerHTML = "";
	}
	rellenar_div_principal(7,"&instalacion_id="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
}

function OnClickEliminarUTC()
{
	document.getElementById('celda_titulo_general_utcs').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general14');		
	document.getElementById('celda_config_general_utcs').innerHTML = '';
	document.getElementById('celda_titulo_situar_utcs').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general17');		
	document.getElementById('celda_config_situar_utcs').innerHTML = '';
	if (document.getElementById('celda_eliminar_utcs').innerHTML == "")
	{
		document.getElementById('celda_titulo_eliminar_utcs').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- "+iObtener_Cadena_AJAX('general56')+' '+iObtener_Cadena_AJAX('general255');
		document.getElementById('celda_eliminar_utcs').innerHTML = '<select id="comboUTCs" onchange="OnEliminarUTC(this.options[this.selectedIndex].id,this.options[this.selectedIndex].value,this.options[this.selectedIndex].text)" size="18" style="width:100%;height:50px;margin:0px 0 5px 0;"/>';
		cargar_utcs("comboUTCs",document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
	}
	else
	{
		document.getElementById('celda_titulo_eliminar_utcs').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general56')+' '+iObtener_Cadena_AJAX('general255');
		document.getElementById('celda_eliminar_utcs').innerHTML = "";
		rellenar_div_principal(7,"&instalacion_id="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
	}	
}

function OnClickSituarUTC()
{
	document.getElementById('celda_titulo_general_utcs').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general14');		
	document.getElementById('celda_config_general_utcs').innerHTML = '';
	document.getElementById('celda_titulo_eliminar_utcs').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general56')+' '+iObtener_Cadena_AJAX('general20');
	document.getElementById('celda_eliminar_utcs').innerHTML = "";
	if (document.getElementById('celda_config_situar_utcs').innerHTML == "")
	{
		document.getElementById('celda_titulo_situar_utcs').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- "+iObtener_Cadena_AJAX('general17');
		document.getElementById('celda_config_situar_utcs').innerHTML = '<select id="comboUTCs" onchange="OnChangeUTC()" size="18" style="width:100%;height:50px;margin:0px 0 5px 0;"/>';
		cargar_utcs("comboUTCs",document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
		rellenar_div_principal(28,"");
	}
	else
	{
		document.getElementById('celda_titulo_situar_utcs').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general17');
		document.getElementById('celda_config_situar_utcs').innerHTML = "";
		rellenar_div_principal(7,"&instalacion_id="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
	}
}

function OnClickAnyadirGWLow()
{
	document.getElementById('celda_titulo_situar_gateways_low').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general17');		
	document.getElementById('celda_config_situar_gateways_low').innerHTML = '';
	document.getElementById('celda_titulo_actuar_gateways_low').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general15');
	document.getElementById('celda_config_actuar_gateways_low').innerHTML = "";
	document.getElementById('celda_titulo_general_gateways_low').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general14');
	document.getElementById('celda_config_general_gateways_low').innerHTML = "";
	document.getElementById('celda_titulo_eliminar_gateways_low').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general56')+' '+iObtener_Cadena_AJAX('general20');
	document.getElementById('celda_eliminar_gateways_low').innerHTML = "";
	rellenar_div_principal(30,"&instalacion_id="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
}

function OnClickConfigGeneralGWLow()
{
	document.getElementById('celda_titulo_situar_gateways_low').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general17');		
	document.getElementById('celda_config_situar_gateways_low').innerHTML = '';
	document.getElementById('celda_titulo_actuar_gateways_low').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general15');
	document.getElementById('celda_config_actuar_gateways_low').innerHTML = "";
	document.getElementById('celda_titulo_eliminar_gateways_low').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general56')+' '+iObtener_Cadena_AJAX('general20');
	document.getElementById('celda_eliminar_gateways_low').innerHTML = "";
	if (document.getElementById('celda_config_general_gateways_low').innerHTML == "")
	{
		document.getElementById('celda_titulo_general_gateways_low').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- "+iObtener_Cadena_AJAX('general14');
		document.getElementById('celda_config_general_gateways_low').innerHTML = '<select id="comboGateways" onchange="OnConfiguracion(6, this.options[this.selectedIndex].id,this.options[this.selectedIndex].id,this.options[this.selectedIndex].id)" size="18" style="width:100%;height:50px;margin:0px 0 5px 0;"/>';
		cargar_gateways_low("comboGateways",document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
	}
	else
	{
		document.getElementById('celda_titulo_general_gateways_low').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general14');
		document.getElementById('celda_config_general_gateways_low').innerHTML = "";
	}
	rellenar_div_principal(7,"&instalacion_id="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
}

function OnClickSituarGWLow()
{
	document.getElementById('celda_titulo_general_gateways_low').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general14');		
	document.getElementById('celda_config_general_gateways_low').innerHTML = '';
	document.getElementById('celda_titulo_actuar_gateways_low').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general15');
	document.getElementById('celda_config_actuar_gateways_low').innerHTML = "";
	document.getElementById('celda_titulo_eliminar_gateways_low').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general56')+' '+iObtener_Cadena_AJAX('general20');
	document.getElementById('celda_eliminar_gateways_low').innerHTML = "";
	if (document.getElementById('celda_config_situar_gateways_low').innerHTML == "")
	{
		document.getElementById('celda_titulo_situar_gateways_low').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- "+iObtener_Cadena_AJAX('general17');
		document.getElementById('celda_config_situar_gateways_low').innerHTML = '<select id="comboGateways" onchange="OnChangeGateway()" size="18" style="width:100%;height:50px;margin:0px 0 5px 0;"/>';
		cargar_gateways_low("comboGateways",document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
		rellenar_div_principal(32,"");
	}
	else
	{
		document.getElementById('celda_titulo_situar_gateways_low').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general17');
		document.getElementById('celda_config_situar_gateways_low').innerHTML = "";
		rellenar_div_principal(7,"&instalacion_id="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
	}
}

function OnClickEliminarGWLow()
{
	document.getElementById('celda_titulo_general_gateways_low').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general14');		
	document.getElementById('celda_config_general_gateways_low').innerHTML = '';
	document.getElementById('celda_titulo_actuar_gateways_low').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general15');
	document.getElementById('celda_config_actuar_gateways_low').innerHTML = "";
	document.getElementById('celda_titulo_situar_gateways_low').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general17');		
	document.getElementById('celda_config_situar_gateways_low').innerHTML = '';
	if (document.getElementById('celda_eliminar_gateways_low').innerHTML == "")
	{
		document.getElementById('celda_titulo_eliminar_gateways_low').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- "+iObtener_Cadena_AJAX('general56')+' '+iObtener_Cadena_AJAX('general20');
		document.getElementById('celda_eliminar_gateways_low').innerHTML = '<select id="comboGateways" onchange="OnEliminarGatewayLow(this.options[this.selectedIndex].id,this.options[this.selectedIndex].id,this.options[this.selectedIndex].id)" size="18" style="width:100%;height:50px;margin:0px 0 5px 0;"/>';
		cargar_gateways_low("comboGateways",document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
	}
	else
	{
		document.getElementById('celda_titulo_eliminar_gateways_low').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general56')+' '+iObtener_Cadena_AJAX('general20');
		document.getElementById('celda_eliminar_gateways_low').innerHTML = "";
		rellenar_div_principal(7,"&instalacion_id="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
	}	
}

function OnClickActuaGWLow()
{
	document.getElementById('celda_titulo_situar_gateways_low').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general17');		
	document.getElementById('celda_config_situar_gateways_low').innerHTML = '';
	document.getElementById('celda_titulo_general_gateways_low').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general14');		
	document.getElementById('celda_config_general_gateways_low').innerHTML = '';
	document.getElementById('celda_titulo_eliminar_gateways_low').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general56')+' '+iObtener_Cadena_AJAX('general20');
	document.getElementById('celda_eliminar_gateways_low').innerHTML = "";
	if (document.getElementById('celda_config_actuar_gateways_low').innerHTML == "")
	{
		document.getElementById('celda_titulo_actuar_gateways_low').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- "+iObtener_Cadena_AJAX('general15');
		document.getElementById('celda_config_actuar_gateways_low').innerHTML = '<select id="comboGateways" onchange="OnConfiguracion(7, this.options[this.selectedIndex].id,this.options[this.selectedIndex].id,this.options[this.selectedIndex].id)" size="18" style="width:100%;height:50px;margin:0px 0 5px 0;"/>';
		cargar_gateways_low("comboGateways",document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
	}
	else
	{
		document.getElementById('celda_titulo_actuar_gateways_low').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general15');
		document.getElementById('celda_config_actuar_gateways_low').innerHTML = "";
	}
	rellenar_div_principal(7,"&instalacion_id="+document.getElementById("comboInstalaciones").options[document.getElementById("comboInstalaciones").selectedIndex].value);
}

function OnClickSituarNuevosNodos()
{
	document.getElementById('celda_titulo_general_nodos').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general14');		
	document.getElementById('celda_config_general_nodos').innerHTML = '';
	document.getElementById('celda_titulo_situar_nodos').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general17');		
	document.getElementById('celda_config_situar_nodos').innerHTML = '';
	document.getElementById('celda_titulo_eliminar_nodos').innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ "+iObtener_Cadena_AJAX('general56')+' '+iObtener_Cadena_AJAX('general21');
	document.getElementById('celda_eliminar_nodos').innerHTML = "";
	rellenar_div_principal(13,"");
}

function cargar_nodos_value(sComboNodo,instalacion)
{
	var xmlHttpDispos;
	xmlHttpDispos= GetXmlHttpObject();
	var url = "carga_nodos.php?instalacion_id=" + instalacion + "&cliente_db=" + top.document.getElementById("db_cliente").value;
	
	xmlHttpDispos.open("GET",url,false);
	xmlHttpDispos.send(null);
	
	var doc=xmlHttpDispos.responseText;
	var xmlrespuesta = parsear_xml(doc);
	var vvx=xmlrespuesta.getElementsByTagName("nodo");
	document.getElementById(sComboNodo).length=0;
	for(i=0;i<vvx.length;i++)
	{
		if (xmlrespuesta.getElementsByTagName("nodo")[i].attributes[1].nodeValue.length == 0)
		{
			insertarOptionComboValue(sComboNodo,xmlrespuesta.getElementsByTagName("nodo")[i].attributes[2].nodeValue, 'N'+xmlrespuesta.getElementsByTagName("nodo")[i].attributes[3].nodeValue+xmlrespuesta.getElementsByTagName("nodo")[i].attributes[2].nodeValue+'00', '', iObtener_Cadena_AJAX('general21')+' '+xmlrespuesta.getElementsByTagName("nodo")[i].attributes[2].nodeValue);
		}
		else
		{
			insertarOptionComboValue(sComboNodo,xmlrespuesta.getElementsByTagName("nodo")[i].attributes[2].nodeValue, 'N'+xmlrespuesta.getElementsByTagName("nodo")[i].attributes[3].nodeValue+xmlrespuesta.getElementsByTagName("nodo")[i].attributes[2].nodeValue+'00', '', xmlrespuesta.getElementsByTagName("nodo")[i].attributes[1].nodeValue);
		}
	}
}

function cargar_nodos(sComboNodo,instalacion)
{
	var xmlHttpDispos;
	xmlHttpDispos= GetXmlHttpObject();
	var url = "carga_nodos.php?instalacion_id=" + instalacion + "&cliente_db=" + top.document.getElementById("db_cliente").value;
	
	xmlHttpDispos.open("GET",url,false);
	xmlHttpDispos.send(null);
	
	var doc=xmlHttpDispos.responseText;
	var xmlrespuesta = parsear_xml(doc);
	var vvx=xmlrespuesta.getElementsByTagName("nodo");
	document.getElementById(sComboNodo).length=0;
	for(i=0;i<vvx.length;i++)
	{
		if (xmlrespuesta.getElementsByTagName("nodo")[i].attributes[1].nodeValue.length == 0)
		{
			insertarOptionComboValue(sComboNodo,xmlrespuesta.getElementsByTagName("nodo")[i].attributes[2].nodeValue, xmlrespuesta.getElementsByTagName("nodo")[i].attributes[0].nodeValue, xmlrespuesta.getElementsByTagName("nodo")[i].attributes[3].nodeValue, iObtener_Cadena_AJAX('general21')+' '+xmlrespuesta.getElementsByTagName("nodo")[i].attributes[2].nodeValue);
		}
		else
		{
			insertarOptionComboValue(sComboNodo,xmlrespuesta.getElementsByTagName("nodo")[i].attributes[2].nodeValue, xmlrespuesta.getElementsByTagName("nodo")[i].attributes[0].nodeValue, xmlrespuesta.getElementsByTagName("nodo")[i].attributes[3].nodeValue, xmlrespuesta.getElementsByTagName("nodo")[i].attributes[1].nodeValue);
		}
	}
}

function cargar_all_gateways(sComboGateway,instalacion)
{
	var xmlHttpDispos;
	xmlHttpDispos= GetXmlHttpObject();
	var url = "cargar_all_gateways.php?instalacion_id=" + instalacion + "&cliente_db=" + top.document.getElementById("db_cliente").value;
	xmlHttpDispos.open("GET",url,false);
	xmlHttpDispos.send(null);
	
	var doc=xmlHttpDispos.responseText;
	var xmlrespuesta = parsear_xml(doc);
	var vvx=xmlrespuesta.getElementsByTagName("gateway");
	document.getElementById(sComboGateway).length=0;
	for(i=0;i<vvx.length;i++)
	{
		if (xmlrespuesta.getElementsByTagName("gateway")[i].attributes[1].nodeValue.length == 0)
		{
			insertarOptionCombo(sComboGateway,xmlrespuesta.getElementsByTagName("gateway")[i].attributes[0].nodeValue, iObtener_Cadena_AJAX('general20')+' '+xmlrespuesta.getElementsByTagName("gateway")[i].attributes[0].nodeValue);
		}
		else
		{
			insertarOptionCombo(sComboGateway,xmlrespuesta.getElementsByTagName("gateway")[i].attributes[0].nodeValue, xmlrespuesta.getElementsByTagName("gateway")[i].attributes[1].nodeValue);
		}
	}
}

function cargar_gateways_value(sComboGateway,instalacion)
{
	var xmlHttpDispos;
	xmlHttpDispos= GetXmlHttpObject();
	var url = "carga_gateways.php?instalacion_id=" + instalacion + "&cliente_db=" + top.document.getElementById("db_cliente").value;
	
	xmlHttpDispos.open("GET",url,false);
	xmlHttpDispos.send(null);
	
	var doc=xmlHttpDispos.responseText;
	var xmlrespuesta = parsear_xml(doc);
	var vvx=xmlrespuesta.getElementsByTagName("gateway");
	document.getElementById(sComboGateway).length=0;
	//alert(vvx.length);
	for(i=0;i<vvx.length;i++)
	{
		var gw_id = xmlrespuesta.getElementsByTagName("gateway")[i].attributes[0].nodeValue;
		if (xmlrespuesta.getElementsByTagName("gateway")[i].attributes[1].nodeValue.length == 0)
		{
			//insertarOptionCombo(sComboGateway,gw_id, iObtener_Cadena_AJAX('general20')+' '+gw_id);
			insertarOptionComboValue(sComboGateway, 'G'+gw_id.toString(), 'G', gw_id.toString(), iObtener_Cadena_AJAX('general20')+' '+gw_id);

		}
		else
		{
			//insertarOptionCombo(sComboGateway,gw_id, xmlrespuesta.getElementsByTagName("gateway")[i].attributes[1].nodeValue);
			insertarOptionComboValue(sComboGateway, 'G'+gw_id.toString(), 'G', gw_id.toString(), xmlrespuesta.getElementsByTagName("gateway")[i].attributes[1].nodeValue);
		}
	}
}

function cargar_gateways(sComboGateway,instalacion)
{
	var xmlHttpDispos;
	xmlHttpDispos= GetXmlHttpObject();
	var url = "carga_gateways.php?instalacion_id=" + instalacion + "&cliente_db=" + top.document.getElementById("db_cliente").value;
	
	xmlHttpDispos.open("GET",url,false);
	xmlHttpDispos.send(null);
	
	var doc=xmlHttpDispos.responseText;
	var xmlrespuesta = parsear_xml(doc);
	var vvx=xmlrespuesta.getElementsByTagName("gateway");
	document.getElementById(sComboGateway).length=0;
	//alert(vvx.length);
	for(i=0;i<vvx.length;i++)
	{
		var gw_id = xmlrespuesta.getElementsByTagName("gateway")[i].attributes[0].nodeValue;
		if (xmlrespuesta.getElementsByTagName("gateway")[i].attributes[1].nodeValue.length == 0)
		{
			insertarOptionCombo(sComboGateway,gw_id, iObtener_Cadena_AJAX('general20')+' '+gw_id);
		}
		else
		{
			insertarOptionCombo(sComboGateway,gw_id, xmlrespuesta.getElementsByTagName("gateway")[i].attributes[1].nodeValue);
		}
	}
}

function cargar_gateways_low(sComboGateway,instalacion)
{
	var xmlHttpDispos;
	xmlHttpDispos= GetXmlHttpObject();
	var url = "carga_gateways_low.php?instalacion_id=" + instalacion + "&cliente_db=" + top.document.getElementById("db_cliente").value;
	xmlHttpDispos.onreadystatechange=function()
	{
		if (xmlHttpDispos.readyState==4)
		{
			var doc=xmlHttpDispos.responseText;
			var xmlrespuesta = parsear_xml(doc);
			var vvx=xmlrespuesta.getElementsByTagName("gateway");
			document.getElementById(sComboGateway).length=0;
			for(i=0;i<vvx.length;i++)
			{
				if (xmlrespuesta.getElementsByTagName("gateway")[i].attributes[1].nodeValue.length == 0)
				{
					insertarOptionCombo(sComboGateway,xmlrespuesta.getElementsByTagName("gateway")[i].attributes[0].nodeValue, iObtener_Cadena_AJAX('general20')+' '+xmlrespuesta.getElementsByTagName("gateway")[i].attributes[0].nodeValue);
				}
				else
				{
					insertarOptionCombo(sComboGateway,xmlrespuesta.getElementsByTagName("gateway")[i].attributes[0].nodeValue, xmlrespuesta.getElementsByTagName("gateway")[i].attributes[1].nodeValue);
				}
			}
		}
	}
	xmlHttpDispos.open("GET",url,true);
	xmlHttpDispos.send(null);
}

function cargar_utcs(sComboUTC,instalacion)
{
	var xmlHttpUTC;
	xmlHttpUTC= GetXmlHttpObject();
	var url = "carga_utcs.php?instalacion_id=" + instalacion + "&cliente_db=" + top.document.getElementById("db_cliente").value;
	xmlHttpUTC.onreadystatechange=function()
	{
		if (xmlHttpUTC.readyState==4)
		{
			var docUTC=xmlHttpUTC.responseText;
			var xmlrespuestaUTC = parsear_xml(docUTC);
			var vvxUTC=xmlrespuestaUTC.getElementsByTagName("utc");
			document.getElementById(sComboUTC).length=0;
			for(i=0;i<vvxUTC.length;i++)
			{
				if (xmlrespuestaUTC.getElementsByTagName("utc")[i].attributes[1].nodeValue.length == 0)
				{
					//insertarOptionComboValue(sComboNodo,xmlrespuesta.getElementsByTagName("nodo")[i].attributes[2].nodeValue, xmlrespuesta.getElementsByTagName("nodo")[i].attributes[0].nodeValue, xmlrespuesta.getElementsByTagName("nodo")[i].attributes[3].nodeValue, iObtener_Cadena_AJAX('general21')+' '+xmlrespuesta.getElementsByTagName("nodo")[i].attributes[2].nodeValue);
					insertarOptionComboValue(sComboUTC,xmlrespuestaUTC.getElementsByTagName("utc")[i].attributes[0].nodeValue, xmlrespuestaUTC.getElementsByTagName("utc")[i].attributes[2].nodeValue,'',iObtener_Cadena_AJAX('general255')+' '+xmlrespuestaUTC.getElementsByTagName("utc")[i].attributes[2].nodeValue);
				}
				else
				{
					insertarOptionComboValue(sComboUTC,xmlrespuestaUTC.getElementsByTagName("utc")[i].attributes[0].nodeValue, xmlrespuestaUTC.getElementsByTagName("utc")[i].attributes[2].nodeValue,'',xmlrespuestaUTC.getElementsByTagName("utc")[i].attributes[1].nodeValue);
					//insertarOptionCombo(sComboUTC,xmlrespuestaUTC.getElementsByTagName("utc")[i].attributes[0].nodeValue, xmlrespuestaUTC.getElementsByTagName("utc")[i].attributes[1].nodeValue);
				}
			}
		}
	}
	xmlHttpUTC.open("GET",url,true);
	xmlHttpUTC.send(null);
}

function cargar_lista_dispositivos(sComboNombre,instalacion)
{
	var xmlHttpInst;
	var sNombreCombo;
	var iAnyadir;
	xmlHttpInst= GetXmlHttpObject();
	var url = "carga_dispositivos_instalacion.php?instalacion_id=" + instalacion + "&cliente_db=" + top.document.getElementById("db_cliente").value;
	
	xmlHttpInst.open("GET",url,false);
	xmlHttpInst.send(null);
	
	var doc=xmlHttpInst.responseText;
	var xmlrespuesta = parsear_xml(doc);
	x=xmlrespuesta.getElementsByTagName("gateway");
	document.getElementById(sComboNombre).length=0;
	for(i=0;i<x.length;i++)
	{
		if (xmlrespuesta.getElementsByTagName("gateway")[i].attributes[1].nodeValue.length == 0)
		{
			insertarOptionComboValue(sComboNombre,xmlrespuesta.getElementsByTagName("gateway")[i].attributes[0].nodeValue, 'G', xmlrespuesta.getElementsByTagName("gateway")[i].attributes[0].nodeValue + '000000000000'+'00', iObtener_Cadena_AJAX('general20')+' '+xmlrespuesta.getElementsByTagName("gateway")[i].attributes[0].nodeValue);
		}
		else
		{
			insertarOptionComboValue(sComboNombre,xmlrespuesta.getElementsByTagName("gateway")[i].attributes[0].nodeValue, 'G', xmlrespuesta.getElementsByTagName("gateway")[i].attributes[0].nodeValue + '000000000000'+'00', xmlrespuesta.getElementsByTagName("gateway")[i].attributes[1].nodeValue);
		}
	}
	
	x=xmlrespuesta.getElementsByTagName("nodo");
	for(i=0;i<x.length;i++)
	{
		if (xmlrespuesta.getElementsByTagName("nodo")[i].attributes[1].nodeValue.length == 0)
		{
			insertarOptionComboValue(sComboNombre,xmlrespuesta.getElementsByTagName("nodo")[i].attributes[2].nodeValue, 'N'+xmlrespuesta.getElementsByTagName("nodo")[i].attributes[3].nodeValue+xmlrespuesta.getElementsByTagName("nodo")[i].attributes[2].nodeValue+'00', '', iObtener_Cadena_AJAX('general21')+' '+xmlrespuesta.getElementsByTagName("nodo")[i].attributes[2].nodeValue);
		}
		else
		{
			insertarOptionComboValue(sComboNombre,xmlrespuesta.getElementsByTagName("nodo")[i].attributes[2].nodeValue, 'N'+xmlrespuesta.getElementsByTagName("nodo")[i].attributes[3].nodeValue+xmlrespuesta.getElementsByTagName("nodo")[i].attributes[2].nodeValue+'00', '', xmlrespuesta.getElementsByTagName("nodo")[i].attributes[1].nodeValue);
		}
	}
}

function cargar_plantillas(sComboPlantilla,instalacion,usuario)
{
	var xmlHttpPlantilla;
	xmlHttpPlantilla= GetXmlHttpObject();
	var url = "carga_informe_plantilla.php?instalacion_id=" + instalacion + "&cliente_db=" + top.document.getElementById("db_cliente").value+"&usuario_nombre="+usuario;
	xmlHttpPlantilla.onreadystatechange=function()
	{
		if (xmlHttpPlantilla.readyState==4)
		{
			var docPlantilla=xmlHttpPlantilla.responseText;
			var xmlrespuestaPlantilla = parsear_xml(docPlantilla);
			var vvxPlantilla=xmlrespuestaPlantilla.getElementsByTagName("plantilla");
			document.getElementById(sComboPlantilla).length=0;
			for(i=0;i<vvxPlantilla.length;i++)
			{
				insertarOptionComboValue(sComboPlantilla,xmlrespuestaPlantilla.getElementsByTagName("plantilla")[i].attributes[0].nodeValue, xmlrespuestaPlantilla.getElementsByTagName("plantilla")[i].attributes[1].nodeValue,'',xmlrespuestaPlantilla.getElementsByTagName("plantilla")[i].attributes[1].nodeValue);
				
			}
		}
	}
	xmlHttpPlantilla.open("GET",url,true);
	xmlHttpPlantilla.send(null);
}

function OnSubmenuAddInst()
{
	rellenar_div_principal(56,"");
	rellenar_div_submenu(99,"");
}

function OnClickConfigSMS()
{
	rellenar_div_principal(67,"");
}

function OnClickConfigEMAIL()
{
	rellenar_div_principal(68,"");
}