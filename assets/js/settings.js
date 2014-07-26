$(function () {
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
		$("label.error").hide();
	});


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