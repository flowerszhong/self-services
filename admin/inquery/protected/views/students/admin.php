<?php
/* @var $this StudentsController */
/* @var $model Students */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#students-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php echo CHtml::link('高级搜索', '#', array('class' => 'btn btn-primary search-button'));?>
<a class="btn btn-success" href="../admin.php" style="margin-left:10px;">
返回基础查询
</a>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search', array(
		'model' => $model,
	));?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'           => 'students-grid',
		'dataProvider' => $model->search(),
		'filter'       => $model,
		'columns'      => array(
			// 'id',
			'student_id',
			'user_name',
			// 'user_email',
			// 'pwd',
			// 'md5_id',

			// 'tel',
			// 'qq',
			'department',
			'major',
			'sub_major',
			'grade',
			'class',
			// 'log_ip',
			'approved',
			// 'reg_date',
			// 'activation_code',
			// 'banned',
			// 'ckey',
			// 'ctime',
			'net_id',
			'net_pwd',
			'start_date',
			'expire_date',

			array(
				'class'    => 'CButtonColumn',
				'template' => '{view} {update} {delete}',
			),
		),
	));?>
