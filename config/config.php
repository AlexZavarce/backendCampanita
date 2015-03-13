<?php
/**
 * Fichero de configuración, que se incluye en cada una de las paginas.
 * Realiza la conexion a la base de datos y contiene algunas funciones
 */
class Conexion{

		// var	$host='localhost';
		// var	$usuario="root";
		// var	$root="";
		// var	$bd="campanita2";
		// var	$numeroRegistros=10;
		
		function __construct(){	
		
		
		}


		function iniciarSesion()
		{
			session_start();
		}
		# determina el total de registros a mostrar por pagina en el listado de usuarios
		

		function conectarBD()
		{
				# conectamos con la base de datos
				// Conectando, seleccionando la base de datos
				$link = mysql_connect('localhost:8080', 'root', '')
				    or die('No se pudo conectar: ' . mysql_error());
				echo 'Connected successfully';
				mysql_select_db('campanita2') or die('No se pudo seleccionar la base de datos');
				return $link;
		}

		

		/**
		 * Funcion que codifica una contraseña en md5 utilizando una semilla
		 * Tiene que recibir la contraseña en claro
		 * Devuelve la contraseña codificafa en md5 con semilla
		 */
		function returnPass($passwordUser)
		{
			$seed="LaCasaAzul";
			return md5($passwordUser.$seed);
		}

}		
?>
