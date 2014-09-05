<?php /* @var $this Controller */?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl;?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl;?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl;?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl;?>/../../assets/css/main.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl;?>/../../assets/css/btn.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl;?>/../../assets/css/table.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl;?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl;?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle);?></title>
</head>

<body>

    <div class="color-bar"></div>

    <div class="navbar" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <div id="header-logo">
                     <h1>
                        <a class="navbar-brand" href="/index.php">上网自助服务</a>
                    </h1>
                    <h2>广东环境保护工程职业学院</h2>
                </div>


                <div id="topnav">
                  <ul>
                    <li><a href="notices.php">使用需知</a><span>Notices</span></li>
                    <li><a href="index.php">首页</a><span>Home</span></li>
                  </ul>
                </div>
              </div>
            </div>
    </div>

<div class="custom_container" id="page">



<?php if (isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
		'links' => $this->breadcrumbs,
	));?><!-- breadcrumbs -->
<?php endif?>

<?php echo $content;?>
<div class="clear"></div>



</div><!-- page -->



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
		<a style="clear:both;float:left;color:#333;">管理员入口</a>
	</div>

</div>
</body>
</html>
