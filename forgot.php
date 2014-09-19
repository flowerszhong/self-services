<?php
include 'dbc.php';

foreach ($_POST as $key => $value) {
	$data[$key] = filter($value);
}

$err = array();
$msg = array();

if (isset($_POST['reset'])) {

	$student_id = $data['student_id'];
	$user_name  = $data['user_name'];
	$user_email = $data['usr_email'];
	$sha1pass   = PwdHash('123456');

	$student_id = $data['student_id'];

	$sql_update = "update students set pwd='$sha1pass' where
				student_id=$student_id
				and user_email='$user_email'
				and user_name='$user_name'";

	$query = mysql_query($sql_update) or die("重置学生密码失败");

	$updated = mysql_affected_rows();
	if ($updated) {
		$msg[] = "密码重置成功";
	} else {
		$err[] = "密码重置失败，请填写正确的信息";
	}

}

if (isset($_POST['doReset'])) {

	if (!isEmail($data['user_email'])) {
		$err[] = "ERROR - 请输入正确的邮箱地址";
	}

	$user_email = $data['user_email'];

	//check if activ code and user is valid as precaution
	$rs_check = mysql_query("select student_id,user_name from students where user_email='$user_email'") or die(mysql_error());
	$num      = mysql_num_rows($rs_check);

	// Match row found with more than 1 results  - the user is authenticated.
	if ($num !== 1) {
		$err[] = "错误 - 该邮箱未注册.";
	}

	if (empty($err)) {

		$new_pwd   = GenPwd();
		$pwd_reset = PwdHash($new_pwd);
		//$sha1_new = sha1($new);
		//set update sha1 of new password + salt
		$rs_activ = mysql_query("update students set pwd='$pwd_reset' WHERE
      						 user_email='$user_email'") or die("重置密码失败");

		$host       = $_SERVER['HTTP_HOST'];
		$host_upper = strtoupper($host);

		$row          = mysql_fetch_array($rs_check);
		$student_id   = $row['student_id'];
		$student_name = $row['user_name'];

		//send email
		$message =
		"<h1>$student_name 同学</h1>
      <p>你好!</p>
      <p>以下账号新密码</p>
      <ul>
          <li>邮箱: $user_email </li>
          <li>密码: $new_pwd</li>
      </ul>
";

		$subject = "你的密码已经重置";
		sendEmail($subject, $message, $user_email);
		$msg[] = "你的密码已经重置成功，请查看你的邮箱";

	}
}
include 'includes/head.php';
include 'includes/errors.php';

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
  <h3 class="title">方式2：邮件获取密码</h3>
        <p>新的密码将会发送至你的注册邮箱</p>

        <form action="forgot.php" method="post" name="actForm" id="actForm" >
              <label>请输入注册邮箱：</label>
              <input name="user_email" type="text" class="required email form-control custom-input">
              <input name="doReset" type="submit" class="btn btn-success" id="doLogin3" value="获取密码">
        </form>
</div>

<?php
$footer_scripts = array("assets/js/forgot.js");
include 'includes/footer.php';
?>
