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



function addAccount($net_id,$net_pwd,$err)
{
	$sql_check_exist = "select count(id) as count from accounts where net_id='$net_id'";
	$check_query = mysql_query($sql_check_exist);
	$check_result = mysql_fetch_array($check_query);
	if($check_result['count'] > 0){
		$err[] = "该账号已经存在于数据中，请不在重复添加";
	}else{
		$current_date = date("Y-m-d");
		$sql_insert = "insert into `accounts` (`net_id`,`net_pwd`,`used`,`import_date`) VALUES ('$net_id','$net_pwd','0','$current_date')";
		mysql_query($sql_insert) or die(mysql_error());
	}
}

function associateNetAccount($student_id,$fee)
{
	global $report;
	$student_data = getStudentData($student_id);
	var_dump($student_data);

	if($student_data && $student_data['student_id'] == $student_id){
		$current_date = date("Y-m-d");
		$time_now = time();
		// $months = $fee/30;
		$months = 5;

		$expire_date = $student_data['expire_date'];
		if($expire_date){
			$time_expire_date = strtotime($expire_date);
			if($time_now > $time_expire_date){
				$start_date = $current_date;
			}else{
				$start_date = date('Y-m-d',mktime(0,0,0,
						date('m',$time_expire_date) +1,
						1,
						date('Y',$time_expire_date)
					));
				$end_date = date('Y-m-d',mktime(0,0,0,
						date('m',$time_expire_date) + $months,
						0,
						date('Y')
					));
			}

		}else{
			$start_date = date('Y-m-d');
			$end_date = date('Y-m-d',mktime(0,0,0,
					date('m') + $months,
					0,
					date('Y')
				));
		}


		 mysql_query("START TRANSACTION");

		if(empty($student_data['net_id'])){
			//分配账号
			$sql_select_account = "select * from accounts where used=0 limit 1";
			$query_account = mysql_query($sql_select_account);
			$row_account = mysql_fetch_array($query_account);
			var_dump($row_account);

			$sql_update_account = "update accounts set used=1 where id=$row_account[id]";
			echo $sql_update_account;
			$bool_update_account = mysql_query($sql_update_account);


			$sql_update_student = "update students set net_id='$row_account[net_id]',net_pwd='$row_account[net_pwd]',expire_date='$end_date' where student_id=$student_id";
			echo $sql_update_student;
			$bool_update_student = mysql_query($sql_update_student);

			var_dump($bool_update_account);
			var_dump($bool_update_student);


		}else{
			$sql_update_student = "update students set net_id=$row_account[net_id],net_pwd=$row_account[net_pwd],expire_date=$end_date where student_id=$student_id";
			$bool_update_student = mysql_query($sql_update_student);
			$bool_update_account = true;

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
            $report['state'] = "ok";
            echo "ok";
        }else{
            mysql_query("ROLLBACK");
            $report['state'] = "fail";
            echo "fail";
        }
	}else{
		echo "error";
	}
	
}

function getStudentData($student_id)
{
	$sql_select = "select id,student_id,user_name,net_id,net_pwd,expire_date from students where student_id=$student_id";
	// echo $sql_select;
	$query = mysql_query($sql_select) or die("获取学生数据失败");
	$num = mysql_num_rows($query);
	if($num == 1){
		return mysql_fetch_array($query);
	}else{
		// echo "未找到学号为 $student_id 的学生数据,请检查该数据";
		// die();
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
	if (($filetype == "application/xls")|| ($filetype == "application/octet-stream") ||($filetype == "application/vnd.ms-excel")) {
	    if ($_FILES["file"]["error"] > 0) {
	        echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
	    } else {

	        // if (file_exists("upload/" . $_FILES["file"]["name"])) {
	        //     echo $_FILES["file"]["name"] . " already exists. ";
	        // } else {
	            // move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $_FILES["file"]["name"]);
	            // echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
	        // }

	         $filename =iconv('UTF-8', 'GB2312', $_FILES["file"]["name"]);
	         // $filename = $_FILES["file"]["name"];
	         if(move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $filename)){
     	    		require_once dirname(__FILE__) . '/PHPExcel/Classes/PHPExcel/IOFactory.php';
     		        $reader = PHPExcel_IOFactory::createReader('Excel5'); //设置以Excel5格式(Excel97-2003工作簿)
     		        $PHPExcel = $reader->load("upload/" . $filename); // 载入excel文件
     		        $sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
     		        $highestRow = $sheet->getHighestRow(); // 取得总行数
     		        $highestColumm = "B"; // 取得总列数
     		        // $highestColumm = $sheet->getHighestColumn(); // 取得总列数

     		        /** 循环读取每个单元格的数据 */
     		        for ($row = 1; $row <= $highestRow; $row++){//行数是以第1行开始
     		        	$net_id = $sheet->getCell("A".$row)->getValue();
     		        	$net_pwd = $sheet->getCell("B".$row)->getValue();
     		        	addAccount($net_id,$net_pwd,$err);
     		            // for ($column = 'A'; $column <= $highestColumm; $column++) {//列数是以A列开始
     		            //     $dataset[] = $sheet->getCell($column.$row)->getValue();
     		            //     echo $column.$row.":".$sheet->getCell($column.$row)->getValue()."<br />";
     		            // }
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
	<label class="hint"><a href="download/班级缴费表.xls" target="_blank">样本文件下载</a></label>
	</h3>
	<div>
		<form action="billing.php" method="post" enctype="multipart/form-data">
			<input type="file" name="file" id="file" /> 
			<br />
			<input type="submit" name="import" class="btn btn-success" value="导入" />
		</form>
	</div>

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

		<!-- <tr>
		    <td>
		        <b class="required"> * </b>
		        年级
		    </td>
		    <td>
		        <select name="grade">
		            <option value="2013">2013</option>
		            <option value="2014">2014</option>
		        </select>
		    </td>
		</tr>
		<tr>
		    <td>
		        <b class="required"> * </b>
		        系别
		    </td>
		    <td>
		        <select name="department" id="department"  class="form-control required">
		          
		        </select>
		    </td>
		</tr>

		<tr>
		    <td>
		        <b class="required"> * </b>
		        专业
		    </td>
		    <td>
		        <select name="major" id="major" class="form-control required">
		            <option value="">请选择专业</option>
		        </select>
		    </td>
		</tr>

		<tr>
		    <td>专业方向</td>
		    <td>
		        <select name="sub_major" id="sub-major" class="form-control">
		            <option value="">请选择专业方向</option>
		        </select>
		    </td>
		</tr>
		<tr>
		    <td>
		        <b class="required"> * </b>
		        班级
		    </td>
		    <td>
		        <select name="class"  class="form-control required">

		            <option value="">请选择班级</option>
		            <option value="1">1班</option>
		            <option value="2">2班</option>
		            <option value="3">3班</option>
		            <option value="4">4班</option>
		            <option value="5">5班</option>
		            <option value="6">6班</option>
		            <option value="7">7班</option>
		            <option value="8">8班</option>
		            <option value="9">9班</option>
		            <option value="10">10班</option>
		        </select>
		    </td>
		</tr> -->


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



