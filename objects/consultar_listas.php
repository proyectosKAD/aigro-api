<?php
class Listas{
 
    // database connection and table name
    private $conn;
    private $table_name = "departamento";
	private $table_semo = "semovientes_negocios";
	private $table_sini = "siniestros_negocios";
	private $page;
	private $rows;
	private $param;
	
    // object properties
	public $products_arr = array();
	
    // constructor
    public function __construct($db){
        $this->conn = $db;
    }
 
	function total_records(){
		
		$query = "SELECT COUNT(*) AS total 
				FROM departamento" ;
				
		// prepare the query
		$stmt = $this->conn->prepare($query);
		
		// execute the query
		$stmt->execute();
		// get number of rows
		$num = $stmt->rowCount();

		if($num>0){
						
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$products_arr=array(
					"total_records" => $row["total"]
				);
			}
			return $products_arr;
		}
		return false;
	}

	function total_records_municipio($param){
		
		$query = "SELECT COUNT(*) AS total 
				FROM municipios 
				WHERE IdDepartamento = $param" ;
				
		// prepare the query
		$stmt = $this->conn->prepare($query);
		
		// execute the query
		$stmt->execute();
		// get number of rows
		$num = $stmt->rowCount();

		if($num>0){
						
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$products_arr=array(
					"total_records" => $row["total"]
				);
			}
			return $products_arr;
		}
		return false;
	}

	function departamentos($page, $rows){	 
		
		$begin = ($page - 1) * $rows;
		
		$query = "SELECT IdDepartamento, Descripcion 
				FROM " . $this->table_name."
				LIMIT $begin, $rows";
				
		// prepare the query
		$stmt = $this->conn->prepare($query);

		// execute the query
		$stmt->execute();
		// get number of rows
		$num = $stmt->rowCount();
		
		if($num>0){
			
			$products_arr["departamentos"]=array();
			// get record details / values
			
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$product_item=array(
					"id" => $row["IdDepartamento"],
					"descripcion" => $row["Descripcion"]
				);
				array_push($products_arr["departamentos"], $product_item);
			}
			
			return $products_arr;
		 
		}
		return false;
	}

	function municipios($param, $page, $rows){	 
		
		$begin = ($page - 1) * $rows;
		
		$query = "SELECT IdMunicipio, Descripcion 
				FROM municipios
				WHERE IdDepartamento = $param
				LIMIT $begin, $rows";
				
		// prepare the query
		$stmt = $this->conn->prepare($query);

		// execute the query
		$stmt->execute();
		// get number of rows
		$num = $stmt->rowCount();
		
		if($num>0){
			
			$products_arr["municipios"]=array();
			// get record details / values
			
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$product_item=array(
					"id" => $row["IdMunicipio"],
					"descripcion" => $row["Descripcion"]
				);
				array_push($products_arr["municipios"], $product_item);
			}
			return $products_arr;
		}
		return false;
	}

	function cultivos(){	 
		
		$query = "SELECT IdTipoCultivo, cul.Descripcion
				FROM tipo_cultivo AS cul";
				
		// prepare the query
		$stmt = $this->conn->prepare($query);

		// execute the query
		$stmt->execute();
		// get number of rows
		$num = $stmt->rowCount();
		
		if($num>0){
			
			$products_arr["cultivos"]=array();
			// get record details / values
			
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$product_item=array(
					"id" => $row["IdTipoCultivo"],
					"descripcion" => $row["Descripcion"]
				);
				array_push($products_arr["cultivos"], $product_item);
			}
			return $products_arr;
		}
		return false;
	}
	function semovientes(){	 
		
		$query = "SELECT IdTipo_Semoviente, sem.Descripcion
				FROM tipo_semoviente AS sem";

		// prepare the query
		$stmt = $this->conn->prepare($query);
		// execute the query
		$stmt->execute();
		// get number of rows
		$num = $stmt->rowCount();		
		if($num>0){
			
			$result_arr["semovientes"]=array();
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$result_item=array(
					"id" => $row["IdTipo_Semoviente"],
					"descripcion" => $row["Descripcion"]
				);
				array_push($result_arr["semovientes"], $result_item);
			}
			return $result_arr;
		}
		return false;
	}
	
	function cobertura($sistema){	 
		
		$query = "SELECT tc.IdTipoCobertura, tc.Descripcion
					FROM tipo_cobertura AS tc
					WHERE tc.sistema_agropecuario = $sistema";
				
		// prepare the query
		$stmt = $this->conn->prepare($query);

		// execute the query
		$stmt->execute();
		// get number of rows
		$num = $stmt->rowCount();
		
		if($num>0){
			
			$products_arr["coberturas"]=array();
			// get record details / values
			
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$product_item=array(
					"id" => $row["IdTipoCobertura"],
					"descripcion" => $row["Descripcion"]
				);
				array_push($products_arr["coberturas"], $product_item);
			}
			return $products_arr;
		}
		return false;
	}

	function TipoNegocios(){	 
		
		$query = "SELECT neg.IdTipoNegocio, neg.Descripcion
				FROM Tipo_Negocio AS neg";
				
		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		$num = $stmt->rowCount();

		if($num>0){
			$negocios_arr["negocios"]=array();			
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$items=array(
					"id" => $row["IdTipoNegocio"],
					"descripcion" => $row["Descripcion"]
				);
				array_push($negocios_arr["negocios"], $items);
			}
			return $negocios_arr;
		}else{
			return false;
		}
	}

	function Actuacion(){	 
		
		$query = "SELECT act.IdTipoActuacion, act.Descripcion
				FROM tipo_actuacion AS act";
				
		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		$num = $stmt->rowCount();

		if($num>0){
			$actuacion_arr["actuacion"]=array();			
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$items=array(
					"id" => $row["IdTipoActuacion"],
					"descripcion" => $row["Descripcion"]
				);
				array_push($actuacion_arr["actuacion"], $items);
			}
			return $actuacion_arr;
		}else{
			return false;
		}
	}

	function TipoDocumento(){	 
		
		$query = "SELECT doc.IdTipoDocumento, doc.Descripcion
				FROM tipo_documento AS doc";
				
		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		$num = $stmt->rowCount();

		if($num>0){
			$result_arr["documentos"]=array();			
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$items=array(
					"id" => $row["IdTipoDocumento"],
					"descripcion" => $row["Descripcion"]
				);
				array_push($result_arr["documentos"], $items);
			}
			return $result_arr;
		}else{
			return false;
		}
	}
}