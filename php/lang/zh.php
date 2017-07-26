<?php

//$forum_name="登入";

$pgTitle = "Doomeye - 登入";
$pgDesc = "Doomey 社群中心";

$str_home="首頁";
$str_administrator="管理者";
$str_Forum = "論壇";
$str_username = "帳號";
$str_name = "名稱";
$str_password = "密碼";
$str_request_from = "來自";
$str_requires = "需要取得";
$str_nickname = "暱稱";
$str_email = "信箱";
$str_renaming = "更改暱稱";
$str_login = "登入";
$str_register = "註冊";
$str_accept = "接受";
$str_another_account = "其他帳號";
$str_find = "搜尋";
$str_logout = "登出";
$str_account = "帳號";
$str_update = "更新";
$str_Sharing = "分享";
$str_Replying = "回應";
$str_cancel = "取消";
$str_upload_file = "上傳檔案";
$str_post = "發表";
$str_reply_to = "回應";
$str_responses = "個回應";
$str_origin_post = "原文";
$str_processing="運行中...";

$str_ind_regform = "
<h2>還沒有帳號嗎？</h2>
<p class='postcontent'>
馬上註冊!
</p>
<table>
<tr>
	<td>電子信箱:</td>
	<td><input type='text' id='reg_email' name='email'/></td>
	<td><div id='reg_email_wrong' style='display:none'><font color='red'>錯誤</font></div></td>
</tr>
<tr>
<td>暱稱:</td>
	<td><input type='text' id='reg_nickname' name='nickname'/></td>
	<td><div id='reg_nickname_wrong' style='display:none'><font color='red'>錯誤</font></div></td>
</tr>
<tr>
	<td>密碼:</td>
	<td><input type='password' id='reg_pass' name='password'/></td>
	<td><div id='reg_pass_wrong' style='display:none'><font color='red'>錯誤</font></div></td>
</tr>
<tr>
	<td>確認密碼:</td>
	<td><input type='password' id='reg_pass2' name='pass2'/></td>
	<td><div id='reg_pass2_wrong' style='display:none'><font color='red'>錯誤</font></div></td>
</tr>
<tr>
	<td></td>
	<td><input type='submit' value='送出' onsubmit='checkRegister()'/></td>
</tr>
</table>
<br>
<br>
<input type='button' value='也許我有註冊過.' onclick='changeStatus(2)'/>
";

$str_ind_forgetform = "
<h2>忘記了密碼?</h2>
<p class='postcontent'>你的帳號就是你的電郵信箱，
<br>我們會將密碼寄給你。
<br>請再給我們一次你的信箱。
</p>
<input type='text' id='rec_email' name='email'/>
<input type='button' value='送出' onclick='checkReclaim()'/>
<br>
<div id='rec_email_wrong' style='display:none'><font color='red'>錯誤</font></div>
<br>
<br>
<input type='button' value='不，我想申請新的帳號' onclick='changeStatus(1)'/>
";

$str_ind_welcome = "
<h2>歡迎加入我們！！！</h2>
<p class='postcontent'>請等待我們的確認函。
<br>再一次感謝你的加入。
</p>
";

$str_ind_waitrefine = "
<h2>你已經重置密碼</h2>
<p class='postcontent'>請等待我們的回信。
<br>感謝你的耐心等候。</p>
";

$str_ind_unauthorized = "
<h2>未經授權</h2>
<p class='postcontent'>你尚未擁有瀏覽的權限。</p>
";

$str_ind_error = "
<h2>喔喔, 出錯了!</h2>
<p class='postcontent'>很抱歉，我們的系統發生問題了。
<br>請稍候再試試看。</p>
";
    
$str_ind_noemail = "
<h2>此信箱未註冊!</h2>
<p class='postcontent'>你這個信箱並未在這裡註冊.
<br>也許試試看另外一個，或者馬上註冊？</p>
";
    
$tips = "
<p class='title'>小提示:</p>
<p class='question'>如何放置連結點?</p>
<p class='answer'>
輸入 &lt;a href='http://路徑'&gt;關於連結的描述&lt;/a&gt;</p>
";

$visitor_tips = "
<p class='title'>趕快來加入我們吧！</p>
<p class='question'>還沒有帳號？</p>
<p class='answer'>你只需要提供一個電郵信箱，就可以申請帳號了。</p>
<p class='question'>有了帳號可以幹嘛？</p>
<p class='answer'>你可以用你的帳號來提出建議，問題或者意見。</p>
<p class='question'>那關於上傳檔案呢？</p>
<p class='answer'>有了帳號就可以簡單與我們分享任何型式的檔案。</p>
<p class='question'>關於遊戲又是如何呢？</p>
<p class='answer'>我們提供一個多人的線上即時策略遊戲。</p>
<p class='question'>我們打算如何建構我們的遊戲呢？</p>
<p class='answer'>簡單，有趣。</p>
<p class='question'>玩家在遊戲裡的目標是什麼？</p>
<p class='answer'>我來了，我看到，我征服。</p>
<p class='question'>沒有帳號也可以玩遊戲嗎？</p>
<p class='answer'>當然。只是很可惜地我們無法幫你保留戰績。</p>
";

$str_recent_post = "最新回應";
$str_from_hoster="板主的話";
    
$str_pwdreset_form = "
    <h1>Doomeye</h1>
    <h2>密碼重置</h2>
    <p class='postcontent'>
    請輸入新的密碼來重置你的密碼
    </p>
    <table>
    <tr>
    <td>密碼:</td>
	<td><input type='password' id='update_pwd_form_pass_1' name='password'/></td>
	<td><div id='update_pwd_form_pass_1_wrong' style='display:none'><font color='red'>錯誤</font></div></td>
    </tr>
    <tr>
	<td>確認密碼:</td>
	<td><input type='password' id='update_pwd_form_pass_2'/></td>
	<td><div id='update_pwd_form_pass_2_wrong' style='display:none'><font color='red'>錯誤</font></div></td>
    </tr>
    <tr>
	<td></td>
	<td><input type='button' value='送出' onclick='checkPasswordReset()'/></td>
    </tr>
    </table>
";

?>