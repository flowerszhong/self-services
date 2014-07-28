$(function () {
	$("#export-students").click(function () {
		this.value="由于数据量大，请耐心等候...";
		var that = this;
		$.ajax({
		      type: "POST",
		      url: "export.php",
		      data: {
		      	'export' : "students"
		      },
		      success: function  (data) {
		      	that.value="导出";
		        if(data && data['state'] == 'ok'){
		        	// window.open(data['xls_name'],'_blank');
		        	window.location.href = data['xls_name'];
		        }
		      },
		      dataType: "json"
		    });
	});

	$("#export-accounts").click(function () {
		this.value="由于数据量大，请耐心等候...";
		var that = this;
		$.ajax({
		      type: "POST",
		      url: "export.php",
		      data: {
		      	'export' : "accounts"
		      },
		      success: function  (data) {
		      	that.value="导出";
		        if(data && data['state'] == 'ok'){
		        	// window.open(data['xls_name'],'_blank');
		        	window.location.href = data['xls_name'];
		        }
		      },
		      dataType: "json"
		    });
	});
});