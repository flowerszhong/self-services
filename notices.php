<?php 
include 'dbc.php';

$dir = dirname(__FILE__)."/admin/docs/";//这里输入其它路径
//PHP遍历文件夹下所有文件
$handle=opendir($dir.".");
//定义用于存储文件名的数组
$array_file = array();
while (false !== ($file = readdir($handle)))
{
  if ($file != "." && $file != "..") {
    $array_file[] = $file; //输出文件名
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
