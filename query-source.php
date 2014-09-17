<?php
include 'dbc.php';

foreach ($_GET as $key => $value) {
	$get[$key] = filter($value);
}

if ($get['cmd'] == 'source') {
	$name               = $get['name'];
	$sql_select_by_name = "select net_id from students2013 where name='$name'";
	$result             = mysql_query($sql_select_by_name) or die(mysql_error());
	$num                = mysql_num_rows($result);
	if ($num > 0) {
		$nets = array();
		// echo json_encode(mysql_fetch_object($result));
		while ($net = mysql_fetch_array($result)) {
			$nets[] = $net['net_id'];
		}
		// var_dump($nets);
		echo json_encode($nets);

	} else {
		return 0;
	}

}

?>