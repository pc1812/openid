

function checkPasswordReset() {
	var pass = document.getElementById("update_pwd_form_pass_1");
	var pass2 = document.getElementById("update_pwd_form_pass_2");
	var pass_wrong = document.getElementById("update_pwd_form_pass_1_wrong");
	var pass2_wrong = document.getElementById("update_pwd_form_pass_2_wrong");
    
    pass_wrong.style.display="none";
	pass2_wrong.style.display="none";
	
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
    
	document.getElementById("update_pwd_form").submit();
}

