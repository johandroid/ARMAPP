<?php
define("SK_TIMEOUT", 4);
define("SK_INTENTOS", 50);
define("PATH_SOCKET_COM", "/var/www/rfreenet2_socket");

function conectar($comando)
{
      $socket_unix=@socket_create(AF_UNIX,SOCK_STREAM,0) or die("Could not create socket\r\n");

      if (!@socket_connect($socket_unix, PATH_SOCKET_COM))
      {
	      //echo "ERROR de conexion 0001<br>";
	      $TramaRx="ERROR";
      }
      else
      {
	      @socket_set_option($socket_unix,SOL_SOCKET, SO_RCVTIMEO, array("sec"=>SK_TIMEOUT, "usec"=>0));	      

	      $CadenaTX="$comando\0";
	      $bytesTx=@socket_write($socket_unix,$CadenaTX);
	      if($bytesTx==false)
	      {
		      //echo "ERROR de conexion 0002<br>";
		      $TramaRx="ERROR";
	      }
	      else
		  {
		      //echo "Escrito: ".$bytesTx." bytes\r\n";
		      $bytesRx=1;
		      $bytesRx_acumulados=0;
		      $DatosRX='';
		      $Intentos=0;
		      while ($bytesRx>0)
		      {
			      $bytesRx=@socket_recv($socket_unix,$DatosRX,1024, 0);
			      if ($bytesRx==FALSE)
			      {
				      	if ($bytesRx_acumulados>0)
					    {
							$bytesRx=0;
							//echo "Trama: ".$DatosRX."<br>";
					    }
					    else
					    {
						    if ($Intentos<SK_INTENTOS)
						    {
								$bytesRx=1;
								$Intentos++;
								//echo "Trama: ".$DatosRX."<br>";
						    }
						    else
						    {
							    //echo "ERROR: Recibido3 ".$bytesRx."\r\n";
							    //echo "ERROR de Timeout<br>";
							    $TramaRx="Timeout";
							  	$bytesRx=-1;
						    }
				    	}
			      	//echo "ERROR: ".socket_strerror(socket_last_error($socket_unix))."<br>";
			      }
			      else if($bytesRx==0)
			      {
				      if ($bytesRx_acumulados>0)
				      {
						  $bytesRx=0;
						  //echo "Trama: ".$DatosRX."<br>";
				      }
				      else
				      {
					    //echo "ERROR: Recibido3 ".$bytesRx."\r\n";
					    //echo "ERROR de Timeout<br>";
					    $TramaRx="Timeout";
					    $bytesRx=-1;
				      }
			      }
			      else if ($bytesRx>0)
			      {
					  $bytesRx_acumulados+=$bytesRx;
					  $TramaRx.=$DatosRX;
					  //echo "Recibido: ".$bytesRx." bytes<br>";
					  //echo "Recibido Total: ".$bytesRx_acumulados." bytes<br>";
					  //echo "Trama: ".$DatosRX."<br>";
			      }
		      }
		  }
      }
      socket_close($socket_unix);
      /*
      if ($TramaRx='')
      {
		$TramaRx="ERROR";
      }
      */
      return $TramaRx;
}

function conectar_noresponse($comando)
{
      $socket_unix=@socket_create(AF_UNIX,SOCK_STREAM,0) or die("Could not create socket\r\n");

      if (!@socket_connect($socket_unix, PATH_SOCKET_COM))
      {
	      //echo "ERROR de conexion 0001<br>";
	      $TramaRx="ERROR";
      }
      else
      {
	      @socket_set_option($socket_unix,SOL_SOCKET, SO_RCVTIMEO, array("sec"=>SK_TIMEOUT, "usec"=>0));	      

	      $CadenaTX="$comando\0";
	      $bytesTx=@socket_write($socket_unix,$CadenaTX);
	      if($bytesTx==false)
	      {
		      //echo "ERROR de conexion 0002<br>";
		      $TramaRx="ERROR";
	      }
	      else
	      {
		      $TramaRx="OK";
	      }
      }
      //sleep(2);
      socket_close($socket_unix);
      /*
	  if ($TramaRx='')
      {
		$TramaRx="ERROR";
      }
      */
      return $TramaRx;
}

function conectar_reintentos($sComando,$reintentos)
{
	$fin = 0;
	$vueltas = 0;
	$sTramaLeida = "ERROR";
	
	//echo "Vamos a empezar el while<br>";
	while(($fin==0) && ($vueltas < $reintentos))
	{
		//echo "Intentando conectar<br>";
		$sTramaLeida=conectar($sComando);
		//echo $sTramaLeida." vez ".$vueltas."<br>";
		if($sTramaLeida != 'Timeout' && $sTramaLeida != 'ERROR')
		{
			$fin = 1;
		}
		
		$vueltas++;
	}
	//echo "While finalizado<br>";
	return $sTramaLeida;
}

?>
