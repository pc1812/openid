<?php

    /**
     *
     * Only do the logout.
     *
     **/
    
    include 'config.php';
    include 'dbconn.php';
    include 'session.php';
    include 'header.php';
    
    // Logout the current session
    if(isset($session_id)) {
        
        // reset status in db
        $sql="update gsession set session_status=0 where session_id='$session_id'";
        $result=query_header_error($dbconn, $sql);
        
        // reset session to null
        $session_id=NULL;
        setcookie("SESSION", $session_id);
        
    }
    
    mysql_close($dbconn);
?>

<img class='home_logo' onclick='window.location.href="index.php"'>
<h1>Good Bye!</h1>



