<?php

define('QUEUE_KEY', 1232345);

define('QUEUE_TYPE_START', 1);

if( !empty( $_SERVER['DOCUMENT_ROOT'] ) ){
	define('SERVER_PATH', $_SERVER['DOCUMENT_ROOT'] ); 	
}else{
	define('SERVER_PATH', dirname( __FILE__ ) . '/../' ); 
}

?>