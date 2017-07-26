<?php

include 'config.php';
include 'dbconn.php';
    
    $addr=$_SERVER["REMOTE_ADDR"];
    $port=$_SERVER["REMOTE_PORT"];
    
    $email = $_POST["email"];
    $redirect_url=isset($_POST["redirect_url"])?$_POST["redirect_url"]:NULL;
    $access_scope=isset($_POST["access_scope"])?$_POST["access_scope"]:NULL;
    
    if($email==null || strlen($email)<10 || strrpos($email, "@")<3 || strlen($email)>40) {
        logger($dbconn, "Failed reclaim for $email from $addr port $port");
        mysql_close($dbconn);
        
        header_error("Reclaim information is wrong");
    }
    
    $sql = "select user_id, nickname from guser where LOWER(username)=LOWER('".$email."')";
    $result = query_header_error($dbconn, $sql);
    
    $num = mysql_num_rows($result);
    if($num!=1) {
        logger($dbconn, "No user for reclaim email $email from $addr port $port");
        mysql_close($dbconn);
        
        $status = 7;
    }
    else {
        
        // get user id
        
        $row = mysql_fetch_row($result);
        $ind = 0;
        $user_id = $row[$ind++];
        $nickname = $row[$ind++];
        
        // generate reclaim
        
        $reclaim_token = generate_token(30);
        $href = $host_root."/update_pwd.php?token=".$reclaim_token;
        
        $sql = "insert into greclaim (user_id, reclaim_token, reclaim_stamp) values ($user_id, '$reclaim_token', now())";
        update_header_error($dbconn, $sql);
        
        logger($dbconn, "Reclaim for user $email($user_id) from $addr port $port");
        
        mysql_close($dbconn);
        
        
        $subject = "From Doomeye Support";
        
        $message = "Hello, ".$nickname."\n\n";
        $message .= "Please click the below link to reset your password.\n\n";
        $message .= $href."\n\n";
        $message .= "Please don't reply this email.\n\n";
        $message = wordwrap($message, strlen($message));
        
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        //$headers .= 'Content-type: text/html; charset=u' . "\r\n";
        
        // Additional headers
        //$headers .= 'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";
        $headers .= "From: Doomeye <autoreply@".$mydomain.">" . "\r\n";
        //$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
        //$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";
        
        mail($email, $subject, $message, $headers);
        
        $status = 4;
    }
    
    
    
    $link = "Location: auth.php?status=$status";
    if(!empty($redirect_url) && !empty($access_scope)) {
        $getdata=urlencode($redirect_url);
        $link .= "&redirect_url=$getdata&access_scope=$access_scope";
    }
//    echo $_POST["redirect_url"];
//    echo "<br>";
//    echo $link;
    header($link);
    die();

?>