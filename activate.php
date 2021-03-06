<?php
include 'dbc.php';

foreach ($_GET as $key => $value) {
	$get[$key] = filter($value);
}

/******** EMAIL ACTIVATION LINK**********************/
if (isset($get['user']) && !empty($get['activ_code']) && !empty($get['user']) && is_numeric($get['activ_code'])) {

	$err = array();
	$msg = array();

	$user  = mysql_real_escape_string($get['user']);
	$activ = mysql_real_escape_string($get['activ_code']);

	//check if activ code and user is valid
	$sql_select = "select student_id from students where md5_id='$user' and activation_code='$activ'";
	$rs_check   = mysql_query($sql_select) or die(mysql_error());

	$num = mysql_num_rows($rs_check);

	// Match row found with more than 1 results  - the user is authenticated.
	if ($num <= 0) {
		$err[] = "账号不存在或激活码失效";
		// $err[] = "Sorry no such account exists or activation code invalid.";
		header("Location: activate.php?msg=$msg");
		// exit();
	}

	if (empty($err)) {
		// set the approved field to 1 to activate the account
		$rs_activ = mysql_query("update students set approved='1' WHERE
                         md5_id='$user' AND activation_code = '$activ' ") or die(mysql_error());
		$msg[] = "Thank you. 您的账号已经激活";
		header("Location: activate.php?done=1");
		// exit();
	}
}
?>


<?php
include 'includes/head.php';
if ($get['done']) {
	?>
<div class="container">
    <h4 class="title">注册成功，您的账号已经激活</h4>
    <p>你可以<a href="index.php">点此登录</a></p>
</div>

<?php
}
include 'includes/footer.php';
?>