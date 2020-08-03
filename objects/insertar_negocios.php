<?php
class Insertar{
 
    // database connection and table name
    private $conn;
    private $table_name = "cultivos_negocios";
	private $table_semo = "semovientes_negocios";
	private $table_sini = "siniestros_negocios";
 
	// object properties
	public $Tomador;
	public $Asegurado;
	public $Beneficiario;
	public $Clientes;
	public $IdTipoCultivo;
	public $IdTipoNegocio;
	public $IdTipoSemoviente;
	public $IdTipoActuacion;
	public $IdTipoCobertura;
	public $IdTipoDocumento;
	public $IdDepartamento;
	public $IdMunicipio;
	public $AnoNegocio;
	public $NumeroDocumento;
	public $NombreGranja;
	public $Vereda;
	public $Latitud;
	public $Area;
	public $Semoviente;
	public $Proposito;
	public $Densidad;
	public $Poliza;
	public $ValorAsegurado;
	public $ValorAseguradoTotal;
	public $Tasa;
	public $Prima;
	public $Deducible;
	public $VigenciaDesde;
	public $VigenciaHasta;
	public $jwt;
	
	public $IdTipoSiniestro;
	public $FechaAviso;
	public $FechaInspeccion;
	public $AmparoAfectado;
	public $ValorSiniestro;
	public $ValorIndemnizar;

		 
    // constructor
    public function __construct($db){
        $this->conn = $db;
    }
 
