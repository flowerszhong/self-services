<?php
include 'dbc.php';
require_once 'array-to-excel.php'; 
   
page_protect();

$page_title = "数据导出";
include 'includes/head.php';
include 'includes/sidebar.php';

if (isset($_POST['export1'])) {
    // 在使用的时候,调用getExcel方法，并传入相应的参数即可,例如：

	$sql_old = "select * from students2013 limit 100";

	$result = mysql_query($sql_old) or die("sql 2013 error");
	$rows = array();
	while ($row = mysql_fetch_array($result)) {
		$rows[] = $row;
	}
    $excel = new ChangeArrayToExcel('ex222.xls');
   
    $enTable = array('name','tel','major','grade','class');
    $cnTable=array('名字','电话号码','专业','年级','班级');
    $excel-> getExcel($rows,$cnTable,$enTable,'other',20);
    var_dump($result);
    echo "ok";
}






?>

<div class="main">
	<h3 class="title">
		导出上网账号
	</h3>
	<form method="post" action="export.php">
		<input type="submit" name="export1" value="export" />
	</form>

	<a href="ex222.xls" id="export-link">export</a>


</div>


 <?php

$footer_scripts = array("assets/js/settings.js","assets/js/main.js");
include 'includes/footer.php';
?>