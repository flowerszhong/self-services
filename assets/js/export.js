$(function() {
	$("#export-students,#export-accounts,#export-consume,#export-unavailable").click(function() {
		this.value = "由于数据量大，请耐心等候...";
		var type = $(this).attr("data-type");
		var that = this;
		$.ajax({
			type: "POST",
			url: "export.php",
			data: {
				'export': type
			},
			success: function(data) {
				that.value = "导出";
				if (data && data['state'] == 'ok') {
					// window.open(data['xls_name'],'_blank');
					window.location.href = data['xls_name'];
				}
			},
			dataType: "json"
		});
	});

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

	$("#download-table").validate({
		submitHandler: function(form) {
			var code = $.trim($("#code-container").html());
			var codeconfirm = $.trim($("#code-confirm").val());
			if(code && codeconfirm && (code.toLowerCase() == codeconfirm.toLowerCase())){
				form.submit();
				$("#code-confirm").val("");
				createCode();
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