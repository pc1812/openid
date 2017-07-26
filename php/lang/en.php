<?php

//$forum_name="LOGON";

//$pgTitle = "Doomeye - Login";
//$pgDesc = "Doomeye Community Center";

$str_home="Home";
$str_administrator="Administrator";
$str_Forum = "Forum";
$str_username = "username";
$str_name = "name";
$str_password = "password";
$str_request_from = "Request from";
$str_requires = "requires";
$str_nickname = "nickname";
$str_email = "email-address";
$str_renaming = "change-nickname";
$str_Latest = "Latest";
$str_login = "login";
$str_register = "register";
$str_accept = "accept";
$str_another_account = "account";
$str_find = "find";
$str_logout = "logout";
$str_account = "account";
$str_update = "update";
$str_Sharing = "Sharing";
$str_Replying = "Replying";
$str_cancel = "cancel";
$str_upload_file = "upload file";
$str_post = "post";
$str_reply_to = "replied to";
$str_responses = "Responses";
$str_origin_post = "Origin Post";
$str_processing="Processing...";

$str_ind_regform = "
<h2>Don't have an account yet?</h2>
<p class='postcontent'>
Register right now!
</p>
<table>
<tr>
	<td>Email:</td>
	<td><input type='text' id='reg_email' name='email'/></td>
	<td><div id='reg_email_wrong' style='display:none'><font color='red'>wrong</font></div></td>
</tr>
<tr>
    <td>Nickname:</td>
	<td><input type='text' id='reg_nickname' name='nickname'/></td>
	<td><div id='reg_nickname_wrong' style='display:none'><font color='red'>wrong</font></div></td>
</tr>
<tr>
	<td>Password:</td>
	<td><input type='password' id='reg_pass' name='password'/></td>
	<td><div id='reg_pass_wrong' style='display:none'><font color='red'>wrong</font></div></td>
</tr>
<tr>
	<td>Password again:</td>
	<td><input type='password' id='reg_pass2' name='pass2'/></td>
	<td><div id='reg_pass2_wrong' style='display:none'><font color='red'>wrong</font></div></td>
</tr>
<tr>
	<td></td>
	<td><input type='button' value='send' onclick='checkRegister()'/></td>
</tr>
</table>
<br>
<br>
<input type='button' value='maybe I have an account.' onclick='changeStatus(2)'/>
";

$str_ind_forgetform = "
<h2>Probably forget your account?</h2>
<p class='postcontent'>Your account should be an eamil address 
<br>We will send you a new password.
<br>Please give us your email again.
</p>
<input type='text' id='rec_email' name='email'/>
<input type='button' value='send' onclick='checkReclaim()'/>
<br>
<div id='rec_email_wrong' style='display:none'><font color='red'>wrong</font></div>
<br>
<br>
<input type='button' value='No, I want to register a new one.' onclick='changeStatus(1)'/>
";

$str_ind_welcome = "
<h2>Welcome to our forum !!!</h2>
<p class='postcontent'>Please wait for our registry email.
<br>Thank you for your join.
</p>
";

$str_ind_waitrefine = "
<h2>Your account will be reset.</h2>
<p class='postcontent'>Please wait for our reclaim email.
<br>Thanks for your patience.</p>
";

$str_ind_unauthorized = "
<h2>Unauthorized.</h2>
<p class='postcontent'>You don't have the permission.</p>
";

$str_ind_error = "
<h2>Oops, somthing wrong!</h2>
<p class='postcontent'>Sorry for our system error.
<br>Please try again later.</p>
";
    
$str_ind_noemail = "
<h2>This email is not registered!</h2>
<p class='postcontent'>The email you sent is not registered here.
<br>Maybe try another one or register now.</p>
";

$tips = "
<p class='title'>Tips:</p>
<p class='question'>How to put a link?</p>
<p class='answer'>
Input &lt;a href='http://the-http-link'&gt;about-it&lt;/a&gt;</p>
";

$visitor_tips = "
<p class='title'>Join us to share your opinion.</p>
<p class='question'>Not have an account yet?</p>
<p class='answer'>Only email address, there you go!</p>
<p class='question'>What to do with the account?</p>
<p class='answer'>Share your words with our community.</p>
<p class='question'>Upload other stuff?</p>
<p class='answer'>Pictures, videos or PDF, all cool!</p>
<p class='question'>What is the game?</p>
<p class='answer'>A real-time strategy game is what we provide.</p>
<p class='question'>How do we want to make the game?</p>
<p class='answer'>Simple and FUN.</p>
<p class='question'>What is the target for players?</p>
<p class='answer'>I came, I see, I conquer.</p>
<p class='question'>Play the game without an account?</p>
<p class='answer'>You surely do. only without records.</p>
";

$str_recent_post = "Recent Posts";
$str_from_hoster="From Hoster";
    
    
$str_pwdreset_form = "
    <h1>Doomeye</h1>
    <h2>Password Reset</h2>
    <p class='postcontent'>
    Please type your new password to reset
    </p>
    <table>
    <tr>
    <td>Password:</td>
	<td><input type='password' id='update_pwd_form_pass_1' name='password'/></td>
	<td><div id='update_pwd_form_pass_1_wrong' style='display:none'><font color='red'>wrong</font></div></td>
    </tr>
    <tr>
	<td>Password again:</td>
	<td><input type='password' id='update_pwd_form_pass_2'/></td>
	<td><div id='update_pwd_form_pass_2_wrong' style='display:none'><font color='red'>wrong</font></div></td>
    </tr>
    <tr>
	<td></td>
	<td><input type='button' value='send' onclick='checkPasswordReset()'/></td>
    </tr>
    </table>
";

?>