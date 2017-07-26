<?php

    
    include 'config.php';
    include 'dbconn.php';
    include 'header.php';
    
    // get user id from a valid token which is not expired and not used.
    function getUserIdFromToken($dbconn, $reclaim_token ) {
        $sql = "select user_id from greclaim where reclaim_token='$reclaim_token' and date_add(reclaim_stamp,interval (select int_value from gconfig where config_name='RECLAIM_TOKEN_EXPIRE_MINUTES') minute)>now() and is_used=0";
        $result = query_header_error($dbconn, $sql);
        if(mysql_num_rows($result)!=1) {
            logger($dbconn, "Duplicated reclaim token $reclaim_token");
            
            mysql_close($dbconn);
            header_error("We got confused!");
        }
        $row = mysql_fetch_row($result);
        $ind = 0;
        $user_id = $row[$ind++];
        return $user_id;
    }
    
    
    $addr=$_SERVER["REMOTE_ADDR"];
    $port=$_SERVER["REMOTE_PORT"];
    
    if(isset($_GET['token'])) {
        
        // prompt input mode
        
        $reclaim_token = $_GET['token'];
        $user_id = getUserIdFromToken($dbconn, $reclaim_token);
        
        echo "<script src='update_pwd.js'></script>";
        
        echo "<img class='home_logo' onclick='window.location.href=\"index.php\"'>";
        
        echo "<form id='update_pwd_form' method='post' action='update_pwd.php'>";
        echo "<input type='hidden' name='token' value='".$reclaim_token."'/>";
        
        echo "<h2>Password Reset</h2>";
        
        echo "<h3>New Password: ";
        echo "<input type='password' id='update_pwd_form_pass_1' name='password'/>";
        echo "<div id='update_pwd_form_pass_1_wrong' style='display:none'><font color='red'>wrong</font></div>";
        echo "</h3>";
        
        echo "<h3>Repeat Password: ";
        echo "<input type='password' id='update_pwd_form_pass_2'/>";
        echo "<div id='update_pwd_form_pass_2_wrong' style='display:none'><font color='red'>wrong</font></div>";
        echo "</h3>";
        
        echo "<h3><input class='openid_button' value='send' onclick='checkPasswordReset()'/></h3>";
        
        echo "</form>";
        
    }
    else if(isset($_POST['token']) && isset($_POST['password'])) {
        
        // reseting mode
        
        $reclaim_token = $_POST['token'];
        $password = $_POST['password'];
        $user_id = getUserIdFromToken($dbconn, $reclaim_token);
        
        $sql = "update guser set password=password('".$password."') where user_id=".$user_id;
        update_header_error($dbconn, $sql);
        
        $sql = "update greclaim set is_used=1 where reclaim_token='".$reclaim_token."'";
        update_header_error($dbconn, $sql);
        
        logger($dbconn, "Reset password for user ($user_id) from $addr port $port");
        
        mysql_close($dbconn);
        
        echo "<img class='home_logo' onclick='window.location.href=\"index.php\"'>";
        echo "<h2>Your password is reset.</h2>";
        
        die();
        
    }
    else {
        
        // illegal request
        
        logger($dbconn, "Illegal password reset from $addr port $port");
        
        mysql_close($dbconn);
        
        header_error("Page not found");
    }
    

?>