<?php
	// required headers
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
	 
	include_once 'config/core.php';
	include_once 'libs/php-jwt-master/src/BeforeValidException.php';
	include_once 'libs/php-jwt-master/src/ExpiredException.php';
	include_once 'libs/php-jwt-master/src/SignatureInvalidException.php';
	include_once 'libs/php-jwt-master/src/JWT.php';
	use \Firebase\JWT\JWT;
	
	include_once 'config/database.php';
	include_once 'objects/user.php';
	include_once 'objects/borrar_negocios.php';
	include_once 'objects/validar_token.php';
	 
	// get database connection
	$database = new Database();
	$db = $database->getConnection();
	
	// validación token de seguridad
	$vtoken = new validar();
	$data = json_decode(file_get_contents("php://input"));	
	$token = false;
	$jwt=isset($data->jwt) ? $data->jwt : "";
	if($jwt){
		try {
			$decoded = JWT::decode($jwt, $key, array('HS256'));
			$token = true;
		}
		catch (Exception $e){		 
			$token = false;
		}
	}
	else{
		$token = false;
	}
	
	$borrar = new Borrar($db);
	 
	//Metodos soportados -> Cultivo - Semoviente - Siniestro
	if($_GET['borrar'] == "cultivo" && @$_GET['id']){				
		try {
			if($token){
				$id = $_GET['id'];
				if($cultivos = $borrar -> cultivosById($id)){
					http_response_code(200);
					echo json_encode(array("description:" => "Registro eliminado con exito"));
				}
				else{
					http_response_code(200);
					echo json_encode(array("message" => "No se encontraron registros."));
				}
			}
			else{
				http_response_code(401);
				echo json_encode(array("message" => "Access denied."));
			}
		} catch (Exception $e) {
			http_response_code(500);
			echo json_encode(array("message" => $e->getMessage()));
		}		
		
	}
	
	
	
	/*
	//En caso de que ninguna de las opciones anteriores se haya ejecutado
	http_response_code(400);
	echo json_encode(array("message" => "Meotodo no encontrado"));*/
?>