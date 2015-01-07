<?session_start(); //continuamos session o la creamos si no hay
	include "inc/funciones_indice.inc";
	include "inc/funciones_db.inc";
	require_once('FirePHPCore/FirePHP.class.php'); 
	
	//ob_start();
	//$mifirePHP = FirePHP::getInstance(true); 
		
	$nombre_actual=$_SESSION['usuario'];
	$perfil_actual=$_SESSION['perfil'];
	$id_usuario=$_SESSION['id_usuario'];
	
	$menu = $_GET["menu"];

	if ($_SESSION['autentificado_rf2'] == 1)
	{
		switch ($menu)
		{
			case 1:
				echo "mapa.html.php";
				break;
			case 2:
				if (($_GET['gw_id']) && ($_GET['nodo_mac']))
				{
					echo "datos.html.php?instalacion_id=".$_GET['instalacion_id']."&pagina=1&gw_id=".$_GET['gw_id']."&nodo_mac=".$_GET['nodo_mac'];
				}
				else if ($_GET['gw_id'])
				{
					echo "datos.html.php?instalacion_id=".$_GET['instalacion_id']."&pagina=1&gw_id=".$_GET['gw_id'];
				}
				else
				{
					echo "datos.html.php?instalacion_id=".$_GET['instalacion_id']."&pagina=1";
				}
				break;
			case 3:
				//echo "informes.html.php";
				break;
			case 4:
				if ($perfil_actual > 1)
				{
					echo "denied_access.html.php";
				}
				else
				{
					//Necesitamos saber el tipo de GW
					$gw_tipo = iObtenerTipoGW($_GET['gw_id'], $_GET['cliente_db']);
					//$mifirePHP -> log("TIPO ".$gw_tipo);				
					echo "configuracion_nodo.html.php?gw_id=".$_GET['gw_id']."&objeto_id=".$_GET['objeto_id']."&objeto_ip=".$_GET['objecto_ip']."&gw_tipo=".$gw_tipo;
				}
				break;
			case 5:
				if ($perfil_actual > 1)
				{
					echo "denied_access.html.php";
				}
				else
				{
					echo "configuracion_nodo_avanzada.html.php?gw_id=".$_GET['gw_id']."&objeto_id=".$_GET['objeto_id']."&objeto_ip=".$_GET['objecto_ip'];
				}
				break;
			case 6:
				if ($perfil_actual > 1)
				{
					echo "denied_access.html.php";
				}
				else
				{
					echo "configuracion_gw.html.php?objeto_id=".$_GET['objeto_id'];
				}
				break;
			case 7:
				echo "vista_general.html.php?objeto_id=".$_GET['instalacion_id'];
				break;
			case 8:
				echo "soporte.html.php";
				break;
			case 9:
				echo "ayuda.html.php";
				break;
			case 10:
				if ($perfil_actual > 1)
				{
					echo "denied_access.html.php";
				}
				else
				{
					echo "configuracion_general.html.php";
				}
				break;
			case 11:
				if ($perfil_actual > 1)
				{
					echo "denied_access.html.php";
				}
				else
				{
					if (iObtenerModoOffline() == 0)
					{
						echo "situar_gateways.html.php?objeto_id=".$_GET['instalacion_id'];
					}
					else
					{
						echo "modo_offline.html.php";
					}
				}
				break;
			case 12:
				if ($perfil_actual > 1)
				{
					echo "denied_access.html.php";
				}
				else
				{
					if (iObtenerModoOffline() == 0)
					{
						echo "situar_nodos.html.php?objeto_id=".$_GET['instalacion_id'];
					}
					else
					{
						echo "modo_offline.html.php";
					}
				}
				break;
			case 13:
				if ($perfil_actual > 1)
				{
					echo "denied_access.html.php";
				}
				else
				{
					if (iObtenerModoOffline() == 0)
					{
						echo "situar_nuevos_nodos.html.php?objeto_id=".$_GET['instalacion_id'];
					}
					else
					{
						echo "modo_offline.html.php";
					}					
				}
				break;
			case 14:
				if ($perfil_actual > 1)
				{
					echo "denied_access.html.php";
				}
				else
				{
					echo "usuarios.html.php";
				}
				break;
			case 15:
				echo "denied_access.html.php";
				break;
			case 16:
				echo "perfil.html.php?objeto_id=".$id_usuario;
				break;
			case 17:
				echo "actuacion_gw.html.php?objeto_id=".$_GET['objeto_id'];
				break;
			case 18:
				echo "actuacion_nodo.html.php?gw_id=".$_GET['gw_id']."&objeto_id=".$_GET['objeto_id']."&objeto_ip=".$_GET['objecto_ip'];
				break;
			case 19:
				if ($perfil_actual > 1)
				{
					echo "denied_access.html.php";
				}
				else
				{
					echo "anyadir_gw.html.php?instalacion_id=".$_GET['instalacion_id'];
				}
				break;
			case 20:
				if ($perfil_actual > 1)
				{
					echo "denied_access.html.php";
				}
				else
				{
					echo "situar_nuevo_gateway.html.php?objeto_id=".$_GET['instalacion_id']."&objeto_id=".$_GET['objeto_id'];
				}
				break;
			case 21:
				if ($perfil_actual > 1)
				{
					echo "denied_access.html.php";
				}
				else
				{
					echo "eliminar_nodo.html.php?gw_id=".$_GET['gw_id']."&objeto_id=".$_GET['objeto_id']."&objeto_ip=".$_GET['objecto_ip'];
				}
				break;
			case 22:
				if ($perfil_actual > 1)
				{
					echo "denied_access.html.php";
				}
				else
				{
					echo "eliminar_gateway.html.php?&objeto_id=".$_GET['objeto_id'];
				}
				break;
			case 23:
				echo "empty_client.html.php";
				break;
			case 24:
				if ($perfil_actual > 1)
				{
					echo "denied_access.html.php";
				}
				else
				{
					echo "anyadir_utc.html.php?instalacion_id=".$_GET['instalacion_id'];
				}
				break;
			case 25:
				if ($perfil_actual > 1)
				{
					echo "denied_access.html.php";
				}
				else
				{
					echo "situar_nuevo_utc.html.php?objeto_id=".$_GET['instalacion_id']."&objeto_id=".$_GET['objeto_id']."&objeto_ip=".$_GET['objeto_ip'];
				}
				break;
			case 26:
				if ($perfil_actual > 1)
				{
					echo "denied_access.html.php";
				}
				else
				{
					echo "configuracion_utc.html.php?objeto_id=".$_GET['objeto_id']."&objeto_ip=".$_GET['objeto_ip'];
				}
				break;
			case 27:
				if ($perfil_actual > 1)
				{
					echo "denied_access.html.php";
				}
				else
				{
					echo "eliminar_utc.html.php?&objeto_id=".$_GET['objeto_id']."&objeto_ip=".$_GET['objeto_ip']."&objeto_texto=".$_GET['objeto_texto'];
				}
				break;
			case 28:
				if ($perfil_actual > 1)
				{
					echo "denied_access.html.php";
				}
				else
				{
					if (iObtenerModoOffline() == 0)
					{
						echo "situar_utcs.html.php?objeto_id=".$_GET['instalacion_id'];
					}
					else
					{
						echo "modo_offline.html.php";
					}
				}
				break;
			case 29:
				echo "vista_general_medidas.html.php?objeto_id=".$_GET['instalacion_id'];
				break;
			case 30:
				if ($perfil_actual > 1)
				{
					echo "denied_access.html.php";
				}
				else
				{
					echo "anyadir_gw_low.html.php?instalacion_id=".$_GET['instalacion_id'];
				}
				break;	
			case 31:
				if ($perfil_actual > 1)
				{
					echo "denied_access.html.php";
				}
				else
				{
					echo "configuracion_gw_low.html.php?objeto_id=".$_GET['objeto_id'];
				}
				break;
			case 32:
				if ($perfil_actual > 1)
				{
					echo "denied_access.html.php";
				}
				else
				{
					if (iObtenerModoOffline() == 0)
					{
						echo "situar_gateways_low.html.php?objeto_id=".$_GET['instalacion_id'];
					}
					else
					{
						echo "modo_offline.html.php";
					}
				}
				break;
			case 33:
				if ($perfil_actual > 1)
				{
					echo "denied_access.html.php";
				}
				else
				{
					echo "actuacion_gw_low.html.php?objeto_id=".$_GET['objeto_id'];
				}			
				
				break;
			case 34:
				if ($perfil_actual > 1)
				{
					echo "denied_access.html.php";
				}
				else
				{
					echo "eliminar_gateway_lowt.php?&objeto_id=".$_GET['objeto_id'];
				}
				break;
			case 35:
				if ($perfil_actual > 1)
				{
					echo "denied_access.html.php";
				}
				else
				{
					echo "anyadir_gw_lowT.php?instalacion_id=".$_GET['instalacion_id'];
				}
				break;	
			case 36:
				if ($perfil_actual > 1)
				{
					echo "denied_access.html.php";
				}
				else
				{
					echo "configuracion_gw_lowt.php?objeto_id=".$_GET['objeto_id'];
				}
				break;
			case 37:
				if ($perfil_actual > 1)
				{
					echo "denied_access.html.php";
				}
				else
				{
					if (iObtenerModoOffline() == 0)
					{
						echo "situar_gateways_low.html.php?objeto_id=".$_GET['instalacion_id'];
					}
					else
					{
						echo "modo_offline.html.php";
					}
				}
				break;
			case 38:
				if ($perfil_actual > 1)
				{
					echo "denied_access.html.php";
				}
				else
				{
					echo "actuacion_gw_low.html.php?objeto_id=".$_GET['objeto_id'];
				}			
				
				break;
			case 39:
				if ($perfil_actual > 1)
				{
					echo "denied_access.html.php";
				}
				else
				{
					echo "eliminar_gateway_low.php?&objeto_id=".$_GET['objeto_id'];
				}
				break;
			case 40:
				if ($perfil_actual > 1)
				{
					echo "denied_access.html.php";
				}
				else
				{
					if (iObtenerModoOffline() == 0)
					{
						echo "situar_gateways_lowt.php?objeto_id=".$_GET['instalacion_id'];
					}
					else
					{
						echo "modo_offline.html.php";
					}
				}
				break;	
			case 41:
				if ($perfil_actual > 1)
				{
					echo "denied_access.html.php";
				}
				else
				{
					echo "actuacion_gw_lowt.php?objeto_id=".$_GET['objeto_id'];
				}						
				
				break;
			case 50:
				if ($perfil_actual > 0)
				{
					echo "denied_access.html.php";
				}
				else
				{
					echo "admin_usuarios.html.php?cliente_id=".$_GET['cliente_id'];
				}
				break;
			case 51:
				if ($perfil_actual > 1)
				{
					echo "denied_access.html.php";
				}
				else
				{
					echo "instalaciones.html.php?cliente_id=".$_GET['cliente_id'];
				}
				break;
			case 52:
				if ($perfil_actual > 1)
				{
					echo "denied_access.html.php";
				}
				else
				{
					echo "admin_clientes.html.php";
				}
				break;
			case 53:
				if ($perfil_actual > 0)
				{
					echo "denied_access.html.php";
				}
				else
				{
					echo "admin_configuracion.html.php";
				}
				break;
			case 54:
				if ($perfil_actual > 0)
				{
					echo "denied_access.html.php";
				}
				else
				{
					echo "admin_anyadir_usuario.html.php";
				}
				break;
			case 55:
				if ($perfil_actual > 0)
				{
					echo "denied_access.html.php";
				}
				else
				{
					echo "admin_mod_usuario.html.php?usuario_id=".$_GET['usuario_id']."&usuario_nombre=".$_GET['usuario_nombre']."&usuario_perfil=".$_GET['usuario_perfil']."&usuario_email=".$_GET['usuario_email']."&cliente_id=".$_GET['cliente_id'];
				}
				break;
			case 56:
				if ($perfil_actual > 1)
				{
					echo "denied_access.html.php";
				}
				else
				{
					echo "anyadir_instalacion.html.php";
				}
				break;
			case 57:
				if ($perfil_actual > 1)
				{
					echo "denied_access.html.php";
				}
				else
				{
					echo "configuracion_instalacion.html.php?instalacion_id=".$_GET['instalacion_id']."&instalacion_nombre=".$_GET['instalacion_nombre']."&instalacion_zona_horaria=".$_GET['instalacion_zona_horaria']."&cliente_db=".$_GET['cliente_db'];
				}
				break;
			case 58:
				if ($perfil_actual > 1)
				{
					echo "denied_access.html.php";
				}
				else
				{
					echo "instalacion_reasignar.html.php?instalacion_id=".$_GET['instalacion_id']."&instalacion_nombre=".$_GET['instalacion_nombre']."&cliente_db=".$_GET['cliente_db']."&cliente_id=".$_GET['cliente_id'];
				}
				break;
			case 59:
				if ($perfil_actual > 0)
				{
					echo "denied_access.html.php";
				}
				else
				{
					echo "admin_anyadir_cliente.html.php";
				}
				break;
			case 60:
				if ($perfil_actual > 0)
				{
					echo "denied_access.html.php";
				}
				else
				{
					echo "admin_mod_cliente.html.php?cliente_id=".$_GET['cliente_id'];
				}
				break;
			case 61:
				if ($perfil_actual > 0)
				{
					echo "denied_access.html.php";
				}
				else
				{
					if (iObtenerModoOffline() == 0)
					{
						echo "admin_configura_sms.html.php";
					}
					else
					{
						echo "modo_offline.html.php";
					}					
				}
				break;
			case 62:
				if ($perfil_actual > 0)
				{
					echo "denied_access.html.php";
				}
				else
				{
					if (iObtenerModoOffline() == 0)
					{
						echo "admin_configura_email.html.php";
					}
					else
					{
						echo "modo_offline.html.php";
					}					
				}
				break;
			case 63:
				if ($perfil_actual > 0)
				{
					echo "denied_access.html.php";
				}
				else
				{
					if (iObtenerModoOffline() == 0)
					{
						echo "admin_configura_eventos.html.php";
					}
					else
					{
						echo "modo_offline.html.php";
					}					
				}
				break;
			case 64:
				if ($perfil_actual > 0)
				{
					echo "denied_access.html.php";
				}
				else
				{
					echo "admin_anyade_evento_blacklist.html.php";
				}
				break;
			case 65:
				if ($perfil_actual > 0)
				{
					echo "denied_access.html.php";
				}
				else
				{
					if (iObtenerModoOffline() == 0)
					{
						echo "admin_control_consumo.html.php";
					}
					else
					{
						echo "modo_offline.html.php";
					}
				}
				break;
			case 66:
				if ($perfil_actual > 2)
				{
					echo "denied_access.html.php";
				}
				else
				{
					if (iObtenerModoOffline() == 0)
					{
						echo "configuracion_notificaciones.html.php";
					}
					else
					{
						echo "modo_offline.html.php";
					}					
				}
				break;
			case 67:
				if ($perfil_actual > 2)
				{
					echo "denied_access.html.php";
				}
				else
				{
					if (iObtenerModoOffline() == 0)
					{
						echo "configuracion_sms.html.php";
					}
					else
					{
						echo "modo_offline.html.php";
					}					
				}
				break;
			case 68:
				if ($perfil_actual > 2)
				{
					echo "denied_access.html.php";
				}
				else
				{
					if (iObtenerModoOffline() == 0)
					{
						echo "configuracion_email.html.php";
					}
					else
					{
						echo "modo_offline.html.php";
					}	
				}
				break;
				
			case 69:
				if ($perfil_actual > 2)
				{
					echo "denied_access.html.php";
				}
				else
				{
					if (iObtenerModoOffline() == 0)
					{
						echo "notificaciones.html.php";
					}
					else
					{
						echo "modo_offline.html.php";
					}
				}
				break;
			case 70:
				if ($perfil_actual > 1)
				{
					echo "denied_access.html.php";
				}
				else
				{
					echo "cola_envios.html.php?instalacion_id=".$_GET['instalacion_id']."&pagina=1";
				}	
				break;				
			case 71:
				if ($perfil_actual > 2)
				{
					echo "denied_access.html.php";
				}
				else
				{
					echo "diario.php";
				}
				break;
				
			// Config telemando
			case 72:
				if ($perfil_actual > 2)
				{
					echo "denied_access.html.php";
				}
				else
				{
					echo "configuracion_telemando.html.php?instalacion_id=".$_GET['instalacion_id']."&objeto_id=".$_GET['objeto_id'];
				}
				break;
				
			// Actuacion telemando
			case 73:
				if ($perfil_actual > 2)
				{
					echo "denied_access.html.php";
				}
				else
				{
					echo "actuacion_telemando.html.php?instalacion_id=".$_GET['instalacion_id']."&objeto_id=".$_GET['objeto_id'];
				}
				break;
						
			case 80:
				echo "modo_offline.html.php";
				break;
				
			case 81:
				echo "informes_csv.html.php";
				break;
				
			case 82:
				echo "informes_grafica.html.php";
				break;
				
			case 83:
				echo "procesado.html.php?instalacion_id=".$_GET['instalacion_id']."&pagina=1";
				break;
				
			case 84:
				if ($perfil_actual > 1)
				{
					echo "denied_access.html.php";
				}
				else
				{
					echo "configuracion_procesado.html.php?instalacion_id=".$_GET['instalacion_id'];
				}
				break;
			case 85:
				if ($perfil_actual > 1)
				{
					echo "denied_access.html.php";
				}
				else
				{
					if (($_GET['id_cliente'] != ""))
					{
						echo "configuracion_cliente_logo.php?id_cliente=".$_GET['id_cliente'];
					}
				}
				break;		
			case 86:
				if ($perfil_actual > 0)
				{
					echo "denied_access.html.php";
				}
				else
				{
					if (($_GET['id_cliente'] != ""))
					{
						echo "configuracion_cliente_logo.php?id_cliente=".$_GET['id_cliente'];
					}
				}
				break;	
			case 87:
				if ($perfil_actual > 1)
				{
					echo "denied_access.html.php";
				}
				else
				{
					echo "config_evaporacion.php?instalacion_id=".$_GET['instalacion_id'];
				}
				break;					
			case 88:
				echo "evaporacion.html.php?instalacion_id=".$_GET['instalacion_id']."&pagina=1";
				break;
			case 89:
				if ($perfil_actual > 2)
				{
					echo "denied_access.html.php";
				}
				else
				{
					if (iObtenerModoOffline() == 0)
					{
						echo "alarmas.html.php?pagina=1";
					}
					else
					{
						echo "modo_offline.html.php";
					}
				}
				break;
			case 90:
				if ($perfil_actual > 2)
				{
					echo "denied_access.html.php";
				}
				else
				{
					if (iObtenerModoOffline() == 0)
					{
						echo "alarmas_historico.html.php?pagina=1";
					}
					else
					{
						echo "modo_offline.html.php";
					}
				}
				break;
																
			case 99:
				echo "";
			default:
				break;
		}
	}
	else
	{
		echo "sesion_caducada.html.php";
	}
?>