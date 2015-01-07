<?php session_start();
header('Content-type: text/html; charset=utf-8');
include 'inc/idiomas.inc';
include 'inc/funciones_indice.inc';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<title>RFreeNET Data</title>
	<link rel="stylesheet" href="css/plantilla_css.css" type="text/css"/>
	<link rel="STYLESHEET" type="text/css" href="codebase/dhtmlxtabbar.css"/>
	<script type="text/javascript" src="js/funciones_ajax.js?time=<?php echo(filemtime("js/funciones_ajax.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_aux.js?time=<?php echo(filemtime("js/funciones_aux.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_check.js?time=<?php echo(filemtime("js/funciones_check.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_datos.js?time=<?php echo(filemtime("js/funciones_datos.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_principal.js?time=<?php echo(filemtime("js/funciones_principal.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_informes.js?time=<?php echo(filemtime("js/funciones_informes.js"));?>"></script>
	<script type="text/javascript" src="js/funciones_graficas.js?time=<?php echo(filemtime("js/funciones_graficas.js"));?>"></script>		
	<script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
	<script type="text/javascript" src="js/jquery.dualListBox-1.3.min_kta.js"></script>
	<script type="text/javascript" src="js/dlbScriptCrossBrowser.js"></script>
	<script src="codebase/dhtmlxcommon.js"></script>
	<script src="codebase/dhtmlxtabbar.js"></script>
	<script src="js/highcharts.src.js"></script>
	<script src="js/exporting.js"></script>
	<link rel="stylesheet" type="text/css" href="css/highslide.css" />
	
	<script type="text/javascript">
		var tabbar;
		var timeoutReturn = new Array();
		var chartDetail = new Array();
		var chartZoom = new Array();
		var detailData = new Array();
		function xObtener_Datos_Graficas(iNumGrafica)
		{
			var	xmlHttpDB;
			var sDatosXMLOut;			
			var url="carga_informe_grafica.php";

			clearTimeout(timeoutReturn[iNumGrafica]);
			
			sDatosXMLOut=xGenerar_Datos_Graficas(iNumGrafica);
			xmlHttpDB= GetXmlHttpObject();
			xmlHttpDB.open("POST",url,true);
			xmlHttpDB.onreadystatechange=function()
			{
				if (xmlHttpDB.readyState==4)
				{
					var data = eval("("+xmlHttpDB.responseText+")");
					var plotarea = $("#caja_grafica"+iNumGrafica);
					var saMagnitudes=new Array();
					var saUnidades=new Array();
					saMagnitudes=iBuscar_Nombres_Magnitudes(iNumGrafica);
					//alert(saMagnitudes.length)
				   for (i=0;i<saMagnitudes.length;i++)
				   {
				   		indice = saMagnitudes[i].lastIndexOf("(");
				   		indicefin = saMagnitudes[i].lastIndexOf(")");
				   		//alert(saMagnitudes[i]);
				   			//alert(indice);
				   		saUnidades[i]="";
				   		if((indice > 0) && (indice < saMagnitudes[i].length) && (indicefin > 0) && (indicefin < saMagnitudes[i].length) && indice < indicefin)
				   		{
				   			saUnidades[i]=saMagnitudes[i].substring(indice+1,indicefin);
				   			//alert(saUnidades[i]);
				   		}
				   		//console.log(saUnidades[i]);
				   }
				   //chartZoom[iNumGrafica].destroy();
				   chartZoom[iNumGrafica] = new Highcharts.Chart({
		                chart: {
		                    renderTo: 'caja_zoom_grafica'+iNumGrafica,
		                    reflow: false,
		                    borderWidth: 0,
		                    backgroundColor: null,
		                    marginLeft: 50,
		                    marginRight: 20,
		                    zoomType: 'x',
		                    events: {
		                        // listen to the selection event on the master chart to update the
		                        // extremes of the detail chart
		                        selection: function(event) {
		                            var extremesObject = event.xAxis[0],
		                                min = extremesObject.min,
		                                max = extremesObject.max,
		                                xAxis = this.xAxis[0];
		                            //alert("El valor minimo es "+min+ " y el maximo es "+max);
		                            var timeChart = max-min;
		                            actualiza_Columna(iNumGrafica,timeChart);
		                           	chartDetail[iNumGrafica].xAxis[0].setExtremes(min,max);
		                           	                            
		                               
		                            xAxis.removePlotBand('mask-before');
		                            xAxis.removePlotBand('mask-after');
		                            extremesX = xAxis.getExtremes();
		                            minimoX = extremesX.min;
		                            maximoX = extremesX.max;
		                            xAxis.addPlotBand({
		                                id: 'mask-before',
		                                from: minimoX,
		                                to: min,
		                                color: 'rgba(0, 0, 0, 0.2)'
		                            });
		                            xAxis.addPlotBand({
		                                id: 'mask-after',
		                                from: max,
		                                to: maximoX,
		                                color: 'rgba(0, 0, 0, 0.2)'
		                            });
		                            return false;
		                        }
		                    }
		                },
		                title: {
		                    text: null
		                },
		                xAxis: {
		                    type: 'datetime',
		                    showLastTickLabel: true,
		                    maxZoom: 60000, // one minut
		                    title: {
		                        text: null
		                    },
		                    dateTimeLabelFormats: {
				                second: '%d-%m %H:%M:%S',
								minute: '%d-%m %H:%M',
								hour: '%d-%m %H:%M',
								day: '%d-%m-%y',
								week: '%d-%m-%Y',
								month: '%m-%Y',
				            }
		                },
		                yAxis: [{
		                    gridLineWidth: 0,
		                    labels: {
		                        enabled: false
		                    },
		                    title: {
		                        text: null
		                    },
		                    showFirstLabel: false
		                },{
		                    gridLineWidth: 0,
		                    labels: {
		                        enabled: false
		                    },
		                    title: {
		                        text: null
		                    },
		                    showFirstLabel: false,
		                    opposite: true
		                }],
		                tooltip: {
		                    formatter: function() {
		                        return false;
		                    }
		                },
		                legend: {
		                    enabled: false
		                },
		                credits: {
		                    enabled: false
		                },
		                plotOptions: {
		                    series: {
		                        fillColor: {
		                            linearGradient: [0, 0, 0, 70],
		                            stops: [
		                                [0, '#4572A7'],
		                                [1, 'rgba(0,0,0,0)']
		                            ]
		                        },
		                        lineWidth: 1,
		                        marker: {
		                            enabled: false
		                        },
		                        shadow: false,
		                        states: {
		                            hover: {
		                                lineWidth: 1
		                            }
		                        },
		                        enableMouseTracking: false
		                    }
		                },
		                series: data,
				exporting: {
                    enabled: false
                }
            });
				   
				   	//chartDetail[iNumGrafica].destroy();
					chartDetail[iNumGrafica] = new Highcharts.Chart({
						chart: {
							renderTo: 'caja_grafica'+iNumGrafica,
							reflow: false
						},
						title: {
							text: document.getElementById("titulo_g"+iNumGrafica).value
						},
						xAxis: {
							type: 'datetime',
		                    dateTimeLabelFormats: {
				                second: '%d-%m %H:%M:%S',
								minute: '%d-%m %H:%M',
								hour: '%d-%m %H:%M',
								day: '%d-%m-%y',
								week: '%d-%m-%Y',
								month: '%m-%Y',
				            },
				            //maxPadding: 0.05,
				            tickInterval: null,
				            tickPixelInterval: 150,
				           	/*minDateTickInterval: 12*3600*1000,*/
				            /*endOnTick: true,
				            startOnTick: true,*/
						},
						yAxis: [{ // Primary yAxis
							labels: {
								style: {
									color: '#606060'
								}
							},
							title: {
								text: saMagnitudes[0],
								style: {
									color: '#606060'
								}
							},
							opposite: false
					
						}, { // Secondary yAxis
							title: {
								text: saMagnitudes[1],
								style: {
									color: '#606060'
								}
							},
							labels: {
								style: {
									color: '#606060'
								}
							},
							opposite: true
						}],
						tooltip: {
							formatter: function() {
								return '<b>'+ this.series.name +'</b><br/>'+ Highcharts.dateFormat('%d-%m-%y %H:%M:%S', this.x) +'-> '+ this.y +''+saUnidades[this.series.yAxis.opposite?1:0];
								//return ''+
									//this.x +': '+ this.y +' '+ unit;
							}
						},
						legend: {
							layout: 'vertical',
							align: 'left',
							verticalAlign: 'top',
							floating: true,
							y: 15,
							backgroundColor: '#FFFFFF'
						},
						plotOptions: {
							spline: {
								lineWidth: 3,
								states: {
									hover: {
										lineWidth: 4
									}
								},
								marker: {
									enabled: false,
									states: {
										hover: {
											enabled: true,
											symbol: 'circle',
											radius: 5,
											lineWidth: 1
										}
									}
								}
							},
							column: {
								marker: {
									enabled: false,
									states: {
										hover: {
											enabled: true,
											symbol: 'circle'
										}
									}
								},
								groupPadding: 0,
							}
						},
						series: data,
						exporting: {
					        enabled: true
					   },
					 	credits: {
					 		enabled: false
					 	}
					});
					actualiza_Columna(iNumGrafica,-1);
					var numGraphs = chartDetail[iNumGrafica].series.length;
				   for(i=0;i<numGraphs;i++)
				    {
					    //var tipoGraph = chartDetail[iNumGrafica].series[i].type;*/
						//console.log(data[i]);
						
						chartZoom[iNumGrafica].series[i].setData(data[i].data);
						chartDetail[iNumGrafica].series[i].setData(data[i].data);
					}
				    document.getElementById('div_espera').style.display="none";
				    document.getElementById('caja_instrucciones').style.display="";
				    
				}
			}
			xmlHttpDB.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
			
			xmlHttpDB.send(sDatosXMLOut);
			
			if(top.document.getElementById('Filtro_combo_Informe').selectedIndex==1)
			{
				var timeout = top.document.getElementById('tiempoIntervalo').value;
				var unidad = top.document.getElementById('selectIntervalo').options[top.document.getElementById('selectIntervalo').selectedIndex].id;
				switch (unidad)
				{
					case '0':
						timeout = timeout*60000;
						break;
					case '1':
						timeout = timeout*60*60000;
						break;
					case '2':
						timeout = timeout*24*60*60000;
						break;
				}
				timeoutReturn[iNumGrafica] = setTimeout("xActualizar_Datos_Graficas("+iNumGrafica+")",timeout);
				
			}
			return;
		}
		
		function actualiza_Columna(iNumGrafica,timeChart)
		{
			var numGraphs = chartDetail[iNumGrafica].series.length;
		                            
            chartDetail[iNumGrafica].xAxis[0].tickInterval = 0;
            chartDetail[iNumGrafica].xAxis[0].tickPixelInterval = 100;
            var graficoDiario=0,graficoHorario=0,graficoLineal=0;
            if(timeChart<0)
            {
            	var min = chartDetail[iNumGrafica].xAxis[0].getExtremes().min;
            	var max = chartDetail[iNumGrafica].xAxis[0].getExtremes().max;
            	timeChart  = max-min;
            }
            for(i=0;i<numGraphs;i++)
            {
            	var tipoGraph = chartDetail[iNumGrafica].series[i].type;
            	if(tipoGraph == "column")
            	{
            		var zIndex = chartDetail[iNumGrafica].series[i].options.zIndex;
            		//MPT acumulado diario
            		if(zIndex == 1)
            		{
            			graficoDiario =1;
            		}
            		else
            		{
            			graficoHorario = 1;
            		}
            	}
            	else
            	{
            		graficoLineal = 1;
            	}
            }
            for(i=0;i<numGraphs;i++)
            {
            	var tipoGraph = chartDetail[iNumGrafica].series[i].type;
            	var ancho = 600;
            	if(tipoGraph == "column")
            	{

            		var zIndex = chartDetail[iNumGrafica].series[i].options.zIndex;
            		//MPT acumulado diario
            		if(zIndex == 1 && (graficoHorario==1 || graficoLineal==1))
            		{
            			var dias = Math.ceil(timeChart / (24*3600000));
            			var anchoColumna = Math.min(0.3*ancho/(dias),100);
            			//console.log(chartDetail[iNumGrafica]);
            			if(chartDetail[iNumGrafica].series[i].data.length>0)
            			{
	            			//console.log("D Se cambia el ancho a "+anchoColumna + " y tenia "+chartDetail[iNumGrafica].series[i].data[0].pointWidth);
	            			if(anchoColumna>chartDetail[iNumGrafica].series[i].data[0].pointWidth)
	            			{
	            				//console.log("D2 Se cambia el ancho a "+anchoColumna);
		            			chartDetail[iNumGrafica].series[i].options.pointWidth= anchoColumna;
		            			chartZoom[iNumGrafica].series[i].options.pointWidth= anchoColumna;
		            		}
		            	}
            		}
            		//MPT acumulado horario
            		else if((zIndex==2 && graficoDiario == 1 || graficoLineal==1))
            		{
            			var horas = Math.ceil(timeChart / 3600000);
            			var anchoColumna = Math.min(0.3*ancho/(horas),20);
            			//console.log(chartDetail[iNumGrafica]);
            			if(chartDetail[iNumGrafica].series[i].data.length>0)
            			{
	            			//console.log("H Se cambia el ancho a "+anchoColumna + " y tenia "+chartDetail[iNumGrafica].series[i].data[0].pointWidth);
	            			if(anchoColumna>chartDetail[iNumGrafica].series[i].data[0].pointWidth)
	            			{
	            				//console.log("H2 Se cambia el ancho a "+anchoColumna);
		            			chartZoom[iNumGrafica].series[i].options.pointWidth= anchoColumna;
		            			chartDetail[iNumGrafica].series[i].options.pointWidth= anchoColumna;
		            		}
		            	}
            		}
            	}
            }
		}
		function xActualizar_Datos_Graficas(iNumGrafica)
		{
			var	xmlHttpDB;
			var sDatosXMLOut;			
			var url="carga_informe_grafica.php";

			clearTimeout(timeoutReturn[iNumGrafica]);
			
			sDatosXMLOut=xGenerar_Datos_Graficas(iNumGrafica);
			xmlHttpDB= GetXmlHttpObject();
			xmlHttpDB.open("POST",url,true);
			xmlHttpDB.onreadystatechange=function()
			{
				if (xmlHttpDB.readyState==4)
				{
					var data = eval("("+xmlHttpDB.responseText+")");
					var plotarea = $("#caja_grafica"+iNumGrafica);
					
				   var numGraphs = chartDetail[iNumGrafica].series.length;
				   for(i=0;i<numGraphs;i++)
		            {
		            	//var tipoGraph = chartDetail[iNumGrafica].series[i].type;*/
		            	//console.log(data[i]);
	            		
	            		chartZoom[iNumGrafica].series[i].setData(data[i].data);
	            		chartDetail[iNumGrafica].series[i].setData(data[i].data);
	            	}
				}
			 }
			 xmlHttpDB.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
			
			xmlHttpDB.send(sDatosXMLOut);
			
			if(top.document.getElementById('Filtro_combo_Informe').selectedIndex==1)
			{
				var timeout = top.document.getElementById('tiempoIntervalo').value;
				var unidad = top.document.getElementById('selectIntervalo').options[top.document.getElementById('selectIntervalo').selectedIndex].id;
				switch (unidad)
				{
					case '0':
						timeout = timeout*60000;
						break;
					case '1':
						timeout = timeout*60*60000;
						break;
					case '2':
						timeout = timeout*24*60*60000;
						break;
				}
				timeoutReturn[iNumGrafica] = setTimeout("xActualizar_Datos_Graficas("+iNumGrafica+")",timeout);
				
			}
		}
		
		function xObtener_Datos_Graficas_Zoom(iNumGrafica)
		{
			var	xmlHttpDB;
			var sDatosXMLOut;
			//var url="window.open('carga_informe_grafica.php')";
			var url="carga_informe_grafica.php";

			clearTimeout(timeoutReturn[iNumGrafica]);
			sDatosXMLOut=xGenerar_Datos_Graficas_Zoom(iNumGrafica);
			xmlHttpDB= GetXmlHttpObject();			
			xmlHttpDB.open("POST",url,true);
			xmlHttpDB.onreadystatechange=function()
			{
				if (xmlHttpDB.readyState==4)
				{
					var data = eval("("+xmlHttpDB.responseText+")");
					var plotarea = $("#caja_grafica"+iNumGrafica);
					var saMagnitudes=new Array();
					var saUnidades=new Array();
					saMagnitudes=iBuscar_Nombres_Magnitudes(iNumGrafica);
				   for (i=0;i<saMagnitudes.length;i++)
				   {
				   		indice = saMagnitudes[i].lastIndexOf("(");
				   		indicefin = saMagnitudes[i].lastIndexOf(")");
				   		saUnidades[i]="";
				   			//alert(indice);
				   		if((indice > 0) && (indice < saMagnitudes[i].length) && (indicefin > 0) && (indicefin < saMagnitudes[i].length) && indice < indicefin)
				   			saUnidades[i]=saMagnitudes[i].substring(indice+1,indicefin);
				   		//alert(saUnidades[i]);
				   }
				   //chartZoom[iNumGrafica].destroy();
				   chartZoom[iNumGrafica] = new Highcharts.Chart({
		                chart: {
		                    renderTo: 'caja_zoom_grafica'+iNumGrafica,
		                    reflow: false,
		                    borderWidth: 0,
		                    backgroundColor: null,
		                    marginLeft: 50,
		                    marginRight: 20,
		                    zoomType: 'x',
		                    events: {
		                        // listen to the selection event on the master chart to update the
		                        // extremes of the detail chart
		                        selection: function(event) {
		                            var extremesObject = event.xAxis[0],
		                                min = extremesObject.min,
		                                max = extremesObject.max,
		                                xAxis = this.xAxis[0];
		                                var timeChart = max-min;
		                            actualiza_Columna(iNumGrafica,timeChart);
		                           	chartDetail[iNumGrafica].xAxis[0].setExtremes(min,max);
		                               
		                            xAxis.removePlotBand('mask-before');
		                            xAxis.removePlotBand('mask-after');
		                            extremesX = xAxis.getExtremes();
		                            minimoX = extremesX.min;
		                            maximoX = extremesX.max;
		                            xAxis.addPlotBand({
		                                id: 'mask-before',
		                                from: minimoX,
		                                to: min,
		                                color: 'rgba(0, 0, 0, 0.2)'
		                            });
		                            xAxis.addPlotBand({
		                                id: 'mask-after',
		                                from: max,
		                                to: maximoX,
		                                color: 'rgba(0, 0, 0, 0.2)'
		                            });
		                            return false;
		                        }
		                    }
		                },
		                title: {
		                    text: null
		                },
		                xAxis: {
		                    type: 'datetime',
		                    showLastTickLabel: true,
		                    maxZoom: 60000, // one minut
		                    title: {
		                        text: null
		                    },
		                    dateTimeLabelFormats: {
				                second: '%d-%m %H:%M:%S',
								minute: '%d-%m %H:%M',
								hour: '%d-%m %H:%M',
								day: '%d-%m-%y',
								week: '%d-%m-%Y',
								month: '%m-%Y',
				            }
		                },
		                yAxis: [{
		                    gridLineWidth: 0,
		                    labels: {
		                        enabled: false
		                    },
		                    title: {
		                        text: null
		                    },
		                    showFirstLabel: false
		                },{
		                    gridLineWidth: 0,
		                    labels: {
		                        enabled: false
		                    },
		                    title: {
		                        text: null
		                    },
		                    showFirstLabel: false,
		                    opposite: true
		                }],
		                tooltip: {
		                    formatter: function() {
		                        return false;
		                    }
		                },
		                legend: {
		                    enabled: false
		                },
		                credits: {
		                    enabled: false
		                },
		                plotOptions: {
		                    series: {
		                        fillColor: {
		                            linearGradient: [0, 0, 0, 70],
		                            stops: [
		                                [0, '#4572A7'],
		                                [1, 'rgba(0,0,0,0)']
		                            ]
		                        },
		                        lineWidth: 1,
		                        marker: {
		                            enabled: false
		                        },
		                        shadow: false,
		                        states: {
		                            hover: {
		                                lineWidth: 1
		                            }
		                        },
		                        enableMouseTracking: false
		                    }
		                },
		                series: data,
						exporting: {
		                    enabled: false
		                }
		            });
				   	//chartDetail[iNumGrafica].destroy();
					chartDetail[iNumGrafica] = new Highcharts.Chart({
						chart: {
							renderTo: 'caja_grafica'+iNumGrafica,
							reflow: false
						},
						title: {
							text: document.getElementById("titulo_g"+iNumGrafica).value
						},
						xAxis: {
							type: 'datetime',
		                    dateTimeLabelFormats: {
				                second: '%d-%m %H:%M:%S',
								minute: '%d-%m %H:%M',
								hour: '%d-%m %H:%M',
								day: '%d-%m-%y',
								week: '%d-%m-%Y',
								month: '%m-%Y',
				            },
				            tickInterval: null,
				            tickPixelInterval: 150,
						},
						yAxis: [{ // Primary yAxis
							labels: {
								style: {
									color: '#606060'
								}
							},
							title: {
								text: saMagnitudes[0],
								style: {
									color: '#606060'
								}
							},
							opposite: false
					
						}, { // Secondary yAxis
							title: {
								text: saMagnitudes[1],
								style: {
									color: '#606060'
								}
							},
							labels: {
								style: {
									color: '#606060'
								}
							},
							opposite: true
						}],
						tooltip: {
							formatter: function() {
								return '<b>'+ this.series.name +'</b><br/>'+ Highcharts.dateFormat('%d-%m-%y %H:%M:%S', this.x) +'-> '+ this.y +''+saUnidades[this.series.yAxis.opposite?1:0];
								//return ''+
									//this.x +': '+ this.y +' '+ unit;
							}
						},
						legend: {
							layout: 'vertical',
							align: 'left',
							verticalAlign: 'top',
							floating: true,
							y: 15,
							backgroundColor: '#FFFFFF'
						},
						plotOptions: {
							spline: {
								lineWidth: 3,
								states: {
									hover: {
										lineWidth: 4
									}
								},
								marker: {
									enabled: false,
									states: {
										hover: {
											enabled: true,
											symbol: 'circle',
											radius: 5,
											lineWidth: 1
										}
									}
								}
							},
							column: {
								marker: {
									enabled: false,
									states: {
										hover: {
											enabled: true,
											symbol: 'circle'
										}
									}
								},
								groupPadding: 0,
							}
						},
						series: data,
						exporting: {
					        enabled: true
					   },
					 	credits: {
					 		enabled: false
					 	}
					});
					actualiza_Columna(iNumGrafica,-1);
					var numGraphs = chartDetail[iNumGrafica].series.length;
				   for(i=0;i<numGraphs;i++)
				    {
					    	//var tipoGraph = chartDetail[iNumGrafica].series[i].type;*/
						//console.log(data[i]);
						
						chartZoom[iNumGrafica].series[i].setData(data[i].data);
						chartDetail[iNumGrafica].series[i].setData(data[i].data);
					}
					
				    document.getElementById('div_espera').style.display="none";
				    document.getElementById('caja_instrucciones').style.display="";
				    document.getElementById('caja_grafica'+iNumGrafica).style.display="";
				    document.getElementById('caja_zoom_grafica'+iNumGrafica).style.display="";
				}
			}
			xmlHttpDB.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
			
			xmlHttpDB.send(sDatosXMLOut);

			if(document.getElementById('Filtro_combo_Informe').value==1)
			{
				var timeout = document.getElementById('tiempoIntervalo').value;
				var unidad = document.getElementById('selectIntervalo').value;
				
				switch (unidad)
				{
					case '0':
						timeout = timeout*60000;
						break;
					case '1':
						timeout = timeout*60*60000;
						break;
					case '2':
						timeout = timeout*24*60*60000;
						break;
				}
				//AMB 25/05/2102 Almacenamos cada timeout en una posición del array para luego destruir cada timeout independientemente
				timeoutReturn[iNumGrafica] = setTimeout("xActualizar_Datos_Graficas_Zoom("+iNumGrafica+")",timeout);
				
			}

			return;
		}
		
		function xActualizar_Datos_Graficas_Zoom(iNumGrafica)
		{
			var	xmlHttpDB;
			var sDatosXMLOut;			
			var url="carga_informe_grafica.php";
			clearTimeout(timeoutReturn[iNumGrafica]);
			
			sDatosXMLOut=xGenerar_Datos_Graficas_Zoom(iNumGrafica);
			xmlHttpDB= GetXmlHttpObject();
			xmlHttpDB.open("POST",url,true);
			xmlHttpDB.onreadystatechange=function()
			{
				if (xmlHttpDB.readyState==4)
				{
					var data = eval("("+xmlHttpDB.responseText+")");
					var plotarea = $("#caja_grafica"+iNumGrafica);
				   var numGraphs = chartDetail[iNumGrafica].series.length;
				   for(i=0;i<numGraphs;i++)
		            {
		            	//var tipoGraph = chartDetail[iNumGrafica].series[i].type;*/
		            	//console.log(data[i]);
	            		
	            		chartZoom[iNumGrafica].series[i].setData(data[i].data);
	            		chartDetail[iNumGrafica].series[i].setData(data[i].data);
	            	}
				}
			 }
			 xmlHttpDB.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
			
			xmlHttpDB.send(sDatosXMLOut);
			
			if(document.getElementById('Filtro_combo_Informe').value==1)
			{
				var timeout = document.getElementById('tiempoIntervalo').value;
				var unidad = document.getElementById('selectIntervalo').value;
				switch (unidad)
				{
					case '0':
						timeout = timeout*60000;
						break;
					case '1':
						timeout = timeout*60*60000;
						break;
					case '2':
						timeout = timeout*24*60*60000;
						break;
				}
				timeoutReturn[iNumGrafica] = setTimeout("xActualizar_Datos_Graficas_Zoom("+iNumGrafica+")",timeout);
				
			}
		}

		function Rellenar_Informe()
		{
			var iResultado;
			var sDatosXML;
			
			if (iComprobar_Controles_Informe() == 0)
			{
				iResultado = iComprobar_Magnitudes();
				if (iResultado == 0)
				{
					document.getElementById('h_tabbar').style.display = "none";
					document.getElementById('div_espera').style.display = "";				
					document.getElementById('bAtras').style.display = "";
					document.getElementById('bGraf').style.display = "none";
					document.getElementById('bGrafZoom').style.display = "";
					document.getElementById('graf_title').style.display = "none";
					document.getElementById('export').style.display = "";		
					for (var iI=1;iI<5;iI++)
					{
						if (iComprobar_Grafica(iI) == 0)
						{
							//document.getElementById('titulo_grafica'+iI).innerHTML = document.getElementById("titulo_g"+iI).value;
							document.getElementById('caja_grafica'+iI).style.width="95%";
							document.getElementById('caja_grafica'+iI).style.height="350px";
							document.getElementById('caja_zoom_grafica'+iI).style.width="95%";
							document.getElementById('caja_zoom_grafica'+iI).style.height="70px";
							//document.getElementById('caja_grafica'+iI).innerHTML='<img src="images/gif_loading.gif" width="50px" height="50px"/>';
							xObtener_Datos_Graficas(iI);
						}
						else
						{
							//document.getElementById('titulo_grafica'+iI).innerHTML = '';
							document.getElementById('caja_grafica'+iI).style.width="0px";
							document.getElementById('caja_grafica'+iI).style.height="0px";
							document.getElementById('caja_grafica'+iI).innerHTML='';
							document.getElementById('caja_zoom_grafica'+iI).style.width="0px";
							document.getElementById('caja_zoom_grafica'+iI).style.height="0px";
							document.getElementById('caja_zoom_grafica'+iI).innerHTML='';
							
						}
					}
					
					descargarPDF();
										
				}
				else
				{
					alert(iObtener_Cadena_AJAX('general220')+' '+iResultado+' '+iObtener_Cadena_AJAX('error_graf10'));
				}
			}
		}
		function descargarPDF()
		{
			Highcharts.getSVG = function(charts) {
			    var svgArr = [],
			        top = 0,
			        width = 0;
				for( var i = 1; i < 5; i++)
				{						
					if (iComprobar_Grafica(i) == 0)
					{
						var svg = charts[i].getSVG();
				        svg = svg.replace('<svg', '<g transform="translate(0,' + top + ')" ');
				        svg = svg.replace('</svg>', '</g>');
				
				        top += charts[i].chartHeight;
				        width = Math.max(width, charts[i].chartWidth);								
				        svgArr.push(svg);
			       }
				}
			    return '<svg height="'+ top +'" width="' + width + '" version="1.1" xmlns="http://www.w3.org/2000/svg">' + svgArr.join('') + '</svg>';
			};
			
			Highcharts.exportCharts = function(charts, options) {
			    var form
			        svg = Highcharts.getSVG(charts);
			
			    // merge the options
			    options = Highcharts.merge(Highcharts.getOptions().exporting, options);
			
			    // create the form
			    form = Highcharts.createElement('form', {
			        method: 'post',
			        action: options.url
			    }, {
			        display: 'none'
			    }, document.body);
			
			    // add the values
			    Highcharts.each(['filename', 'type', 'width', 'svg'], function(name) {
			        Highcharts.createElement('input', {
			            type: 'hidden',
			            name: name,
			            value: {
			                filename: options.filename || 'Rfreenet_Charts',
			                type: "application/pdf",
			                width: options.width,
			                svg: svg
			            }[name]
			        }, null, form);					        
			    });
			    //console.log(svg); return;
			    // submit
			    form.submit();
			
			    // clean up
			    form.parentNode.removeChild(form);
			};
		   
		   $('#export').click(function() {
		   		Highcharts.exportCharts(chartDetail);
		   });
		//////////////////////////////////////////////////////		
		}
		function Rellenar_Informe_Zoom()
		{
			var iResultado;
			var sDatosXML;
			
			document.getElementById('h_tabbar').style.display = "none";
			document.getElementById('div_espera').style.display = "";
			document.getElementById('div_espera').style.position = "absolute";
			document.getElementById('div_espera').style.left = "150px";
			document.getElementById('div_espera').style.top = "150px";
			
			document.getElementById('bGraf').style.display = "none";
			document.getElementById('graf_title').style.display = "none";
			//document.getElementById('bDown').style.display = "none";	
			document.getElementById('bGrafZoom').style.display = "none";
			document.getElementById('bAtras').style.display = "none";
			document.getElementById('caja_instrucciones').style.height="95%";
			document.getElementById('export').style.display = "none";
								
			for (var iI=1;iI<5;iI++)
			{							
				if (iComprobar_Grafica(iI) == 0)
				{
					//document.getElementById('iframe_mapa').className = vClase;
					//document.getElementById('titulo_grafica'+iI).innerHTML = document.getElementById("titulo_g"+iI).value;
					document.getElementById('caja_grafica'+iI).style.width="95%";
					document.getElementById('caja_grafica'+iI).style.height="50%";
					document.getElementById('caja_zoom_grafica'+iI).style.width="95%";
					document.getElementById('caja_zoom_grafica'+iI).style.height="15%";
					document.getElementById('caja_grafica'+iI).style.display="none";
					document.getElementById('caja_zoom_grafica'+iI).style.display="none";
					//document.getElementById('caja_grafica'+iI).innerHTML='<img src="images/gif_loading.gif" width="50px" height="50px"/>';				
					xObtener_Datos_Graficas_Zoom(iI);					
				}

			}			
			
		}	

		function Nueva_ventana()
		{
			//AMB 25/05/2102 Creamos una nueva ventana maximizada para contener las gráficas
			var height = screen.availHeight-30;
			var width = screen.availWidth-10;
			var settings;
			var left = 0;
			var top = 0;
			var sDatosXmlOut = new Array(4);
			settings = 'fullscreen=no,resizable=yes,location=no,toolbar=no,menubar=no';
			settings = settings + ',status=no,directories=no,scrollbars=no';
			settings = settings + ',width=' + width +',height=' + height;
			settings = settings + ',top=' + top +',left=' + left;
			settings = settings + ',charset=iso-8859-1';
	
			writeConsole(document.head.innerHTML + document.body.innerHTML);
			//AMB 25/05/2102 Escribimos en la nueva ventana el contenido de la principal (la parte de la gráfica) y le pasamos los parámetros que necesita con sus respectivos valores
			function writeConsole(content) {
			 consoleRef=window.open('','myconsole',settings);
		  	
			sTipo = new String();
			for (var iGraficas = 0; iGraficas < 4; iGraficas++)
			{
				for(var iSensores = 0; iSensores < 4; iSensores++)
				{
					var sRadio = document.getElementsByName("graph"+(iGraficas+1)+"s"+(iSensores+1));
					for (var iRadio = 0; iRadio < sRadio.length; iRadio++)
					{
						if (sRadio[iRadio].checked)
						{
							sTipo+=sRadio[iRadio].value;
						}
					}
				}	
			}
			   if(parent.document.getElementById('Filtro_combo_Informe').selectedIndex == 1)
			   {			 					 	
			   			 
					 consoleRef.document.writeln(
					 	content
					   +'<input id="db_cliente" type="hidden" value="'+parent.document.getElementById("db_cliente").value+'">'
					   +'<input id="id_cliente" type="hidden" value="'+parent.document.getElementById("id_cliente").value+'">'		
					   +'<input id="tiempoIntervalo" type="hidden" value="'+parent.document.getElementById('tiempoIntervalo').value+'">'
					   +'<input id="selectIntervalo" type="hidden" value="'+parent.document.getElementById('selectIntervalo').options[parent.document.getElementById('selectIntervalo').selectedIndex].id+'">'
					   +'<input id="tiempoGrafica" type="hidden" value="'+parent.document.getElementById('tiempoGrafica').value+'">'
					   +'<input id="selectTiempo" type="hidden" value="'+parent.document.getElementById('selectTiempo').options[parent.document.getElementById('selectTiempo').selectedIndex].id+'">'			   
					   +'<input id="comboInstalaciones" type="hidden" value="'+parent.document.getElementById("comboInstalaciones").options[parent.document.getElementById("comboInstalaciones").selectedIndex].value+'">'			   			   			   		   	   
					   +'<input id="Filtro_combo_Informe" type="hidden" value="'+parent.document.getElementById('Filtro_combo_Informe').selectedIndex+'">'
					   +'<script>Rellenar_Radio('+sTipo+');Rellenar_Informe_Zoom()</script\></body></html>'
					 //  +'<script>Rellenar_Informe_Zoom("", new Array("'+sDatosXmlOut[1]+'","'+sDatosXmlOut[2]+'","'+sDatosXmlOut[3]+'","'+sDatosXmlOut[4]+'"))</script\></body></html>'
					 )
				}
				else
				{
					 consoleRef.document.writeln(
					 	content
					   +'<input id="db_cliente" type="hidden" value="'+parent.document.getElementById("db_cliente").value+'">'
					   +'<input id="id_cliente" type="hidden" value="'+parent.document.getElementById("id_cliente").value+'">'		
					   +'<input id="tiempoIntervalo" type="hidden" value="">'
					   +'<input id="selectIntervalo" type="hidden" value="">'
					   +'<input id="tiempoGrafica" type="hidden" value="">'
					   +'<input id="selectTiempo" type="hidden" value="">'			   					   
					   +'<input id="comboInstalaciones" type="hidden" value="'+parent.document.getElementById("comboInstalaciones").options[parent.document.getElementById("comboInstalaciones").selectedIndex].value+'">'
					   +'<input id="FechaFinal" type="hidden" value="'+parent.document.getElementById('FechaFinal').value+'">'
					   +'<input id="FechaInicial" type="hidden" value="'+parent.document.getElementById('FechaInicial').value+'">'
 						+'<input id="comboInstalaciones" type="hidden" value="'+parent.document.getElementById("comboInstalaciones").options[parent.document.getElementById("comboInstalaciones").selectedIndex].value+'">'					   
					   +'<input id="Filtro_combo_Informe" type="hidden" value="'+parent.document.getElementById('Filtro_combo_Informe').selectedIndex+'">'
					   +'<script>Rellenar_Radio('+sTipo+');Rellenar_Informe_Zoom()</script\></body></html>'
					 //  +'<script>Rellenar_Informe_Zoom("", new Array("'+sDatosXmlOut[1]+'","'+sDatosXmlOut[2]+'","'+sDatosXmlOut[3]+'","'+sDatosXmlOut[4]+'"))</script\></body></html>'
					 )					
				}			 
			 consoleRef.document.close()
			 			 
			}					
		}
		
		function Rellenar_Radio(Tipo)
		{
			var sTipo = Tipo.toString();
			
			for (var iGraficas = 0; iGraficas < 4; iGraficas++)
			{
				for(var iSensores = 0; iSensores < 4; iSensores++)
				{
					var sRadio = document.getElementsByName("graph"+(iGraficas+1)+"s"+(iSensores+1));
					for (var iRadio = 0; iRadio < sRadio.length; iRadio++)
					{
						if (sRadio[iRadio].value == sTipo.charAt(iGraficas*4+iSensores))
						{
							//alert("Sensor "+iI+" datos "+sRadio[iRadio].value+" vs "+tipo);
							sRadio[iRadio].checked = true;
						}
					}
				}	
			}
		}
		
		function vVolverAtras()
		{
			document.getElementById('caja_grafica1').innerHTML='';
			document.getElementById('caja_grafica2').innerHTML='';
			document.getElementById('caja_grafica3').innerHTML='';
			document.getElementById('caja_grafica4').innerHTML='';
			document.getElementById('caja_instrucciones').style.display = "none";
			document.getElementById('div_espera').style.display = "none";
			document.getElementById('h_tabbar').style.display = "";
			document.getElementById('bAtras').style.display = "none";
			document.getElementById('bGraf').style.display = "";
			document.getElementById('graf_title').style.display = "";
			document.getElementById('bGrafZoom').style.display = "none";
			document.getElementById('export').style.display = "none";

			document.getElementById('imagen1').value='';
			document.getElementById('imagen2').value='';
			document.getElementById('imagen3').value='';
			document.getElementById('imagen4').value='';
			document.getElementById('imagen1_div').value='';
			document.getElementById('imagen2_div').value='';
			document.getElementById('imagen3_div').value='';
			document.getElementById('imagen4_div').value='';
		}		
		
	</script>
</head>
<body>
	<div>
		<div style="text-align:center;margin-top:25px">	
			<span id="graf_title"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general221']?></span>
			<select id="Filtro_sensores_gX" style="margin-right:100px;display:none;"><option value="tot"></option></select>			
		</div>
		<div id='caja_instrucciones' style="display:none;width:100%;height:420px;overflow-y:scroll;-ms-overflow-y:scroll;text-align:center" class="highslide-resize">
			<div id='caja_grafica1' style="width:95%;height:400px"></div>
			<div id='caja_zoom_grafica1' style="width:95%;height:100px"></div>
			<div id='caja_grafica2' style="width:95%;height:400px"></div>
			<div id='caja_zoom_grafica2' style="width:95%;height:100px"></div>
			<div id='caja_grafica3' style="width:95%;height:400px"></div>
			<div id='caja_zoom_grafica3' style="width:95%;height:100px"></div>
			<div id='caja_grafica4' style="width:95%;height:400px"></div>
			<div id='caja_zoom_grafica4' style="width:95%;height:100px"></div>
		</div>
		<div id="h_tabbar" style="width:95%;height:410px;margin-left:20px">
			<div id='params_h_1'>
				<div style="text-align:center;margin-top:15px;margin-right:50px">
					<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general222']?> 1</span>
					<input type="text" id="titulo_g1" style="width:150px;text-align:center" maxlength="20"/>
				</div>
				<div style="width:35%;clear:none;float:left;margin-left:30px">
					<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general223']?></span>
					<select id="Filtro_sensores_g1" style="margin-right:100px">
					<?php 
						echo Rellenar_Filtro_Sensores_Informes();
					?>
					</select>
					<select id="box1View" multiple="multiple" style="height:250px;width:230px;"></select>
					<select id="box1Storage"></select>
					<p><span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general224']?>:</span><input type="text" id="box1Filter"/>
				</div>
				<div style="height:250px;width:50px;clear:none;float:left;margin-top:140px;">				
					<button id="to2" type="button" style="width:44px"> > </button>
					<button id="to1" type="button" style="width:44px;margin-top:20px"> < </button>
				</div>
				<div style="width:240px;clear:none;float:left;margin-top:50px">
					<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general225']?></span>
					<select id="box2View" multiple="multiple" style="line-height:50px;height:230px;width:230px;"></select>
					<select id="box2Storage"></select>
					<input type="hidden" id="box2Filter"/>
				</div>
				<div style="height:250px;width:140px;clear:none;float:left;">				
					<table border="0" width="100%" cellpadding="0" cellspacing="0">
						<tr>
							<td><span class="RFNETtext"><?php echo $idiomas[$_SESSION['opcion_idioma']]['plantilla4']?></span><br /><img src="images/chart_4.png" width="40px" style="valign:top;align:center" alt="Lineal"></td>
							<td><span class="RFNETtext"><?php echo $idiomas[$_SESSION['opcion_idioma']]['plantilla5']?></span><br /><img src="images/chart_1.png" width="40px" style="valign:top;align:center" alt="Diario"></td>
							<td><span class="RFNETtext"><?php echo $idiomas[$_SESSION['opcion_idioma']]['plantilla6']?></span><br /><img src="images/chart_1.png" width="40px" style="valign:top;align:center" alt="Horario"></td>
						</tr>
						<tr>
							<td align="center" height="17"><input type="radio" id="graph1s1lineal" name="graph1s1" checked="checked" value="0"></td>
							<td align="center"><input type="radio" id="graph1s1diario" name="graph1s1" value="1"></td>
							<td align="center"><input type="radio" id="graph1s1horario" name="graph1s1" value="2"></td>
						</tr>
						<tr>
							<td align="center" height="17"><input type="radio" id="graph1s2lineal" name="graph1s2" checked="checked" value="0"></td>
							<td align="center"><input type="radio" id="graph1s2diario" name="graph1s2" value="1"></td>
							<td align="center"><input type="radio" id="graph1s2horario" name="graph1s2" value="2"></td>
						</tr>
						<tr>
							<td align="center" height="17"><input type="radio" id="graph1s3lineal" name="graph1s3" checked="checked" value="0"></td>
							<td align="center"><input type="radio" id="graph1s3diario" name="graph1s3" value="1"></td>
							<td align="center"><input type="radio" id="graph1s3horario" name="graph1s3" value="2"></td>
						</tr>
						<tr>
							<td align="center" height="17"><input type="radio" id="graph1s4lineal" name="graph1s4" checked="checked" value="0"></td>
							<td align="center"><input type="radio" id="graph1s4diario" name="graph1s4" value="1"></td>
							<td align="center"><input type="radio" id="graph1s4horario" name="graph1s4" value="2"></td>
						</tr>
					</table>
				</div>
			</div>
			<div id='params_h_2'>
				<div style="text-align:center;margin-top:15px;margin-right:50px">
					<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general222']?> 2</span>
					<input type="text" id="titulo_g2" style="width:150px;text-align:center" maxlength="20"/>
				</div>
				<div style="width:35%;clear:none;float:left;margin-left:30px">
					<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general223']?></span>
					<select id="Filtro_sensores_g2" style="margin-right:100px">
					<?php 
						echo Rellenar_Filtro_Sensores_Informes();
					?>
					</select>
					<select id="box3View" multiple="multiple" style="height:250px;width:230px;"></select>
					<select id="box3Storage"></select>
					<p><span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general224']?>:</span><input type="text" id="box3Filter"/>
				</div>
				<div style="height:250px;width:50px;clear:none;float:left;margin-top:140px;">				
					<button id="to4" type="button" style="width:33px"> > </button>
					<button id="to3" type="button" style="width:33px;margin-top:20px"> < </button>
				</div>
				<div style="width:240px;clear:none;float:left;margin-top:50px">
					<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general225']?></span>
					<select id="box4View" multiple="multiple" style="line-height:50px;height:230px;width:230px;"></select>
					<select id="box4Storage"></select>
					<input type="hidden" id="box4Filter"/>
				</div>
				<div style="height:250px;width:140px;clear:none;float:left;">				
					<table border="0" width="100%" cellpadding="0" cellspacing="0">
						<tr>
							<td><span class="RFNETtext"><?php echo $idiomas[$_SESSION['opcion_idioma']]['plantilla4']?></span><br /><img src="images/chart_4.png" width="40px" style="valign:top;align:center" alt="Lineal"></td>
							<td><span class="RFNETtext"><?php echo $idiomas[$_SESSION['opcion_idioma']]['plantilla5']?></span><br /><img src="images/chart_1.png" width="40px" style="valign:top;align:center" alt="Diario"></td>
							<td><span class="RFNETtext"><?php echo $idiomas[$_SESSION['opcion_idioma']]['plantilla6']?></span><br /><img src="images/chart_1.png" width="40px" style="valign:top;align:center" alt="Horario"></td>
						</tr>
						<tr>
							<td align="center" height="17"><input type="radio" id="graph2s1lineal" name="graph2s1" checked="checked" value="0"></td>
							<td align="center"><input type="radio" id="graph2s1diario" name="graph2s1" value="1"></td>
							<td align="center"><input type="radio" id="graph2s1horario" name="graph2s1" value="2"></td>
						</tr>
						<tr>
							<td align="center" height="17"><input type="radio" id="graph2s2lineal" name="graph2s2" checked="checked" value="0"></td>
							<td align="center"><input type="radio" id="graph2s2diario" name="graph2s2" value="1"></td>
							<td align="center"><input type="radio" id="graph2s2horario" name="graph2s2" value="2"></td>
						</tr>
						<tr>
							<td align="center" height="17"><input type="radio" id="graph2s3lineal" name="graph2s3" checked="checked" value="0"></td>
							<td align="center"><input type="radio" id="graph2s3diario" name="graph2s3" value="1"></td>
							<td align="center"><input type="radio" id="graph2s3horario" name="graph2s3" value="2"></td>
						</tr>
						<tr>
							<td align="center" height="17"><input type="radio" id="graph2s4lineal" name="graph2s4" checked="checked" value="0"></td>
							<td align="center"><input type="radio" id="graph2s4diario" name="graph2s4" value="1"></td>
							<td align="center"><input type="radio" id="graph2s4horario" name="graph2s4" value="2"></td>
						</tr>
					</table>
				</div>
			</div>
			<div id='params_h_3'>
				<div style="text-align:center;margin-top:15px;margin-right:50px">
					<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general222']?> 3</span>
					<input type="text" id="titulo_g3" style="width:150px;text-align:center" maxlength="20"/>
				</div>
				<div style="width:35%;clear:none;float:left;margin-left:30px">
					<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general223']?></span>
					<select id="Filtro_sensores_g3" style="margin-right:100px">
					<?php 
						echo Rellenar_Filtro_Sensores_Informes();
					?>
					</select>
					<select id="box5View" multiple="multiple" style="height:250px;width:230px;"></select>
					<select id="box5Storage"></select>
					<p><span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general224']?>:</span><input type="text" id="box5Filter"/>
				</div>
				<div style="height:250px;width:50px;clear:none;float:left;margin-top:140px;">				
					<button id="to6" type="button" style="width:33px"> > </button>
					<button id="to5" type="button" style="width:33px;margin-top:20px"> < </button>
				</div>
				<div style="width:240px;clear:none;float:left;margin-top:50px">
					<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general225']?></span>
					<select id="box6View" multiple="multiple" style="line-height:50px;height:230px;width:230px;"></select>
					<select id="box6Storage"></select>
					<input type="hidden" id="box6Filter"/>
				</div>
				<div style="height:250px;width:140px;clear:none;float:left;">				
					<table border="0" width="100%" cellpadding="0" cellspacing="0">
						<tr>
							<td><span class="RFNETtext"><?php echo $idiomas[$_SESSION['opcion_idioma']]['plantilla4']?></span><br /><img src="images/chart_4.png" width="40px" style="valign:top;align:center" alt="Lineal"></td>
							<td><span class="RFNETtext"><?php echo $idiomas[$_SESSION['opcion_idioma']]['plantilla5']?></span><br /><img src="images/chart_1.png" width="40px" style="valign:top;align:center" alt="Diario"></td>
							<td><span class="RFNETtext"><?php echo $idiomas[$_SESSION['opcion_idioma']]['plantilla6']?></span><br /><img src="images/chart_1.png" width="40px" style="valign:top;align:center" alt="Horario"></td>
						</tr>
						<tr>
							<td align="center" height="17"><input type="radio" id="graph3s1lineal" name="graph3s1" checked="checked" value="0"></td>
							<td align="center"><input type="radio" id="graph3s1diario" name="graph3s1" value="1"></td>
							<td align="center"><input type="radio" id="graph3s1horario" name="graph3s1" value="2"></td>
						</tr>
						<tr>
							<td align="center" height="17"><input type="radio" id="graph3s2lineal" name="graph3s2" checked="checked" value="0"></td>
							<td align="center"><input type="radio" id="graph3s2diario" name="graph3s2" value="1"></td>
							<td align="center"><input type="radio" id="graph3s2horario" name="graph3s2" value="2"></td>
						</tr>
						<tr>
							<td align="center" height="17"><input type="radio" id="graph3s3lineal" name="graph3s3" checked="checked" value="0"></td>
							<td align="center"><input type="radio" id="graph3s3diario" name="graph3s3" value="1"></td>
							<td align="center"><input type="radio" id="graph3s3horario" name="graph3s3" value="2"></td>
						</tr>
						<tr>
							<td align="center" height="17"><input type="radio" id="graph3s4lineal" name="graph3s4" checked="checked" value="0"></td>
							<td align="center"><input type="radio" id="graph3s4diario" name="graph3s4" value="1"></td>
							<td align="center"><input type="radio" id="graph3s4horario" name="graph3s4" value="2"></td>
						</tr>
					</table>
				</div>
			</div>
			<div id='params_h_4'>
				<div style="text-align:center;margin-top:15px;margin-right:50px">
					<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general222']?> 4</span>
					<input type="text" id="titulo_g4" style="width:150px;text-align:center" maxlength="20"/>
				</div>
				<div style="width:35%;clear:none;float:left;margin-left:30px">
					<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general223']?></span>
					<select id="Filtro_sensores_g4" style="margin-right:100px">
					<?php 
						echo Rellenar_Filtro_Sensores_Informes();
					?>
					</select>
					<select id="box7View" multiple="multiple" style="height:250px;width:230px;"></select>
					<select id="box7Storage"></select>
					<p><span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general224']?>:</span><input type="text" id="box7Filter"/>
				</div>
				<div style="height:250px;width:50px;clear:none;float:left;margin-top:140px;">				
					<button id="to8" type="button" style="width:33px"> > </button>
					<button id="to7" type="button" style="width:33px;margin-top:20px"> < </button>
				</div>
				<div style="width:240px;clear:none;float:left;margin-top:50px">
					<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general225']?></span>
					<select id="box8View" multiple="multiple" style="line-height:50px;height:230px;width:230px;"></select>
					<select id="box8Storage"></select>
					<input type="hidden" id="box8Filter"/>
				</div>
				<div style="height:250px;width:140px;clear:none;float:left;">				
					<table border="0" width="100%" cellpadding="0" cellspacing="0">
						<tr>
							<td><span class="RFNETtext"><?php echo $idiomas[$_SESSION['opcion_idioma']]['plantilla4']?></span><br /><img src="images/chart_4.png" width="40px" style="valign:top;align:center" alt="Lineal"></td>
							<td><span class="RFNETtext"><?php echo $idiomas[$_SESSION['opcion_idioma']]['plantilla5']?></span><br /><img src="images/chart_1.png" width="40px" style="valign:top;align:center" alt="Diario"></td>
							<td><span class="RFNETtext"><?php echo $idiomas[$_SESSION['opcion_idioma']]['plantilla6']?></span><br /><img src="images/chart_1.png" width="40px" style="valign:top;align:center" alt="Horario"></td>
						</tr>
						<tr>
							<td align="center" height="17"><input type="radio" id="graph4s1lineal" name="graph4s1" checked="checked" value="0"></td>
							<td align="center"><input type="radio" id="graph4s1diario" name="graph4s1" value="1"></td>
							<td align="center"><input type="radio" id="graph4s1horario" name="graph4s1" value="2"></td>
						</tr>
						<tr>
							<td align="center" height="17"><input type="radio" id="graph4s2lineal" name="graph4s2" checked="checked" value="0"></td>
							<td align="center"><input type="radio" id="graph4s2diario" name="graph4s2" value="1"></td>
							<td align="center"><input type="radio" id="graph4s2horario" name="graph4s2" value="2"></td>
						</tr>
						<tr>
							<td align="center" height="17"><input type="radio" id="graph2s3lineal" name="graph4s3" checked="checked" value="0"></td>
							<td align="center"><input type="radio" id="graph4s3diario" name="graph4s3" value="1"></td>
							<td align="center"><input type="radio" id="graph4s3horario" name="graph4s3" value="2"></td>
						</tr>
						<tr>
							<td align="center" height="17"><input type="radio" id="graph2s4lineal" name="graph4s4" checked="checked" value="0"></td>
							<td align="center"><input type="radio" id="graph4s4diario" name="graph4s4" value="1"></td>
							<td align="center"><input type="radio" id="graph4s4horario" name="graph4s4" value="2"></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div id="div_espera" style="display:none;width:50%;height:250px;margin-left:300px;margin-top:180px">
			<img id="imagen_esperaDB" src="images/gif_loading.gif" style="width:50px;height:50px;"/>
		</div>
	</div>
	
	<table border="0" width="100%">
	<tr>
		<td align="center">
			<input type="button" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general49']?>" id="bAtras" onclick="vVolverAtras()" style="text-align:center;width:90px;display:none" class="boton_fino"/>
			<input type="button" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general226']?>" id="bGraf" onclick="Rellenar_Informe()" style="text-align:center;width:90px" class="boton_fino"/>
			<input type="button" id="export"  class="boton_fino" style="text-align:center;display:none" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general219']?>"/>
			<input type="button" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general306']?>" id="bGrafZoom" onclick="Nueva_ventana();" style="text-align:center;width:230px;display:none" class="boton_fino_muy_largo"/>			
			<input type="hidden" id='imagen1' name="imagen1"/>
			<input type="hidden" id='imagen1_div' name="imagen1_div"/>
			<input type="hidden" id='imagen1_title' name="imagen1_title"/>
			<input type="hidden" id='imagen2' name="imagen2"/>
			<input type="hidden" id='imagen2_div' name="imagen2_div"/>
			<input type="hidden" id='imagen2_title' name="imagen2_title"/>
			<input type="hidden" id='imagen3' name="imagen3"/>
			<input type="hidden" id='imagen3_div' name="imagen3_div"/>
			<input type="hidden" id='imagen3_title' name="imagen3_title"/>
			<input type="hidden" id='imagen4' name="imagen4"/>
			<input type="hidden" id='imagen4_div' name="imagen4_div"/>
			<input type="hidden" id='imagen4_title' name="imagen4_title"/>
			<input type="hidden" id="allto1"/>
		</td>
	</tr>
	</table>
<script type="text/javascript" >
	$(document).ready(function() {
		tabbar = new dhtmlXTabBar("h_tabbar", "top");
		tabbar.setSkin('dark_blue');
		tabbar.setImagePath("codebase/imgs/");
		AnchoTabAux=document.getElementById('h_tabbar').offsetWidth/4.05;
		tabbar.addTab("h1", "1", AnchoTabAux);
		tabbar.addTab("h2", "2", AnchoTabAux);
		tabbar.addTab("h3", "3", AnchoTabAux);
		tabbar.addTab("h4", "4", AnchoTabAux);
		tabbar.setContent("h1", "params_h_1");
		tabbar.setContent("h2", "params_h_2");
		tabbar.setContent("h3", "params_h_3");
		tabbar.setContent("h4", "params_h_4");
		tabbar.setTabActive("h1");		

		$(function() {
	        $.configureBoxes({
	        	box1View: 'box1View',
	            box1Storage: 'box1Storage',
	            box2View: 'box2View',
	            box2Storage: 'box2Storage',
	            box1Filter: 'box1Filter',
	            box2Filter: 'box2Filter',
	            combo1Filter: 'Filtro_sensores_g1',
	            combo2Filter: 'Filtro_sensores_gX',
	            to1: 'to1',
	            to2: 'to2',
	            allTo1: 'allto1',
	            transferMode: 'move',
	            maxelementos1:4,
	            maxelementos2:0,
	            useFilters: true,
	            useCounters: false
	        });
	        $.configureBoxes({
	        	box1View: 'box3View',
	            box1Storage: 'box3Storage',
	            box2View: 'box4View',
	            box2Storage: 'box4Storage',
	            box1Filter: 'box3Filter',
	            box2Filter: 'box4Filter',
	            combo1Filter: 'Filtro_sensores_g2',
	            combo2Filter: 'Filtro_sensores_gX',
	            to1: 'to3',
	            to2: 'to4',
	            allTo1: 'allto1',
	            transferMode: 'move',
	            maxelementos1:4,
	            maxelementos2:0,
	            useFilters: true,
	            useCounters: false
	        });
	        $.configureBoxes({
	        	box1View: 'box5View',
	            box1Storage: 'box5Storage',
	            box2View: 'box6View',
	            box2Storage: 'box6Storage',
	            box1Filter: 'box5Filter',
	            box2Filter: 'box6Filter',
	            combo1Filter: 'Filtro_sensores_g3',
	            combo2Filter: 'Filtro_sensores_gX',
	            to1: 'to5',
	            to2: 'to6',
	            allTo1: 'allto1',
	            transferMode: 'move',
	            maxelementos1:4,
	            maxelementos2:0,
	            useFilters: true,
	            useCounters: false
	        });
	        $.configureBoxes({
	        	box1View: 'box7View',
	            box1Storage: 'box7Storage',
	            box2View: 'box8View',
	            box2Storage: 'box8Storage',
	            box1Filter: 'box7Filter',
	            box2Filter: 'box8Filter',
	            combo1Filter: 'Filtro_sensores_g4',
	            combo2Filter: 'Filtro_sensores_gX',
	            to1: 'to7',
	            to2: 'to8',
	            allTo1: 'allto1',
	            transferMode: 'move',
	            maxelementos1:4,
	            maxelementos2:0,
	            useFilters: true,
	            useCounters: false
	        });
		});
		if(!document.getElementById("comboInstalaciones"))
		{
			Rellenar_Sensores_Instalacion("box1View", 1 , 1, "box3View","box5View","box7View");
		}
	});
</script>
</body>
</html>
