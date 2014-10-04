<?php
header("content-type:text/html;charset=utf-8");

include '../dbc.php';
admin_page_protect();

ini_set('max_execution_time', 1000);

// 1,何寿鸿,18144773115,物理污染监测技术,13级,1班,fsVPDNhb001636@fsnhedu.v.gd,77654579,300,20131001,20140930

function getDepartment($major, $sub_major) {
	$departments = array(
		array("环境工程与土木工程系", "环境监测与治理技术", "城市水净化技术", "给排水工程技术", "工程测量与监理", "工程监理", "建筑工程技术", "工程造价"),
		array("环境监测系", "环境监测与评价", "食品营养与检测", "室内检测与控制技术", "工业分析与检验", "商检技术"),
		array("环境科学系", "环境监测与评价", "环境规划与管理", "工业环保与安全技术", "安全技术管理"),
		array("循环经济与低碳经济系", "资源环境与城市管理", "节能工程技术", "工业节能管理"),
		array("机电工程系", "机电设备维修与管理", "模具设计与制造", "软件测试技术", "机械制造与自动化", "电气自动化技术"),
		array("生态环境系", "城市园林", "园艺技术"),
		array("环境艺术与服务系", "环境艺术设计", "会展艺术设计", "烹饪工艺与营养"),
	);
	if ($major == "环境监测与评价") {
		if ($sub_major == "环境影响评价") {
			return "环境科学系";
		} else {
			return "环境监测系";
		}
	} else {
		foreach ($departments as $key => $d) {
			if (in_array($major, $d)) {
				return $d[0];
			}
		}
	}

}

$file = fopen("students2014.csv", "r") or exit("Unable to open file!");
while (!feof($file)) {

	$row = fgets($file);
	$rowdata = explode(",", $row);
	$grade = 2014;
	$student_id = intval($rowdata[0]);
	$user_name = $rowdata[1];
	$class = $rowdata[2];
	$class = intval(substr($class, -1));
	if ($class === 0) {
		$class = 1;
	}
	$male = $rowdata[3];
	if ($male == "女") {
		$male = 0;
	} else {
		$male = 1;
	}

	$major = $rowdata[4];

	// echo $major;
	$sub_major = $rowdata[5];
	$department = getDepartment($major, $sub_major);

	$user_email = "fake_email@gdepc.cn";
	$sha1pass = PwdHash('123456');

	$sql = "select * from students where student_id=$student_id";

	$query = mysql_query($sql);
	$row_num = mysql_num_rows($query);
	if ($row_num) {
		echo "has record";
	} else {
		$sql_insert = "INSERT INTO `students`
		(`student_id`, `user_name`, `user_email`, `pwd`,`department`, `major`, `sub_major`, `grade`, `class`,`approved`,`male`)
		VALUES
		($student_id,'$user_name','$user_email','$sha1pass','$department','$major',
			'$sub_major',$grade,$class,1,$male)";
		mysql_query($sql_insert) or die(mysql_error());
	}

}
fclose($file);

?>
