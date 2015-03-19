<?php

require_once dirname(__FILE__) . "/../config/ActiveRecord.php";


	// initialize ActiveRecord
	ActiveRecord\Config::initialize(function($cfg)
	{
	    $cfg->set_model_directory(dirname(__FILE__) . "/../model");
	    $cfg->set_connections(array("development" => "mysql://root:1234@127.0.0.1/campanita2"));

	});

 


class FrontController {
	
	function listarGrupos(){
		$result = array();
		$grupos = Grupo::all();
		$cant = Grupo::count();
		if ($cant > 0) {
				$i=0;
				$tirajson='{"success": "1", "exito": "1","grupos":[';

				foreach ($grupos as $p) {
					$i++;
					if ($i<$cant){
					 	$tirajson = $tirajson .' {"id": '. $p->id.',';
						$tirajson = $tirajson.'"nombre": "'. $p->nombre.'",';
						$tirajson = $tirajson.'"estatus": '. $p->estatus.'},';
					}
					else{
					 	$tirajson =  $tirajson .'{ id": '. $p->id.',';
						$tirajson = $tirajson.'" nombre": "'. $p->nombre.'",';
						$tirajson = $tirajson.'" estatus": '. $p->estatus.' }';
					}
				//echo $p->person->name;
				}
					$tirajson= $tirajson .']};';
				//echo $json;
		}
		 else
		    $tirajson = '{ "success": "1", "exito": "1", "msg": "No hay datos!" }'; 

		return $tirajson;
	}


	function buscarGrupo($campo,$valor){
		$result = array();
		$obj = Grupo::find_by_sql("select * from grupos where ".$campo.'='.$valor );
		$cant = Grupo::count(array("conditions" => $campo."=". $valor));
		if ($cant > 0) {
				$i=0;
				
				foreach ($obj as $p) {
						$arreglo[$i]=array(	
							'id'  => $p->id ,
							'nombre'  => $p->nombre ,
							'estatus' => $p->estatus
						);

						$i++;
					}

						$resultado= array (
							'success' => 'true',
							'exito' => 'true',
							'grupo' => $arreglo
						);
						
						$tirajson= json_encode($resultado);
			}
			else
		    	$tirajson = "{ 'success': 'true', 'exito': 'false', 'msg': 'No hay datos!' }"; 

		return $tirajson;
	}

	//este hay que actualizarlo
	function listarHipodromos(){
		$result = array();
		$obj = Hipodromo::all();
		$cant = Hipodromo::count();
		if ($cant > 0) {
				$i=0;
				$tirajson='{"success": "1", "exito": "1","hipodromos":[';

				foreach ($obj as $p) {
					$i++;
					if ($i<$cant){
					 	$tirajson = $tirajson .' {"id": '. $p->id.',';
						$tirajson = $tirajson.'"nombre": "'. $p->nombre.'",';
						$tirajson = $tirajson.'" direccion": "'. $p->direccion.'",';
						$tirajson = $tirajson.'"estatus": '. $p->estatus.'},';
					}
					else{
					 	$tirajson =  $tirajson .'{ id": '. $p->id.',';
						$tirajson = $tirajson.'" nombre": "'. $p->nombre.'",';
						$tirajson = $tirajson.'" direccion": "'. $p->direccion.'",';
						$tirajson = $tirajson.'" estatus": '. $p->estatus.' }';
					}
				//echo $p->person->name;
				}
				$tirajson= $tirajson .']};';
				//echo $json;
		}
		 else
		    $tirajson = '{ "success": "1", "exito": "1", "msg": "No hay datos!" }';
		return $tirajson;
	}




	function listarGrupoPantalla(){
		$obj = Grupopantalla::all();
		$cant = Grupopantalla::count();
		$pantalla = array();
		$grupo = array();
		if ($cant > 0) {
				$i=0;
					foreach ($obj as $p) {
						
						$obj2 = Grupo::all(array("conditions" => "id=". $p->id_grupo));
						$cant2 = Grupo::count(array("conditions" => "id=". $p->id_grupo));
						$obj3 = Pantalla::all(array("conditions" => "id=". $p->id_pantalla));
						$cant3 = Pantalla::count(array("conditions" => "id=". $p->id_pantalla));
						
						if ($cant2 > 0) {
							$i2=0;
							foreach ($obj2 as $p2) {
								$i2++;
								
								 	$grupo = array(
										'id' => $p2->id,
										'nombre' => $p2->nombre,
										'estatus' => $p2->estatus
									);
								
							}
						};
						

						if ($cant3 > 0) {
							$i3=0;
							
							foreach ($obj3 as $p3) {
								$i3++;
										$pantalla = array(
											'id' => $p3->id,
											'nombre' => $p3->nombre,
											'estatus' => $p3->estatus
							);
						};


						$arreglo = array(
							'grupos' => $grupo,
							'pantalla' => $pantalla
						);

						$resultado[$i] = array(
							'grupopantallas' => $arreglo
						);
					
						$i++;		
					};

						$datos = array(
							'success' => 'true',
							'exito' => 'true',
							'datos' => $resultado
						);

					$tirajson= json_encode($datos);
				 }
		}
		else
		    $tirajson = '{ "success": "true", "exito": "false", "msg": "No hay datos!" }';

		return $tirajson;
	}

