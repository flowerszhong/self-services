<?php
// header("content-type:text/html;charset=utf-8");
include 'dbc.php';
require_once dirname(__FILE__) . '/admin/PHPExcel/Classes/PHPExcel.php';

// admin_page_protect();

foreach ($_POST as $key => $value) {
	$data[$key] = filter($value);//get variables are filtered.
}

if ($_POST['major']) {
	$department = $data['department'];
	$major = $data['major'];
	$sub_major = $data['sub-major'];
	$class = $data['class'];

	$sql_select_all = "select student_id,user_name from students
		where grade=2014
		and major='$major'
		and class=$class
		and department='$department'";

	if ($sub_major) {
		$sql_select_all = $sql_select_all . " and sub_major='$sub_major'";
	}

	// echo $sql_select_all;

	$result = mysql_query($sql_select_all) or die("获取学生信息失败");

	$current_date = date("Ymd");
	// $filename = 'student111-' . $current_date . '.xlsx';
	$filename = '2014-' . $department . '-' . $major;

	if ($sub_major) {
		$filename = $filename . '-' . $sub_major;
	}

	$filename = $filename . '-' . $class . '班.xlsx';

	$ua = $_SERVER['HTTP_USER_AGENT'];
	if (preg_match('/MSIE/', $ua)) {
		$filename = iconv('UTF-8', 'GB2312', $filename);
	}

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
	$activeSheet = $objPHPExcel->getActiveSheet();

	$activeSheet->setCellValue('A1', "班级缴费表");
	$activeSheet->mergeCells('A1:E1');

	$activeSheet->setCellValue('A2', "学号");
	$activeSheet->setCellValue('B2', "姓名");
	$activeSheet->setCellValue('C2', "缴费金额");
	$activeSheet->setCellValue('D2', "备注（开户或续费）");
	$activeSheet->setCellValue('E2', "序号");

	$activeSheet->getStyle('A1:E2')->getFont()->setBold(true);
// $activeSheet->getStyle('A1:D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	$activeSheet->getColumnDimension('A')->setWidth(20);
	$activeSheet->getColumnDimension('B')->setWidth(20);
	$activeSheet->getColumnDimension('C')->setWidth(20);
	$activeSheet->getColumnDimension('D')->setWidth(20);

// Rows to repeat at top
	$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);

// Add data
	$startIndex = 3;
	while ($row = mysql_fetch_array($result)) {
		$activeSheet->setCellValue('A' . $startIndex, $row['student_id'])
		            ->setCellValue('B' . $startIndex, $row['user_name'])
		            ->setCellValue('C' . $startIndex, 300)
		            ->setCellValue('D' . $startIndex, '开户');

		$startIndex = $startIndex + 1;
	}

	$startIndex = $startIndex + 1;

	$comment_start = $startIndex;

	$activeSheet->setCellValue('A' . $startIndex, '系部')
	            ->setCellValue('B' . $startIndex, $department)
	            ->setCellValue('C' . $startIndex, '专业')
	            ->setCellValue('D' . $startIndex, $major);

	$startIndex = $startIndex + 1;

	$activeSheet->setCellValue('A' . $startIndex, '专业方向')
	            ->setCellValue('B' . $startIndex, $sub_major)
	            ->setCellValue('C' . $startIndex, '班级')
	            ->setCellValue('D' . $startIndex, $class . '班');

	$startIndex = $startIndex + 1;

	$activeSheet->setCellValue('A' . $startIndex, '缴费总人数')
	            ->setCellValue('B' . $startIndex, '')
	            ->setCellValue('C' . $startIndex, '缴费总金额')
	            ->setCellValue('D' . $startIndex, '');

	$startIndex = $startIndex + 1;
	$comment_end = $startIndex;

	$activeSheet->setCellValue('A' . $startIndex, '统计人')
	            ->setCellValue('B' . $startIndex, '')
	            ->setCellValue('C' . $startIndex, '联系电话')
	            ->setCellValue('D' . $startIndex, '');

	$activeSheet->getStyle("A" . $comment_start . ":D" . $comment_end)->getFont()->setBold(true);
	$activeSheet->getStyle("A" . $comment_start . ":D" . $comment_end)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

	$activeSheet->getStyle("A1:E2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	$objPHPExcel->getDefaultStyle()
	            ->getAlignment()
	            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	// $objPHPExcel->setActiveSheetIndex(0);
	// Redirect output to a client’s web browser (Excel2007)

	// header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=UTF-8');
	// header('Content-Transfer-Encoding: none');
	// header('Content-Type: application/vnd.ms-excel;');
	// header("Content-type: application/x-msexcel");
	header('Content-Disposition: attachment;filename="' . $filename . '"');
	header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
	header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');// Date in the past
	header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');// always modified
	header('Cache-Control: cache, must-revalidate');// HTTP/1.1
	header('Pragma: public');// HTTP/1.0

// Save Excel 2007 file
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	// $objWriter->save('download/' . $filename);
	$objWriter->save('php://output');

	exit;

	$response_data = array(
		'state' => "ok",
		'xls_name' => SITE_ROOT . "/download/" . $filename,
	);

	echo json_encode($response_data);
	exit();
}

