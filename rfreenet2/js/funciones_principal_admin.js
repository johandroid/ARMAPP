
function OnBotonUsuarios()
{		
	if (opcion_elegida != 50)
	{		
		rellenar_div_submenu(50,"");
		cargar_clientes(50);
		rellenar_div_principal(50,"");
		
		document.getElementById("boton_clientes").style.color="#333";
		document.getElementById("boton_usuarios").style.color="#990000";
		document.getElementById("boton_configuracion").style.color="#333";
		opcion_elegida = 50;
	}
	return;
}

function OnBotonClientes()
{		
	if (opcion_elegida != 52)
	{
		rellenar_div_submenu(52,"");
		cargar_clientes(52);
		rellenar_div_principal(52,"");
		
		document.getElementById("boton_clientes").style.color="#990000";
		document.getElementById("boton_usuarios").style.color="#333";
		document.getElementById("boton_configuracion").style.color="#333";
		opcion_elegida = 52;
	}
	return;
}
function OnBotonConfigAdmin()
{		
	if (opcion_elegida != 53)
	{
		rellenar_div_principal(53,"");
		rellenar_div_submenu(53,"");
		
		document.getElementById("boton_clientes").style.color="#333";
		document.getElementById("boton_usuarios").style.color="#333";
		document.getElementById("boton_configuracion").style.color="#990000";
		opcion_elegida = 53;

								
	
	}
	return;
}
