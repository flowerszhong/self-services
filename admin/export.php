<?php
include '../dbc.php';
require_once 'array-to-excel.php'; 
   
admin_page_protect();


if ($_POST['export'] == 'students') {
    // 在使用的时候,调用getExcel方法，并传入相应的参数即可,例如：

	$sql_select_all = "select * from students";

	$result = mysql_query($sql_select_all) or die("sql 2013 error");
	$rows = array();
	while ($row = mysql_fetch_array($result)) {
		$rows[] = $row;
	}

	$current_date = date("Ymd");
	$filename = '学生上网表'.$current_date . '.xls';

    $excel = new ChangeArrayToExcel('download/'.$filename);
   
    $enTable = array('student_id','user_name','user_email','tel','net_id','net_pwd','expire_date','grade','department','major','sub_major','class');
    $cnTable = array('学号','姓名','邮箱','电话','上网账号','上网密码','过期时间','年级','系','专业','专业方向','班级');
    $excel-> getExcel($rows,$cnTable,$enTable,'other',20);

    $response_data = array(
    	'state' => "ok", 
    	'xls_name' => SITE_ROOT . "/admin/download/" .$filename
    	);

    echo json_encode($response_data);
    exit();
}



if ($_POST['export'] == 'accounts') {
    // 在使用的时候,调用getExcel方法，并传入相应的参数即可,例如：

	$sql_select_all = "select * from accounts";

	$result = mysql_query($sql_select_all) or die("获取上网账号表失败");
	$rows = array();
	while ($row = mysql_fetch_array($result)) {
		$rows[] = $row;
	}

	$current_date = date("Ymd");
	$filename = '上网账号表'.$current_date . '.xls';

    $excel = new ChangeArrayToExcel('download/'.$filename);
   
    $enTable = array('net_id','net_pwd','used','import_date');
    $cnTable = array('账号','密码','是否被使用','入库时间');
    $excel-> getExcel($rows,$cnTable,$enTable,'other',20);

    $response_data = array(
    	'state' => "ok", 
    	'xls_name' => SITE_ROOT . "/admin/download/" .$filename
    	);


    echo json_encode($response_data);
    exit();
}


$page_title = "数据备份";
include '../includes/head.php';
include '../includes/sidebar.php';
?>

<div class="main">
	<h3 class="title">
		导出学生网费信息表
	</h3>
	<form method="post" action="export.php">
		<input type="button" name="export" value="导出" id="export-students" class="btn btn-danger" />
	</form>

  <br />
	<h3 class="title">
		备份上网账号表
	</h3>
	<form method="post" action="export.php">
		<input type="button" name="export" value="导出" id="export-accounts" class="btn btn-danger" />
	</form>


</div>


 <?php

$footer_scripts = array("assets/js/export.js");

include '../includes/footer.php';
?>