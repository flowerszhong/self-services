<?php
include '../dbc.php';
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

if ($_POST['user_name'] && $_POST['pwd']) {

	foreach ($_POST as $key => $value) {
		$data[$key] = filter($value);// post variables are filtered
	}

	$user_name = $data['user_name'];
	$pass      = $data['pwd'];

	if (isAdminName($user_name)) {

		$search_cond = "where name='$user_name'";

		$sql_select = "SELECT `id`,`pwd` FROM admin $search_cond";
		$result     = mysql_query($sql_select) or die(mysql_error());

		$num = mysql_num_rows($result);

		if ($num == 1) {
			$row = mysql_fetch_row($result);

// Match row found with more than 1 results  - the user is authenticated.
			if ($row) {

				list($id, $pwd) = $row;

				if ($pwd === PwdHash($pass, substr($pwd, 0, 9))) {
					if (empty($err)) {

// this sets session and logs user in
						session_start();
						session_regenerate_id(true);//prevent against session fixation attacks.

// this sets variables in the session
						$_SESSION['admin_id']        = $id;
						$_SESSION['admin_name']      = $user_name;
						$_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);

//update the timestamp and key for cookie
						$stamp = time();
						$ckey  = GenKey();
						mysql_query("update admin set `ctime`='$stamp', `ckey` = '$ckey' where id='$id'") or die(mysql_error());

//set a cookie

						if (isset($_POST['remember'])) {
							setcookie("admin_id", $_SESSION['admin_id'], time() + 60 * 60 * 24 * COOKIE_TIME_OUT, "/");
							setcookie("admin_key", sha1($ckey), time() + 60 * 60 * 24 * COOKIE_TIME_OUT, "/");
							setcookie("admin_name", $_SESSION['admin_name'], time() + 60 * 60 * 24 * COOKIE_TIME_OUT, "/");
						}

						header("Location: statistics.php");
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
			echo "no record";
		}

	} else {
		$err[] = "请输入正确的用户名";
	}

}

$page_title = "登录-后台";
include '../includes/head.php';
include '../includes/errors.php';
?>
<div class="container" style="height:360px;">
<h3 class="title">管理员登录</h3>
<?php
if ($_SESSION['student_id'] && $_SESSION['student_name']) {
	?>
	<p>你已经登录，点击<a href="logout.php">退出</a>，或点击查看<a href="statistics.php">统计面板</a></p>

	<?php } else {?>
	<form class="form-signin" action="index.php" method="post" id="login-form" name="logForm">
		    <label>用户名</label>
		    <div>
		        <input type="text" name="user_name" class="form-control login-input required" placeholder="用户名" minlength='6' required="" autofocus="">
		    </div>
		    <label>密码</label>
		    <div>
		        <input type="password" name="pwd" class="form-control login-input required" minlength='6' placeholder="密码" required="">
		    </div>

		    <div class="login-util">
		        <label class="checkbox pull-left">
		        <input type="checkbox" value="1" name="remember">
		        记住我
		    </label>
		    </div>

		    <input type="submit" class="btn btn-primary" name="doLogin" value="登录" />

		</form>

	<?php }?>
</div>


<?php
include '../includes/footer.php';
?>