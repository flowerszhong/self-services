<?php
include '../dbc.php';
admin_page_protect();
header("content-type:text/html;charset=utf-8");

foreach ($_GET as $key => $value) {
	$data[$key] = filter($value);//get variables are filtered.
}
$sha1pass = PwdHash('123456');

$student_id = $data['student_id'];

$sql_update = "update students set pwd='$sha1pass' where student_id=$student_id";

$query = mysql_query($sql_update) or die("重置学生密码失败");

$updated = mysql_affected_rows();

if ($query) {
	$output = array(
		"state"   => "ok",
		"updated" => $updated,
	);
} else {
	$output = array(
		"state"   => "fail",
		"updated" => $updated,
	);
}

echo json_encode($output);
?>

