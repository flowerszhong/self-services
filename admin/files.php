<?php 
include '../dbc.php';
admin_page_protect();

include 'uploadfiles.php';

$err = array();
$msg = array();

foreach($_POST as $key => $value) {
	$data[$key] = filter($value); // post variables are filtered
}

if (isset($_POST['upload'])) {

	$upfile = new UploadFiles(
		array('filepath'=>'./docs',
			'allowtype'=>array('pdf','xls','xlsx','doc','docx','jpg','png'),
			'israndfile'=>false,
			'maxsize'=>'10000000')
	);

	if($upfile ->uploadeFile('docs')){
		$arrfile = $upfile ->getnewFile();
		foreach($arrfile as $v){
			$msg[] = $v . '上传成功';
		}
	}else{
		$err =  $upfile ->gteerror();
	}
}


$dir = dirname(__FILE__)."/" . DOCS_DIR . "/";//
//PHP遍历文件夹下所有文件
$handle=opendir($dir.".");
//定义用于存储文件名的数组
$array_file = array();
while (false !== ($file = readdir($handle)))
{
   $encode = mb_detect_encoding($file, array("UTF-8","GB2312","GBK",'BIG5'));
   if($encode !== 'UTF-8'){
      $file = iconv('GB2312','UTF-8', $file);
   }

  if ($file != "." && $file != "..") {
    $array_file[] = $file; //输出文件名
  }
}
closedir($handle);


$page_title = "文档管理";
include '../includes/head.php';
include '../includes/sidebar.php';
include "../includes/errors.php";

 ?>

<div class="main">
	<h3 class="title">已上传文档</h3>
	<?php 
      foreach ($array_file as $key => $value) {
        ?>
      <li>
        <a target="blank" href="<?php echo SITE_ROOT . '/admin/docs/' . $value; ?>"><?php echo $value; ?></a>
        <input type="button" class='delete-doc' data-id='<?php echo $value; ?>' value="删除" />
      </li>     
    <?php
      }
    ?>

	<h3 class="title">上传文档
	<label class="hint">
		(允许上传格式有：pdf,doc,docx,xls,xlsx,所有上传文件大小之合不超过10MB)
	</label>
	</h3>
	<form name="upfile" action="files.php" method="post" id="upload-docs-form" enctype="multipart/form-data">
		<ul id="docs-list">
			<li><input type="file" name="docs[]" class="docs"/></li>
			<li><input type="file" name="docs[]" class="docs"/></li>
			<li><input type="file" name="docs[]" class="docs"/></li>
		</ul>
		
		<input type="button" class="btn btn-xs btn-info" value="添加文档" id="add-doc" /> <br>
		<input type="submit" name="upload" id="upload-docs-btn" value="提交"  class="btn btn-success" />
		<input type="reset" name="reset" value="重填" class="btn btn-danger"/>
	</form>

</div>

 <?php 
include '../includes/footer.php';
?>



