<?php 
include '../dbc.php';
admin_page_protect();

$page_title = "按班收费";
include '../includes/head.php';
include '../includes/sidebar.php';



$err = array();
$msg = array();
$report = array();


foreach($_POST as $key => $value) {
	$data[$key] = filter($value); // post variables are filtered
}

function associateNetAccount($student_id,$fee)
{
	global $report;
	$flag = true;

	$student_data = getStudentData($student_id);
	if(!$student_data){
		add_log(false,'data_error',$student_id,"");
		return false;
	}



	if($student_data && $student_data['student_id'] == $student_id){
		
		$expire_date = $student_data['expire_date'];

		$dates = calc_start_end_date($expire_date,$fee);

		if($dates){
			$start_date = $dates['start_date'];
			$end_date = $dates['end_date'];
		}else{
			add_log(false,"duplicate",$student_id,$student_data['user_name']);
			return false;
		}
		
		mysql_query("START TRANSACTION");

		if(empty($student_data['net_id'])){
			//分配账号
			$sql_select_account = "select * from accounts where used=0 and available=1 limit 1";
			$query_account = mysql_query($sql_select_account);
			$row_account = mysql_fetch_array($query_account);
			// var_dump($row_account);

			$sql_update_account = "update accounts set used=1,start_date='$start_date',end_date='$end_date',user_id='$student_data[id]',student_id='$student_id' where id=$row_account[id]";
			// echo $sql_update_account;
			$bool_update_account = mysql_query($sql_update_account);


			$sql_update_student = "update students set net_id='$row_account[net_id]',net_pwd='$row_account[net_pwd]',expire_date='$end_date' where student_id=$student_id";
			// echo $sql_update_student;
			$bool_update_student = mysql_query($sql_update_student);

			// var_dump($bool_update_account);
			// var_dump($bool_update_student);


		}else{
			$sql_update_student = "update students set expire_date='$end_date' where student_id=$student_id";
			// echo $sql_update_student;
			$bool_update_student = mysql_query($sql_update_student);

			$sql_update_account = "update accounts set used=1,start_date='$start_date',end_date='$end_date' where net_id=$student_data[net_id]";

			$bool_update_account = mysql_query($sql_update_account);

		}

		$user_id = $student_data['id'];

		$sql_insert_consume ="INSERT into consume
                              (`user_id`,`student_id`,`fee`,`start_date`,`end_date`)
                              VALUES
                              ($user_id,'$student_id','$fee','$start_date','$end_date')
                              ";

        $bool_insert_consume = mysql_query($sql_insert_consume);


        if($sql_update_student and $bool_update_account and $bool_insert_consume){
            mysql_query("COMMIT");
			add_log($flag,"ok",$student_id,$student_data['user_name']);

        }else{
            mysql_query("ROLLBACK");
            $flag = false;

            if(!$sql_update_student){
            	$code = 'students';
            }

            if(!$bool_update_account){
            	$code = "accounts";
            }

            if(!$bool_insert_consume){
            	$code = 'consume';
            }
			add_log($flag,$code,$student_id,$student_data['user_name']);
        }
	}else{
		$flag = false;
		add_log($flag,'not_found',$student_id,"");
	}

	return $flag;
}

function calc_start_end_date($expire_date,$fee)
{
	$current_date = date("Y-m-d");
	$time_now = time();
	$months = $fee/30; 
	if($months==4||$months==5){
		$months += 1;
	}else{
		$months += 2;
	}
	$max_time = strtotime("2015-03-01");//config to global


	$start_date = "";
	$end_date = "";

	if($expire_date){
		$time_expire_date = strtotime($expire_date);
	}else{
		$time_expire_date = time(0);
	}


	if($time_expire_date > $max_time){
		return null;
	}
	if($time_now > $time_expire_date){
		$start_date = $current_date;
		if(date('d') > 20){
			$start_date = date("Y-m-d",mktime(0,0,0,
				date('m') + 1,
				1,
				date('Y')
				));
		}else{
			$start_date = date("Y-m-d",mktime(0,0,0,
				date('m'),
				0,
				date('Y')
				));
		}

		$start_date_time = strtotime($start_date);

		$end_date = $end_date = date('Y-m-d',mktime(0,0,0,
				date('m',$start_date_time) + $months,
				0,
				date('Y',$start_date_time)
			));
	}else{
		$start_date = date('Y-m-d',mktime(0,0,0,
				date('m',$time_expire_date) +1,
				1,
				date('Y',$time_expire_date)
			));
		$end_date = date('Y-m-d',mktime(0,0,0,
				date('m',$time_expire_date) + $months,
				0,
				date('Y',$time_expire_date)
			));
	}

	return array('start_date' => $start_date,
					'end_date' => $end_date
				 );
}

function add_log($ok,$code,$student_id,$user_name)
{
	$code_array = array(
		'ok'=>'添加成功',
		'duplicate'=>'已有缴费记录，请不要重复缴费',
		'students'=>'更新学生表失败',
		'accounts'=>'更新账号表失败',
		'consume'=>'更新缴费记录表失败',
		'not_found'=>'未找到该用户',
		'data_error'=>'未找到该用户',
		'unknow'=>'未知错误'
		);

	global $report;

	$ok = $ok ? "成功":"失败";

	$report[] = array(
		'ok'=>$ok,
		'cause'=>$code_array[$code],
		'id' =>$student_id,
		'name'=>$user_name
		);
}

