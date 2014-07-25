
<div class="footer">
	<div class="container">
		<div class="copyright">
			Copyright © 2011 - All Rights Reserved - 广东环境保护工程职业学院
		</div>
		<div class="support-by">
			技术支持: 信息中心
		</div>
	</div>

</div>
<script type="text/javascript" src="assets/lib/jquery-1.11.1.js"></script>
<script type="text/javascript" src="assets/lib/jquery.validate.js"></script>
<script type="text/javascript" src="assets/lib/jquery.validate.ext.js"></script>
<script type="text/javascript" src="assets/js/main.js"></script>
<?php 
$scripts = "";
if ($footer_scripts) {
	foreach ($footer_scripts as $key => $value) {
		$scripts = $scripts . "<script type='text/javascript' src='" . $value ."'></script>";
	}
	echo $scripts;
}
?>

</body>
</html>