	//CRUD DE BANCOS
	function listarBancos($start,$limit){
		
		if($limit!=0){
			$obj = Banco::find_by_sql("SELECT * FROM bancos WHERE estatus != 0 LIMIT $start,  $limit");
			$cant = Banco::count(array("conditions" => "estatus != 0"));
			if ($cant > 0) {
					$i=0;
					$tirajson='';
					foreach ($obj as $p) {
						$arreglo[$i]=array(	
							'id'  => $p->id ,
							'nombre'  => $p->nombre ,
							'estatus' => $p->estatus
						);

						$i++;
					}

						$resultado= array (
							'success' => 'true',
							'exito' => 'true',
							'total' => $cant,
							'bancos' => $arreglo
						);
						
						$tirajson= json_encode($resultado);
			}
			 else
				$tirajson = '{ "success": "1", "exito": "1", "msg": "No hay datos!" }';
	
		}
		else{
			$obj = Banco::find_by_sql("SELECT * FROM bancos WHERE estatus != 0");
			$cant = Banco::count(array("conditions" => "estatus != 0"));
			if ($cant > 0) {
					$i=0;
					$tirajson='';
					foreach ($obj as $p) {
						$arreglo[$i]=array(	
							'id'  => $p->id ,
							'nombre'  => $p->nombre ,
							'estatus' => $p->estatus
						);

						$i++;
					}

						$resultado= array (
							'success' => 'true',
							'exito' => 'true',
							'total' => $cant,
							'bancos' => $arreglo
						);
						
						$tirajson= json_encode($resultado);
			}
			 else
				$tirajson = '{ "success": "1", "exito": "1", "msg": "No hay datos!" }';

		}

			return $tirajson;
	}

	function registrarBanco($nombre,$estatus){
			
		if($nombre == '')
			$tirajson = '{ "success": "true", "exito": "true", "msg": "Error! Por Favor Llene todos los Campos" }';
		else{
			$banco = new Banco();
		   	$banco->nombre = ereg_replace( '/ +/', " ", $nombre );
		   	$banco->estatus = $estatus;
		   	$banco->save();
		   	$tirajson = '{ "success": "true", "exito": "true", "msg": "Banco Registrador Exitosamente!" }';
	   	}
		
		return $tirajson;

	}


	function actualizarBanco($id,$nombre){
			
		$banco = Banco::find($id);
	   	$banco->nombre = ereg_replace( '-', " ", $nombre );;
	   	
	   	$banco->save();
	   	$tirajson = '{ "success": "true", "exito": "true", "msg": "Banco Actualizado Exitosamente!" }';

		
		return $tirajson;

	}

