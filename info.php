<?php
include 'dbc.php';
page_protect();

$err = array();
$msg = array();

$rs_settings = mysql_query("select * from students where id='$_SESSION[user_id]'") or die(mysql_error());
$row_settings = mysql_fetch_array($rs_settings);

$rows_consume = mysql_query("select * from consume where user_id='$_SESSION[user_id]'") or die("查询缴费记录失败");
$consume_num = mysql_num_rows($rows_consume);

if ($_POST['doUpdate']) {
	$rs_pwd = mysql_query("select * from students where id='$_SESSION[user_id]'");
	$rs_pwd_row = mysql_fetch_array($rs_pwd);
	$old = $rs_pwd_row['pwd'];
	$old_salt = substr($old, 0, 9);

	$student_id = $rs_pwd_row['student_id'];
	$user_email = $rs_pwd_row['user_email'];
	$user_name = $rs_pwd_row['user_name'];
	$tel = $rs_pwd_row['tel'];
	$qq = $rs_pwd_row['qq'];
	$department = $rs_pwd_row['department'];
	$major = $rs_pwd_row['major'];
	$sub_major = $rs_pwd_row['sub_major'];
	$grade = $rs_pwd_row['grade'];
	$class = $rs_pwd_row['class'];

	$sql_insert_user = "INSERT into `user`
	(`student_id`,`user_name`,`user_email`,`pwd`,`tel`,`qq`,`department`,`major`,`sub_major`,`grade`,`class`)
	VALUES
	('$student_id','$user_name','$user_email','$_POST[pwd_new]','$tel','$qq','$department','$major','$sub_major','$grade','$class')";

	@mysql_query($sql_insert_user);

//check for old password in md5 format
	if ($old === PwdHash($_POST['pwd_old'], $old_salt)) {
		$newsha1 = PwdHash($_POST['pwd_new']);
		mysql_query("update students set pwd='$newsha1' where id='$_SESSION[user_id]'");
		$msg[] = "你的账号已经更新";
	} else {
		$err[] = "你输入的旧密码不正确";
	}

}

include 'includes/head.php';
include 'includes/errors.php';
?>
<div class="container">

<h3 class="title">宽带账号信息</h3>
<table id="net-account-table">
<tr>
<td width="120">宽带上网账号</td>
<td>
<?php if ($row_settings['net_id']) {?>
<input name="student_id" type="text" id="student_id" value="<? echo $row_settings['net_id']; ?>" class="form-control custom-input" disabled></td>
<?php } else {?>
你尚未分配上网账号
<?php }?>
</tr>
<tr>
<td>宽带账号密码</td>
<td>
<?php if ($row_settings['net_id']) {?>
<button class="btn btn-info" id="btn-check-pwd">查看宽带账号密码</button>
<span for="" id="label-net-pwd"><?php echo $row_settings['net_pwd'];?>
<label class="hint">（如果密码与你使用密码不符合，请以你现在使用的密码为准，并通知信息中心更新）</label>
</span>

<?php }?>
</td>
</tr>
<tr>
<td>账号过期时间</td>
<td>
<label for=""><?php echo format_date($row_settings['expire_date']);?></label>
</td>
</tr>


</table>

<?php
if ($consume_num > 0) {?>
<h3 class="title">你的缴费记录</h3>
<table>
<tr>
<td>缴费金额</td>
<td>开始时间</td>
<td>截止时间</td>
</tr>
<?php while ($consume_row = mysql_fetch_array($rows_consume)) {?>
<tr>
<td>
<?php echo $consume_row['fee'];?></td>
<td>
<?php echo format_date($consume_row['start_date']);?>
</td>
<td>
<?php echo format_date($consume_row['end_date']);?>
</td>
</tr>

<?php }
	?>
</table>

<?php }
?>
<h3 class="title">修改网站登录密码<b class="hint">(这个密码是wf.gdepc.com的登录密码，非宽带账号密码)</b></h3>
<div class="table-responsive">
<form name="resetForm" id="reset-form" method="post" action="info.php">
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
include 'includes/footer.php';
?>