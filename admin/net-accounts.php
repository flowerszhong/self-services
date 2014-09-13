<?php
include '../dbc.php';
admin_page_protect();

$page_title = "上网账号表";
include '../includes/head.php';
include '../includes/sidebar.php';

$err = array();
$msg = array();

foreach ($_POST as $key => $value) {
	$data[$key] = filter($value);// post variables are filtered
}

function addAccount($net_id, $net_pwd, $err) {
	global $err;
	$sql_check_exist = "select count(id) as count from accounts where net_id='$net_id'";
	$check_query     = mysql_query($sql_check_exist);
	$check_result    = mysql_fetch_array($check_query);
	if ($check_result['count'] > 0) {
		$err[] = "该账号已经存在于数据中，请不在重复添加";
	} else {
		$current_date = date("Y-m-d");
		$sql_insert   = "insert into `accounts` (`net_id`,`net_pwd`,`used`,`import_date`) VALUES ('$net_id','$net_pwd','0','$current_date')";
		mysql_query($sql_insert) or die(mysql_error());
	}
}

if ($_POST['add']) {
	if ($data['net_id'] && $data['net_pwd']) {
		addAccount($data['net_id'], $data['net_pwd'], $err);
	}
}

if (isset($_POST['import'])) {

	$filetype = $_FILES["file"]["type"];
	if (($filetype == "application/xls") || ($filetype == "application/octet-stream") || ($filetype == "application/vnd.ms-excel")) {
		if ($_FILES["file"]["error"] > 0) {
			echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
		} else {

// if (file_exists("upload/" . $_FILES["file"]["name"])) {
			//     echo $_FILES["file"]["name"] . " already exists. ";
			// } else {
			// move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $_FILES["file"]["name"]);
			// echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
			// }

			$filename = iconv('UTF-8', 'GB2312', $_FILES["file"]["name"]);
// $filename = $_FILES["file"]["name"];
			// $encode   = mb_detect_encoding($filename, array("UTF-8", "GB2312", "GBK", 'BIG5'));
			// if ($encode == 'GB2312') {
			// 	$filename = iconv('UTF-8', 'GB2312', $filename);
			// }
			// $filename = $_FILES["file"]["name"];
			if (move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $filename)) {
				require_once dirname(__FILE__) . '/PHPExcel/Classes/PHPExcel/IOFactory.php';
				$reader        = PHPExcel_IOFactory::createReader('Excel5');//设置以Excel5格式(Excel97-2003工作簿)
				$PHPExcel      = $reader->load("upload/" . $filename);// 载入excel文件
				$sheet         = $PHPExcel->getSheet(0);// 读取第一個工作表
				$highestRow    = $sheet->getHighestRow();// 取得总行数
				$highestColumm = "B";// 取得总列数
				// $highestColumm = $sheet->getHighestColumn(); // 取得总列数

/** 循环读取每个单元格的数据 */
				for ($row = 2; $row <= $highestRow; $row++) {//行数是以第1行开始
					$net_id  = $sheet->getCell("A" . $row)->getValue();
					$net_pwd = $sheet->getCell("B" . $row)->getValue();
					addAccount($net_id, $net_pwd, $err);
// for ($column = 'A'; $column <= $highestColumm; $column++) {//列数是以A列开始
					//     $dataset[] = $sheet->getCell($column.$row)->getValue();
					//     echo $column.$row.":".$sheet->getCell($column.$row)->getValue()."<br />";
					// }
				}
			} else {
				$err[] = "错误 - 上传文件失败";
			}

		}
	} else {
		$err[] = "错误 - 上传文件无效";
	}

}

