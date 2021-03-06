<?php
include 'dbc.php';
// page_protect();

session_start();

$page_title = "审核";
include 'includes/head.php';

$err    = array();
$msg    = array();
$report = array();

foreach ($_POST as $key => $value) {
	$data[$key] = filter($value);// post variables are filtered
}
function checkStudentId($student_id, $user_name, $fee, $comment) {
	global $report;
	$input = array(
		'type'       => 'input',
		'student_id' => $student_id,
		'user_name'  => $user_name,
		'fee'        => $fee,
		'comment'    => $comment,
	);
	if (!$fee) {
		$output = array(
			'type'          => 'output',
			'student_id'    => null,
			'student_id_ok' => null,
			'user_name'     => null,
			'name_ok'       => null,
			'fee'           => "交费金额不应为空",
			'fee_ok'        => "not-ok",
			'comment'       => null,
			'comment_ok'    => null,
		);
		$report[] = $input;
		$report[] = $output;
		return;
	}

	$student_data = getStudentData($student_id);

	if (!$student_data) {
		$output = array(
			'type'          => 'output',
			'student_id'    => '该生未注册',
			'student_id_ok' => 'not-ok',
			'user_name'     => null,
			'name_ok'       => null,
			'fee'           => null,
			'fee_ok'        => null,
			'comment'       => null,
			'comment_ok'    => null,
		);

		$report[] = $input;
		$report[] = $output;
		return;
	}

	$new     = null;
	$new_msg = null;
	$new_ok  = null;

	if ($student_data['net_id']) {
		if ($student_data['expire_date'] > date('Y-m-d')) {
			$new_msg = "该生有账号，现在为续费";
			$new     = "续费";
		} else {
			$new_msg = "该生有账号，账号已经过期，现在为新开户";
			$new     = "开户";
		}
	} else {
		$new_msg = "该生无账号，为开户";
		$new     = "开户";
	}

	if ($new == $comment) {
		$new_ok = "ok";
	} else {
		$new_ok = "not-ok";
	}

	$name_ok = null;
	if ($student_data['user_name'] == $user_name) {
		$name_msg = "名字正确";
		$name_ok  = "ok";
	} else {
		$name_msg = "名字错误，注册名为:" . $student_data['user_name'];
		$name_ok  = "not-ok";
	}

	$output = array(
		'type'          => 'output',
		'student_id'    => '该生已注册',
		'student_id_ok' => 'ok',
		'user_name'     => $name_msg,
		'name_ok'       => $name_ok,
		'fee'           => $fee,
		'fee_ok'        => $fee,
		'comment'       => $new_msg,
		'comment_ok'    => $new_ok,
	);

	$report[] = $input;
	$report[] = $output;
	return;

}

function getStudentData($student_id) {
	$sql_select = "select id,student_id,user_name,net_id,net_pwd,start_date,expire_date,grade,pay_date from students where student_id=$student_id";
// echo $sql_select;
	$query = mysql_query($sql_select);
	if ($query) {
		$num = mysql_num_rows($query);
		if ($num == 1) {
			return mysql_fetch_array($query);
		} else {
// echo "未找到学号为 $student_id 的学生数据,请检查该数据";
			// die();
		}
	} else {
		return null;
	}

}

if ($_POST['add']) {
	if ($data['student_id'] && $data['fee']) {
		associateNetAccount($data['student_id'], $data['fee']);
	}
}

if (isset($_POST['import'])) {

	$filetype = $_FILES["file"]["type"];
	if (($filetype == "application/xls") || ($filetype == "application/octet-stream")
		 || ($filetype == "application/vnd.ms-excel")
		 || ($filetype == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet")) {
		if ($_FILES["file"]["error"] > 0) {
			echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
		} else {

			$filename = iconv('UTF-8', 'GB2312', $_FILES["file"]["name"]);
			if (move_uploaded_file($_FILES["file"]["tmp_name"], "admin/upload/" . $filename)) {
				require_once dirname(__FILE__) . '/admin/PHPExcel/Classes/PHPExcel/IOFactory.php';
				$reader = PHPExcel_IOFactory::createReader('Excel2007');//设置以Excel5格式(Excel97-2003工作簿)
				// var_dump($reader);
				$PHPExcel = $reader->load("admin/upload/" . $filename);// 载入excel文件
				// var_dump($PHPExcel);
				$sheet         = $PHPExcel->getSheet(0);// 读取第一個工作表
				$highestRow    = $sheet->getHighestRow();// 取得总行数
				$highestColumm = "B";// 取得总列数
				// $highestColumm = $sheet->getHighestColumn(); // 取得总列数

/** 循环读取每个单元格的数据 */
				for ($row = 3; $row <= $highestRow; $row++) {//行数是以第1行开始
					$student_id = trim($sheet->getCell("A" . $row)->getValue());
					$user_name  = trim($sheet->getCell("B" . $row)->getValue());
					$fee        = $sheet->getCell("C" . $row)->getValue();
					$comment    = $sheet->getCell("D" . $row)->getValue();

					$student_id = filter($student_id);
					$user_name  = filter($user_name);
					$fee        = filter($fee);
					$comment    = filter($comment);

					if ($student_id == "系部") {
						break;
					}

					if ($student_id == "") {
						continue;
					}

					checkStudentId($student_id, $user_name, $fee, $comment);

				}
			} else {
				$err[] = "错误 - 上传文件失败";
			}

		}
	} else {
		$err[] = "错误 - 上传文件无效";
	}

}

include "includes/errors.php";

?>
<div class="main">


<div class="alert alert-success">
<h3>缴费前审核</h3>
<p>班长或班级负责人上传班级缴费表，点击审核可查看班级成员是否注册成功</p>
<p>导入审核表格
<br>
<img src="assets/image/001.png" width="500">
</p>
<br>
<p>查看审核结果
<br>
<img src="assets/image/002.png" width="500">
</p>
</div>
<h3 class="title">导入班级缴费表
<label class="hint">样本文件下载 :<a href="admin/download/班级缴费表.xlsx" target="_blank">班级缴费表.xlsx</a>,,请保持xlsx后缀格式</label>
</h3>
<div>
<form action="audit-self.php" method="post" enctype="multipart/form-data">
<input type="file" name="file" id="file" />
<br />
<input type="submit" name="import" class="btn btn-success" value="审核" />
</form>
</div>


<?php

if (sizeof($report) > 0) {
	?>
<h3 class="title">
审核结果
</h3>
<table id="audit-report">
<tr>
<td>学号</td>
<td>姓名</td>
<td>金额</td>
<td>开户/续费</td>
</tr>
<?php

	foreach ($report as $key => $log) {?>


<tr class="log-<?php echo $log['type'];?>">
<td class="<?php echo $log['student_id_ok'];?>">
<?php echo $log['student_id'];?>
</td>

<td class="<?php echo $log['name_ok'];?>">
<?php echo $log['user_name'];?>
</td>
<td class="<?php echo $log['fee_ok'];?>">
<?php echo $log['fee'];?>
</td>

<td class="<?php echo $log['comment_ok'];?>">
<?php echo $log['comment'];?>
</td>
</tr>
<?php
if ($log['type'] == "output") {
		echo "<tr><td colspan='4' class='center'><hr></td></tr>";
	}

		?>



<?php
}

	?>
</table>

<?php
}
?>
</div>



<?php
include 'includes/footer.php';
?>



