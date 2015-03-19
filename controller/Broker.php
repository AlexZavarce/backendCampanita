<?php

    require_once("/FrontController.php"); 


    class Broker {


      function HabilitarServicio() {  
        $webService = $_REQUEST['servicioSolicitado'];
        $objServicios = new FrontController();
            
      	if($webService=='grupo/todos') //Buscar TODOS los grupos 
    		$tiraJson = $objServicios->listarGrupos();
    	elseif($webService=='hipodromo/todos') //Buscar TODOS los hipodromos 
    		$tiraJson = $objServicios->listarHipodromos();
        elseif($webService=='grupopantalla/todos') //Buscar TODOS los hipodromos 
        	$tiraJson = $objServicios->listarGrupoPantalla();
    	elseif($webService=='banco/todos') //Buscar TODOS los hipodromos 
        	{
                $start = $_REQUEST['start'];
                $limit = $_REQUEST['limit'];
                $tiraJson = $objServicios->listarBancos($start,$limit);	
        }
        elseif($webService=='grupo/buscar'){ //Buscar TODOS los hipodromos 
        	$campo = $_REQUEST['campo'];
        	$valor = $_REQUEST['valor'];
        	$tiraJson = $objServicios->buscarGrupo($campo,$valor);	
        }
        elseif($webService=='banco/ingresar'){ 
            $nombre = $_REQUEST['nombre'];
            $estatus = $_REQUEST['estatus'];
            $tiraJson = $objServicios->registrarBanco($nombre,$estatus);
        }
        elseif($webService=='banco/actualizar'){ 
            $id = $_REQUEST['id'];
            $nombre = $_REQUEST['nombre'];
        
            $tiraJson = $objServicios->actualizarBanco($id,$nombre);
        }
        elseif($webService=='banco/eliminar'){ 
            $id = $_REQUEST['id'];
            $tiraJson = $objServicios->eliminarBanco($id);
        }
       elseif ($webService=='usuario/todos'){
            $start = $_REQUEST['start'];
            $limit = $_REQUEST['limit'];
            $tiraJson = $objServicios->listarUsuarios($start,$limit);
        }
       
             elseif ($webService=='usuario/ingresar') {
          
            
            $nombre = $_REQUEST['nombre'];
            $apellido=$_REQUEST['apellido'];
            $foto=$_REQUEST['foto'];
            $telefono = $_REQUEST['telefono'];
            $codigo_area = $_REQUEST['codigo_area'];
            $codigo_operadora=$_REQUEST['codigo_operadora'];
            $celular=$_REQUEST['celular'];
            $correo = $_REQUEST['correo'];
            $login = $_REQUEST['login'];
            $password = $_REQUEST['password'];
            $pregunta_secreta = $_REQUEST['pregunta_secreta'];
            $respuesta_secreta = $_REQUEST['respuesta_secreta'];
            $intentos = $_REQUEST['intentos'];
            $fecha_nacimiento = $_REQUEST['fecha_nacimiento'];
            $estatus = $_REQUEST['estatus'];
            

            $tiraJson = $objServicios-> registrarUsuarios($nombre,$apellido,$fecha_nacimiento,$codigo_area,$telefono,$codigo_operadora,$celular,$correo,$login,$password,$foto,$pregunta_secreta,$respuesta_secreta,$intentos,$estatus);
             }
        elseif ($webService=='usuario/buscar') {
            $login = $_REQUEST['login'];
            $password = $_REQUEST['password'];

            $tiraJson = $objServicios->buscarUsuario($login,$password);
        }
          elseif ($webService=='codigo_telefono/todos') {
            $tiraJson = $objServicios->listarCodigoAreaFijo();
        }
        elseif ($webService=='codigo_celular/todos') {
            $tiraJson = $objServicios->listarCodigoAreaCelular();
        }
             elseif ($webService=='pregunta1/todos') {
            $tiraJson = $objServicios->listarPregunta1();
        }
         elseif ($webService=='pregunta2/todos') {
             $id = $_REQUEST['id'];
            $tiraJson = $objServicios->listarPregunta2($id);
        }
        elseif ($webService=='polla/todos') {
            $estatus = $_REQUEST['estatus'];
            $start = $_REQUEST['start'];
            $limit = $_REQUEST['limit'];
            $tiraJson = $objServicios->listarPollas($estatus,$start,$limit);
        }
        elseif ($webService=='polla/buscar') {
            $id = $_REQUEST['id'];
            $tiraJson = $objServicios->buscarPolla($id);
        }
        elseif ($webService=='polla/ingresar') {
          
            $id_hipodromo = $_REQUEST['id_hipodromo'];
            $id_usuario_creador=$_REQUEST['id_usuario_creador'];
            $fecha_creacion = $_REQUEST['fecha_creacion'];
            $fecha_jugada = $_REQUEST['fecha_jugada'];
            $estatus = $_REQUEST['estatus'];
            $tiraJson = $objServicios->registrarPolla($id_hipodromo,$id_usuario_creador,$fecha_creacion,$fecha_jugada,$estatus);
        }
        elseif ($webService=='polla/actualizar') {
            $id = $_REQUEST['id'];
            $id_hipodromo = $_REQUEST['id_hipodromo'];
            $id_usuario_creador=$_REQUEST['id_usuario_creador'];
            $fecha_creacion = $_REQUEST['fecha_creacion'];
            $fecha_jugada = $_REQUEST['fecha_jugada'];
            $estatus = $_REQUEST['estatus'];
            
            $tiraJson = $objServicios->actualizarPolla($id,$id_hipodromo,$id_usuario_creador,$fecha_creacion,$fecha_jugada,$estatus);
        }
        elseif ($webService=='polla_jugada/todos') {
            $tiraJson = $objServicios->listarPollaJugadas();
        }
        elseif ($webService=='polla_jugada/buscar') {
            $id = $_REQUEST['id'];
            $tiraJson = $objServicios->buscarPollaJugadas($id);
        }elseif($webService=='valida/todos'){
            $start = $_REQUEST['start'];
            $limit = $_REQUEST['limit'];
            $tiraJson = $objServicios->listarValida($start,$limit);
        }elseif($webService=='valida/buscarPollaValida'){
            $id_polla = $_REQUEST['id_polla'];
            $nro_valida = $_REQUEST['nro_valida'];
            $tiraJson = $objServicios->buscarValida($id_polla,$nro_valida);
        }elseif($webService=='valida/buscarPolla'){
            $id_polla = $_REQUEST['id_polla'];
            $tiraJson = $objServicios->buscarValidaPolla($id_polla);
        }elseif ($webService=='valida/ingresar') {
            $id_polla =$_REQUEST['id_polla'];
            $nro_valida =$_REQUEST['nro_valida'];
            $primero =$_REQUEST['primero'];
            $segundo =$_REQUEST['segundo'];
            $tercero =$_REQUEST['tercero'];
            $estatus =$_REQUEST['estatus'];
            $tiraJson = $objServicios->registrarValida($id_polla, $nro_valida, $primero, $segundo, $tercero, $estatus);
        }
        else 
     		$tiraJson = '{ "success": "true", "exito": "false", "msg": "No hay datos!" }'; 

        print_r($tiraJson);
        return true;
      }

    }

    $objBroker = new Broker();
    $objBroker->HabilitarServicio();
?>