	function cultivos(){

		$size = count($this->Clientes);
		//** Save person like client */
		if($size > 0){
			for ($i=0; $i < $size ; $i++) { 				
				foreach($this->Clientes[$i] as $key => $value){
				  if($key == 'NumeroDocumento'){
					  $numeroDocumento = $value;
				  }
				  if($key == 'IdTipoDocumento'){
					$tipoDocumento = $value;
				  }
				  if($key == 'IdTipoActuacion'){
					$tipoActuacion = $value;
				  }
				}
				/*$queryClient = "INSERT INTO cliente 
						SET NumeroDocumento = :numeroDocumento,
							IdTipoDocumento = :tipoDocumento,
							IdTipoActuacion = :tipoActuacion";*/
				$queryClient = "CALL SP_INS_UPD_CLIENTE(?,?,?,?,?,?,?,?)";

				// prepare the query
				$stmtClient = $this->conn->prepare($queryClient);
				// bind the values
				$stmtClient->bindParam(1, $numeroDocumento); // P_NUMERODOCUMENTO
				$stmtClient->bindParam(2, $this->AnoNegocio); // P_NOMBRES
				$stmtClient->bindParam(3, $this->AnoNegocio); // P_APELLIDOS
				$stmtClient->bindParam(4, $this->AnoNegocio); // P_TELEFONO
				$stmtClient->bindParam(5, $tipoDocumento); 	  // P_IDTIPODOCUMENTO
				$stmtClient->bindParam(6, $tipoActuacion);    // P_IDTIPOACTUACION
				$stmtClient->bindParam(7, $this->AnoNegocio); // P_RAZONSOCIAL
				$stmtClient->bindParam(8, $this->AnoNegocio); // P_EMAIL

				$stmtClient->execute();			
				
				
			}
		}
		
		// insert query
		/*$query = "INSERT INTO " . $this->table_name . "
				SET
					IdTipoCultivo = :IdTipoCultivo,
					IdTipoNegocio = :IdTipoNegocio,
					IdTipoCobertura = :IdTipoCobertura,
					IdDepartamento = :IdDepartamento,
					IdMunicipio = :IdMunicipio,
					AnoNegocio = :AnoNegocio,
					NombreGranja = :NombreGranja,
					Vereda = :Vereda,
					Latitud = :Latitud,
					Area = :Area,
					Densidad = :Densidad,
					Poliza = :Poliza,
					ValorAsegurado = :ValorAsegurado,
					ValorAseguradoTotal = :ValorAseguradoTotal,
					Tasa = :Tasa,
					Prima = :Prima,
					Deducible = :Deducible,
					VigenciaDesde = CAST(:VigenciaDesde AS DATE),
					VigenciaHasta = CAST(:VigenciaHasta AS DATE),
					Tomador = :Tomador,
					Asegurado = :Asegurado,
					Beneficiario = :Beneficiario";
	 
		// prepare the query
		$stmt = $this->conn->prepare($query);
	 
		// bind the values
		$stmt->bindParam(':IdTipoCultivo', $this->IdTipoCultivo);
		$stmt->bindParam(':IdTipoNegocio', $this->IdTipoNegocio);
		$stmt->bindParam(':IdTipoCobertura', $this->IdTipoCobertura);
		$stmt->bindParam(':IdDepartamento', $this->IdDepartamento);
		$stmt->bindParam(':IdMunicipio', $this->IdMunicipio);
		$stmt->bindParam(':AnoNegocio', $this->AnoNegocio);
		$stmt->bindParam(':NombreGranja', $this->NombreGranja);
		$stmt->bindParam(':Vereda', $this->Vereda);
		$stmt->bindParam(':Latitud', $this->Latitud);
		$stmt->bindParam(':Area', $this->Area);
		$stmt->bindParam(':Densidad', $this->Densidad);
		$stmt->bindParam(':Poliza', $this->Poliza);
		$stmt->bindParam(':ValorAsegurado', $this->ValorAsegurado);
		$stmt->bindParam(':ValorAseguradoTotal', $this->ValorAseguradoTotal);
		$stmt->bindParam(':Tasa', $this->Tasa);
		$stmt->bindParam(':Prima', $this->Prima);
		$stmt->bindParam(':Deducible', $this->Deducible);
		$stmt->bindParam(':VigenciaDesde', $this->VigenciaDesde);
		$stmt->bindParam(':VigenciaHasta', $this->VigenciaHasta);
		$stmt->bindParam(':Tomador', $this->Tomador);
		$stmt->bindParam(':Asegurado', $this->Asegurado);
		$stmt->bindParam(':Beneficiario', $this->Beneficiario);*/

		$query = "CALL SP_INS_UPD_CULTIVOS_NEGOCIOS (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

		$stmt = $this->conn->prepare($query);
	 
		// bind the values
		$stmt->bindParam(1, $this->IdTipoCultivo);
		$stmt->bindParam(2, $this->IdTipoNegocio);
		$stmt->bindParam(3, $this->IdTipoCobertura);
		$stmt->bindParam(4, $this->IdDepartamento);
		$stmt->bindParam(5, $this->IdMunicipio);
		$stmt->bindParam(6, $this->AnoNegocio);
		$stmt->bindParam(7, $this->NombreGranja);
		$stmt->bindParam(8, $this->Vereda);
		$stmt->bindParam(9, $this->Latitud);
		$stmt->bindParam(10, $this->Area);
		$stmt->bindParam(11, $this->Densidad);
		$stmt->bindParam(12, $this->Poliza);
		$stmt->bindParam(13, $this->ValorAsegurado);
		$stmt->bindParam(14, $this->ValorAseguradoTotal);
		$stmt->bindParam(15, $this->Tasa);
		$stmt->bindParam(16, $this->Prima);
		$stmt->bindParam(17, $this->Deducible);
		$stmt->bindParam(18, $this->VigenciaDesde);
		$stmt->bindParam(19, $this->VigenciaHasta);
		$stmt->bindParam(20, $this->Tomador);
		$stmt->bindParam(21, $this->Asegurado);
		$stmt->bindParam(22, $this->Beneficiario);
	 
		// execute the query, also check if query was successful
		try {
			$stmt->execute();
				return true;
		} catch (\Throwable $th) {
			return false;
		}
				
	}
	
