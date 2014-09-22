<?php
/* @var $this AuditController */
/* @var $model Audit */

$this->breadcrumbs=array(
	'Audits'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Audit', 'url'=>array('index')),
	array('label'=>'Create Audit', 'url'=>array('create')),
	array('label'=>'Update Audit', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Audit', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Audit', 'url'=>array('admin')),
);
?>

<h1>View Audit #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'filename',
		'student_id',
		'user_name',
		'fee',
		'comment',
		'student_id_msg',
		'student_id_ok',
		'user_name_msg',
		'user_name_ok',
		'fee_msg',
		'fee_ok',
		'comment_msg',
		'comment_ok',
	),
)); ?>
