
<?php
    
    $current_uri = $_SERVER['REQUEST_URI'];
    $current_uri = urlencode($current_uri);
    
    echo "<form id='lang' action='langupd.php' method='post'>";
    echo "<input type='hidden' name='uri' value='$current_uri'/>";
    echo "<select name='language' onchange='this.form.submit()'>";
    
    echo "<option value='en'";
    if($user_language=="en")
        echo " selected";
    echo ">English</option>";
    
    echo "<option value='zh'";
    if($user_language=="zh")
        echo " selected";
    echo ">中文</option>";

    echo "</select>";
    echo "</form>";
?>
