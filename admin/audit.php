<?php
include '../dbc.php';
admin_page_protect();

$page_title = "审核";
include '../includes/head.php';
include '../includes/sidebar.php';

$err    = array();
$msg    = array();
$report = array();

foreach ($_POST as $key => $value) {
	$data[$key] = filter($value);// post variables are filtered
}
function checkStudentId($student_id, $user_name, $fee, $comment, $filename) {
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

		$sql = "INSERT INTO `audit`
					(`filename`, `student_id`, `user_name`, `fee`, `comment`, `student_id_msg`, `student_id_ok`, `user_name_msg`, `user_name_ok`,
						`fee_msg`, `fee_ok`, `comment_msg`, `comment_ok`)
				VALUES
					('$filename',$student_id,'$user_name','$fee','$comment','$output[student_id]','$output[student_id_ok]','$output[user_name]','$output[name_ok]',
						'$output[fee]','$output[fee_ok]','$output[comment]','$output[comment_ok]')";
		@mysql_query($sql);

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

	if ($new_ok == "not-ok" || $name_ok == "not-ok") {
		$sql = "INSERT INTO `audit`
					(`filename`, `student_id`, `user_name`, `fee`, `comment`, `student_id_msg`, `student_id_ok`, `user_name_msg`, `user_name_ok`,
						`fee_msg`, `fee_ok`, `comment_msg`, `comment_ok`)
				VALUES
					('$filename',$student_id,'$user_name','$fee','$comment','$output[student_id]','$output[student_id_ok]','$output[user_name]','$output[name_ok]',
						'$output[fee]','$output[fee_ok]','$output[comment]','$output[comment_ok]')";
		@mysql_query($sql);
	}

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
			$origin_file_name = $_FILES["file"]["name"];
			$filename         = iconv('UTF-8', 'GB2312', $_FILES["file"]["name"]);
			if (move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $filename)) {
				require_once dirname(__FILE__) . '/PHPExcel/Classes/PHPExcel/IOFactory.php';
				$reader = PHPExcel_IOFactory::createReader('Excel2007');//设置以Excel5格式(Excel97-2003工作簿)
				// var_dump($reader);
				$PHPExcel = $reader->load("upload/" . $filename);// 载入excel文件
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
					$comment    = trim($sheet->getCell("D" . $row)->getValue());
					if ($student_id == "系部") {
						break;
					}

					if ($student_id == "") {
						continue;
					}

					if ($student_id && $user_name && $fee && $comment) {

						checkStudentId($student_id, $user_name, $fee, $comment, $origin_file_name);

					}
				}
			} else {
				$err[] = "错误 - 上传文件失败";
			}

		}
	} else {
		$err[] = "错误 - 上传文件无效";
	}

}

include "../includes/errors.php";

?>
<div class="main">

<h3 class="title">导入班级缴费表
<label class="hint">xls文档类型请另存为xlsx文档类型后，再导入审核</label>
</h3>
<div>
<form action="audit.php" method="post" enctype="multipart/form-data">
<input type="file" name="file" id="file" />
<br />
<input type="submit" name="import" class="btn btn-success" value="审核" />
</form>
</div>


<?php

if (sizeof($report) > 0) {
	?>
<h3 class="title">
<?php echo $origin_file_name;?><br>
 审核结果(<?php echo sizeof($report) / 2;?>条记录)
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
include '../includes/footer.php';
?>



