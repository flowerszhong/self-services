
<div class="footer">
	<div class="container">
		<div class="copyright">
			Copyright © 2011 - All Rights Reserved - 广东环境保护工程职业学院
		</div>
		<div class="support-by">
			技术支持: 信息中心
		</div>

	</div>
	<div class="container">
		<a style="clear:both;float:left;color:#333;" href="<?php echo SITE_ROOT?>/admin/index.php">管理员入口</a>
	</div>

</div>
<script type="text/javascript" src="<?php echo SITE_ROOT?>/assets/lib/jquery-1.11.1.js" ></script>
<script type="text/javascript" src="<?php echo SITE_ROOT?>/assets/lib/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo SITE_ROOT?>/assets/lib/jquery.validate.ext.js"></script>
<script type="text/javascript" src="<?php echo SITE_ROOT?>/assets/js/main.js?timestamp=<?php echo time()?>"></script>
<?php
$scripts = "";
if ($footer_scripts) {
	foreach ($footer_scripts as $key => $value) {
		$scripts = $scripts . "<script type='text/javascript' src='" . SITE_ROOT . "/" . $value . "'></script>";
	}
	echo $scripts;
}
?>





<script type="text/javascript">
var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F3f1deb8fdfc6c4316f49b667edb62aac' type='text/javascript'%3E%3C/script%3E"));
</script>


</body>
</html>