<?php
    
    include 'config.php';
    include 'dbconn.php';
    
    
    $addr=$_SERVER["REMOTE_ADDR"];
    $port=$_SERVER["REMOTE_PORT"];
    
    if(!isset($_GET["access_token"])) {
        
        logger_die_json_error($dbconn, "Update profile without accesstoken from $addr port $port");
        
        mysql_close($dbconn);
        die_json_error("no access token");
    }
    
    $access_token=$_GET["access_token"];
    
    $sql="select user_id from grequest where access_token='$access_token' and date_add(access_stamp, INTERVAL (select int_value from gconfig where config_name='REQUEST_EXPIRE_MINUTES') MINUTE)>now() and access_content like '%renaming%' and user_id is not null";
    $result=query_die_json_error($dbconn, $sql);
    
    $row_num = mysql_num_rows($result);
    if($row_num==1) {
        //
        // success
        //
        $row = mysql_fetch_row($result);
        $ind=0;
        $user_id=$row[$ind++];
        
		$response = array();
        
        if(isset($_GET['nickname'])) {
            $nickname = $_GET['nickname'];
            
            $sql = "update guser set nickname='$nickname' where user_id=$user_id";
            update_die_json_error($dbconn, $sql);
            $response['Nickname'] = $nickname;
            
        }
        
        logger_die_json_error($dbconn, "Update profile with accesstoken $access_token($user_id) from $addr port $port");
        
        mysql_close($dbconn);
		die(json_encode($response));
    }
    else if($row_num>1) {
        //
        // duplicated token
        //
        logger_die_json_error($dbconn, "Duplicated accesstoken $access_token");
        
        mysql_close($dbconn);
        die_json_error("duplicated access token");
    }
    else {
        //
        // no token
        //
        logger_die_json_error($dbconn, "Unvalid accesstoken $access_token from $addr port $port");
        
        mysql_close($dbconn);
        die_json_error("no access token");
        
    }
    
    ?>