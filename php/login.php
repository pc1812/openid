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

    $user_host=$_SERVER["REMOTE_ADDR"];
    $user_port=$_SERVER["REMOTE_PORT"];
    
    if(!isset($_POST["username"]) || !isset($_POST["password"])) {
        logger($dbconn, "No username/password from $user_host port $user_port");
        header_error("no username");
    }
    
    $username=$_POST["username"];
    $password=$_POST["password"];
    
    if(isset($_POST["redirect_url"])) {
        $redirect_url = $_POST["redirect_url"];
    }
    
    if(isset($_POST["access_scope"])) {
        $access_scope = $_POST["access_scope"];
    }
    
    include 'dbconn.php';
    
    $sql="select user_id, password, password('$password') from guser where LOWER(username)=LOWER('$username')";
    $result=query_header_error($dbconn, $sql);
    
    if(1==mysql_num_rows($result)) {
        $row = mysql_fetch_row($result);
        
        $user_id=$row[0];
        $user_password=$row[1];
        $encoded_password=$row[2];
        
        // login successfully.
        if($encoded_password==$user_password) {
            
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
            
        }
        // password is wrong.
        else {
            
            logger($dbconn, "Failed password for $username($user_id) / $password from $user_host port $user_port");
            
            mysql_close($dbconn);
            
            $getdata=urlencode($redirect_url);
            header("Location: auth.php?status=2&redirect_url=$getdata&access_scope=$access_scope");
            die();
        }
    }
    // username doesn't exist.
    else {
        logger($dbconn, "Failed username for $username / $password from $user_host port $user_port");
        
        mysql_close($dbconn);
        $getdata=urlencode($redirect_url);
        header("Location: auth.php?status=1&redirect_url=$getdata&access_scope=$access_scope");
        die();
    }
    
    ?>