	function eliminarBanco($id){
			
		$banco = Banco::find($id);
	   	$banco->estatus = 0;
	   	$banco->save();
	   	$tirajson = '{ "success": "true", "exito": "true", "msg": "Banco Eliminado Exitosamente!" }';

		
		return $tirajson;
	}
 
 	
	//CRUB DE USUARIO
	//CRUD DE USUARIO
 	function listarUsuarios($start,$limit){
	
		if($limit!=0){	
			$obj = Usuario::find_by_sql("SELECT * FROM usuarios WHERE estatus != 0 LIMIT $start,  $limit");
			$cant = Usuario::count(array("conditions" => "estatus != 0"));

			if ($cant > 0) {
					$i=0;
					foreach ($obj as $p) {
						
						//Se buscan los grupos asociados a ese usuario	
						$obj2 = Grupo::all(array("conditions" => "id=". $p->id_grupo));
						$cant2 = Grupo::count(array("conditions" => "id=". $p->id_grupo));
						
						//Se buscan las Cuentas asociados a ese usuario
						$obj3 = Cuenta::all(array("conditions" => "id=". $p->id_cuenta));
						$cant3 = Cuenta::count(array("conditions" => "id=". $p->id_cuenta));
						
						if ($cant2 > 0) {
							$i2=0;
							foreach ($obj2 as $p2) {
								
								
								 	$grupo = array(
										'id' => $p2->id,
										'nombre' => $p2->nombre,
										'estatus' => $p2->estatus
									);
									$i2++;
							}
						};
						

						if ($cant3 > 0) {
							$i3=0;
							
							foreach ($obj3 as $p3) {
								
									
									//Se buscan los Bancos asociados a esa Cuenta
									$obj4 = Banco::all(array("conditions" => "id=". $p3->id_banco));
									$cant4 = Banco::count(array("conditions" => "id=". $p3->id_banco));
									$i4=0;
									foreach ($obj4 as $p4) {

										$bancos = array(
											'id' => $p4->id,
											'nombre' => $p4->nombre,
											'estatus' => $p4->estatus
										);

										$i4++;

									}	

									$cuentas = array(
										'id' => $p3->id,
										'bancos' => $bancos,
										'nro_cuenta' => $p3->nro_cuenta,
										'estatus' => $p3->estatus
									);
									$i3++;
									
							};


							$arreglo = array(
								'id' => $p->id,
								'grupos' => $grupo,
								'cuentas' => $cuentas,
								'nombre' => $p->nombre,
								'apellido' => $p->apellido,
								'fecha_nacimiento' => $p->fecha_nacimiento,
								'codigo_area' => $p->codigo_area,
								'telefono' => $p->telefono,
								'correo' => $p->correo,
								'login' => $p->login,
								'password' => $p->password,
								'foto' => $p->foto,
								'pregunta_secreta' => $p->pregunta_secreta,
								'respuesta_secreta' => $p->respuesta_secreta,
								'intentos' => $p->intentos,
								'estatus' => $p->estatus

							);

							$resultado[$i] = array(
								'usuarios' => $arreglo
							);
						
							$i++;		
						};

						$datos = array(
							'success' => 'true',
							'exito' => 'true',
							'datos' => $resultado
						);

					$tirajson= json_encode($datos);
					}
			}
			else
			    $tirajson = '{ "success": "true", "exito": "false", "msg": "No hay datos!" }';
		}
		else{

			$obj = Usuario::find_by_sql("SELECT * FROM usuarios WHERE estatus != 0");
			$cant = Usuario::count(array("conditions" => "estatus != 0"));

			if ($cant > 0) {
					$i=0;
					foreach ($obj as $p) {
						
						//Se buscan los grupos asociados a ese usuario	
						$obj2 = Grupo::all(array("conditions" => "id=". $p->id_grupo));
						$cant2 = Grupo::count(array("conditions" => "id=". $p->id_grupo));
						
						//Se buscan las Cuentas asociados a ese usuario
						$obj3 = Cuenta::all(array("conditions" => "id=". $p->id_cuenta));
						$cant3 = Cuenta::count(array("conditions" => "id=". $p->id_cuenta));
						
						if ($cant2 > 0) {
							$i2=0;
							foreach ($obj2 as $p2) {
								
								
								 	$grupo = array(
										'id' => $p2->id,
										'nombre' => $p2->nombre,
										'estatus' => $p2->estatus
									);
									$i2++;
							}
						};
						

						if ($cant3 > 0) {
							$i3=0;
							
							foreach ($obj3 as $p3) {
								
									
									//Se buscan los Bancos asociados a esa Cuenta
									$obj4 = Banco::all(array("conditions" => "id=". $p3->id_banco));
									$cant4 = Banco::count(array("conditions" => "id=". $p3->id_banco));
									$i4=0;
									foreach ($obj4 as $p4) {

										$bancos = array(
											'id' => $p4->id,
											'nombre' => $p4->nombre,
											'estatus' => $p4->estatus
										);

										$i4++;

									}	

									$cuentas = array(
										'id' => $p3->id,
										'bancos' => $bancos,
										'nro_cuenta' => $p3->nro_cuenta,
										'estatus' => $p3->estatus
									);
									$i3++;
									
							};


							$arreglo = array(
								'id' => $p->id,
								'grupos' => $grupo,
								'cuentas' => $cuentas,
								'nombre' => $p->nombre,
								'apellido' => $p->apellido,
								'fecha_nacimiento' => $p->fecha_nacimiento,
								'codigo_area' => $p->codigo_area,
								'telefono' => $p->telefono,
								'correo' => $p->correo,
								'login' => $p->login,
								'password' => $p->password,
								'foto' => $p->foto,
								'pregunta_secreta' => $p->pregunta_secreta,
								'respuesta_secreta' => $p->respuesta_secreta,
								'intentos' => $p->intentos,
								'estatus' => $p->estatus

							);

							$resultado[$i] = array(
								'usuarios' => $arreglo
							);
						
							$i++;		
						};

						$datos = array(
							'success' => 'true',
							'exito' => 'true',
							'datos' => $resultado
						);

					$tirajson= json_encode($datos);
					}
			}
			else
			    $tirajson = '{ "success": "true", "exito": "false", "msg": "No hay datos!" }';
		

		}

		return $tirajson;
	}

	
function registrarUsuarios($cedula,
	 	                        $id_grupo,$id_cuenta,
	 	                        $nombre,$apellido,
	 	                        $fecha_nacimiento,
	 	                        $codigo_area,$telefono,
	 	                        $codigo_operadora,$celular,
	 	                        $correo,$login,$password,
	 	                        $foto,
	 	                        $pregunta_secreta,$respuesta_secreta,
	 	                        $intentos,$estatus){
		

          if ($cedula==''||$id_grupo==''||$id_cuenta==''||$nombre==''||$apellido==''||$fecha_nacimiento==''||
        	  $codigo_area==''||$telefono==''||$codigo_operadora==''||$celular==''||$correo==''||$login==''||
        	  $password==''||$foto==''||$pregunta_secreta==''||$respuesta_secreta==''||$intentos=='') 

	 	    $tirajson = '{ "success": "true", "exito": "true", "msg": "Error! Por Favor Llene todos los Campos" }';
	 	 
	 	  else{
	 	
	 		$usuario = new Usuario();
	 	   	 $usuario->cedula=$cedula;
             $usuario->id_grupo=$id_grupo;
             $usuario->id_cuenta=$id_cuenta;
             $usuario->nombre=ereg_replace( '/ +/', " ", $nombre );
             $usuario->apellido = ereg_replace( '/ +/', " ", $apellido );
             $usuario->fecha_nacimiento=$fecha_nacimiento;
             $usuario->codigo_area=$codigo_area;
             $usuario->telefono=$telefono;
             $usuario->codigo_operadora=$codigo_operadora; 
             $usuario->celular=$celular;
             $usuario->correo=$correo; 
             $usuario->login=$login;
             $usuario->password=$password;
             $usuario->foto=$foto;
             $usuario->pregunta_secreta = ereg_replace( '/ +/', " ", $pregunta_secreta );
	       	 $usuario->respuesta_secreta = ereg_replace( '/ +/', " ", $respuesta_secreta );
             $usuario->intentos=$intentos;
             $usuario->estatus=$estatus;

	 	   	$usuario->save();
	 	   	$tirajson = '{ "success": "true", "exito": "true", "msg": "Usuario Registrado Exitosamente!" }';
	    	}
		
	 	return $tirajson;

	 }


	function actualizarUsuarios($id,$id_grupo,$id_cuenta,$nombre,$apellido,$fecha_nacimiento,$codigo_area,$telefono,$correo,$login,$password,$foto,$pregunta_secreta,$respuesta_secreta,$intentos){
	 	  
		if ($id==''||$cedula==''||$id_grupo==''||$id_cuenta==''||$nombre==''||$apellido==''||$fecha_nacimiento==''||
        	  $codigo_area==''||$telefono==''||$codigo_operadora==''||$celular==''||$correo==''||$login==''||
        	  $password==''||$foto==''||$pregunta_secreta==''||$respuesta_secreta==''||$intentos==''){ 

	 	    $tirajson = '{ "success": "true", "exito": "true", "msg": "Error! Por Favor Llene todos los Campos" }';
		}
		else{
	        $usuario = Usuario::find($id);

			$usuario->cedula=$cedula;
			$usuario->id_grupo=$id_grupo;
			$usuario->id_cuenta=$id_cuenta;
			$usuario->nombre=ereg_replace( '/ +/', " ", $nombre );
			$usuario->apellido = ereg_replace( '/ +/', " ", $apellido );
			$usuario->fecha_nacimiento=$fecha_nacimiento;
			$usuario->codigo_area=$codigo_area;
			$usuario->telefono=$telefono;
			$usuario->codigo_operadora=$codigo_operadora; 
			$usuario->celular=$celular;
			$usuario->correo=$correo; 
			$usuario->login=$login;
			$usuario->password=$password;
			$usuario->foto=$foto;
			$usuario->pregunta_secreta = ereg_replace( '/ +/', " ", $pregunta_secreta );
			 $usuario->respuesta_secreta = ereg_replace( '/ +/', " ", $respuesta_secreta );
			$usuario->intentos=$intentos;
			$usuario->estatus=$estatus;

		   	

		   	$usuario->save();
		   	$tirajson = '{ "success": "true", "exito": "true", "msg": " Usuario Actualizado Exitosamente!" }';
 		}
			
	 	return $tirajson;

  	}

