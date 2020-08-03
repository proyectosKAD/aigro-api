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
	include_once 'objects/consultar_listas.php';
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
	
	$listas = new Listas($db);

	//** Se validan listas */
	if($_GET['listas']){
		switch ($_GET['listas']) {
			//** Lista tipo de cultivos */
			case 'cultivos':
				try{
					if($token){
						if($cultivos = $listas -> cultivos()){
							http_response_code(200);
							echo json_encode(utf8ize(array($cultivos)));
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
			//** Lista tipo de semovientes */	
			case 'semovientes':
				try{	
					if($token){
						if($semovientes = $listas -> semovientes()){
							http_response_code(200);
							echo json_encode(utf8ize(array($semovientes)));
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
			//** Lista Tipo de Negocio */
			case 'tipoNegocio':
				try{
					if($token){
						if($negocios = $listas -> TipoNegocios()){
							http_response_code(200);
							echo json_encode(utf8ize(array($negocios)));
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
			//** Lista Tipo de actuación */
			case 'actuacion':
				try {
					if($token){
						if($actuacion = $listas -> Actuacion()){
							http_response_code(200);
							echo json_encode(utf8ize(array($actuacion)));
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
			//** Lista Tipo de cobertura */
			case 'cobertura':
				try {
					if($token){
						$sistema = $_GET['sistema'];
						if($cobertura = $listas -> cobertura($sistema)){
							http_response_code(200);
							echo json_encode(utf8ize(array($cobertura)));
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
			//** Lista Tipo de identificación */
			case 'tipoDoc':
				try {
					if($token){
						if($tipoDoc = $listas -> TipoDocumento()){
							http_response_code(200);
							echo json_encode(utf8ize(array($tipoDoc)));
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
			//** Lista de departamentos de Colombia */
			case 'departamentos':
				try {
					if($token){
						if(@$_GET['page'] && @$_GET['rows']){
							$page = $_GET['page'];
							$rows = $_GET['rows'];
							if($departamentos = $listas -> departamentos($page, $rows)){
								http_response_code(200);
								echo json_encode(utf8ize(array($departamentos)));
							}
							else{
								http_response_code(200);
								echo json_encode(array("message" => "No se encontraron registros para la busqueda."));
							}
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
			//** Lista de municipios por departamento */
			case 'municipios':
				try {
					if($token){
						$page = $_GET['page'];
						$rows = $_GET['rows'];
						$param = $_GET['dep'];
						
						if($departamentos = $listas -> municipios($param, $page, $rows)){
							http_response_code(200);
							echo json_encode(utf8ize(array($departamentos)));
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
			default:
				http_response_code(404);
				break;
		}
	}

	//** Se validan records */
	if($_GET['records']){
		switch ($_GET['records']) {
			//** Total departamentos para paginación */
			case 'departamentos':
				try {
					if($token){
						if($total = $listas -> total_records()){
							http_response_code(200);
							echo json_encode(array($total));
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
			//** Total municipios para paginación */
			case 'municipios':
				try {
					if($token){
						$param = $_GET['departamento'];
						if($total = $listas -> total_records_municipio($param)){
							http_response_code(200);
							echo json_encode(array($total));
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
			default:
				http_response_code(404);
				break;
		}
	}
	
	function utf8ize($d) {
        if (is_array($d)) {
            foreach ($d as $k => $v) {
                $d[$k] = utf8ize($v);
            }
        } else if (is_string ($d)) {
            return utf8_encode($d);
        }
        return $d;
    }
?>