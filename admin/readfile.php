<?php
header("content-type:text/html;charset=utf-8");

include '../dbc.php';
admin_page_protect();

ini_set('max_execution_time', 1000);

// 1,何寿鸿,18144773115,物理污染监测技术,13级,1班,fsVPDNhb001636@fsnhedu.v.gd,77654579,300,20131001,20140930

$file = fopen("data-ok.csv", "r") or exit("Unable to open file!");
while (!feof($file)) {

	$rowdata   = explode(",", fgets($file));
	$tel       = $rowdata[2];
	$user_name = $rowdata[1];
	$major     = $rowdata[3];

	$net_id  = $rowdata[6];
	$net_pwd = $rowdata[7];

	$fee = $rowdata[8];

	$last_pay_date = $rowdata[9];
	$expire_date   = trim($rowdata[10]);
	// echo $expire_date;
	// echo "<br>";

	$import_date = date('Y-m-d');

	$grade = 2013;

	mysql_query("START TRANSACTION");

	$sql = "INSERT INTO students2013 (name, tel,grade,major,net_id,net_pwd,fee,pay_date,expire_date) VALUES
  	('$user_name','$tel','$grade','$major','$net_id','$net_pwd','$fee','$last_pay_date','$expire_date')";

	$insert2013 = mysql_query($sql) or die(mysql_error());

	$sql_accounts = "INSERT INTO accounts (net_id,net_pwd,import_date,start_date,end_date,used,grade) VALUES
    ('$net_id','$net_pwd','$import_date','$last_pay_date','$expire_date',1,$grade)";

	$insert_accounts = mysql_query($sql_accounts) or die(mysql_error());

	if ($insert2013 and $insert_accounts) {
		echo $sql;
		mysql_query("COMMIT");
	} else {
		mysql_query("ROLLBACK");
	}

}
fclose($file);

?>