	function buscarUsuario($login,$password){
			

		$obj = Usuario::find_by_sql("SELECT * FROM usuarios WHERE estatus != 0 and login='".$login."' and password='".$password."'");
		$cant = Usuario::count(array("conditions" => "estatus != 0"));

		if ($cant > 0) {
				$i=0;
				foreach ($obj as $p) {
					
					//Se buscan los grupos asociados a ese usuario	
					$obj2 = Grupo::all(array("conditions" => "id=". $p->id_grupo));
					$cant2 = Grupo::count(array("conditions" => "id=". $p->id_grupo));
					
					//Se buscan las Cuentas asociados a ese usuario
					$obj3 = Cuenta::all(array("conditions" => "id=". $p->id_cuenta));
					$cant3 = Cuenta::count(array("conditions" => "id=". $p->id_cuenta));
					
					if ($cant2 > 0) {
						$i2=0;
						foreach ($obj2 as $p2) {
							
							
							 	$grupo[$i2] = array(
									'id' => $p2->id,
									'nombre' => $p2->nombre,
									'estatus' => $p2->estatus
								);
								$i2++;
						}
					};
					

					if ($cant3 > 0) {
						$i3=0;
						
						foreach ($obj3 as $p3) {
							
								
								//Se buscan los Bancos asociados a esa Cuenta
								$obj4 = Banco::all(array("conditions" => "id=". $p3->id_banco));
								$cant4 = Banco::count(array("conditions" => "id=". $p3->id_banco));
								$i4=0;
								foreach ($obj4 as $p4) {

									$bancos[$i4] = array(
										'id' => $p4->id,
										'nombre' => $p4->nombre,
										'estatus' => $p4->estatus
									);

									$i4++;

								}	

								$cuentas[$i3] = array(
									'id' => $p3->id,
									'bancos' => $bancos,
									'nro_cuenta' => $p3->nro_cuenta,
									'estatus' => $p3->estatus
								);
								$i3++;
								
						};


						$arreglo = array(
							'id' => $p->id,
							'grupos' => $grupo,
							'cuentas' => $cuentas,
							'nombre' => $p->nombre,
							'apellido' => $p->apellido,
							'fecha_nacimiento' => $p->fecha_nacimiento,
							'codigo_area' => $p->codigo_area,
							'telefono' => $p->telefono,
							'correo' => $p->correo,
							'login' => $p->login,
							'password' => $p->password,
							'foto' => $p->foto,
							'pregunta_secreta' => $p->pregunta_secreta,
							'respuesta_secreta' => $p->respuesta_secreta,
							'intentos' => $p->intentos,
							'estatus' => $p->estatus

						);

						$resultado[$i] = array(
							'usuarios' => $arreglo
						);
					
						$i++;		
					};

					$datos = array(
						'success' => 'true',
						'exito' => 'true',
						'datos' => $resultado
					);

				$tirajson= json_encode($datos);
				}
		}
		else
		    $tirajson = '{ "success": "true", "exito": "false", "msg": "No hay datos!" }';


		return $tirajson;
	}

	function listarCodigoAreaFijo(){
			$obj = Codigo_Telefono::find_by_sql("SELECT * FROM codigo_telefonos WHERE estatus = 1");
			$cant = Codigo_Telefono::count(array("conditions" => "estatus = 1"));
			if ($cant > 0) {
					$i=0;
					$tirajson='';
					foreach ($obj as $p) {
						$arreglo[$i]=array(	
							'id'  => $p->id ,
							'codigo'  => $p->codigo,
							'estatus' => $p->estatus
						);

						$i++;
					}

						$resultado= array (
							'success' => 'true',
							'exito' => 'true',
							'total' => $cant,
							'codigo_area_fijo' => $arreglo
						);
						
						$tirajson= json_encode($resultado);
			}
			 else
				$tirajson = '{ "success": "1", "exito": "1", "msg": "No hay datos!" }';
	
			return $tirajson;
	}


	function listarCodigoAreaCelular(){
			$obj = Codigo_Telefono::find_by_sql("SELECT * FROM codigo_telefonos WHERE estatus = 2");
			$cant = Codigo_Telefono::count(array("conditions" => "estatus = 2"));
			if ($cant > 0) {
					$i=0;
					$tirajson='';
					foreach ($obj as $p) {
						$arreglo[$i]=array(	
							'id'  => $p->id ,
							'codigo'  => $p->codigo,
							'estatus' => $p->estatus
						);

						$i++;
					}

						$resultado= array (
							'success' => 'true',
							'exito' => 'true',
							'total' => $cant,
							'codigo_area_fijo' => $arreglo
						);
						
						$tirajson= json_encode($resultado);
			}
			 else
				$tirajson = '{ "success": "1", "exito": "1", "msg": "No hay datos!" }';
	
			return $tirajson;
	}



	function listarPregunta1(){
			$obj = Pregunta::find_by_sql("SELECT * FROM preguntas WHERE estatus = 1");
			$cant = Pregunta::count(array("conditions" => "estatus = 1"));
			if ($cant > 0) {
					$i=0;
					$tirajson='';
					foreach ($obj as $p) {
						$arreglo[$i]=array(	
							'id'  => $p->id ,
							'descripcion'  => $p->descripcion,
							'estatus' => $p->estatus
						);

						$i++;
					}

						$resultado= array (
							'success' => 'true',
							'exito' => 'true',
							'total' => $cant,
							'preguntas' => $arreglo
						);
						
						$tirajson= json_encode($resultado);
			}
			 else
				$tirajson = '{ "success": "1", "exito": "1", "msg": "No hay datos!" }';
	
			return $tirajson;
	}

