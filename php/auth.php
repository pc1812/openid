<?php
    
    // status code
    // 0: success
    // 1: failure
    // 2: error
    // 3: waiting on registry (not here)
    // 4: waiting on reclaim (not here)
    // 5: unauthorized
    // 6: system error
    // 7: email unregistered
    
    include 'config.php';
    include 'header.php';
    
    $status = isset($_GET["status"])?$_GET["status"]:0;
    
    if(isset($_GET["redirect_url"])) {
        $redirect_url = $_GET["redirect_url"];
    }
    
    if(isset($_GET["access_scope"])) {
        $access_scope = $_GET["access_scope"];
    }
?>

<!--FB JavaScript--!>
<script>

var fbConnected;
var fbToken;
var fbChecking;

// Load the SDK asynchronously
(function(d){
 var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
 if (d.getElementById(id)) {return;}
 js = d.createElement('script'); js.id = id; js.async = true;
 js.src = "//connect.facebook.net/en_US/all.js";
 ref.parentNode.insertBefore(js, ref);
 }(document));

window.fbAsyncInit = function() {
    FB.init({
            appId      : '155968294431363',
            status     : true, // check login status
            cookie     : true, // enable cookies to allow the server to access the session
            xfbml      : true  // parse XFBML
            });
    
    // Here we subscribe to the auth.authResponseChange JavaScript event. This event is fired
    // for any authentication related change, such as login, logout or session refresh. This means that
    // whenever someone who was previously logged out tries to log in again, the correct case below
    // will be handled.
    FB.Event.subscribe('auth.authResponseChange', function(response) {
                       // Here we specify what we do with the response anytime this event occurs.
                       if (response.status === 'connected') {
                       // The response object is returned with a status field that lets the app know the current
                       // login status of the person. In this case, we're handling the situation where they
                       // have logged in to the app.
                       fbConnected = 1;
                       fbToken = response.authResponse.accessToken;
                       } else if (response.status === 'not_authorized') {
                       // In this case, the person is logged into Facebook, but not into the app, so we call
                       // FB.login() to prompt them to do so.
                       // In real-life usage, you wouldn't want to immediately prompt someone to login
                       // like this, for two reasons:
                       // (1) JavaScript created popup windows are blocked by most browsers unless they
                       // result from direct interaction from people using the app (such as a mouse click)
                       // (2) it is a bad experience to be continually prompted to login upon page load.
//                       FB.login();
                       fbConnected = 0;
                       fbToken = "";
                       } else {
                       // In this case, the person is not logged into Facebook, so we call the login()
                       // function to prompt them to do so. Note that at this stage there is no indication
                       // of whether they are logged into the app. If they aren't then they'll see the Login
                       // dialog right after they log in to Facebook.
                       // The same caveats as above apply to the FB.login() call here.
//                       FB.login();
                       fbConnected = 0;
                       fbToken = "";
                       }
                       });
};

// Here we run a very simple test of the Graph API after login is successful.
// This testAPI() function is only called in those cases.
function testAPI() {
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
           console.log('Good to see you, ' + response.name + '.');
           });
}

</script>
<!--FB JavaScript--!>

<script type="text/javascript">

function getRedirectURL() {
    return '<?php echo isset($redirect_url)?$redirect_url:""; ?>';
}

function getAccessScope() {
    return '<?php echo isset($access_scope)?$access_scope:""; ?>';
}

function doFacebookAuthorization() {
    if(fbConnected > 0 && fbToken !== "") {
        loginWithFB();
    }
    else {
        clearInterval(fbChecking);
        FB.login();
        fbChecking = setInterval(function(){loginWithFB();}, 1000);
    }
}

function loginWithFB() {
    if(fbConnected > 0 && fbToken !== "") {
        var link = "loginfb.php?fb_token="+fbToken;
        if(getRedirectURL() !== "" && getAccessScope() !== "") {
            link += "&redirect_url="+getRedirectURL()+"&access_scope="+getAccessScope();
        }
//        alert(link);
        window.location.href = link;
        clearInterval(fbChecking);
    }
}

