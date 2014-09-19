<?php
header("content-type:text/html;charset=utf-8");

include '../dbc.php';
admin_page_protect();

$err = array();
$msg = array();

foreach ($_POST as $key => $value) {
	$data[$key] = filter($value);//get variables are filtered.
}

if (isset($_POST['sync'])) {

	$name_array = array('梁嘉琪', '黄键聪', '钟伟健', '梁晓莹', '张丽');

	$sql   = "select * from students where net_id is null and grade=2013";
	$query = mysql_query($sql) or die("fail");
	while ($row = mysql_fetch_array($query)) {
		$student_id = $row['student_id'];
		$user_id    = $row['id'];
		$user_name  = $row['user_name'];
		if (in_array($user_name, $name_array)) {
			continue;
		}

		$sql_select_2013 = "select * from students2013 where name='$user_name'";
		$result_2013     = mysql_query($sql_select_2013) or die("获取原始数据失败");
		$row_2013        = mysql_fetch_array($result_2013);
		$net_id          = $row_2013['net_id'];

		if ($net_id) {
			echo $user_name . "  " . $net_id;
			echo "<br>";
			$net_pwd    = $row_2013["net_pwd"];
			$fee        = $row_2013['fee'];
			$start_date = $row_2013['pay_date'];
			$end_date   = $row_2013['expire_date'];
			$used       = 1;

			$sql_account_exist = "select * from accounts where net_id='$net_id'";
			$exist             = mysql_query($sql_account_exist) or die("获取上网账号信息失败 " . mysql_error());
			$exist_row         = mysql_fetch_array($exist);
			$exist_num         = mysql_num_rows($exist);

			if ($exist_num == 1) {
				if ($exist_row['student_id']) {
					$update2 = false;
					$msg[]   = "你的网络账号(NET ID)" . $net_id . "已经被其它账号关联";
				} else {
					$sql_update_accounts = "update accounts
				set student_id='$student_id',
				user_id='$user_id',
				user_name='$user_name',
				grade=2013
				where net_id='$net_id'";

					$update2 = mysql_query($sql_update_accounts) or die("更新上网账号信息失败: " . mysql_error());
				}
			} else {
				$update2 = false;
				if ($exist_num > 1) {
					$err[] = "网络账号 " . $net_id . " 重复出现，请及时告知管理员";
				} else {
					$err[] = "你的网络账号(NET ID)不存在";
				}

			}

			$sql_insert_consume = "INSERT into consume
(`user_id`,`student_id`,`fee`,`start_date`,`end_date`,`pay_date`)
VALUES
($user_id,'$student_id','$fee','$start_date','$end_date','$start_date')";
			$insert3 = mysql_query($sql_insert_consume) or die("更新学生消费记录表失败: " . mysql_error());
// echo $sql_insert_consume;

			$sql_update_student = "update students
set net_id='$net_id',
net_pwd='$net_pwd',
start_date='$start_date',
expire_date='$end_date',
pay_date='$start_date'
where student_id='$student_id'";
			$update4 = mysql_query($sql_update_student) or die("注册：更新学生信息失败");
// echo $update4;
			// echo $sql_update_student;

		} else {
			$update4 = true;
			$insert3 = true;
			$update2 = true;
		}

		if ($update2 and $insert3 and $update4) {
			mysql_query("COMMIT");
		} else {
			mysql_query("ROLLBACK");
		}
	}

}

$page_title = "同步历史数据";

include '../includes/head.php';
include '../includes/errors.php';
include '../includes/sidebar.php';

?>
<div class="main">
<h3 class="title">同步历史数据</h3>
<form class="form-clear" action="sync.php" method="post" id="sync-form">
<input type="submit" value="同步历史数据" name="sync" class="btn btn-success" />
<?php
if (isset($updated)) {
	echo "清理过期上网账号信息" . $updated . "条";
}
?>
</form>

</div>


<?php

include '../includes/footer.php'

?>



