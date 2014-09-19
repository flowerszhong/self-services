$(function() {
	$("#reset-form1 tr").find("td:first").addClass("th");
	$("#reset-form1 input[type='text']").addClass("form-control");

	function createCode() {
		code = "";
		var codeLength = 4; //验证码的长度
		var checkCode = document.getElementById("code-container");
		var codeChars = new Array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9,
			'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
			'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'); //所有候选组成验证码的字符，当然也可以用中文的
		for (var i = 0; i < codeLength; i++) {
			var charNum = Math.floor(Math.random() * 52);
			code += codeChars[charNum];
		}
		if (checkCode) {
			checkCode.className = "code";
			checkCode.innerHTML = code;
		}
	}

	createCode();


	$("#reset-form1").validate({
		rules: {
			'student_id': {
				required: true,
				isStudentId: true
			}
		},
		submitHandler: function(form) {
			var code = $.trim($("#code-container").html());
			var codeconfirm = $.trim($("#code-confirm").val());
			if(code && codeconfirm && (code.toLowerCase() == codeconfirm.toLowerCase())){
				form.submit();
			}else{
				alert("验证码不正确");
				return false;
			}
		}
	});

	$("#change-code").click(function () {
		createCode();
	});
});