	function listarPregunta2($id){
			$obj = Pregunta::find_by_sql("SELECT * FROM preguntas WHERE estatus = 1 and id!=".$id);
			$cant = Pregunta::count(array("conditions" => "estatus = 1 and id!=".$id));
			if ($cant > 0) {
					$i=0;
					$tirajson='';
					foreach ($obj as $p) {
						$arreglo[$i]=array(	
							'id'  => $p->id ,
							'descripcion'  => $p->descripcion,
							'estatus' => $p->estatus
						);

						$i++;
					}

						$resultado= array (
							'success' => 'true',
							'exito' => 'true',
							'total' => $cant,
							'preguntas' => $arreglo
						);
						
						$tirajson= json_encode($resultado);
			}
			 else
				$tirajson = '{ "success": "1", "exito": "1", "msg": "No hay datos!" }';
	
			return $tirajson;
	}



	//CRUB DE POLLA
	function listarPollas($estatus,$start,$limit){
		$obj = Polla::find_by_sql("SELECT * FROM pollas WHERE estatus= $estatus LIMIT $start,  $limit");
		$cant = Polla::count(array("conditions" => "estatus= $estatus"));
		$pantalla = array();
		$grupo = array();
		if ($cant > 0) {
				$i=0;
					foreach ($obj as $p) {
						
						$obj2 = Hipodromo::all(array("conditions" => "id=". $p->id_hipodromo));
						$cant2 = Hipodromo::count(array("conditions" => "id=". $p->id_hipodromo));
						$obj3 = Usuario::all(array("conditions" => "id=". $p->id_usuario_creador));
						$cant3 = Usuario::count(array("conditions" => "id=". $p->id_usuario_creador));
						
						if ($cant2 > 0) {
							$i2=0;
							foreach ($obj2 as $p2) {
								$i2++;
								
								 	$hipodromos = array(
										'id' => $p2->id,
										'nombre' => $p2->nombre,
										'direccion' => $p2->direccion,
										'estatus' => $p2->estatus
									);
								
							}
						};
						

						if ($cant3 > 0) {
							$i3=0;
							
							foreach ($obj3 as $p3) {
								$i3++;
										$usuarios = $this->listarUsuario($p3->id);
						};


						$arreglo = array(
							'id' => $p->id,
							'hipodromos' => $hipodromos,
							'usuarios' => $usuarios,
							'fecha_creacion' => $p->fecha_creacion,
							'fecha_jugada' => $p->fecha_jugada,
							'estatus' => $p->estatus
						);

						$resultado[$i] = array(
							'pollas' => $arreglo
						);
					
						$i++;		
					};

						$datos = array(
							'success' => 'true',
							'exito' => 'true',
							'datos' => $resultado
						);

					$tirajson= json_encode($datos);
				 }
		}
		else
		    $tirajson = '{ "success": "true", "exito": "false", "msg": "No hay datos!" }';

		return $tirajson;
	}

	function buscarPolla($id){
		$obj = Polla::all(array("conditions" => "estatus != 0 and id=".$id));
		$cant = Polla::count(array("conditions" => "estatus != 0 and id=".$id));
		if ($cant > 0) {
				$i=0;
					foreach ($obj as $p) {
						
						$obj2 = Hipodromo::all(array("conditions" => "id=". $p->id_hipodromo));
						$cant2 = Hipodromo::count(array("conditions" => "id=". $p->id_hipodromo));
						$obj3 = Usuario::all(array("conditions" => "id=". $p->id_usuario_creador));
						$cant3 = Usuario::count(array("conditions" => "id=". $p->id_usuario_creador));
						
						if ($cant2 > 0) {
							$i2=0;
							foreach ($obj2 as $p2) {
								$i2++;
								
								 	$hipodromos = array(
										'id' => $p2->id,
										'nombre' => $p2->nombre,
										'direccion' => $p2->direccion,
										'estatus' => $p2->estatus
									);
								
							}
						};
						

						if ($cant3 > 0) {
							$i3=0;
							
							foreach ($obj3 as $p3) {
								$i3++;
										$usuarios = $this->listarUsuario($p3->id);
						};


						$arreglo = array(
							'id' => $p->id,
							'hipodromos' => $hipodromos,
							'usuarios' => $usuarios,
							'fecha_creacion' => $p->fecha_creacion,
							'fecha_jugada' => $p->fecha_jugada,
							'estatus' => $p->estatus
						);

						$resultado[$i] = array(
							'Polla' => $arreglo
						);
					
						$i++;		
					};

						$datos = array(
							'success' => 'true',
							'exito' => 'true',
							'datos' => $resultado
						);

					$tirajson= json_encode($datos);
				 }
		}
		else
		    $tirajson = '{ "success": "true", "exito": "false", "msg": "No hay datos!" }';

		return $tirajson;
	}

	function registrarPolla($id_hipodromo,$id_usuario_creador,$fecha_creacion,$fecha_jugada,$estatus){
		

		if ($id_hipodromo==''||$id_usuario_creador==''||$fecha_creacion==''||$fecha_jugada==''||$estatus=='') 
			$tirajson = '{ "success": "true", "exito": "true", "msg": "Error! Por Favor Llene todos los Campos" }';
		else{

			$polla = new Polla();
			$polla->id_hipodromo=$id_hipodromo;
			$polla->id_usuario_creador=$id_usuario_creador;
			$polla->fecha_creacion=$fecha_creacion;
			$polla->fecha_jugada=$fecha_jugada;
			$polla->estatus=$estatus;

			$polla->save();
			$tirajson = '{ "success": "true", "exito": "true", "msg": "Polla Registrada Exitosamente!" }';
		}

		return $tirajson;

	}

