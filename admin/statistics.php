<?php
include '../dbc.php';
admin_page_protect();
include '../includes/head.php';
include '../includes/sidebar.php';

$current_date = date("Y-m-d");
$first_date   = date("Y-m-01", strtotime($current_date));
$last_date    = date("Y-m-t", strtotime($current_date));

$begin_time = mktime(0, 0, 0, 7, 1, 2014);
$begin_date = date("Y-m-d", $begin_time);

function getMonthData($begin_date, $current_first_date) {
	$table_array    = array();
	$table_array_13 = array();
	$table_array_14 = array();
	$sql            = "select count(*) as count from accounts where available=1";

	$begin_datetime = new DateTime($begin_date);

	while ($begin_date < $current_first_date) {
		$last_month_end = $begin_datetime->format('Y-m-t');
		$begin_datetime->modify('+1 month');
		$begin_date = $begin_datetime->format('Y-m-d');

		$month_start = $begin_datetime->format('Y-m-01');
		$month_end   = $begin_datetime->format('Y-m-t');

		$sql_all    = $sql . " and end_date >='$month_end'";
		$sql_new    = $sql . " and start_date between '$month_start' and '$month_end'";
		$sql_expire = $sql . " and end_date = '$last_month_end'";

		$grade_condition_13 = " and grade=2013";
		$grade_condition_14 = " and grade=2014";

		$sql_all_13 = $sql_all . $grade_condition_13;
		$sql_all_14 = $sql_all . $grade_condition_14;

		$sql_new_13 = $sql_new . $grade_condition_13;
		$sql_new_14 = $sql_new . $grade_condition_14;

		$sql_expire_13 = $sql_expire . $grade_condition_13;
		$sql_expire_14 = $sql_expire . $grade_condition_14;

		$all    = mysql_query($sql_all) or die("all");
		$all_13 = mysql_query($sql_all_13) or die("all");
		$all_14 = mysql_query($sql_all_14) or die("all");

		$new    = mysql_query($sql_new) or die("new ");
		$new_13 = mysql_query($sql_new_13) or die("new ");
		$new_14 = mysql_query($sql_new_14) or die("new ");

		$expire    = mysql_query($sql_expire) or die("expire");
		$expire_13 = mysql_query($sql_expire_13) or die("expire");
		$expire_14 = mysql_query($sql_expire_14) or die("expire");

		$all_account    = mysql_fetch_array($all);
		$all_account_13 = mysql_fetch_array($all_13);
		$all_account_14 = mysql_fetch_array($all_14);

		$new_account    = mysql_fetch_array($new);
		$new_account_13 = mysql_fetch_array($new_13);
		$new_account_14 = mysql_fetch_array($new_14);

		$expire_account    = mysql_fetch_array($expire);
		$expire_account_13 = mysql_fetch_array($expire_13);
		$expire_account_14 = mysql_fetch_array($expire_14);

		$row_array = array(
			'month'          => $begin_datetime->format('Y-m'),
			'last_month_end' => $last_month_end,
			'start_date'     => $month_start,
			'end_date'       => $month_end,
			'all'            => $all_account['count'],
			'all_13'         => $all_account_13['count'],
			'all_14'         => $all_account_14['count'],
			'new'            => $new_account['count'],
			'new_13'         => $new_account_13['count'],
			'new_14'         => $new_account_14['count'],
			'expire'         => $expire_account['count'],
			'expire_13'      => $expire_account_13['count'],
			'expire_14'      => $expire_account_14['count'],
		);

		$row_array_13 = array(
			'month'          => $begin_datetime->format('Y-m'),
			'last_month_end' => $last_month_end,
			'start_date'     => $month_start,
			'end_date'       => $month_end,
			'all_13'         => $all_account_13['count'],
			'new_13'         => $new_account_13['count'],
			'expire_13'      => $expire_account_13['count'],
		);

		$row_array_14 = array(
			'month'          => $begin_datetime->format('Y-m'),
			'last_month_end' => $last_month_end,
			'start_date'     => $month_start,
			'end_date'       => $month_end,
			'all_14'         => $all_account_14['count'],
			'new_14'         => $new_account_14['count'],
			'expire_14'      => $expire_account_14['count'],
		);

		array_push($table_array, $row_array);
		array_push($table_array_13, $row_array_13);
		array_push($table_array_14, $row_array_14);
	}

	$array_wrap = array(
		'table_array'    => array_reverse($table_array),
		'table_array_13' => array_reverse($table_array_13),
		'table_array_14' => array_reverse($table_array_14),

	);

	return $array_wrap;
}

// $table_array = getMonthData($begin_date,$first_date);
$array_wrap = getMonthData($begin_date, '2015-04-01');

