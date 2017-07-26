<?PHP
    
    header("HTTP/1.0 404 Not Found"); die();
    $mydomain="localhost";
    $openid_auth_url="http://$mydomain/openid/auth.php";
    $openid_access_url="http://$mydomain/openid/access.php";
    
    $openid_redirect_url="http://$mydomain/openid/test.php";
    
    if(!isset($_GET["access_token"])) {
        
        $link="Location: $openid_auth_url?redirect_url=".urlencode($openid_redirect_url)."&access_scope=nickname,email";
        
        if(isset($language))
            $link.="&language=$language";
        
        header($link);
        die();

    }
    
    $access_token=$_GET["access_token"];
    
    $ch = curl_init($openid_access_url."?access_token=".$access_token);
    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt( $ch, CURLOPT_HEADER, 0);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
    
    $json = curl_exec( $ch );
    curl_close($ch);
    
    $response = json_decode($json);
    
    // Error happened.
    
    if(isset($response->error)) {
        $error = $response->{'error'};
        echo $error;
        die();
    }
    
    // Access user profile.
    
    $user_id = $response->{'unique_id'};
    echo $user_id;
    
    die();

?>