	function actualizarPolla($id,$id_hipodromo,$id_usuario_creador,$fecha_creacion,$fecha_jugada,$estatus){
		
		if ($id==''||$id_hipodromo==''||$id_usuario_creador==''||$fecha_creacion==''||$fecha_jugada==''||$estatus==''){ 
	 	    $tirajson = '{ "success": "true", "exito": "true", "msg": "Error! Por Favor Llene todos los Campos" }';
		}
		else{
	        $polla = Polla::find($id);
			$polla->id_hipodromo=$id_hipodromo;
			$polla->id_usuario_creador=$id_usuario_creador;
			$polla->fecha_creacion=$fecha_creacion;
			$polla->fecha_jugada=$fecha_jugada;
			$polla->estatus=$estatus;

			$polla->save();
			$tirajson = '{ "success": "true", "exito": "true", "msg": "Polla Registrada Exitosamente!" }';
		}		
	 	return $tirajson;

  	}

	//CRUB DE POLLA JUGADA
	function listarPollaJugadas(){
		$obj = Polla_jugada::all(array("conditions" => "estatus != 0"));

		$cant = Polla_jugada::count(array("conditions" => "estatus != 0"));
		$pantalla = array();
		$grupo = array();
		if ($cant > 0) {
				$i=0;
					foreach ($obj as $p) {
						
						$obj2 = Polla::all(array("conditions" => "id=". $p->id_polla));
						$cant2 = Polla::count(array("conditions" => "id=". $p->id_polla));
						$obj3 = Usuario::all(array("conditions" => "id=". $p->id_usuario_creador));
						$cant3 = Usuario::count(array("conditions" => "id=". $p->id_usuario_creador));
						$obj4 = Puntuacione::all(array("conditions" => "id=". $p->id_puntuacion));
						$cant4 = Puntuacione::count(array("conditions" => "id=". $p->id_puntuacion));
						
						if ($cant2 > 0) {
							$i2=0;
							foreach ($obj2 as $p2) {
								$i2++;
								
								 	$polla = $this->listarPolla($p2->id);
								
							}
						};

						if ($cant4 > 0) {
							$i2=0;
							foreach ($obj4 as $p4) {
								$i2++;
								
								 	$puntuacion = array(
										'id' => $p4->id,
										'lugar' => $p4->lugar,
										'punto' => $p4->punto,
										'descripcion' => $p4->descripcion,
										'estatus' => $p4->estatus
									);
								
							}
						};
						

						if ($cant3 > 0) {
							$i3=0;
							
							foreach ($obj3 as $p3) {
								$i3++;
										$usuarios = $this->listarUsuario($p3->id);
						};


						$arreglo = array(
							'polla' => $polla,
							'usuarios' => $usuarios,
							'puntuaciones' => $puntuacion,
							'fecha_creacion' => $p->fecha_creacion,
							'fecha_jugada' => $p->fecha_jugada,
							'primero' => $p->primero,
							'segundo' => $p->segundo,
							'tercero' => $p->tercero,
							'cuarto' => $p->cuarto,
							'quinto' => $p->quinto,
							'sexto' => $p->sexto,
							'septimo' => $p->septimo,
							'nro_transaccion' => $p->septimo,
							'estatus' => $p->estatus
							
						);

						$resultado = array(
							'polla_jugada' => $arreglo
						);
					
						$i++;		
					};

						$datos = array(
							'success' => 'true',
							'exito' => 'true',
							'datos' => $resultado
						);

					$tirajson= json_encode($datos);
				 }
		}
		else
		    $tirajson = '{ "success": "true", "exito": "false", "msg": "No hay datos!" }';

		return $tirajson;
	}
	
	function buscarPollaJugadas($id){
		$obj = Polla_jugada::all(array("conditions" => "estatus != 0 and id=".$id));
		$cant = Polla_jugada::count(array("conditions" => "estatus != 0 and id=".$id));
		$pantalla = array();
		$grupo = array();
		if ($cant > 0) {
				$i=0;
					foreach ($obj as $p) {
						
						$obj2 = Polla::all(array("conditions" => "id=". $p->id_polla));
						$cant2 = Polla::count(array("conditions" => "id=". $p->id_polla));
						$obj3 = Usuario::all(array("conditions" => "id=". $p->id_usuario_creador));
						$cant3 = Usuario::count(array("conditions" => "id=". $p->id_usuario_creador));
						$obj4 = Puntuacione::all(array("conditions" => "id=". $p->id_puntuacion));
						$cant4 = Puntuacione::count(array("conditions" => "id=". $p->id_puntuacion));
						
						if ($cant2 > 0) {
							$i2=0;
							foreach ($obj2 as $p2) {
								$i2++;
								
								 	$polla = $this->listarPolla($p2->id);
								
							}
						};

						if ($cant4 > 0) {
							$i2=0;
							foreach ($obj4 as $p4) {
								$i2++;
								
								 	$puntuacion = array(
										'id' => $p4->id,
										'lugar' => $p4->lugar,
										'punto' => $p4->punto,
										'descripcion' => $p4->descripcion,
										'estatus' => $p4->estatus
									);
								
							}
						};
						

						if ($cant3 > 0) {
							$i3=0;
							
							foreach ($obj3 as $p3) {
								$i3++;
										$usuarios = $this->listarUsuario($p3->id);
						};


						$arreglo = array(
							'polla' => $polla,
							'usuarios' => $usuarios,
							'puntuaciones' => $puntuacion,
							'fecha_creacion' => $p->fecha_creacion,
							'fecha_jugada' => $p->fecha_jugada,
							'primero' => $p->primero,
							'segundo' => $p->segundo,
							'tercero' => $p->tercero,
							'cuarto' => $p->cuarto,
							'quinto' => $p->quinto,
							'sexto' => $p->sexto,
							'septimo' => $p->septimo,
							'nro_transaccion' => $p->septimo,
							'estatus' => $p->estatus
							
						);

						$resultado[$i] = array(
							'polla_jugada' => $arreglo
						);
					
						$i++;		
					};

						$datos = array(
							'success' => 'true',
							'exito' => 'true',
							'datos' => $resultado
						);

					$tirajson= json_encode($datos);
				 }
		}
		else
		    $tirajson = '{ "success": "true", "exito": "false", "msg": "No hay datos!" }';

		return $tirajson;
	}
	
