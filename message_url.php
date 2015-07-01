<?php
//Provide Access to validate_signature Function
require 'plivo.php';

//Enter Credentials - Move Prior to Going Live
$auth_id = "XXXXXXXXXXXXXXXXXXXX";
$auth_token = "YYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYY";

//Get Page URI - Change to "https://" if Needed
$set_uri = "http://" . $_SERVER[HTTP_HOST] . $_SERVER[REQUEST_URI];

//Get Post Parameters
$raw_post_data = file_get_contents('php://input');
$raw_post_array = explode('&', $raw_post_data);
$set_post_params = array();
foreach ($raw_post_array as $keyval) {
	$keyval = explode ('=', $keyval);
	if (count($keyval) == 2)
		$set_post_params[$keyval[0]] = urldecode($keyval[1]);
}

//Get Valid Signature from Plivo
$set_headers = apache_request_headers();
foreach ($set_headers as $header_key => $header_value) {
	if($header_key == "X-Plivo-Signature") {
    	echo $set_signature .= "$header_value";
	}
}

//Variable Change to Match
$set_auth_token = $auth_token;

//Signature Match Returns TRUE (1) - Mismatch Returns FALSE (0)
$validate_signature = validate_signature($set_uri, $set_post_params, $set_signature, $set_auth_token);

//Example XML - Generic Response if FALSE
if ($validate_signature == false) {
	echo "<?xml version='1.0' encoding='UTF-8'?>" . "\n";
	echo "<Response>" . "\n";
	echo "</Response>" . "\n";
	exit;
}

//Signature is Valid - Do Something Here

?>