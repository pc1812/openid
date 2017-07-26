<?php
    
    // status code
    // 0: success
    // 1: no user
    // 2: wrong password
    // 3: waiting on registry (not here)
    // 4: waiting on reclaim (not here)
    // 5: unauthorized
    // 6: system error
    include 'config.php';
    
    if(!isset($_GET["fb_token"])) {
        header_error("Can't access facebook!");
    }
    
    $fb_access_token=$_GET["fb_token"];
    
    if(isset($_GET["redirect_url"])) {
        $redirect_url = $_GET["redirect_url"];
    }
    
    if(isset($_GET["access_scope"])) {
        $access_scope = $_GET["access_scope"];
    }
    
//    $fb_app_id="155968294431363";
//    $fb_secret="55d5d2a67b297a7b3458a5bd2e507e11";
    
    $fb_link="https://graph.facebook.com/me?access_token=$fb_access_token";
    
    $ch = curl_init($fb_link);
    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt( $ch, CURLOPT_HEADER, 0);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
    
    $json = curl_exec( $ch );
    curl_close($ch);
    
    $response = json_decode($json);
    
    include 'dbconn.php';
    
    $user_host=$_SERVER["REMOTE_ADDR"];
    $user_port=$_SERVER["REMOTE_PORT"];
    
    // Error happened
    if(isset($response->{'error'})) {
        logger($dbconn, "Error happened when access Facebook");
        header_error($response->error->message);
    }
    
    // No expected info
    if(!isset($response->{'email'}) || !isset($response->{'name'})) {
        logger($dbconn, "Empty access from Facebook from $user_host port $user_port");
        header_error("Your Facebook account is not valid");
    }
    
    $username = $response->{'email'};
    $nickname = $response->{'name'};
    
    // query the user id.
    
    $sql="select user_id from guser where LOWER(username)=LOWER('$username')";
    $result=query_header_error($dbconn, $sql);
    
    if(mysql_num_rows($result)>=1) {
        
        // user exists.
        
        $row = mysql_fetch_row($result);
        
        $user_id=$row[0];
        
        // update the user
        $sql="update guser set nickname='$nickname' where user_id=$user_id";
        $result=query_header_error($dbconn, $sql);
        
    }
    else {
        
        // user does not exist.
        
        // create new user.

        $user_id=generate_user($dbconn, 2, $username, $password, $nickname, $username, 'facebook');
        
        logger($dbconn, "New facebook user $username($user_id) from $user_host port $user_port");
    }
    
    // generate session.
    $session_id=generate_session($dbconn, $user_id, $user_host, $user_port, $_COOKIE["language"]);
    
    // default is to redirect to index.
    $link = "Location: index.php";
    
    // or redirect to url if it is given
    if(isset($redirect_url) && isset($access_scope)) {
        $access_token = generate_request($dbconn, $user_id, $session_id, $redirect_url, $access_scope);
        $link = "Location: $redirect_url?access_token=$access_token";
    }
    
    mysql_close($dbconn);
    header($link);
    die();
    
    ?>