function checkRegister() {
	var email = document.getElementById("reg_email");
	var nickname = document.getElementById("reg_nickname");
	var pass = document.getElementById("reg_pass");
	var pass2 = document.getElementById("reg_pass2");
	var email_wrong = document.getElementById("reg_email_wrong");
	var nickname_wrong = document.getElementById("reg_nickname_wrong");
	var pass_wrong = document.getElementById("reg_pass_wrong");
	var pass2_wrong = document.getElementById("reg_pass2_wrong");
    
	email_wrong.style.display="none";
	nickname_wrong.style.display="none";
	pass_wrong.style.display="none";
	pass2_wrong.style.display="none";
	
	if(email.value.indexOf("@")<3 || email.value.length<10 || email.value.length>40) {
		email_wrong.style.display="inline";
		return;
	}
    
	if(nickname.value.length<3) {
		nickname_wrong.style.display="inline";
		return;
	}
    
	if(pass.value.length<4) {
		pass.value="";
		pass2.value="";
		pass_wrong.style.display="inline";
		return;
	}
    
	if(pass.value!=pass2.value) {
		pass.value="";
		pass2.value="";
		pass2_wrong.style.display="inline";
		return;
	}

	document.getElementById("reg_form").submit();
}

function checkReclaim() {
    
	var email = document.getElementById("rec_email");
	var email_wrong = document.getElementById("rec_email_wrong");
    
	email_wrong.style.display="none";
    
	if(email.value.indexOf("@")<3 || email.value.length<10 || email.value.length>40) {
		email_wrong.style.display="inline";
		return;
	}
    
	document.getElementById("rec_form").submit();
}

function changeStatus(status) {
	if(status==1) {
		document.getElementById("regform").style.display = "inline";
		document.getElementById("forgetform").style.display = "none";
		document.getElementById("welcome").style.display = "none";
		document.getElementById("waitrefine").style.display = "none";
		document.getElementById("unauthorized").style.display = "none";
		document.getElementById("error").style.display = "none";
		document.getElementById("noemail").style.display = "none";
	}
	else if(status==2) {
		document.getElementById("regform").style.display = "none";
		document.getElementById("forgetform").style.display = "inline";
		document.getElementById("welcome").style.display = "none";
		document.getElementById("waitrefine").style.display = "none";
		document.getElementById("unauthorized").style.display = "none";
		document.getElementById("error").style.display = "none";
		document.getElementById("noemail").style.display = "none";
	}
	else if(status==3) {
		document.getElementById("regform").style.display = "none";
		document.getElementById("forgetform").style.display = "none";
		document.getElementById("welcome").style.display = "inline";
		document.getElementById("waitrefine").style.display = "none";
		document.getElementById("unauthorized").style.display = "none";
		document.getElementById("error").style.display = "none";
		document.getElementById("noemail").style.display = "none";
	}
	else if(status==4) {
		document.getElementById("regform").style.display = "none";
		document.getElementById("forgetform").style.display = "none";
		document.getElementById("welcome").style.display = "none";
		document.getElementById("waitrefine").style.display = "inline";
		document.getElementById("unauthorized").style.display = "none";
		document.getElementById("error").style.display = "none";
		document.getElementById("noemail").style.display = "none";
	}
	else if(status==5) {
		document.getElementById("regform").style.display = "none";
		document.getElementById("forgetform").style.display = "none";
		document.getElementById("welcome").style.display = "none";
		document.getElementById("waitrefine").style.display = "none";
		document.getElementById("unauthorized").style.display = "inline";
		document.getElementById("error").style.display = "none";
		document.getElementById("noemail").style.display = "none";
	}
	else if(status==6) {
		document.getElementById("regform").style.display = "none";
		document.getElementById("forgetform").style.display = "none";
		document.getElementById("welcome").style.display = "none";
		document.getElementById("waitrefine").style.display = "none";
		document.getElementById("unauthorized").style.display = "none";
		document.getElementById("error").style.display = "inline";
		document.getElementById("noemail").style.display = "none";
	}
	else if(status==7) {
		document.getElementById("regform").style.display = "none";
		document.getElementById("forgetform").style.display = "none";
		document.getElementById("welcome").style.display = "none";
		document.getElementById("waitrefine").style.display = "none";
		document.getElementById("unauthorized").style.display = "none";
		document.getElementById("error").style.display = "none";
		document.getElementById("noemail").style.display = "inline";
	}
	else {
		document.getElementById("regform").style.display = "none";
		document.getElementById("forgetform").style.display = "none";
		document.getElementById("welcome").style.display = "none";
		document.getElementById("waitrefine").style.display = "none";
		document.getElementById("unauthorized").style.display = "none";
		document.getElementById("error").style.display = "none";
		document.getElementById("noemail").style.display = "none";
	}
}

function showforum() {
	var vis = document.getElementById("forumdb").style.display;
	if(vis=='inline')
		document.getElementById("forumdb").style.display = "none";
	else
		document.getElementById("forumdb").style.display = "inline";
}

