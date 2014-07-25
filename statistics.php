<?php
include 'dbc.php';
page_protect();
include 'includes/head.php';
include 'includes/sidebar.php';
?>


        
<div class="main">
<table>
	<tr>
		<td>网络用户总数</td>
	</tr>
	<tr>
		<td>本月需向电信支付人月数</td>
	</tr>
	<tr>
		<td>预计下月需向电信支付人月数</td>
	</tr>
</table>


<h3 class="title">
	按时间跨度查询
</h3>

<table>
	<tr>
		<td>start date</td>
		<td><input type="text" value="" /></td>
	</tr>
	<tr>
		<td>end date</td>
		<td><input type="text" value="" /></td>
	</tr>
</table>




 
</div>

<?php 
$footer_scripts = array("assets/js/settings.js","assets/js/main.js");
include 'includes/footer.php'  
?>
