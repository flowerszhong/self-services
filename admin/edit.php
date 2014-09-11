<?php
/********************** MYSETTINGS.PHP**************************
This updates user settings and password
 ************************************************************/
include '../dbc.php';
admin_page_protect();

$err = array();
$msg = array();

if (!empty($_GET['id'])) {
	$id = $_GET['id'];

} else {
	header("Content-type:text/html;charset=utf-8");
	echo "不存在该用户，请检查该用户ID";
	die();
}

if (sizeof($_POST) > 0) {
// Filter POST data for harmful code (sanitize)
	foreach ($_POST as $key => $value) {
		$data[$key] = filter($value);
	}

// var_dump($_POST);

	if ($data['user_name']) {
		$sql_update = "UPDATE students SET `user_name` = '$data[user_name]' WHERE id='$id'";
		mysql_query($sql_update) or die(mysql_error());
	}

	if ($data['student_id']) {
		$sql_update = "UPDATE students SET `student_id` = '$data[student_id]' WHERE id='$id'";
		mysql_query($sql_update) or die(mysql_error());
	}

	if ($data['tel']) {
		$sql_tel_update = "UPDATE students SET `tel` = '$data[tel]' WHERE id='$id'";
		mysql_query($sql_tel_update) or die(mysql_error());
	}

	if ($data['qq']) {
		$sql_qq_update = "UPDATE students SET `qq` = '$data[qq]' WHERE id='$id'";
		mysql_query($sql_qq_update) or die(mysql_error());
	}

	if ($data['user_email']) {
		$sql_update = "UPDATE students SET `user_email` = '$data[user_email]' WHERE id='$id'";
		mysql_query($sql_update) or die(mysql_error());
	}

	if ($data['grade']) {
		$sql_update = "UPDATE students SET `grade` = '$data[grade]' WHERE id='$id'";
		mysql_query($sql_update) or die(mysql_error());
	}

	if ($data['department']) {
		$sql_update = "UPDATE students SET `department` = '$data[department]',`major` = '$data[major]',`sub_major` = '$data[sub_major]' WHERE id='$id'";
		mysql_query($sql_update) or die(mysql_error());
	}

	if ($data['major']) {
		$sql_update = "UPDATE students SET `major` = '$data[major]',`sub_major` = '$data[sub_major]'  WHERE id='$id'";
		mysql_query($sql_update) or die(mysql_error());
	}

	if ($data['sub_major']) {
		$sql_update = "UPDATE students SET `sub_major` = '$data[sub_major]' WHERE id='$id'";
		mysql_query($sql_update) or die(mysql_error());
	}

	if ($data['class']) {
		$sql_update = "UPDATE students SET `class` = '$data[class]' WHERE id='$id'";
		mysql_query($sql_update) or die(mysql_error());
	}

	$msg[] = "人个资料更新成功";
}

$rs_settings  = mysql_query("select * from students where id='$id'") or die(mysql_error());
$row_settings = mysql_fetch_array($rs_settings);

$page_title = '编辑学生信息';
include '../includes/head.php';
include '../includes/errors.php';
include '../includes/sidebar.php';
?>
<div class="main">

<h3 class="title">编辑学生信息</h3>
<form action="edit.php?id=<?php echo $id;?>" method="post" name="settingForm" id="setting-form">
<table id="setting-table">
<tr>
<td>学号</td>
<td>
<input name="student_id" type="text" id="student_id" class="required" value="<? echo $row_settings['student_id']; ?>" />
</td>
</tr>

<tr>
<td>姓名</td>
<td>
<input name="user_name" type="text" value="<? echo $row_settings['user_name']; ?>" ></td>
</tr>

<tr>
<td>邮箱</td>
<td>
<input name="user_email" type="text" class="email" value="<? echo $row_settings['user_email']; ?>" ></td>
</tr>

<tr>
<td>
密码
</td>
<td>
<a id="btn-reset-pwd" class="btn btn-danger" data-id="<? echo $row_settings['student_id']; ?>">重置密码为123456</a>
</td>
</tr>

<tr>
<td>电话</td>
<td>
<input name="tel" type="text" id="tel" value="<? echo $row_settings['tel']; ?>"></td>
</tr>

<tr>
<td>qq</td>
<td>
<input name="qq" type="text" id="qq" value="<? echo $row_settings['qq']; ?>"></td>
</tr>

<tr>
<td colspan="2"></td>
</tr>

<tr>
<td>上网账号</td>
<td>
<input name="net_id" id="input-net-id" type="text" value="<? echo $row_settings['net_id']; ?>" disabled>
<?php if ($row_settings['net_id']) {
	?>
	<a class="btn btn-danger" id="resign-net" data-id="<? echo $row_settings['net_id']; ?>">重新分配上网账号</a>
	<?php
}?>
</td>
</tr>

<tr>
<td>密码</td>
<td>
<input name="net_pwd" id="input-net-pwd" type="text" value="<? echo $row_settings['net_pwd']; ?>" disabled>

<?php if ($row_settings['net_id']) {
	?>
	<a class="btn btn-danger" id="resign-net-pwd">重置上网账号密码</a>
		<span id="confirm-resign">
		<input type="text" value="" id="new-net-pwd" data-net="<? echo $row_settings['net_id']; ?>" placeholder="请输入新密码" />
		<input type="button" value="确认" class="btn btn-success" id="reset-net-pwd" />
		</span>
	<?php
}?>

</td>
</td>
</tr>

<tr>
<td colspan="2"></td>
</tr>

<tr>
<td>专业设置</td>
<td>
<input type="button" value="点击修改" id="change-major-setting">
<input type="button" value="取消修改" id="cancel-setting-btn">
</td>
</tr>
<tr>
<td>年级</td>
<td>
<label class="lbl">
<? echo $row_settings['grade']; ?>
</label>

<select name="grade" id="grade" class="editing form-control required">
<option value="">请选择年级</option>
<option value="2013">2013</option>
<option value="2014">2014</option>
</select>
</td>
</tr>

<tr>
<td>系别</td>
<td>
<label class="lbl"> <?php echo $row_settings['department'];?></label>

<select name="department" id="department" class="form-control required editing">
</select>
</td>
</tr>

<tr>
<td>专业</td>
<td>

<label class="lbl">
<?php echo $row_settings['major'];?>
</label>

<select name="major" id="major" class="form-control required editing">
<option value="">请选择专业</option>
</select>
</td>
</tr>

<tr>
<td>专业方向</td>
<td>

<label class="lbl">
<?php echo $row_settings['sub_major'];?>
</label>

<select name="sub_major" id="sub-major" class="form-control editing">
<option value="">请选择专业方向</option>
</select>
</td>
</tr>

<tr>
<td>班级</td>
<td>
<label class="lbl"><?php echo $row_settings['class'];?> 班</label>

<select name="class" id="" class="editing required"> cvalue="<?php echo $row_settings['class'];?>" >

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
<td></td>
<td>
<a class="btn btn-success" id="link-save-setting">保存</a>
</td>
</tr>
</table>
</form>
</div>

<?php

$footer_scripts = array("assets/lib/jquery.validate.js", "assets/lib/jquery.validate.ext.js");

include '../includes/footer.php';?>