function acceptRequest(redirectURL, accessScope) {
    link = "index.php";
    if(redirectURL!="")
        link += "?redirect_url="+redirectURL;
    if(accessScope!="")
        link += "&access_scope="+accessScope;
    window.location.href = link;
}

function anotherAccount(redirectURL, accessScope) {
    link = "auth.php?logout=1";
    if(redirectURL!="")
        link += "&redirect_url="+redirectURL;
    if(accessScope!="")
        link += "&access_scope="+accessScope;
    window.location.href = link;
}

</script>

<body onload='changeStatus(<?php echo $status; ?>);'>

<table width='100%' height='100%'>
<tr>


<td valign='top' align='center' width='50%'>

<?php
    echo "<form action='login.php' method='post'>";
    echo "<img class='main_logo'/>";
    echo "<h2 align='center'>$str_username:&nbsp;&nbsp;<input type='text' name='username'/></h2>";
    echo "<h2 align='center'>$str_password:&nbsp;&nbsp;<input type='password' name='password'/></h2>";
    
    echo "<h2 align='center'>";
    
    echo "<input type='submit' class='openid_button' value='$str_login'/> ";
    
    echo "<input type='button'  class='openid_button' value='$str_register' onclick='changeStatus(1)'/> ";
    
    echo "<input type='button' class='openid_button_facebook' onclick='doFacebookAuthorization()' value='facebook'/>";
    echo "</h2>";
    
    if(isset($redirect_url)) {
		$redirect_url = urldecode($redirect_url);
        $redirect_hostname = parse_url($redirect_url, PHP_URL_HOST);
        echo "<input type='hidden' name='redirect_url' value='$redirect_url'/>";
        echo "<h2>$str_request_from $redirect_hostname</h2>";
    }
    
    
    if(isset($access_scope)) {
        echo "<input type='hidden' name='access_scope' value='$access_scope'/>";
        echo "<table width=200><tr>";
        echo "<td valign=top align=left>$str_requires: </td>";
        echo "<td valign=top align=right><p class='postercontent'>";
        $access_items = explode(",", $access_scope);
        foreach($access_items as $access_item) {
            if($access_item=="nickname") {
                echo "$str_nickname<br>";
            }
            else if($access_item=="email") {
                echo "$str_email<br>";
            }
            else if($access_item=="renaming") {
                echo "$str_renaming<br>";
            }
        }
        echo "</td>";
        echo "</tr></table>";
    }
    
    echo "<hr>";
?>
<!--
<h2 align='center' id='forumdb' style='display: none'><?php echo 'datacode' ?>:<input type='text' name='forumdb'/></h2>
 -->
</form>

<?php include 'langlist.php'; ?>

</td>

<td valign='top'>

<div id='regform' style='display: none'>
<?php
    echo "<form id='reg_form' method='post' action='register.php'>";
    if(isset($redirect_url)) {
        echo "<input type='hidden' name='redirect_url' value='".$redirect_url."'/>";
    }
    if(isset($access_scope)) {
        echo "<input type='hidden' name='access_scope' value='".$access_scope."'/>";
    }
    echo $str_ind_regform;
    echo "</form>";

    ?>
</div>

<div id='forgetform' style='display: none'>
<?php
    echo "<form id='rec_form' method='post' action='reclaim.php'>";
    if(isset($redirect_url)) {
        echo "<input type='hidden' name='redirect_url' value='".$redirect_url."'/>";
    }
    if(isset($access_scope)) {
        echo "<input type='hidden' name='access_scope' value='".$access_scope."'/>";
    }
    echo $str_ind_forgetform;
    echo "</form>";
    
    ?>
</div>

<div id='welcome' style='display: none'>
<?php echo $str_ind_welcome ?>
</div>

<div id='waitrefine' style='display: none'>
<?php echo $str_ind_waitrefine ?>
</div>

<div id='unauthorized' style='display: none'>
<?php echo $str_ind_unauthorized ?>
</div>

<div id='error' style='display: none'>
<?php echo $str_ind_error ?>
</div>

<div id='noemail' style='display: none'>
<?php echo $str_ind_noemail ?>
</div>

<?php
    //include 'news.php'
?>

</td>
</tr>

<tr>
<td align='center'>
<?php
    //include 'langlist.php';
?>
</td>
</tr>

<tr>
<td></td>
<td align='right' valign='bottom'>
<div onclick='showforum()'>copyright ©</div>
</td>
</tr>
</table>

<div id='fb-root'></div>