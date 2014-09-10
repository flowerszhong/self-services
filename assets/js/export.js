$(function() {
	$("#export-students,#export-accounts,#export-consume").click(function() {
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

	
});