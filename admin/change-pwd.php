<?php
include '../dbc.php';
admin_page_protect();

foreach ($_POST as $key => $value) {
	$data[$key] = filter($value);//get variables are filtered.
}

if ($_POST['doUpdate']) {
	$rs_pwd     = mysql_query("select pwd from admin where id='$_SESSION[admin_id]'");
	$rs_pwd_row = mysql_fetch_array($rs_pwd);
	$old        = $rs_pwd_row['pwd'];
	$old_salt   = substr($old, 0, 9);

//check for old password in md5 format
	if ($old === PwdHash($_POST['pwd_old'], $old_salt)) {
		$newsha1 = PwdHash($_POST['pwd_new']);
		mysql_query("update admin set pwd='$newsha1' where id='$_SESSION[admin_id]'");
		$msg[] = "你的账号已经更新";
	} else {
		$err[] = "你输入的旧密码不正确";
	}

}

include '../includes/head.php';
include '../includes/errors.php';
include '../includes/sidebar.php';
?>
<div class="main">


<h3 class="title">修改密码</h3>
<div class="table-responsive">
<form name="resetForm" id="reset-form" method="post" action="change-pwd.php">
<table class="table table-striped">
<tr>
<td width="120">旧密码</td>
<td><input name="pwd_old" type="password" class="required password" minlength="6" id="pwd_old"></td>
</tr>
<tr>
<td>输入新密码</td>
<td><input name="pwd_new" type="password" id="pwd_new" class="required password" minlength='6'></td>
</tr>

<tr>
<td>再次输入新密码</td>
<td>
<input name="pwd_new_2" type="password" id="pwd_new_again" class="password required" minlength="6" equalto="#pwd_new" >
</td>
</tr>
<tr>
<td></td>
<td>
<input name="doUpdate" type="submit" id="doUpdate" class="btn btn-success" value="更新">
</td>
</tr>
</table>
</form>
</div>


</div>


<?php
include '../includes/footer.php';
?>