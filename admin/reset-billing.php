<?php
include '../dbc.php';
admin_page_protect();

$err = array();
$msg = array();

foreach ($_POST as $key => $value) {
	$data[$key] = filter($value);//get variables are filtered.
}

if (isset($_POST['tj'])) {
	$sql = "select * from students where pay_date is not null and grade=2014 and net_id=''";
	$query = mysql_query($sql);
	$number = mysql_num_rows($query);

}

if (isset($_POST['reset-biling'])) {

	$sql_update = "update students set
		start_date=null,
		expire_date=null,
		pay_date=null
		where
		pay_date is not null and
		grade=2014 and
		net_id=''
	";

	$query_update = mysql_query($sql_update) or die("update error");

	$updated = mysql_affected_rows();
}

$page_title = "恢复分配账号成功但却没有拿到账号的14级同学";

include '../includes/head.php';
include '../includes/errors.php';
include '../includes/sidebar.php';

?>
<div class="main">
<h3 class="title">统计分配账号成功但却没有拿到账号的14级同学数</h3>
<form class="form-clear" action="reset-billing.php" method="post" id="clear-form">
	<input type="submit" value="统计" name="tj" class="btn btn-success" />
<?php
if (isset($number)) {
	echo "恢复分配账号成功但却没有拿到账号的14级同学:" . $number . "条";
	echo "<br>";
}

?>
</form>


<h3 class="title">恢复</h3>
<form class="form-clear" action="reset-billing.php" method="post" id="clear-form">
	<input type="submit" value="恢复" name="reset-biling" class="btn btn-success" />
<?php

if (isset($updated)) {
	echo "恢复分配账号成功但却没有拿到账号的14级同学:" . $updated . "条";
}
?>
</form>
</div>


<?php

include '../includes/footer.php'

?>