	function semovientes(){	 
	
	// insert query
	$query = "INSERT INTO " . $this->table_semo . "
				SET
					IdTipoSemoviente = :IdTipoSemoviente,
					IdTipoNegocio = :IdTipoNegocio,
					IdTipoActuacion = :IdTipoActuacion,
					IdTipoCobertura = :IdTipoCobertura,
					IdTipoDocumento = :IdTipoDocumento,
					IdDepartamento = :IdDepartamento,
					IdMunicipio = :IdMunicipio,
					AnoNegocio = :AnoNegocio,
					NumeroDocumento = :NumeroDocumento,
					NombreGranja = :NombreGranja,
					Vereda = :Vereda,
					Semoviente = :Semoviente,
					Latitud = :Latitud,
					Proposito = :Proposito,
					Densidad = :Densidad,
					Poliza = :Poliza,
					ValorAsegurado = :ValorAsegurado,
					ValorAseguradoTotal = :ValorAseguradoTotal,
					Tasa = :Tasa,
					Prima = :Prima,
					Deducible = :Deducible,
					VigenciaDesde = CAST(:VigenciaDesde AS DATE),
					VigenciaHasta = CAST(:VigenciaHasta AS DATE)";
	 
		// prepare the query
		$stmt = $this->conn->prepare($query);
	 	 
		// bind the values
		$stmt->bindParam(':IdTipoSemoviente', $this->IdTipoSemoviente);
		$stmt->bindParam(':IdTipoNegocio', $this->IdTipoNegocio);
		$stmt->bindParam(':IdTipoActuacion', $this->IdTipoActuacion);
		$stmt->bindParam(':IdTipoCobertura', $this->IdTipoCobertura);
		$stmt->bindParam(':IdTipoDocumento', $this->IdTipoDocumento);
		$stmt->bindParam(':IdDepartamento', $this->IdDepartamento);
		$stmt->bindParam(':IdMunicipio', $this->IdMunicipio);
		$stmt->bindParam(':AnoNegocio', $this->AnoNegocio);
		$stmt->bindParam(':NumeroDocumento', $this->NumeroDocumento);
		$stmt->bindParam(':NombreGranja', $this->NombreGranja);
		$stmt->bindParam(':Vereda', $this->Vereda);
		$stmt->bindParam(':Semoviente', $this->Semoviente);
		$stmt->bindParam(':Latitud', $this->Latitud);
		$stmt->bindParam(':Proposito', $this->Proposito);
		$stmt->bindParam(':Densidad', $this->Densidad);
		$stmt->bindParam(':Poliza', $this->Poliza);
		$stmt->bindParam(':ValorAsegurado', $this->ValorAsegurado);
		$stmt->bindParam(':ValorAseguradoTotal', $this->ValorAseguradoTotal);
		$stmt->bindParam(':Tasa', $this->Tasa);
		$stmt->bindParam(':Prima', $this->Prima);
		$stmt->bindParam(':Deducible', $this->Deducible);
		$stmt->bindParam(':VigenciaDesde', $this->VigenciaDesde);
		$stmt->bindParam(':VigenciaHasta', $this->VigenciaHasta);
	 
		// execute the query, also check if query was successful
		if($stmt->execute()){
			return true;
		}
		return false;
	}
	
	function siniestro(){	 
	
	// insert query
	$query = "INSERT INTO " . $this->table_sini . "
				SET
					IdTipoSiniestro = :IdTipoSiniestro,
					IdTipoDocumento = :IdTipoDocumento,
					NumeroDocumento = :NumeroDocumento,
					NombreFinca = :NombreGranja,
					FechaAviso = CAST(:FechaAviso AS DATE),
					FechaInspeccion = CAST(:FechaInspeccion AS DATE),
					AmparoAfectado = :AmparoAfectado,
					ValorSiniestro = :ValorSiniestro,
					Deducible = :Deducible,
					ValorIndemnizar = :ValorIndemnizar";
	 
		// prepare the query
		$stmt = $this->conn->prepare($query);
	 	 
		// bind the values
		$stmt->bindParam(':IdTipoSiniestro', $this->IdTipoSiniestro);
		$stmt->bindParam(':IdTipoDocumento', $this->IdTipoDocumento);
		$stmt->bindParam(':NumeroDocumento', $this->NumeroDocumento);
		$stmt->bindParam(':NombreGranja', $this->NombreGranja);
		$stmt->bindParam(':FechaAviso', $this->FechaAviso);
		$stmt->bindParam(':FechaInspeccion', $this->FechaInspeccion);
		$stmt->bindParam(':AmparoAfectado', $this->AmparoAfectado);
		$stmt->bindParam(':ValorSiniestro', $this->ValorSiniestro);
		$stmt->bindParam(':Deducible', $this->Deducible);
		$stmt->bindParam(':ValorIndemnizar', $this->ValorIndemnizar);
	 
		// execute the query, also check if query was successful
		if($stmt->execute()){
			return true;
		}
		return false;
	}
}