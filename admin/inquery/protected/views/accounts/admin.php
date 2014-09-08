<?php
/* @var $this AccountsController */
/* @var $model Accounts */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#accounts-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php echo CHtml::link('点击展开高级搜索面板', '#', array('class' => 'search-button btn btn-success'));?>
<a class="btn btn-danger" href="../net-accounts.php" style="margin-left:10px;">
返回上网账号统计页
</a>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search', array(
		'model' => $model,
	));?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'           => 'accounts-grid',
		'dataProvider' => $model->search(),
		'filter'       => $model,
		'columns'      => array(
			// 'id',
			'net_id',
			'net_pwd',
			'student_id',
			'user_name',
			'grade',
			// 'user_id',
			'used',
			'available',
			// 'import_date',
			'start_date',
			'end_date',
			array(
				'class'    => 'CButtonColumn',
				'template' => '{view} {update}',
			),
		),
	));?>