function getStudentData($student_id)
{
	$sql_select = "select id,student_id,user_name,net_id,net_pwd,expire_date from students where student_id=$student_id";
	// echo $sql_select;
	$query = mysql_query($sql_select);
	if($query){
		$num = mysql_num_rows($query);
		if($num == 1){
			return mysql_fetch_array($query);
		}else{
			// echo "未找到学号为 $student_id 的学生数据,请检查该数据";
			// die();
		}
	}else{
		return null;
	}
	
}


if ($_POST['add'])
{
	if($data['student_id'] && $data['fee']){
		associateNetAccount($data['student_id'],$data['fee']);
	}
}

if (isset($_POST['import'])) {

    $filetype = $_FILES["file"]["type"];
    echo $filetype;
	if (($filetype == "application/xls")|| ($filetype == "application/octet-stream") 
		||($filetype == "application/vnd.ms-excel")
		||($filetype == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet")) {
	    if ($_FILES["file"]["error"] > 0) {
	        echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
	    } else {


	         $filename =iconv('UTF-8', 'GB2312', $_FILES["file"]["name"]);
	         if(move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $filename)){
     	    		require_once dirname(__FILE__) . '/PHPExcel/Classes/PHPExcel/IOFactory.php';
     		        $reader = PHPExcel_IOFactory::createReader('Excel2007'); //设置以Excel5格式(Excel97-2003工作簿)
     		        // var_dump($reader);
     		        $PHPExcel = $reader->load("upload/" . $filename); // 载入excel文件
     		        // var_dump($PHPExcel);
     		        $sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
     		        $highestRow = $sheet->getHighestRow(); // 取得总行数
     		        $highestColumm = "B"; // 取得总列数
     		        // $highestColumm = $sheet->getHighestColumn(); // 取得总列数

     		        /** 循环读取每个单元格的数据 */
     		        for ($row = 3; $row <= $highestRow; $row++){//行数是以第1行开始
     		        	$student_id = trim($sheet->getCell("A".$row)->getValue());
     		        	$user_name = trim($sheet->getCell("B".$row)->getValue());
     		        	$fee = $sheet->getCell("C".$row)->getValue();

     		        	if($student_id=="系部"){
     		        		break;
     		        	}

     		        	if($student_id == ""){
     		        		continue;
     		        	}

     		        	associateNetAccount($student_id,$fee);

     		        }
	         }else{
	         	$err[] = "错误 - 上传文件失败";
	         }

	    }
	} else {
	    echo "Invalid file";
	}

}


$sql_select_account = "select count(net_id) as count from accounts";
$sql_result = mysql_query($sql_select_account);
$all = mysql_fetch_array($sql_result);

$current_date = date("Y-m-d");
$first_date = date("Y-m-01",strtotime($current_date));

$sql_select_expire = "select net_id as count from students where expire_date<$first_date";
$sql_result1 = mysql_query($sql_select_expire);
$expire_num = mysql_num_rows($sql_result1);


include "../includes/errors.php";

 ?>

<div class="main">

	<h3 class="title">导入班级缴费表
	<label class="hint">样本文件下载 :<a href="download/班级缴费表.xlsx" target="_blank">班级缴费表.xlsx</a> ,请保持xlsx后缀格式</label>
	</h3>
	<div>
		<form action="billing.php" method="post" enctype="multipart/form-data">
			<input type="file" name="file" id="file" /> 
			<br />
			<input type="submit" name="import" class="btn btn-success" value="导入" />
		</form>
	</div>


	<?php 

		if(sizeof($report)>0){
			?>

	<h3 class="title">
		导入结果
	</h3>
	<table>
		<tr>
			<td>成功</td>
			<td>学号</td>
			<td>姓名</td>
			<td>原因</td>
		</tr>
	<?php 

	foreach ($report as $key => $log) { ?>

	<tr>
		<td>
			<?php echo $log['ok']; ?>
		</td>

		<td>
			<?php echo $log['id']; ?>
		</td>
		<td>
			<?php echo $log['name']; ?>
		</td>

		<td>
			<?php echo $log['cause']; ?>
		</td>
	</tr>


	<?php
	}

	 ?>
	</table>

		<?php 
	}
	?>


	<h3 class="title">单个学生收费录入</h3>
	<div>
		<form action="billing.php" method="post" id="add-billing-form">
		<table>
		<tr>
			<td width="160" class="th"><b class="required"> * </b>学号</td>
			<td>
				<input type="text" name="student_id" value="" class="form-control custom-input required" />
			</td>
		</tr>
		<tr>
			<td class="th">姓名</td>
			<td>
				<input type="text" name="user_name" value="" class="form-control custom-input"/>
			</td>
		</tr>
		<tr>
			<td class="th">
			 <b class="required"> * </b>
			 缴费金额</td>
			<td>
				<select name="fee" class="form-control required">
					<option name="fee" value="">请选择缴费金额</option>
					<option name="fee" value="300">300</option>
					<option name="fee" value="150">150</option>
					<option name="fee" value="120">120</option>
				</select>
			</td>
		</tr>

		<tr>
			<td></td>
			<td>
				<input type="submit" value="提交" name="add" class="btn btn-success"/>
			</td>
		</tr>
		</table>

		</form>
	</div>

</div>

 <?php 
include '../includes/footer.php';
?>



