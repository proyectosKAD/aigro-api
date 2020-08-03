<?php
// files for decoding jwt will be here
// required to decode jwt
include_once 'config/core.php';
include_once 'libs/php-jwt-master/src/BeforeValidException.php';
include_once 'libs/php-jwt-master/src/ExpiredException.php';
include_once 'libs/php-jwt-master/src/SignatureInvalidException.php';
include_once 'libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;

class validar{

	// constructor
    public function validar_token($token){
		
        // get jwt
		$jwt=isset($token) ? $token : "";
		
		if($jwt){
	 
			// if decode succeed, show user details
			try {
				// decode jwt
				$decoded = JWT::decode($jwt, $key, array('HS256'));
		 
				return true;
			}
			catch (Exception $e){		 
				return $e;
			}
		}
		// error if jwt is empty will be here// show error message if jwt is empty
		else{
			return false;
		}
		
    }
}
?>
