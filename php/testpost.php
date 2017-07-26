<?php

$access_token=$_GET["access_token"];
if(isset($access_token)) {
	echo $access_token;
	
$ch = curl_init("http://localhost/openid/auth.php?access_token=$access_token");
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt( $ch, CURLOPT_HEADER, 0);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

$json = curl_exec( $ch );
curl_close($ch);

$response = json_decode($json);
	
$status = $response->{'status_code'};
$user_id = $response->{'id'};
$user_nickname = $response->{'nickname'};

echo $status;
echo $user_id;
echo $user_nickname;
	die();
}
else {
	header("Location: index.php?redirect_url=".urlencode("http://localhost/openid/testpost.php"));
	die();	
}
header('Host: index.php localhost');
header('Connection: close');
header('Content-type: application/x-www-form-urlencoded');
header('Content-length: ' . $content_length);
header('');
header($post_data);

die();
?>