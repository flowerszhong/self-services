xxx<?php
include 'dbc.php';
require_once dirname(__FILE__) . '/admin/PHPExcel/Classes/PHPExcel.php';

// admin_page_protect();

// if ($_POST['export'] == 'students') {
// 在使用的时候,调用getExcel方法，并传入相应的参数即可,例如：

$sql_select_all = "select * from students
		where grade=2014
		and major='环境监测与评价'
		and class=1
		and department='环境监测系'";

$result = mysql_query($sql_select_all) or die("获取学生信息失败");

$current_date = date("Ymd");
$filename = 'student111-' . $current_date . '.xlsx';

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
$activeSheet->mergeCells('A1:D1');

$activeSheet->setCellValue('A2', "学号");
$activeSheet->setCellValue('B2', "姓名");
$activeSheet->setCellValue('C2', "缴费金额");
$activeSheet->setCellValue('D2', "备注（开户或续费）");

$activeSheet->getStyle('A1:D2')->getFont()->setBold(true);
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
            ->setCellValue('B' . $startIndex, '系部名称')
            ->setCellValue('C' . $startIndex, '专业')
            ->setCellValue('D' . $startIndex, '专业名称');

$startIndex = $startIndex + 1;

$activeSheet->setCellValue('A' . $startIndex, '专业方向')
            ->setCellValue('B' . $startIndex, '专业方向名称')
            ->setCellValue('C' . $startIndex, '班级')
            ->setCellValue('D' . $startIndex, '班级');

$startIndex = $startIndex + 1;

$activeSheet->setCellValue('A' . $startIndex, '缴费总人数')
            ->setCellValue('B' . $startIndex, '缴费总人数')
            ->setCellValue('C' . $startIndex, '缴费总金额')
            ->setCellValue('D' . $startIndex, '缴费总金额');

$startIndex = $startIndex + 1;
$comment_end = $startIndex;

$activeSheet->setCellValue('A' . $startIndex, '统计人')
            ->setCellValue('B' . $startIndex, 'xxx')
            ->setCellValue('C' . $startIndex, '联系电话')
            ->setCellValue('D' . $startIndex, '联系电话');

$objPHPExcel->getDefaultStyle()
            ->getAlignment()
            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$activeSheet->getStyle("A" . $comment_start . ":D" . $comment_end)->getFont()->setBold(true);
$activeSheet->getStyle("A" . $comment_start . ":D" . $comment_end)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
// $objPHPExcel->setActiveSheetIndex(0);

// Save Excel 2007 file
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('download/' . $filename);

$response_data = array(
	'state' => "ok",
	'xls_name' => SITE_ROOT . "/admin/download/" . $filename,
);

echo json_encode($response_data);
exit();
// }

$page_title = "导出班级缴费表";
include 'includes/head.php';
?>
<div class="container">

<h3 class="title">方式1：填写信息重置密码为123456</h3>
<form id="reset-form1" action="forgot.php" method="post" name="forgotform">
<table>
  <td width="160">
<b class="required"> * </b>
学号
</td>
<td>
<input type="text" name="student_id" class="studentid"></td>
</tr>

<tr>
<td>
<b class="required"> * </b>
姓名
</span>
</td>
<td>
<input name="user_name" type="text" id="user_name" class="required"></td>
</tr>

<tr>
<td>
<b class="required"> * </b>
邮箱地址
</td>
<td>
<input name="usr_email" type="text" id="usr_email3" class="required email">
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
<td>
<b class="required"> * </b>
验证码</td>
<td>
  <input type="text" value="" id="code-confirm" placeholder="请输入验证码" maxlength="4" class="required" />
</td>
</tr>
<tr>
<td>

</td>
<td>
  <input type="submit" name="reset" class="btn btn-success" value="重置为123456" />
  <br>
  <br>
</td>
</tr>
</table>
</form>


</div>


<?php

$footer_scripts = array("assets/js/export.js");

include 'includes/footer.php';
?>