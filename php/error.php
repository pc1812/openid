<?php
    include 'config.php';
    include 'header.php';
    
    
    echo "<img class='home_logo' onclick='window.location.href=\"index.php\"'/>";
    echo "<h1>Sorry, there is a problem!</h1>";
    
    if(isset($_GET["msg"])) {
        $msg=$_GET["msg"];
        
        echo "<h2>Details:</h2>";
        echo "<h3>$msg</h3>";
    }

    die();
?>
