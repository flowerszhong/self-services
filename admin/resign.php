<?php
include '../dbc.php';
admin_page_protect();

// filter POST values
foreach ($_POST as $key => $value) {
	$data[$key] = filter($value);
}

foreach ($_GET as $key => $value) {
	$data[$key] = filter($value);
}

$old_net_id = $data['net_id'];

$sql_old   = "select * from accounts where net_id='$old_net_id'";
$old_query = mysql_query($sql_old) or die("get old data error " . mysql_error());
$old       = mysql_fetch_array($old_query);

$sql_new   = "select * from accounts where available=1 and used=0 limit 1";
$new_query = mysql_query($sql_new) or die("get new account fail" . mysql_error());
$new       = mysql_fetch_array($new_query);

$new_id  = $new['net_id'];
$new_pwd = $new['net_pwd'];

$student_id = $old['student_id'];
$user_id    = $old['user_id'];

mysql_query("START TRANSACTION");

$sql_update_old = "update accounts set available=0 where net_id='$old_net_id'";
$update_old     = mysql_query($sql_update_old) or die("update old accounts fail ... " . mysql_error());

$sql_update_new = "update accounts set
					user_id=$user_id,
					student_id=$student_id,
					grade=$old[grade],
					import_date='$old[import_date]',
					used=1,
					start_date='$old[start_date]',
					end_date='$old[end_date]' where net_id='$new_id'";
$update_new = mysql_query($sql_update_new) or die("update new accounts fail ... " . mysql_error());

$sql_update_student = "update students set
						net_id='$new_id',
						net_pwd='$new_pwd' where student_id=$student_id";

$update_student = mysql_query($sql_update_student) or die("update students fail ..." . mysql_error());

if ($update_new and $update_old and $update_student) {
	mysql_query("COMMIT");
	$output = array(
		"state"   => "ok",
		"net_id"  => $new_id,
		"net_pwd" => $new_pwd,
	);
} else {
	mysql_query("ROLLBACK");
	$output = array(
		"state"   => "error",
		"old"     => $update_old,
		"new"     => $update_new,
		"student" => $update_student,
	);
}

echo json_encode($output);

exit();

?>




