<?php
    
    include 'config.php';
    include 'dbconn.php';
    
    
    $addr=$_SERVER["REMOTE_ADDR"];
    $port=$_SERVER["REMOTE_PORT"];
    
    if(!isset($_GET["access_token"])) {
        
        logger_die_json_error($dbconn, "Access without accesstoken from $addr port $port");
        
        mysql_close($dbconn);
        die_json_error("no access token");
    }
    
    $access_token=$_GET["access_token"];
    
    $sql="select user_id, access_content, redirect_url from grequest where access_token='$access_token' and date_add(access_stamp, INTERVAL (select int_value from gconfig where config_name='REQUEST_EXPIRE_MINUTES') MINUTE)>now() and user_id is not null";
    $result=query_die_json_error($dbconn, $sql);
    
    $row_num = mysql_num_rows($result);
    if($row_num==1) {
        //
        // success
        //
        $row = mysql_fetch_row($result);
        $ind=0;
        $user_id=$row[$ind++];
        $access_content=$row[$ind++];
        $redirect_url=$row[$ind++];
        
        logger_die_json_error($dbconn, "Access with accesstoken $access_token($user_id) from $addr port $port");
        
        $access_itmes=explode(",", $access_content);
        
        $response_items=array();
        $item_ind = 0;
        
        $sql = "select unique_id ";
        $query_items[$item_ind++] = "unique_id";
        
        
        foreach($access_itmes as $access_itme) {
            if($access_itme=="nickname") {
                $sql .= ", nickname";
                $query_items[$item_ind++] = "nickname";
            }
            else if($access_itme=="email") {
                $sql .= ", email_address";
                $query_items[$item_ind++] = "email";
            }
        }
        
        $sql .= " from guser where user_id=$user_id";
        $result=query_die_json_error($dbconn, $sql);
        
        $arow = mysql_fetch_row($result);
        
		$response = array();
        
        foreach($query_items as $query_ind => $query_name ) {
            
			$response[$query_name] = $arow[$query_ind];
        }
        
        
//		$response = array(
//                          "unique_id" => $unique_id
//                          );
//		
//		if(isset($user_nickname))
//			$response["nickname"] = $user_nickname;
//		if(isset($user_email))
//			$response["email"] = $user_email;
        
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