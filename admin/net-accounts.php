<?php 
include '../dbc.php';
admin_page_protect();

$page_title = "数据导出";
include '../includes/head.php';
include '../includes/sidebar.php';


$err = array();

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


if ($_POST['submit'] == 'Submit') {
    
    foreach ($_POST as $key => $value) {
        $data[$key] = filter($value); // post variables are filtered
    }

    require_once dirname(__FILE__) . '/PHPExcel/Classes/PHPExcel/IOFactory.php';


    if ($_FILES["file"]["error"] > 0) {
        echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
    } else {
        echo "Upload: " . $_FILES["file"]["name"] . "<br />";
        echo "Type: " . $_FILES["file"]["type"] . "<br />";
        echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
        echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
        
        // if (file_exists("upload/" . $_FILES["file"]["name"])) {
        //     echo $_FILES["file"]["name"] . " already exists. ";
        // } else {
            move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $_FILES["file"]["name"]);
            echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
        // }
    }

    $reader = PHPExcel_IOFactory::createReader('Excel5'); //设置以Excel5格式(Excel97-2003工作簿)
    $PHPExcel = $reader->load("upload/" . $_FILES['file']["name"]); // 载入excel文件
    $sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
    sleep(2);
    $highestRow = $sheet->getHighestRow(); // 取得总行数
    $highestColumm = $sheet->getHighestColumn(); // 取得总列数

    var_dump($highestColumm);
     
    /** 循环读取每个单元格的数据 */
    for ($row = 1; $row <= $highestRow; $row++){//行数是以第1行开始
        for ($column = 'A'; $column <= $highestColumm; $column++) {//列数是以A列开始
            $dataset[] = $sheet->getCell($column.$row)->getValue();
            echo $column.$row.":".$sheet->getCell($column.$row)->getValue()."<br />";
        }
    }



	// if ((($_FILES["file"]["type"] == "image/gif") || ($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/pjpeg"))) {
	//     if ($_FILES["file"]["error"] > 0) {
	//         echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
	//     } else {
	//         echo "Upload: " . $_FILES["file"]["name"] . "<br />";
	//         echo "Type: " . $_FILES["file"]["type"] . "<br />";
	//         echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
	//         echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
	        
	//         if (file_exists("upload/" . $_FILES["file"]["name"])) {
	//             echo $_FILES["file"]["name"] . " already exists. ";
	//         } else {
	//             move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $_FILES["file"]["name"]);
	//             echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
	//         }
	//     }
	// } else {
	//     echo "Invalid file";
	// }

}




 ?>

<div class="main">
	<h3 class="title">统计</h3>
	<table>
		<tr>
			<td>可用上网账号总数</td>
		</tr>
		<tr>
			<td>本月将过期账号总数</td>
			<td>下载过期账号数据</td>
		</tr>
	</table>

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


	<h3 class="title">导入上网账号</h3>
	<div>
		<form action="net-accounts.php" method="post" enctype="multipart/form-data">
			<label for="file">Filename:</label>
			<input type="file" name="file" id="file" /> 
			<br />
			<input type="submit" name="submit" value="Submit" />
		</form>
	</div>


	<h3 class="title">导出上网账号表</h3>
	<input type="button" value="export" id="export" />
	

</div>

 <?php 
$footer_scripts = array("assets/js/settings.js","assets/js/register.js","assets/js/main.js");
include '../includes/footer.php';
?>



