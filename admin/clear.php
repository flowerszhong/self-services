<?php
include '../dbc.php';
admin_page_protect();

$err = array();
$msg = array();

foreach ($_POST as $key => $value) {
	$data[$key] = filter($value);//get variables are filtered.
}

if (isset($_POST['clear'])) {
	$last_month_end = date("Y-m-d", mktime(0, 0, 0, date('m'), 0, date('Y')));
	$sql_update = "update accounts set available=0 where
						available=1 and
						end_date is not null and
						end_date<='$last_month_end'";
	echo $sql_update;
	// $query = mysql_query($sql_update) or die("清理过期上网账号信息失败");

	// $updated = mysql_affected_rows();
}

$page_title = "清理旧数据";

include '../includes/head.php';
include '../includes/errors.php';
include '../includes/sidebar.php';

?>
<div class="main">
<h3 class="title">清理数据</h3>
<form class="form-clear" action="clear.php" method="post" id="clear-form">
	<input type="submit" value="清理过期上网账号信息" name="clear" class="btn btn-success" />
<?php
if (isset($updated)) {
	echo "清理过期上网账号信息" . $updated . "条";
}
?>
</form>

</div>


<?php

include '../includes/footer.php'

?>



