<?php
include '../dbc.php';
admin_page_protect();
include '../includes/head.php';
include '../includes/sidebar.php';




$current_date = date("Y-m-d");
$first_date = date("Y-m-01",strtotime($current_date));
$last_date = date("Y-m-t",strtotime($current_date));

$begin_time = mktime(0,0,0,5,1,2014);
$begin_date = date("Y-m-d",$begin_time);


function getMonthData($begin_date,$current_first_date)
{
	$table_array = array();
	$sql = "select count(*) as count from accounts where available=1";

	$begin_datetime = new DateTime($begin_date);

	while ($begin_date < $current_first_date) {
		$last_month_end = $begin_datetime->format('Y-m-t');
		$begin_datetime->modify('+1 month');
		$begin_date = $begin_datetime->format('Y-m-d');

		$month_start = $begin_datetime->format('Y-m-01');
		$month_end = $begin_datetime->format('Y-m-t');

		$sql_all = $sql . " and end_date >='$month_end'";
		$sql_new = $sql . " and start_date between '$month_start' and '$month_end'";
		$sql_expire = $sql . " and end_date = '$last_month_end'";

		$all = mysql_query($sql_all) or die("all");

		$new = mysql_query($sql_new) or die("new ");
		$expire = mysql_query($sql_expire) or die("expire");

		$all_account = mysql_fetch_array($all);
		$new_account = mysql_fetch_array($new);
		$expire_account = mysql_fetch_array($expire);


		$row_array = array(
				'month' => $begin_datetime->format('Y-m'), 
				'last_month_end'=>$last_month_end,
				'start_date' => $month_start, 
				'end_date' => $month_end,
				'all' => $all_account['count'],
				'new' => $new_account['count'],
				'expire' => $expire_account['count']
			);
		array_push($table_array, $row_array);
	}

	return array_reverse($table_array);
}

// $table_array = getMonthData($begin_date,$first_date);
$table_array = getMonthData($begin_date,'2015-04-01');

?>


        
<div class="main">

	<h3 class="title">
		每月数据
	</h3>

	<table id="statistics-table">
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
			foreach ($table_array as $key => $row) {
				?>
				<tr data-id="<?php echo $row['start_date']; ?>">
					<td>
						<?php echo $row['month']; ?>
					</td>
					<td data-type="1">
						<a href=""><?php echo $row['expire']; ?></a>
					</td>

					<td date-type="2">
						<a href="">
							<?php echo $row['new']; ?>
						</a>
					</td>

					<td data-type="3">
						<a href="">
							<?php echo $row['all']; ?>
						</a>
					</td>
				</tr>

		<?php
			}
		 ?>
	</table>

	<br>

	 <div class="">
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
	  
	</div>
 
</div>

<?php 
// $footer_scripts = array("assets/lib/jquery-ui.min.js");
$footer_scripts = array("assets/lib/jquery.tmpl.min.js","assets/js/details.js");

include '../includes/footer.php'  
?>
