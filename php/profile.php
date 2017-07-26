<?php

    include 'config.php';
    include 'dbconn.php';
    include 'session.php';
    include 'header.php';
    
    // no session is set
    if(!isset($session_id)) {
        header("Location: $host_root/auth.php");
        die();
    }
    
    // update nickname
    if(isset($_POST["nickname"])) {
        $user_nickname=$_POST["nickname"];
        
        $sql="update guser set nickname='$user_nickname' where user_id=$user_id";
        if(!$result=mysql_query($sql)) {
            $msg = mysql_error();
        }
        else {
            $msg = "updated successfully!";
        }
    }
    
    // update password
    if(isset($_POST["password2"]) && isset($_POST["password3"])) {
        $password2=$_POST["password2"];
        $password3=$_POST["password3"];
        if(strlen($password2)>0) {
            if(strlen($password2)<8) {
                $msg = "your password is too short (8)";
            }
            if($password2!=$password3) {
                $msg = "repeat your password correctly";
            }
            
            $sql="update guser set password=password('$password2') where user_id=$user_id";
            if(!$result=mysql_query($sql)) {
                $msg = mysql_error();
            }
            else {
                $msg = "updated successfully!";
            }
        }
    }
    
    mysql_close($dbconn);

?>

<!--  Diplay the profile form -->

<img class='home_logo' onclick="window.location.href='index.php'"/>

<form action='profile.php' method='post'>

<h1>Profile</h1>

<h3>Display Name<br>
<input name='nickname' type='text' value='<?php echo $user_nickname; ?>'/>
</h3>

<h3>New Passowrd<br>
<input name='password2' type='password' value=''/>
</h3>

<h3>Repeat Passowrd<br>
<input name='password3' type='password' value=''/>
</h3>

<p><input class='openid_button' onclick='this.form.submit()' value='send'/></p>

</form>

<?php
    
    
    if(isset($msg)) {
        echo "<h3>".$msg."</h3>";
    }
    
    
    ?>

