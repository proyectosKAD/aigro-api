<?php
class Borrar{
 
    // database connection and table name
    private $conn;
    private $table_name = "cultivos_negocios";
	private $table_semo = "semovientes_negocios";
	private $table_sini = "siniestros_negocios";
 
    // object properties	
	public $id;
	public $IdTipoCultivo;
	public $NumeroDocumento;
	public $NombreGranja;
	public $Poliza;
	
	public $idTipoSemoviente;
	public $IdTipoActuacion;
	public $IdTipoCobertura;
	public $IdTipoDocumento;
	public $IdDepartamento;
	public $IdMunicipio;
	public $AnoNegocio;
	public $IdTipoNegocio;
	
	public $Vereda;
	public $Latitud;
	public $Area;
	public $Semoviente;
	public $Proposito;
	public $Densidad;
	
	public $ValorAsegurado;
	public $ValorAseguradoTotal;
	public $Tasa;
	public $Prima;
	public $Deducible;
	public $VigenciaDesde;
	public $VigenciaHasta;
	public $jwt;
	
	public $IdTipoSiniestro;
	public $NombreFinca;
	public $FechaAviso;
	public $FechaInspeccion;
	public $AmparoAfectado;
	public $ValorSiniestro;
	public $ValorIndemnizar;
	 
	public $cultivos_arr = array();
	public $semovientes_arr = array();
	public $siniestros_arr = array();
	 
    // constructor
    public function __construct($db){
        $this->conn = $db;
    }
 
	function cultivosById($param){
		try {
			$query = "CALL SP_BORRARCULTIVO(?)";

			$stmt = $this->conn->prepare($query);

			$stmt->bindParam(1, $param, PDO::PARAM_STR);
			$stmt->execute();
			return true;

		} catch (\Throwable $th) {
			return false;
		}
	}

	function cultivos(){

		$query = "CALL SP_Cultivos(?, ?, ?)";

		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $this->NumeroDocumento, PDO::PARAM_STR);
		$stmt->bindParam(2, $this->NombreGranja, PDO::PARAM_STR);
		$stmt->bindParam(3, $this->IdTipoCultivo, PDO::PARAM_STR);
		$stmt->execute();

		$num = $stmt->rowCount();
		if($num>0){
			$cultivos_arr["cultivos"]=array();			
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$cultivo_item=array(
					"id" => $row["id"],
					"NumeroDocumento" => $row["NumeroDocumento"],
					"NombreGranja" => $row["NombreGranja"],
					"IdTipoCultivo" => $row["IdTipoCultivo"],
					"Poliza" => $row["Poliza"]
				);
				array_push($cultivos_arr["cultivos"], $cultivo_item);
			}
			return $cultivos_arr;
		}else{
			return false;
		}
	}
	
	function semovientes(){

		$query = "CALL SP_SEMOVIENTES(?, ?, ?)";

		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $this->NumeroDocumento, PDO::PARAM_STR);
		$stmt->bindParam(2, $this->NombreGranja, PDO::PARAM_STR);
		$stmt->bindParam(3, $this->idTipoSemoviente, PDO::PARAM_STR);
		$stmt->execute();

		$num = $stmt->rowCount();
		if($num>0){
			$result_arr["semovientes"]=array();			
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$result_item=array(
					"id" => $row["id"],
					"NumeroDocumento" => $row["NumeroDocumento"],
					"NombreGranja" => $row["NombreGranja"],
					"TipoSemoviente" => $row["IdTipoSemoviente"],
					"Poliza" => $row["Poliza"]
				);
				array_push($result_arr["semovientes"], $result_item);
			}
			return $result_arr;
		}else{
			return false;
		}
	}
	
	function siniestros(){	 
	
		// search query
		$query = "SELECT id, NumeroDocumento, NombreFinca, IdTipoSiniestro
				FROM " . $this->table_sini . "
				WHERE NumeroDocumento = ?";
			 
		// prepare the query
		$stmt = $this->conn->prepare($query);
	 	 		 
		$stmt->bindParam(1, $this->NumeroDocumento);
		
		// execute the query
		$stmt->execute();
	 
		// table_semoget number of rows
		$num = $stmt->rowCount();
	 		
		if($num>0){
			
			$siniestros_arr["siniestros"]=array();
			
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$siniestro_item=array(
					"id" => $row["id"],
					"NumeroDocumento" => $row["NumeroDocumento"],
					"NombreGranja" => $row["NombreFinca"],
					"tipoSiniestro" => $row["IdTipoSiniestro"]
				);
				array_push($siniestros_arr["siniestros"], $siniestro_item);
			}
			return $siniestros_arr;
		}
		return false;
	}
}