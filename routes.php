<?php

require_once( 'config/config.php' );
require_once( SERVER_PATH . '/helpers/HTTPResponse.php');
require_once( SERVER_PATH . '/controllers/OrderController.php');

$action = isset( $_GET["action"] ) ? $_GET["action"] : "";
$method = isset( $_SERVER['REQUEST_METHOD'] ) ? $_SERVER['REQUEST_METHOD'] : "";
switch($action){

	// to handle add API /orders/add/
	case "add":
		switch($method) {
		  case 'POST':
		  	$mobileRestHandler = new OrderController();
			$mobileRestHandler->addOrder();
			break;

		  default:
		  	$response = new HTTPResponse();
		    header('HTTP/1.1 405 Method Not Allowed');
		    header('Allow: POST');
		    echo $response->getHTMLResponse(405);
		    break;
		}
		
		break;
	case "" :
		$response = new HTTPResponse();
	    header('HTTP/1.1 404 NOT FOUND');
	    echo $response->getHTMLResponse(400);
	    break;
		break;
}

?>