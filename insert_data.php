<?php
	// required headers
	//header("Access-Control-Allow-Origin: http://localhost:10080/rest/");
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
	include_once 'objects/insertar_negocios.php';
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
	
	$insertar = new Insertar($db);
	 
	//Metodos soportados -> Cultivo - Semoviente - Siniestro
	if($_GET['insertar'] == "cultivo"){
				
		$insertar->IdTipoCultivo = $data->IdTipoCultivo;
		$insertar->Clientes = $data->Clientes;
		$insertar->Tomador = $data->Tomador;
		$insertar->Asegurado = $data->Asegurado;
		$insertar->Beneficiario = $data->Beneficiario;		
		$insertar->IdTipoCultivo = $data->IdTipoCultivo;
		$insertar->IdTipoNegocio = $data->IdTipoNegocio;
		$insertar->IdTipoCobertura = $data->IdTipoCobertura;
		$insertar->IdDepartamento = $data->IdDepartamento;
		$insertar->IdMunicipio = $data->IdMunicipio;
		$insertar->AnoNegocio = $data->AnoNegocio;
		$insertar->NombreGranja = $data->NombreGranja;
		$insertar->Vereda = $data->Vereda;
		$insertar->Latitud = $data->Latitud;
		$insertar->Area = $data->Area;
		$insertar->Densidad = $data->Densidad;
		$insertar->Poliza = $data->Poliza;
		$insertar->ValorAsegurado = $data->ValorAsegurado;
		$insertar->ValorAseguradoTotal = $data->ValorAseguradoTotal;
		$insertar->Tasa = $data->Tasa;
		$insertar->Prima = $data->Prima;
		$insertar->Deducible = $data->Deducible;
		$insertar->VigenciaDesde = $data->VigenciaDesde;
		$insertar->VigenciaHasta = $data->VigenciaHasta;
				
		if($token){
			if($insertar->cultivos()){
				http_response_code(200);
				echo json_encode(array("message" => "Cultivo creado exitosamente."));
			}
			else{
				http_response_code(400);
				echo json_encode(array("message" => "Error al insertar el registro."));
			}
		}
		else{
			http_response_code(401);
			echo json_encode(array("message" => "Access denied."));
		}
	}
	elseif($_GET['insertar'] == "semoviente"){
				
		$insertar->IdTipoSemoviente = $data->IdTipoSemoviente;
		$insertar->IdTipoNegocio = $data->IdTipoNegocio;
		$insertar->IdTipoActuacion = $data->IdTipoActuacion;
		$insertar->IdTipoCobertura = $data->IdTipoCobertura;
		$insertar->IdTipoDocumento = $data->IdTipoDocumento;
		$insertar->IdDepartamento = $data->IdDepartamento;
		$insertar->IdMunicipio = $data->IdMunicipio;
		$insertar->AnoNegocio = $data->AnoNegocio;
		$insertar->NumeroDocumento = $data->NumeroDocumento;
		$insertar->NombreGranja = $data->NombreGranja;
		$insertar->Vereda = $data->Vereda;
		$insertar->Semoviente = $data->Semoviente;
		$insertar->Latitud = $data->Latitud;
		$insertar->Proposito = $data->Proposito;
		$insertar->Densidad = $data->Densidad;
		$insertar->Poliza = $data->Poliza;
		$insertar->ValorAsegurado = $data->ValorAsegurado;
		$insertar->ValorAseguradoTotal = $data->ValorAseguradoTotal;
		$insertar->Tasa = $data->Tasa;
		$insertar->Prima = $data->Prima;
		$insertar->Deducible = $data->Deducible;
		$insertar->VigenciaDesde = $data->VigenciaDesde;
		$insertar->VigenciaHasta = $data->VigenciaHasta;		
		
		if($token){
			if($insertar->semovientes()){
				http_response_code(200);
				echo json_encode(array("message" => "Semoviente creado exitosamente."));
			}
			else{
				http_response_code(400);
				echo json_encode(array("message" => "Error al insertar el registro."));
			}
		}
		else{
			http_response_code(401);
			echo json_encode(array("message" => "Access denied."));
		}
	}
	elseif($_GET['insertar'] == "siniestro"){
	
		$insertar->IdTipoSiniestro = $data->IdTipoSiniestro;
		$insertar->IdTipoDocumento = $data->IdTipoDocumento;
		$insertar->NumeroDocumento = $data->NumeroDocumento;
		$insertar->NombreGranja = $data->NombreGranja;
		$insertar->FechaAviso = $data->FechaAviso;
		$insertar->FechaInspeccion = $data->FechaInspeccion;
		$insertar->AmparoAfectado = $data->AmparoAfectado;
		$insertar->ValorSiniestro = $data->ValorSiniestro;
		$insertar->Deducible = $data->Deducible;
		$insertar->ValorIndemnizar = $data->ValorIndemnizar;
			
		if($token){
			if($insertar->siniestro()){
				http_response_code(200);
				echo json_encode(array("message" => "Siniestro creado exitosamente."));
			}
			else{
				http_response_code(400);
				echo json_encode(array("message" => "Error al insertar el registro."));
			}
		}
		else{
			http_response_code(401);
			echo json_encode(array("message" => "Access denied."));
		}
	}
	
	/*
	//En caso de que ninguna de las opciones anteriores se haya ejecutado
	http_response_code(400);
	echo json_encode(array("message" => "Meotodo no encontrado"));*/
?>