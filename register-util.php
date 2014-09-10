<?php
$err = array();
$msg = array();

if ($_POST['doRegister'] == 'Register') {

	foreach ($_POST as $key => $value) {
		$data[$key] = filter($value);
	}

// Validate Student Id
	if (!isset($data['student_id'])) {
		$err[] = "错误 - 请输入学号";
	} else {
		$student_id = $data['student_id'];
	}

	if (!isStudentId($data['student_id'])) {
		$err[] = "错误 - 请输入正确的学号.";
	}

// Validate User Name
	if (!isUserName($data['user_name'])) {
		$err[] = "错误 - 不合法的用户名.";
	}

// Validate Email
	if (!isEmail($data['usr_email'])) {
		$err[] = "错误 - 不合法的邮箱地址.";
	}
// Check User Passwords
	if (!checkPwd($data['pwd'], $data['pwd2'])) {
		$err[] = "错误 - 两次输入的密码不匹配";
	}

	$user_ip = $_SERVER['REMOTE_ADDR'];

// stores sha1 of password
	$sha1pass = PwdHash($data['pwd']);

// Automatically collects the hostname or domain  like example.com)
	$host       = $_SERVER['HTTP_HOST'];
	$host_upper = strtoupper($host);
	$path       = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

// Generates activation code simple 4 digit number
	$activ_code = rand(1000, 9999);

	$usr_email = $data['usr_email'];
// $user_name = base64_encode($data['user_name']);
	$user_name = $data['user_name'];

/************ USER EMAIL CHECK ************************************
This code does a second check on the server side if the email already exists. It
queries the database and if it has any existing email it throws user email already exists
 *******************************************************************/

	$sql_select   = "select count(*) as total from students where user_email='$usr_email' OR student_id='$data[student_id]'";
	$rs_duplicate = mysql_query($sql_select) or die("检查学生信息信息是否重复");
	$row          = mysql_fetch_array($rs_duplicate);
	$total        = intval($row['total']);

	if ($total > 0) {
		$err[] = "错误 - 出现重复的学号或邮箱，请确认你是否已经注册过";
	}

	if ($data['net_id']) {
		$net_id = 'fsVPDNhb' . $data['net_id'] . '@fsnhedu.v.gd';
// $net_id          = 'fsVPDNhb001728@fsnhedu.v.gd';
		$sql_select_2013 = "select * from students2013 where net_id='$net_id'";
		$result_2013     = mysql_query($sql_select_2013) or die("获取原始数据失败");
		$row_2013        = mysql_fetch_array($result_2013);
	}

/***************************************************************************/
	if (empty($err)) {
		$datenow = get_Datetime_Now();

		mysql_query("START TRANSACTION");
		$sql_insert = "INSERT into `students`
(`student_id`,`user_name`,`user_email`,`pwd`,`tel`,`qq`,`reg_date`,`log_ip`,`activation_code`,`department`,`major`,`sub_major`,`grade`,`class`)
VALUES
('$student_id','$user_name','$usr_email','$sha1pass','$data[tel]','$data[qq]','$datenow','$user_ip','$activ_code','$data[department]','$data[major]','$data[sub_major]','$data[grade]','$data[class]')";

		$insert1 = mysql_query($sql_insert) or die("注册新用户失败:" . mysql_error());
// sleep(3);

		$user_id = mysql_insert_id();
		$md5_id  = md5($user_id);

		if (isset($row_2013) and (intval($data['grade']) == 2013)) {
			$net_pwd    = $row_2013["net_pwd"];
			$fee        = $row_2013['fee'];
			$start_date = $row_2013['pay_date'];
			$end_date   = $row_2013['expire_date'];
			$used       = 1;

			//TODO: 检查上网账号是否已经存在

			$sql_account_exist = "select * from accounts where net_id='$net_id'";
			$exist             = mysql_query($sql_account_exist) or die("获取上网账号信息失败 " . mysql_error());
			$exist_row         = mysql_fetch_array($exist);
			$exist_num         = mysql_num_rows($exist);

			if ($exist_num == 1) {
				if ($exist_row['student_id']) {
					$update2 = false;
					$msg[]   = "你的网络账号(NET ID)已经被其它账号关联";
				} else {

					$sql_update_accounts = "update accounts
						set student_id='$data[student_id]',
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

		$update5 = mysql_query("update students set md5_id='$md5_id' where student_id='$student_id'") or die("update md5_id error");

		if ($insert1 and $update2 and $insert3 and $update4 and $update5) {
			mysql_query("COMMIT");
			if ($user_registration) {
				$a_link = "
<h3>激活你的账号</h3>
<a href='http://$host$path/activate.php?user=$md5_id&activ_code=$activ_code'>http://$host$path/activate.php?user=$md5_id&activ_code=$activ_code</a>";
			} else {
				$a_link = "你的账号正在等待管理员激活";
			}

			$message = "<p>hi $user_name,感谢你使用上网自助服务！</p>
<ul>
<li>姓名: $user_name</li>
<li>学号: $student_id</li>
<li>邮箱: $usr_email </li>
<li>密码: $data[pwd]</li>
</ul>

$a_link";

			$subject = "请激活您的账号";
			$smtpOK  = sendEmail($subject, $message, $usr_email);

			header("Location: thankyou.php");
			exit();
		} else {
			mysql_query("ROLLBACK");
			$err[] = "注册不成功，请重新注册或联系管理员";
		}

	}
}

?>