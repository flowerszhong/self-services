<?php
/* @var $this AuditController */
/* @var $model Audit */

$this->breadcrumbs = array(
	'Audits' => array('index'),
	'Manage',
);

$this->menu = array(
	array('label' => 'List Audit', 'url' => array('index')),
	array('label' => 'Create Audit', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#audit-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<h1>Manage Audits</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button'));?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search', array(
	'model' => $model,
));?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'           => 'audit-grid',
	'dataProvider' => $model->search(),
	'filter'       => $model,
	'columns'      => array(
		// 'id',
		'filename',
		'student_id',
		'user_name',
		'fee',
		'comment',
		'student_id_msg',
		'student_id_ok',
		'user_name_msg',
		'user_name_ok',
		// 'fee_msg',
		// 'fee_ok',
		'comment_msg',
		'comment_ok',
		array(
			'class' => 'CButtonColumn',
		),
	),
));?>
