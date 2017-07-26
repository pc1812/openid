<?php
    
    $mydomain = $_SERVER['HTTP_HOST'];
    $host = "http://".$mydomain;
    $host_root = $host."/openid";
    $pgTitle = "Doomeye - Login";
    $pgDesc = "Doomeye Community Center";
    $pgIcon = $host."/art/web/openid/img/favicon.ico";
    $pgCSS = $host."/art/web/openid/css/openid.css";

	$DEBUG_MODE = 1;
    $default_error_msg = "Somthing is wrong!";
	
    /*
     * Return a json with the error/reason.
     */
    function die_json_error($reason) {
        global $DEBUG_MODE;
        global $default_error_msg;
        
        $msg=($DEBUG_MODE > 0)?$msg:$default_error_msg;
        
        $response = array(
                          "error" => $msg
                          );
        die(json_encode($response));
    }
    
    /*
     * Return the result of query.
     * Return a json with the error/reason if the query fails.
     */
    function query_die_json_error($dbconn, $sql) {
        global $DEBUG_MODE;
        global $default_error_msg;
        
        if(!($result=mysql_query($sql))) {
            
            if($DEBUG_MODE > 2)
                $msg = $sql."<br>".mysql_error();
            else if($DEBUG_MODE > 1)
                $msg = mysql_error();
            else
                $msg = $default_error_msg;
            
            $response = array(
                              "error" => $msg
                              );
            
            mysql_close($dbconn);
            die(json_encode($response));
        }
        return $result;
    }
    
    /*
     * Return the affected rows of update.
     * Return a json with the error/reason if the update fails.
     */
    function update_die_json_error($dbconn, $sql) {
        global $DEBUG_MODE;
        global $default_error_msg;
        
        if(!($result=mysql_query($sql))) {
            
            if($DEBUG_MODE > 2)
                $msg = $sql."<br>".mysql_error();
            else if($DEBUG_MODE > 1)
                $msg = mysql_error();
            else
                $msg = $default_error_msg;
            
            $response = array(
                              "error" => $msg
                              );
            
            mysql_close($dbconn);
            die(json_encode($response));
        }
        return mysql_affected_rows();
    }
    
    
    /*
     * Header to error page with the given message.
     */
    function header_error($msg) {
        global $DEBUG_MODE;
        global $default_error_msg;
        
        $msg=($DEBUG_MODE > 0)?$msg:$default_error_msg;
        
        header("Location: error.php?msg=".urlencode($msg));
        die();
    }
    
    /*
     * Return the result of query.
     * Header to error page with the mysql_error if the query fails.
     */
    function query_header_error($dbconn, $sql) {
        global $DEBUG_MODE;
        global $default_error_msg;
        
        if(!($result=mysql_query($sql))) {
            
            if($DEBUG_MODE > 2)
                $msg = $sql."<br>".mysql_error();
            else if($DEBUG_MODE > 1)
                $msg = mysql_error();
            else
                $msg = $default_error_msg;
            
            mysql_close($dbconn);
            header("Location:error.php?msg=".urlencode($msg));
            die();
        }
        
        return $result;
    }
    
    /*
     * Return the affected rows of update.
     * Header to error page with the mysql_error if the update fails.
     */
    function update_header_error($dbconn, $sql) {
        global $DEBUG_MODE;
        global $default_error_msg;
        
        if(!($result=mysql_query($sql))) {
            
            if($DEBUG_MODE > 2)
                $msg = $sql."<br>".mysql_error();
            else if($DEBUG_MODE > 1)
                $msg = mysql_error();
            else
                $msg = $default_error_msg;
            
            mysql_close($dbconn);
            header("Location:error.php?msg=".urlencode($msg));
            die();
        }
        
        return mysql_affected_rows();
    }
    
    /*
     * Log the given message.
     * Return a json with error/reason if the log fails.
     */
    function logger_die_json_error($dbconn, $content) {
        $sql="insert into glog set stamp=now(), content='$content'";
        update_die_json_error($dbconn, $sql);
    }
    
    /*
     * Log the given message.
     * Header to error page with the mysql_error if the update fails.
     */
    function logger($dbconn, $content) {
        $sql="insert into glog set stamp=now(), content='$content'";
        update_header_error($dbconn, $sql);
    }
    
    
    function generate_session($dbconn, $user_id, $user_host, $user_port, $user_language) {
        
        // generate session.
        
        $session_id="";
        while($session_id=="") {
            $session_id = generate_token(10);
            $sql="select session_id from gsession where session_id='$session_id'";
            $result=query_header_error($dbconn, $sql);
            
            if(mysql_num_rows($result)>0) {
                $session_id="";
            }
        }
        
        $sql="insert into gsession (user_id, session_id, user_host, user_port, user_language, session_stamp) values ($user_id, '$session_id', '$user_host', $user_port, '$user_language', now())";
        update_header_error($dbconn, $sql);
        
        // set the new session id to cookie.
        
        setcookie("SESSION", $session_id, time()+86400);
        
        return $session_id;
    }
    
    function generate_request($dbconn, $user_id, $session_id, $redirect_url, $access_scope) {
        
        // generate access.
        
        $access_token="";
        while($access_token=="") {
            $access_token = generate_token(10);
            $sql="select 1 from grequest where access_token='$access_token'";
            $result=query_header_error($dbconn, $sql);
            
            if(mysql_num_rows($result)>0) {
                $access_token="";
            }
        }
        
        $sql="insert into grequest (user_id, session_id, redirect_url, access_token, access_content, access_stamp) values( $user_id, '$session_id', '$redirect_url', '$access_token', '$access_scope', now())";
        update_header_error($dbconn, $sql);
        
        return $access_token;
    }
    
    function generate_user($dbconn, $type, $username, $password, $nickname, $email, $from) {
        
        $unique_id="";
        while($unique_id=="") {
            $unique_id = generate_token(10);
            $sql="select unique_id from guser where unique_id='$unique_id'";
            $result=query_header_error($dbconn, $sql);
            
            if(mysql_num_rows($result)>0) {
                $unique_id="";
            }
        }

        
        $sql="insert into guser (unique_id, type, status, username, password, nickname, create_stamp, email_address, registry_from_url) values ('$unique_id', $type, 1, '$username', password('$password'), '$nickname', now(), '$email', '$from')";
        update_header_error($dbconn, $sql);
        
        $user_id=mysql_insert_id();
        
        return $user_id;
    }
    
    function generate_token($lengthoftoken) {
        
        $token_chars=array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0');
        $token="";
        $i=0;
        while($i<$lengthoftoken) {
            $token .= $token_chars[rand(0, count($token_chars)-1)];
            $i++;
        }
        return $token;
    }
    
    // the detected language will choose a mapping package to include.
    // the package contains the suitable translations of variables.
    // english is the default language package.
    // it affects the content database as well.
    // but it is possible to be replaced by other parameters later.
	if(isset($_COOKIE["language"])) {
        $user_language=$_COOKIE["language"];
    }
    else {
		// if no cookie is set for language,
		// then we use http request setting.
		// if browser doesn't support that,
		// then we use 'en' as default.
        $user_language = isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ? substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2) : "en";
		setcookie("language", $user_language);
    }
	
	if( file_exists("lang/".$user_language.".php") ) {
		include "lang/".$user_language.".php";
	}
    else {
        include 'lang/en.php';
    }
    
    ?>