?>
<div class="main">

<h3 class="title">
每月数据
</h3>

<table class="statistics-table">
<tr>
<td>年-月</td>
<td colspan="3">
本月过期账号数
</td>
<td colspan="3">
本月新增账号数
</td>
<td colspan="3">
本月需要缴费账号数
</td>
</tr>

<tr>
<td></td>
<td>
2013
</td>
<td>2014</td>
<td>13/14总计</td>

<td>
2013
</td>

<td>2014</td>
<td>13/14总计</td>
<td>
2013
</td>

<td>2014</td>
<td>13/14总计</td>

</tr>
<?php
foreach ($array_wrap['table_array'] as $key => $row) {
	?>
	<tr data-id="<?php
	echo $row['start_date'];
	?>">
	<td>
	<?php
	echo $row['month'];
	?>
	</td>

	<td>
	<a data-type="1" href=""><?php
	echo $row['expire_13'];
	?></a>
	</td>

	<td>
	<a data-type="1" href=""><?php
	echo $row['expire_14'];
	?></a>
	</td>

	<td>
	<a data-type="1" href=""><?php
	echo $row['expire'];
	?></a>
	</td>

	<td>
	<a href="" date-type="2">
	<?php
	echo $row['new_13'];
	?>
	</a>
	</td>

	<td>
	<a href="" date-type="2">
	<?php
	echo $row['new_14'];
	?>
	</a>
	</td>
	<td>
	<a href="" date-type="2">
	<?php
	echo $row['new'];
	?>
	</a>
	</td>
	<td>
	<a href="" data-type="3">
	<?php
	echo $row['all_13'];
	?>
	</a>
	</td>
	<td>
	<a href="" data-type="3">
	<?php
	echo $row['all_14'];
	?>
	</a>
	</td>

	<td>
	<a href="" data-type="3">
	<?php
	echo $row['all'];
	?>
	</a>
	</td>
	</tr>

	<?php
}
?>
</table>



<h3 class="title">
2013级每月数据
</h3>

<table class="statistics-table">
<tr>
<td>年-月</td>
<td>
本月过期账号数
</td>
<td>
本月新增账号数
</td>
<td>
本月需要缴费账号数
</td>
</tr>
<?php
foreach ($array_wrap['table_array_13'] as $key => $row) {
	?>
	<tr data-id="<?php
	echo $row['start_date'];
	?>">
	<td>
	<?php
	echo $row['month'];
	?>
	</td>
	<td>
	<a data-type="1" href=""><?php
	echo $row['expire_13'];
	?></a>
	</td>

	<td>
	<a href="" date-type="2">
	<?php
	echo $row['new_13'];
	?>
	</a>
	</td>

	<td>
	<a href="" data-type="3">
	<?php
	echo $row['all_13'];
	?>
	</a>
	</td>
	</tr>

	<?php
}
?>
</table>


<h3 class="title">
2014级每月数据
</h3>

<table class="statistics-table">
<tr>
<td>年-月</td>
<td>
本月过期账号数
</td>
<td>
本月新增账号数
</td>
<td>
本月需要缴费账号数
</td>
</tr>
<?php
foreach ($array_wrap['table_array_14'] as $key => $row) {
	?>
	<tr data-id="<?php
	echo $row['start_date'];
	?>">
	<td>
	<?php
	echo $row['month'];
	?>
	</td>
	<td>
	<a data-type="1" href=""><?php
	echo $row['expire_14'];
	?></a>
	</td>

	<td>
	<a href="" date-type="2">
	<?php
	echo $row['new_14'];
	?>
	</a>
	</td>

	<td>
	<a href="" data-type="3">
	<?php
	echo $row['all_14'];
	?>
	</a>
	</td>
	</tr>

	<?php
}
?>
</table>
<br>

<!-- <div class="">
<span id="page-state">

</span>


<select id="row-limit">
<option value="10">10</option>
<option value="20">20</option>
<option value="50">50</option>
<option value="100">100</option>
</select>行/页
</div>

<table>
<thead>
<tr>
<td>ID</td>
<td>账号</td>
<td>密码</td>
<td>学号</td>
<td>开始时间</td>
<td>结束时间</td>
<td>是否可用</td>
</tr>
<tr>
</thead>

<tbody id="accounts-list">

</tbody>
</table>

<div id="page-controls">

</div> -->

</div>

<?php
// $footer_scripts = array("assets/lib/jquery-ui.min.js");
$footer_scripts = array(
	"assets/lib/jquery.tmpl.min.js",
	"assets/js/details.js",
);

include '../includes/footer.php';
?>
