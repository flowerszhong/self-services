$(function () {
	$('.msg').delay(2000).slideUp('slow');


	var pathnames = window.location.pathname.split('/');
	var filename = pathnames[pathnames.length -1];

	$('.nav-sidebar')
			.find('li').removeClass('active')
			.end()
			.find('a[href="' +filename + '"]').parent().addClass('active');

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
	$("#net-account-table tr").find("td:first").addClass("reg-th");


	//reset password
	$("#reset-form").validate();
	$("#reset-form input").addClass("form-control");
	$("#reset-form input[type='text']").addClass("reg-input");
	$("#reset-form tr").find("td:first").addClass("reg-th");


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




	// validate function
	function isStudentId (id) {
		if(id.length == 8){
			return true;
		}
	}

});