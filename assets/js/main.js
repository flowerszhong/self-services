$(function () {
	$('.msg').delay(2000).slideUp('slow');

	/*
	* top nav and admin nav
	*/
	var pathnames = window.location.pathname.split('/');
	var filename = pathnames[pathnames.length -1];

	$('.nav-sidebar')
			.find('li').removeClass('active')
			.end()
			.find('a[href="' +filename + '"]').parent().addClass('active');


	/*
	* register module
	*/
	var DEPARTMENTS = [{
		"id": 100,
		"name": "环境工程与土木工程系",
		"major": [{
			"id": "1",
			"name": "环境监测与治理技术",
			'sub-major' : ['环境治理技术','污染场地修复技术','环保设施运营管理']
		}, {
			"id": "2",
			"name": "城市水净化技术",
			"sub-major": []
		}, {
			"id": "3",
			"name": "给排水工程技术",
			"sub-major" : []
		}, {
			"id": "4",
			"name": "工程测量与监理",
			"sub-major" :  ['工程测量技术','工程监测技术']
		}, {
			"id": "5",
			"name": "建筑工程技术",
			"sub-major":[]
		}, {
			"id": "6",
			"name": "工程造价",
			"sub-major":[]
		}]
	}, {
		"id": 2,
		"name": "环境监测系",
		"major": [{
			"id": "201",
			"name": "环境监测与评价",
			"sub-major" :['环境监测','环境自动监测管理','物理污染监测技术']
		}, {
			"id": "202",
			"name": "食品营养与检测",
			"sub-major":[]
		}, {
			"id": "203",
			"name": "室内检测与控制技术",
			"sub-major":[]
		}, {
			"id": "204",
			"name": "工业分析与检验",
			"sub-major":[]
		}, {
			"id": "205",
			"name": "商检技术专业",
			"sub-major":[]
		}]
	}, {
		"id": 3,
		"name": "环境科学系",
		"major": [{
			"id": "301",
			"name": "环境监测与评价",
			"sub-major":['环境影响评价']
		}, {
			"id": "302",
			"name": "环境规划与管理",
			"sub-major":[]
		},  {
			"id": "303",
			"name": "工业环保与安全技术",
			"sub-major":['企业环境与安全管理方向']
		}, {
			"id": "304",
			"name": "安全技术管理",
			"sub-major":[]
		}]
	},{
		"id": 4,
		"name": "循环经济与低碳经济系",
		"major": [{
			"id": "401",
			"name": "资源环境与城市管理",
			"sub-major":['资源综合利用技术','清洁生产与节能技术','能源管理及节能工程']
		},{
			"id": "402",
			"name": "节能工程技术"
		},{
			"id": "403",
			"name": "工业节能管理专业"
		}]
	},{
		"id": 5,
		"name": "机电工程系",
		"major": [{
			"id": "501",
			"name": "机电设备维修与管理",
			"sub-major":['机电设备维修与管理','环保设备制造与营销']
		}, {
			"id": "502",
			"name": "模具设计与制造",
			"sub-major" :[]
		}, {
			"id": "503",
			"name": "软件测试技术",
			"sub-major":['web应用软件开发与测试','移动互联网应用与测试']
		}]
	},{
		"id": 6,
		"name": "生态环境系",
		"major": [{
			"id": "601",
			"name": "城市园林",
			"sub-major":['景观设计','工程管理']
		}, {
			"id": "602",
			"name": "园艺技术",
			"sub-major":['商品花卉']
		}]
	},{
		"id": 7,
		"name": "环境艺术与服务系",
		"major": [{
			"id": "701",
			"name": "环境艺术设计",
			"sub-major" :[]
		}, {
			"id": "702",
			"name": "会展艺术设计",
			"sub-major" :[]
		}, {
			"id": "703",
			"name": "烹饪工艺与营养",
			"sub-major":["公共营养与健康管理"]
		}]
	}];

	var $department = $("#department"),
		$major = $("#major"),
		$subMajor = $("#sub-major");

	var options = "<option value=''>请选择系别</option>";
	for (var i = 0; i < DEPARTMENTS.length; i++) {
		var depa = DEPARTMENTS[i];
		options += ("<option name='department' cvalue="+ depa.id + " value=" + depa.name + ">" + depa.name + "</option>");
	};

	$department.empty().append(options);


	$department.on('change',function () {
		var department_id = $(this).find(':selected').attr('cvalue');
		var depa = null;
		for (var i = 0; i < DEPARTMENTS.length; i++) {
			if (DEPARTMENTS[i].id == department_id) {
				depa = DEPARTMENTS[i];
				break;
			};
		};

		if(depa){
			var majors = depa['major'];
			var options = "<option value=''>请选择专业</option>";
			for (var i = 0; i < majors.length; i++) {
				var _m = majors[i];
				var submajorString = _m['sub-major'];

				if(submajorString){
					submajorString = submajorString.join(',');
				}else{
					submajorString = "";
				}
				options += ("<option submajor='"+ submajorString +"' value='"+ _m.name +"' mid='" + _m.id + "'>" + _m.name + "</option>");
			};
			$major.empty().append(options);
			$subMajor.empty().append("<option value=''>请选择专业方向</option>");

		}
	});


	$major.on('change',function () {

		var subMajorOptions;
		var submajorString = $(this).find(':selected').attr('submajor');
		if(!submajorString){
			subMajorOptions = "<option value=''>请选择专业方向</option>";
			subMajorOptions += "<option value=''>无</option>";
			$subMajor.empty().append(subMajorOptions);
			return;
		}
		var subMajorArray = submajorString.split(',');
		subMajorOptions = "<option value=''>请选择专业方向</option>";

		if(submajorString == ""){
			subMajorOptions += "<option value=''>无</option>";
		}else{
			for (var i = subMajorArray.length - 1; i >= 0; i--) {
				subMajorOptions += "<option value='"+subMajorArray[i]+"'>" + subMajorArray[i] + "</option>"
			};
		}

		$subMajor.empty().append(subMajorOptions);

	});


	$("#reg-grade").change(function () {
		var $hint = $("#net-id-hint");
		if(this.value == 2013){
			$(".net-row").show();
			var username = $("#user_name").val();
			var hintText = "";
			// var username = "何寿鸿";
			if(username){
				$.ajax({
					url:"query-source.php",
					data:{
						"cmd":"source",
						"name": username
					},
					dataType :"json",
					type:"GET"
				}).done(function (data) {
					console.log(data);
					if(data){
						var netId = data['net_id'];
						console.log(netId);
						hintText = "Hi " + username + " 同学，你的上网账号有可能是：" + netId;
						$hint.text(hintText);
					}
				});
				
			}

		}else{
			$('.net-row').hide();
			$hint.empty();
		}
	});


	$("#regForm input").addClass("form-control");

	$("#regForm input[type='text']").addClass("custom-input");

	$("#regForm tr").find("td:first").addClass("th");

	$("#regForm").validate({
        rules:{
        	'student_id' : {
        		required:true,
        		isStudentId :true
        	}
        }
    });

    //settings panel

    $("#setting-form").validate();

    $("#setting-form input").addClass("form-control");

	$("#setting-form input[type='text']").addClass("custom-input");

	$("#setting-form tr").find("td:first").addClass("th");


	$("#change-major-setting").on('click',function () {
		$("#setting-table").find('.lbl').hide().end().find('.editing').prop('disabled',false).show();
		$(this).hide();
		$("#cancel-setting-btn").show();
	});

	$("#cancel-setting-btn").on('click',function () {
		$("#setting-table").find('.lbl').show().end().find('.editing').prop('disabled',true).hide();
		$(this).hide();
		$("#change-major-setting").show();
	});

	$(".link-submit").click(function () {
		$("#login-form").submit();
		return false;
	});


	$("#link-save-setting").click(function () {
		$("#setting-form").submit();
		return false;
	});


	$("#actForm").validate();

	// net-account-table
	$("#net-account-table tr").find("td:first").addClass("th");


	//reset password
	$("#reset-form").validate();
	$("#reset-form input").addClass("form-control");
	$("#reset-form input[type='text']").addClass("custom-input");
	$("#reset-form tr").find("td:first").addClass("th");


	$("#btn-check-pwd").click(function () {
		$("#label-net-pwd").slideDown();
	});



	$("#login-form").validate({
        rules:{
        	'student_id' : {
        		required:true,
        		isStudentId :true
        	}
        }
    });

    $("#add-form").validate();

    //billing module
    $("#add-billing-form").validate();
    $("#add-billing-form tr").find("td:first").addClass("th");


	// validate function
	function isStudentId (id) {
		if(id.length == 8){
			return true;
		}
	}


	$("#state-form").validate();

	if($.fn.datepicker){
		$(".input-start-date").datepicker({
	        dateFormat: 'yy-mm-dd',
	        changeMonth: true,
	        changeYear: true,
	        showButtonPanel: true,
	        onClose: function (selectedDate) {
	            $(".input-end-date").datepicker("option", "minDate", selectedDate);
	        }
	    });
	    $(".input-end-date").datepicker({
	        dateFormat: 'yy-mm-dd',
	        changeMonth: true,
	        changeYear: true,
	        showButtonPanel: true,
	        onClose: function (selectedDate) {
	            $(".input-start-date").datepicker("option", "maxDate", selectedDate);
	        }
	    });
	}

});