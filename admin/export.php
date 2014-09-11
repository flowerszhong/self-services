<?php
include '../dbc.php';
require_once dirname(__FILE__) . '/PHPExcel/Classes/PHPExcel.php';

admin_page_protect();

if ($_POST['export'] == 'students') {
	// 在使用的时候,调用getExcel方法，并传入相应的参数即可,例如：

	$sql_select_all = "select * from students";

	$result = mysql_query($sql_select_all) or die("获取学生信息失败");

	$current_date = date("Ymd");
	$filename     = 'student-' . $current_date . '.xlsx';

	$objPHPExcel = new PHPExcel();

// Set document properties
	$objPHPExcel->getProperties()->setCreator("Matthew Zhong")
	            ->setLastModifiedBy("Matthew Zhong")
	            ->setTitle("Office 2007 XLSX Test Document")
	            ->setSubject("Office 2007 XLSX Test Document")
	            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
	            ->setKeywords("office 2007 openxml php")
	            ->setCategory("studens");

// Create a first sheet
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setCellValue('A1', "学号");
	$objPHPExcel->getActiveSheet()->setCellValue('B1', "姓名");
	$objPHPExcel->getActiveSheet()->setCellValue('C1', "邮箱");
	$objPHPExcel->getActiveSheet()->setCellValue('D1', "密码");
	$objPHPExcel->getActiveSheet()->setCellValue('E1', "电话");
	$objPHPExcel->getActiveSheet()->setCellValue('F1', "系别");
	$objPHPExcel->getActiveSheet()->setCellValue('G1', "专业");
	$objPHPExcel->getActiveSheet()->setCellValue('H1', "专业方向");
	$objPHPExcel->getActiveSheet()->setCellValue('I1', "年级");
	$objPHPExcel->getActiveSheet()->setCellValue('J1', "班级");
	$objPHPExcel->getActiveSheet()->setCellValue('K1', "上网账号");
	$objPHPExcel->getActiveSheet()->setCellValue('L1', "账号到期时间");

// Rows to repeat at top
	$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);

// Add data
	$startIndex = 2;
	while ($row = mysql_fetch_array($result)) {
		$objPHPExcel->getActiveSheet()->setCellValue('A' . $startIndex, $row['student_id'])
		            ->setCellValue('B' . $startIndex, $row['user_name'])
		            ->setCellValue('C' . $startIndex, $row['user_email'])
		            ->setCellValue('D' . $startIndex, $row['pwd'])
		            ->setCellValue('E' . $startIndex, $row['tel'])
		            ->setCellValue('F' . $startIndex, $row['department'])
		            ->setCellValue('G' . $startIndex, $row['major'])
		            ->setCellValue('H' . $startIndex, $row['sub_major'])
		            ->setCellValue('I' . $startIndex, $row['grade'])
		            ->setCellValue('J' . $startIndex, $row['class'])
		            ->setCellValue('K' . $startIndex, $row['net_id'])
		            ->setCellValue('L' . $startIndex, $row['expire_date']);
		$startIndex = $startIndex + 1;
	}

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

// Save Excel 2007 file
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('download/' . $filename);

	$response_data = array(
		'state'    => "ok",
		'xls_name' => SITE_ROOT . "/admin/download/" . $filename,
	);

	echo json_encode($response_data);
	exit();
}

if ($_POST['export'] == 'accounts') {
	// 在使用的时候,调用getExcel方法，并传入相应的参数即可,例如：

	$sql_select_all = "select * from accounts";

	$result = mysql_query($sql_select_all) or die("获取上网账号表失败");

	$objPHPExcel = new PHPExcel();

// Set document properties
	$objPHPExcel->getProperties()->setCreator("Matthew Zhong")
	            ->setLastModifiedBy("Matthew Zhong")
	            ->setTitle("Office 2007 XLSX Test Document")
	            ->setSubject("Office 2007 XLSX Test Document")
	            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
	            ->setKeywords("office 2007 openxml php")
	            ->setCategory("accounts");

// Create a first sheet
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setCellValue('A1', "账号");
	$objPHPExcel->getActiveSheet()->setCellValue('B1', "密码");
	$objPHPExcel->getActiveSheet()->setCellValue('C1', "开始时间");
	$objPHPExcel->getActiveSheet()->setCellValue('D1', "截止时间");
	$objPHPExcel->getActiveSheet()->setCellValue('E1', "学生学号");
	$objPHPExcel->getActiveSheet()->setCellValue('F1', "是否被使用");
	$objPHPExcel->getActiveSheet()->setCellValue('G1', "是否可用");

// Rows to repeat at top
	$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);

// Add data
	$startIndex = 2;
	while ($row = mysql_fetch_array($result)) {
		$objPHPExcel->getActiveSheet()->setCellValue('A' . $startIndex, $row['net_id'])
		            ->setCellValue('B' . $startIndex, $row['net_pwd'])
		            ->setCellValue('C' . $startIndex, $row['start_date'])
		            ->setCellValue('D' . $startIndex, $row['end_date'])
		            ->setCellValue('E' . $startIndex, $row['student_id'])
		            ->setCellValue('F' . $startIndex, $row['used'])
		            ->setCellValue('G' . $startIndex, $row['available']);
		$startIndex = $startIndex + 1;
	}

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

// Save Excel 2007 file
	$current_date = date("Ymd");
	$filename     = 'net-table-' . $current_date . '.xlsx';
	$objWriter    = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('download/' . $filename);

	$response_data = array(
		'state'    => "ok",
		'xls_name' => SITE_ROOT . "/admin/download/" . $filename,
	);

	echo json_encode($response_data);
	exit();

}

