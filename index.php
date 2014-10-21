<?php
include 'dbc.php';
session_start();

$err = array();
$msg = array();

// if (isset($_SESSION['student_id'])) {
//     header("Location: info.php");
//     die();
// }

foreach ($_GET as $key => $value) {
	$get[$key] = filter($value);//get variables are filtered.
}

if ($_POST['student_id'] && $_POST['pwd']) {

	foreach ($_POST as $key => $value) {
		$data[$key] = filter($value);// post variables are filtered
	}

	$student_id = $data['student_id'];
	$pass = $data['pwd'];

	if (isStudentId($student_id)) {
		$search_cond = "where student_id=$student_id";

		$sql_select = "SELECT `id`,`pwd`,`user_name`,`approved` FROM students $search_cond";
		$result = mysql_query($sql_select) or die(mysql_error());

		$num = mysql_num_rows($result);

		if ($num > 0) {
			$row = mysql_fetch_row($result);

// Match row found with more than 1 results  - the user is authenticated.
			if ($row) {

				list($id, $pwd, $user_name, $approved) = $row;

				if (!$approved) {
//$msg = urlencode("Account not activated. Please check your email for activation code");
					$err[] = "账号尚未激活，请检查你的邮件，激活你的账号";
				}
//check against salt

				if ($pwd === PwdHash($pass, substr($pwd, 0, 9))) {
					if (empty($err)) {

// this sets session and logs user in
						session_start();
						session_regenerate_id(true);//prevent against session fixation attacks.

// this sets variables in the session
						$_SESSION['user_id'] = $id;
						$_SESSION['student_id'] = $id;
						$_SESSION['student_name'] = $user_name;
						$_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);

//update the timestamp and key for cookie
						$stamp = time();
						$ckey = GenKey();
						mysql_query("update students set `ctime`='$stamp', `ckey` = '$ckey' where id='$id'") or die(mysql_error());

//set a cookie

						if (isset($_POST['remember'])) {
							setcookie("student_id", $_SESSION['user_id'], time() + 60 * 60 * 24 * COOKIE_TIME_OUT, "/");
							setcookie("user_key", sha1($ckey), time() + 60 * 60 * 24 * COOKIE_TIME_OUT, "/");
							setcookie("student_name", $_SESSION['student_name'], time() + 60 * 60 * 24 * COOKIE_TIME_OUT, "/");
						}

						header("Location: info.php");
						die();
					}
				} else {
//$msg = urlencode("Invalid Login. Please try again with correct user email and password. ");
					$err[] = "登录出错，请填写正确账号及密码";
//header("Location: login.php?msg=$msg");
				}
			} else {
				$err[] = "登录出错，该账号不存在";
			}
		} else {
			$err[] = "学号或密码不正确";
		}

	} else {
		$err[] = "请输入正确的学号";
	}

}
include 'includes/head.php';
include 'includes/errors.php';
?>
<div class="container">
<div class="alert alert-success">
<h3>Welcome!</h3>
<p>1.请点击<a href="notices.php">[使用需知]</a>查看上网缴费流程，或下载<a href="download/使用需知.rar">[使用需知文件包(1.13MB)]</a></p>
<p style="color:red;">2.<b>2014</b>级新生默认已注册，初始密码为<b>“123456”</b>，请及时登录并修改密码</p>
<p>3.下载<a href="download/拨号客户端.rar">[电信拨号软件客户端]</a></p>
<p>4.生成并下载<a style="color:red;" href="export-table.php">[班级缴费表]</a></p>
<p>5.请使用IE7+,Chrome,Firefox,Safari等浏览器</p>
</div>
</div>

<div class="container">
<h3 class="title">登录</h3>
<?php
if ($_SESSION['student_id'] && $_SESSION['student_name']) {
	?>
<p>你已经登录，点击<a href="logout.php">退出</a></p>

<?php } else {?>
<form class="form-signin" action="index.php" method="post" id="login-form" name="logForm">
<label>学号</label>
<div>
<input type="text" name="student_id" id="student_id" class="form-control login-input required student_id" placeholder="请输入学号" required="" autofocus="">
</div>
<label>密码</label>
<div>
<input type="password" name="pwd" class="form-control login-input" placeholder="请输入密码" minlength="6" required="">
</div>

<div class="login-util">
<label class="checkbox pull-left">
<input type="checkbox" value="1" name="remember">
记住我
</label>
<a href="forgot.php" class="forgot-pwd">忘记密码 </a>
</div>


<input class="btn btn-primary" name="doLogin" value="登录" type="submit" />

<a class="btn btn-success btn-register" href="register.php">
注册</a>

<span class="clearfix"></span>
</form>

<?php }?>
</div>


<?php
include 'includes/footer.php';

?>
<style type="text/css">
#float-new{
	position: absolute;
	width: 300px;
	border:1px solid green;
	background: white;
	padding: 10px;
	padding-top: 0;
}

#close-float-new{
	cursor: pointer;
}

</style>

<?php
$notice = getNewestNotice();
if ($notice) {
	?>
<div class="float-new" id="float-new">
		<h3 class="title">
		<a href="<?php echo SITE_ROOT . '/admin/inquery/index.php?r=notice/view&id=' . $notice['id']?>"><?php echo $notice['title'];?></a>

</h3>
<div class="float-new-content">
<?php echo $notice['summary'];?>
</div>
<br />
<input id="close-float-new" type="button" value="关闭通知" />

</div>

<?php }
?>