	function registrarPollaJugada($id_polla,$id_puntuacion,$id_usuario_creador,$fecha_creacion,$fecha_jugada,$primero,$segundo,$tercero,$cuarto,$quinto,$sexto,$septimo,$nro_transaccion,$estatus){
		

		if ($id_polla==''||$id_puntuacion==''||$id_usuario_creador==''||$fecha_creacion==''||$primero==''||$segundo==''||$tercero==''||$cuarto==''||$quinto==''||$sexto==''||$septimo==''||$nro_transaccion==''||$estatus=='') 
			$tirajson = '{ "success": "true", "exito": "true", "msg": "Error! Por Favor Llene todos los Campos" }';
		else{

			$polla_jugada = new Polla_jugada();
			$polla_jugada->id_polla=$id_polla;
			$polla_jugada->id_puntuacion=$id_puntuacion;
			$polla_jugada->id_usuario_creador=$id_usuario_creador;
			$polla_jugada->fecha_creacion=$fecha_creacion;
			$polla_jugada->fecha_jugada=$fecha_jugada;
			$polla_jugada->primero=$primero;
			$polla_jugada->segundo=$segundo;
			$polla_jugada->tercero=$tercero;
			$polla_jugada->cuarto=$cuarto;
			$polla_jugada->quinto=$quinto;
			$polla_jugada->sexto=$sexto;
			$polla_jugada->septimo=$septimo;
			$polla_jugada->nro_transaccion=$nro_transaccion;			
			$polla_jugada->estatus=$estatus;

			$polla_jugada->save();
			$tirajson = '{ "success": "true", "exito": "true", "msg": "Jugada Registrada Exitosamente!" }';
		}

		return $tirajson;

	}

	function actualizarPollaJugada($id,$id_polla,$id_puntuacion,$id_usuario_creador,$fecha_creacion,$fecha_jugada,$primero,$segundo,$tercero,$cuarto,$quinto,$sexto,$septimo,$nro_transaccion,$estatus){
		

		if ($id==''||$id_polla==''||$id_puntuacion==''||$id_usuario_creador==''||$fecha_creacion==''||$primero==''||$segundo==''||$tercero==''||$cuarto==''||$quinto==''||$sexto==''||$septimo==''||$nro_transaccion==''||$estatus=='') 
			$tirajson = '{ "success": "true", "exito": "true", "msg": "Error! Por Favor Llene todos los Campos" }';
		else{

			$polla_jugada = Polla_jugada::find($id);
			$polla_jugada->id_polla=$id_polla;
			$polla_jugada->id_puntuacion=$id_puntuacion;
			$polla_jugada->id_usuario_creador=$id_usuario_creador;
			$polla_jugada->fecha_creacion=$fecha_creacion;
			$polla_jugada->fecha_jugada=$fecha_jugada;
			$polla_jugada->primero=$primero;
			$polla_jugada->segundo=$segundo;
			$polla_jugada->tercero=$tercero;
			$polla_jugada->cuarto=$cuarto;
			$polla_jugada->quinto=$quinto;
			$polla_jugada->sexto=$sexto;
			$polla_jugada->septimo=$septimo;
			$polla_jugada->nro_transaccion=$nro_transaccion;			
			$polla_jugada->estatus=$estatus;

			$polla_jugada->save();
			$tirajson = '{ "success": "true", "exito": "true", "msg": "Jugada Actualizada Exitosamente!" }';
		}

		return $tirajson;

	}
        
    //CRUB VALIDA
        function listarValida($start,$limit){
			$obj = Valida::find_by_sql("SELECT * FROM validas where estatus = 1 LIMIT $start,$limit");
			$cant = Valida::count(array("conditions" => "estatus = 1"));
			if ($cant > 0) {
					$i=0;
					$tirajson='';
					foreach ($obj as $p) {
						$arreglo[$i]=array(	
							'id'  => $p->id ,
                                                        'polla'=>$this->listarPolla($p->id),
							'nro_valida'  => $p->nro_valida,
                                                        'primero' => $p->primero,
                                                        'segundo' => $p->segundo,
                                                        'tercero' => $p->tercero,
							'estatus' => $p->estatus
						);

						$i++;
					}

						$resultado= array (
							'success' => 'true',
							'exito' => 'true',
							'total' => $cant,
							'validas' => $arreglo
						);
						
						$tirajson= json_encode($resultado);
			}
			 else
				$tirajson = '{ "success": "1", "exito": "1", "msg": "No hay datos!" }';
	
			return $tirajson;
	}