if ($_POST['export'] == 'unavailable') {
	// 在使用的时候,调用getExcel方法，并传入相应的参数即可,例如：

	$sql_select_all = "select * from accounts where available=0";

	$result = mysql_query($sql_select_all) or die("获取上网账号表失败");

	$objPHPExcel = new PHPExcel();

// Set document properties
	$objPHPExcel->getProperties()->setCreator("Matthew Zhong")
	            ->setLastModifiedBy("Matthew Zhong")
	            ->setTitle("Office 2007 XLSX Test Document")
	            ->setSubject("Office 2007 XLSX Test Document")
	            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
	            ->setKeywords("office 2007 openxml php")
	            ->setCategory("unavailable accounts");

// Create a first sheet
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setCellValue('A1', "账号");
	$objPHPExcel->getActiveSheet()->setCellValue('B1', "密码");
	$objPHPExcel->getActiveSheet()->setCellValue('C1', "开始时间");
	$objPHPExcel->getActiveSheet()->setCellValue('D1', "截止时间");
	$objPHPExcel->getActiveSheet()->setCellValue('E1', "学生学号");
	$objPHPExcel->getActiveSheet()->setCellValue('F1', "是否被使用");
	$objPHPExcel->getActiveSheet()->setCellValue('G1', "是否可用");

// Rows to repeat at top
	$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);

// Add data
	$startIndex = 2;
	while ($row = mysql_fetch_array($result)) {
		$objPHPExcel->getActiveSheet()->setCellValue('A' . $startIndex, $row['net_id'])
		            ->setCellValue('B' . $startIndex, $row['net_pwd'])
		            ->setCellValue('C' . $startIndex, $row['start_date'])
		            ->setCellValue('D' . $startIndex, $row['end_date'])
		            ->setCellValue('E' . $startIndex, $row['student_id'])
		            ->setCellValue('F' . $startIndex, $row['used'])
		            ->setCellValue('G' . $startIndex, $row['available']);
		$startIndex = $startIndex + 1;
	}

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

// Save Excel 2007 file
	$current_date = date("Ymd");
	$filename     = 'net-unavailable-table-' . $current_date . '.xlsx';
	$objWriter    = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('download/' . $filename);

	$response_data = array(
		'state'    => "ok",
		'xls_name' => SITE_ROOT . "/admin/download/" . $filename,
	);

	echo json_encode($response_data);
	exit();

}

if ($_POST['export'] == 'consume') {
	$sql_select_all = "select
	c.student_id,c.fee,c.start_date,c.end_date,c.pay_date,
	s.user_name
	from
	consume as c,
	students as s
	where c.student_id=s.student_id";

	$result = mysql_query($sql_select_all) or die("获取学生消费记录失败");

	$objPHPExcel = new PHPExcel();

	$objPHPExcel->getProperties()->setCreator("Matthew Zhong")
	            ->setLastModifiedBy("Matthew Zhong")
	            ->setTitle("Office 2007 XLSX Test Document")
	            ->setSubject("Office 2007 XLSX Test Document")
	            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
	            ->setKeywords("office 2007 openxml php")
	            ->setCategory("consume");

// Create a first sheet
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setCellValue('A1', "学生学号");
	$objPHPExcel->getActiveSheet()->setCellValue('B1', "姓名");
	$objPHPExcel->getActiveSheet()->setCellValue('C1', "开始时间");
	$objPHPExcel->getActiveSheet()->setCellValue('D1', "截止时间");
	$objPHPExcel->getActiveSheet()->setCellValue('E1', "缴费金额");
	$objPHPExcel->getActiveSheet()->setCellValue('F1', "交费时间");

// Rows to repeat at top
	$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);

// Add data
	$startIndex = 2;
	while ($row = mysql_fetch_array($result)) {
		$objPHPExcel->getActiveSheet()->setCellValue('A' . $startIndex, $row['student_id'])
		            ->setCellValue('B' . $startIndex, $row['user_name'])
		            ->setCellValue('C' . $startIndex, $row['start_date'])
		            ->setCellValue('D' . $startIndex, $row['end_date'])
		            ->setCellValue('E' . $startIndex, $row['fee'])
		            ->setCellValue('F' . $startIndex, $row['pay_date']);
		$startIndex = $startIndex + 1;
	}

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

// Save Excel 2007 file
	$current_date = date("Ymd");
	$filename     = 'consume-table-' . $current_date . '.xlsx';
	$objWriter    = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('download/' . $filename);

	$response_data = array(
		'state'    => "ok",
		'xls_name' => SITE_ROOT . "/admin/download/" . $filename,
	);

	echo json_encode($response_data);
	exit();

}

$page_title = "数据导出";
include '../includes/head.php';
include '../includes/sidebar.php';
?>
<div class="main">
	<h3 class="title">
		导出学生网费信息表
	</h3>
	<form method="post" action="export.php">
		<input type="button" name="export" value="导出" id="export-students" data-type="students" class="btn btn-danger" />
	</form>

  <br />
	<h3 class="title">
		导出上网账号表
	</h3>
	<form method="post" action="export.php">
		<input type="button" name="export" value="导出" data-type="accounts" id="export-accounts" class="btn btn-danger" />
	</form>

	<br />
	<h3 class="title">
		导出消费记录表
	</h3>
	<form method="post" action="export.php">
		<input type="button" name="export" value="导出" data-type="consume" id="export-consume" class="btn btn-danger" />
	</form>

	<h3 class="title">
		导出不可用账号
	</h3>
	<form method="post" action="export.php">
		<input type="button" name="export" value="导出" data-type="unavailable" id="export-unavailable" class="btn btn-danger" />
	</form>

</div>


<?php

$footer_scripts = array("assets/js/export.js");

include '../includes/footer.php';
?>