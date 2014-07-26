<?php
include '../dbc.php';
admin_page_protect();
include '../includes/head.php';
include '../includes/sidebar.php';

$sql_all_count = "select count(*) as count from students where net_id !='' and net_pwd !=''";
$rows = mysql_query($sql_all_count) or die("获取使用网络学生总数失败");
$all_count = mysql_fetch_array($rows);


$current_date = date("Y-m-d");
$first_date = date("Y-m-01",strtotime($current_date));
$last_date = date("Y-m-t",strtotime($current_date));


$current_month_count = $sql_all_count . " and expire_date > $last_date";
$current_month_rows = mysql_query($current_month_count) or die("获取本月使用网络学生总数失败");
$current_count = mysql_fetch_array($current_month_rows);


?>


        
<div class="main">
<h3 class="title">
	统计
</h3>

<table>
	<tr>
		<td width="220">网络用户总数</td>
		<td>
			<?php echo $all_count['count']; ?>
		</td>
	</tr>
	<tr>
		<td>本月需向电信支付人月数</td>
		<td>
			<?php echo $current_count['count']; ?>
		</td>
	</tr>
	<tr>
		<td>预计下月需向电信支付人月数</td>
		<td></td>
	</tr>
</table>


<h3 class="title">
	按时间跨度查询
</h3>

<div>
<form action="statistics.php" method="post" id="state-form">
	<label>开始时间：</label> <input type="text" value="" class="input-start-date form-control required" />
	<label>截止时间：</label> <input type="text" value="" class="input-end-date form-control required" />
	<input type="submit" class="btn btn-danger" value="查询" />
</form>
	
</div>




 
</div>

<?php 
$footer_scripts = array("assets/lib/jquery-ui.min.js","assets/js/settings.js");
include '../includes/footer.php'  
?>
