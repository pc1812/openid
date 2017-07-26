<?php
/**

 It is also a home page of the site of openid when there is no specific redirection request.
 
 
 */
    include 'config.php';
    include 'dbconn.php';
    include 'session.php';
  
    // No session is set
    if(!isset($session_id)) {
        mysql_close($dbconn);
        header("Location: $host_root/auth.php");
        die();
    }
    
    mysql_close($dbconn);
    
    include 'header.php';
?>

<img class='home_logo'>
<h1>Home</h1>
<h2>Welcome, <?php echo $user_nickname; ?></h2>
<p><input class='openid_button' value='profile' onclick="window.location.href='profile.php'"/></p>
<p><input class='openid_button' value='logout' onclick="window.location.href='logout.php'"/></p>

