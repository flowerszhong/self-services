<?php
include '../dbc.php';
admin_page_protect();

$err      = array();
$msg      = array();
$sha1pass = PwdHash('123456');
echo $sha1pass;

function randomStudentId() {
	return rand(2014091000, 2015091000);
}

function randomName($value = '学生') {
	return $value . rand(10, 3000);
}

function randomEmail($value = '@no-exist.com') {
	return rand(100, 100000) . $value;
}

$page_title = "创建账号";

if ($_GET['quickadd'] == "true") {
	foreach ($_GET as $key => $value) {
		$data[$key] = filter($value);
	}

	$student_id = randomStudentId();
	$user_name  = randomName();
	$usr_email  = randomEmail();
	$sha1pass   = PwdHash('123456');
	$tel        = rand(13000000000, 19000000000);
	$datenow    = get_Datetime_Now();
	$user_ip    = $_SERVER['REMOTE_ADDR'];
	$activ_code = rand(1000, 9999);

	$sql_insert = "INSERT into `students`
(`student_id`,`user_name`,`user_email`,`pwd`,`tel`,`reg_date`,`log_ip`,`activation_code`,`department`,`major`,`sub_major`,`grade`,`class`,`approved`)
VALUES
('$student_id','$user_name','$usr_email','$sha1pass','$tel','$datenow','$user_ip','$activ_code','$data[department]','$data[major]','$data[sub_major]','$data[grade]','$data[class]',1)
";

	$insert1 = mysql_query($sql_insert, $link) or die("insert data failed:" . mysql_error());

	$user_id = mysql_insert_id();
	$md5_id  = md5($user_id);
	$update5 = mysql_query("update students set md5_id='$md5_id' where student_id='$student_id'") or die("update md5_id error");
	$msg[]   = "创建账号成功!";
}

if (isset($_POST['doCreate'])) {

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
	// if (!checkPwd($data['pwd'], $data['pwd2'])) {
	//     $err[] = "错误 - 两次输入的密码不匹配";
	// }

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

	$sql_select   = "select count(*) as total from students where user_email='$user_email' OR student_id='$data[student_id]'";
	$rs_duplicate = mysql_query($sql_select);
	$row          = mysql_fetch_array($rs_duplicate);
	$total        = intval($row['total']);

	if ($total > 0) {
		$err[] = "错误 - 你已经注册过";
	}

/***************************************************************************/
	if (empty($err)) {
		$datenow    = get_Datetime_Now();
		$sql_insert = "INSERT into `students`
(`student_id`,`user_name`,`user_email`,`pwd`,`tel`,`reg_date`,`log_ip`,`activation_code`,`department`,`major`,`sub_major`,`grade`,`class`,`approved`,`qq`)
VALUES
('$student_id','$user_name','$usr_email','$sha1pass','$data[tel]','$datenow','$user_ip','$activ_code','$data[department]','$data[major]','$data[sub_major]','$data[grade]','$data[class]',1,'$data[qq]')
";

		$insert1 = mysql_query($sql_insert, $link) or die("insert data failed:" . mysql_error());

		$user_id = mysql_insert_id();
		$md5_id  = md5($user_id);
		$update5 = mysql_query("update students set md5_id='$md5_id' where student_id='$student_id'") or die("update md5_id error");
		$msg[]   = "创建账号成功!";

	}

}

include '../includes/head.php';
include '../includes/errors.php';
include '../includes/sidebar.php';

?>
<div class="main">
<h3 class="title">创建账号</h3>
<form action="create.php" method="post" name="regForm" id="regForm">
<table>

<tr>
<td>
<b class="required"> * </b>
学号
</td>
<td>
<input type="text" name="student_id" class="studentid" value="<?php echo randomStudentId();?>"></td>
</tr>

<tr>
<td>
    <b class="required"> * </b>
    姓名
    </span>
</td>
<td>
    <input name="user_name" type="text" id="user_name" class="required" value="<?php echo randomName();?>"></td>
</tr>

<tr>
<td>
    <b class="required"> * </b>
    邮箱地址
</td>
<td>
    <input name="usr_email" type="text" id="usr_email3" class="required email" value="<?php echo randomEmail();?>">
</td>
</tr>
<tr>
<td>
    <b class="required"> * </b>
    密码
</td>
<td>
    <input name="pwd" type="text" class="required password" minlength="6" id="pwd" value="123456">
    <b class="hint">(密码不小于6位字母数字)</b>
</td>
</tr>
<tr>
<td colspan="2">&nbsp;</td>
</tr>
<tr>
<td>上网账号</td>
<td>
    <input type="text" value="" name="net_id">
</td>
</tr>
<tr>
<td>上网密码</td>
<td>
    <input type="text" value="" name="net_pwd">
</td>
</tr>
<tr>
<td colspan="2">&nbsp;</td>
</tr>

<tr>
<td>
    电话
</td>
<td>
    <input name="tel" type="text" id="tel"></td>
</tr>

<tr>
<td>
    qq
</td>
<td>
    <input name="qq" type="text" id="qq"></td>
</tr>


<tr>
<td>
    <b class="required"> * </b>
    年级
</td>
<td>
    <select name="grade">
        <option value="2013">2013</option>
        <option value="2014" selected>2014</option>
    </select>
</td>
</tr>

<tr>
<td>
    <b class="required"> * </b>
    系别
</td>
<td>
    <select name="department" id="department"  class="form-control required">

    </select>
</td>
</tr>

<tr>
<td>
    <b class="required"> * </b>
    专业
</td>
<td>
    <select name="major" id="major" class="form-control required">
        <option value="">请选择专业</option>
    </select>
</td>
</tr>

<tr>
<td>专业方向</td>
<td>
    <select name="sub_major" id="sub-major" class="form-control">
        <option value="">请选择专业方向</option>
    </select>
</td>
</tr>
<tr>
<td>
    <b class="required"> * </b>
    班级
</td>
<td>
    <select name="class"  class="form-control required">

        <option value="">请选择班级</option>
        <option value="1">1班</option>
        <option value="2">2班</option>
        <option value="3">3班</option>
        <option value="4">4班</option>
        <option value="5">5班</option>
        <option value="6">6班</option>
        <option value="7">7班</option>
        <option value="8">8班</option>
        <option value="9">9班</option>
        <option value="10">10班</option>
    </select>
</td>
</tr>

<tr>
<td>

</td>
<td>
    <button name="doCreate" type="submit" id="doCreate" class="btn btn-success" value="create">
        创建
    </button>
</td>
</tr>

</table>
</form>
</div>


<?php

include '../includes/footer.php'

?>



