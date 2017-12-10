<?php

require_once( SERVER_PATH . '/helpers/HTTPResponse.php');
require_once( SERVER_PATH . '/helpers/Queue.php');
require_once( SERVER_PATH . '/helpers/DataValidator.php');

class OrderController extends HTTPResponse {

	function addOrder() {	
	    
	    $data = $_POST['data'];

	    $validator = new DataValidator($data);
	    $errors = $validator->validate();

	    if( sizeof($errors) > 0 ){
	    	$statusCode = 400;
	    	$rawData = array('error' => 'Data not valid', 'message' => $errors);
	    }else{
	    	if( Queue::addMessage($data['orderId'], $data) ) {
				$statusCode = 200;
				$rawData = array('success' => 'Data added to Queue');
			} else {
				$statusCode = 500;
				$rawData = array('error' => 'Error adding to Queue');
			}
	    }

		$headers = getallheaders();
		$requestContentType = $headers['Content-Type'];
		$this->setHttpHeaders($requestContentType, $statusCode);
				
		if(strpos($requestContentType,'application/json') !== false){
			$response = $this->encodeJson($rawData);
		} else if(strpos($requestContentType,'application/xml') !== false){
			$response = $this->encodeXml($rawData);
		}else{
			$response = $this->encodeJson($rawData);
		}

		echo $response;
	}
	
	public function encodeJson($responseData) {
		$jsonResponse = json_encode($responseData);
		return $jsonResponse;		
	}
	
	public function encodeXml($responseData) {
		$xml = new SimpleXMLElement('<?xml version="1.0"?><meesho></meesho>');
		foreach($responseData as $key=>$value) {
			$xml->addChild($key, $value);
		}
		return $xml->asXML();
	}

}

?>