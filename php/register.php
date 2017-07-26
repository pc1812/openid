<?php
    
    include 'config.php';
    include 'dbconn.php';
    
    $addr=$_SERVER["REMOTE_ADDR"];
    $port=$_SERVER["REMOTE_PORT"];
    
    $email=$_POST['email'];
    $password=$_POST['password'];
    $nickname=$_POST['nickname'];
    $redirect_url=$_POST['redirect_url'];
    $access_scope=$_POST['access_scope'];
    
    if(empty($email) || empty($password) || empty($nickname)) {
        
        logger($dbconn, "No identification request for register from $addr port $port");
        mysql_close($dbconn);
        
        header_error("Empty request");
    }
    
    $email = strtolower($email);
    
    if($email==null || strlen($email)<10 || strrpos($email, "@")<3 || strlen($email)>40 || strlen($password)<4) {
        
        logger($dbconn, "Failed register for $email from $addr port $port");
        mysql_close($dbconn);
        
        header_error("Register information is wrong");
    }
    
    $sql = "select username from guser where LOWER(username)=LOWER('".$email."')";
    $result = query_header_error($dbconn, $sql);
    
    $num = mysql_num_rows($result);
    if($num>0) {
        
        // the given email is registered.
        
        logger($dbconn, "Duplicated register for $email from $addr port $port");
        mysql_close($dbconn);
        
        $link = "Location: auth.php?status=2";
        if(isset($redirect_url) && isset($access_scope)) {
            $getdata=urlencode($redirect_url);
            $link .= "&redirect_url=$getdata&access_scope=$access_scope";
        }
        header($link);
        die();
    }
    
    $user_id=generate_user($dbconn, 1, $email, $password, $nickname, $email, 'doomeye');
    
    logger($dbconn, "New doomeye user $username($user_id) from $addr port $port");
    
    
    mysql_close($dbconn);
    
	// everything is fine.
    
	$subject = "Welcome to our Doomeye Support";
    
	$message = "Hello,\n\n";
	$message .= "Your password is ".$password."\n\n";
	$message .= "Please don't reply this email.\n\n";
	$message = wordwrap($message, 70);
    
	$headers  = 'MIME-Version: 1.0' . "\r\n";
    //$headers .= 'Content-type: text/html; charset=u' . "\r\n";
    
    // Additional headers
    //$headers .= 'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";
	$headers .= "From: Registry <registry@".$mydomain.">" . "\r\n";
    //$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
    //$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";
    
	mail($email, $subject, $message, $headers);
    
    
    $link = "Location: auth.php?status=3";
    if(!empty($redirect_url) && !empty($access_scope)) {
        $getdata=urlencode($redirect_url);
        $link .= "&redirect_url=$getdata&access_scope=$access_scope";
    }
    
    header($link);
    die();
    


?>