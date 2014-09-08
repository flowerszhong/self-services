<?php
include 'dbc.php';
session_start();
include 'register-util.php';
$page_title = "注册账号";
include 'includes/head.php';
include 'includes/errors.php';
?>
<div class="container">
<form action="register.php" method="post" name="regForm" id="regForm">
<table>

<tr>
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
<td>
    <b class="required"> * </b>
    密码
</td>
<td>
    <input name="pwd" type="password" class="required password" minlength="6" maxlength="16" id="pwd">
    <b class="hint">(密码不小于6位字母数字)</b>
</td>
</tr>
<tr>
<td>
    <b class="required"> * </b>
    密码确认
</td>
<td>
    <input name="pwd2"  id="pwd2" class="required password" type="password" minlength="6" equalto="#pwd"></td>
</tr>
<tr>
<td colspan="2">&nbsp;</td>
</tr>


<tr>
<td>
    电话
</td>
<td>
    <input name="tel" type="text" id="tel" maxlength="14"></td>
</tr>
<tr>
<td>
    QQ
</td>
<td>
    <input name="qq" type="text" id="qq" maxlength="12"></td>
</tr>
<tr>
<td>
    <b class="required"> * </b>
    年级
</td>
<td>
    <select name="grade" id="reg-grade">
        <option value="2013">2013</option>
        <option value="2014" selected>2014</option>
    </select>
</td>
</tr>


<tr class="net-row">
<td></td>
<td>
    <div class="alert" id="net-id-hint">
        请填写你的上网账号
    </div>
</td>
</tr>

<tr class="net-row">
<td>上网账号</td>
<td>
    fsVPDNhb<input type="text" name="net_id" id="net-id-input" value="">@fsnhedu.v.gd
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
    <button name="doRegister" type="submit" id="doRegister" class="btn btn-success" value="Register">
        注册
    </button>
</td>
</tr>

</table>
</form>
</div>


<?php

include 'includes/footer.php'

?>