$page_title = "导出班级缴费表";
include 'includes/head.php';
?>
<div class="container">

<h3 class="title">生成并下载班级缴费表</h3>
<form id="download-table" action="export-table.php" method="post" name="download-table-form">

<table>

    <tr>
      <td width="80" class="th">
      <b class="required"> * </b>
        年级
      </td>
      <td>
      2014
        <!-- <select name="grade" id="grade-select" class="form-control required">
         <option name="" value="">
             请选择年级
           </option>
           <option name="" value="2013">
             2013
           </option>

           <option name="" value="2014" selected>
             2014
           </option>
         </select> -->
      </td>
    </tr>
    <tr>
      <td class="th">
      <b class="required"> * </b>
        系
      </td>
      <td>
        <select name="department" id="department" class="form-control required">
           <option name="" value="">
             请选择系别
           </option>
         </select>

      </td>
    </tr>

    <tr>
      <td class="th">
      <b class="required"> * </b>
        专业
      </td>
      <td>
       <select name="major" id="major" class="form-control required">
           <option name="" value="">
             请选择专业
           </option>
         </select>

      </td>
    </tr>

    <tr>
      <td class="th">
        专业方向
      </td>
      <td>
        <select name="sub-major" id="sub-major" class="form-control">
           <option name="" value="">
             请选择专业方向
           </option>
         </select>


      </td>
    </tr>

    <tr>
      <td class="th">
      <b class="required"> * </b>
        班级
      </td>
      <td>
        <select name="class" id="class" class="form-control required">
           <option name="class" value=""></option>
               <option name="class" value="1">1班</option>
               <option name="class" value="2">2班</option>
               <option name="class" value="3">3班</option>
               <option name="class" value="4">4班</option>
               <option name="class" value="5">5班</option>
               <option name="class" value="6">6班</option>
               <option name="class" value="7">7班</option>
               <option name="class" value="8">8班</option>
               <option name="class" value="9">9班</option>
               <option name="class" value="10">10班</option>
         </select>
      </td>
    </tr>
    <tr>
      <td></td>
      <td>
      <div id="code-container">

      </div>
      <br>
        <a id="change-code" href="#">点击更换验证码</a>
      </td>
    </tr>
    <tr>
    <td class="th">
    <b class="required"> * </b>
    验证码</td>
    <td>
      <input type="text" value="" id="code-confirm" placeholder="请输入验证码" maxlength="4" class="required form-control" />
    </td>
    </tr>
    <tr>
      <td></td>
      <td>
        <input type="submit" class="btn btn-success" id="btn-search-many" value="下载班级缴费表" />
      </td>
    </tr>

  </table>

</form>


</div>


<?php

$footer_scripts = array("assets/js/export.js");

include 'includes/footer.php';
?>