$sql_all              = 'select count(*) as count from accounts';
$sql_all_available    = 'select count(*) as count from accounts WHERE available=1';
$sql_all_unvailable   = 'select count(*) as count from accounts WHERE available=0';
$sql_all_used         = 'select count(*) as count from accounts WHERE available=1 and used=1';
$query_all            = mysql_query($sql_all) or die(mysql_error());
$query_all_available  = mysql_query($sql_all_available) or die(mysql_error());
$query_all_unvailable = mysql_query($sql_all_unvailable) or die(mysql_error());
$query_all_used       = mysql_query($sql_all_used) or die(mysql_error());
$all                  = mysql_fetch_array($query_all);
$all_available        = mysql_fetch_array($query_all_available);
$all_unvailable       = mysql_fetch_array($query_all_unvailable);
$all_used             = mysql_fetch_array($query_all_used);

$current_date = date("Y-m-d");
$first_date   = date("Y-m-01", strtotime($current_date));

$sql_select_expire = "select net_id as count from accounts where end_date<$first_date and available=1";
$sql_result1       = mysql_query($sql_select_expire);
$expire_num        = mysql_num_rows($sql_result1);

include "../includes/errors.php";

?>
<div class="main">
<h3 class="title">统计</h3>
<table>
<tr>
<td width="250">上网账号总数</td>
<td>
<?php
echo $all['count'];
?>
</td>
</tr>

<tr>
<td width="250">不可用账号总数</td>
<td>
<?php
echo $all_unvailable['count'];
?>
</td>
</tr>

<tr>
<td width="250">可用上网账号总数</td>
<td>
<?php
echo $all_available['count'];
?>
</td>
</tr>

<tr>
<td width="250">已关联学生账号总数</td>
<td>
<?php
echo $all_used['count'];
?>
</td>
</tr>
<tr>
<td>本月已过期账号总数
<br>
<label class="hint">
早于( <?php
echo $first_date;
?>)的账号总数
</label>
</td>
<td>
<?php
echo $expire_num;
?>
</td>
</tr>
<!-- <tr>
<td>
<input type="button" value="生成过期账号表" class="btn btn-danger" id="btn-expire-report" />
</td>
<td></td>
</tr> -->
</table>

<h3 class="title">导入上网账号
<label class="hint"><a href="download/上网账号表.xls" target="_blank">样本文件下载</a></label>
</h3>
<div>
<form action="net-accounts.php" method="post" enctype="multipart/form-data">
<input type="file" name="file" id="file" />
<br />
<input type="submit" name="import" class="btn btn-success" value="导入" />
</form>
</div>

<h3 class="title">
上网账号高级查询
</h3>

<div>
<a href="inquery/index.php?r=accounts/admin" class="btn btn-success">
点击查询上网账号
</a>
</div>



<h3 class="title">上网账号列表</h3>
<table>
<tr>
<td>上网账号</td>
<td>上网密码</td>
<td>是否关联</td>
</tr>
<?php

$sql_select  = "select * from `accounts` ORDER BY id DESC limit 10";
$rows_result = mysql_query($sql_select) or die(mysql_error());
?>

<?php while ($rrow = mysql_fetch_array($rows_result)) {?>
<tr>
<td>
<?php echo $rrow['net_id'];?>
</td>

<td>
<?php echo $rrow['net_pwd'];?>
</td>
<td>
<?php if ($rrow['used']) {echo "已关联";} else {
		echo "未关联";
	}?>
</td>
</tr>


<?php }?>
</table>



<!-- <h3 class="title">添加账号</h3>
<div>
<form action="net-accounts.php" method="post" id="add-form">
<table>
<tr>
<td>账号</td>
<td>
<input type="text" name="net_id" value="" class="form-control custom-input required" />
</td>
</tr>
<tr>
<td>密码</td>
<td>
<input type="text" name="net_pwd" value="" class="form-control custom-input required"/>
</td>
</tr>
<tr>
<td></td>
<td>
<input type="submit" value="提交" name="add" class="btn btn-success"/>
</td>
</tr>
</table>

</form> -->
</div>





<!-- <h3 class="title">导出上网账号表</h3>
<input type="button" value="导出" class="btn btn-success" id="export" /> -->


</div>

<?php
include '../includes/footer.php';
?>