        function buscarValida($id_polla,$nro_valida){
			$obj = Valida::find_by_sql("SELECT * FROM validas where id_polla=$id_polla and nro_valida=$nro_valida");
			$cant = Valida::count(array("conditions" => "id_polla=$id_polla and nro_valida=$nro_valida"));
			if ($cant > 0) {
					$i=0;
					$tirajson='';
					foreach ($obj as $p) {
						
                                                $arreglo=array(	
							'id'  => $p->id ,
                                                        'polla'=>$this->listarPolla($p->id_polla),
							'nro_valida'  => $p->nro_valida,
                                                        'primero' => $p->primero,
                                                        'segundo' => $p->segundo,
                                                        'tercero' => $p->tercero,
							'estatus' => $p->estatus
						);

						$i++;
					}

						$resultado= array (
							'success' => 'true',
							'exito' => 'true',
							'total' => $cant,
							'validas' => $arreglo
						);
						
						$tirajson= json_encode($resultado);
			}
			 else
				$tirajson = '{ "success": "true", "exito": "false", "msg": "No hay datos!" }';
	
			return $tirajson;
	}

        
        function buscarValidaPolla($id_polla){
			$obj = Valida::find_by_sql("SELECT * FROM validas where estatus = 1 and id_polla=$id_polla");
			$cant = Valida::count(array("conditions" => "estatus = 1 and id_polla=$id_polla"));
			if ($cant > 0) {
					$i=0;
					$tirajson='';
					foreach ($obj as $p) {
						$arreglo[$i]=array(	
							'id'  => $p->id ,
                                                        'polla'=>$this->listarPolla($p->id_polla),
							'nro_valida'  => $p->nro_valida,
                                                        'primero' => $p->primero,
                                                        'segundo' => $p->segundo,
                                                        'tercero' => $p->tercero,
							'estatus' => $p->estatus
						);

						$i++;
					}

						$resultado= array (
							'success' => 'true',
							'exito' => 'true',
							'total' => $cant,
							'validas' => $arreglo
						);
						
						$tirajson= json_encode($resultado);
			}
			 else
				$tirajson = '{ "success": "1", "exito": "1", "msg": "No hay datos!" }';
	
			return $tirajson;
	}
        
        
	function registrarValida($id_polla,$nro_valida,$primero,$segundo,$tercero,$estatus){
		

		if ($id_polla==''||$nro_valida==''||$primero==''||$segundo==''||$tercero==''||$estatus=='') 
			$tirajson = '{ "success": "true", "exito": "true", "msg": "Error! Por Favor Llene todos los Campos" }';
		else{

			$valida = new Valida();
			$valida->id_polla=$id_polla;
                        $valida->nro_valida=$nro_valida;
                        $valida->primero=$primero;
                        $valida->segundo=$segundo;
                        $valida->tercero=$tercero;
			$valida->estatus=$estatus;

			$valida->save();
			$tirajson = '{ "success": "true", "exito": "true", "msg": "Valida Registrada Exitosamente!" }';
		}

		return $tirajson;

	}


//Funciones que retornan arreglos 
	function listarUsuario($id){
		
		$obj = Usuario::find_by_sql("SELECT * FROM usuarios WHERE estatus != 0 and id=".$id);
		$cant = Usuario::count(array("conditions" => "estatus != 0 and id=".$id));

		if ($cant > 0) {
				$i=0;
				foreach ($obj as $p) {
					
					//Se buscan los grupos asociados a ese usuario	
					$obj2 = Grupo::all(array("conditions" => "id=". $p->id_grupo));
					$cant2 = Grupo::count(array("conditions" => "id=". $p->id_grupo));
					
					//Se buscan las Cuentas asociados a ese usuario
					$obj3 = Cuenta::all(array("conditions" => "id=". $p->id_cuenta));
					$cant3 = Cuenta::count(array("conditions" => "id=". $p->id_cuenta));
					
					if ($cant2 > 0) {
						$i2=0;
						foreach ($obj2 as $p2) {
							
							
							 	$grupo = array(
									'id' => $p2->id,
									'nombre' => $p2->nombre,
									'estatus' => $p2->estatus
								);
								$i2++;
						}
					};
					

					if ($cant3 > 0) {
						$i3=0;
						
						foreach ($obj3 as $p3) {
							
								
								//Se buscan los Bancos asociados a esa Cuenta
								$obj4 = Banco::all(array("conditions" => "id=". $p3->id_banco));
								$cant4 = Banco::count(array("conditions" => "id=". $p3->id_banco));
								$i4=0;
								foreach ($obj4 as $p4) {

									$bancos = array(
										'id' => $p4->id,
										'nombre' => $p4->nombre,
										'estatus' => $p4->estatus
									);

									$i4++;

								}	

								$cuentas = array(
									'id' => $p3->id,
									'bancos' => $bancos,
									'nro_cuenta' => $p3->nro_cuenta,
									'estatus' => $p3->estatus
								);
								$i3++;
								
						};


						$arreglo = array(
							'id' => $p->id,
							'grupos' => $grupo,
							'cuentas' => $cuentas,
							'nombre' => $p->nombre,
							'apellido' => $p->apellido,
							'fecha_nacimiento' => $p->fecha_nacimiento,
							'codigo_area' => $p->codigo_area,
							'telefono' => $p->telefono,
							'correo' => $p->correo,
							'login' => $p->login,
							'password' => $p->password,
							'foto' => $p->foto,
							'pregunta_secreta' => $p->pregunta_secreta,
							'respuesta_secreta' => $p->respuesta_secreta,
							'intentos' => $p->intentos,
							'estatus' => $p->estatus

						);

						$resultado = array(
							'usuarios' => $arreglo
						);
					
						$i++;		
					};

					$datos = array(
						'success' => 'true',
						'exito' => 'true',
						'datos' => $resultado
					);

				}
		}
		else
		    $tirajson = '{ "success": "true", "exito": "false", "msg": "No hay datos!" }';


		return $arreglo;
	}

	function listarPolla($id){
		$obj = Polla::all(array("conditions" => "estatus != 0 and id=".$id));

		$cant = Polla::count(array("conditions" => "estatus != 0 and id=".$id));

		$pantalla = array();
		$grupo = array();
		if ($cant != 0) {
				$i=0;
					foreach ($obj as $p) {
						
						$obj2 = Hipodromo::all(array("conditions" => "id=". $p->id_hipodromo));
						$cant2 = Hipodromo::count(array("conditions" => "id=". $p->id_hipodromo));
						$obj3 = Usuario::all(array("conditions" => "id=". $p->id_usuario_creador));
						$cant3 = Usuario::count(array("conditions" => "id=". $p->id_usuario_creador));
						
						if ($cant2 > 0) {
							$i2=0;
							foreach ($obj2 as $p2) {
								$i2++;
								
								 	$hipodromos = array(
										'id' => $p2->id,
										'nombre' => $p2->nombre,
										'direccion' => $p2->direccion,
										'estatus' => $p2->estatus
									);
								
							}
						};
						

						if ($cant3 > 0) {
							$i3=0;
							
							foreach ($obj3 as $p3) {
								$i3++;
										$usuarios = $this->listarUsuario($p3->id);
						};


						$arreglo = array(
							'hipodromos' => $hipodromos,
							'usuarios' => $usuarios
						);

						
						$i++;		
					};

						

					
				 }
		}
		else
		    $arreglo = '{ "success": "true", "exito": "false", "msg": "No hay datos!" }';

		return $arreglo;
	}
	
}

?>
