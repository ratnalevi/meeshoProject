<?php

# Create a connection
$url = 'http://meesho.com/routes.php?action=add&id=2';
$data = [ "data" => [
			'orderId' => 123,
	        'requestType' => 'email',
	        'recepient' => 'ratnalevi@gmail.com',
	        'subject' => 'Test Subject',
	        'message' => 'Test Message',
	        'time' => time(), // used for time based operations
	        'retries' => 0	     
		]
];

$ch = curl_init($url);
# Form data string
$postString = http_build_query($data, '', '&');
# Setting our options
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
# Get the response
$response = curl_exec($ch);
curl_close($ch);

print "Response from API : \n";
var_dump( $response );

?>
