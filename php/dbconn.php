<?php
    
    $mysqlhost="localhost";
    $mysqluser="";
    $mysqlpassword="";
    $sysdb="my_openid";
    $dbencoding="utf8";
    
    $dbconn = mysql_connect($mysqlhost, $mysqluser, $mysqlpassword);
    if(!$dbconn) {
        header_error("Database connection failed");
        die();
    }
    
    
    mysql_set_charset($dbencoding, $dbconn);
    
    mysql_select_db($sysdb);
    

?>
