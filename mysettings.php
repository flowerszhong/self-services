<?php
/********************** MYSETTINGS.PHP**************************
This updates user settings and password
 ************************************************************/
include 'dbc.php';
page_protect();

$err = array();
$msg = array();

if (sizeof($_POST) > 0) {
// Filter POST data for harmful code (sanitize)
	foreach ($_POST as $key => $value) {
		$data[$key] = filter($value);
	}

// var_dump($_POST);

	if ($data['user_name']) {
		echo "string";
		$sql_update = "UPDATE students SET `user_name` = '$data[user_name]' WHERE id='$_SESSION[user_id]'";
		mysql_query($sql_update) or die(mysql_error());
	}

	if ($data['student_id']) {
		$sql_update = "UPDATE students SET `student_id` = '$data[student_id]' WHERE id='$_SESSION[user_id]'";
		mysql_query($sql_update) or die(mysql_error());
	}

	if ($data['tel']) {
		$sql_tel_update = "UPDATE students SET `tel` = '$data[tel]' WHERE id='$_SESSION[user_id]'";
		mysql_query($sql_tel_update) or die(mysql_error());
	}

	if ($data['qq']) {
		$sql_qq_update = "UPDATE students SET `qq` = '$data[qq]' WHERE id='$_SESSION[user_id]'";
		mysql_query($sql_qq_update) or die(mysql_error());
	}

	if ($data['user_email']) {
		$sql_update = "UPDATE students SET `user_email` = '$data[user_email]' WHERE id='$_SESSION[user_id]'";
		mysql_query($sql_update) or die(mysql_error());
	}

	if ($data['grade']) {
		$sql_update = "UPDATE students SET `grade` = '$data[grade]' WHERE id='$_SESSION[user_id]'";
		mysql_query($sql_update) or die(mysql_error());
	}

	if ($data['department']) {
		$sql_update = "UPDATE students SET `department` = '$data[department]',`major` = '$data[major]',`sub_major` = '$data[sub_major]' WHERE id='$_SESSION[user_id]'";
		mysql_query($sql_update) or die(mysql_error());
	}

	if ($data['major']) {
		$sql_update = "UPDATE students SET `major` = '$data[major]',`sub_major` = '$data[sub_major]'  WHERE id='$_SESSION[user_id]'";
		mysql_query($sql_update) or die(mysql_error());
	}

	if ($data['sub_major']) {
		$sql_update = "UPDATE students SET `sub_major` = '$data[sub_major]' WHERE id='$_SESSION[user_id]'";
		mysql_query($sql_update) or die(mysql_error());
	}

	if ($data['class']) {
		$sql_update = "UPDATE students SET `class` = '$data[class]' WHERE id='$_SESSION[user_id]'";
		mysql_query($sql_update) or die(mysql_error());
	}

	$msg[] = "人个资料更新成功";
}

$rs_settings  = mysql_query("select * from students where id='$_SESSION[user_id]'") or die(mysql_error());
$row_settings = mysql_fetch_array($rs_settings);
include 'includes/head.php';
include 'includes/errors.php';
?>
<div class="container">

<h3 class="title">人个档案</h3>

<p>你可以修改部分个人信息。</p>
<br>
<form action="mysettings.php" method="post" name="settingForm" id="setting-form">
<table id="setting-table">
<tr>
<td>学号</td>
<td>
<input name="student_id" type="text" id="student_id" class="required" value="<? echo $row_settings['student_id']; ?>"

<?php if (!empty($row_settings['student_id'])) {
	echo "disabled";
}?>
></td>
</tr>

<tr>
<td>姓名</td>
<td>
<input name="user_name" type="text" value="<? echo $row_settings['user_name']; ?>"
<?php if (!empty($row_settings['user_name'])) {
	echo "disabled";
}?>
></td>
</tr>

<tr>
<td>邮箱</td>
<td>
<input name="user_email" type="text" class="email" value="<? echo $row_settings['user_email']; ?>"

<?php if (!empty($row_settings['user_email'])) {
	echo "disabled";
}?>

></td>
</tr>

<tr>
<td>电话</td>
<td>
<input name="tel" type="text" id="tel" value="<? echo $row_settings['tel']; ?>"></td>
</tr>

<tr>
<td>QQ</td>
<td>
<input name="qq" type="text" id="qq" value="<? echo $row_settings['qq']; ?>"></td>
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

include 'includes/footer.php';?>



