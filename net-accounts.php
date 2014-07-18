<?php 
include 'dbc.php';
page_protect();

$page_title = "数据导出";
include 'includes/head.php';
include 'includes/sidebar.php';

if ($_POST['add'])
{

	foreach($_POST as $key => $value) {
		$data[$key] = filter($value); // post variables are filtered
	}

	if($data['account_id'] && $data['account_pwd']){
		$sql_insert = "insert into `accounts` (`net_id`,`net_pwd`,`used`) VALUES ('$data[account_id]','$data[account_pwd]','0')";
		mysql_query($sql_insert) or die(mysql_error());
	}
}




 ?>

<div class="main">
	<table>
	<tr>
		<td>上网账号</td>
		<td>上网密码</td>
		<td>是否关联</td>
	</tr>		
	<?php 

		$sql_select = "select * from `accounts` ORDER BY id DESC limit 50";
		$rows_result = mysql_query($sql_select) or die(mysql_error());
	?>

		<?php while($rrow = mysql_fetch_array($rows_result)){?>
			<tr>
				<td>
					<?php echo $rrow['net_id']; ?>
				</td>

				<td>
					<?php echo $rrow['net_pwd']; ?>
				</td>
				<td>
					<?php if($rrow['used']){echo "已关联";}else{
						echo "未关联";
						} ?>
				</td>
			</tr>


		<?php } ?>

	</table>


	<h3 class="title">添加账号</h3>
	<div>
		<form action="net-accounts.php" method="post">
		<table>
		<tr>
			<td>账号</td>
			<td>
				<input type="text" name="account_id" value=""/>

			</td>
		</tr>
		<tr>
			<td>密码</td>
			<td>
				<input type="text" name="account_pwd" value=""/>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="submit" value="提交" name="add"/>
			</td>
		</tr>
		</table>

		</form>
	</div>

</div>

 <?php 
$footer_scripts = array("assets/js/settings.js","assets/js/register.js","assets/js/main.js");
include 'includes/footer.php';
?>



