<?php 
include 'dbc.php';

$dir = dirname(__FILE__)."/admin/docs/";//这里输入其它路径
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
    // $array_file[] = $file; //输出文件名
    $array_file[] = $file;
  }
}
closedir($handle);

$page_title = "使用需知";
include 'includes/head.php';
include 'includes/errors.php';
?>
<div class="container">
 
  <h3 class="title">使用需知</h3>
    <?php 
      foreach ($array_file as $key => $value) {
        ?>
      <li>
        <a href="<?php echo SITE_ROOT . '/admin/docs/' . $value; ?>"><?php echo $value; ?></a>
      </li>     
    <?php
      }
    ?>
</div>

<?php 
include 'includes/footer.php';
 ?>
