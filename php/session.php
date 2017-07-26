<?php
    
    $username="";
    $user_nickname="Guest";
    $session_id=NULL;
    
    if(isset($_COOKIE["SESSION"])) {
        $session_id=$_COOKIE["SESSION"];
        
        // check session.
        
        $sql="select ifnull(user_id, 0) from gsession where date_add(session_stamp,interval (select int_value from gconfig where config_name='SESSION_EXPIRE_MINUTES') minute)>now() and session_id='$session_id' and session_status=1";
        $result=query_header_error($dbconn, $sql);
        
        // valid session
        if(1==mysql_num_rows($result)) {
            $row=mysql_fetch_row($result);
            $ind=0;
            $user_id=$row[$ind++];
            //            $redirect_url=$row[$ind++];
            //            $access_scope=$row[$ind++];
            //
            //            if(isset($_GET["language"])) {
            //                // it means the user change the language by request
            //                $user_language=$_GET["language"];
            //                $sql="update gopenid set user_language='$user_language' where session_id='$session_id'";
            //                update_header_error($dbconn, $sql);
            //            }
            
            // get the profile of the user.
            $sql="select username, nickname from guser where user_id=$user_id";
            $result=query_header_error($dbconn, $sql);
            
            // user is valid.
            if(1==mysql_num_rows($result)) {
                
                
                $row=mysql_fetch_row($result);
                $ind=0;
                $username=$row[$ind++];
                $user_nickname=$row[$ind++];
            }
            // invalid user with an existent session.
            else {
                // reset status in db
                $sql="update gsession set session_status=0 where session_id='$session_id'";
                $result=query_header_error($dbconn, $sql);
                
                // reset session to null
                $session_id=NULL;
                setcookie("SESSION", $session_id);
            }
            
        }
        // invalid session.
        else{
            // reset session to null
            $session_id=NULL;
            setcookie("SESSION", $session_id);
        }
    }
    
    
    ?>