<?php
include 'dbc.php';
page_protect();

$page_title = "上网账号导入";
include 'includes/head.php';
include 'includes/sidebar.php';


if ($_POST['submit'] == 'Submit') {
    
    foreach ($_POST as $key => $value) {
        $data[$key] = filter($value); // post variables are filtered
    }

    var_dump($_FILES["file"]["type"]);

    echo $_FILES['uploaded_file']['type']."<br>"; 

    $filetype = $_FILES["file"]["type"];

	if (($filetype == "application/xls")|| ($filetype == "application/octet-stream")) {
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


    		require_once dirname(__FILE__) . '/PHPExcel/Classes/PHPExcel/IOFactory.php';

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
	    }
	} else {
	    echo "Invalid file";
	}

}

?>

<div class="main">
	<form action="import.php" method="post"
	enctype="multipart/form-data">
	<label for="file">Filename:</label>
	<input type="file" name="file" id="file" /> 
	<br />
	<input type="submit" name="submit" value="Submit" />
	</form>
</div>

 <?php

$footer_scripts = array("assets/js/settings.js","assets/js/main.js");

include 'includes/footer.php';
?>