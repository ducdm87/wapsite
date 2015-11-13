function checkErrorFirst(fieldName){
	if($('#'+fieldName+'_err').css('display') != 'none'){
		return true;	
	}
	return false;
}
// Show Warning Success
function showWarningSuccess(tmp){
	if(tmp[3] == 'register'){
		var tmp2 = tmp[4].split(".");
		if(tmp2[0] == 'success'){
			var username = $('#username').val();
			if(username.indexOf('.') != -1 || username.indexOf('_') != -1){
				$('#account_has_dot_succ').show();
			}else{
				$('#account_not_dot_succ').show();
			}
		}
	}	
	/////////////// Home
	if(tmp[3] == 'home'){
		var username = $('#username').val();
		if(username){
			if(username.indexOf('.') != -1 || username.indexOf('_') != -1){
				$('#account_has_dot').show();
			}else{
				$('#account_not_dot').show();
			}
		}
	}		

}
//////////
function setAllFocus(){
	var url = window.location.href;
	var tmp = url.split("/");	
	////////////// Set Text for register success 
	showWarningSuccess(tmp);
	//////////////END	
	if(tmp[3] == 'register' || tmp[3] == 'forgotinfo' || tmp[3] == 'profile'){
		$("input:text:first").focus();
		return;
	}
	//Forgot Function	
	if(tmp[3] == 'forgotpass'){
		var tmp2 = tmp[4].split(".");
		if(tmp2[0] == 'gamecode' || tmp2[0] == 'newpass'){
			if(!checkErrorFirst('password')){
				$("input:password:first").focus();
			}			
			return;
		}
		if(tmp2[0] == 'qna'){
			if($('#question').val() == -1){
				$('#question').focus();
			}
			return;
		}		
	}		
	if(tmp[3] == 'changegamecode'){
		var tmp2 = tmp[4].split(".");
		if(tmp2[0] == 'index'){
			if(!checkErrorFirst('password2') || !checkErrorFirst('password')){
				$("input:password:first").focus();
			}			
			return;
		}
	}		
	//Change Function
	if(tmp[3] == 'changepass' || tmp[3] == 'changeqna' || tmp[3] == 'updatepersonalid' || tmp[3] == 'updateaccount' || tmp[3] == 'updateemail'){
		var tmp2 = tmp[4].split(".");
		if(tmp2[0] == 'index'){
			if(!checkErrorFirst('password')){
				$("input:password:first").focus();
			}			
			return;
		}
	}		
	//Reset GameCode
	if(tmp[3] == 'forgotgamecode'){
		var tmp2 = tmp[4].split(".");
		if(tmp2[0] == 'newgamecode'){
			if(!checkErrorFirst('new_password2')){
				$("input:password:first").focus();
			}			
			return;
		}
	}		
}
//type="password" class="keyboardInput"
$(document).ready(function () {
	if($("#pp")){
    	$("#pp").addClass("w_258");			
    	$("#u").addClass("w_258");							
    	$("#pp").addClass("keyboardInput");	
	}
	if($("#sPassWord1")){    	
    	$("#sPassWord1").addClass("keyboardInput");	
	}		
	if($("#sConfirm_PassWord1")){    	
    	$("#sConfirm_PassWord1").addClass("keyboardInput");	
	}		
	if($("#password")){		
		if($("#password").attr("class") == 'txt_260'){
			$("#password").addClass("w_260");
		}		
    	$("#password").addClass("keyboardInput");	
	}		
	if($("#new_password")){    	
    	$("#new_password").addClass("keyboardInput");	
	}		
	if($("#confirm_new_password")){    	
    	$("#confirm_new_password").addClass("keyboardInput");	
	}		
	if($("#password2")){    	
    	$("#password2").addClass("keyboardInput");	
	}		
	if($("#new_password2")){    	
    	$("#new_password2").addClass("keyboardInput");	
	}		
	if($("#confirm_new_password2")){    	
    	$("#confirm_new_password2").addClass("keyboardInput");	
	}	
	setAllFocus();
});
/* #################################### xu ly password #############################*/
var PASSWORD_ERR_NEW_LEN = 'Phải có ít nhất 6 ký tự.';
var PASSWORD_ERR_NEW = 'Bạn phải nhập có ít nhất 1 ký tự chữ, số, hoa và thường.';
var PASWORD_DESCRIPTION = "Chiều dài từ 6-32 ký tự, không gõ tiếng việt có dấu. Để an toàn hơn, bạn nên sử dụng: chữ cái, số, hoa và thường lẫn lộn, ký tự đặc biệt (*,%,...). <br/><a href='../general/guide.38.html#c_3_11' target='_blank'>Xem hướng dẫn đặt mật khẩu an toàn</a>";
var STRONG_PASSWORD = 1;
function show_Meta(field_pass){
	if(field_pass < 6)
		return false;
	var level = password_level(field_pass);
	if(level){
		//level 1
		if((level[0] && !level[1] && !level[2] && !level[3])
			 || (!level[0] && level[1] && !level[2] && !level[3])
			 || (!level[0] && !level[1] && level[2] && !level[3])
			 || (!level[0] && !level[1] && !level[2] && level[3])){			
			$('#meta1').addClass("meta");			
			//STRONG_PASSWORD = 0;
		}
		//level 2
		if((level[0] && level[1] && !level[2] && !level[3]) 
			|| (level[0] && !level[1] && level[2] && !level[3])
			|| (level[0] && !level[1] && !level[2] && level[3])
			
			|| (!level[0] && level[1] && level[2] && !level[3])
			|| (!level[0] && level[1] && !level[2] && level[3])
			
			|| (!level[0] && !level[1] && level[2] && level[3])){
			$('#meta1').addClass("meta");
			$('#meta2').addClass("meta");			
			//STRONG_PASSWORD = 0;
		}else{
			$('#meta2').removeClass("meta");			
		}
		//level 3			
		if((level[0] && level[1] && level[2] && !level[3]) 
			|| (level[0] && level[1] && !level[2] && level[3])
			|| (level[0] && !level[1] && level[2] && level[3])			
			|| (!level[0] && level[1] && level[2] && level[3])){
			$('#meta1').addClass("meta");
			$('#meta2').addClass("meta");		
			$('#meta3').addClass("meta");		
			//STRONG_PASSWORD = 1;
		}
		else{
			$('#meta3').removeClass("meta");			
		}
		//level 4			
		if(level[0] && level[1] && level[2] && level[3]){
			$('#meta1').addClass("meta");
			$('#meta2').addClass("meta");		
			$('#meta3').addClass("meta");		
			$('#meta4').addClass("meta");			
			//STRONG_PASSWORD = 1;
		}else{
			$('#meta4').removeClass("meta");
		}	
	}
}
function check_show_keyboard(){
	if($("#keyboardInputMaster").css('display') == 'table' || $("#keyboardInputMaster").css('display') == 'block'){
		return true;
	}
	return false;
}
function check_GA_keyboard(){
	var url_curent = window.location.href;	
	var arr = url_curent.split("/");
	if(arr[3]){
		var section = arr[3]+'/'+arr[4];
	}else{
		var section = 'login/index.38.html';
	}
	pageTracker._trackPageview('/keyboard/'+section); 
}
function dong_popup(){
	$('#popup-event').hide();
}
function show_mess_game(){
	//var is_game = $('#is_game').val();
	var is_game = 1;
	var sUserName = $('#sUserName').val();
	if(is_game == 1){
		if(sUserName.indexOf('.') != -1 || sUserName.indexOf('_') != -1){
			$('#mess_game').show();
		}else{
			$('#mess_game').hide();
		}		
	}
	return;
}
/////////////// Check GA //////////////////////////////////
/** Select account suggesstion **/
function act_selectAcc_GA(){
	pageTracker._trackPageview('/trackchontengoiylink/index.html');
}
function act_pushRegister_GA(){
	pageTracker._trackPageview('/tracktaotaikhoanbtn/index.html');
}
function act_pushHuyBoRegister_GA(){
	pageTracker._trackPageview('/trackhuybotaotaikhoanbtn/index.html');
}
function act_pushLogin_GA(){
	pageTracker._trackPageview('/trackdangnhapbtn/index.html');
}
function act_accRegisterLink_GA(){
	pageTracker._trackPageview('/trackdangkylink/index.html');
}
function act_accForgotLink_GA(){
	pageTracker._trackPageview('/trackquenthongtinlink/index.html');
}
function act_pushUpdateInfo_GA(){
	pageTracker._trackPageview('/trackcapnhattkbtn/index.html');
}
function act_accOPIDLink_GA(id){
	pageTracker._trackPageview('/trackopenidlink/index.'+id+'.html');
}
function act_ChangePassLink_GA(){
	pageTracker._trackPageview('/trackchangepasslink/index.html');
}
function act_reSendMailActive_GA(opt){
	if(opt == 1){
		pageTracker._trackPageview('/tracksentactivelinksucc/index.html');
	}
	if(opt == 0){
		pageTracker._trackPageview('/tracksentactivelinkfalse/index.html');
	}
}
function act_UpdateProfiePayer_GA(){
	pageTracker._trackPageview('/trackupdateprofilepayer/index.html');
}
/*
Last updated : 24/06/2009
*/
//END tracker GA
//####################################### Password ##################################################
function checkCharLow(c){
	if(c > 96 && c < 123)
		return true;
	return false;
}
function checkCharUp(c){
	if(c > 64 && c < 91)
		return true;
	return false;
}
function checkNum(c){
	if(c > 47 && c < 58)
		return true;
	return false;
}
function checkStringIsNum(str){
	for(i=0;i<str.length;i++){
		if(!checkNum(str.charCodeAt(i)))
			return false;
	}
	return true;
}
function checkCharacter(str){
	for(i=0;i<str.length;i++){
		if((str.charCodeAt(i) < 48 && str.charCodeAt(i) != 46)|| str.charCodeAt(i) > 122)
			return false;
		if(str.charCodeAt(i) > 57 && str.charCodeAt(i) < 65)
			return false;
		if(str.charCodeAt(i) > 90 && str.charCodeAt(i) < 97 && str.charCodeAt(i) != 95)
			return false;		
	}
	return true;
}
function checkNewRulePass(str){
	return true;
	if(str.length < 8)
		return false;
	var level = new Array(0,0,0,0);
	for(i=0;i<str.length;i++){		
		// Ky tu thuong
		if(checkCharLow(str.charCodeAt(i)))
			level[0] = 1;
		// Ky tu hoa
		if(checkCharUp(str.charCodeAt(i)))
			level[1] = 1;	
		// Ky tu so
		if(checkNum(str.charCodeAt(i)))
			level[2] = 1;		
	}
	//co ky tu dat biet
	if(!checkCharacter(str)){
		level[3] = 1;
	}	
	if((level[0] && level[1] && level[2] && !level[3]) 
			|| (level[0] && level[1] && !level[2] && level[3])
			|| (level[0] && !level[1] && level[2] && level[3])			
			|| (!level[0] && level[1] && level[2] && level[3])
			|| (level[0] && level[1] && level[2] && level[3])
			){
			return true;
	}
	return false;

}
function explode (delimiter, string, limit) {
    // Splits a string on string separator and return array of components. If limit is positive only limit number of components is returned. If limit is negative all components except the last abs(limit) are returned.  
    // 
    // version: 1103.1210
    // discuss at: http://phpjs.org/functions/explode
    // +     original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +     improved by: kenneth
    // +     improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +     improved by: d3x
    // +     bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // *     example 1: explode(' ', 'Kevin van Zonneveld');
    // *     returns 1: {0: 'Kevin', 1: 'van', 2: 'Zonneveld'}
    // *     example 2: explode('=', 'a=bc=d', 2);
    // *     returns 2: ['a', 'bc=d']
    var emptyArray = {
        0: ''
    };
 
    // third argument is not required
    if (arguments.length < 2 || typeof arguments[0] == 'undefined' || typeof arguments[1] == 'undefined') {
        return null;
    }
 
    if (delimiter === '' || delimiter === false || delimiter === null) {
        return false;
    }
 
    if (typeof delimiter == 'function' || typeof delimiter == 'object' || typeof string == 'function' || typeof string == 'object') {
        return emptyArray;
    }
 
    if (delimiter === true) {
        delimiter = '1';
    }
 
    if (!limit) {
        return string.toString().split(delimiter.toString());
    } else {
        // support for limit argument
        var splitted = string.toString().split(delimiter.toString());
        var partA = splitted.splice(0, limit - 1);
        var partB = splitted.join(delimiter.toString());
        partA.push(partB);
        return partA;
    }
}