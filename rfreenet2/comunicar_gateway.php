<?php
	  define("SK_TIMEOUT", 10);
	  define("PATH_SOCKET_COM", "/var/www/rfreenet2_socket");

	  $comando=$_GET['comando'];

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
	      //$CadenaTX="M2502IPX158.42.166.142IPY158.42.166.142\0";
	      //$CadenaTX="1";
	      $bytesTx=@socket_write($socket_unix,$CadenaTX);
	      if($bytesTx==false)
	      { 
		      //echo "ERROR: Escrito ".$bytesTx."\r\n";
		      //echo "ERROR de conexion 0002<br>";
		      //echo socket_strerror()."\r\n";
		      $TramaRx="ERROR";
	      }
	      else
	      {
		      //echo "Escrito: ".$bytesTx." bytes\r\n";
		      $bytesRx=1;
		      $bytesRx_acumulados=0;
		      $iRecepciones=0;
		      while ($bytesRx>0)
		      {
		      	  //echo "Recibidos ".$bytesRX."<br>";
			      $bytesRx=@socket_recv($socket_unix,$DatosRX,1024, 0);
			      $iRecepciones++;
			      if($bytesRx==false)
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
					    //echo socket_strerror()."\r\n";
				      }
			      }
			      else if ($bytesRx!=0)
			      {
				      //if ($iRecepciones>2)
				      //{
						  $bytesRx_acumulados+=$bytesRx;
						  $TramaRx.=$DatosRX;
						  //echo "Recibido: ".$bytesRx." bytes<br>";
						  //echo "Recibido Total: ".$bytesRx_acumulados." bytes<br>";
						  //echo "Trama: ".$DatosRX."<br>";
				      //}
				      //else
				      //{
				      //	echo "Recepciones -".$iRecepciones."-<br>";
				      //}
			      }
			  }
      		}
      }
	  socket_close($socket_unix);
	  echo $TramaRx;
?>
