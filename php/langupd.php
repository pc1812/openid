
<?php
    
    $from_uri = " http://".$_SERVER['HTTP_HOST'].urldecode($_POST["uri"]);
    $user_language = $_POST["language"];
    
    echo $_COOKIE["language"];
    echo "<br>";
    echo $from_uri;
    echo "<br>";
    echo $user_language;
    
    setcookie("language", $user_language);
    
    header("Location: $from_uri");
    
    die();
?>
