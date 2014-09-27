<?php
include '../dbc.php';
admin_page_protect();

$page_title = "数据检查";
include '../includes/head.php';

$err = array();
$msg = array();

foreach ($_POST as $key => $value) {
	$data[$key] = filter($value);// post variables are filtered
}

$sql_used = "select net_id from accounts WHERE available=1 and used=1";

$sql_accounts = "select net_id from accounts where available=1 and end_date >='2014-09-30'";
$query_used   = mysql_query($sql_accounts);
while ($row = mysql_fetch_array($query_used)) {
	echo $row['net_id'];
	echo "<br>";
}

include '../includes/footer.php';
?>


