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
	include_once 'objects/consultar_negocios.php';
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
	
	$consultar = new Consultar($db);
	
	/* -- Metodos soportados:
	* --- Cultivo
	* --- Semoviente
	* --- Siniestro
	*/
	switch ($_GET['consultar']) {
		case 'cultivo':
			try {
				if($token){
					$id = $_GET['id'];
					if($cultivos = $consultar -> cultivosById($id)){
						http_response_code(200);
						echo json_encode(array($cultivos));
					}
					else{
						http_response_code(200);
						echo json_encode(array("message" => "No se encontraron registros para la busqueda."));
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
			break;
		case 'semoviente':
			try {
				if($token){
					$id = $_GET['id'];
					if($semovientes = $consultar -> semovientesById($id)){
						http_response_code(200);
						echo json_encode(array($semovientes));
					}
					else{
						http_response_code(200);
						echo json_encode(array("message" => "No se encontraron registros para la busqueda."));
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
			break;
		case 'siniestro':
			try {					
				if($token){
					$consultar->IdTipoCultivo = $data->IdTipoCultivo;
					$consultar->NombreGranja = $data->NombreGranja;
					$consultar->NumeroDocumento = $data->NumeroDocumento;
					if($siniestros = $consultar -> siniestros()){
						http_response_code(200);
						echo json_encode(array($siniestros));
					}
					else{
						http_response_code(400);
						echo json_encode(array("message" => "Error al consultar siniestros."));
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
			break;
		default:
			http_response_code(404);
			break;
	}
?>