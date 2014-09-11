<?php
include '../dbc.php';
admin_page_protect();

// filter POST values
foreach ($_GET as $key => $value) {
	$data[$key] = filter($value);
}

if (isset($_GET['id'])) {
	$user_id = $data['id'];
	$sql     = "select start_date,end_date,fee,pay_date from consume where user_id=$user_id";
	// echo $sql;
	$query = mysql_query($sql) or die("get consume fail");

	$rrows = array();
	while ($row = mysql_fetch_object($query)) {
		$rrows[] = $row;
	}
	$output = array(
		"state"   => "ok",
		'consume' => $rrows,
	);
} else {
	$output = array(
		"state" => "fail",
	);
}

echo json_encode($output);

exit();

?>




