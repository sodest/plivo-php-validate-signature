<?php
//Provide Access to validate_signature Function
require 'plivo.php';

//Enter Credentials - Move Prior to Going Live
$auth_id = "XXXXXXXXXXXXXXXXXXXX";
$auth_token = "YYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYY";

//Get Page URI - Change to "https://" if Needed
$get_uri = "http://" . $_SERVER[HTTP_HOST] . $_SERVER[REQUEST_URI];

//Get Post Parameters
$raw_post_data = file_get_contents('php://input');
$raw_post_array = explode('&', $raw_post_data);
$get_post_params = array();
foreach ($raw_post_array as $keyval) {
	$keyval = explode ('=', $keyval);
	if (count($keyval) == 2)
		$get_post_params[$keyval[0]] = urldecode($keyval[1]);
}

//Get Valid Signature from Plivo
$get_headers = apache_request_headers();
foreach ($get_headers as $header_key => $header_value) {
	if($header_key == "X-Plivo-Signature") {
    	echo $get_signature .= "$header_value";
	}
}

//Variable Change to Match
$get_auth_token = $auth_token;

//Signature Match Returns TRUE (1) - Mismatch Returns FALSE (0)
$validate_signature = validate_signature($get_uri, $get_post_params, $get_signature, $get_auth_token);

//Example XML - Generic Response if FALSE
if ($validate_signature == false) {
	echo "<?xml version='1.0' encoding='UTF-8'?>" . "\n";
	echo "<Response>" . "\n";
	echo "</Response>" . "\n";
	exit;
}

//Signature is Valid - Do Something Here

?>
